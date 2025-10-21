<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Event;
use App\Models\EventAttendee;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = auth()->user()->appointments()
            ->with(['event', 'attendee'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = auth()->user()->events()->where('events.is_active', true)->get();
        $universities = \DB::connection('mysql2')->table('tbl_universities')->orderBy('name', 'ASC')->get();
        return view('admin.appointments.create', compact('events', 'universities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'attendee_name' => 'required|string|max:255',
            'attendee_email' => 'required|email',
            'attendee_phone' => 'nullable|string|max:20',
            'university' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'appointment_date' => 'nullable|date|after:now',
            'notes' => 'nullable|string',
        ]);

        // Verify that the event is linked to this exhibitor
        $event = auth()->user()->events()->where('events.id', $request->event_id)->first();
        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'You are not linked to this event.'
            ], 403);
        }

        // Check if attendee already exists for this event
        $existingAttendee = EventAttendee::where('event_id', $request->event_id)
            ->where('email', $request->attendee_email)
            ->first();

        $attendee = null;
        if ($existingAttendee) {
            // Use existing attendee
            $attendee = $existingAttendee;
        } else {
            // Create new event attendee
            $attendee = EventAttendee::create([
                'event_id' => $request->event_id,
                'name' => $request->attendee_name,
                'email' => $request->attendee_email,
                'phone_number' => $request->attendee_phone,
                'other_fields' => json_encode([
                    'university' => $request->university,
                    'message' => $request->message,
                    'appointment_date' => $request->appointment_date,
                    'notes' => $request->notes,
                    'created_by_exhibitor' => true,
                    'exhibitor_id' => auth()->id()
                ]),
                'is_approved' => 0, // Pending approval
                'auto_approved' => false,
                'remarks' => 'Appointment request from exhibitor - pending admin approval'
            ]);
        }

        // Create appointment
        $appointmentData = $request->all();
        $appointmentData['exhibitor_id'] = auth()->id();
        $appointmentData['attendee_id'] = $attendee->id;
        $appointmentData['status'] = 'pending';

        Appointment::create($appointmentData);

        return response()->json([
            'success' => true,
            'message' => 'Appointment created successfully! The attendee will be reviewed by admin for approval.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        // Ensure the appointment belongs to the authenticated exhibitor
        if ($appointment->exhibitor_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $appointment->load(['event', 'attendee']);
        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        // Ensure the appointment belongs to the authenticated exhibitor
        if ($appointment->exhibitor_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $events = auth()->user()->events()->where('is_active', true)->get();
        return view('admin.appointments.edit', compact('appointment', 'events'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        // Ensure the appointment belongs to the authenticated exhibitor
        if ($appointment->exhibitor_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'event_id' => 'required|exists:events,id',
            'attendee_name' => 'required|string|max:255',
            'attendee_email' => 'required|email',
            'attendee_phone' => 'nullable|string|max:20',
            'university' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'appointment_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        // Verify that the event is linked to this exhibitor
        $event = auth()->user()->events()->where('events.id', $request->event_id)->first();
        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'You are not linked to this event.'
            ], 403);
        }

        $appointment->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Appointment updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        // Ensure the appointment belongs to the authenticated exhibitor
        if ($appointment->exhibitor_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $appointment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Appointment deleted successfully!'
        ]);
    }

    /**
     * Update appointment status
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        // Ensure the appointment belongs to the authenticated exhibitor
        if ($appointment->exhibitor_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'notes' => 'nullable|string',
        ]);

        $appointment->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment status updated successfully!'
        ]);
    }
}
