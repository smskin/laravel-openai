<?php

namespace SMSkin\LaravelOpenAi;

use OpenAI\Responses\Completions\CreateResponse;
use SMSkin\LaravelOpenAi\Contracts\ICompletionModule;
use SMSkin\LaravelOpenAi\Controllers\Completion\Create;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Exceptions\NotValidModel;
use SMSkin\LaravelOpenAi\Jobs\ExecuteMethodJob;

class CompletionModule implements ICompletionModule
{
    /**
     * @throws NotValidModel
     */
    public function create(
        ModelEnum $model,
        string    $prompt,
        int|null  $frequencyPenalty = null,
        int|null  $temperature = null,
        int|null  $presencePenalty = null,
        int|null  $maxTokens = null,
    ): CreateResponse {
        $frequencyPenalty ??= 0;
        $temperature ??= 1;
        $presencePenalty ??= 0;
        return (new Create($model, $prompt, $frequencyPenalty, $temperature, $presencePenalty, $maxTokens))->execute();
    }

    public function createAsync(
        string      $correlationId,
        ModelEnum   $model,
        string      $prompt,
        int|null    $frequencyPenalty = null,
        int|null    $temperature = null,
        int|null    $presencePenalty = null,
        int|null    $maxTokens = null,
        string|null $connection = null,
        string|null $queue = null
    ): void {
        dispatch(new ExecuteMethodJob($correlationId, self::class, substr(__FUNCTION__, 0, -5), $connection, $queue, $model, $prompt, $frequencyPenalty, $temperature, $presencePenalty, $maxTokens));
    }
}
