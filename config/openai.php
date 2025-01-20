<?php

return [
    'client' => [
        'api_key' => env('OPENAI_API_KEY'),
        'request_timeout' => env('OPENAI_REQUEST_TIMEOUT', 0),
    ],
];
