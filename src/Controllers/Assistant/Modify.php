<?php

namespace SMSkin\LaravelOpenAi\Controllers\Assistant;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Assistants\AssistantResponse;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Traits\CreateExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Traits\RetrieveExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Enums\ResponseFormatEnum;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\InvalidFunctionName;
use SMSkin\LaravelOpenAi\Exceptions\InvalidModel;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;
use SMSkin\LaravelOpenAi\Models\CodeInterpreterToolResource;
use SMSkin\LaravelOpenAi\Models\FileSearchToolResource;
use SMSkin\LaravelOpenAi\Models\FunctionToolConfig;

class Modify extends BaseController
{
    use CreateExceptionHandlerTrait;
    use RetrieveExceptionHandlerTrait;

    /**
     * @throws InvalidModel
     * @throws InvalidFunctionName
     * @throws NotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(
        string                           $id,
        ModelEnum                        $model,
        string|null                      $name,
        string|null                      $description,
        string|null                      $instructions,
        bool|null                        $codeInterpreterTool,
        bool|null                        $fileSearchTool,
        FunctionToolConfig|null          $functionTool,
        CodeInterpreterToolResource|null $codeInterpreterToolResource,
        FileSearchToolResource|null      $fileSearchToolResource,
        array|null                       $metadata,
        int|null                         $temperature,
        int|null                         $topP,
        ResponseFormatEnum|null          $responseFormat
    ): AssistantResponse {
        try {
            return $this->getClient()->assistants()->modify(
                $id,
                $this->prepareData($model, $name, $description, $instructions, $codeInterpreterTool, $fileSearchTool, $functionTool, $codeInterpreterToolResource, $fileSearchToolResource, $metadata, $temperature, $topP, $responseFormat)
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->createExceptionHandler($exception);
            $this->retrieveExceptionHandler($exception);
            $this->globalExceptionHandler($exception);
        }
    }

    private function prepareData(
        ModelEnum                        $model,
        string|null                      $name,
        string|null                      $description,
        string|null                      $instructions,
        bool|null                        $codeInterpreterTool,
        bool|null                        $fileSearchTool,
        FunctionToolConfig|null          $functionTool,
        CodeInterpreterToolResource|null $codeInterpreterToolResource,
        FileSearchToolResource|null      $fileSearchToolResource,
        array|null                       $metadata,
        int|null                         $temperature,
        int|null                         $topP,
        ResponseFormatEnum|null          $responseFormat
    ): array {
        $payload = compact('model');

        if ($name) {
            $payload['name'] = $name;
        }
        if ($description) {
            $payload['description'] = $description;
        }
        if ($instructions) {
            $payload['instructions'] = $instructions;
        }
        if ($codeInterpreterTool) {
            $payload['tools'][] = [
                'type' => 'code_interpreter',
            ];
        }
        if ($fileSearchTool) {
            $payload['tools'][] = [
                'type' => 'file_search',
            ];
        }
        if ($functionTool) {
            $payload['tools'][] = [
                'type' => 'function',
                'function' => $functionTool->toArray(),
            ];
        }
        if ($codeInterpreterToolResource) {
            $payload['tool_resources']['code_interpreter'] = $codeInterpreterToolResource->toArray();
        }
        if ($fileSearchToolResource) {
            $payload['tool_resources']['file_search'] = $fileSearchToolResource->toArray();
        }
        if ($metadata) {
            $payload['metadata'] = $metadata;
        }
        if ($temperature !== null) {
            $payload['temperature'] = $temperature;
        }
        if ($topP !== null) {
            $payload['top_p'] = $topP;
        }
        if ($responseFormat) {
            $payload['response_format'] = $responseFormat->value;
        }
        return $payload;
    }
}
