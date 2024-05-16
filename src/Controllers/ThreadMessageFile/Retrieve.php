<?php

namespace SMSkin\LaravelOpenAi\Controllers\ThreadMessageFile;

use BaseController;
use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Threads\Messages\Files\ThreadMessageFileResponse;
use SMSkin\LaravelOpenAi\Exceptions\MessageFileNotFound;
use SMSkin\LaravelOpenAi\Exceptions\MessageNotFound;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;

class Retrieve extends BaseController
{
    public function __construct(
        private readonly string $threadId,
        private readonly string $messageId,
        private readonly string $fileId
    ) {
    }

    /**
     * @throws MessageFileNotFound
     * @throws MessageNotFound
     * @throws ThreadNotFound
     */
    public function execute(): ThreadMessageFileResponse
    {
        try {
            return $this->getClient()->threads()->messages()->files()->retrieve(
                $this->threadId,
                $this->messageId,
                $this->fileId
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'No message file found with id')) {
                throw new MessageFileNotFound($exception->getMessage(), 500, $exception);
            }
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
