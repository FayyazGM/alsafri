<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailSubscription;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:email_subscriptions,email'
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email address is already subscribed.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first('email')
            ], 422);
        }

        try {
            EmailSubscription::create([
                'email' => $request->email,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'subscribed_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you for subscribing! We will keep you updated with our latest news and offers.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }
}
