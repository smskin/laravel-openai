<?php

namespace SMSkin\LaravelOpenAi\Controllers\Assistant;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Assistants\AssistantResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Exceptions\AssistanceNotFound;
use SMSkin\LaravelOpenAi\Models\BaseTool;

class Modify extends BaseController
{
    /**
     * @param string $assistantId
     * @param string|null $name
     * @param string|null $description
     * @param string|null $instructions
     * @param Collection<BaseTool>|null $tools
     */
    public function __construct(
        private readonly string $assistantId,
        private readonly string|null $name,
        private readonly string|null $description,
        private readonly string|null $instructions,
        private readonly Collection|null $tools
    ) {
    }

    /**
     * @return AssistantResponse
     * @throws AssistanceNotFound
     */
    public function execute(): AssistantResponse
    {
        try {
            return $this->getClient()->assistants()->modify($this->assistantId, $this->prepareData());
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'No assistant found with id')) {
                throw new AssistanceNotFound($exception->getMessage(), 500, $exception);
            }
            $this->errorExceptionHandler($exception);
        }
    }

    private function prepareData(): array
    {
        $data = [];
        if (filled($this->name)) {
            $data['name'] = $this->name;
        }
        if (filled($this->description)) {
            $data['description'] = $this->description;
        }
        if (filled($this->instructions)) {
            $data['instructions'] = $this->instructions;
        }
        if (filled($this->tools)) {
            $data['tools'] = $this->tools->map(static function (BaseTool $tool) {
                return $tool->toArray();
            });
        }
        return $data;
    }
}
