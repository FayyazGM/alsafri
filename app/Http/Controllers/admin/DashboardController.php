<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\GalleryImage;
use App\Models\ContactMessage;
use App\Models\EmailSubscription;
use App\Models\Admin;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Get statistics for the dashboard
        $statistics = [
            'total_projects' => Project::count(),
            'active_projects' => Project::where('is_active', true)->count(),
            'featured_projects' => Project::where('is_featured', true)->count(),
            'total_gallery_images' => GalleryImage::count(),
            'active_gallery_images' => GalleryImage::where('is_active', true)->count(),
            'total_contact_messages' => ContactMessage::count(),
            'recent_contact_messages' => ContactMessage::where('created_at', '>=', now()->subDays(7))->count(),
            'total_email_subscriptions' => EmailSubscription::count(),
            'recent_subscriptions' => EmailSubscription::where('created_at', '>=', now()->subDays(7))->count(),
            'total_admins' => Admin::count(),
        ];

        // Get recent contact messages
        $recent_messages = ContactMessage::orderBy('created_at', 'desc')->take(5)->get();

        // Get recent email subscriptions
        $recent_subscriptions = EmailSubscription::orderBy('created_at', 'desc')->take(5)->get();

        // Get recent projects
        $recent_projects = Project::orderBy('created_at', 'desc')->take(5)->get();

        // Get project categories count
        $project_categories = Project::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get();

        // Get gallery categories count
        $gallery_categories = GalleryImage::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get();

        return view('admin.dashboard', compact(
            'statistics', 
            'recent_messages', 
            'recent_subscriptions', 
            'recent_projects',
            'project_categories',
            'gallery_categories'
        ));
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
