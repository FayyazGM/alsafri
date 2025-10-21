<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventAttendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ReportsController extends Controller
{
    public function index()
    {
        $events = Event::where('is_active', true)->get();
        
        // If it's an AJAX request, return JSON
        if (request()->ajax()) {
            return response()->json(['events' => $events]);
        }
        
        return view('admin.reports.index', compact('events'));
    }

    public function getEventReport($eventId)
    {
        $event = Event::with('sliderImages')->findOrFail($eventId);
        $totalAttendees = EventAttendee::where('event_id', $eventId)->count();
        $presentAttendees = EventAttendee::where('event_id', $eventId)
            ->whereNotNull('visited_at')
            ->count();
        $absentAttendees = $totalAttendees - $presentAttendees;
        $attendanceRate = $totalAttendees > 0 ? round(($presentAttendees / $totalAttendees) * 100, 2) : 0;
        // Paginate present attendees
        $presentAttendeesList = EventAttendee::where('event_id', $eventId)
            ->whereNotNull('visited_at')
            ->with('markedBy')
            ->orderBy('visited_at', 'desc')
            ->paginate(20, ['*'], 'present_page');
        // Paginate absent attendees
        $absentAttendeesList = EventAttendee::where('event_id', $eventId)
            ->whereNull('visited_at')
            ->orderBy('created_at', 'desc')
            ->paginate(20, ['*'], 'absent_page');
        $hourlyAttendance = EventAttendee::selectRaw('
            HOUR(visited_at) as hour,
            COUNT(*) as count
        ')
        ->where('event_id', $eventId)
        ->whereNotNull('visited_at')
        ->groupBy('hour')
        ->orderBy('hour')
        ->get();
        $dailyAttendance = EventAttendee::selectRaw('
            DATE(visited_at) as date,
            COUNT(*) as count
        ')
        ->where('event_id', $eventId)
        ->whereNotNull('visited_at')
        ->groupBy('date')
        ->orderBy('date')
        ->get();
        $statistics = [
            'total_attendees' => $totalAttendees,
            'present_attendees' => $presentAttendees,
            'absent_attendees' => $absentAttendees,
            'attendance_rate' => $attendanceRate
        ];
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'event' => $event,
                'statistics' => $statistics,
                'present_attendees_list' => $presentAttendeesList,
                'absent_attendees_list' => $absentAttendeesList,
                'hourly_attendance' => $hourlyAttendance,
                'daily_attendance' => $dailyAttendance
            ]);
        }
        return view('admin.reports.event-detail', compact(
            'event', 'statistics', 'presentAttendeesList', 'absentAttendeesList', 'hourlyAttendance', 'dailyAttendance'
        ));
    }

    public function exportEventReport($eventId)
    {
        $event = Event::findOrFail($eventId);
        
        $filename = 'event_report_' . $event->slug . '_' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($event) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, ['Name', 'Email', 'Phone' , 'Registration Date', 'Status', 'Visited At', 'Marked By', 'QR Code']);
            
            // Get all attendees for this event
            $attendees = EventAttendee::where('event_id', $event->id)
                ->with(['markedBy'])
                ->orderBy('created_at', 'desc')
                ->get();
            
            // Data rows
            foreach ($attendees as $attendee) {
                fputcsv($file, [
                    $attendee->name,
                    $attendee->email,
                    $attendee->phone_number,
                    $attendee->created_at->format('Y-m-d H:i:s'),
                    $attendee->visited_at ? 'Present' : 'Absent',
                    $attendee->visited_at ? $attendee->visited_at->format('Y-m-d H:i:s') : 'Not Visited',
                    $attendee->markedBy ? $attendee->markedBy->name : 'N/A',
                    $attendee->qr_code ?? 'N/A'
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPresentAttendees($eventId)
    {
        $event = Event::findOrFail($eventId);
        
        $filename = 'present_attendees_' . $event->slug . '_' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($event) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, ['Name', 'Email', 'Phone' , 'Registration Date', 'Visited At', 'Marked By', 'QR Code']);
            
            // Get present attendees
            $attendees = EventAttendee::where('event_id', $event->id)
                ->whereNotNull('visited_at')
                ->with(['markedBy'])
                ->orderBy('visited_at', 'desc')
                ->get();
            
            // Data rows
            foreach ($attendees as $attendee) {
                fputcsv($file, [
                    $attendee->name,
                    $attendee->email,
                    $attendee->phone_number,
                    $attendee->created_at->format('Y-m-d H:i:s'),
                    $attendee->visited_at->format('Y-m-d H:i:s'),
                    $attendee->markedBy ? $attendee->markedBy->name : 'N/A',
                    $attendee->qr_code ?? 'N/A'
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportAbsentAttendees($eventId)
    {
        $event = Event::findOrFail($eventId);
        
        $filename = 'absent_attendees_' . $event->slug . '_' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($event) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, ['Name', 'Email', 'Phone' ,'Registration Date', 'QR Code']);
            
            // Get absent attendees
            $attendees = EventAttendee::where('event_id', $event->id)
                ->whereNull('visited_at')
                ->orderBy('created_at', 'desc')
                ->get();
            
            // Data rows
            foreach ($attendees as $attendee) {
                fputcsv($file, [
                    $attendee->name,
                    $attendee->email,
                    $attendee->phone_number,
                    $attendee->created_at->format('Y-m-d H:i:s'),
                    $attendee->qr_code ?? 'N/A'
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function attendeesReport(Request $request)
    {
        $events = Event::where('is_active', true)->get();
        
        // Get universities from the external database
        $universities = DB::connection('mysql2')->table('tbl_universities')
            ->orderBy('name')
            ->get();
        
        // Get users (non-exhibitors) for the marked by filter
        $staffMembers = \App\Models\Admin::where('user_type', '!=', 'exhibitor')->orderBy('name')->get();
        
        $attendees = collect();
        $selectedEvent = null;
        $selectedUniversity = null;
        $registrationFormFields = [];
        
        // If form is submitted, get the data
        if ($request->has('event_id') && $request->event_id) {
            $selectedEvent = Event::findOrFail($request->event_id);
            $selectedUniversity = $request->university_id;
            
            // Get registration form fields for dynamic columns (excluding basic fields)
            $registrationFormFields = [];
            $excludeFields = ['name', 'email', 'phone_number', 'phone'];
            if ($selectedEvent->registration_form) {
                $formFields = json_decode($selectedEvent->registration_form, true);
                if (is_array($formFields)) {
                    foreach ($formFields as $field) {
                        if (isset($field['label'])) {
                            $fieldKey = strtolower(str_replace(' ', '_', $field['label']));
                            // Only include fields that are not basic fields
                            if (!in_array($fieldKey, $excludeFields)) {
                                $registrationFormFields[$fieldKey] = $field['label'];
                            }
                        }
                    }
                }
            }
            
            // Build the query
            $query = EventAttendee::where('event_id', $request->event_id)
                ->with(['markedBy', 'event', 'approvedBy', 'rejectedBy']);
            
            // Filter by approval status
            if ($request->filled('approval_status')) {
                if ($request->approval_status === 'auto_approved') {
                    $query->where('is_approved', 1)->where('auto_approved', 1);
                } else {
                    $query->where('is_approved', $request->approval_status);
                }
            }
            // If no approval status is selected, show all statuses (no filter applied)
            
            // Filter by visit status
            if ($request->filled('visit_status')) {
                if ($request->visit_status === 'visited') {
                    $query->whereNotNull('visited_at');
                } elseif ($request->visit_status === 'not_visited') {
                    $query->whereNull('visited_at');
                }
            }
            
            // Filter by university if selected
            if ($selectedUniversity) {
                $university = DB::connection('mysql2')->table('tbl_universities')
                    ->where('id', $selectedUniversity)
                    ->first();
                
                if ($university) {
                    // Search for the university name in the JSON object values
                    $query->whereRaw("JSON_SEARCH(universities, 'one', ?)", [$university->name]);
                }
            }
            
            // Search by name or email
            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('email', 'LIKE', "%{$searchTerm}%");
                });
            }
            
            // Filter by registration date range
            if ($request->filled('registration_date_from')) {
                $query->whereDate('created_at', '>=', $request->registration_date_from);
            }
            if ($request->filled('registration_date_to')) {
                $query->whereDate('created_at', '<=', $request->registration_date_to);
            }
            
            // Filter by visit date range
            if ($request->filled('visit_date_from')) {
                $query->whereDate('visited_at', '>=', $request->visit_date_from);
            }
            if ($request->filled('visit_date_to')) {
                $query->whereDate('visited_at', '<=', $request->visit_date_to);
            }
            
            // Filter by approval date range
            if ($request->filled('approved_date_from')) {
                $query->whereDate('approved_at', '>=', $request->approved_date_from);
            }
            if ($request->filled('approved_date_to')) {
                $query->whereDate('approved_at', '<=', $request->approved_date_to);
            }
            
            // Filter by timeslot
            if ($request->filled('timeslot_from')) {
                $query->where('timeslot_from', '>=', $request->timeslot_from);
            }
            if ($request->filled('timeslot_to')) {
                $query->where('timeslot_to', '<=', $request->timeslot_to);
            }
            
            // Filter by marked by staff
            if ($request->filled('marked_by')) {
                $query->where('marked_by', $request->marked_by);
            }
            
            // Filter by approved by staff
            if ($request->filled('approved_by')) {
                $query->where('approved_by', $request->approved_by);
            }
            
            // Filter by remarks
            if ($request->filled('has_remarks')) {
                if ($request->has_remarks === 'with_remarks') {
                    $query->whereNotNull('remarks')->where('remarks', '!=', '');
                } elseif ($request->has_remarks === 'without_remarks') {
                    $query->where(function($q) {
                        $q->whereNull('remarks')->orWhere('remarks', '');
                    });
                }
            }
            
            // Apply sorting
            $sortBy = $request->get('sort_by', 'created_at_desc');
            switch ($sortBy) {
                case 'created_at_asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'visited_at_desc':
                    $query->orderBy('visited_at', 'desc');
                    break;
                case 'visited_at_asc':
                    $query->orderBy('visited_at', 'asc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
            
            // Apply pagination or get all results
            $perPage = $request->get('per_page', '25');
            if ($perPage === 'all') {
                $attendees = $query->get();
            } else {
                $attendees = $query->paginate((int)$perPage)->appends($request->query());
            }
        }
        
        return view('admin.reports.attendees', compact('events', 'universities', 'staffMembers', 'attendees', 'selectedEvent', 'selectedUniversity', 'registrationFormFields'));
    }

    public function generateAttendeesReport(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'university_id' => 'nullable|integer',
        ]);

        $event = Event::findOrFail($request->event_id);
        $universityId = $request->university_id;
        
        // Get registration form fields for dynamic columns (excluding basic fields)
        $registrationFormFields = [];
        $excludeFields = ['name', 'email', 'phone_number', 'phone'];
        if ($event->registration_form) {
            $formFields = json_decode($event->registration_form, true);
            if (is_array($formFields)) {
                foreach ($formFields as $field) {
                    if (isset($field['label'])) {
                        $fieldKey = strtolower(str_replace(' ', '_', $field['label']));
                        // Only include fields that are not basic fields
                        if (!in_array($fieldKey, $excludeFields)) {
                            $registrationFormFields[$fieldKey] = $field['label'];
                        }
                    }
                }
            }
        }
        
        // Build the query with all filters
        $query = EventAttendee::where('event_id', $request->event_id)
            ->with(['markedBy', 'event', 'approvedBy', 'rejectedBy']);
        
        // Filter by approval status
        if ($request->filled('approval_status')) {
            if ($request->approval_status === 'auto_approved') {
                $query->where('is_approved', 1)->where('auto_approved', 1);
            } else {
                $query->where('is_approved', $request->approval_status);
            }
        }
        // If no approval status is selected, show all statuses (no filter applied)
        
        // Filter by visit status
        if ($request->filled('visit_status')) {
            if ($request->visit_status === 'visited') {
                $query->whereNotNull('visited_at');
            } elseif ($request->visit_status === 'not_visited') {
                $query->whereNull('visited_at');
            }
        }
        
        // Filter by university if selected
        if ($universityId) {
            $university = DB::connection('mysql2')->table('tbl_universities')
                ->where('id', $universityId)
                ->first();
            
            if ($university) {
                // Search for the university name in the JSON object values
                $query->whereRaw("JSON_SEARCH(universities, 'one', ?)", [$university->name]);
            }
        }
        
        // Search by name or email
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email', 'LIKE', "%{$searchTerm}%");
            });
        }
        
        // Filter by registration date range
        if ($request->filled('registration_date_from')) {
            $query->whereDate('created_at', '>=', $request->registration_date_from);
        }
        if ($request->filled('registration_date_to')) {
            $query->whereDate('created_at', '<=', $request->registration_date_to);
        }
        
        // Filter by visit date range
        if ($request->filled('visit_date_from')) {
            $query->whereDate('visited_at', '>=', $request->visit_date_from);
        }
        if ($request->filled('visit_date_to')) {
            $query->whereDate('visited_at', '<=', $request->visit_date_to);
        }
        
        // Filter by approval date range
        if ($request->filled('approved_date_from')) {
            $query->whereDate('approved_at', '>=', $request->approved_date_from);
        }
        if ($request->filled('approved_date_to')) {
            $query->whereDate('approved_at', '<=', $request->approved_date_to);
        }
        
        // Filter by timeslot
        if ($request->filled('timeslot_from')) {
            $query->where('timeslot_from', '>=', $request->timeslot_from);
        }
        if ($request->filled('timeslot_to')) {
            $query->where('timeslot_to', '<=', $request->timeslot_to);
        }
        
        // Filter by marked by staff
        if ($request->filled('marked_by')) {
            $query->where('marked_by', $request->marked_by);
        }
        
        // Filter by approved by staff
        if ($request->filled('approved_by')) {
            $query->where('approved_by', $request->approved_by);
        }
        
        // Filter by remarks
        if ($request->filled('has_remarks')) {
            if ($request->has_remarks === 'with_remarks') {
                $query->whereNotNull('remarks')->where('remarks', '!=', '');
            } elseif ($request->has_remarks === 'without_remarks') {
                $query->where(function($q) {
                    $q->whereNull('remarks')->orWhere('remarks', '');
                });
            }
        }
        
        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at_desc');
        switch ($sortBy) {
            case 'created_at_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'visited_at_desc':
                $query->orderBy('visited_at', 'desc');
                break;
            case 'visited_at_asc':
                $query->orderBy('visited_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $attendees = $query->get();
        
        // Get university name if filtered
        $universityName = null;
        if ($universityId) {
            $university = DB::connection('mysql2')->table('tbl_universities')
                ->where('id', $universityId)
                ->first();
            $universityName = $university ? $university->name : null;
        }
        
        // Generate filename
        $filename = 'attendees_report_' . $event->slug;
        if ($universityName) {
            $filename .= '_' . str_replace(' ', '_', strtolower($universityName));
        }
        $filename .= '_' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($attendees, $event, $universityName, $registrationFormFields) {
            $file = fopen('php://output', 'w');
            
            // Build header row with dynamic columns
            $headerRow = [
                'Name', 
                'Email', 
                'Phone', 
                'Registration Date', 
                'Status', 
                'Approved By',
                'Approved At',
                'Rejected By',
                'Rejected At',
                'Visited At', 
                'Marked By', 
                'Universities',
                'Timeslot',
                'Remarks',
                'QR Code'
            ];
            
            // Add dynamic columns from registration form
            foreach ($registrationFormFields as $fieldKey => $fieldLabel) {
                $headerRow[] = $fieldLabel;
            }
            
            fputcsv($file, $headerRow);
            
            // Data rows
            foreach ($attendees as $attendee) {
                $universities = json_decode($attendee->universities, true) ?? [];
                $universitiesList = '';
                if (is_array($universities) && count($universities) > 0) {
                    $universitiesList = implode(', ', array_values($universities));
                }
                
                // Format timeslot
                $timeslot = 'N/A';
                if ($attendee->timeslot_from && $attendee->timeslot_to) {
                    $timeslot = \Carbon\Carbon::parse($attendee->timeslot_from)->format('h:i A') . ' - ' . \Carbon\Carbon::parse($attendee->timeslot_to)->format('h:i A');
                }
                
                // Format status
                $status = 'Pending';
                if ($attendee->is_approved == 1) {
                    $status = $attendee->auto_approved ? 'Auto-Approved' : 'Approved';
                } elseif ($attendee->is_approved == 2) {
                    $status = 'Rejected';
                }
                
                // Build data row with dynamic columns
                $dataRow = [
                    $attendee->name,
                    $attendee->email,
                    $attendee->phone_number ?? 'N/A',
                    $attendee->created_at->format('Y-m-d H:i:s'),
                    $status,
                    $attendee->approvedBy ? $attendee->approvedBy->name : 'N/A',
                    $attendee->approved_at ? $attendee->approved_at->format('Y-m-d H:i:s') : 'N/A',
                    $attendee->rejectedBy ? $attendee->rejectedBy->name : 'N/A',
                    $attendee->rejected_at ? $attendee->rejected_at->format('Y-m-d H:i:s') : 'N/A',
                    $attendee->visited_at ? $attendee->visited_at->format('Y-m-d H:i:s') : 'Not Visited',
                    $attendee->markedBy ? $attendee->markedBy->name : 'N/A',
                    $universitiesList,
                    $timeslot,
                    $attendee->remarks ?? 'N/A',
                    $attendee->qr_code ?? 'N/A'
                ];
                
                // Add dynamic field values
                $otherFields = json_decode($attendee->other_fields, true) ?? [];
                foreach ($registrationFormFields as $fieldKey => $fieldLabel) {
                    $dataRow[] = $otherFields[$fieldKey] ?? 'N/A';
                }
                
                fputcsv($file, $dataRow);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
} 