<?php

namespace SMSkin\LaravelOpenAi\Controllers\Assistant;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Assistants\AssistantResponse;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Traits\RetrieveExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;

class Retrieve extends BaseController
{
    use RetrieveExceptionHandlerTrait;

    public function __construct(private readonly string $id)
    {
    }

    /**
     * @throws NotFound
     * @throws TransporterException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(): AssistantResponse
    {
        try {
            return $this->getClient()->assistants()->retrieve(
                $this->id
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->retrieveExceptionHandler($exception);
            $this->globalExceptionHandler($exception);
        }
    }
}
