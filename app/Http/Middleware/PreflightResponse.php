<?php

namespace App\Http\Middleware;

use Closure;

class PreflightResponse
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Handle preflight OPTIONS requests
        if ($request->isMethod('OPTIONS')) {
            return response()
                ->setStatusCode(200) // Set your desired status code here
                ->header('Access-Control-Allow-Origin', 'https://do-track.vercel.app')
                ->header('Access-Control-Allow-Methods', 'OPTIONS, POST, GET, PUT, DELETE')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization')
                ->header('Access-Control-Allow-Credentials', 'true');
        }
        return $next($request);
    }
}
