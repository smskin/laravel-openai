<?php

namespace SMSkin\LaravelOpenAi\Controllers\Chat;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Chat\CreateResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Models\ChatMessage;

class Create extends BaseController
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
     */
    public function __construct(
        private readonly array $messages,
        private readonly ModelEnum $model,
        private readonly bool|null $store,
        private readonly int|null $frequencyPenalty,
        private readonly int|null $maxCompletionTokens,
        private readonly int|null $n,
        private readonly int|null $presencePenalty,
        private readonly int|null $temperature,
        private readonly int|null $topP,
    ) {
    }

    public function execute(): CreateResponse
    {
        try {
            return $this->getClient()->chat()->create(
                $this->prepareData()
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->globalExceptionHandler($exception);
        }
    }

    private function prepareData(): array
    {
        $payload = [
            'messages' => collect($this->messages)->map(static function (ChatMessage $message) {
                return [
                    'role' => $message->role->value,
                    'content' => $message->content,
                ];
            }),
            'model' => $this->model->value,
        ];
        if ($this->store !== null) {
            $payload['store'] = $this->store;
        }
        if ($this->frequencyPenalty !== null) {
            $payload['frequency_penalty'] = $this->frequencyPenalty;
        }
        if ($this->maxCompletionTokens !== null) {
            $payload['max_completion_tokens'] = $this->maxCompletionTokens;
        }
        if ($this->n !== null) {
            $payload['n'] = $this->n;
        }
        if ($this->presencePenalty !== null) {
            $payload['presence_penalty'] = $this->presencePenalty;
        }
        if ($this->temperature !== null) {
            $payload['temperature'] = $this->temperature;
        }
        if ($this->topP !== null) {
            $payload['top_p'] = $this->topP;
        }
        return $payload;
    }
}
