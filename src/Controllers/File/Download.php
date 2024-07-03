<?php

namespace SMSkin\LaravelOpenAi\Controllers\File;

use OpenAI\Exceptions\ErrorException;
use SMSkin\LaravelOpenAi\Controllers\BaseController;

class Download extends BaseController
{
    public function __construct(private readonly string $fileId)
    {
    }

    public function execute(): string
    {
        try {
            return $this->getClient()->files()->download($this->fileId);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->errorExceptionHandler($exception);
        }
    }
}
