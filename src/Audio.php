<?php

namespace SMSkin\LaravelOpenAi;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Audio\TranscriptionResponse;
use SMSkin\LaravelOpenAi\Controllers\Audio\CreateTranscription;
use SMSkin\LaravelOpenAi\Enums\LanguageEnum;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;

class Audio
{
    /**
     * @throws ErrorException
     * @throws Exceptions\ApiServerHadProcessingError
     */
    public function transcribe(string $filePath, ModelEnum $model, LanguageEnum|null $language = null, string|null $prompt = null, int|null $temperature = null): TranscriptionResponse
    {
        return (new CreateTranscription())->execute(fopen($filePath, 'r'), $model, $language, $prompt, $temperature);
    }
}
