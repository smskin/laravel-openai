<?php

namespace SMSkin\LaravelOpenAi;

use OpenAI\Responses\Threads\Messages\ThreadMessageDeleteResponse;
use OpenAI\Responses\Threads\Messages\ThreadMessageListResponse;
use OpenAI\Responses\Threads\Messages\ThreadMessageResponse;
use SMSkin\LaravelOpenAi\Controllers\Message\Create;
use SMSkin\LaravelOpenAi\Controllers\Message\Delete;
use SMSkin\LaravelOpenAi\Controllers\Message\GetList;
use SMSkin\LaravelOpenAi\Controllers\Message\Modify;
use SMSkin\LaravelOpenAi\Controllers\Message\Retrieve;
use SMSkin\LaravelOpenAi\Enums\OrderEnum;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Models\Message as MessageModel;

class Message
{
    /**
     * @throws ThreadNotFound
     */
    public function getList(
        string         $threadId,
        int|null       $limit = null,
        OrderEnum|null $order = null,
        string|null    $after = null,
        string|null    $before = null,
        string|null    $runId = null
    ): ThreadMessageListResponse {
        return (new GetList($threadId, $limit, $order, $after, $before, $runId))->execute();
    }

    /**
     * @throws ThreadNotFound
     */
    public function create(string $threadId, MessageModel $message): ThreadMessageResponse
    {
        return (new Create($threadId, $message))->execute();
    }

    /**
     * @throws ThreadNotFound
     * @throws NotFound
     */
    public function retrieve(string $threadId, string $messageId): ThreadMessageResponse
    {
        return (new Retrieve($threadId, $messageId))->execute();
    }

    /**
     * @throws ThreadNotFound
     * @throws NotFound
     */
    public function modify(
        string     $threadId,
        string     $messageId,
        array|null $metadata = null
    ): ThreadMessageResponse {
        return (new Modify($threadId, $messageId, $metadata))->execute();
    }

    /**
     * @throws ThreadNotFound
     * @throws NotFound
     */
    public function delete(string $threadId, string $messageId): ThreadMessageDeleteResponse
    {
        return (new Delete($threadId, $messageId))->execute();
    }
}
