<?php

namespace SMSkin\LaravelOpenAi\Contracts;

use OpenAI\Responses\Completions\CreateResponse;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Exceptions\NotValidModel;

interface ICompletionModule
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
    ): CreateResponse;

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
    ): void;
}
