<?php

return [

    'paths' => ['api/*', 'onlyoffice/*', 'documents/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'], // Allow all HTTP methods

    'allowed_origins' => [
        'http://127.0.0.1:8000', // ONLYOFFICE Document Server origin
        // Add more origins if necessary
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Allow all headers

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false, // Set to true if you're using credentials (e.g., cookies)
];

