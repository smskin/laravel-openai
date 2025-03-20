<?php

namespace SMSkin\LaravelOpenAi\Controllers\Audio;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Audio\TranscriptionResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Enums\LanguageEnum;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;

class CreateTranscription extends BaseController
{
    /**
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function execute(mixed $file, ModelEnum $model, LanguageEnum|null $language, string|null $prompt, int|null $temperature): TranscriptionResponse
    {
        try {
            return $this->getClient()->audio()->transcribe(
                $this->prepareData($file, $model, $language, $prompt, $temperature)
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->globalExceptionHandler($exception);
        }
    }

    private function prepareData(mixed $file, ModelEnum $model, LanguageEnum|null $language, string|null $prompt, int|null $temperature): array
    {
        $payload = [
            'file' => $file,
            'model' => $model->value,
        ];

        if ($language) {
            $payload['language'] = $language->value;
        }

        if ($prompt) {
            $payload['prompt'] = $prompt;
        }

        if ($temperature !== null) {
            $payload['temperature'] = $temperature;
        }
        return $payload;
    }
}
