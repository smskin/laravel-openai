<?php

namespace SMSkin\LaravelOpenAi;

use Illuminate\Support\Collection;
use OpenAI\Responses\Threads\Runs\ThreadRunResponse;
use OpenAI\Responses\Threads\ThreadDeleteResponse;
use OpenAI\Responses\Threads\ThreadResponse;
use SMSkin\LaravelOpenAi\Contracts\IThreadMessageModule;
use SMSkin\LaravelOpenAi\Contracts\IThreadModule;
use SMSkin\LaravelOpenAi\Contracts\IThreadRunModule;
use SMSkin\LaravelOpenAi\Controllers\Thread\Create;
use SMSkin\LaravelOpenAi\Controllers\Thread\CreateAndRun;
use SMSkin\LaravelOpenAi\Controllers\Thread\Delete;
use SMSkin\LaravelOpenAi\Controllers\Thread\Modify;
use SMSkin\LaravelOpenAi\Controllers\Thread\Retrieve;
use SMSkin\LaravelOpenAi\Exceptions\AssistanceNotFound;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Jobs\ExecuteMethodJob;
use SMSkin\LaravelOpenAi\Models\ChatMessage;
use SMSkin\LaravelOpenAi\Models\MetaData;

class ThreadModule implements IThreadModule
{
    /**
     * @param Collection<ChatMessage>|null $messages
     * @param MetaData|null $metaData
     * @return ThreadResponse
     */
    public function create(
        Collection|null $messages = null,
        MetaData|null   $metaData = null
    ): ThreadResponse {
        return (new Create($messages, $metaData))->execute();
    }

    /**
     * @param string $correlationId
     * @param Collection<ChatMessage>|null $messages
     * @param MetaData|null $metaData
     * @param string|null $connection
     * @param string|null $queue
     * @return void
     */
    public function createAsync(
        string          $correlationId,
        Collection|null $messages = null,
        MetaData|null   $metaData = null,
        string|null     $connection = null,
        string|null     $queue = null
    ): void {
        dispatch(new ExecuteMethodJob($correlationId, self::class, 'create', $connection, $queue, $messages, $metaData));
    }

    /**
     * @param string $assistantId
     * @param Collection<ChatMessage>|null $messages
     * @param MetaData|null $metaData
     * @return ThreadRunResponse
     * @throws AssistanceNotFound
     */
    public function createAndRun(
        string          $assistantId,
        Collection|null $messages = null,
        MetaData|null   $metaData = null
    ): ThreadRunResponse {
        return (new CreateAndRun($assistantId, $messages, $metaData))->execute();
    }

    /**
     * @param string $correlationId
     * @param string $assistantId
     * @param Collection<ChatMessage>|null $messages
     * @param MetaData|null $metaData
     * @param string|null $connection
     * @param string|null $queue
     * @return void
     */
    public function createAndRunAsync(
        string          $correlationId,
        string          $assistantId,
        Collection|null $messages = null,
        MetaData|null   $metaData = null,
        string|null     $connection = null,
        string|null     $queue = null
    ): void {
        dispatch(new ExecuteMethodJob($correlationId, self::class, 'createAndRun', $connection, $queue, $assistantId, $messages, $metaData));
    }

    /**
     * @throws ThreadNotFound
     */
    public function retrieve(string $id): ThreadResponse
    {
        return (new Retrieve($id))->execute();
    }

    public function retrieveAsync(string $correlationId, string $id, string|null $connection = null, string|null $queue = null): void
    {
        dispatch(new ExecuteMethodJob($correlationId, self::class, 'retrieve', $connection, $queue, $id));
    }

    /**
     * @throws ThreadNotFound
     */
    public function modify(
        string        $id,
        MetaData|null $metaData = null
    ): ThreadResponse {
        return (new Modify($id, $metaData))->execute();
    }

    public function modifyAsync(
        string        $correlationId,
        string        $id,
        MetaData|null $metaData = null,
        string|null   $connection = null,
        string|null   $queue = null
    ): void {
        dispatch(new ExecuteMethodJob($correlationId, self::class, 'modify', $connection, $queue, $id, $metaData));
    }

    /**
     * @throws ThreadNotFound
     */
    public function delete(string $id): ThreadDeleteResponse
    {
        return (new Delete($id))->execute();
    }

    public function deleteAsync(string $correlationId, string $id, string|null $connection = null, string|null $queue = null): void
    {
        dispatch(new ExecuteMethodJob($correlationId, self::class, 'delete', $connection, $queue, $id));
    }

    public function runs(): IThreadRunModule
    {
        return app(IThreadRunModule::class);
    }

    public function messages(): IThreadMessageModule
    {
        return app(IThreadMessageModule::class);
    }
}
