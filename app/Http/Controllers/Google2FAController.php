<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Google2FAQRCode\Google2FA;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Google2FAController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the 2FA setup page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    // public function diagnose(Request $request)
    // {
    //     if (!Auth::check()) {
    //         return redirect()->route('login')->withErrors(['auth' => 'Please login first']);
    //     }

    //     $output = [];
    //     $user = Auth::user();

    //     $output[] = "User ID: {$user->id}";
    //     $output[] = "Email: {$user->email}";

    //     // Check middleware registration
    //     $output[] = "Checking middleware registration...";
    //     $router = app('router');

    //     // Laravel 10/11 compatibility
    //     try {
    //         // Try to access middleware information using reflection
    //         $reflection = new \ReflectionClass($router);

    //         $middlewareProperty = null;
    //         if ($reflection->hasProperty('middleware')) {
    //             $middlewareProperty = $reflection->getProperty('middleware');
    //             $middlewareProperty->setAccessible(true);
    //             $middleware = $middlewareProperty->getValue($router);
    //             $output[] = "Middleware:";
    //             $output[] = print_r($middleware, true);
    //         } else {
    //             $output[] = "Middleware: Unable to access middleware property";
    //         }

    //         $middlewareGroupsProperty = null;
    //         if ($reflection->hasProperty('middlewareGroups')) {
    //             $middlewareGroupsProperty = $reflection->getProperty('middlewareGroups');
    //             $middlewareGroupsProperty->setAccessible(true);
    //             $middlewareGroups = $middlewareGroupsProperty->getValue($router);
    //             $output[] = "Middleware groups:";
    //             $output[] = print_r($middlewareGroups, true);
    //         } else {
    //             $output[] = "Middleware groups: Unable to access middlewareGroups property";
    //         }

    //         // Check if the 2FA middleware is registered at application level
    //         $kernel = app(\Illuminate\Contracts\Http\Kernel::class);
    //         $reflectionKernel = new \ReflectionClass($kernel);

    //         // Check middleware property in kernel
    //         if ($reflectionKernel->hasProperty('middleware')) {
    //             $kernelMiddlewareProperty = $reflectionKernel->getProperty('middleware');
    //             $kernelMiddlewareProperty->setAccessible(true);
    //             $kernelMiddleware = $kernelMiddlewareProperty->getValue($kernel);
    //             $output[] = "Kernel middleware:";
    //             $output[] = print_r($kernelMiddleware, true);
    //         } else {
    //             $output[] = "Kernel middleware: Unable to access middleware property";
    //         }

    //         // Check middlewareGroups property in kernel
    //         if ($reflectionKernel->hasProperty('middlewareGroups')) {
    //             $kernelMiddlewareGroupsProperty = $reflectionKernel->getProperty('middlewareGroups');
    //             $kernelMiddlewareGroupsProperty->setAccessible(true);
    //             $kernelMiddlewareGroups = $kernelMiddlewareGroupsProperty->getValue($kernel);
    //             $output[] = "Kernel middleware groups:";
    //             $output[] = print_r($kernelMiddlewareGroups, true);
    //         } else {
    //             $output[] = "Kernel middleware groups: Unable to access middlewareGroups property";
    //         }

    //         // Direct check for Google2FAMiddleware
    //         $output[] = "Direct check for Google2FAMiddleware registration:";
    //         $found = false;

    //         // Check Laravel's middleware aliases
    //         try {
    //             $aliases = config('app.aliases', []);
    //             if (isset($aliases['2fa']) || array_search('App\\Http\\Middleware\\Google2FAMiddleware', $aliases) !== false) {
    //                 $output[] = "Found in app.aliases config";
    //                 $found = true;
    //             }
    //         } catch (\Exception $e) {
    //             $output[] = "Error checking app.aliases: " . $e->getMessage();
    //         }

    //         // Try to get middleware groups through app config
    //         try {
    //             $webMiddleware = config('app.middleware.web', []);
    //             if (in_array('App\\Http\\Middleware\\Google2FAMiddleware', $webMiddleware)) {
    //                 $output[] = "Found in web middleware group via config";
    //                 $found = true;
    //             }
    //         } catch (\Exception $e) {
    //             $output[] = "Error checking web middleware config: " . $e->getMessage();
    //         }

    //         if (!$found) {
    //             $output[] = "Google2FAMiddleware not found in standard registration locations";
    //         }

    //     } catch (\Exception $e) {
    //         $output[] = "Error accessing middleware configuration: " . $e->getMessage();
    //     }

    //     // Check 2FA configuration in database
    //     $output[] = "Checking database 2FA configuration...";
    //     try {
    //         $google2faSecret = DB::table('users')
    //             ->where('id', $user->id)
    //             ->value('google2fa_secret');

    //         $google2faEnabled = DB::table('users')
    //             ->where('id', $user->id)
    //             ->value('google2fa_enabled');

    //         $output[] = "2FA Enabled in DB: " . ($google2faEnabled ? 'Yes' : 'No');
    //         $output[] = "2FA Secret exists: " . ($google2faSecret ? 'Yes' : 'No');

    //         if ($google2faSecret) {
    //             try {
    //                 // Try to decrypt the secret (this might throw an exception if encryption key issues)
    //                 $decryptedSecret = decrypt($google2faSecret);
    //                 $output[] = "Secret decryption: Success";

    //                 // Validate secret format
    //                 if (strlen($decryptedSecret) == 16) {
    //                     $output[] = "Secret format: Valid (16 characters)";
    //                 } else {
    //                     $output[] = "Secret format: Invalid (should be 16 chars, got " . strlen($decryptedSecret) . ")";
    //                 }

    //                 // Test Google2FA library
    //                 $google2fa = new Google2FA();
    //                 $currentOtp = $google2fa->getCurrentOtp($decryptedSecret);
    //                 $output[] = "Current OTP generation: Success - " . $currentOtp;
    //             } catch (\Exception $e) {
    //                 $output[] = "Decryption error: " . $e->getMessage();

    //                 // Application key might have changed
    //                 $output[] = "APP_KEY in .env: " . substr(env('APP_KEY'), 0, 10) . "...";
    //             }
    //         }
    //     } catch (\Exception $e) {
    //         $output[] = "Database error: " . $e->getMessage();
    //     }

    //     // Check session configuration
    //     $output[] = "Session driver: " . config('session.driver');
    //     $output[] = "Session lifetime: " . config('session.lifetime') . " minutes";

    //     // Check if Google2FAMiddleware exists
    //     $middlewarePath = app_path('Http/Middleware/Google2FAMiddleware.php');
    //     $output[] = "Google2FAMiddleware file exists: " . (file_exists($middlewarePath) ? 'Yes' : 'No');

    //     if (file_exists($middlewarePath)) {
    //         $output[] = "Google2FAMiddleware contents:";
    //         $output[] = "---------------------------------";
    //         $output[] = file_get_contents($middlewarePath);
    //         $output[] = "---------------------------------";
    //     }

    //     // Check route configuration - Laravel 10/11 compatible
    //     $output[] = "Route configuration:";

    //     try {
    //         $routes = app('router')->getRoutes();

    //         // Find 2FA routes
    //         $twoFaRoutes = [];
    //         foreach ($routes as $route) {
    //             $name = $route->getName();
    //             if ($name && strpos($name, '2fa') !== false) {
    //                 $middleware = $route->middleware();
    //                 $action = $route->getActionName();
    //                 $uri = $route->uri();

    //                 $twoFaRoutes[] = [
    //                     'name' => $name,
    //                     'uri' => $uri,
    //                     'middleware' => $middleware,
    //                     'action' => $action
    //                 ];
    //             }
    //         }

    //         if (empty($twoFaRoutes)) {
    //             $output[] = "No 2FA routes found!";
    //         } else {
    //             foreach ($twoFaRoutes as $route) {
    //                 $output[] = "Route: {$route['name']}";
    //                 $output[] = "  URI: {$route['uri']}";
    //                 $output[] = "  Middleware: " . implode(', ', $route['middleware']);
    //                 $output[] = "  Action: {$route['action']}";
    //                 $output[] = "------";
    //             }
    //         }
    //     } catch (\Exception $e) {
    //         $output[] = "Error accessing routes: " . $e->getMessage();
    //     }

    //     // Test Google2FA library functionality
    //     $output[] = "\nTesting Google2FA Library:";
    //     try {
    //         $google2fa = new Google2FA();
    //         $testSecret = $google2fa->generateSecretKey();
    //         $output[] = "Generated test secret: " . $testSecret;

    //         // Test QR code generation
    //         try {
    //             $qrCodeUrl = $google2fa->getQRCodeUrl(
    //                 'Test App',
    //                 'test@example.com',
    //                 $testSecret
    //             );
    //             $output[] = "QR code URL generation: Success";
    //             $output[] = "URL: " . $qrCodeUrl;
    //         } catch (\Exception $e) {
    //             $output[] = "QR code URL generation failed: " . $e->getMessage();
    //         }

    //         // Test current OTP generation
    //         try {
    //             $currentOtp = $google2fa->getCurrentOtp($testSecret);
    //             $output[] = "Current OTP generation: Success - " . $currentOtp;
    //         } catch (\Exception $e) {
    //             $output[] = "OTP generation failed: " . $e->getMessage();
    //         }

    //     } catch (\Exception $e) {
    //         $output[] = "Google2FA library test failed: " . $e->getMessage();
    //     }

    //     // Log all information for later reference
    //     Log::info('2FA Diagnostic Report', ['data' => $output]);

    //     return response()->view('auth.2fa.2fa', ['output' => $output]);
    // }

public function setup(Request $request)
{
    // Debug message to verify the method is being called
    \Log::debug('2FA Setup method called');

    $google2fa = new Google2FA();
    $secret = $google2fa->generateSecretKey();
    $userCode  =  $google2fa->getCurrentOtp($secret);

    \Log::debug('usercode is ', ['secret' => $userCode]);

    // Store secret temporarily in session
    $request->session()->put('2fa_secret', $secret);

    // Generate TOTP URI
    $totpUrl = $google2fa->getQRCodeUrl(
        config('app.name'),
        $request->user()->email,
        $secret
    );

    // Generate SVG QR code
    $renderer = new ImageRenderer(
        new RendererStyle(200),  // Reduced size for better compatibility
        new SvgImageBackEnd()
    );

    $writer = new Writer($renderer);
    $qrCode = $writer->writeString($totpUrl);
    \Log::debug('Setup Secret: '.$secret);

    return view('auth.2fa.setup', [
        'qrCode' => $qrCode,
        'secret' => $secret
    ]);
}
    /**
     * Enable 2FA for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enable(Request $request)
    {
        // dd($request);
        $request->validate([
            'code' => 'required|digits:6',
            'secret' => 'required|string',
            'password' => 'required'
        ]);
        \Log::debug('Pre‑verify code from session', ['secret' => $request->code]);

        $user = Auth::user();

        // Verify the user's password for security
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Invalid password']);
        }

        // Verify the TOTP code
        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($request->secret, $request->code, 2);
        \Log::debug('Pre‑verify secret from session', ['secret' => $request->secret]);

        if (!$valid) {
            return back()->withErrors(['code' => 'Invalid authentication code']);
        }

        // Update directly without trying to use the model's accessor
        \DB::table('users')
            ->where('id', $user->id)
            ->update([
                'google2fa_secret' => encrypt($request->secret),
                'google2fa_enabled' => true
            ]);

        \Log::debug('Secret stored successfully: ' . $request->secret);

        return redirect()->route('profile.show')->with('status', 'Two-factor authentication has been enabled.');
    }

    /**
     * Disable 2FA for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disable(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password'
        ]);

        $user = $request->user();

        // Update directly without using the model
        \DB::table('users')
            ->where('id', $user->id)
            ->update([
                'google2fa_secret' => null,
                'google2fa_enabled' => false
            ]);

        // Clear verification status
        $request->session()->forget('2fa_verified');

        return redirect()->route('profile')->with('status', [
            'type' => 'success',
            'message' => 'Two-factor authentication disabled successfully!'
        ]);
    }

    /**
     * Show the 2FA verification page after login.
     *
     * @return \Illuminate\View\View
     */
    public function verify()
    {
        // Allow access only for unverified 2FA users
        if (!Auth::check() || session()->has('2fa_verified')) {
            return redirect()->intended('/');
        }

        return view('auth.2fa.verify');
    }

    /**
     * Validate the 2FA code after login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function validateCode(Request $request)
    {
        // dd($request);
        $request->validate(['code' => 'required|digits:6']);

        $user = $request->user();
        \Log::debug('Starting validation for user: ' . $user->email);

        // Get the encrypted secret directly from DB
        $encryptedSecret = \DB::table('users')
            ->where('id', $user->id)
            ->value('google2fa_secret');

        if (!$encryptedSecret) {
            \Log::debug('No 2FA secret found for user');
            return redirect()->route('2fa.setup')->withErrors([
                'auth' => '2FA not configured properly'
            ]);
        }

        try {
            // Decrypt the secret
            $decryptedSecret = decrypt($encryptedSecret);
            \Log::debug('Decrypted secret: ' . $decryptedSecret);

            $google2fa = new Google2FA();

            // Try verification with window parameter to account for time drift
            $valid = $google2fa->verifyKey($decryptedSecret, $request->code, 8); // 8 windows = 4 minutes
            \Log::debug('Verification result: ' . ($valid ? 'Valid' : 'Invalid'));

            if ($valid) {
                $request->session()->put('2fa_verified', now()->addMinutes(120));
                \Log::debug('2FA verification successful, redirecting to dashboard');
                return redirect()->intended('/dashboard');
            }

        } catch (\Exception $e) {
            \Log::error('2FA validation error: ' . $e->getMessage());
            return back()->withErrors(['code' => 'System error: ' . $e->getMessage()]);
        }

        \Log::debug('Code validation failed');
        return back()->withErrors(['code' => 'Invalid code. Make sure your device time is synced correctly.']);
    }
}
