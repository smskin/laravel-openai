<?php

namespace SMSkin\LaravelOpenAi\Models;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Enums\ResponseFormatEnum;

class Run implements Arrayable
{
    public function __construct(
        private readonly string $assistantId,
        private readonly ModelEnum|null $model = null,
        private readonly string|null $instructions = null,
        private readonly string|null $additionalInstructions = null,
        private readonly Collection|null $additionalMessages = null,
        private readonly bool|null $codeInterpreterTool = null,
        private readonly bool|null $fileSearchTool = null,
        private readonly FunctionToolConfig|null $functionTool = null,
        private readonly array|null $metadata = null,
        private readonly int|null $temperature = null,
        private readonly int|null $topP = null,
        private readonly bool|null $stream = null,
        private readonly int|null $maxPromptTokens = null,
        private readonly int|null $maxCompletionTokens = null,
        private readonly TruncationStrategy|null $truncationStrategy = null,
        private readonly string|ToolChoice|null $toolChoice = null,
        private readonly bool|null $parallelToolCalls = null,
        private readonly ResponseFormatEnum|null $responseFormat = null
    ) {
    }

    public function toArray(): array
    {
        $payload = [
            'assistant_id' => $this->assistantId,
        ];
        if ($this->model) {
            $payload['model'] = $this->model;
        }
        if ($this->instructions) {
            $payload['instructions'] = $this->instructions;
        }
        if ($this->additionalInstructions) {
            $payload['additional_instructions'] = $this->additionalInstructions;
        }
        if ($this->additionalMessages) {
            $payload['additional_messages'] = $this->additionalMessages->map(static function (Message $message) {
                return $message->toArray();
            })->toArray();
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
        if ($this->metadata) {
            $payload['metadata'] = $this->metadata;
        }
        if ($this->temperature !== null) {
            $payload['temperature'] = $this->temperature;
        }
        if ($this->topP !== null) {
            $payload['top_p'] = $this->topP;
        }
        if ($this->stream !== null) {
            $payload['stream'] = $this->stream;
        }
        if ($this->maxPromptTokens !== null) {
            $payload['max_prompt_tokens'] = $this->maxPromptTokens;
        }
        if ($this->maxCompletionTokens !== null) {
            $payload['max_completion_tokens'] = $this->maxCompletionTokens;
        }
        if ($this->truncationStrategy) {
            $payload['truncation_strategy'] = $this->truncationStrategy->toArray();
        }
        if ($this->toolChoice instanceof ToolChoice) {
            $payload['tool_choice'] = $this->toolChoice->toArray();
        } elseif (is_string($this->toolChoice)) {
            $payload['tool_choice'] = $this->toolChoice;
        }
        if ($this->parallelToolCalls !== null) {
            $payload['parallel_tool_calls'] = $this->parallelToolCalls;
        }
        if ($this->responseFormat) {
            $payload['response_format'] = $this->responseFormat->value;
        }
        return $payload;
    }

    /**
     * @return string
     */
    public function getAssistantId(): string
    {
        return $this->assistantId;
    }
}
