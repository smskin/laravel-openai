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

    public function __construct(
        private readonly string $vectorStoreId,
        private readonly int|null $limit,
        private readonly OrderEnum|null $order,
        private readonly string|null $after,
        private readonly string|null $before,
        private readonly VectorStoreFileFilter|null $filter
    ) {
    }

    /**
     * @throws ErrorException
     * @throws ApiServerHadProcessingError
     * @throws NotFound
     * @throws TransporterException
     * @throws VectorStoreIsExpired
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(): VectorStoreFileListResponse
    {
        try {
            return $this->getClient()->vectorStores()->files()->list($this->vectorStoreId, $this->prepareData());
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->vectorStoreExceptionHandler($exception);
            $this->globalExceptionHandler($exception);
        }
    }

    private function prepareData(): array
    {
        $data = [];
        if (filled($this->limit)) {
            $data['limit'] = $this->limit;
        }
        if (filled($this->order)) {
            $data['order'] = $this->order->value;
        }
        if (filled($this->after)) {
            $data['after'] = $this->after;
        }
        if (filled($this->before)) {
            $data['before'] = $this->before;
        }
        if (filled($this->filter)) {
            $data['filter'] = $this->filter->value;
        }
        return $data;
    }
}
