<?php

namespace SMSkin\LaravelOpenAi;

use Illuminate\Support\Collection;
use OpenAI\Responses\Assistants\AssistantDeleteResponse;
use OpenAI\Responses\Assistants\AssistantListResponse;
use OpenAI\Responses\Assistants\AssistantResponse;
use OpenAI\Responses\Assistants\Files\AssistantFileListResponse;
use SMSkin\LaravelOpenAi\Contracts\IAssistantModule;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Create;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Delete;
use SMSkin\LaravelOpenAi\Controllers\Assistant\GetList;
use SMSkin\LaravelOpenAi\Controllers\Assistant\ListFiles;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Modify;
use SMSkin\LaravelOpenAi\Controllers\Assistant\Retrieve;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Exceptions\AssistanceNotFound;
use SMSkin\LaravelOpenAi\Exceptions\NotValidModel;
use SMSkin\LaravelOpenAi\Models\BaseTool;

class AssistantModule implements IAssistantModule
{
    /**
     * @param int|null $limit
     * @return AssistantListResponse
     */
    public function getList(int|null $limit = null): AssistantListResponse
    {
        $limit ??= 10;
        return (new GetList($limit))->execute();
    }

    /**
     * @param ModelEnum $model
     * @param string|null $name
     * @param string|null $description
     * @param string|null $instructions
     * @param Collection<BaseTool>|null $tools
     * @return AssistantResponse
     * @throws NotValidModel
     */
    public function create(
        ModelEnum   $model,
        string|null     $name = null,
        string|null     $description = null,
        string|null     $instructions = null,
        Collection|null $tools = null
    ): AssistantResponse {
        return (new Create($model, $name, $description, $instructions, $tools))->execute();
    }

    /**
     * @throws AssistanceNotFound
     */
    public function retrieve(string $assistantId): AssistantResponse
    {
        return (new Retrieve($assistantId))->execute();
    }

    /**
     * @param string $assistantId
     * @param string|null $name
     * @param string|null $description
     * @param string|null $instructions
     * @param Collection<BaseTool>|null $tools
     * @return AssistantResponse
     * @throws AssistanceNotFound
     */
    public function modify(
        string          $assistantId,
        string|null     $name = null,
        string|null     $description = null,
        string|null     $instructions = null,
        Collection|null $tools = null
    ): AssistantResponse {
        return (new Modify($assistantId, $name, $description, $instructions, $tools))->execute();
    }

    /**
     * @throws AssistanceNotFound
     */
    public function delete(string $assistantId): AssistantDeleteResponse
    {
        return (new Delete($assistantId))->execute();
    }

    /**
     * @throws AssistanceNotFound
     */
    public function listFiles(string $assistantId, int|null $limit = null): AssistantFileListResponse
    {
        $limit ??= 10;
        return (new ListFiles($assistantId, $limit))->execute();
    }
}
