<?php

namespace SMSkin\LaravelOpenAi;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Threads\Messages\ThreadMessageDeleteResponse;
use OpenAI\Responses\Threads\Messages\ThreadMessageListResponse;
use OpenAI\Responses\Threads\Messages\ThreadMessageResponse;
use SMSkin\LaravelOpenAi\Controllers\Message\Create;
use SMSkin\LaravelOpenAi\Controllers\Message\Delete;
use SMSkin\LaravelOpenAi\Controllers\Message\GetList;
use SMSkin\LaravelOpenAi\Controllers\Message\Modify;
use SMSkin\LaravelOpenAi\Controllers\Message\Retrieve;
use SMSkin\LaravelOpenAi\Enums\OrderEnum;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\FileNotSupportedForRetrieval;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;
use SMSkin\LaravelOpenAi\Exceptions\RunInProcess;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Models\Message as MessageModel;

class Message
{
    /**
     * @throws ThreadNotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function getList(
        string         $threadId,
        int|null       $limit = null,
        OrderEnum|null $order = null,
        string|null    $after = null,
        string|null    $before = null,
        string|null    $runId = null
    ): ThreadMessageListResponse {
        return (new GetList())->execute($threadId, $limit, $order, $after, $before, $runId);
    }

    /**
     * @throws ThreadNotFound
     * @throws RunInProcess
     * @throws FileNotSupportedForRetrieval
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function create(string $threadId, MessageModel $message): ThreadMessageResponse
    {
        return (new Create())->execute($threadId, $message);
    }

    /**
     * @throws ThreadNotFound
     * @throws NotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function retrieve(string $threadId, string $messageId): ThreadMessageResponse
    {
        return (new Retrieve())->execute($threadId, $messageId);
    }

    /**
     * @throws ThreadNotFound
     * @throws NotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function modify(
        string     $threadId,
        string     $messageId,
        array|null $metadata = null
    ): ThreadMessageResponse {
        return (new Modify())->execute($threadId, $messageId, $metadata);
    }

    /**
     * @throws ThreadNotFound
     * @throws NotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function delete(string $threadId, string $messageId): ThreadMessageDeleteResponse
    {
        return (new Delete())->execute($threadId, $messageId);
    }
}
