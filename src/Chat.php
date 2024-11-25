<?php

namespace SMSkin\LaravelOpenAi;

use OpenAI\Responses\Chat\CreateResponse;
use SMSkin\LaravelOpenAi\Controllers\Chat\Create;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Models\ChatMessage;

class Chat
{
    /**
     * @param array<ChatMessage> $messages
     * @param ModelEnum $model
     * @param bool|null $store
     * @param int|null $frequencyPenalty
     * @param int|null $maxCompletionTokens
     * @param int|null $n
     * @param int|null $presencePenalty
     * @param int|null $temperature
     * @param int|null $topP
     * @return CreateResponse
     */
    public function create(
        array     $messages,
        ModelEnum $model,
        bool|null $store = null,
        int|null  $frequencyPenalty = null,
        int|null  $maxCompletionTokens = null,
        int|null  $n = null,
        int|null  $presencePenalty = null,
        int|null  $temperature = null,
        int|null  $topP = null
    ): CreateResponse {
        return (new Create($messages, $model, $store, $frequencyPenalty, $maxCompletionTokens, $n, $presencePenalty, $temperature, $topP))->execute();
    }
}