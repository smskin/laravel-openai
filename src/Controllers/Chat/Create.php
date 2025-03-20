<?php

namespace SMSkin\LaravelOpenAi\Controllers\Chat;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Chat\CreateResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
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
     * @return CreateResponse
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @throws TransporterException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(
        array     $messages,
        ModelEnum $model,
        bool|null $store,
        int|null  $frequencyPenalty,
        int|null  $maxCompletionTokens,
        int|null  $n,
        int|null  $presencePenalty,
        int|null  $temperature,
        int|null  $topP
    ): CreateResponse {
        try {
            return $this->getClient()->chat()->create(
                $this->prepareData($messages, $model, $store, $frequencyPenalty, $maxCompletionTokens, $n, $presencePenalty, $temperature, $topP)
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->globalExceptionHandler($exception);
        }
    }

    private function prepareData(
        array     $messages,
        ModelEnum $model,
        bool|null $store,
        int|null  $frequencyPenalty,
        int|null  $maxCompletionTokens,
        int|null  $n,
        int|null  $presencePenalty,
        int|null  $temperature,
        int|null  $topP
    ): array {
        $payload = [
            'messages' => collect($messages)->map(static function (ChatMessage $message) {
                return [
                    'role' => $message->role->value,
                    'content' => $message->content,
                ];
            }),
            'model' => $model->value,
        ];
        if ($store !== null) {
            $payload['store'] = $store;
        }
        if ($frequencyPenalty !== null) {
            $payload['frequency_penalty'] = $frequencyPenalty;
        }
        if ($maxCompletionTokens !== null) {
            $payload['max_completion_tokens'] = $maxCompletionTokens;
        }
        if ($n !== null) {
            $payload['n'] = $n;
        }
        if ($presencePenalty !== null) {
            $payload['presence_penalty'] = $presencePenalty;
        }
        if ($temperature !== null) {
            $payload['temperature'] = $temperature;
        }
        if ($topP !== null) {
            $payload['top_p'] = $topP;
        }
        return $payload;
    }
}
