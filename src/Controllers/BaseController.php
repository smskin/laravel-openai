<?php

namespace SMSkin\LaravelOpenAi\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use OpenAI;
use OpenAI\Client;
use OpenAI\Exceptions\ErrorException;
use RuntimeException;
use SMSkin\LaravelOpenAi\Exceptions\ApiKeyNotProvided;
use SMSkin\LaravelOpenAi\Exceptions\IncorrectApiKey;
use SMSkin\LaravelOpenAi\Exceptions\NotSupportedRegion;

abstract class BaseController
{
    protected function getClient(): Client
    {
        return OpenAI::client(Config::get('openai.client.api_key'));
    }

    protected function globalExceptionHandler(ErrorException $exception)
    {
        if (Str::contains($exception->getMessage(), 'Incorrect API key provided')) {
            throw new IncorrectApiKey($exception->getMessage(), 500, $exception);
        }
        if (Str::contains($exception->getMessage(), 'You didn\'t provide an API key')) {
            throw new ApiKeyNotProvided($exception->getMessage(), 500, $exception);
        }
        if (Str::contains($exception->getMessage(), 'Country, region, or territory not supported')) {
            throw new NotSupportedRegion($exception->getMessage(), 500, $exception);
        }
        throw new RuntimeException($exception->getMessage(), 500, $exception);
    }
}
