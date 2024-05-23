<?php

namespace SMSkin\LaravelOpenAi\Contracts;

use OpenAI\Responses\Threads\Messages\Files\ThreadMessageFileListResponse;
use OpenAI\Responses\Threads\Messages\Files\ThreadMessageFileResponse;
use SMSkin\LaravelOpenAi\Exceptions\MessageFileNotFound;
use SMSkin\LaravelOpenAi\Exceptions\MessageNotFound;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;

interface IThreadMessageFileModule
{
    /**
     * @throws MessageNotFound
     * @throws ThreadNotFound
     */
    public function getList(
        string   $threadId,
        string   $messageId,
        int|null $limit = null
    ): ThreadMessageFileListResponse;

    public function getListAsync(
        string      $correlationId,
        string      $threadId,
        string      $messageId,
        int|null    $limit = null,
        string|null $connection = null,
        string|null $queue = null
    ): void;

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

    public function retrieveAsync(
        string      $correlationId,
        string      $threadId,
        string      $messageId,
        string      $fileId,
        string|null $connection = null,
        string|null $queue = null
    ): void;
}
