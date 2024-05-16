<?php

namespace SMSkin\LaravelOpenAi\Controllers\ThreadRun;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Threads\Runs\ThreadRunResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Exceptions\AssistanceNotFound;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Models\MetaData;

class Create extends BaseController
{
    public function __construct(
        private readonly string $threadId,
        private readonly string $assistantId,
        private readonly MetaData|null $metaData
    ) {
    }

    /**
     * @throws ThreadNotFound
     * @throws AssistanceNotFound
     */
    public function execute(): ThreadRunResponse
    {
        try {
            return $this->getClient()->threads()->runs()->create(
                $this->threadId,
                [
                    'assistant_id' => $this->assistantId,
                    'metadata' => $this->metaData?->toArray(),
                ]
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'No thread found with id')) {
                throw new ThreadNotFound($exception->getMessage(), 500, $exception);
            }
            if (Str::contains($exception->getMessage(), 'No assistant found with id')) {
                throw new AssistanceNotFound($exception->getMessage(), 500, $exception);
            }

            $this->errorExceptionHandler($exception);
        }
    }
}
