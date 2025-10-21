<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function view(Request $request)
    {
        $users = Admin::query()->where('user_type' , '!=', 'super_admin');
        $filter = null;

        if ($request->filled('filter')) {
            $filter = $request->filter;
            $users = $users->where(function($query) use ($filter) {
                $query->where('name', 'like', '%' . $filter . '%')
                      ->orWhere('email', 'like', '%' . $filter . '%')
                      ->orWhere('user_type', 'like', '%' . $filter . '%')
                      ->orWhere('phone' , 'like' , '%' . $filter . '%');
            });
        }

        // Get countries and universities for the forms
        $countries = DB::table('countries')->where('is_active', true)->orderBy('name')->get();
        $universities = DB::connection('mysql2')->table('tbl_universities')->orderBy('name', 'ASC')->get();

        $data['filter'] = $filter;
        $data['users'] = $users->orderBy('name', 'ASC')->paginate(25);
        $data['countries'] = $countries;
        $data['universities'] = $universities;
        return view('admin.manage-users', $data);
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:admins,email',
            'user_type' => 'required|string',
            'password' => 'required|string|min:8',
            'avatar' => 'nullable|image',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'country_id' => 'nullable|exists:countries,id',
            'university' => 'nullable|string',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('users', 'public');
        }

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => $request->user_type,
            'password' => Hash::make($request->password),
            'avatar' => $avatarPath,
            'address' => $request->address,
            'phone' => $request->phone,
            'country_id' => $request->country_id,
            'university' => $request->university,
        ]);

        return response()->json(['success' => true, 'message' => 'User added successfully.']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:admins,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:admins,email,'.$request->id,
            'user_type' => 'required|string',
            'password' => 'nullable|string|min:8',
            'avatar' => 'nullable|image',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'country_id' => 'nullable|exists:countries,id',
            'university' => 'nullable|string',
        ]);

        $user = Admin::findOrFail($request->id);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => $request->user_type,
            'address' => $request->address,
            'phone' => $request->phone,
            'country_id' => $request->country_id,
            'university' => $request->university,
        ];

        // Update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        // Update avatar if provided
        if ($request->hasFile('avatar')) {
            // Delete old avatar if it exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('users', 'public');
            $updateData['avatar'] = $avatarPath;
        }

        $user->update($updateData);

        return response()->json(['success' => true, 'message' => 'User updated successfully.']);
    }
}
