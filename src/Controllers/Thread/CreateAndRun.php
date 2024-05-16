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
            return $this->getClient()->threads()->createAndRun($this->prepareData());
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'No assistant found with id')) {
                throw new AssistanceNotFound($exception->getMessage(), 500, $exception);
            }

            $this->errorExceptionHandler($exception);
        }
    }

    private function prepareData(): array
    {
        $data = [
            'assistant_id' => $this->assistantId,
            'thread' => [],
        ];
        if (filled($this->metaData)) {
            $data['thread']['metadata'] = $this->metaData->toArray();
        }
        if (filled($this->messages)) {
            $data['thread']['messages'] = $this->messages->map(static function (ChatMessage $message) {
                return $message->toArray();
            })->toArray();
        }
        return $data;
    }
}
