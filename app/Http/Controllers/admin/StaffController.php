<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = auth()->user()->staff()->orderBy('created_at', 'desc')->get();
        return view('admin.staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.staff.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email',
            'phone_number' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'bio' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['exhibitor_id'] = auth()->id();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('staff-profiles', 'public');
        }

        Staff::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Staff member added successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        // Ensure the staff belongs to the authenticated exhibitor
        if ($staff->exhibitor_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        // Ensure the staff belongs to the authenticated exhibitor
        if ($staff->exhibitor_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.staff.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        // Ensure the staff belongs to the authenticated exhibitor
        if ($staff->exhibitor_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'phone_number' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'bio' => 'nullable|string',
        ]);

        $data = $request->all();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image
            if ($staff->profile_image && Storage::exists('public/' . $staff->profile_image)) {
                Storage::delete('public/' . $staff->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('staff-profiles', 'public');
        }

        $staff->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Staff member updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        // Ensure the staff belongs to the authenticated exhibitor
        if ($staff->exhibitor_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        // Delete profile image
        if ($staff->profile_image && Storage::exists('public/' . $staff->profile_image)) {
            Storage::delete('public/' . $staff->profile_image);
        }

        $staff->delete();

        return response()->json([
            'success' => true,
            'message' => 'Staff member deleted successfully!'
        ]);
    }
}
