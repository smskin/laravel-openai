<?php

namespace SMSkin\LaravelOpenAi\Controllers\Run\Traits;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use SMSkin\LaravelOpenAi\Exceptions\AssistantNotFound;
use SMSkin\LaravelOpenAi\Exceptions\RunInProcess;
use SMSkin\LaravelOpenAi\Exceptions\VectorStoreIsExpired;

trait CreateExceptionHandlerTrait
{
    /**
     * @throws AssistantNotFound
     * @throws RunInProcess
     * @throws VectorStoreIsExpired
     */
    private function createExceptionHandler(ErrorException $exception): void
    {
        if (Str::contains($exception->getMessage(), 'No assistant found with id')) {
            throw new AssistantNotFound($exception->getMessage(), 500, $exception);
        }
        if (preg_match('/(Thread \w+ already has an active run \w+)/i', $exception->getMessage())) {
            throw new RunInProcess($exception->getMessage(), 500, $exception);
        }
        if (preg_match('/(Vector store \w+ is expired)/i', $exception->getMessage())) {
            throw new VectorStoreIsExpired($exception->getMessage(), 500, $exception);
        }
    }
}
