<?php

return [
    'client' => [
        'api_key' => env('OPENAI_API_KEY'),
        'client' => [
            'timeout' => env('OPENAI_CLIENT_TIMEOUT', 0),
            'connect_timeout' => env('OPENAI_CLIENT_CONNECT_TIMEOUT', 0),
            'read_timeout' => env('OPENAI_CLIENT_READ_TIMEOUT', ini_get('default_socket_timeout')),
        ],
    ],
];
