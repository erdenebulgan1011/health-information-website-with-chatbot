<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    // public function handle(Request $request, Closure $next)
    // {
    //     if (Auth::check() && Auth::user()->isAdmin()) {
    //         return $next($request);
    //     }

    //     return redirect()->route('home')->with('error', 'Танд энэ хэсэгт нэвтрэх эрх хүрэлцэхгүй байна!');
    // }
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is not authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Та эхлээд нэвтэрнэ үү!');
        }

        // Check if user is not admin
        if (!Auth::user()->isAdmin()) {
            // If AJAX request, return JSON response
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Танд энэ хэсэгт нэвтрэх эрх хүрэлцэхгүй байна!'
                ], 403);
            }

            // For web requests, redirect with error message
            return redirect()->route('home')
                ->with('error', 'Танд энэ хэсэгт нэвтрэх эрх хүрэлцэхгүй байна!');
        }

        return $next($request);
    }
}
