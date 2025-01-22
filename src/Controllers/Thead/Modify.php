<?php

namespace SMSkin\LaravelOpenAi\Controllers\Thead;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Threads\ThreadResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Controllers\Thead\Traits\RetrieveExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;
use SMSkin\LaravelOpenAi\Models\CodeInterpreterToolResource;
use SMSkin\LaravelOpenAi\Models\FileSearchToolResource;

class Modify extends BaseController
{
    use RetrieveExceptionHandlerTrait;

    public function __construct(
        private readonly string $id,
        private readonly CodeInterpreterToolResource|null $codeInterpreterToolResource,
        private readonly FileSearchToolResource|null $fileSearchToolResource,
        private readonly array|null $metadata,
    ) {
    }

    /**
     * @throws NotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(): ThreadResponse
    {
        try {
            return $this->getClient()->threads()->modify(
                $this->id,
                $this->prepareData()
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->retrieveExceptionHandler($exception);
            $this->globalExceptionHandler($exception);
        }
    }

    private function prepareData(): array
    {
        $payload = [];
        if ($this->codeInterpreterToolResource) {
            $payload['tool_resources']['code_interpreter'] = $this->codeInterpreterToolResource->toArray();
        }
        if ($this->fileSearchToolResource) {
            $payload['tool_resources']['file_search'] = $this->fileSearchToolResource->toArray();
        }
        if ($this->metadata) {
            $payload['metadata'] = $this->metadata;
        }
        return $payload;
    }
}
