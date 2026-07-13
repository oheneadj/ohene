<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Adds baseline security response headers site-wide (NFR4).
 *
 * HSTS is only sent over HTTPS (sending it on plain HTTP is meaningless and can
 * pin the wrong scheme). A Content-Security-Policy is intentionally left out for
 * now — it needs per-source tuning against Vite/Livewire/Google Fonts and is
 * tracked as a follow-up rather than shipped half-configured.
 */
class SecurityHeaders
{
    /**
     * Attach the security headers to the outgoing response.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');

        if ($request->secure()) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains; preload',
            );
        }

        return $response;
    }
}
