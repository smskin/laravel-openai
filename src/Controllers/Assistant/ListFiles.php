<?php

namespace SMSkin\LaravelOpenAi\Controllers\Assistant;

use BaseController;
use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Assistants\Files\AssistantFileListResponse;
use SMSkin\LaravelOpenAi\Exceptions\AssistanceNotFound;

class ListFiles extends BaseController
{
    public function __construct(
        private readonly string $assistantId,
        private readonly int $limit
    ) {
    }

    /**
     * @return AssistantFileListResponse
     * @throws AssistanceNotFound
     */
    public function execute(): AssistantFileListResponse
    {
        try {
            return $this->getClient()->assistants()->files()->list($this->assistantId, [
                'limit' => $this->limit,
            ]);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'No assistant found with id')) {
                throw new AssistanceNotFound($exception->getMessage(), 500, $exception);
            }
            $this->errorExceptionHandler($exception);
        }
    }
}
