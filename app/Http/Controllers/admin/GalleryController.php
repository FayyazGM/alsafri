<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', '');
        
        $query = GalleryImage::ordered();
        
        if ($filter) {
            $query->where(function($q) use ($filter) {
                $q->where('title', 'like', '%' . $filter . '%')
                  ->orWhere('category', 'like', '%' . $filter . '%')
                  ->orWhere('description', 'like', '%' . $filter . '%');
            });
        }
        
        $images = $query->paginate(10);
        
        return view('admin.gallery', compact('images', 'filter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        $imagePath = $request->file('image')->store('gallery', 'public');

        GalleryImage::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'category' => $request->category,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Gallery image added successfully!'
        ]);
    }

    public function update(Request $request, $id)
    {
        $image = GalleryImage::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active')
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($image->image_path);
            // Store new image
            $data['image_path'] = $request->file('image')->store('gallery', 'public');
        }

        $image->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Gallery image updated successfully!'
        ]);
    }

    public function destroy($id)
    {
        $image = GalleryImage::findOrFail($id);
        
        // Delete image file
        Storage::disk('public')->delete($image->image_path);
        
        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gallery image deleted successfully!'
        ]);
    }
}
