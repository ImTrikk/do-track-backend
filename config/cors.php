<?php

// config/cors.php



return [
    'paths' => ['*'],
    'allowed_methods' => ['*'],
    'Access-Control-Allow-Origin' => ['*'],
    'allowed_origins' => ['https://do-track.vercel.app'],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
