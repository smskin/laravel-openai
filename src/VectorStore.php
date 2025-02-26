<?php

namespace SMSkin\LaravelOpenAi;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\VectorStores\VectorStoreDeleteResponse;
use OpenAI\Responses\VectorStores\VectorStoreListResponse;
use SMSkin\LaravelOpenAi\Controllers\VectorStore\Delete;
use SMSkin\LaravelOpenAi\Controllers\VectorStore\GetList;
use SMSkin\LaravelOpenAi\Enums\OrderEnum;

class VectorStore
{
    /**
     * @throws ErrorException
     * @throws Exceptions\ApiServerHadProcessingError
     * @throws TransporterException
     */
    public function getList(int|null $limit = null, OrderEnum|null $order = null, string|null $after = null, string|null $before = null): VectorStoreListResponse
    {
        return (new GetList($limit, $order, $after, $before))->execute();
    }

    /**
     * @throws ErrorException
     * @throws Exceptions\ApiServerHadProcessingError
     * @throws Exceptions\NotFound
     * @throws TransporterException
     * @throws Exceptions\VectorStoreIsExpired
     */
    public function delete(string $id): VectorStoreDeleteResponse
    {
        return (new Delete($id))->execute();
    }

    public function files(): VectorStoreFile
    {
        return new VectorStoreFile();
    }
}
