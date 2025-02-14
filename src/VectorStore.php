<?php

namespace SMSkin\LaravelOpenAi;

use OpenAI\Exceptions\ErrorException;
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
     */
    public function getList(int|null $limit = null, OrderEnum|null $order = null, string|null $after = null, string|null $before = null): VectorStoreListResponse
    {
        return (new GetList())->execute($limit, $order, $after, $before);
    }

    /**
     * @throws ErrorException
     * @throws Exceptions\ApiServerHadProcessingError
     * @throws Exceptions\NotFound
     */
    public function delete(string $id): VectorStoreDeleteResponse
    {
        return (new Delete())->execute($id);
    }

    public function files(): VectorStoreFile
    {
        return new VectorStoreFile();
    }
}
