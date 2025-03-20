<?php

namespace SMSkin\LaravelOpenAi\Controllers\File;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Files\RetrieveResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Controllers\File\Traits\RetrieveExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;

class Retrieve extends BaseController
{
    use RetrieveExceptionHandlerTrait;

    /**
     * @throws NotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(string $id): RetrieveResponse
    {
        try {
            return $this->getClient()->files()->retrieve($id);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->retrieveExceptionHandler($exception);
            $this->globalExceptionHandler($exception);
        }
    }
}
