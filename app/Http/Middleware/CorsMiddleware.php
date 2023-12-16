<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        dd('test');
        $response = $next($request);

        $allowedOrigins = [
            'https://do-track.vercel.app',
            // Add more allowed origins if needed
        ];

        $origin = $request->headers->get('Origin');

        if (in_array($origin, $allowedOrigins)) {
            $response->header('Access-Control-Allow-Origin', $origin);
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
            $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
            $response->header('Access-Control-Allow-Credentials', 'true');
        }

        return $response;
    }
}
