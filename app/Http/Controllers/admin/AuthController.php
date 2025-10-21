<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Models\Admin;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function login_request(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::guard('admin')->user();
            
            // Determine redirect URL based on user type
            $redirectUrl = $user->user_type === 'exhibitor' 
                ? route('exhibitor.dashboard') 
                : route('admin-dashboard');
            
            $welcomeMessage = $user->user_type === 'exhibitor' 
                ? 'Welcome to IEO Exhibitor Dashboard' 
                : 'Welcome to IEO Admin Dashboard';
            
            return response()->json([
                'success' => true,
                'message' => $welcomeMessage,
                'redirect_url' => $redirectUrl
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Email or Password is Incorrect'
            ]);
        }
    }

    public function logout()
    {
        auth('admin')->logout();
        return redirect()->route('admin-login');
    }

    public function forgotPassword()
    {
        return view('admin.forgot-password');
    }

    public function sendForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin) {
            $activation_token = bin2hex(random_bytes(16));
            $resetLink = route('admin.password.reset', ['token' => $activation_token]) . '?email=' . urlencode($admin->email);

            // Save the token and its expiry time
            $admin->activation_token = $activation_token;
            $admin->activation_token_expires_at = now()->addHours(1);
            $admin->save();

            // Send password reset email
            Mail::send('emails.admin.reset-password', ['resetLink' => $resetLink], function ($message) use ($admin) {
                $message->to($admin->email)
                        ->subject('Reset Your Password - IEO Admin');
            });

            return response()->json([
                'success' => true,
                'message' => 'If your email exists in our system, a password reset link has been sent.',
            ]);
        }

        // Generic response for both found/not found (for security)
        return response()->json([
            'success' => true,
            'message' => 'If your email exists in our system, a password reset link has been sent.',
        ]);
    }

    public function resetPassword($token)
    {
        $email = request()->query('email');
        return view('admin.reset-password', compact('token', 'email'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $admin = Admin::where('email', $request->email)
            ->where('activation_token', $request->token)
            ->where('activation_token_expires_at', '>', now())
            ->first();

        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired password reset link.'
            ]);
        }

        $admin->password = Hash::make($request->password);
        $admin->activation_token = null;
        $admin->activation_token_expires_at = null;
        $admin->save();

        return response()->json([
            'success' => true,
            'message' => 'Password has been reset successfully. You can now log in.'
        ]);
    }
}
