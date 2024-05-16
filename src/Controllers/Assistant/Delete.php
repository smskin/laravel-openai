<?php

namespace SMSkin\LaravelOpenAi\Controllers\Assistant;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Assistants\AssistantDeleteResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Exceptions\AssistanceNotFound;

class Delete extends BaseController
{
    public function __construct(private readonly string $assistantId)
    {
    }

    /**
     * @return AssistantDeleteResponse
     * @throws AssistanceNotFound
     */
    public function execute(): AssistantDeleteResponse
    {
        try {
            return $this->getClient()->assistants()->delete($this->assistantId);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'No assistant found with id')) {
                throw new AssistanceNotFound($exception->getMessage(), 500, $exception);
            }
            $this->errorExceptionHandler($exception);
        }
    }
}
