<?php

namespace SMSkin\LaravelOpenAi\Controllers\VectorStore;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\VectorStores\VectorStoreDeleteResponse;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Traits\CreateExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;

class Delete extends BaseController
{
    use CreateExceptionHandlerTrait;

    /**
     * @throws ErrorException
     * @throws ApiServerHadProcessingError
     * @throws NotFound
     * @throws TransporterException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(string $id): VectorStoreDeleteResponse
    {
        try {
            return $this->getClient()->vectorStores()->delete($id);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (
                Str::contains($exception->getMessage(), 'Expected an ID that begins with') ||
                Str::contains($exception->getMessage(), 'No vector store found with id')
            ) {
                throw new NotFound($exception->getMessage(), 500, $exception);
            }
            $this->globalExceptionHandler($exception);
        }
    }
}
