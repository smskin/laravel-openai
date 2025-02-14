<?php

namespace SMSkin\LaravelOpenAi;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\VectorStores\Files\VectorStoreFileDeleteResponse;
use OpenAI\Responses\VectorStores\Files\VectorStoreFileListResponse;
use SMSkin\LaravelOpenAi\Controllers\VectorStoreFile\Delete;
use SMSkin\LaravelOpenAi\Controllers\VectorStoreFile\GetList;
use SMSkin\LaravelOpenAi\Enums\OrderEnum;
use SMSkin\LaravelOpenAi\Enums\VectorStoreFileFilter;

class VectorStoreFile
{
    /**
     * @throws ErrorException
     * @throws Exceptions\ApiServerHadProcessingError
     * @throws Exceptions\NotFound
     */
    public function getList(string $vectorStoreId, int|null $limit = null, OrderEnum|null $order = null, string|null $after = null, string|null $before = null, VectorStoreFileFilter|null $filter = null): VectorStoreFileListResponse
    {
        return (new GetList())->execute($vectorStoreId, $limit, $order, $after, $before, $filter);
    }

    /**
     * @throws ErrorException
     * @throws Exceptions\ApiServerHadProcessingError
     * @throws Exceptions\NotFound
     */
    public function delete(string $vectorStoreId, string $fileId): VectorStoreFileDeleteResponse
    {
        return (new Delete())->execute($vectorStoreId, $fileId);
    }
}
