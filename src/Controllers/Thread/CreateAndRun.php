<?php

namespace SMSkin\LaravelOpenAi\Controllers\Thread;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Threads\Runs\ThreadRunResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Exceptions\AssistanceNotFound;
use SMSkin\LaravelOpenAi\Models\ChatMessage;
use SMSkin\LaravelOpenAi\Models\MetaData;

class CreateAndRun extends BaseController
{
    public function __construct(
        private readonly string $assistantId,
        private readonly Collection|null $messages,
        private readonly MetaData|null $metaData
    ) {
    }

    /**
     * @throws AssistanceNotFound
     */
    public function execute(): ThreadRunResponse
    {
        try {
            return $this->getClient()->threads()->createAndRun([
                'assistant_id' => $this->assistantId,
                'thread' => [
                    'metadata' => $this->metaData?->toArray(),
                    'messages' => $this->messages?->map(static function (ChatMessage $message) {
                        return $message->toArray();
                    }),
                ],
            ]);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'No assistant found with id')) {
                throw new AssistanceNotFound($exception->getMessage(), 500, $exception);
            }

            $this->errorExceptionHandler($exception);
        }
    }
}
