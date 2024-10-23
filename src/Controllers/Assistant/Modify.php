<?php

namespace SMSkin\LaravelOpenAi\Controllers\Assistant;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Assistants\AssistantResponse;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Traits\CreateExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Traits\RetrieveExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Enums\ResponseFormatEnum;
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

    public function __construct(
        private readonly string $id,
        private readonly ModelEnum $model,
        private readonly string|null $name,
        private readonly string|null $description,
        private readonly string|null $instructions,
        private readonly bool|null $codeInterpreterTool,
        private readonly bool|null $fileSearchTool,
        private readonly FunctionToolConfig|null $functionTool,
        private readonly CodeInterpreterToolResource|null $codeInterpreterToolResource,
        private readonly FileSearchToolResource|null $fileSearchToolResource,
        private readonly array|null $metadata,
        private readonly int|null $temperature,
        private readonly int|null $topP,
        private readonly ResponseFormatEnum|null $responseFormat
    ) {
    }

    /**
     * @throws InvalidModel
     * @throws InvalidFunctionName
     * @throws NotFound
     */
    public function execute(): AssistantResponse
    {
        try {
            return $this->getClient()->assistants()->modify(
                $this->id,
                $this->prepareData()
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->createExceptionHandler($exception);
            $this->retrieveExceptionHandler($exception);
            $this->globalExceptionHandler($exception);
        }
    }

    private function prepareData(): array
    {
        $payload = [
            'model' => $this->model,
        ];
        if ($this->name) {
            $payload['name'] = $this->name;
        }
        if ($this->description) {
            $payload['description'] = $this->description;
        }
        if ($this->instructions) {
            $payload['instructions'] = $this->instructions;
        }
        if ($this->codeInterpreterTool) {
            $payload['tools'][] = [
                'type' => 'code_interpreter',
            ];
        }
        if ($this->fileSearchTool) {
            $payload['tools'][] = [
                'type' => 'file_search',
            ];
        }
        if ($this->functionTool) {
            $payload['tools'][] = [
                'type' => 'function',
                'function' => $this->functionTool->toArray(),
            ];
        }
        if ($this->codeInterpreterToolResource) {
            $payload['tool_resources']['code_interpreter'] = $this->codeInterpreterToolResource->toArray();
        }
        if ($this->fileSearchToolResource) {
            $payload['tool_resources']['file_search'] = $this->fileSearchToolResource->toArray();
        }
        if ($this->metadata) {
            $payload['metadata'] = $this->metadata;
        }
        if ($this->temperature !== null) {
            $payload['temperature'] = $this->temperature;
        }
        if ($this->topP !== null) {
            $payload['top_p'] = $this->topP;
        }
        if ($this->responseFormat) {
            $payload['response_format'] = $this->responseFormat->value;
        }
        return $payload;
    }
}
