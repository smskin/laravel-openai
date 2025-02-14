<?php

namespace SMSkin\LaravelOpenAi\Controllers\VectorStoreFile;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\VectorStores\Files\VectorStoreFileDeleteResponse;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Traits\CreateExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;

class Delete extends BaseController
{
    use CreateExceptionHandlerTrait;

    /**
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @throws NotFound
     * @throws TransporterException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(string $vectorStoreId, string $fileId): VectorStoreFileDeleteResponse
    {
        try {
            return $this->getClient()->vectorStores()->files()->delete($vectorStoreId, $fileId);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (
                Str::contains($exception->getMessage(), 'No vector store found with id') ||
                Str::contains($exception->getMessage(), 'Expected an ID that begins with') ||
                Str::contains($exception->getMessage(), 'No file found with id')
            ) {
                throw new NotFound($exception->getMessage(), 500, $exception);
            }
            $this->globalExceptionHandler($exception);
        }
    }
}
