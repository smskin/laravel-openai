<?php

namespace SMSkin\LaravelOpenAi\Contracts;

use OpenAI\Responses\Threads\Messages\Files\ThreadMessageFileResponse;
use SMSkin\LaravelOpenAi\Exceptions\MessageFileNotFound;
use SMSkin\LaravelOpenAi\Exceptions\MessageNotFound;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;

interface IThreadMessageFileModule
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
    ): ThreadMessageFileResponse;
}
