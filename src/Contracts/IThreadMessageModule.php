<?php

namespace SMSkin\LaravelOpenAi\Contracts;

use Illuminate\Support\Collection;
use OpenAI\Responses\Threads\Messages\ThreadMessageListResponse;
use OpenAI\Responses\Threads\Messages\ThreadMessageResponse;
use SMSkin\LaravelOpenAi\Enums\RoleEnum;
use SMSkin\LaravelOpenAi\Exceptions\MessageNotFound;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Models\MetaData;

interface IThreadMessageModule
{
    /**
     * @throws ThreadNotFound
     */
    public function getList(
        string   $threadId,
        int|null $limit = null
    ): ThreadMessageListResponse;

    public function getListAsync(
        string      $correlationId,
        string      $threadId,
        int|null    $limit = null,
        string|null $connection = null,
        string|null $queue = null
    ): void;

    /**
     * @throws ThreadNotFound
     */
    public function create(
        string          $threadId,
        RoleEnum        $role,
        string          $content,
        Collection|null $attachments = null
    ): ThreadMessageResponse;

    public function createAsync(
        string          $correlationId,
        string          $threadId,
        RoleEnum        $role,
        string          $content,
        Collection|null $attachments = null,
        string|null     $connection = null,
        string|null     $queue = null
    ): void;

    /**
     * @throws MessageNotFound
     * @throws ThreadNotFound
     */
    public function retrieve(
        string $threadId,
        string $messageId
    ): ThreadMessageResponse;

    public function retrieveAsync(
        string      $correlationId,
        string      $threadId,
        string      $messageId,
        string|null $connection = null,
        string|null $queue = null
    ): void;

    /**
     * @throws MessageNotFound
     * @throws ThreadNotFound
     */
    public function modify(
        string        $threadId,
        string        $messageId,
        MetaData|null $metaData = null
    ): ThreadMessageResponse;

    public function modifyAsync(
        string        $correlationId,
        string        $threadId,
        string        $messageId,
        MetaData|null $metaData = null,
        string|null   $connection = null,
        string|null   $queue = null
    ): void;

    public function files(): IThreadMessageFileModule;
}
