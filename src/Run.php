<?php

namespace SMSkin\LaravelOpenAi;

use Illuminate\Support\Collection;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\StreamResponse;
use OpenAI\Responses\Threads\Runs\ThreadRunListResponse;
use OpenAI\Responses\Threads\Runs\ThreadRunResponse;
use SMSkin\LaravelOpenAi\Controllers\Run\Cancel;
use SMSkin\LaravelOpenAi\Controllers\Run\Create;
use SMSkin\LaravelOpenAi\Controllers\Run\CreateStreamed;
use SMSkin\LaravelOpenAi\Controllers\Run\GetList;
use SMSkin\LaravelOpenAi\Controllers\Run\Modify;
use SMSkin\LaravelOpenAi\Controllers\Run\Retrieve;
use SMSkin\LaravelOpenAi\Controllers\Run\SubmitToolOutputs;
use SMSkin\LaravelOpenAi\Controllers\Run\SubmitToolOutputsStreamed;
use SMSkin\LaravelOpenAi\Enums\OrderEnum;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\InvalidState;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;
use SMSkin\LaravelOpenAi\Exceptions\RunInProcess;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Exceptions\VectorStoreIsExpired;
use SMSkin\LaravelOpenAi\Models\ToolOutput;

class Run
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
    ): ThreadRunListResponse {
        return (new GetList($threadId, $limit, $order, $after, $before))->execute();
    }

    /**
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @throws Exceptions\AssistantNotFound
     * @throws RunInProcess
     * @throws ThreadNotFound
     * @throws TransporterException
     * @throws VectorStoreIsExpired
     */
    public function create(string $threadId, Models\Run $run): ThreadRunResponse
    {
        return (new Create($threadId, $run))->execute();
    }

    /**
     * @throws ThreadNotFound
     * @throws VectorStoreIsExpired
     * @throws RunInProcess
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @throws Exceptions\AssistantNotFound
     */
    public function createStreamed(string $threadId, Models\Run $run): StreamResponse
    {
        return (new CreateStreamed($threadId, $run))->execute();
    }

    /**
     * @throws ThreadNotFound
     * @throws NotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function retrieve(string $threadId, string $runId): ThreadRunResponse
    {
        return (new Retrieve($threadId, $runId))->execute();
    }

    /**
     * @throws ThreadNotFound
     * @throws NotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function modify(string $threadId, string $runId, array|null $metadata = null): ThreadRunResponse
    {
        return (new Modify($threadId, $runId, $metadata))->execute();
    }

    /**
     * @throws InvalidState
     * @throws NotFound
     * @throws ThreadNotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function cancel(string $threadId, string $runId): ThreadRunResponse
    {
        return (new Cancel($threadId, $runId))->execute();
    }

    /**
     * @param string $threadId
     * @param string $runId
     * @param Collection<ToolOutput> $toolOutputs
     * @return ThreadRunResponse
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @throws Exceptions\ExpectedToolOutputs
     * @throws Exceptions\RunIsExpired
     * @throws ThreadNotFound
     * @throws TransporterException
     */
    public function submitToolOutputs(string $threadId, string $runId, Collection $toolOutputs): ThreadRunResponse
    {
        return (new SubmitToolOutputs())->execute($threadId, $runId, $toolOutputs);
    }

    /**
     * @param string $threadId
     * @param string $runId
     * @param Collection<ToolOutput> $toolOutputs
     * @return StreamResponse
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @throws Exceptions\ExpectedToolOutputs
     * @throws Exceptions\RunIsExpired
     * @throws ThreadNotFound
     * @throws TransporterException
     */
    public function submitToolOutputsStreamed(string $threadId, string $runId, Collection $toolOutputs): StreamResponse
    {
        return (new SubmitToolOutputsStreamed())->execute($threadId, $runId, $toolOutputs);
    }
}
