<?php

namespace SMSkin\LaravelOpenAi;

use OpenAI\Responses\Completions\CreateResponse;
use SMSkin\LaravelOpenAi\Controllers\Completion\Create;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;

class Completion
{
    public function create(
        ModelEnum $model,
        string    $prompt,
        int|null  $bestOf = null,
        bool|null $echo = null,
        int|null  $frequencyPenalty = null,
        int|null  $maxTokens = null,
        int|null  $n = null,
        int|null  $presencePenalty = null,
        int|null  $temperature = null,
        int|null  $topP = null
    ): CreateResponse {
        return (new Create($model, $prompt, $bestOf, $echo, $frequencyPenalty, $maxTokens, $n, $presencePenalty, $temperature, $topP))->execute();
    }
}
