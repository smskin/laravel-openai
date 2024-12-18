<?php

namespace SMSkin\LaravelOpenAi;

use OpenAI\Responses\StreamResponse;
use OpenAI\Responses\Threads\Runs\ThreadRunListResponse;
use OpenAI\Responses\Threads\Runs\ThreadRunResponse;
use SMSkin\LaravelOpenAi\Controllers\Run\Cancel;
use SMSkin\LaravelOpenAi\Controllers\Run\Create;
use SMSkin\LaravelOpenAi\Controllers\Run\CreateStreamed;
use SMSkin\LaravelOpenAi\Controllers\Run\GetList;
use SMSkin\LaravelOpenAi\Controllers\Run\Modify;
use SMSkin\LaravelOpenAi\Controllers\Run\Retrieve;
use SMSkin\LaravelOpenAi\Enums\OrderEnum;
use SMSkin\LaravelOpenAi\Exceptions\InvalidState;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Exceptions\VectorStoreIsExpired;

class Run
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
    ): ThreadRunListResponse {
        return (new GetList($threadId, $limit, $order, $after, $before))->execute();
    }

    /**
     * @throws ThreadNotFound
     */
    public function create(string $threadId, Models\Run $run): ThreadRunResponse
    {
        return (new Create($threadId, $run))->execute();
    }

    /**
     * @throws ThreadNotFound
     * @throws VectorStoreIsExpired
     */
    public function createStreamed(string $threadId, Models\Run $run): StreamResponse
    {
        return (new CreateStreamed($threadId, $run))->execute();
    }

    /**
     * @throws ThreadNotFound
     * @throws NotFound
     */
    public function retrieve(string $threadId, string $runId): ThreadRunResponse
    {
        return (new Retrieve($threadId, $runId))->execute();
    }

    /**
     * @throws ThreadNotFound
     * @throws NotFound
     */
    public function modify(string $threadId, string $runId, array|null $metadata = null): ThreadRunResponse
    {
        return (new Modify($threadId, $runId, $metadata))->execute();
    }

    /**
     * @throws InvalidState
     * @throws NotFound
     * @throws ThreadNotFound
     */
    public function cancel(string $threadId, string $runId): ThreadRunResponse
    {
        return (new Cancel($threadId, $runId))->execute();
    }
}
