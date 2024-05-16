<?php

namespace SMSkin\LaravelOpenAi\Controllers\Chat;

use BaseController;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Chat\CreateResponse;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Exceptions\NotValidModel;
use SMSkin\LaravelOpenAi\Models\ChatMessage;

class Create extends BaseController
{
    public function __construct(
        private readonly ModelEnum $model,
        private readonly Collection $messages,
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
            return $this->getClient()->chat()->create([
                'model' => $this->model->value,
                'messages' => $this->messages->map(static function (ChatMessage $message) {
                    return $message->toArray();
                }),
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
