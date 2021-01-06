<?php

namespace App\Http\Middleware;

use Closure;

class SecureHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof \Symfony\Component\HttpFoundation\BinaryFileResponse) {}
        else {
            $response->header('Cache-control', 'no-store, private');
            $response->header('Pragma', 'no-cache');
//            $response->header('Content-Security-Policy', 'script-src \'self\' ' . $request->getHost());
            $response->header('X-Frame-Options', 'SAMEORIGIN');
            $response->header('X-XSS-Protection', '1; mode=block');
            $response->header('X-Content-Type-Options', 'nosniff');
            $response->header('Referrer-Policy', 'no-referrer');
//            $response->header('Feature-Policy', 'vibrate \'none\'; geolocation \'none\'');
            $response->header('Feature-Policy', 'geolocation \'none\'');
        }

        return $response;
    }
}
