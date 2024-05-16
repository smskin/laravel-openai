<?php

namespace SMSkin\LaravelOpenAi\Contracts;

use OpenAI\Responses\Assistants\Files\AssistantFileDeleteResponse;
use OpenAI\Responses\Assistants\Files\AssistantFileListResponse;
use OpenAI\Responses\Assistants\Files\AssistantFileResponse;
use SMSkin\LaravelOpenAi\Exceptions\AssistanceNotFound;
use SMSkin\LaravelOpenAi\Exceptions\FileNotFound;
use SMSkin\LaravelOpenAi\Exceptions\InvalidAssistantConfig;

interface IAssistantFileModule
{
    /**
     * @throws AssistanceNotFound
     */
    public function getList(string $assistantId, int|null $limit = null): AssistantFileListResponse;

    /**
     * @throws InvalidAssistantConfig
     * @throws AssistanceNotFound
     * @throws FileNotFound
     */
    public function create(string $assistantId, string $fileId): AssistantFileResponse;


    /**
     * @throws FileNotFound
     * @throws AssistanceNotFound
     */
    public function retrieve(string $assistantId, string $fileId): AssistantFileResponse;


    /**
     * @throws FileNotFound
     * @throws AssistanceNotFound
     */
    public function delete(string $assistantId, string $fileId): AssistantFileDeleteResponse;
}
