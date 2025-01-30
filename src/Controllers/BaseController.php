<?php

namespace SMSkin\LaravelOpenAi\Controllers;

use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use OpenAI\Client;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Factory;
use SMSkin\LaravelOpenAi\Exceptions\ApiKeyNotProvided;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\IncorrectApiKey;
use SMSkin\LaravelOpenAi\Exceptions\NotSupportedRegion;

abstract class BaseController
{
    protected function getClient(): Client
    {
        return (new Factory())
            ->withApiKey(Config::get('openai.client.api_key'))
            ->withHttpHeader('OpenAI-Beta', 'assistants=v2')
            ->withHttpClient(new \GuzzleHttp\Client([
                RequestOptions::TIMEOUT => Config::get('openai.client.client.timeout', 0),
                RequestOptions::CONNECT_TIMEOUT => Config::get('openai.client.client.connect_timeout', 0),
                RequestOptions::READ_TIMEOUT => Config::get('openai.client.client.read_timeout', ini_get("default_socket_timeout"))
            ]))
            ->make();
    }

    /**
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
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
        if (Str::contains($exception->getMessage(), 'The server had an error processing your request. Sorry about that! You can retry your request, or contact us through our help center at help.openai.com if you keep seeing this error.')) {
            throw new ApiServerHadProcessingError($exception->getMessage(), 500, $exception);
        }
        throw $exception;
    }
}
