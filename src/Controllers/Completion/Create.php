<?php

namespace SMSkin\LaravelOpenAi\Controllers\Completion;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Completions\CreateResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;

class Create extends BaseController
{
    public function __construct(
        private readonly ModelEnum $model,
        private readonly string $prompt,
        private readonly int|null $bestOf,
        private readonly bool|null $echo,
        private readonly int|null $frequencyPenalty,
        private readonly int|null $maxTokens,
        private readonly int|null $n,
        private readonly int|null $presencePenalty,
        private readonly int|null $temperature,
        private readonly int|null $topP
    ) {
    }

    public function execute(): CreateResponse
    {
        try {
            return $this->getClient()->completions()->create(
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
            'model' => $this->model,
            'prompt' => $this->prompt,
        ];
        if ($this->bestOf !== null) {
            $payload['best_of'] = $this->bestOf;
        }
        if ($this->echo !== null) {
            $payload['echo'] = $this->echo;
        }
        if ($this->frequencyPenalty !== null) {
            $payload['frequency_penalty'] = $this->frequencyPenalty;
        }
        if ($this->maxTokens !== null) {
            $payload['max_tokens'] = $this->maxTokens;
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
