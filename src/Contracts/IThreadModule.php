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
     * @throws ThreadNotFound
     */
    public function retrieve(string $id): ThreadResponse;

    /**
     * @throws ThreadNotFound
     */
    public function modify(
        string        $id,
        MetaData|null $metaData = null
    ): ThreadResponse;

    /**
     * @throws ThreadNotFound
     */
    public function delete(string $id): ThreadDeleteResponse;

    public function runs(): IThreadRunModule;

    public function messages(): IThreadMessageModule;
}
