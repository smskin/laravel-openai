<?php

namespace SMSkin\LaravelOpenAi\Controllers\Completion;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Completions\CreateResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;

class Create extends BaseController
{
    /**
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(
        ModelEnum $model,
        string    $prompt,
        int|null  $bestOf,
        bool|null $echo,
        int|null  $frequencyPenalty,
        int|null  $maxTokens,
        int|null  $n,
        int|null  $presencePenalty,
        int|null  $temperature,
        int|null  $topP
    ): CreateResponse {
        try {
            return $this->getClient()->completions()->create(
                $this->prepareData($model, $prompt, $bestOf, $echo, $frequencyPenalty, $maxTokens, $n, $presencePenalty, $temperature, $topP)
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->globalExceptionHandler($exception);
        }
    }

    private function prepareData(
        ModelEnum $model,
        string    $prompt,
        int|null  $bestOf,
        bool|null $echo,
        int|null  $frequencyPenalty,
        int|null  $maxTokens,
        int|null  $n,
        int|null  $presencePenalty,
        int|null  $temperature,
        int|null  $topP
    ): array {
        $payload = compact('model', 'prompt');

        if ($bestOf !== null) {
            $payload['best_of'] = $bestOf;
        }
        if ($echo !== null) {
            $payload['echo'] = $echo;
        }
        if ($frequencyPenalty !== null) {
            $payload['frequency_penalty'] = $frequencyPenalty;
        }
        if ($maxTokens !== null) {
            $payload['max_tokens'] = $maxTokens;
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
