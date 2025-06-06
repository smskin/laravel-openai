<?php

namespace SMSkin\LaravelOpenAi;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Assistants\AssistantDeleteResponse;
use OpenAI\Responses\Assistants\AssistantListResponse;
use OpenAI\Responses\Assistants\AssistantResponse;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Create;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Delete;
use SMSkin\LaravelOpenAi\Controllers\Assistant\GetList;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Modify;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Retrieve;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Enums\OrderEnum;
use SMSkin\LaravelOpenAi\Enums\ResponseFormatEnum;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\InvalidFunctionName;
use SMSkin\LaravelOpenAi\Exceptions\InvalidModel;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;
use SMSkin\LaravelOpenAi\Models\CodeInterpreterToolResource;
use SMSkin\LaravelOpenAi\Models\FileSearchToolResource;
use SMSkin\LaravelOpenAi\Models\FunctionToolConfig;

class Assistant
{
    /**
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function getList(
        int|null       $limit = null,
        OrderEnum|null $order = null,
        string|null    $after = null,
        string|null    $before = null,
    ): AssistantListResponse {
        return (new GetList())->execute($limit, $order, $after, $before);
    }

    /**
     * @throws ErrorException
     * @throws ApiServerHadProcessingError
     * @throws InvalidFunctionName
     * @throws InvalidModel
     * @throws TransporterException
     */
    public function create(
        ModelEnum                        $model,
        string|null                      $name = null,
        string|null                      $description = null,
        string|null                      $instructions = null,
        bool|null                        $codeInterpreterTool = null,
        bool|null                        $fileSearchTool = null,
        FunctionToolConfig|null          $functionTool = null,
        CodeInterpreterToolResource|null $codeInterpreterToolResource = null,
        FileSearchToolResource|null      $fileSearchToolResource = null,
        array|null                       $metadata = null,
        int|null                         $temperature = null,
        int|null                         $topP = null,
        ResponseFormatEnum|null          $responseFormat = null
    ): AssistantResponse {
        return (new Create())->execute($model, $name, $description, $instructions, $codeInterpreterTool, $fileSearchTool, $functionTool, $codeInterpreterToolResource, $fileSearchToolResource, $metadata, $temperature, $topP, $responseFormat);
    }

    /**
     * @throws NotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function retrieve(string $id): AssistantResponse
    {
        return (new Retrieve())->execute($id);
    }

    /**
     * @throws InvalidModel
     * @throws InvalidFunctionName
     * @throws NotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function modify(
        string                           $id,
        ModelEnum                        $model,
        string|null                      $name = null,
        string|null                      $description = null,
        string|null                      $instructions = null,
        bool|null                        $codeInterpreterTool = null,
        bool|null                        $fileSearchTool = null,
        FunctionToolConfig|null          $functionTool = null,
        CodeInterpreterToolResource|null $codeInterpreterToolResource = null,
        FileSearchToolResource|null      $fileSearchToolResource = null,
        array|null                       $metadata = null,
        int|null                         $temperature = null,
        int|null                         $topP = null,
        ResponseFormatEnum|null          $responseFormat = null
    ): AssistantResponse {
        return (new Modify())->execute($id, $model, $name, $description, $instructions, $codeInterpreterTool, $fileSearchTool, $functionTool, $codeInterpreterToolResource, $fileSearchToolResource, $metadata, $temperature, $topP, $responseFormat);
    }

    /**
     * @throws NotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function delete(string $id): AssistantDeleteResponse
    {
        return (new Delete())->execute($id);
    }
}
