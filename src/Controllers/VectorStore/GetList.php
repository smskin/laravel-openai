<?php

namespace SMSkin\LaravelOpenAi\Controllers\VectorStore;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\VectorStores\VectorStoreListResponse;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Traits\CreateExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Enums\OrderEnum;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;

class GetList extends BaseController
{
    use CreateExceptionHandlerTrait;

    /**
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function execute(int|null $limit, OrderEnum|null $order, string|null $after, string|null $before): VectorStoreListResponse
    {
        try {
            return $this->getClient()->vectorStores()->list(
                $this->prepareData($limit, $order, $after, $before)
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->globalExceptionHandler($exception);
        }
    }

    private function prepareData(int|null $limit, OrderEnum|null $order, string|null $after, string|null $before): array
    {
        $data = [];
        if (filled($limit)) {
            $data['limit'] = $limit;
        }
        if (filled($order)) {
            $data['order'] = $order->value;
        }
        if (filled($after)) {
            $data['after'] = $after;
        }
        if (filled($before)) {
            $data['before'] = $before;
        }
        return $data;
    }
}
