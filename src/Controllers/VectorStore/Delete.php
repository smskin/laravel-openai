<?php

namespace SMSkin\LaravelOpenAi\Controllers\VectorStore;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\VectorStores\VectorStoreDeleteResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Controllers\VectorStore\Traits\VectorStoreExceptionTrait;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;
use SMSkin\LaravelOpenAi\Exceptions\VectorStoreIsExpired;

class Delete extends BaseController
{
    use VectorStoreExceptionTrait;

    public function __construct(private readonly string $id)
    {
    }

    /**
     * @throws ErrorException
     * @throws ApiServerHadProcessingError
     * @throws NotFound
     * @throws TransporterException
     * @throws VectorStoreIsExpired
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(): VectorStoreDeleteResponse
    {
        try {
            return $this->getClient()->vectorStores()->delete($this->id);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->vectorStoreExceptionHandler($exception);
            $this->globalExceptionHandler($exception);
        }
    }
}
