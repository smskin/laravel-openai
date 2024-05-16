<?php

namespace SMSkin\LaravelOpenAi\Controllers\AssistantFile;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Assistants\Files\AssistantFileResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Exceptions\AssistanceNotFound;
use SMSkin\LaravelOpenAi\Exceptions\FileNotFound;
use SMSkin\LaravelOpenAi\Exceptions\InvalidAssistantConfig;

class Create extends BaseController
{
    public function __construct(
        private readonly string $assistantId,
        private readonly string $fileId
    ) {
    }

    /**
     * @throws InvalidAssistantConfig
     * @throws AssistanceNotFound
     * @throws FileNotFound
     */
    public function execute(): AssistantFileResponse
    {
        try {
            return $this->getClient()->assistants()->files()->create($this->assistantId, [
                'file_id' => $this->fileId,
            ]);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'were not found')) {
                throw new FileNotFound();
            }
            if (Str::contains($exception->getMessage(), 'file_ids are only supported')) {
                throw new InvalidAssistantConfig($exception->getMessage(), 500, $exception);
            }
            if (Str::contains($exception->getMessage(), 'No assistant found with id')) {
                throw new AssistanceNotFound($exception->getMessage(), 500, $exception);
            }
            $this->errorExceptionHandler($exception);
        }
    }
}
