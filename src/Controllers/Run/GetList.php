<?php

namespace SMSkin\LaravelOpenAi\Controllers\Run;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Threads\Runs\ThreadRunListResponse;
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
        string|null    $before
    ): ThreadRunListResponse {
        try {
            return $this->getClient()->threads()->runs()->list(
                $threadId,
                $this->prepareParams(
                    $limit,
                    $order,
                    $after,
                    $before
                )
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
        string|null    $before
    ): array {
        $payload = [];
        if ($limit !== null) {
            $payload['limit'] = $limit;
        }
        if ($order) {
            $payload['order'] = $order->value;
        }
        if ($after !== null) {
            $payload['after'] = $after;
        }
        if ($before !== null) {
            $payload['before'] = $before;
        }
        return $payload;
    }
}
