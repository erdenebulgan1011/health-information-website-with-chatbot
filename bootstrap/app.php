<?php use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\IsAdmin;
return Application::configure(basePath: dirname(__DIR__))
->withRouting(
    web: __DIR__.'/../routes/web.php',
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
)
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        '2fa' => \App\Http\Middleware\Google2FAMiddleware::class,
        'admin' => IsAdmin::class,
    ]);
    $middleware->web(append: [
        // You could also add it globally here if needed
        // \App\Http\Middleware\Google2FAMiddleware::class,
    ]);
})
->withExceptions(function (Exceptions $exceptions) {
    //
})->create();
