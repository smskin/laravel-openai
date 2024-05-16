<?php

use Illuminate\Support\Str;
use OpenAI\Contracts\ClientContract;
use OpenAI\Exceptions\ErrorException;
use SMSkin\LaravelOpenAi\Exceptions\ApiKeyNotProvided;
use SMSkin\LaravelOpenAi\Exceptions\IncorrectApiKey;

abstract class BaseController
{
    protected function getClient(): ClientContract
    {
        return app(ClientContract::class);
    }

    protected function errorExceptionHandler(ErrorException $exception)
    {
        if (Str::contains($exception->getMessage(), 'Incorrect API key provided')) {
            throw new IncorrectApiKey($exception->getMessage(), 500, $exception);
        }
        if (Str::contains($exception->getMessage(), 'You didn\'t provide an API key')) {
            throw new ApiKeyNotProvided($exception->getMessage(), 500, $exception);
        }
        throw new RuntimeException($exception->getMessage(), 500, $exception);
    }
}
