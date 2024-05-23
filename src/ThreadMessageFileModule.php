<?php

namespace SMSkin\LaravelOpenAi;

use OpenAI\Responses\Threads\Messages\Files\ThreadMessageFileListResponse;
use OpenAI\Responses\Threads\Messages\Files\ThreadMessageFileResponse;
use SMSkin\LaravelOpenAi\Contracts\IThreadMessageFileModule;
use SMSkin\LaravelOpenAi\Controllers\ThreadMessageFile\GetList;
use SMSkin\LaravelOpenAi\Controllers\ThreadMessageFile\Retrieve;
use SMSkin\LaravelOpenAi\Exceptions\MessageFileNotFound;
use SMSkin\LaravelOpenAi\Exceptions\MessageNotFound;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Jobs\ExecuteMethodJob;

class ThreadMessageFileModule implements IThreadMessageFileModule
{
    /**
     * @throws MessageNotFound
     * @throws ThreadNotFound
     */
    public function getList(
        string   $threadId,
        string   $messageId,
        int|null $limit = null
    ): ThreadMessageFileListResponse {
        $limit ??= 10;
        return (new GetList($threadId, $messageId, $limit))->execute();
    }

    public function getListAsync(
        string      $correlationId,
        string      $threadId,
        string      $messageId,
        int|null    $limit = null,
        string|null $connection = null,
        string|null $queue = null
    ): void {
        dispatch(new ExecuteMethodJob($correlationId, self::class, substr(__FUNCTION__, 0, -5), $connection, $queue, $threadId, $messageId, $limit));
    }

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

    public function retrieveAsync(
        string      $correlationId,
        string      $threadId,
        string      $messageId,
        string      $fileId,
        string|null $connection = null,
        string|null $queue = null
    ): void {
        dispatch(new ExecuteMethodJob($correlationId, self::class, substr(__FUNCTION__, 0, -5), $connection, $queue, $threadId, $messageId, $fileId));
    }
}
