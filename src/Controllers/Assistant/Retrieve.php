<?php

namespace SMSkin\LaravelOpenAi\Controllers\Assistant;

use BaseController;
use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Assistants\AssistantResponse;
use SMSkin\LaravelOpenAi\Exceptions\AssistanceNotFound;

class Retrieve extends BaseController
{
    public function __construct(private readonly string $assistantId)
    {
    }

    /**
     * @throws AssistanceNotFound
     */
    public function execute(): AssistantResponse
    {
        try {
            return $this->getClient()->assistants()->retrieve($this->assistantId);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'No assistant found with id')) {
                throw new AssistanceNotFound($exception->getMessage(), 500, $exception);
            }
            $this->errorExceptionHandler($exception);
        }
    }
}
