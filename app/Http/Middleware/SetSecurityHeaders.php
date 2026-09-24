<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetSecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        if (app()->isProduction()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=63072000; includeSubDomains; preload');
        }

        // Alpine.js requires unsafe-inline + unsafe-eval; Unsplash images are used in the trip planner form.
        $csp = implode(' ', [
            "default-src 'self';",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval';",
            "style-src 'self' 'unsafe-inline';",
            "img-src 'self' data: https://images.unsplash.com https://og.tailwindui.com;",
            "font-src 'self' data:;",
            "connect-src 'self';",
            "frame-src 'none';",
            "frame-ancestors 'self';",
            "base-uri 'self';",
            "form-action 'self';",
        ]);

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
