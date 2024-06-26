<?php

namespace SMSkin\LaravelOpenAi\Contracts;

use Illuminate\Support\Collection;
use OpenAI\Responses\Chat\CreateResponse;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Exceptions\NotValidModel;
use SMSkin\LaravelOpenAi\Models\ChatMessage;

interface IChatModule
{
    /**
     * @param ModelEnum $model
     * @param Collection<ChatMessage> $messages
     * @param int|null $frequencyPenalty
     * @param int|null $temperature
     * @param int|null $presencePenalty
     * @param int|null $maxTokens
     * @return CreateResponse
     * @throws NotValidModel
     */
    public function create(
        ModelEnum  $model,
        Collection $messages,
        int|null   $frequencyPenalty = null,
        int|null   $temperature = null,
        int|null   $presencePenalty = null,
        int|null   $maxTokens = null,
    ): CreateResponse;

    /**
     * @param string $correlationId
     * @param ModelEnum $model
     * @param Collection<ChatMessage> $messages
     * @param int|null $frequencyPenalty
     * @param int|null $temperature
     * @param int|null $presencePenalty
     * @param int|null $maxTokens
     * @param string|null $connection
     * @param string|null $queue
     * @return void
     */
    public function createAsync(
        string      $correlationId,
        ModelEnum   $model,
        Collection  $messages,
        int|null    $frequencyPenalty = null,
        int|null    $temperature = null,
        int|null    $presencePenalty = null,
        int|null    $maxTokens = null,
        string|null $connection = null,
        string|null $queue = null
    ): void;
}
