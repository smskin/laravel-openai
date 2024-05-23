<?php

namespace SMSkin\LaravelOpenAi;

use OpenAI\Responses\Assistants\Files\AssistantFileDeleteResponse;
use OpenAI\Responses\Assistants\Files\AssistantFileListResponse;
use OpenAI\Responses\Assistants\Files\AssistantFileResponse;
use SMSkin\LaravelOpenAi\Contracts\IAssistantFileModule;
use SMSkin\LaravelOpenAi\Controllers\AssistantFile\Create;
use SMSkin\LaravelOpenAi\Controllers\AssistantFile\Delete;
use SMSkin\LaravelOpenAi\Controllers\AssistantFile\GetList;
use SMSkin\LaravelOpenAi\Controllers\AssistantFile\Retrieve;
use SMSkin\LaravelOpenAi\Exceptions\AssistanceNotFound;
use SMSkin\LaravelOpenAi\Exceptions\FileNotFound;
use SMSkin\LaravelOpenAi\Exceptions\InvalidAssistantConfig;
use SMSkin\LaravelOpenAi\Jobs\ExecuteMethodJob;

class AssistantFileModule implements IAssistantFileModule
{
    /**
     * @throws AssistanceNotFound
     */
    public function getList(string $assistantId, int|null $limit = null): AssistantFileListResponse
    {
        $limit ??= 10;
        return (new GetList($assistantId, $limit))->execute();
    }

    public function getListAsync(string $correlationId, string $assistantId, int|null $limit = null, string|null $connection = null, string|null $queue = null): void
    {
        dispatch(new ExecuteMethodJob($correlationId, self::class, 'getList', $connection, $queue, $assistantId, $limit));
    }

    /**
     * @throws InvalidAssistantConfig
     * @throws AssistanceNotFound
     * @throws FileNotFound
     */
    public function create(string $assistantId, string $fileId): AssistantFileResponse
    {
        return (new Create($assistantId, $fileId))->execute();
    }

    public function createAsync(string $correlationId, string $assistantId, string $fileId, string|null $connection = null, string|null $queue = null): void
    {
        dispatch(new ExecuteMethodJob($correlationId, self::class, 'create', $connection, $queue, $assistantId, $fileId));
    }

    /**
     * @throws FileNotFound
     * @throws AssistanceNotFound
     */
    public function retrieve(string $assistantId, string $fileId): AssistantFileResponse
    {
        return (new Retrieve($assistantId, $fileId))->execute();
    }

    public function retrieveAsync(string $correlationId, string $assistantId, string $fileId, string|null $connection = null, string|null $queue = null): void
    {
        dispatch(new ExecuteMethodJob($correlationId, self::class, 'retrieve', $connection, $queue, $assistantId, $fileId));
    }

    /**
     * @throws FileNotFound
     * @throws AssistanceNotFound
     */
    public function delete(string $assistantId, string $fileId): AssistantFileDeleteResponse
    {
        return (new Delete($assistantId, $fileId))->execute();
    }

    public function deleteAsync(string $correlationId, string $assistantId, string $fileId, string|null $connection = null, string|null $queue = null): void
    {
        dispatch(new ExecuteMethodJob($correlationId, self::class, 'delete', $connection, $queue, $assistantId, $fileId));
    }
}
