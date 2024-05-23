<?php

namespace SMSkin\LaravelOpenAi\Contracts;

use Illuminate\Support\Collection;
use OpenAI\Responses\Threads\Runs\ThreadRunResponse;
use OpenAI\Responses\Threads\ThreadDeleteResponse;
use OpenAI\Responses\Threads\ThreadResponse;
use SMSkin\LaravelOpenAi\Exceptions\AssistanceNotFound;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Models\ChatMessage;
use SMSkin\LaravelOpenAi\Models\MetaData;

interface IThreadModule
{
    /**
     * @param Collection<ChatMessage>|null $messages
     * @param MetaData|null $metaData
     * @return ThreadResponse
     */
    public function create(
        Collection|null $messages = null,
        MetaData|null   $metaData = null
    ): ThreadResponse;

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
    ): void;

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
    ): ThreadRunResponse;

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
    ): void;

    /**
     * @throws ThreadNotFound
     */
    public function retrieve(string $id): ThreadResponse;

    public function retrieveAsync(string $correlationId, string $id, string|null $connection = null, string|null $queue = null): void;

    /**
     * @throws ThreadNotFound
     */
    public function modify(
        string        $id,
        MetaData|null $metaData = null
    ): ThreadResponse;

    public function modifyAsync(
        string        $correlationId,
        string        $id,
        MetaData|null $metaData = null,
        string|null   $connection = null,
        string|null   $queue = null
    ): void;

    /**
     * @throws ThreadNotFound
     */
    public function delete(string $id): ThreadDeleteResponse;

    public function deleteAsync(string $correlationId, string $id, string|null $connection = null, string|null $queue = null): void;

    public function runs(): IThreadRunModule;

    public function messages(): IThreadMessageModule;
}
