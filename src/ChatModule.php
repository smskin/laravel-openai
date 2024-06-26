<?php

namespace SMSkin\LaravelOpenAi;

use Illuminate\Support\Collection;
use OpenAI\Responses\Chat\CreateResponse;
use SMSkin\LaravelOpenAi\Contracts\IChatModule;
use SMSkin\LaravelOpenAi\Controllers\Chat\Create;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Exceptions\NotValidModel;
use SMSkin\LaravelOpenAi\Jobs\ExecuteMethodJob;
use SMSkin\LaravelOpenAi\Models\ChatMessage;

class ChatModule implements IChatModule
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
    ): CreateResponse {
        $frequencyPenalty ??= 0;
        $temperature ??= 1;
        $presencePenalty ??= 0;
        return (new Create($model, $messages, $frequencyPenalty, $temperature, $presencePenalty, $maxTokens))->execute();
    }

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
    ): void {
        dispatch(new ExecuteMethodJob($correlationId, self::class, 'create', $connection, $queue, $model, $messages, $frequencyPenalty, $temperature, $presencePenalty, $maxTokens));
    }
}
