<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventAttendee;
use App\Helpers\WhatsappHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WhatsAppController extends Controller
{
    public function index()
    {
        $events = Event::where('is_active', true)->orderBy('name')->get();
        $universities = DB::connection('mysql2')->table('tbl_universities')->orderBy('name', 'ASC')->get();
        
        return view('admin.whatsapp-attendees', compact('events', 'universities'));
    }

    public function preview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'nullable|exists:events,id',
            'university_id' => 'nullable|integer',
            'registration_date_from' => 'nullable|date',
            'registration_date_to' => 'nullable|date',
            'approval_status' => 'nullable|in:approved,pending',
            'attendance_status' => 'nullable|in:present,absent',
            'event_type' => 'nullable|in:physical,virtual',
            'event_status' => 'nullable|in:upcoming,ongoing,completed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]);
        }

        $query = $this->buildAttendeeQuery($request);
        $total = $query->count();

        // Get actual attendees with their details (only those with phone numbers)
        $attendees = $query->select('event_attendees.name', 'event_attendees.email', 'event_attendees.phone_number', 'events.name as event_name')
            ->join('events', 'event_attendees.event_id', '=', 'events.id')
            ->whereNotNull('event_attendees.phone_number')
            ->where('event_attendees.phone_number', '!=', '')
            ->orderBy('event_attendees.name')
            ->get();

        // Get summary information
        $summary = $this->getSummaryInfo($request);

        return response()->json([
            'success' => true,
            'total' => $total,
            'attendees_with_phone' => $attendees->count(),
            'attendees' => $attendees,
            'events' => $summary['events'],
            'universities' => $summary['universities'],
            'dateRange' => $summary['dateRange'],
            'filters' => $summary['filters']
        ]);
    }

    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'template_name' => 'required|string|max:255',
            'event_id' => 'nullable|exists:events,id',
            'university_id' => 'nullable|integer',
            'registration_date_from' => 'nullable|date',
            'registration_date_to' => 'nullable|date',
            'approval_status' => 'nullable|in:approved,pending',
            'attendance_status' => 'nullable|in:present,absent',
            'event_type' => 'nullable|in:physical,virtual',
            'event_status' => 'nullable|in:upcoming,ongoing,completed',
            'send_test_whatsapp' => 'nullable|in:0,1,true,false',
            'send_individual' => 'nullable|in:0,1,true,false',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]);
        }

        $query = $this->buildAttendeeQuery($request);
        $attendees = $query->whereNotNull('phone_number')
            ->where('phone_number', '!=', '')
            ->get();

        if ($attendees->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No attendees with phone numbers found matching the selected criteria.'
            ]);
        }

        $sentCount = 0;
        $errors = [];

        // Send test WhatsApp to admin if requested
        if ($request->input('send_test_whatsapp', '0') === '1') {
            try {
                $adminPhone = auth()->guard('admin')->user()->phone ?? null;
                if ($adminPhone) {
                    $response = WhatsappHelper::sendWhatsappTemplateMessage($adminPhone, $request->template_name);
                    if (!$response['success']) {
                        $errors[] = 'Test WhatsApp failed: ' . ($response['message'] ?? 'Unknown error');
                    }
                } else {
                    $errors[] = 'Admin phone number not found for test message';
                }
            } catch (\Exception $e) {
                $errors[] = 'Test WhatsApp failed: ' . $e->getMessage();
            }
        }

        // Send WhatsApp messages to attendees
        if ($request->input('send_individual', '1') === '1') {
            foreach ($attendees as $attendee) {
                try {
                    $response = WhatsappHelper::sendWhatsappTemplateMessage($attendee->phone_number, $request->template_name);
                    
                    if ($response['success']) {
                        $sentCount++;
                    } else {
                        $errors[] = "Failed to send WhatsApp to {$attendee->phone_number}: " . ($response['message'] ?? 'Unknown error');
                    }
                } catch (\Exception $e) {
                    $errors[] = "Failed to send WhatsApp to {$attendee->phone_number}: " . $e->getMessage();
                }
            }
        } else {
            // Send bulk WhatsApp (individual messages in a loop)
            foreach ($attendees as $attendee) {
                try {
                    $response = WhatsappHelper::sendWhatsappTemplateMessage($attendee->phone_number, $request->template_name);
                    
                    if ($response['success']) {
                        $sentCount++;
                    } else {
                        $errors[] = "Failed to send WhatsApp to {$attendee->phone_number}: " . ($response['message'] ?? 'Unknown error');
                    }
                } catch (\Exception $e) {
                    $errors[] = "Failed to send WhatsApp to {$attendee->phone_number}: " . $e->getMessage();
                }
            }
        }

        $response = [
            'success' => true,
            'sent_count' => $sentCount,
            'total_recipients' => $attendees->count()
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
            $response['message'] = 'WhatsApp messages sent with some errors. Check the error log.';
        }

        return response()->json($response);
    }

    private function buildAttendeeQuery(Request $request)
    {
        $query = EventAttendee::with(['event']);

        // Event filter
        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        // University filter
        if ($request->filled('university_id')) {
            $university = DB::connection('mysql2')->table('tbl_universities')
                ->where('id', $request->university_id)
                ->first();
            
            if ($university) {
                $query->whereRaw("JSON_SEARCH(universities, 'one', ?)", [$university->name]);
            }
        }

        // Registration date filters
        if ($request->filled('registration_date_from')) {
            $query->whereDate('created_at', '>=', $request->registration_date_from);
        }
        
        if ($request->filled('registration_date_to')) {
            $query->whereDate('created_at', '<=', $request->registration_date_to);
        }

        // Approval status filter
        if ($request->filled('approval_status')) {
            if ($request->approval_status === 'approved') {
                $query->where('is_approved', 1);
            } elseif ($request->approval_status === 'pending') {
                $query->where('is_approved', 0);
            }
        }

        // Attendance status filter
        if ($request->filled('attendance_status')) {
            if ($request->attendance_status === 'present') {
                $query->whereNotNull('visited_at');
            } elseif ($request->attendance_status === 'absent') {
                $query->whereNull('visited_at');
            }
        }

        // Event type filter
        if ($request->filled('event_type')) {
            $query->whereHas('event', function($q) use ($request) {
                $q->where('event_type', $request->event_type);
            });
        }

        // Event status filter
        if ($request->filled('event_status')) {
            $query->whereHas('event', function($q) use ($request) {
                $now = now();
                switch ($request->event_status) {
                    case 'upcoming':
                        $q->where('start_time', '>', $now);
                        break;
                    case 'ongoing':
                        $q->where('start_time', '<=', $now)
                          ->where(function($subQ) use ($now) {
                              $subQ->whereNull('end_time')
                                   ->orWhere('end_time', '>=', $now);
                          });
                        break;
                    case 'completed':
                        $q->where('end_time', '<', $now);
                        break;
                }
            });
        }

        return $query->orderBy('event_attendees.created_at', 'desc');
    }

    private function getSummaryInfo(Request $request)
    {
        $summary = [
            'events' => 'All Events',
            'universities' => 'All Universities',
            'dateRange' => 'All Time',
            'filters' => []
        ];

        // Event summary
        if ($request->filled('event_id')) {
            $event = Event::find($request->event_id);
            if ($event) {
                $summary['events'] = $event->name;
                $summary['filters'][] = "Event: {$event->name}";
            }
        }

        // University summary
        if ($request->filled('university_id')) {
            $university = DB::connection('mysql2')->table('tbl_universities')
                ->where('id', $request->university_id)
                ->first();
            if ($university) {
                $summary['universities'] = $university->name;
                $summary['filters'][] = "University: {$university->name}";
            }
        }

        // Date range summary
        if ($request->filled('registration_date_from') || $request->filled('registration_date_to')) {
            $from = $request->registration_date_from ?: 'Beginning';
            $to = $request->registration_date_to ?: 'Now';
            $summary['dateRange'] = "From {$from} to {$to}";
            $summary['filters'][] = "Date Range: {$from} to {$to}";
        }

        // Other filters
        if ($request->filled('approval_status')) {
            $summary['filters'][] = "Approval: " . ucfirst($request->approval_status);
        }
        if ($request->filled('attendance_status')) {
            $summary['filters'][] = "Attendance: " . ucfirst($request->attendance_status);
        }
        if ($request->filled('event_type')) {
            $summary['filters'][] = "Type: " . ucfirst($request->event_type);
        }
        if ($request->filled('event_status')) {
            $summary['filters'][] = "Status: " . ucfirst($request->event_status);
        }

        return $summary;
    }
}
