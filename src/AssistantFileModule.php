<?php

namespace SMSkin\LaravelOpenAi;

use OpenAI\Responses\Assistants\Files\AssistantFileDeleteResponse;
use OpenAI\Responses\Assistants\Files\AssistantFileResponse;
use SMSkin\LaravelOpenAi\Controllers\AssistantFile\Create;
use SMSkin\LaravelOpenAi\Controllers\AssistantFile\Delete;
use SMSkin\LaravelOpenAi\Controllers\AssistantFile\Retrieve;
use SMSkin\LaravelOpenAi\Exceptions\AssistanceNotFound;
use SMSkin\LaravelOpenAi\Exceptions\FileNotFound;
use SMSkin\LaravelOpenAi\Exceptions\InvalidAssistantConfig;

class AssistantFileModule
{
    /**
     * @throws InvalidAssistantConfig
     * @throws AssistanceNotFound
     * @throws FileNotFound
     */
    public function create(string $assistantId, string $fileId): AssistantFileResponse
    {
        return (new Create($assistantId, $fileId))->execute();
    }

    /**
     * @throws FileNotFound
     * @throws AssistanceNotFound
     */
    public function retrieve(string $assistantId, string $fileId): AssistantFileResponse
    {
        return (new Retrieve($assistantId, $fileId))->execute();
    }

    /**
     * @throws FileNotFound
     * @throws AssistanceNotFound
     */
    public function delete(string $assistantId, string $fileId): AssistantFileDeleteResponse
    {
        return (new Delete($assistantId, $fileId))->execute();
    }
}
