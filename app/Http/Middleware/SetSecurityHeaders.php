<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Vite;
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

        // Local `composer run dev` serves assets from the Vite dev server; never allowed in production.
        $vite = '';
        if (! app()->isProduction() && Vite::isRunningHot()) {
            $origin = rtrim((string) file_get_contents(Vite::hotFile()));
            $vite = ' '.$origin.' '.preg_replace('#^http#', 'ws', $origin);
        }

        // Alpine.js requires unsafe-inline + unsafe-eval; Unsplash images are used in the trip planner form;
        // blob: lets the admin preview a photo before uploading it.
        $csp = implode(' ', [
            "default-src 'self';",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval'{$vite};",
            "style-src 'self' 'unsafe-inline'{$vite};",
            "img-src 'self' data: blob: https://images.unsplash.com https://og.tailwindui.com{$vite};",
            "font-src 'self' data:{$vite};",
            "connect-src 'self'{$vite};",
            "frame-src 'none';",
            "frame-ancestors 'self';",
            "base-uri 'self';",
            "form-action 'self';",
        ]);

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
