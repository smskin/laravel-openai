<?php

namespace SMSkin\LaravelOpenAi\Contracts;

use OpenAI\Responses\Threads\Runs\ThreadRunListResponse;
use OpenAI\Responses\Threads\Runs\ThreadRunResponse;
use SMSkin\LaravelOpenAi\Exceptions\AssistanceNotFound;
use SMSkin\LaravelOpenAi\Exceptions\RunInCompletedState;
use SMSkin\LaravelOpenAi\Exceptions\RunNotFound;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Models\MetaData;

interface IThreadRunModule
{
    public function getList(
        string   $threadId,
        int|null $limit = null
    ): ThreadRunListResponse;

    public function getListAsync(
        string      $correlationId,
        string      $threadId,
        int|null    $limit = null,
        string|null $connection = null,
        string|null $queue = null
    ): void;

    /**
     * @throws ThreadNotFound
     * @throws AssistanceNotFound
     */
    public function create(
        string        $threadId,
        string        $assistantId,
        MetaData|null $metaData = null
    ): ThreadRunResponse;

    /**
     * @throws ThreadNotFound
     * @throws RunNotFound
     */
    public function retrieve(
        string $threadId,
        string $runId
    ): ThreadRunResponse;

    public function retrieveAsync(
        string      $correlationId,
        string      $threadId,
        string      $runId,
        string|null $connection = null,
        string|null $queue = null
    ): void;

    /**
     * @throws ThreadNotFound
     * @throws RunNotFound
     */
    public function modify(
        string        $threadId,
        string        $runId,
        MetaData|null $metaData = null
    ): ThreadRunResponse;

    public function modifyAsync(
        string        $correlationId,
        string        $threadId,
        string        $runId,
        MetaData|null $metaData = null,
        string|null   $connection = null,
        string|null   $queue = null
    ): void;

    /**
     * @throws ThreadNotFound
     * @throws RunNotFound
     * @throws RunInCompletedState
     */
    public function cancel(
        string $threadId,
        string $runId
    ): ThreadRunResponse;

    public function cancelAsync(
        string      $correlationId,
        string      $threadId,
        string      $runId,
        string|null $connection = null,
        string|null $queue = null
    ): void;
}
