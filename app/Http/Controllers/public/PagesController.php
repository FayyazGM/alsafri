<?php

namespace App\Http\Controllers\public;

use App\Helpers\WhatsappHelper;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventAttendee;
use App\Models\EventGallery;
use App\Models\ExhibitorMedia;
use App\Models\Staff;
use App\Models\GalleryImage;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class PagesController extends Controller
{

    public function home()
    {
        return view('public.index');
    }
    public function about()
    {
        return view('public.about');
    }
    public function services()
    {
        return view('public.services');
    }
    public function projects()
    {
        $projects = Project::active()->ordered()->paginate(9);
        $categories = Project::getCategories();
        
        return view('public.projects', compact('projects', 'categories'));
    }

    public function projectDetail($slug)
    {
        $project = Project::active()->where('slug', $slug)->firstOrFail();
        $relatedProjects = $project->getRelatedProjects(3);
        
        return view('public.project-detail', compact('project', 'relatedProjects'));
    }
    public function gallery()
    {
        $galleryImages = GalleryImage::active()->ordered()->paginate(9);
        $categories = GalleryImage::active()->distinct()->pluck('category')->toArray();
        
        return view('public.gallery', compact('galleryImages', 'categories'));
    }
    public function contact()
    {
        return view('public.contact');
    }
}