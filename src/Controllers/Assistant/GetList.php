<?php

namespace SMSkin\LaravelOpenAi\Controllers\Assistant;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Assistants\AssistantListResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Enums\OrderEnum;

class GetList extends BaseController
{
    public function __construct(
        private readonly int|null $limit,
        private readonly OrderEnum|null $order,
        private readonly string|null $after,
        private readonly string|null $before,
    ) {
    }

    public function execute(): AssistantListResponse
    {
        try {
            return $this->getClient()->assistants()->list(
                $this->prepareParams()
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->globalExceptionHandler($exception);
        }
    }

    private function prepareParams(): array
    {
        $payload = [];
        if ($this->limit !== null) {
            $payload['limit'] = $this->limit;
        }
        if ($this->order) {
            $payload['order'] = $this->order->value;
        }
        if ($this->after !== null) {
            $payload['after'] = $this->after;
        }
        if ($this->before !== null) {
            $payload['before'] = $this->before;
        }
        return $payload;
    }
}
