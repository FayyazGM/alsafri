<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter', '');
        $query = Project::ordered();
        
        if ($filter) {
            $query->where(function($q) use ($filter) {
                $q->where('title', 'like', '%' . $filter . '%')
                  ->orWhere('category', 'like', '%' . $filter . '%')
                  ->orWhere('client_name', 'like', '%' . $filter . '%')
                  ->orWhere('project_location', 'like', '%' . $filter . '%');
            });
        }
        
        $projects = $query->paginate(10);
        return view('admin.projects', compact('projects', 'filter'));
    }

    /**
     * Store a newly created project
     */
    public function store(Request $request)
    {
        $request->merge([
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active'),
        ]);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'secondary_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'client_name' => 'nullable|string|max:255',
            'project_location' => 'nullable|string|max:255',
            'project_date' => 'nullable|date',
            'project_duration' => 'nullable|string|max:255',
            'project_value' => 'nullable|numeric|min:0',
            'sort_order' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean'
        ]);

        // Handle featured image
        $featuredImagePath = $request->file('featured_image')->store('projects', 'public');

        // Handle secondary image
        $secondaryImagePath = null;
        if ($request->hasFile('secondary_image')) {
            $secondaryImagePath = $request->file('secondary_image')->store('projects', 'public');
        }

        // Handle gallery images
        $galleryImages = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('projects/gallery', 'public');
                $galleryImages[] = [
                    'url' => $path,
                    'alt' => $request->title
                ];
            }
        }

        // Handle features
        $features = [];
        if ($request->has('features')) {
            $features = array_filter($request->input('features', []));
        }

        // Handle progress data
        $progressData = [];
        if ($request->has('progress_labels') && $request->has('progress_percentages')) {
            $labels = $request->input('progress_labels', []);
            $percentages = $request->input('progress_percentages', []);
            
            for ($i = 0; $i < count($labels); $i++) {
                if (!empty($labels[$i]) && isset($percentages[$i])) {
                    $progressData[] = [
                        'label' => $labels[$i],
                        'percentage' => (int)$percentages[$i]
                    ];
                }
            }
        }

        $project = Project::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'additional_content' => $request->additional_content,
            'conclusion' => $request->conclusion,
            'category' => $request->category,
            'featured_image_path' => $featuredImagePath,
            'secondary_image_path' => $secondaryImagePath,
            'gallery_images' => $galleryImages,
            'features' => $features,
            'progress_data' => $progressData,
            'client_name' => $request->client_name,
            'project_location' => $request->project_location,
            'project_date' => $request->project_date,
            'project_duration' => $request->project_duration,
            'project_value' => $request->project_value,
            'sort_order' => $request->sort_order ?? 0,
            'is_featured' => $request->has('is_featured'),
            'is_active' => $request->has('is_active')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Project created successfully!'
        ]);
    }

    /**
     * Update the specified project
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $request->merge([
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active'),
        ]);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'secondary_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'client_name' => 'nullable|string|max:255',
            'project_location' => 'nullable|string|max:255',
            'project_date' => 'nullable|date',
            'project_duration' => 'nullable|string|max:255',
            'project_value' => 'nullable|numeric|min:0',
            'sort_order' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean'
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'additional_content' => $request->additional_content,
            'conclusion' => $request->conclusion,
            'category' => $request->category,
            'client_name' => $request->client_name,
            'project_location' => $request->project_location,
            'project_date' => $request->project_date,
            'project_duration' => $request->project_duration,
            'project_value' => $request->project_value,
            'sort_order' => $request->sort_order ?? 0,
            'is_featured' => $request->has('is_featured'),
            'is_active' => $request->has('is_active')
        ];

        // Handle featured image
        if ($request->hasFile('featured_image')) {
            Storage::disk('public')->delete($project->featured_image_path);
            $data['featured_image_path'] = $request->file('featured_image')->store('projects', 'public');
        }

        // Handle secondary image
        if ($request->hasFile('secondary_image')) {
            if ($project->secondary_image_path) {
                Storage::disk('public')->delete($project->secondary_image_path);
            }
            $data['secondary_image_path'] = $request->file('secondary_image')->store('projects', 'public');
        }

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            // Delete old gallery images
            if ($project->gallery_images) {
                foreach ($project->gallery_images as $image) {
                    Storage::disk('public')->delete($image['url']);
                }
            }

            $galleryImages = [];
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('projects/gallery', 'public');
                $galleryImages[] = [
                    'url' => $path,
                    'alt' => $request->title
                ];
            }
            $data['gallery_images'] = $galleryImages;
        }

        // Handle features
        if ($request->has('features')) {
            $data['features'] = array_filter($request->input('features', []));
        }

        // Handle progress data
        if ($request->has('progress_labels') && $request->has('progress_percentages')) {
            $labels = $request->input('progress_labels', []);
            $percentages = $request->input('progress_percentages', []);
            
            $progressData = [];
            for ($i = 0; $i < count($labels); $i++) {
                if (!empty($labels[$i]) && isset($percentages[$i])) {
                    $progressData[] = [
                        'label' => $labels[$i],
                        'percentage' => (int)$percentages[$i]
                    ];
                }
            }
            $data['progress_data'] = $progressData;
        }

        $project->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Project updated successfully!'
        ]);
    }

    /**
     * Remove the specified project
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        // Delete images
        Storage::disk('public')->delete($project->featured_image_path);
        
        if ($project->secondary_image_path) {
            Storage::disk('public')->delete($project->secondary_image_path);
        }

        if ($project->gallery_images) {
            foreach ($project->gallery_images as $image) {
                Storage::disk('public')->delete($image['url']);
            }
        }

        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully!'
        ]);
    }
}