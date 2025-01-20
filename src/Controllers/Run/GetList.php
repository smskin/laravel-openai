<?php

namespace SMSkin\LaravelOpenAi\Controllers\Run;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Threads\Runs\ThreadRunListResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Controllers\Run\Traits\GetListExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Enums\OrderEnum;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;

class GetList extends BaseController
{
    use GetListExceptionHandlerTrait;

    public function __construct(
        private readonly string $threadId,
        private readonly int|null $limit,
        private readonly OrderEnum|null $order,
        private readonly string|null $after,
        private readonly string|null $before,
    ) {
    }

    /**
     * @throws ThreadNotFound
     * @throws TransporterException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(): ThreadRunListResponse
    {
        try {
            return $this->getClient()->threads()->runs()->list(
                $this->threadId,
                $this->prepareParams()
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->getListExceptionHandler($exception);
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
