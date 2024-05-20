<?php

use SMSkin\LaravelOpenAi\Api;
use SMSkin\LaravelOpenAi\AssistantFileModule;
use SMSkin\LaravelOpenAi\AssistantModule;
use SMSkin\LaravelOpenAi\AudioModule;
use SMSkin\LaravelOpenAi\ChatModule;
use SMSkin\LaravelOpenAi\CompletionModule;
use SMSkin\LaravelOpenAi\Contracts\IApi;
use SMSkin\LaravelOpenAi\Contracts\IAssistantFileModule;
use SMSkin\LaravelOpenAi\Contracts\IAssistantModule;
use SMSkin\LaravelOpenAi\Contracts\IAudioModule;
use SMSkin\LaravelOpenAi\Contracts\IChatModule;
use SMSkin\LaravelOpenAi\Contracts\ICompletionModule;
use SMSkin\LaravelOpenAi\Contracts\IImageModule;
use SMSkin\LaravelOpenAi\Contracts\IThreadMessageFileModule;
use SMSkin\LaravelOpenAi\Contracts\IThreadMessageModule;
use SMSkin\LaravelOpenAi\Contracts\IThreadModule;
use SMSkin\LaravelOpenAi\Contracts\IThreadRunModule;
use SMSkin\LaravelOpenAi\ImageModule;
use SMSkin\LaravelOpenAi\ThreadMessageFileModule;
use SMSkin\LaravelOpenAi\ThreadMessageModule;
use SMSkin\LaravelOpenAi\ThreadModule;
use SMSkin\LaravelOpenAi\ThreadRunModule;

return [
    'client' => [
        'api_key' => env('OPENAI_API_KEY'),
        'organization' => null,
        'base_uri' => 'api.openai.com/v1',
    ]
];
