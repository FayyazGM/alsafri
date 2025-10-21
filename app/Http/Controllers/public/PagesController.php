<?php

namespace App\Http\Controllers\public;

use App\Helpers\WhatsappHelper;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventAttendee;
use App\Models\EventGallery;
use App\Models\ExhibitorMedia;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class PagesController extends Controller
{

    private function generateUniqueCode($prefix = 'QRC-', $length = 16)
    {
        $randomString = strtoupper(bin2hex(random_bytes(($length - strlen($prefix)) / 2)));
        return $prefix . $randomString;
    }
    public function home()
    {
        return view('public.index');
    }

    public function event_detail($slug)
    {
        $event = Event::with(['sliderImages', 'lineups' => function($query) {
            $query->orderBy('sort', 'asc');
        }, 'agendas' => function($query) {
            $query->orderBy('sort', 'asc');
        }, 'faqs', 'exhibitors' => function($query) {
            $query->with('country');
        }])->where('slug', $slug)->first();
        
        // Get staff members from exhibitors linked to this event
        $exhibitorIds = $event->exhibitors->pluck('id');
        $staff = Staff::whereIn('exhibitor_id', $exhibitorIds)
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();
        
        // Get exhibitors linked to this event
        $exhibitors = $event->exhibitors;
        
        return view('public.event-detail', compact('event', 'staff', 'exhibitors'));
    }

    public function exhibitor_detail($id)
    {
        $exhibitor = \App\Models\Admin::with(['country', 'events' => function($query) {
            $query->where('events.is_active', true)->orderBy('start_time', 'desc');
        }])->where('id', $id)->where('user_type', 'exhibitor')->firstOrFail();
        
        // Get staff members for this exhibitor
        $staff = Staff::where('exhibitor_id', $exhibitor->id)
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();
        
        // Get media uploaded by this exhibitor - distinct by title
        $media = \App\Models\ExhibitorMedia::where('exhibitor_id', $exhibitor->id)
            ->where('is_active', true)
            ->with('event')
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('title');
        
        // Group media by type
        $videos = $media->where('media_type', 'video');
        $brochures = $media->where('media_type', 'brochure');
        $files = $media->where('media_type', 'file');
        
        return view('public.exhibitor-detail', compact('exhibitor', 'staff', 'media', 'videos', 'brochures', 'files'));
    }

    public function event_registration(Request $request)
    {
        // Validate the request data
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $event = Event::find($request->event_id);
        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found'
            ]);
        }
        $checkAttendee = EventAttendee::where('event_id', $event->id)
            ->where('email', $request->email)
            ->first();
        if ($checkAttendee) {
            return response()->json([
                'success' => false,
                'message' => 'You have already registered for this event.'
            ]);
        }
        $checkAttendee = EventAttendee::where('event_id', $event->id)
            ->where('phone_number', $this->formatPhoneNumberWithCountryCode($request->phone_number))
            ->first();
        if ($checkAttendee) {
            return response()->json([
                'success' => false,
                'message' => 'You have already registered for this event.'
            ]);
        }
        // Get all form fields from the event
        $formFields = json_decode($event->registration_form, true);
        // Create an array to store other fields
        $otherFields = [];
        // Loop through form fields and collect all fields except name and email
        foreach ($formFields as $field) {
            $fieldName = strtolower(str_replace(' ', '_', $field['label']));
            if ($fieldName !== 'name' && $fieldName !== 'email') {
                $otherFields[$fieldName] = $request->input($fieldName);
            }
        }
        $uniqueCode = $this->generateUniqueCode();
        $qrCodeLink = url("qr/{$uniqueCode}");
        $qrCodeImage = QrCode::format('png')
            ->size(300)
            ->margin(1)
            ->generate($qrCodeLink);
        $fileName = time() . '_' . $uniqueCode . '.png';
        $filePath = "public/qrcodes/{$fileName}";
        Storage::put($filePath, $qrCodeImage);
        $Image = 'storage/qrcodes/' . $fileName;

        // Generate PDF
        $pdf = PDF::loadView('public.event-ticket-pdf', [
                'event' => $event,
                'formData' => array_merge(['name' => $request->name, 'email' => $request->email], $otherFields),
                'qrCodeFileName' => $fileName,
                'uniqueCode' => $uniqueCode
            ])->setPaper('a4', 'portrait')
            ->setOption([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'defaultFont' => 'dejavu sans'
            ]);

        // Save PDF to storage
        $pdfFileName = 'tickets/' . time() . '_' . $uniqueCode . '.pdf';
        Storage::put('public/' . $pdfFileName, $pdf->output());

        // Check if auto-approval is enabled for this event
        $isAutoApproved = $event->auto_approval;
        
        // Create attendee record
        $attendee = EventAttendee::create([
            'event_id' => $event->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $this->formatPhoneNumberWithCountryCode($request->phone_number),
            'other_fields' => json_encode($otherFields),
            'qr_code_path' => $Image,
            'qr_code' => $uniqueCode,
            'ticket_pdf' => 'storage/' . $pdfFileName,
            'is_approved' => $isAutoApproved ? 1 : 0,
            'auto_approved' => $isAutoApproved
        ]);

        if ($isAutoApproved) {
            // Auto-approval is enabled - send approval email with ticket
            Mail::send('emails.public.event-ticket', [
                'event' => $event,
                'formData' => array_merge(['name' => $request->name, 'email' => $request->email], $otherFields),
                'uniqueCode' => $uniqueCode,
                'universities' => [],
                'timeslot_from' => null,
                'timeslot_to' => null,
            ], function ($message) use ($request, $attendee) {
                $relativePath = str_replace('storage/', '', $attendee->ticket_pdf);
                $filePath = storage_path('app/public/' . $relativePath);
                
                if (file_exists($filePath)) {
                    $message->to($request->email)
                        ->subject('Your Event Ticket - Education Ireland Online')
                        ->attach($filePath, [
                            'as' => 'event-ticket.pdf',
                            'mime' => 'application/pdf',
                        ]);
                } else {
                    $message->to($request->email)
                        ->subject('Your Event Ticket - Education Ireland Online');
                }
            });

            // Send WhatsApp approval message
            if($request['phone_number']){
                $to_phone_number = $this->formatPhoneNumberWithCountryCode($request['phone_number']);
                $templateName = 'eventapproval';
                $whatsappResponse = WhatsappHelper::sendWhatsappTemplateMessage($to_phone_number , $templateName);
            }

            return response()->json([
                'success' => true,
                'message' => 'Registration successful! Your ticket has been sent to your email.'
            ]);
        } else {
            // Auto-approval is disabled - send registration confirmation email (no ticket attached)
            Mail::send('emails.public.event-registration', [
                'event' => $event,
                'formData' => array_merge(['name' => $request->name, 'email' => $request->email], $otherFields),
            ], function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Event Registration Confirmation - IEO');
            });

            // Send WhatsApp notification
            if($request['phone_number']){
                $to_phone_number = $this->formatPhoneNumberWithCountryCode($request['phone_number']);
                $templateName = 'onregistrationevent';
                $whatsappResponse = WhatsappHelper::sendWhatsappTemplateMessage($to_phone_number , $templateName);
            }

            return response()->json([
                'success' => true,
                'message' => 'We have received your request please check your email.'
            ]);
        }
    }

    public function events(Request $request)
    {
        $query = Event::where('is_active', true)
            ->where(function($q) {
                $q->whereNull('end_time')
                  ->orWhere('end_time', '>=', now());
            }); // Exclude completed events

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%')
                  ->orWhere('organized_by', 'like', '%' . $search . '%');
            });
        }

        // City filter
        if ($request->filled('city')) {
            $query->where('city_id', $request->city);
        }

        // Event type filter
        if ($request->filled('event_type') && in_array($request->event_type, ['physical', 'virtual'])) {
            $query->where('event_type', $request->event_type);
        }

        // Date range filter
        if ($request->filled('date_filter')) {
            $now = now();
            switch ($request->date_filter) {
                case 'upcoming':
                    $query->where('start_time', '>', $now);
                    break;
                case 'ongoing':
                    $query->where('start_time', '<=', $now)
                          ->where(function($q) use ($now) {
                              $q->whereNull('end_time')
                                ->orWhere('end_time', '>=', $now);
                          });
                    break;
                case 'completed':
                    $query->where('end_time', '<', $now);
                    break;
                case 'this_week':
                    $query->whereBetween('start_time', [$now->startOfWeek(), $now->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereBetween('start_time', [$now->startOfMonth(), $now->endOfMonth()]);
                    break;
            }
        }

        // Sort order
        $sortBy = $request->get('sort', 'start_time');
        $sortOrder = $request->get('order', 'asc');
        
        if (in_array($sortBy, ['name', 'start_time', 'location', 'organized_by'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('start_time', 'asc');
        }

        $events = $query->paginate(12)->withQueryString();

        // Get unique organizers for filter dropdown (exclude completed events)
        $organizers = Event::where('is_active', true)
            ->where(function($q) {
                $q->whereNull('end_time')
                  ->orWhere('end_time', '>=', now());
            })
            ->whereNotNull('organized_by')
            ->where('organized_by', '!=', '')
            ->distinct()
            ->pluck('organized_by')
            ->filter()
            ->sort()
            ->values();

        // Get cities for filter dropdown
        $cities = \App\Models\City::orderBy('name', 'asc')->get();

        return view('public.events', compact('events', 'organizers', 'cities'));
    }

    public function previous_events(Request $request)
    {
        $query = Event::where('is_active', true)
            ->where('end_time', '<', now()); // Only completed events

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%')
                  ->orWhere('organized_by', 'like', '%' . $search . '%');
            });
        }

        // City filter
        if ($request->filled('city')) {
            $query->where('city_id', $request->city);
        }

        // Event type filter
        if ($request->filled('event_type') && in_array($request->event_type, ['physical', 'virtual'])) {
            $query->where('event_type', $request->event_type);
        }

        // Sort order (default to most recent first for previous events)
        $sortBy = $request->get('sort', 'start_time');
        $sortOrder = $request->get('order', 'desc');
        
        if (in_array($sortBy, ['name', 'start_time', 'location', 'organized_by'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('start_time', 'desc');
        }

        $events = $query->paginate(12)->withQueryString();

        // Get unique organizers for filter dropdown (from previous events only)
        $organizers = Event::where('is_active', true)
            ->where('end_time', '<', now())
            ->whereNotNull('organized_by')
            ->where('organized_by', '!=', '')
            ->distinct()
            ->pluck('organized_by')
            ->filter()
            ->sort()
            ->values();

        // Get cities for filter dropdown
        $cities = \App\Models\City::orderBy('name', 'asc')->get();

        return view('public.previous-events', compact('events', 'organizers', 'cities'));
    }

    public function city_events(Request $request, $cityId)
    {
        // Get the city
        $city = \App\Models\City::findOrFail($cityId);
        
        $query = Event::where('is_active', true)
            ->where('city_id', $cityId);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%')
                  ->orWhere('organized_by', 'like', '%' . $search . '%');
            });
        }

        // Event type filter
        if ($request->filled('event_type') && in_array($request->event_type, ['physical', 'virtual'])) {
            $query->where('event_type', $request->event_type);
        }

        // Date range filter
        if ($request->filled('date_filter')) {
            $now = now();
            switch ($request->date_filter) {
                case 'upcoming':
                    $query->where('start_time', '>', $now);
                    break;
                case 'ongoing':
                    $query->where('start_time', '<=', $now)
                          ->where(function($q) use ($now) {
                              $q->whereNull('end_time')
                                ->orWhere('end_time', '>=', $now);
                          });
                    break;
                case 'completed':
                    $query->where('end_time', '<', $now);
                    break;
                case 'this_week':
                    $query->whereBetween('start_time', [$now->startOfWeek(), $now->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereBetween('start_time', [$now->startOfMonth(), $now->endOfMonth()]);
                    break;
            }
        }

        // Sort order
        $sortBy = $request->get('sort', 'start_time');
        $sortOrder = $request->get('order', 'asc');
        
        if (in_array($sortBy, ['name', 'start_time', 'location', 'organized_by'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('start_time', 'asc');
        }

        $events = $query->paginate(12)->withQueryString();

        // Get unique organizers for filter dropdown (from this city's events only)
        $organizers = Event::where('is_active', true)
            ->where('city_id', $cityId)
            ->whereNotNull('organized_by')
            ->where('organized_by', '!=', '')
            ->distinct()
            ->pluck('organized_by')
            ->filter()
            ->sort()
            ->values();

        // Get all cities for filter dropdown
        $cities = \App\Models\City::orderBy('name', 'asc')->get();

        return view('public.city-events', compact('events', 'city', 'organizers', 'cities'));
    }

    public function gallery()
    {
        // Get event gallery items (always show, regardless of event status)
        $eventGallery = EventGallery::query()
            ->get()
            ->map(function ($item) {
                return [
                    'id' => 'event_' . $item->id,
                    'type' => 'event_gallery',
                    'attachment' => $item->attachment,
                    'attachment_type' => $item->attachment_type,
                    'event_name' => $item->event->name,
                    'created_at' => $item->created_at,
                ];
            });

        // Get exhibitor videos (only videos, not brochures or files)
        $exhibitorVideos = ExhibitorMedia::query()
            ->where('media_type', 'video')
            ->where('is_active', true)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => 'exhibitor_' . $item->id,
                    'type' => 'exhibitor_media',
                    'attachment' => $item->file_path,
                    'attachment_type' => 'video',
                    'event_name' => $item->event->name,
                    'created_at' => $item->created_at,
                ];
            });

        // Combine and sort by creation date
        $allGallery = $eventGallery->concat($exhibitorVideos)
            ->sortByDesc('created_at')
            ->values();

        // Manual pagination
        $perPage = 12;
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $items = $allGallery->slice($offset, $perPage);
        
        // Create paginator manually
        $gallery = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $allGallery->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'pageName' => 'page',
            ]
        );

        return view('public.gallery', compact('gallery'));
    }

    public function faq()
    {
        return view('public.faq');
    }

    private function formatPhoneNumberWithCountryCode($phoneNumber)
    {
        // Remove any spaces, dashes, or other non-numeric characters (including +)
        $cleanPhone = preg_replace('/[^\d]/', '', $phoneNumber);
        
        // If phone number already starts with country code (92xxxxxxxxxx)
        if (strlen($cleanPhone) >= 12 && substr($cleanPhone, 0, 2) === '92') {
            return $cleanPhone;
        }
        
        // Check if phone number contains 92 but doesn't start with it
        // This handles cases like: 009233012345678, 00923301234567, etc.
        if (preg_match('/^0*92(\d{10})$/', $cleanPhone, $matches)) {
            return '92' . $matches[1];
        }
        
        // If phone number starts with 0 (local format), remove 0 and add country code
        if (substr($cleanPhone, 0, 1) === '0') {
            return '92' . substr($cleanPhone, 1);
        }
        
        // If it's a 10-digit number (typical Pakistani mobile without country code)
        if (preg_match('/^3\d{9}$/', $cleanPhone)) {
            return '92' . $cleanPhone;
        }
        
        // If phone number doesn't match any pattern above, assume it's local and add country code
        return '92' . $cleanPhone;
    }
}