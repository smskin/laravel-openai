<?php

namespace SMSkin\LaravelOpenAi\Controllers\File;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Files\RetrieveResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;

class Retrieve extends BaseController
{
    public function __construct(private readonly string $fileId)
    {
    }

    public function execute(): RetrieveResponse
    {
        try {
            return $this->getClient()->files()->retrieve($this->fileId);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->errorExceptionHandler($exception);
        }
    }
}
