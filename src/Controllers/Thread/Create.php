<?php

namespace SMSkin\LaravelOpenAi\Controllers\Thread;

use Illuminate\Support\Collection;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Threads\ThreadResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Models\ChatMessage;
use SMSkin\LaravelOpenAi\Models\MetaData;

class Create extends BaseController
{
    public function __construct(
        private readonly Collection|null $messages,
        private readonly MetaData|null $metaData
    ) {
    }

    public function execute(): ThreadResponse
    {
        try {
            return $this->getClient()->threads()->create($this->prepareData());
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->errorExceptionHandler($exception);
        }
    }

    private function prepareData(): array
    {
        $data = [];
        if (filled($this->metaData)) {
            $data['metadata'] = $this->metaData->toArray();
        }
        if (filled($this->messages)) {
            $data['messages'] = $this->messages->map(static function (ChatMessage $message) {
                return $message->toArray();
            })->toArray();
        }
        return $data;
    }
}
