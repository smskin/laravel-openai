<?php

namespace SMSkin\LaravelOpenAi\Controllers\ThreadMessage;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Threads\Messages\ThreadMessageResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Exceptions\MessageNotFound;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;

class Retrieve extends BaseController
{
    public function __construct(
        private readonly string $threadId,
        private readonly string $messageId
    ) {
    }

    /**
     * @throws MessageNotFound
     * @throws ThreadNotFound
     */
    public function execute(): ThreadMessageResponse
    {
        try {
            return $this->getClient()->threads()->messages()->retrieve(
                $this->threadId,
                $this->messageId
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
