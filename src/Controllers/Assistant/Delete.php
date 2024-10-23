<?php

namespace SMSkin\LaravelOpenAi\Controllers\Assistant;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Assistants\AssistantDeleteResponse;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Traits\RetrieveExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;

class Delete extends BaseController
{
    use RetrieveExceptionHandlerTrait;

    public function __construct(private readonly string $id)
    {
    }

    /**
     * @throws NotFound
     */
    public function execute(): AssistantDeleteResponse
    {
        try {
            return $this->getClient()->assistants()->delete(
                $this->id
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->retrieveExceptionHandler($exception);
            $this->globalExceptionHandler($exception);
        }
    }
}
