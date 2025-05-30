<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/testhome112233';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    protected function authenticated(Request $request, $user)
{

     // Check if user is admin and redirect accordingly
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Админ хэсэгт тавтай морил!');
        }

    // Check if 2FA is enabled for this user
    if ($user->google2fa_enabled) {
        // Redirect to 2FA verification
        return redirect()->route('2fa.verify');
    }

    // Default redirect
    return redirect()->intended($this->redirectPath());
}
}
