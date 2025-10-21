<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventAttendee;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExhibitorReportsController extends Controller
{
    /**
     * Display the reports dashboard
     */
    public function index()
    {
        $exhibitor = auth()->user();
        
        // Get events linked to this exhibitor
        $events = $exhibitor->events()->where('events.is_active', true)->get();
        
        // Get basic statistics
        $stats = $this->getBasicStats($exhibitor);
        
        return view('admin.exhibitor-reports.index', compact('events', 'stats'));
    }

    /**
     * Generate student registrations report
     */
    public function studentRegistrations(Request $request)
    {
        $exhibitor = auth()->user();
        $filters = $this->getFilters($request);
        
        $query = $this->buildAttendeeQuery($exhibitor, $filters);
        
        $attendees = $query->paginate(50);
        
        // Get available universities from attendees
        $universities = $this->getAvailableUniversities($exhibitor);
        
        return view('admin.exhibitor-reports.student-registrations', compact('attendees', 'filters', 'universities'));
    }

    /**
     * Generate student visits report
     */
    public function studentVisits(Request $request)
    {
        $exhibitor = auth()->user();
        $filters = $this->getFilters($request);
        
        $query = $this->buildAttendeeQuery($exhibitor, $filters)
            ->whereNotNull('visited_at');
        
        $attendees = $query->paginate(50);
        
        // Get available universities from attendees
        $universities = $this->getAvailableUniversities($exhibitor);
        
        return view('admin.exhibitor-reports.student-visits', compact('attendees', 'filters', 'universities'));
    }

    /**
     * Generate leads report
     */
    public function leads(Request $request)
    {
        $exhibitor = auth()->user();
        $filters = $this->getFilters($request);
        
        // Get appointments (leads) for this exhibitor
        $query = Appointment::where('exhibitor_id', $exhibitor->id)
            ->with(['event', 'attendee']);
        
        // Apply filters
        if ($filters['event_id']) {
            $query->where('event_id', $filters['event_id']);
        }
        
        if ($filters['status']) {
            $query->where('status', $filters['status']);
        }
        
        if ($filters['date_from']) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        
        if ($filters['date_to']) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }
        
        $appointments = $query->orderBy('created_at', 'desc')->paginate(50);
        
        return view('admin.exhibitor-reports.leads', compact('appointments', 'filters'));
    }

    /**
     * Export data to CSV
     */
    public function export(Request $request)
    {
        $exhibitor = auth()->user();
        $type = $request->get('type', 'registrations');
        $filters = $this->getFilters($request);
        
        $filename = $this->generateFilename($type, $filters);
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($exhibitor, $type, $filters) {
            $file = fopen('php://output', 'w');
            
            if ($type === 'registrations') {
                $this->exportRegistrations($file, $exhibitor, $filters);
            } elseif ($type === 'visits') {
                $this->exportVisits($file, $exhibitor, $filters);
            } elseif ($type === 'leads') {
                $this->exportLeads($file, $exhibitor, $filters);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get basic statistics for the exhibitor
     */
    private function getBasicStats($exhibitor)
    {
        $eventIds = $exhibitor->events()->pluck('events.id');
        
        $stats = [
            'total_registrations' => EventAttendee::whereIn('event_id', $eventIds)->count(),
            'total_visits' => EventAttendee::whereIn('event_id', $eventIds)->whereNotNull('visited_at')->count(),
            'total_leads' => Appointment::where('exhibitor_id', $exhibitor->id)->count(),
            'confirmed_appointments' => Appointment::where('exhibitor_id', $exhibitor->id)->where('status', 'confirmed')->count(),
            'completed_appointments' => Appointment::where('exhibitor_id', $exhibitor->id)->where('status', 'completed')->count(),
        ];
        
        return $stats;
    }

    /**
     * Build attendee query with filters
     */
    private function buildAttendeeQuery($exhibitor, $filters)
    {
        $eventIds = $exhibitor->events()->pluck('events.id');
        
        $query = EventAttendee::whereIn('event_id', $eventIds)
            ->with(['event']);
        
        // Apply filters
        if ($filters['event_id']) {
            $query->where('event_id', $filters['event_id']);
        }
        
        if ($filters['date_from']) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        
        if ($filters['date_to']) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }
        
        if ($filters['preferred_course']) {
            $query->whereRaw("JSON_SEARCH(other_fields, 'one', ?)", ['%' . $filters['preferred_course'] . '%']);
        }
        
        if ($filters['city']) {
            $query->whereRaw("JSON_SEARCH(other_fields, 'one', ?)", ['%' . $filters['city'] . '%']);
        }
        
        if ($filters['qualification']) {
            $query->whereRaw("JSON_SEARCH(other_fields, 'one', ?)", ['%' . $filters['qualification'] . '%']);
        }
        
        if ($filters['university']) {
            $query->whereRaw("JSON_SEARCH(universities, 'one', ?)", [$filters['university']]);
        }
        
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Get filters from request
     */
    private function getFilters($request)
    {
        return [
            'event_id' => $request->get('event_id'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
            'preferred_course' => $request->get('preferred_course'),
            'city' => $request->get('city'),
            'qualification' => $request->get('qualification'),
            'university' => $request->get('university'),
            'status' => $request->get('status'),
        ];
    }

    /**
     * Get available universities from attendees
     */
    private function getAvailableUniversities($exhibitor)
    {
        $eventIds = $exhibitor->events()->pluck('events.id');
        
        $attendees = EventAttendee::whereIn('event_id', $eventIds)
            ->whereNotNull('universities')
            ->get();
        
        $universities = collect();
        
        foreach ($attendees as $attendee) {
            $attendeeUniversities = json_decode($attendee->universities, true);
            if (is_array($attendeeUniversities)) {
                foreach ($attendeeUniversities as $university) {
                    $universities->push($university);
                }
            }
        }
        
        return $universities->unique()->sort()->values();
    }

    /**
     * Generate filename for export
     */
    private function generateFilename($type, $filters)
    {
        $date = now()->format('Y-m-d');
        $eventName = $filters['event_id'] ? Event::find($filters['event_id'])->name : 'all-events';
        $eventName = str_replace(' ', '-', strtolower($eventName));
        
        return "exhibitor-{$type}-{$eventName}-{$date}.csv";
    }

    /**
     * Export registrations to CSV
     */
    private function exportRegistrations($file, $exhibitor, $filters)
    {
        fputcsv($file, ['Name', 'Email', 'Phone', 'Event', 'University', 'Registration Date', 'Status']);
        
        $query = $this->buildAttendeeQuery($exhibitor, $filters);
        $attendees = $query->get();
        
        foreach ($attendees as $attendee) {
            $universities = json_decode($attendee->universities, true) ?? [];
            $universityNames = is_array($universities) ? implode(', ', array_values($universities)) : '';
            
            fputcsv($file, [
                $attendee->name,
                $attendee->email,
                $attendee->phone_number,
                $attendee->event->name,
                $universityNames,
                $attendee->created_at->format('Y-m-d H:i:s'),
                $attendee->is_approved ? 'Approved' : 'Pending'
            ]);
        }
    }

    /**
     * Export visits to CSV
     */
    private function exportVisits($file, $exhibitor, $filters)
    {
        fputcsv($file, ['Name', 'Email', 'Phone', 'Event', 'University', 'Visit Date', 'Registration Date']);
        
        $query = $this->buildAttendeeQuery($exhibitor, $filters)
            ->whereNotNull('visited_at');
        $attendees = $query->get();
        
        foreach ($attendees as $attendee) {
            $universities = json_decode($attendee->universities, true) ?? [];
            $universityNames = is_array($universities) ? implode(', ', array_values($universities)) : '';
            
            fputcsv($file, [
                $attendee->name,
                $attendee->email,
                $attendee->phone_number,
                $attendee->event->name,
                $universityNames,
                $attendee->visited_at ? $attendee->visited_at->format('Y-m-d H:i:s') : '',
                $attendee->created_at->format('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Export leads to CSV
     */
    private function exportLeads($file, $exhibitor, $filters)
    {
        fputcsv($file, ['Attendee Name', 'Email', 'Phone', 'Event', 'University', 'Status', 'Appointment Date', 'Created Date']);
        
        $query = Appointment::where('exhibitor_id', $exhibitor->id)
            ->with(['event', 'attendee']);
        
        if ($filters['event_id']) {
            $query->where('event_id', $filters['event_id']);
        }
        
        if ($filters['status']) {
            $query->where('status', $filters['status']);
        }
        
        $appointments = $query->get();
        
        foreach ($appointments as $appointment) {
            fputcsv($file, [
                $appointment->attendee_name,
                $appointment->attendee_email,
                $appointment->attendee_phone,
                $appointment->event->name,
                $appointment->university,
                ucfirst($appointment->status),
                $appointment->appointment_date ? $appointment->appointment_date->format('Y-m-d H:i:s') : '',
                $appointment->created_at->format('Y-m-d H:i:s')
            ]);
        }
    }
}
