<?php

use App\Http\Middleware\SecurityHeaders;
use App\Models\Redirect;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            SecurityHeaders::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // Honour stored 301 redirects before showing a 404 (FR15).
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            $redirect = Redirect::query()
                ->where('from_path', '/'.ltrim($request->path(), '/'))
                ->first();

            if ($redirect !== null) {
                return redirect($redirect->to_path, 301);
            }
        });
    })->create();
