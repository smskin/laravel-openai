<?php

namespace SMSkin\LaravelOpenAi\Controllers\File;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Files\DeleteResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;

class Delete extends BaseController
{
    public function __construct(private readonly string $fileId)
    {
    }

    public function execute(): DeleteResponse
    {
        try {
            return $this->getClient()->files()->delete($this->fileId);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->errorExceptionHandler($exception);
        }
    }
}
