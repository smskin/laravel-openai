<?php

namespace SMSkin\LaravelOpenAi\Controllers\VectorStore\Traits;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;
use SMSkin\LaravelOpenAi\Exceptions\VectorStoreIsExpired;

trait VectorStoreExceptionTrait
{
    /**
     * @throws VectorStoreIsExpired
     * @throws NotFound
     */
    private function vectorStoreExceptionHandler(ErrorException $exception): void
    {
        if (
            Str::contains($exception->getMessage(), 'Expected an ID that begins with') ||
            Str::contains($exception->getMessage(), 'No vector store found with id')
        ) {
            throw new NotFound($exception->getMessage(), 500, $exception);
        }
        if (preg_match('/(Vector store \'\w+\' has expired)/i', $exception->getMessage())) {
            throw new VectorStoreIsExpired($exception->getMessage(), 500, $exception);
        }
    }
}
