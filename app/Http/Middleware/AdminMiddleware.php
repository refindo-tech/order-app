<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Troubleshooting: Log request ke admin (POST/PUT/PATCH = form submit)
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
            Log::channel('single')->info('[AdminMiddleware] Request form ke admin', [
                'method' => $request->method(),
                'path' => $request->path(),
                'url' => $request->fullUrl(),
            ]);
        }

        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        // Check if user is admin
        if (!Auth::user()->isAdmin()) {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Access denied. Admin privileges required.');
        }

        return $next($request);
    }
}
