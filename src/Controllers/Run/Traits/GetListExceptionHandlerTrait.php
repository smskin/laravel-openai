<?php

namespace SMSkin\LaravelOpenAi\Controllers\Run\Traits;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;

trait GetListExceptionHandlerTrait
{
    /**
     * @throws ThreadNotFound
     */
    private function getListExceptionHandler(ErrorException $exception): void
    {
        if (Str::contains($exception->getMessage(), 'No thread found with id')) {
            throw new ThreadNotFound($exception->getMessage(), 500, $exception);
        }
    }
}
