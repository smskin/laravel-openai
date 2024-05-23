<?php

namespace SMSkin\LaravelOpenAi;

use Illuminate\Support\Collection;
use OpenAI\Responses\Threads\Messages\ThreadMessageListResponse;
use OpenAI\Responses\Threads\Messages\ThreadMessageResponse;
use SMSkin\LaravelOpenAi\Contracts\IThreadMessageFileModule;
use SMSkin\LaravelOpenAi\Contracts\IThreadMessageModule;
use SMSkin\LaravelOpenAi\Controllers\ThreadMessage\Create;
use SMSkin\LaravelOpenAi\Controllers\ThreadMessage\GetList;
use SMSkin\LaravelOpenAi\Controllers\ThreadMessage\Modify;
use SMSkin\LaravelOpenAi\Controllers\ThreadMessage\Retrieve;
use SMSkin\LaravelOpenAi\Enums\RoleEnum;
use SMSkin\LaravelOpenAi\Exceptions\MessageNotFound;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Jobs\ExecuteMethodJob;
use SMSkin\LaravelOpenAi\Models\MetaData;

class ThreadMessageModule implements IThreadMessageModule
{
    /**
     * @throws ThreadNotFound
     */
    public function getList(
        string   $threadId,
        int|null $limit = null
    ): ThreadMessageListResponse {
        $limit ??= 10;
        return (new GetList($threadId, $limit))->execute();
    }

    public function getListAsync(
        string      $correlationId,
        string      $threadId,
        int|null    $limit = null,
        string|null $connection = null,
        string|null $queue = null
    ): void {
        dispatch(new ExecuteMethodJob($correlationId, self::class, substr(__FUNCTION__, 0, -5), $connection, $queue, $threadId, $limit));
    }

    /**
     * @throws ThreadNotFound
     */
    public function create(
        string          $threadId,
        RoleEnum        $role,
        string          $content,
        Collection|null $attachments = null
    ): ThreadMessageResponse {
        return (new Create($threadId, $role, $content, $attachments))->execute();
    }

    public function createAsync(
        string          $correlationId,
        string          $threadId,
        RoleEnum        $role,
        string          $content,
        Collection|null $attachments = null,
        string|null     $connection = null,
        string|null     $queue = null
    ): void {
        dispatch(new ExecuteMethodJob($correlationId, self::class, substr(__FUNCTION__, 0, -5), $connection, $queue, $threadId, $role, $content, $attachments));
    }

    /**
     * @throws MessageNotFound
     * @throws ThreadNotFound
     */
    public function retrieve(
        string $threadId,
        string $messageId
    ): ThreadMessageResponse {
        return (new Retrieve($threadId, $messageId))->execute();
    }

    public function retrieveAsync(
        string      $correlationId,
        string      $threadId,
        string      $messageId,
        string|null $connection = null,
        string|null $queue = null
    ): void {
        dispatch(new ExecuteMethodJob($correlationId, self::class, substr(__FUNCTION__, 0, -5), $connection, $queue, $threadId, $messageId));
    }

    /**
     * @throws MessageNotFound
     * @throws ThreadNotFound
     */
    public function modify(
        string        $threadId,
        string        $messageId,
        MetaData|null $metaData = null
    ): ThreadMessageResponse {
        return (new Modify($threadId, $messageId, $metaData))->execute();
    }

    public function modifyAsync(
        string        $correlationId,
        string        $threadId,
        string        $messageId,
        MetaData|null $metaData = null,
        string|null   $connection = null,
        string|null   $queue = null
    ): void {
        dispatch(new ExecuteMethodJob($correlationId, self::class, substr(__FUNCTION__, 0, -5), $connection, $queue, $threadId, $messageId, $metaData));
    }

    public function files(): IThreadMessageFileModule
    {
        return app(IThreadMessageFileModule::class);
    }
}
