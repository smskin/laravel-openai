<?php

namespace SMSkin\LaravelOpenAi\Controllers\Assistant\Traits;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use SMSkin\LaravelOpenAi\Exceptions\InvalidFunctionName;
use SMSkin\LaravelOpenAi\Exceptions\InvalidModel;

trait CreateExceptionHandlerTrait
{
    /**
     * @throws InvalidModel
     * @throws InvalidFunctionName
     */
    private function createExceptionHandler(ErrorException $exception): void
    {
        if (Str::contains($exception->getMessage(), 'cannot be used with the Assistants API')) {
            throw new InvalidModel($exception->getMessage(), 500, $exception);
        }
        if (Str::contains($exception->getMessage(), '.function.name\': string does not match pattern')) {
            throw new InvalidFunctionName($exception->getMessage(), 500, $exception);
        }
    }
}
