<?php

namespace SMSkin\LaravelOpenAi;

use Illuminate\Support\Collection;
use OpenAI\Responses\Assistants\AssistantDeleteResponse;
use OpenAI\Responses\Assistants\AssistantListResponse;
use OpenAI\Responses\Assistants\AssistantResponse;
use SMSkin\LaravelOpenAi\Contracts\IAssistantFileModule;
use SMSkin\LaravelOpenAi\Contracts\IAssistantModule;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Create;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Delete;
use SMSkin\LaravelOpenAi\Controllers\Assistant\GetList;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Modify;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Retrieve;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Exceptions\AssistanceNotFound;
use SMSkin\LaravelOpenAi\Exceptions\NotValidModel;
use SMSkin\LaravelOpenAi\Exceptions\RetrievalToolNotSupported;
use SMSkin\LaravelOpenAi\Jobs\ExecuteMethodJob;
use SMSkin\LaravelOpenAi\Models\BaseTool;

class AssistantModule implements IAssistantModule
{
    public function getList(int|null $limit = null): AssistantListResponse
    {
        $limit ??= 10;
        return (new GetList($limit))->execute();
    }

    public function getListAsync(string $correlationId, int|null $limit = null, string|null $connection = null, string|null $queue = null): void
    {
        dispatch(new ExecuteMethodJob($correlationId, self::class, 'getList', $connection, $queue, $limit));
    }

    /**
     * @param ModelEnum $model
     * @param string|null $name
     * @param string|null $description
     * @param string|null $instructions
     * @param Collection<BaseTool>|null $tools
     * @return AssistantResponse
     * @throws NotValidModel
     * @throws RetrievalToolNotSupported
     */
    public function create(
        ModelEnum       $model,
        string|null     $name = null,
        string|null     $description = null,
        string|null     $instructions = null,
        Collection|null $tools = null
    ): AssistantResponse {
        return (new Create($model, $name, $description, $instructions, $tools))->execute();
    }

    /**
     * @param string $correlationId
     * @param ModelEnum $model
     * @param string|null $name
     * @param string|null $description
     * @param string|null $instructions
     * @param Collection<BaseTool>|null $tools
     * @param string|null $connection
     * @param string|null $queue
     */
    public function createAsync(
        string          $correlationId,
        ModelEnum       $model,
        string|null     $name = null,
        string|null     $description = null,
        string|null     $instructions = null,
        Collection|null $tools = null,
        string|null     $connection = null,
        string|null     $queue = null
    ): void {
        dispatch(new ExecuteMethodJob($correlationId, self::class, 'create', $connection, $queue, $model, $name, $description, $instructions, $tools));
    }

    /**
     * @throws AssistanceNotFound
     */
    public function retrieve(string $assistantId): AssistantResponse
    {
        return (new Retrieve($assistantId))->execute();
    }

    public function retrieveAsync(string $correlationId, string $assistantId, string|null $connection = null, string|null $queue = null): void
    {
        dispatch(new ExecuteMethodJob($correlationId, self::class, 'retrieve', $connection, $queue, $assistantId));
    }

    /**
     * @param string $assistantId
     * @param string|null $name
     * @param string|null $description
     * @param string|null $instructions
     * @param Collection<BaseTool>|null $tools
     * @return AssistantResponse
     * @throws AssistanceNotFound
     */
    public function modify(
        string          $assistantId,
        string|null     $name = null,
        string|null     $description = null,
        string|null     $instructions = null,
        Collection|null $tools = null
    ): AssistantResponse {
        return (new Modify($assistantId, $name, $description, $instructions, $tools))->execute();
    }

    /**
     * @param string $correlationId
     * @param string $assistantId
     * @param string|null $name
     * @param string|null $description
     * @param string|null $instructions
     * @param Collection<BaseTool>|null $tools
     * @param string|null $connection
     * @param string|null $queue
     */
    public function modifyAsync(
        string          $correlationId,
        string          $assistantId,
        string|null     $name = null,
        string|null     $description = null,
        string|null     $instructions = null,
        Collection|null $tools = null,
        string|null     $connection = null,
        string|null     $queue = null
    ): void {
        dispatch(new ExecuteMethodJob($correlationId, self::class, 'modify', $connection, $queue, $assistantId, $name, $description, $instructions, $tools));
    }

    /**
     * @throws AssistanceNotFound
     */
    public function delete(string $assistantId): AssistantDeleteResponse
    {
        return (new Delete($assistantId))->execute();
    }

    public function deleteAsync(string $correlationId, string $assistantId, string|null $connection = null, string|null $queue = null): void
    {
        dispatch(new ExecuteMethodJob($correlationId, self::class, 'delete', $connection, $queue, $assistantId));
    }

    public function files(): IAssistantFileModule
    {
        return app(IAssistantFileModule::class);
    }
}
