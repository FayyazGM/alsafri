<?php

namespace App\Http\Controllers\admin;

use App\Helpers\WhatsappHelper;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventAttendee;
use App\Models\EventGallery;
use App\Models\Admin;
use App\Models\Appointment;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

class EventsController extends Controller
{
    public function view(Request $request)
    {
        $events = Event::query();
        $filter = null;

        if ($request->filled('filter')) {
            $filter = $request->filter;
            $events = $events->where(function($query) use ($filter) {
                $query->where('name', 'like', '%' . $filter . '%')
                      ->orWhere('description', 'like', '%' . $filter . '%');
            });
        }


        $data['filter'] = $filter;
        // Get exhibitors for the forms
        $exhibitors = Admin::where('user_type', 'exhibitor')->orderBy('name')->get();
        // Get cities for the forms
        $cities = City::orderBy('province')->orderBy('name')->get();

        // Sort events: completed events at the end, rest sorted by latest upcoming first
        $data['events'] = $events->with('exhibitors')
            ->orderByRaw("CASE WHEN end_time < NOW() THEN 1 ELSE 0 END")
            ->orderBy('start_time', 'asc')
            ->paginate(25);
        $data['exhibitors'] = $exhibitors;
        $data['cities'] = $cities;
        return view('admin.manage-events', $data);
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'google_map_iframe' => 'nullable|string',
            'is_active' => 'boolean',
            'auto_approval' => 'boolean',
            'location' => 'nullable|string',
            'organized_by' => 'nullable|string',
            'city_id' => 'required|exists:cities,id',
            'slider_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'lineups.*.name' => 'nullable|string|max:255',
            'lineups.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'agenda.*.start_time' => 'nullable|string',
            'agenda.*.end_time' => 'nullable|string',
            'agenda.*.title' => 'nullable|string|max:255',
            'agenda.*.username' => 'nullable|string|max:255',
            'agenda.*.user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'agenda.*.description' => 'nullable|string',
            'agenda.*.sort' => 'nullable|integer|min:1',
            'faqs.*.question' => 'nullable|string|max:255',
            'faqs.*.answer' => 'nullable|string',
            'event_type' => 'required|string|in:physical,virtual',
            'zoom_link' => 'nullable|required_if:event_type,virtual|url',
            'qrcode_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048|required_if:event_type,virtual',
        ]);
        $sliderImagePath = null;
        if ($request->hasFile('slider_image')) {
            $sliderImagePath = $request->file('slider_image')->store('events/slider', 'public');
        }

        $mainImagePath = null;
        if ($request->hasFile('main_image')) {
            $mainImagePath = $request->file('main_image')->store('events/main', 'public');
        }
        $qrcodeImagePath = null;
        if ($request->hasFile('qrcode_image')) {
            $qrcodeImagePath = $request->file('qrcode_image')->store('events/qrcodes', 'public');
        }
        DB::beginTransaction();
        try {
            $mainImagePath = null;
            if ($request->hasFile('main_image')) {
                $mainImagePath = $request->file('main_image')->store('events/main', 'public');
            }
            $defaultRegistrationForm = [
                [ 'label' => 'name', 'type' => 'text', 'required' => true ],
                [ 'label' => 'email', 'type' => 'email', 'required' => true ],
                [ 'label' => 'Phone Number', 'type' => 'text', 'required' => true ],
                [ 'label' => 'Cnic #', 'type' => 'text', 'required' => true ],
            ];
            $event = Event::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'main_image' => $mainImagePath,
                'google_map_iframe' => $request->google_map_iframe,
                'registration_form' => json_encode($defaultRegistrationForm),
                'is_active' => $request->boolean('is_active', true),
                'auto_approval' => $request->boolean('auto_approval', false),
                'location' => $request->location,
                'organized_by' => $request->organized_by,
                'city_id' => $request->city_id,
                'slider_image' => $sliderImagePath,
                'main_image' => $mainImagePath,
                'event_type' => $request->event_type ?? 'physical',
                'zoom_link' => $request->event_type === 'virtual' ? $request->zoom_link : null,
                'qrcode_image' => $request->event_type === 'virtual' ? $qrcodeImagePath : null,
            ]);
            // Slider Images
            if ($request->hasFile('slider_images')) {
                foreach ($request->file('slider_images') as $index => $file) {
                    $path = $file->store('events/slider', 'public');
                    $event->sliderImages()->create([
                        'image_path' => $path,
                        'order' => $index,
                    ]);
                }
            }
            // Lineups
            if ($request->lineups) {
                foreach ($request->lineups as $index => $lineup) {
                    $imagePath = null;
                    if (isset($lineup['image']) && $lineup['image']) {
                        $imagePath = $lineup['image']->store('events/lineups', 'public');
                    }
                    $event->lineups()->create([
                        'name' => $lineup['name'] ?? '',
                        'image_path' => $imagePath,
                        'order' => $index,
                        'sort' => $lineup['sort'] ?? ($index + 1),
                    ]);
                }
            }
            // Agenda
            if ($request->agenda) {
                foreach ($request->agenda as $index => $agenda) {
                    $userImagePath = null;
                    if (isset($agenda['user_image']) && $agenda['user_image']) {
                        $userImagePath = $agenda['user_image']->store('events/agenda', 'public');
                    }
                    $event->agendas()->create([
                        'start_time' => $agenda['start_time'] ?? '',
                        'end_time' => $agenda['end_time'] ?? '',
                        'title' => $agenda['title'] ?? '',
                        'username' => $agenda['username'] ?? '',
                        'user_image' => $userImagePath,
                        'description' => $agenda['description'] ?? '',
                        'order' => $index,
                        'sort' => $agenda['sort'] ?? ($index + 1),
                    ]);
                }
            }
            // FAQs
            if ($request->faqs) {
                foreach ($request->faqs as $index => $faq) {
                    $event->faqs()->create([
                        'question' => $faq['question'] ?? '',
                        'answer' => $faq['answer'] ?? '',
                        'order' => $index,
                    ]);
                }
            }
            
            
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Event added successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
{
    $request->validate([
        'id' => 'required|exists:events,id',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_time' => 'required|date',
        'end_time' => 'nullable|date|after_or_equal:start_time',
        'slider_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'slider_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'google_map_iframe' => 'nullable|string',
        'is_active' => 'boolean',
        'auto_approval' => 'boolean',
        'location' => 'nullable|string',
        'organized_by' => 'nullable|string',
        'city_id' => 'required|exists:cities,id',
        'lineups.*.name' => 'nullable|string|max:255',
        'lineups.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'agenda.*.start_time' => 'nullable|string',
        'agenda.*.end_time' => 'nullable|string',
        'agenda.*.title' => 'nullable|string|max:255',
        'agenda.*.username' => 'nullable|string|max:255',
        'agenda.*.user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'agenda.*.description' => 'nullable|string',
        'agenda.*.sort' => 'nullable|integer|min:1',
        'faqs.*.question' => 'nullable|string|max:255',
        'faqs.*.answer' => 'nullable|string',
        'event_type' => 'required|string|in:physical,virtual',
        'zoom_link' => 'nullable|required_if:event_type,virtual|url',
        'qrcode_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    DB::beginTransaction();
    
    try {
        $event = Event::findOrFail($request->id);
        
        // Prepare basic update data
        $updateData = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_active' => $request->boolean('is_active'),
            'auto_approval' => $request->boolean('auto_approval'),
            'location' => $request->location,
            'organized_by' => $request->organized_by,
            'city_id' => $request->city_id,
            'event_type' => $request->event_type ?? 'physical',
            'zoom_link' => $request->event_type === 'virtual' ? $request->zoom_link : null,
        ];
        // Handle QR code image - only update if new file is uploaded
        if ($request->hasFile('qrcode_image')) {
            $newQrcodeImagePath = $request->file('qrcode_image')->store('events/qrcodes', 'public');
            if ($newQrcodeImagePath) {
                if ($event->qrcode_image && Storage::disk('public')->exists($event->qrcode_image)) {
                    Storage::disk('public')->delete($event->qrcode_image);
                }
                $updateData['qrcode_image'] = $newQrcodeImagePath;
            }
        } else if ($request->event_type === 'virtual') {
            // If not uploading a new image, keep the old one for virtual events
            $updateData['qrcode_image'] = $event->qrcode_image;
        } else {
            // If switching to physical, remove the qrcode_image
            $updateData['qrcode_image'] = null;
        }

        // Handle Google Map iframe - only update if provided and not empty
        if ($request->filled('google_map_iframe')) {
            $updateData['google_map_iframe'] = $request->google_map_iframe;
        }

        // Handle main image - only update if new file is uploaded
        if ($request->hasFile('main_image')) {
            // Delete old image only if upload is successful
            $newMainImagePath = $request->file('main_image')->store('events/main', 'public');
            if ($newMainImagePath) {
                // Delete old image after successful upload
                if ($event->main_image && Storage::disk('public')->exists($event->main_image)) {
                    Storage::disk('public')->delete($event->main_image);
                }
                $updateData['main_image'] = $newMainImagePath;
            }
        }

        // Handle slider image - only update if new file is uploaded
        if ($request->hasFile('slider_image')) {
            $newSliderImagePath = $request->file('slider_image')->store('events/slider_image', 'public');
            if ($newSliderImagePath) {
                // Delete old image after successful upload
                if ($event->slider_image && Storage::disk('public')->exists($event->slider_image)) {
                    Storage::disk('public')->delete($event->slider_image);
                }
                $updateData['slider_image'] = $newSliderImagePath;
            }
        }

        // Update the event with basic data and any new images
        $event->update($updateData);

        // Handle slider images - only update if new files are provided
        if ($request->hasFile('slider_images')) {
            // Store old image paths before deletion
            $oldSliderImages = $event->sliderImages->pluck('image_path')->toArray();
            
            // Delete old slider images records
            $event->sliderImages()->delete();
            
            $newSliderImages = [];
            foreach ($request->file('slider_images') as $index => $file) {
                $path = $file->store('events/slider', 'public');
                if ($path) {
                    $newSliderImages[] = [
                        'image_path' => $path,
                        'order' => $index,
                    ];
                }
            }
            
            // Create new slider images
            if (!empty($newSliderImages)) {
                $event->sliderImages()->createMany($newSliderImages);
                
                // Delete old files only after successful creation of new records
                foreach ($oldSliderImages as $oldImage) {
                    if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }
        }

        // Handle lineups - only update if lineups data is provided
        if ($request->has('lineups') && is_array($request->lineups)) {
            // Get existing lineups with their images
            $existingLineups = $event->lineups->keyBy('order');
            $oldLineupImages = [];
            
            // Delete old lineups
            $event->lineups()->delete();
            
            $newLineups = [];
            foreach ($request->lineups as $index => $lineup) {
                $imagePath = null;
                
                // Check if new image is uploaded
                if (isset($lineup['image']) && $lineup['image']) {
                    $imagePath = $lineup['image']->store('events/lineups', 'public');
                    // Mark old image for deletion if new one is uploaded
                    if (isset($existingLineups[$index]) && $existingLineups[$index]->image_path) {
                        $oldLineupImages[] = $existingLineups[$index]->image_path;
                    }
                } else {
                    // Keep existing image if no new image is uploaded
                    if (isset($existingLineups[$index]) && $existingLineups[$index]->image_path) {
                        $imagePath = $existingLineups[$index]->image_path;
                    }
                }
                
                $newLineups[] = [
                    'name' => $lineup['name'] ?? '',
                    'image_path' => $imagePath,
                    'order' => $index,
                    'sort' => $lineup['sort'] ?? ($index + 1),
                ];
            }
            
            if (!empty($newLineups)) {
                $event->lineups()->createMany($newLineups);
                
                // Delete only the old images that were replaced with new ones
                foreach ($oldLineupImages as $oldImage) {
                    if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }
        }

        // Handle agenda - only update if agenda data is provided
        if ($request->has('agenda') && is_array($request->agenda)) {
            // Get existing agendas with their images
            $existingAgendas = $event->agendas->keyBy('order');
            $oldAgendaImages = [];
            
            // Delete old agendas
            $event->agendas()->delete();
            
            $newAgendas = [];
            foreach ($request->agenda as $index => $agenda) {
                $userImagePath = null;
                
                // Check if new image is uploaded
                if (isset($agenda['user_image']) && $agenda['user_image']) {
                    $userImagePath = $agenda['user_image']->store('events/agenda', 'public');
                    // Mark old image for deletion if new one is uploaded
                    if (isset($existingAgendas[$index]) && $existingAgendas[$index]->user_image) {
                        $oldAgendaImages[] = $existingAgendas[$index]->user_image;
                    }
                } else {
                    // Keep existing image if no new image is uploaded
                    if (isset($existingAgendas[$index]) && $existingAgendas[$index]->user_image) {
                        $userImagePath = $existingAgendas[$index]->user_image;
                    }
                }
                
                $newAgendas[] = [
                    'start_time' => $agenda['start_time'] ?? '',
                    'end_time' => $agenda['end_time'] ?? '',
                    'title' => $agenda['title'] ?? '',
                    'username' => $agenda['username'] ?? '',
                    'user_image' => $userImagePath,
                    'description' => $agenda['description'] ?? '',
                    'order' => $index,
                    'sort' => $agenda['sort'] ?? ($index + 1),
                ];
            }
            
            if (!empty($newAgendas)) {
                $event->agendas()->createMany($newAgendas);
                
                // Delete only the old images that were replaced with new ones
                foreach ($oldAgendaImages as $oldImage) {
                    if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }
        }

        // Handle FAQs - only update if FAQ data is provided
        if ($request->has('faqs') && is_array($request->faqs)) {
            // Delete old FAQs
            $event->faqs()->delete();
            
            $newFaqs = [];
            foreach ($request->faqs as $index => $faq) {
                if (!empty($faq['question']) || !empty($faq['answer'])) {
                    $newFaqs[] = [
                        'question' => $faq['question'] ?? '',
                        'answer' => $faq['answer'] ?? '',
                        'order' => $index,
                    ];
                }
            }
            
            if (!empty($newFaqs)) {
                $event->faqs()->createMany($newFaqs);
            }
        }
        

        DB::commit();
        return response()->json(['success' => true, 'message' => 'Event updated successfully.']);
        
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
    }
}

    public function registration_form($id)
    {
        $event = Event::findOrFail($id);
        $registrationForm = json_decode($event->registration_form, true) ?? [];
        
        // Sort fields based on sort_order within each field
        if (!empty($registrationForm)) {
            usort($registrationForm, function($a, $b) {
                $sortA = isset($a['sort_order']) ? $a['sort_order'] : 0;
                $sortB = isset($b['sort_order']) ? $b['sort_order'] : 0;
                return $sortA - $sortB;
            });
        }
        
        return view('admin.registration-form', compact('event', 'registrationForm'));
    }

    public function add_registration_field(Request $request)
    {
        $validationRules = [
            'event_id' => 'required|exists:events,id',
            'label' => 'required|string|max:255',
            'type' => 'required|string|in:text,email,number,tel,textarea,select,checkbox,radio',
            'required' => 'boolean'
        ];

        // Only validate options if field type is select
        if ($request->type === 'select') {
            $validationRules['options'] = 'required|array|min:1';
            $validationRules['options.*'] = 'required|string|max:255';
        }

        $request->validate($validationRules);

        $event = Event::findOrFail($request->event_id);
        $registrationForm = json_decode($event->registration_form, true) ?? [];

        $field = [
            'label' => $request->label,
            'type' => $request->type,
            'required' => $request->boolean('required'),
            'sort_order' => count($registrationForm)
        ];

        if ($request->type === 'select') {
            $field['options'] = $request->options ?? [];
        }

        $registrationForm[] = $field;
        
        $event->update([
            'registration_form' => json_encode($registrationForm)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Field added successfully'
        ]);
    }

    public function delete_registration_field(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'index' => 'required|integer|min:0'
        ]);

        $event = Event::findOrFail($request->event_id);
        $registrationForm = json_decode($event->registration_form, true) ?? [];

        // Check if index exists
        if (!isset($registrationForm[$request->index])) {
            return response()->json([
                'success' => false,
                'message' => 'Field not found'
            ], 404);
        }

        // Remove field at specified index
        array_splice($registrationForm, $request->index, 1);
        
        // Reindex sort_order values for remaining fields
        foreach ($registrationForm as $newIndex => $field) {
            $registrationForm[$newIndex]['sort_order'] = $newIndex;
        }

        // Update event with modified registration form
        $event->update([
            'registration_form' => json_encode($registrationForm)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Field deleted successfully'
        ]);
    }

    public function edit_registration_field(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'index' => 'required|integer|min:0',
            'required' => 'boolean',
            'sort_order' => 'required|integer|min:0'
        ]);

        $event = Event::findOrFail($request->event_id);
        $registrationForm = json_decode($event->registration_form, true) ?? [];

        // Check if index exists
        if (!isset($registrationForm[$request->index])) {
            return response()->json([
                'success' => false,
                'message' => 'Field not found'
            ], 404);
        }

        // Update field properties
        $registrationForm[$request->index]['required'] = $request->boolean('required');
        $registrationForm[$request->index]['sort_order'] = $request->sort_order;

        $event->update([
            'registration_form' => json_encode($registrationForm)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Field updated successfully'
        ]);
    }

    public function update_registration_field_order(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'sort_order' => 'required|array',
            'sort_order.*' => 'integer|min:0'
        ]);

        $event = Event::findOrFail($request->event_id);
        $registrationForm = json_decode($event->registration_form, true) ?? [];
        
        // Update sort order for each field
        foreach ($request->sort_order as $index => $order) {
            if (isset($registrationForm[$index])) {
                $registrationForm[$index]['sort_order'] = $order;
            }
        }
        
        // Update the event with modified registration form
        $event->update([
            'registration_form' => json_encode($registrationForm)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Field order updated successfully'
        ]);
    }

    public function eventAttendees($id)
    {
        $event = Event::findOrFail($id);
        $filter = request('filter', '');
        
        $query = EventAttendee::where('event_id', $id);
        
        if ($filter) {
            $query->where(function($q) use ($filter) {
                $q->where('name', 'like', "%{$filter}%")
                  ->orWhere('email', 'like', "%{$filter}%");
            });
        }
        
        $attendees = $query->orderBy('created_at', 'desc')->paginate(25);
        $universities = DB::connection('mysql2')->table('tbl_universities')->orderBy('name' , 'ASC')->get();
        return view('admin.event-attendees', compact('event', 'attendees', 'filter' , 'universities'));
    }

    public function getAllAttendeeIds($id)
    {
        $event = Event::findOrFail($id);
        $filter = request('filter', '');
        
        $query = EventAttendee::where('event_id', $id)->where('is_approved', 0); // Only pending attendees
        
        if ($filter) {
            $query->where(function($q) use ($filter) {
                $q->where('name', 'like', "%{$filter}%")
                  ->orWhere('email', 'like', "%{$filter}%");
            });
        }
        
        $attendeeIds = $query->pluck('id')->toArray();
        $totalCount = $query->count();
        
        return response()->json([
            'success' => true,
            'attendee_ids' => $attendeeIds,
            'total_count' => $totalCount
        ]);
    }

    public function markAttendeeVisited($id)
    {
        $attendee = EventAttendee::findOrFail($id);
        
        // Check if event has started
        $event = $attendee->event;
        if($event->start_time > now()){
            return response()->json([
                'success' => false,
                'message' => 'Event has not started yet. Attendance marking is only allowed after the event start time.'
            ]);
        }
        
        $attendee->update([
            'visited_at' => now(),
            'marked_by' => auth()->guard('admin')->id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Attendee marked as visited successfully.'
        ]);
    }

    public function markAttendeeNotVisited($id)
    {
        $attendee = EventAttendee::findOrFail($id);
        $attendee->update([
            'visited_at' => null,
            'marked_by' => null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Attendee marked as not visited successfully.'
        ]);
    }

    public function approveAttendee(Request $request)
    {
        // dd($request->all());
        $id = $request['attendee_id'];

        $attendee = EventAttendee::findOrFail($id);
        if ($attendee->is_approved == 1) {
            return response()->json([
                'success' => false,
                'message' => 'Attendee already approved.'
            ]);
        }
        if ($attendee->is_approved == 2) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot approve a rejected attendee.'
            ]);
        }
        $universityIds = $request['universities'];
        if($universityIds){
        $universities = DB::connection('mysql2')->table('tbl_universities')
                                                ->whereIn('id', $universityIds)
                                                ->pluck('name', 'id');
        $attendee->universities = json_encode($universities);
        }else{
            $universities = '';
        }
        
        // Save timeslot fields
        $attendee->timeslot_from = $request['timeslot_from'];
        $attendee->timeslot_to = $request['timeslot_to'];
        
        // Save remarks if provided
        if ($request->has('remarks') && !empty($request['remarks'])) {
            $attendee->remarks = $request['remarks'];
        }
        
        $attendee->is_approved = 1;
        $attendee->auto_approved = false; // Mark as manually approved
        $attendee->approved_by = auth()->guard('admin')->id();
        $attendee->approved_at = now();
        $attendee->rejected_by = null; // Clear rejection data if any
        $attendee->rejected_at = null;
        $attendee->save();
        $event = $attendee->event;
        $otherFields = json_decode($attendee->other_fields, true) ?? [];
        
        // Create appointments for exhibitors linked to universities
        if ($universityIds && count($universityIds) > 0) {
            $this->createAppointmentsFromAttendee($attendee, $event, $universities);
        }
        
        // Regenerate PDF with timeslot information
        $pdf = \PDF::loadView('public.event-ticket-pdf', [
            'event' => $event,
            'formData' => array_merge(['name' => $attendee->name, 'email' => $attendee->email], $otherFields),
            'qrCodeFileName' => basename($attendee->qr_code_path),
            'uniqueCode' => $attendee->qr_code,
            'timeslot_from' => $attendee->timeslot_from,
            'timeslot_to' => $attendee->timeslot_to,
            'universities' => $universities,
        ])->setPaper('a4', 'portrait')
        ->setOption([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'defaultFont' => 'dejavu sans'
        ]);

        // Save updated PDF
        $pdfFileName = 'tickets/' . time() . '_' . $attendee->qr_code . '.pdf';
        \Storage::put('public/' . $pdfFileName, $pdf->output());
        $attendee->ticket_pdf = 'storage/' . $pdfFileName;
        $attendee->save();

        // Send ticket email with PDF attached
        Mail::send('emails.public.event-ticket', [
            'event' => $event,
            'formData' => array_merge(['name' => $attendee->name, 'email' => $attendee->email], $otherFields),
            'uniqueCode' => $attendee->qr_code,
            'universities' => $universities,
            'timeslot_from' => $attendee->timeslot_from,
            'timeslot_to' => $attendee->timeslot_to,
        ], function ($message) use ($attendee) {
            // Clean path if it starts with 'storage/'
            $relativePath = str_replace('storage/', '', $attendee->ticket_pdf);

            $filePath = storage_path('app/public/' . $relativePath);

            if (!file_exists($filePath)) {
                \Log::error("Ticket PDF not found: " . $filePath);
                return;
            }
            // WhatssApp message send
            $templateName = 'eventapproval';
            $whatsappResponse = WhatsappHelper::sendWhatsappTemplateMessage($attendee->phone_number , $templateName);
            $message->to($attendee->email)
                ->subject('Your Event Ticket - Education Ireland Online')
                ->attach($filePath, [
                    'as' => 'event-ticket.pdf',
                    'mime' => 'application/pdf',
                ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Attendee approved and ticket sent.'
        ]);
    }

    public function rejectAttendee($id)
    {
        $attendee = EventAttendee::findOrFail($id);
        if ($attendee->is_approved == 2) {
            return response()->json([
                'success' => false,
                'message' => 'Attendee already rejected.'
            ]);
        }
        if ($attendee->is_approved == 1) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot reject an already approved attendee.'
            ]);
        }
        $attendee->is_approved = 2;
        $attendee->rejected_by = auth()->guard('admin')->id();
        $attendee->rejected_at = now();
        $attendee->approved_by = null; // Clear approval data if any
        $attendee->approved_at = null;
        $attendee->save();
        $event = $attendee->event;
        $otherFields = json_decode($attendee->other_fields, true) ?? [];
        // Send rejection email using the new Blade template
        \Mail::send('emails.public.event-rejected', [
            'event' => $event,
            'formData' => array_merge(['name' => $attendee->name, 'email' => $attendee->email], $otherFields),
        ], function ($message) use ($attendee) {
            $message->to($attendee->email)
                ->subject('Event Registration Update - Education Ireland Online');
        });
         // WhatssApp message send
        $templateName = 'event_registration_reject';
        $whatsappResponse = WhatsappHelper::sendWhatsappTemplateMessage($attendee->phone_number , $templateName);
        return response()->json([
            'success' => true,
            'message' => 'Attendee rejected and email sent.'
        ]);
    }

    public function eventGallery($id)
    {
        $event = Event::findOrFail($id);
        $galleries = EventGallery::where('event_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        return view('admin.event-gallery', compact('event', 'galleries'));
    }

    public function addGalleryImage(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'attachment' => 'required|file|mimes:jpeg,png,jpg,gif,mp4|max:10240',
        ]);

        $path = $request->file('attachment')->store('events/gallery', 'public');
        $type = $request->file('attachment')->getClientOriginalExtension() === 'mp4' ? 'video' : 'image';

        EventGallery::create([
            'event_id' => $request->event_id,
            'add_by' => auth()->guard('admin')->id(),
            'attachment' => $path,
            'attachment_type' => $type
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Gallery image/video added successfully.'
        ]);
    }

    public function deleteGalleryImage($id)
    {
        $gallery = EventGallery::findOrFail($id);
        
        // Delete the file from storage
        if (Storage::disk('public')->exists($gallery->attachment)) {
            Storage::disk('public')->delete($gallery->attachment);
        }
        
        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gallery image/video deleted successfully.'
        ]);
    }

    public function bulkDeleteGalleryImages(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:event_galleries,id'
        ]);

        $deletedCount = 0;
        $errors = [];

        foreach ($request->ids as $id) {
            try {
                $gallery = EventGallery::findOrFail($id);
                
                // Delete the file from storage
                if (Storage::disk('public')->exists($gallery->attachment)) {
                    Storage::disk('public')->delete($gallery->attachment);
                }
                
                $gallery->delete();
                $deletedCount++;
            } catch (\Exception $e) {
                $errors[] = "Failed to delete gallery item with ID {$id}: " . $e->getMessage();
            }
        }

        $message = "Successfully deleted {$deletedCount} gallery item(s).";
        if (!empty($errors)) {
            $message .= " Some items could not be deleted: " . implode(', ', $errors);
        }

        return response()->json([
            'success' => $deletedCount > 0,
            'message' => $message,
            'deleted_count' => $deletedCount,
            'errors' => $errors
        ]);
    }

    public function editData($id)
    {
        $event = Event::with(['lineups' => function($query) {
            $query->orderBy('sort', 'asc');
        }, 'agendas' => function($query) {
            $query->orderBy('sort', 'asc');
        }, 'faqs', 'sliderImages'])->findOrFail($id);
        return response()->json([
            'id' => $event->id,
            'name' => $event->name,
            'description' => $event->description,
            'start_time' => $event->start_time,
            'end_time' => $event->end_time,
            'google_map_iframe' => $event->google_map_iframe,
            'is_active' => $event->is_active,
            'auto_approval' => $event->auto_approval,
            'location' => $event->location,
            'organized_by' => $event->organized_by,
            'main_image' => $event->main_image,
            'slider_images' => $event->sliderImages,
            'lineups' => $event->lineups,
            'agendas' => $event->agendas,
            'faqs' => $event->faqs,
        ]);
    }

    public function deleteSliderImage($id)
    {
        $image = \App\Models\EventSliderImage::findOrFail($id);
        if ($image->image_path && \Storage::disk('public')->exists($image->image_path)) {
            \Storage::disk('public')->delete($image->image_path);
        }
        $image->delete();
        return response()->json(['success' => true, 'message' => 'Slider image deleted successfully.']);
    }

    public function publicEventDetail($slug)
    {
        $event = Event::with(['sliderImages', 'lineups' => function($query) {
            $query->orderBy('sort', 'asc');
        }, 'agendas' => function($query) {
            $query->orderBy('sort', 'asc');
        }, 'faqs'])->where('slug', $slug)->firstOrFail();
        return view('public.event-detail', compact('event'));
    }

    public function importAttendeesForm()
    {
        $events = Event::where('is_active', true)->orderBy('name')->get();
        return view('admin.import-attendees', compact('events'));
    }

    public function downloadAttendeesTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="attendees_template.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, ['name', 'email', 'phone_number', 'other_fields']);
            
            // Add sample data
            fputcsv($file, ['John Doe', 'john@example.com', '03012345678', '{"cnic_#":"213313","new_field":"asdasd"}']);
            // fputcsv($file, ['Jane Smith', 'jane@example.com', '03098765432', '35202-9876543-2']);
            
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function importAttendees(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $event = Event::findOrFail($request->event_id);
        $file = $request->file('file');
        
        // Read CSV file
        $handle = fopen($file->getPathname(), 'r');
        $headers = fgetcsv($handle); // Skip header row
        
        $imported = 0;
        $errors = [];
        $rowNumber = 1; // Start from 1 since we skipped header

        while (($data = fgetcsv($handle)) !== false) {
            $rowNumber++;
            
            try {
                // Validate required fields
                if (empty($data[0]) || empty($data[1])) {
                    $errors[] = "Row {$rowNumber}: Name and email are required";
                    continue;
                }

                $name = trim($data[0]);
                $email = trim($data[1]);
                $phoneNumber = isset($data[2]) ? trim($data[2]) : null;
                $otherFieldsJson = isset($data[3]) ? trim($data[3]) : null;

                // Check if attendee already exists
                $existingAttendee = EventAttendee::where('event_id', $event->id)
                    ->where(function($query) use ($email, $phoneNumber) {
                        $query->where('email', $email);
                        if ($phoneNumber) {
                            $query->orWhere('phone_number', $this->formatPhoneNumberWithCountryCode($phoneNumber));
                        }
                    })
                    ->first();

                if ($existingAttendee) {
                    $errors[] = "Row {$rowNumber}: Attendee with email '{$email}' already exists for this event";
                    continue;
                }

                // Parse other fields from JSON
                $otherFields = [];
                if ($otherFieldsJson) {
                    try {
                        $otherFields = json_decode($otherFieldsJson, true);
                        if (json_last_error() !== JSON_ERROR_NONE) {
                            $errors[] = "Row {$rowNumber}: Invalid JSON format in other_fields column";
                            continue;
                        }
                    } catch (\Exception $e) {
                        $errors[] = "Row {$rowNumber}: Error parsing other_fields JSON: " . $e->getMessage();
                        continue;
                    }
                }

                // Generate unique code and QR code
                $uniqueCode = $this->generateUniqueCode();
                $qrCodeLink = url("qr/{$uniqueCode}");
                $qrCodeImage = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
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
                    'formData' => array_merge(['name' => $name, 'email' => $email], $otherFields),
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
                    'name' => $name,
                    'email' => $email,
                    'phone_number' => $phoneNumber ? $this->formatPhoneNumberWithCountryCode($phoneNumber) : null,
                    'other_fields' => json_encode($otherFields),
                    'qr_code_path' => $Image,
                    'qr_code' => $uniqueCode,
                    'ticket_pdf' => 'storage/' . $pdfFileName,
                    'is_approved' => $isAutoApproved ? 1 : 0,
                    'auto_approved' => $isAutoApproved
                ]);

                // If auto-approval is enabled, send approval email with ticket
                if ($isAutoApproved) {
                    try {
                        Mail::send('emails.public.event-ticket', [
                            'event' => $event,
                            'formData' => array_merge(['name' => $name, 'email' => $email], $otherFields),
                            'uniqueCode' => $uniqueCode,
                            'universities' => [],
                            'timeslot_from' => null,
                            'timeslot_to' => null,
                        ], function ($message) use ($email, $attendee) {
                            $relativePath = str_replace('storage/', '', $attendee->ticket_pdf);
                            $filePath = storage_path('app/public/' . $relativePath);
                            
                            if (file_exists($filePath)) {
                                $message->to($email)
                                    ->subject('Your Event Ticket - Education Ireland Online')
                                    ->attach($filePath, [
                                        'as' => 'event-ticket.pdf',
                                        'mime' => 'application/pdf',
                                    ]);
                            } else {
                                $message->to($email)
                                    ->subject('Your Event Ticket - Education Ireland Online');
                            }
                        });

                        // Send WhatsApp approval message if phone number exists
                        if ($attendee->phone_number) {
                            $templateName = 'eventapproval';
                            WhatsappHelper::sendWhatsappTemplateMessage($attendee->phone_number, $templateName);
                        }
                    } catch (\Exception $e) {
                        // Log email sending errors but don't fail the import
                        \Log::error("Failed to send auto-approval email to {$email}: " . $e->getMessage());
                    }
                }

                $imported++;

            } catch (\Exception $e) {
                $errors[] = "Row {$rowNumber}: " . $e->getMessage();
            }
        }

        fclose($handle);

        $message = "Successfully imported {$imported} attendees.";
        if (!empty($errors)) {
            $message .= " Errors: " . implode(', ', $errors);
        }

        $response = [
            'success' => true,
            'message' => $message,
            'imported' => $imported,
            'errors' => $errors
        ];

        \Log::info('Import attendees response:', $response);

        return response()->json($response);
    }

    /**
     * Bulk approve multiple attendees
     */
    public function bulkApproveAttendees(Request $request)
    {
        $request->validate([
            'attendee_ids' => 'required|array|min:1',
            'attendee_ids.*' => 'integer|exists:event_attendees,id',
            'event_id' => 'required|integer|exists:events,id'
        ]);

        $attendeeIds = $request->attendee_ids;
        $eventId = $request->event_id;
        
        // Get the event to check if auto-approval is enabled
        $event = Event::findOrFail($eventId);
        
        // Get attendees that are pending approval
        $attendees = EventAttendee::whereIn('id', $attendeeIds)
            ->where('event_id', $eventId)
            ->where('is_approved', 0)
            ->get();

        if ($attendees->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No pending attendees found to approve.'
            ], 400);
        }

        $approvedCount = 0;
        $errors = [];

        foreach ($attendees as $attendee) {
            try {
                // Set approval status
                $attendee->is_approved = 1;
                $attendee->auto_approved = false; // Mark as manually approved
                $attendee->approved_by = auth()->guard('admin')->id();
                $attendee->approved_at = now();
                $attendee->rejected_by = null; // Clear rejection data if any
                $attendee->rejected_at = null;
                $attendee->save();

                // Send approval email with ticket
                try {
                    Mail::send('emails.public.event-ticket', [
                        'attendee' => $attendee,
                        'event' => $event,
                        'ticket_code' => $attendee->ticket_code ?? 'N/A'
                    ], function ($message) use ($attendee, $event) {
                        $message->to($attendee->email)
                            ->subject('Event Approval - ' . $event->name);

                        // Generate and attach PDF ticket
                        $pdf = Pdf::loadView('public.event-ticket-pdf', [
                            'attendee' => $attendee,
                            'event' => $event
                        ]);

                        $message->attachData($pdf->output(), 'event-ticket.pdf', [
                            'mime' => 'application/pdf',
                        ]);
                    });

                    // Send WhatsApp approval message if phone number exists
                    if ($attendee->phone_number) {
                        $templateName = 'eventapproval';
                        WhatsappHelper::sendWhatsappTemplateMessage($attendee->phone_number, $templateName);
                    }

                    $approvedCount++;
                } catch (\Exception $e) {
                    \Log::error("Failed to send approval email to {$attendee->email}: " . $e->getMessage());
                    $errors[] = "Failed to send email to {$attendee->email}";
                    // Still count as approved even if email fails
                    $approvedCount++;
                }

            } catch (\Exception $e) {
                \Log::error("Failed to approve attendee {$attendee->id}: " . $e->getMessage());
                $errors[] = "Failed to approve attendee {$attendee->name}";
            }
        }

        $message = "Successfully approved {$approvedCount} attendee(s).";
        if (!empty($errors)) {
            $message .= " Some errors occurred: " . implode(', ', $errors);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'approved_count' => $approvedCount,
            'errors' => $errors
        ]);
    }

    /**
     * Bulk reject multiple attendees
     */
    public function bulkRejectAttendees(Request $request)
    {
        $request->validate([
            'attendee_ids' => 'required|array|min:1',
            'attendee_ids.*' => 'integer|exists:event_attendees,id',
            'event_id' => 'required|integer|exists:events,id'
        ]);

        $attendeeIds = $request->attendee_ids;
        $eventId = $request->event_id;
        
        // Get attendees that are pending approval
        $attendees = EventAttendee::whereIn('id', $attendeeIds)
            ->where('event_id', $eventId)
            ->where('is_approved', 0)
            ->get();

        if ($attendees->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No pending attendees found to reject.'
            ], 400);
        }

        $rejectedCount = 0;
        $errors = [];

        foreach ($attendees as $attendee) {
            try {
                // Set rejection status
                $attendee->is_approved = 2;
                $attendee->rejected_by = auth()->guard('admin')->id();
                $attendee->rejected_at = now();
                $attendee->approved_by = null; // Clear approval data if any
                $attendee->approved_at = null;
                $attendee->save();

                $rejectedCount++;
            } catch (\Exception $e) {
                \Log::error("Failed to reject attendee {$attendee->id}: " . $e->getMessage());
                $errors[] = "Failed to reject attendee {$attendee->name}";
            }
        }

        $message = "Successfully rejected {$rejectedCount} attendee(s).";
        if (!empty($errors)) {
            $message .= " Some errors occurred: " . implode(', ', $errors);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'rejected_count' => $rejectedCount,
            'errors' => $errors
        ]);
    }

    private function generateUniqueCode($prefix = 'QRC-', $length = 16)
    {
        $randomString = strtoupper(bin2hex(random_bytes(($length - strlen($prefix)) / 2)));
        return $prefix . $randomString;
    }

    private function formatPhoneNumberWithCountryCode($phoneNumber)
    {
        // Remove any spaces, dashes, or other non-numeric characters (including +)
        $cleanPhone = preg_replace('/[^\d]/', '', $phoneNumber);
        
        // If phone number already starts with Pakistani country code (92xxxxxxxxxx)
        if (strlen($cleanPhone) >= 12 && substr($cleanPhone, 0, 2) === '92') {
            return $cleanPhone;
        }
        
        // Check if phone number contains 92 but doesn't start with it
        // This handles cases like: 009233012345678, 00923301234567, etc.
        if (preg_match('/^0*92(\d{10})$/', $cleanPhone, $matches)) {
            return '92' . $matches[1];
        }
        
        // Check if it's a Pakistani local number format
        $isPakistaniNumber = false;
        
        // If phone number starts with 0 (Pakistani local format)
        if (substr($cleanPhone, 0, 1) === '0' && strlen($cleanPhone) == 11) {
            $withoutZero = substr($cleanPhone, 1);
            // Check if it matches Pakistani mobile pattern (3xxxxxxxxx)
            if (preg_match('/^3\d{9}$/', $withoutZero)) {
                $isPakistaniNumber = true;
            }
        }
        
        // If it's a 10-digit number starting with 3 (typical Pakistani mobile without country code)
        if (preg_match('/^3\d{9}$/', $cleanPhone)) {
            $isPakistaniNumber = true;
        }
        
        // Only format Pakistani numbers
        if ($isPakistaniNumber) {
            // If phone number starts with 0, remove 0 and add country code
            if (substr($cleanPhone, 0, 1) === '0') {
                return '92' . substr($cleanPhone, 1);
            }
            
            // If it's a 10-digit Pakistani mobile number
            if (preg_match('/^3\d{9}$/', $cleanPhone)) {
                return '92' . $cleanPhone;
            }
        }
        
        // For non-Pakistani numbers or unrecognized patterns, return original input
        return $phoneNumber;
    }

    public function updateAttendeeRemarks(Request $request)
    {
        $request->validate([
            'attendee_id' => 'required|exists:event_attendees,id',
            'remarks' => 'nullable|string|max:1000'
        ]);

        try {
            $attendee = EventAttendee::findOrFail($request->attendee_id);
            $attendee->remarks = $request->remarks;
            $attendee->save();

            return response()->json([
                'success' => true,
                'message' => 'Remarks updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update remarks. Please try again.'
            ], 500);
        }
    }

    public function updateAttendee(Request $request)
    {
        $request->validate([
            'attendee_id' => 'required|exists:event_attendees,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'remarks' => 'nullable|string|max:1000'
        ]);

        try {
            $attendee = EventAttendee::findOrFail($request->attendee_id);
            
            // Check if email is being changed and if it already exists for another attendee
            if ($attendee->email !== $request->email) {
                $existingAttendee = EventAttendee::where('email', $request->email)
                    ->where('id', '!=', $request->attendee_id)
                    ->where('event_id', $attendee->event_id)
                    ->first();
                
                if ($existingAttendee) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Email already exists for another attendee in this event.'
                    ]);
                }
            }
            
            $attendee->name = $request->name;
            $attendee->email = $request->email;
            $attendee->phone_number = $request->phone_number;
            $attendee->remarks = $request->remarks;
            $attendee->save();

            return response()->json([
                'success' => true,
                'message' => 'Attendee updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update attendee. Please try again.'
            ], 500);
        }
    }

    /**
     * Get exhibitors linked to an event
     */
    public function getEventExhibitors($id)
    {
        try {
            $event = Event::findOrFail($id);
            $exhibitors = $event->exhibitors()->get();
            
            return response()->json([
                'success' => true,
                'exhibitors' => $exhibitors
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading exhibitors: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Link exhibitors to an event
     */
    public function linkExhibitors(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'exhibitors' => 'required|array|min:1',
            'exhibitors.*' => 'exists:admins,id'
        ]);

        try {
            $event = Event::findOrFail($request->event_id);
            
            // Get existing linked exhibitors
            $existingExhibitors = $event->exhibitors()->pluck('admins.id')->toArray();
            
            // Filter out already linked exhibitors
            $newExhibitors = array_diff($request->exhibitors, $existingExhibitors);
            
            if (empty($newExhibitors)) {
                return response()->json([
                    'success' => false,
                    'message' => 'All selected exhibitors are already linked to this event.'
                ]);
            }
            
            // Link new exhibitors
            foreach ($newExhibitors as $exhibitorId) {
                $event->exhibitors()->attach($exhibitorId, [
                    'is_active' => true,
                    'linked_at' => now()
                ]);
            }
            
            $linkedCount = count($newExhibitors);
            return response()->json([
                'success' => true,
                'message' => "Successfully linked {$linkedCount} exhibitor(s) to the event."
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error linking exhibitors: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Unlink an exhibitor from an event
     */
    public function unlinkExhibitor(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'exhibitor_id' => 'required|exists:admins,id'
        ]);

        try {
            $event = Event::findOrFail($request->event_id);
            $exhibitor = Admin::findOrFail($request->exhibitor_id);
            
            // Check if exhibitor is actually linked to this event
            if (!$event->exhibitors()->where('admins.id', $exhibitor->id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This exhibitor is not linked to the event.'
                ]);
            }
            
            // Unlink the exhibitor
            $event->exhibitors()->detach($exhibitor->id);
            
            return response()->json([
                'success' => true,
                'message' => "Successfully unlinked {$exhibitor->name} from the event."
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error unlinking exhibitor: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create appointments for exhibitors linked to universities when attendee is approved
     */
    private function createAppointmentsFromAttendee($attendee, $event, $universities)
    {
        try {
            // Get exhibitors linked to this event
            $exhibitors = $event->exhibitors()->where('user_type', 'exhibitor')->get();
            
            foreach ($exhibitors as $exhibitor) {
                // Check if exhibitor's university matches any of the attendee's universities
                if ($exhibitor->university && $universities->contains($exhibitor->university)) {
                    // Create appointment for this exhibitor
                    Appointment::create([
                        'event_id' => $event->id,
                        'exhibitor_id' => $exhibitor->id,
                        'attendee_id' => $attendee->id,
                        'attendee_name' => $attendee->name,
                        'attendee_email' => $attendee->email,
                        'attendee_phone' => $attendee->phone_number,
                        'university' => $exhibitor->university,
                        'message' => 'Appointment created automatically when attendee was approved with university: ' . $exhibitor->university,
                        'status' => 'pending',
                        'appointment_date' => null, // Can be set later by exhibitor
                        'notes' => 'Auto-generated appointment from attendee approval',
                        'is_active' => true
                    ]);
                }
            }
        } catch (\Exception $e) {
            \Log::error('Error creating appointments from attendee: ' . $e->getMessage());
        }
    }
}