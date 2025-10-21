<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\EventAttendee;
use App\Models\EventGallery;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function exhibitorDashboard()
    {
        // Get the authenticated exhibitor with country relationship
        $exhibitor = auth()->user()->load('country');
        
        // Get basic statistics for the exhibitor
        $statistics = [
            'total_events' => $exhibitor->events()->count(),
            'university' => $exhibitor->university ?? 'Not specified',
            'country' => $exhibitor->country ? $exhibitor->country->name : 'Not specified',
        ];

        // Get upcoming events that this exhibitor is linked to
        $upcoming_events = $exhibitor->events()
            ->where('events.start_time', '>', now())
            ->where('events.is_active', true)
            ->orderBy('events.start_time', 'asc')
            ->take(5)
            ->get();

        return view('admin.exhibitor-dashboard', compact('statistics', 'upcoming_events', 'exhibitor'));
    }
}
