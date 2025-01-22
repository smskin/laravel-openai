<?php

namespace SMSkin\LaravelOpenAi\Controllers\Message;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Threads\Messages\ThreadMessageListResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Controllers\Run\Traits\GetListExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Enums\OrderEnum;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
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
        private readonly string|null $runId
    ) {
    }

    /**
     * @throws ThreadNotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(): ThreadMessageListResponse
    {
        try {
            return $this->getClient()->threads()->messages()->list(
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
        if ($this->after) {
            $payload['after'] = $this->after;
        }
        if ($this->before) {
            $payload['before'] = $this->before;
        }
        if ($this->runId) {
            $payload['run_id'] = $this->runId;
        }
        return $payload;
    }
}
