<?php

namespace SMSkin\LaravelOpenAi\Controllers\VectorStore;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\VectorStores\VectorStoreListResponse;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Traits\CreateExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Enums\OrderEnum;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;

class GetList extends BaseController
{
    use CreateExceptionHandlerTrait;

    public function __construct(
        private readonly int|null $limit,
        private readonly OrderEnum|null $order,
        private readonly string|null $after,
        private readonly string|null $before
    ) {
    }

    /**
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @throws TransporterException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(): VectorStoreListResponse
    {
        try {
            return $this->getClient()->vectorStores()->list(
                $this->prepareData()
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
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
        return $data;
    }
}
