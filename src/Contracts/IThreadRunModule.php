<?php

namespace SMSkin\LaravelOpenAi\Contracts;

use OpenAI\Responses\Threads\Runs\ThreadRunListResponse;
use OpenAI\Responses\Threads\Runs\ThreadRunResponse;
use SMSkin\LaravelOpenAi\Exceptions\AssistanceNotFound;
use SMSkin\LaravelOpenAi\Exceptions\RunNotFound;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Models\MetaData;

interface IThreadRunModule
{
    public function getList(
        string   $threadId,
        int|null $limit = null
    ): ThreadRunListResponse;

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

    /**
     * @throws ThreadNotFound
     * @throws RunNotFound
     */
    public function modify(
        string        $threadId,
        string        $runId,
        MetaData|null $metaData = null
    ): ThreadRunResponse;

    /**
     * @throws ThreadNotFound
     * @throws RunNotFound
     */
    public function cancel(
        string $threadId,
        string $runId
    ): ThreadRunResponse;
}
