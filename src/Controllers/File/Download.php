<?php

namespace SMSkin\LaravelOpenAi\Controllers\File;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Exceptions\InvalidPurpose;

class Download extends BaseController
{
    public function __construct(private readonly string $fileId)
    {
    }

    /**
     * @throws InvalidPurpose
     */
    public function execute(): string
    {
        try {
            return $this->getClient()->files()->download($this->fileId);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'Not allowed to download files of purpose')) {
                throw new InvalidPurpose($exception->getMessage(), 500, $exception);
            }
            $this->errorExceptionHandler($exception);
        }
    }
}
