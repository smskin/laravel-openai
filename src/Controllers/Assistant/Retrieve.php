<?php

namespace SMSkin\LaravelOpenAi\Controllers\Assistant;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Assistants\AssistantResponse;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Traits\RetrieveExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
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
    public function execute(string $id): AssistantResponse
    {
        try {
            return $this->getClient()->assistants()->retrieve($id);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->retrieveExceptionHandler($exception);
            $this->globalExceptionHandler($exception);
        }
    }
}
