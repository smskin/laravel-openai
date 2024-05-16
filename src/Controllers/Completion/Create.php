<?php

namespace SMSkin\LaravelOpenAi\Controllers\Completion;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Completions\CreateResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Exceptions\NotValidModel;

class Create extends BaseController
{
    public function __construct(
        private readonly ModelEnum $model,
        private readonly string $prompt,
        private readonly int $frequencyPenalty,
        private readonly int $temperature,
        private readonly int $presencePenalty,
        private readonly int|null $maxTokens,
    ) {
    }

    /**
     * @throws NotValidModel
     */
    public function execute(): CreateResponse
    {
        try {
            return $this->getClient()->completions()->create([
                'model' => $this->model->value,
                'prompt' => $this->prompt,
                'frequency_penalty' => $this->frequencyPenalty,
                'max_tokens' => $this->maxTokens,
                'temperature' => $this->temperature,
                'presence_penalty' => $this->presencePenalty,
            ]);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'You are not allowed to sample from this model')) {
                throw new NotValidModel($exception->getMessage(), 500, $exception);
            }
            $this->errorExceptionHandler($exception);
        }
    }
}
