<?php

namespace SMSkin\LaravelOpenAi\Controllers\Thead\Traits;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;

trait RetrieveExceptionHandlerTrait
{
    /**
     * @throws NotFound
     */
    private function retrieveExceptionHandler(ErrorException $exception): void
    {
        if (Str::contains($exception->getMessage(), 'No thread found with id')) {
            throw new NotFound($exception->getMessage(), 500, $exception);
        }
    }
}
