<?php

// config/cors.php



return [
    'middleware' => [
        \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        // Other middleware entries...
    ],
    'paths' => ['*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['https://do-track.vercel.app'],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
