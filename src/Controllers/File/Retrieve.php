<?php

namespace SMSkin\LaravelOpenAi\Controllers\File;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Files\RetrieveResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Controllers\File\Traits\RetrieveExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;

class Retrieve extends BaseController
{
    use RetrieveExceptionHandlerTrait;

    public function __construct(
        private readonly string $id
    ) {
    }

    /**
     * @throws NotFound
     * @throws TransporterException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(): RetrieveResponse
    {
        try {
            return $this->getClient()->files()->retrieve($this->id);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->retrieveExceptionHandler($exception);
            $this->globalExceptionHandler($exception);
        }
    }
}
