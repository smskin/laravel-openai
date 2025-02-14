<?php

namespace SMSkin\LaravelOpenAi\Controllers\VectorStoreFile;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\VectorStores\Files\VectorStoreFileListResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Controllers\VectorStore\Traits\VectorStoreExceptionTrait;
use SMSkin\LaravelOpenAi\Enums\OrderEnum;
use SMSkin\LaravelOpenAi\Enums\VectorStoreFileFilter;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;
use SMSkin\LaravelOpenAi\Exceptions\VectorStoreIsExpired;

class GetList extends BaseController
{
    use VectorStoreExceptionTrait;

    /**
     * @throws ErrorException
     * @throws ApiServerHadProcessingError
     * @throws NotFound
     * @throws TransporterException
     * @throws VectorStoreIsExpired
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(string $vectorStoreId, int|null $limit, OrderEnum|null $order, string|null $after, string|null $before, VectorStoreFileFilter|null $filter): VectorStoreFileListResponse
    {
        try {
            return $this->getClient()->vectorStores()->files()->list($vectorStoreId, $this->prepareData($limit, $order, $after, $before, $filter));
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->vectorStoreExceptionHandler($exception);
            $this->globalExceptionHandler($exception);
        }
    }

    private function prepareData(int|null $limit, OrderEnum|null $order, string|null $after, string|null $before, VectorStoreFileFilter|null $filter): array
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
        if (filled($filter)) {
            $data['filter'] = $filter->value;
        }
        return $data;
    }
}
