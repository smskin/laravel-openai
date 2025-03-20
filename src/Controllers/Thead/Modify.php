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

    /**
     * @throws NotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(
        string                           $id,
        CodeInterpreterToolResource|null $codeInterpreterToolResource,
        FileSearchToolResource|null      $fileSearchToolResource,
        array|null                       $metadata
    ): ThreadResponse {
        try {
            return $this->getClient()->threads()->modify(
                $id,
                $this->prepareData($codeInterpreterToolResource, $fileSearchToolResource, $metadata)
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->retrieveExceptionHandler($exception);
            $this->globalExceptionHandler($exception);
        }
    }

    private function prepareData(
        CodeInterpreterToolResource|null $codeInterpreterToolResource,
        FileSearchToolResource|null      $fileSearchToolResource,
        array|null                       $metadata
    ): array {
        $payload = [];
        if ($codeInterpreterToolResource) {
            $payload['tool_resources']['code_interpreter'] = $codeInterpreterToolResource->toArray();
        }
        if ($fileSearchToolResource) {
            $payload['tool_resources']['file_search'] = $fileSearchToolResource->toArray();
        }
        if ($metadata) {
            $payload['metadata'] = $metadata;
        }
        return $payload;
    }
}
