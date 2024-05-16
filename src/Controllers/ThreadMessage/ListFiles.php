<?php

namespace SMSkin\LaravelOpenAi\Controllers\ThreadMessage;

use BaseController;
use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Threads\Messages\Files\ThreadMessageFileListResponse;
use SMSkin\LaravelOpenAi\Exceptions\MessageNotFound;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;

class ListFiles extends BaseController
{
    public function __construct(
        private readonly string $threadId,
        private readonly string $messageId,
        private readonly int|null $limit
    ) {
    }

    /**
     * @throws MessageNotFound
     * @throws ThreadNotFound
     */
    public function execute(): ThreadMessageFileListResponse
    {
        try {
            return $this->getClient()->threads()->messages()->files()->list(
                $this->threadId,
                $this->messageId,
                [
                    'limit' => $this->limit,
                ]
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'No thread found with id')) {
                throw new ThreadNotFound($exception->getMessage(), 500, $exception);
            }
            if (Str::contains($exception->getMessage(), 'No message found with id')) {
                throw new MessageNotFound($exception->getMessage(), 500, $exception);
            }

            $this->errorExceptionHandler($exception);
        }
    }
}
