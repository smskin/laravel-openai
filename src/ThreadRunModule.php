<?php

namespace SMSkin\LaravelOpenAi;

use OpenAI\Responses\Threads\Runs\ThreadRunListResponse;
use OpenAI\Responses\Threads\Runs\ThreadRunResponse;
use SMSkin\LaravelOpenAi\Contracts\IThreadRunModule;
use SMSkin\LaravelOpenAi\Controllers\ThreadRun\Cancel;
use SMSkin\LaravelOpenAi\Controllers\ThreadRun\Create;
use SMSkin\LaravelOpenAi\Controllers\ThreadRun\GetList;
use SMSkin\LaravelOpenAi\Controllers\ThreadRun\Modify;
use SMSkin\LaravelOpenAi\Controllers\ThreadRun\Retrieve;
use SMSkin\LaravelOpenAi\Exceptions\AssistanceNotFound;
use SMSkin\LaravelOpenAi\Exceptions\RunInCompletedState;
use SMSkin\LaravelOpenAi\Exceptions\RunNotFound;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Jobs\ExecuteMethodJob;
use SMSkin\LaravelOpenAi\Models\MetaData;

class ThreadRunModule implements IThreadRunModule
{
    /**
     * @throws ThreadNotFound
     */
    public function getList(
        string   $threadId,
        int|null $limit = null
    ): ThreadRunListResponse {
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
        dispatch(new ExecuteMethodJob($correlationId, self::class, 'getList', $connection, $queue, $threadId, $limit));
    }

    /**
     * @throws ThreadNotFound
     * @throws AssistanceNotFound
     */
    public function create(
        string        $threadId,
        string        $assistantId,
        MetaData|null $metaData = null
    ): ThreadRunResponse {
        return (new Create($threadId, $assistantId, $metaData))->execute();
    }

    public function createAsync(
        string        $correlationId,
        string        $threadId,
        string        $assistantId,
        MetaData|null $metaData = null,
        string|null   $connection = null,
        string|null   $queue = null
    ): void {
        dispatch(new ExecuteMethodJob($correlationId, self::class, 'create', $connection, $queue, $threadId, $assistantId, $metaData));
    }

    /**
     * @throws ThreadNotFound
     * @throws RunNotFound
     */
    public function retrieve(
        string $threadId,
        string $runId
    ): ThreadRunResponse {
        return (new Retrieve($threadId, $runId))->execute();
    }

    public function retrieveAsync(
        string      $correlationId,
        string      $threadId,
        string      $runId,
        string|null $connection = null,
        string|null $queue = null
    ): void {
        dispatch(new ExecuteMethodJob($correlationId, self::class, 'retrieve', $connection, $queue, $threadId, $runId));
    }

    /**
     * @throws ThreadNotFound
     * @throws RunNotFound
     */
    public function modify(
        string        $threadId,
        string        $runId,
        MetaData|null $metaData = null
    ): ThreadRunResponse {
        return (new Modify($threadId, $runId, $metaData))->execute();
    }

    public function modifyAsync(
        string        $correlationId,
        string        $threadId,
        string        $runId,
        MetaData|null $metaData = null,
        string|null   $connection = null,
        string|null   $queue = null
    ): void {
        dispatch(new ExecuteMethodJob($correlationId, self::class, 'modify', $connection, $queue, $threadId, $runId, $metaData));
    }

    /**
     * @throws ThreadNotFound
     * @throws RunNotFound
     * @throws RunInCompletedState
     */
    public function cancel(
        string $threadId,
        string $runId
    ): ThreadRunResponse {
        return (new Cancel($threadId, $runId))->execute();
    }

    public function cancelAsync(
        string      $correlationId,
        string      $threadId,
        string      $runId,
        string|null $connection = null,
        string|null $queue = null
    ): void {
        dispatch(new ExecuteMethodJob($correlationId, self::class, 'cancel', $connection, $queue, $threadId, $runId));
    }
}
