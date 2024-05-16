<?php

namespace SMSkin\LaravelOpenAi;

use OpenAI\Responses\Threads\Messages\Files\ThreadMessageFileResponse;
use SMSkin\LaravelOpenAi\Contracts\IThreadMessageFileModule;
use SMSkin\LaravelOpenAi\Controllers\ThreadMessageFile\Retrieve;
use SMSkin\LaravelOpenAi\Exceptions\MessageFileNotFound;
use SMSkin\LaravelOpenAi\Exceptions\MessageNotFound;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;

class ThreadMessageFileModule implements IThreadMessageFileModule
{
    /**
     * @throws MessageNotFound
     * @throws MessageFileNotFound
     * @throws ThreadNotFound
     */
    public function retrieve(
        string $threadId,
        string $messageId,
        string $fileId
    ): ThreadMessageFileResponse {
        return (new Retrieve($threadId, $messageId, $fileId))->execute();
    }
}
