<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile.index', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        // Base validation rules
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|min:8',
        ];

        // Add exhibitor-specific validation rules if user is an exhibitor
        if ($admin->user_type === 'exhibitor') {
            $validationRules = array_merge($validationRules, [
                'university' => 'nullable|string|max:255',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'facebook_url' => 'nullable|url|max:255',
                'instagram_url' => 'nullable|url|max:255',
                'linkedin_url' => 'nullable|url|max:255',
                'youtube_url' => 'nullable|url|max:255',
                'twitter_url' => 'nullable|url|max:255',
            ]);
        }

        $request->validate($validationRules);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        // Add exhibitor-specific fields if user is an exhibitor
        if ($admin->user_type === 'exhibitor') {
            $data['university'] = $request->university;
            $data['facebook_url'] = $request->facebook_url;
            $data['instagram_url'] = $request->instagram_url;
            $data['linkedin_url'] = $request->linkedin_url;
            $data['youtube_url'] = $request->youtube_url;
            $data['twitter_url'] = $request->twitter_url;
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($admin->avatar && Storage::exists('public/' . $admin->avatar)) {
                Storage::delete('public/' . $admin->avatar);
            }
            
            $avatarPath = $request->file('avatar')->store('admin/avatars', 'public');
            $data['avatar'] = $avatarPath;
        }

        // Handle logo upload for exhibitors
        if ($admin->user_type === 'exhibitor' && $request->hasFile('logo')) {
            // Delete old logo if exists
            if ($admin->logo && Storage::exists('public/' . $admin->logo)) {
                Storage::delete('public/' . $admin->logo);
            }
            
            $logoPath = $request->file('logo')->store('admin/logos', 'public');
            $data['logo'] = $logoPath;
        }

        // Update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully'
        ]);
    }
} 