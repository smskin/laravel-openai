<?php

namespace SMSkin\LaravelOpenAi\Controllers\AssistantFile;

use BaseController;
use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Assistants\Files\AssistantFileDeleteResponse;
use SMSkin\LaravelOpenAi\Exceptions\AssistanceNotFound;
use SMSkin\LaravelOpenAi\Exceptions\FileNotFound;

class Delete extends BaseController
{
    public function __construct(
        private readonly string $assistantId,
        private readonly string $fileId
    ) {
    }

    /**
     * @throws AssistanceNotFound
     * @throws FileNotFound
     */
    public function execute(): AssistantFileDeleteResponse
    {
        try {
            return $this->getClient()->assistants()->files()->delete(
                $this->assistantId,
                $this->fileId
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'No assistant file found with id')) {
                throw new FileNotFound();
            }
            if (Str::contains($exception->getMessage(), 'No assistant found with id')) {
                throw new AssistanceNotFound($exception->getMessage(), 500, $exception);
            }
            $this->errorExceptionHandler($exception);
        }
    }
}
