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
        $featuredProjects = Project::active()
            ->where('is_featured', true)
            ->ordered()
            ->take(6)
            ->get();

        $activeProjects = Project::active()
            ->ordered()
            ->take(6)
            ->get();

        return view('public.index', compact('featuredProjects', 'activeProjects'));
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
    public function gallery(Request $request)
    {
        $selectedCategory = $request->get('category', 'all');
        
        $query = GalleryImage::active()->ordered();
        
        if ($selectedCategory && $selectedCategory !== 'all') {
            $query->where('category', $selectedCategory);
        }
        
        $galleryImages = $query->paginate(9)->appends($request->query());
        $categories = GalleryImage::active()->distinct()->pluck('category')->toArray();
        
        return view('public.gallery', compact('galleryImages', 'categories', 'selectedCategory'));
    }
    public function contact()
    {
        return view('public.contact');
    }
}