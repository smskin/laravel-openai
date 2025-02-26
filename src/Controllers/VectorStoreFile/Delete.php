<?php

namespace SMSkin\LaravelOpenAi\Controllers\VectorStoreFile;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\VectorStores\Files\VectorStoreFileDeleteResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Controllers\VectorStore\Traits\VectorStoreExceptionTrait;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;
use SMSkin\LaravelOpenAi\Exceptions\VectorStoreIsExpired;

class Delete extends BaseController
{
    use VectorStoreExceptionTrait;

    public function __construct(private readonly string $vectorStoreId, private readonly string $fileId)
    {
    }

    /**
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @throws NotFound
     * @throws TransporterException
     * @throws VectorStoreIsExpired
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(): VectorStoreFileDeleteResponse
    {
        try {
            return $this->getClient()->vectorStores()->files()->delete($this->vectorStoreId, $this->fileId);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'No file found with id')) {
                throw new NotFound($exception->getMessage(), 500, $exception);
            }
            $this->vectorStoreExceptionHandler($exception);
            $this->globalExceptionHandler($exception);
        }
    }
}
