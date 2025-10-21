<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExhibitorMiddleware
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

        // Check if user is an exhibitor
        if ($user->user_type !== 'exhibitor') {
            // If not an exhibitor, redirect to dashboard or show 403
            return redirect()->route('admin.dashboard')->with('error', 'Access denied. Exhibitor access required.');
        }

        return $next($request);
    }
}