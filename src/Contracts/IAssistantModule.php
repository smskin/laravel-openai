<?php

namespace SMSkin\LaravelOpenAi\Contracts;

use Illuminate\Support\Collection;
use OpenAI\Responses\Assistants\AssistantDeleteResponse;
use OpenAI\Responses\Assistants\AssistantListResponse;
use OpenAI\Responses\Assistants\AssistantResponse;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Exceptions\AssistanceNotFound;
use SMSkin\LaravelOpenAi\Exceptions\NotValidModel;
use SMSkin\LaravelOpenAi\Exceptions\RetrievalToolNotSupported;
use SMSkin\LaravelOpenAi\Models\BaseTool;

interface IAssistantModule
{
    public function getList(int|null $limit = null): AssistantListResponse;

    /**
     * @param ModelEnum $model
     * @param string|null $name
     * @param string|null $description
     * @param string|null $instructions
     * @param Collection<BaseTool>|null $tools
     * @return AssistantResponse
     * @throws NotValidModel
     * @throws RetrievalToolNotSupported
     */
    public function create(
        ModelEnum       $model,
        string|null     $name = null,
        string|null     $description = null,
        string|null     $instructions = null,
        Collection|null $tools = null
    ): AssistantResponse;

    /**
     * @throws AssistanceNotFound
     */
    public function retrieve(string $assistantId): AssistantResponse;

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
    ): AssistantResponse;

    /**
     * @throws AssistanceNotFound
     */
    public function delete(string $assistantId): AssistantDeleteResponse;

    public function files(): IAssistantFileModule;
}
