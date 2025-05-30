<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'email' => ['required', 'email'],
    //     ]);

    //     // We will send the password reset link to this user. Once we have attempted
    //     // to send the link, we will examine the response then see the message we
    //     // need to show to the user. Finally, we'll send out a proper response.
    //     $status = Password::sendResetLink(
    //         $request->only('email')
    //     );

    //     return $status == Password::RESET_LINK_SENT
    //                 ? back()->with('status', 'Нууц үг сэргээх холбоосыг таны имэйл хаяг руу илгээлээ. Имэйлээ шалгана уу.')
    //                 : back()->withInput($request->only('email'))
    //                         ->withErrors(['email' => 'Энэ имэйл хаягаар бүртгэлтэй хэрэглэгч олдсонгүй.']);
    // }
    public function store(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        // Find user with case-insensitive email match
        $user = User::whereRaw('LOWER(email) = LOWER(?)', [$request->email])->first();

        if (!$user) {
            Log::info('User not found for email: ' . $request->email);
            return back()->withErrors(['email' => 'Энэ имэйл хаягаар бүртгэлтэй хэрэглэгч олдсонгүй.']);
        }

        Log::info('Found user: ' . $user->email);

        try {
            $status = Password::sendResetLink(['email' => $user->email]);

            Log::info('Password reset status: ' . $status);
            Log::info('RESET_LINK_SENT constant: ' . Password::RESET_LINK_SENT);

            if ($status == Password::RESET_LINK_SENT) {
                Log::info('Password reset email should have been sent to: ' . $user->email);
                return back()->with('status', 'Нууц үг сэргээх холбоосыг таны имэйл хаяг руу илгээлээ. Имэйлээ шалгана уу.');
            } else {
                Log::error('Password reset failed with status: ' . $status);
                return back()->withErrors(['email' => __($status)]);
            }

        } catch (\Exception $e) {
            Log::error('Password reset email error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return back()->withErrors(['email' => 'Имэйл илгээхэд алдаа гарлаа. Дахин оролдоно уу.']);
        }
    }

}
