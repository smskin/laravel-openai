<?php


return [
    'client' => [
        'api_key' => env('OPENAI_API_KEY'),
        'organization' => null,
        'base_uri' => 'api.openai.com/v1',
    ],
    'async' => [
        'connection' => env('OPENAI_ASYNC_TASK_CONNECTION'),
        'queue' => env('OPENAI_ASYNC_TASK_QUEUE'),
    ],
];
