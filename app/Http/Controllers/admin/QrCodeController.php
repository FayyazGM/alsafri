<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventAttendee;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function scan()
    {
        return view('admin.scan');
    }

    public function qrcode_scanning($qrcode) 
    {
        $checkQrcode = EventAttendee::query()->where('qr_code' , $qrcode)->first();
        if(!$checkQrcode){
            return redirect()->route('admin-dashboard')->with('error', 'Invalid QR code!');
        }
        $checkLogin = auth()->guard('admin')->user();
        if(!$checkLogin){
            return redirect()->route('event-detail' , $checkQrcode->event->slug);
        }
        
        // Check if event has started
        $event = $checkQrcode->event;
        if($event->start_time > now()){
            return redirect()->route('admin-dashboard')->with('error', 'Event has not started yet. Attendance marking is only allowed after the event start time.');
        }
        
        if($checkQrcode->visited_at != NULL){
            return redirect()->route('admin-dashboard')->with('error' , 'Owner of this qrcode already visited');
        }
        $checkQrcode->update([
            'visited_at' => now(),
            'marked_by' => auth()->guard('admin')->id()
        ]);
        return redirect()->route('admin-dashboard')->with('success' , 'Attendee marked as visited succesfully');
    }
} 