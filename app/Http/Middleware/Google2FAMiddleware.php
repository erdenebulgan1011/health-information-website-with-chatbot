<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class Google2FAMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // app/Http/Middleware/Google2FAMiddleware.php
    public function handle(Request $request, Closure $next): Response
    {
        // Allow these routes to bypass the 2FA check
        if ($request->routeIs('2fa.verify', '2fa.validate', '2fa.setup', '2fa.enable', '2fa.disable', '2fa.disable.form')) {
            return $next($request);
        }

        // Only check for authenticated users
        if (Auth::check()) {
            $user = Auth::user();

            // If 2FA is enabled for this user
            if ($user->google2fa_enabled) {
                // If 2FA is not verified in this session
                if (!$request->session()->has('2fa_verified')) {
                    // Store intended URL for later redirect
                    $request->session()->put('url.intended', $request->fullUrl());

                    // Redirect to the 2FA verification page
                    return redirect()->route('2fa.verify');
                }

                // Check if the verification has expired
                $verifiedAt = $request->session()->get('2fa_verified');
                if ($verifiedAt && now()->gt($verifiedAt)) {
                    // Clear expired verification
                    $request->session()->forget('2fa_verified');

                    // Store intended URL for later redirect
                    $request->session()->put('url.intended', $request->fullUrl());

                    // Redirect to the 2FA verification page
                    return redirect()->route('2fa.verify');
                }
            }
        }

        return $next($request);
    }
    }
