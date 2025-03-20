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

    /**
     * @throws ThreadNotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(
        string         $threadId,
        int|null       $limit,
        OrderEnum|null $order,
        string|null    $after,
        string|null    $before,
        string|null    $runId
    ): ThreadMessageListResponse {
        try {
            return $this->getClient()->threads()->messages()->list(
                $threadId,
                $this->prepareParams($limit, $order, $after, $before, $runId)
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->getListExceptionHandler($exception);
            $this->globalExceptionHandler($exception);
        }
    }

    private function prepareParams(
        int|null       $limit,
        OrderEnum|null $order,
        string|null    $after,
        string|null    $before,
        string|null    $runId
    ): array {
        $payload = [];
        if ($limit !== null) {
            $payload['limit'] = $limit;
        }
        if ($order) {
            $payload['order'] = $order->value;
        }
        if ($after) {
            $payload['after'] = $after;
        }
        if ($before) {
            $payload['before'] = $before;
        }
        if ($runId) {
            $payload['run_id'] = $runId;
        }
        return $payload;
    }
}
