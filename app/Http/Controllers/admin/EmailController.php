<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventAttendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class EmailController extends Controller
{
    public function index()
    {
        $events = Event::where('is_active', true)->orderBy('name')->get();
        $universities = DB::connection('mysql2')->table('tbl_universities')->orderBy('name', 'ASC')->get();
        
        return view('admin.email-attendees', compact('events', 'universities'));
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

        // Get actual attendees with their details
        $attendees = $query->select('event_attendees.name', 'event_attendees.email', 'events.name as event_name')
            ->join('events', 'event_attendees.event_id', '=', 'events.id')
            ->orderBy('event_attendees.name')
            ->get();

        // Get summary information
        $summary = $this->getSummaryInfo($request);

        return response()->json([
            'success' => true,
            'total' => $total,
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
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'event_id' => 'nullable|exists:events,id',
            'university_id' => 'nullable|integer',
            'registration_date_from' => 'nullable|date',
            'registration_date_to' => 'nullable|date',
            'approval_status' => 'nullable|in:approved,pending',
            'attendance_status' => 'nullable|in:present,absent',
            'event_type' => 'nullable|in:physical,virtual',
            'event_status' => 'nullable|in:upcoming,ongoing,completed',
            'send_test_email' => 'nullable|in:0,1,true,false',
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
        $attendees = $query->get();

        if ($attendees->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No attendees found matching the selected criteria.'
            ]);
        }

        $sentCount = 0;
        $errors = [];

        // Send test email to admin if requested
        if ($request->input('send_test_email', '0') === '1') {
            try {
                Mail::send('emails.attendee-notification', [
                    'content' => $request->content,
                    'subject' => $request->subject,
                    'attendee' => (object)['name' => 'Admin Test', 'email' => auth()->guard('admin')->user()->email],
                    'event' => (object)['name' => 'Test Event']
                ], function ($message) use ($request) {
                    $message->to(auth()->guard('admin')->user()->email)
                            ->subject('[TEST] ' . $request->subject);
                });
            } catch (\Exception $e) {
                $errors[] = 'Test email failed: ' . $e->getMessage();
            }
        }

        // Send emails to attendees
        if ($request->input('send_individual', '1') === '1') {
            foreach ($attendees as $attendee) {
                try {
                    $personalizedContent = $this->personalizeContent($request->content, $attendee);
                    
                    Mail::send('emails.attendee-notification', [
                        'content' => $personalizedContent,
                        'subject' => $request->subject,
                        'attendee' => $attendee,
                        'event' => $attendee->event
                    ], function ($message) use ($request, $attendee) {
                        $message->to($attendee->email)
                                ->subject($request->subject);
                    });
                    
                    $sentCount++;
                } catch (\Exception $e) {
                    $errors[] = "Failed to send email to {$attendee->email}: " . $e->getMessage();
                }
            }
        } else {
            // Send bulk email (BCC)
            try {
                $emails = $attendees->pluck('email')->toArray();
                
                Mail::send('emails.attendee-notification', [
                    'content' => $request->content,
                    'subject' => $request->subject,
                    'attendee' => (object)['name' => 'Attendee', 'email' => ''],
                    'event' => (object)['name' => 'Event']
                ], function ($message) use ($request, $emails) {
                    $message->to(auth()->guard('admin')->user()->email)
                            ->bcc($emails)
                            ->subject($request->subject);
                });
                
                $sentCount = count($emails);
            } catch (\Exception $e) {
                $errors[] = 'Bulk email failed: ' . $e->getMessage();
            }
        }

        $response = [
            'success' => true,
            'sent_count' => $sentCount,
            'total_recipients' => $attendees->count()
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
            $response['message'] = 'Email sent with some errors. Check the error log.';
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
            $summary['events'] = $event ? $event->name : 'Selected Event';
        }

        // University summary
        if ($request->filled('university_id')) {
            $university = DB::connection('mysql2')->table('tbl_universities')
                ->where('id', $request->university_id)
                ->first();
            $summary['universities'] = $university ? $university->name : 'Selected University';
        }

        // Date range summary
        if ($request->filled('registration_date_from') || $request->filled('registration_date_to')) {
            $from = $request->registration_date_from ?: 'Beginning';
            $to = $request->registration_date_to ?: 'Now';
            $summary['dateRange'] = "From {$from} to {$to}";
        }

        // Filters summary
        $filters = [];
        if ($request->filled('approval_status')) {
            $filters[] = 'Approval: ' . ucfirst($request->approval_status);
        }
        if ($request->filled('attendance_status')) {
            $filters[] = 'Attendance: ' . ucfirst($request->attendance_status);
        }
        if ($request->filled('event_type')) {
            $filters[] = 'Type: ' . ucfirst($request->event_type);
        }
        if ($request->filled('event_status')) {
            $filters[] = 'Status: ' . ucfirst($request->event_status);
        }
        
        $summary['filters'] = empty($filters) ? 'None' : implode(', ', $filters);

        return $summary;
    }

    private function personalizeContent($content, $attendee)
    {
        $personalizedContent = $content;
        
        // Replace placeholders
        $personalizedContent = str_replace('{name}', $attendee->name, $personalizedContent);
        $personalizedContent = str_replace('{email}', $attendee->email, $personalizedContent);
        $personalizedContent = str_replace('{event_name}', $attendee->event->name, $personalizedContent);
        
        return $personalizedContent;
    }
}

