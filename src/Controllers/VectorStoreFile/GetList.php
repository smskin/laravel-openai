<?php

namespace SMSkin\LaravelOpenAi\Controllers\VectorStoreFile;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\VectorStores\Files\VectorStoreFileListResponse;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Traits\CreateExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Enums\OrderEnum;
use SMSkin\LaravelOpenAi\Enums\VectorStoreFileFilter;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;

class GetList extends BaseController
{
    use CreateExceptionHandlerTrait;

    /**
     * @throws ErrorException
     * @throws ApiServerHadProcessingError
     * @throws NotFound
     * @throws TransporterException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(string $vectorStoreId, int|null $limit, OrderEnum|null $order, string|null $after, string|null $before, VectorStoreFileFilter|null $filter): VectorStoreFileListResponse
    {
        try {
            return $this->getClient()->vectorStores()->files()->list($vectorStoreId, $this->prepareData($limit, $order, $after, $before, $filter));
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (
                Str::contains($exception->getMessage(), 'No vector store found with id') ||
                Str::contains($exception->getMessage(), 'Expected an ID that begins with')
            ) {
                throw new NotFound($exception->getMessage(), 500, $exception);
            }
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
