<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnlyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('admin.login');
        }

        // Get the authenticated user
        $user = auth()->user();

        // Check if user is an exhibitor - if so, deny access to admin routes
        if ($user->user_type === 'exhibitor') {
            return redirect()->route('exhibitor.dashboard')->with('error', 'Access denied. Admin access required.');
        }

        // Allow other user types (admin, staff, consultant, student, etc.)
        return $next($request);
    }
}