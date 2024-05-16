<?php

namespace SMSkin\LaravelOpenAi\Controllers\Audio;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Enums\AudioResponseFormatEnum;
use SMSkin\LaravelOpenAi\Enums\AudioVoiceEnum;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Exceptions\NotValidModel;

class Speech extends BaseController
{
    public function __construct(
        private readonly ModelEnum $model,
        private readonly string $input,
        private readonly AudioVoiceEnum $voice,
        private readonly AudioResponseFormatEnum $responseFormat,
        private readonly int $speed
    ) {
    }

    /**
     * @throws NotValidModel
     */
    public function execute(): string
    {
        try {
            return $this->getClient()->audio()->speech([
                'model' => $this->model->value,
                'input' => $this->input,
                'voice' => $this->voice->value,
                'response_format' => $this->responseFormat->value,
                'speed' => $this->speed,
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
