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
}
