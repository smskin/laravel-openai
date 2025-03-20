<?php

namespace SMSkin\LaravelOpenAi\Controllers\Run;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Threads\Runs\ThreadRunResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Controllers\Run\Traits\CreateExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Controllers\Run\Traits\GetListExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\AssistantNotFound;
use SMSkin\LaravelOpenAi\Exceptions\RunInProcess;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Exceptions\VectorStoreIsExpired;
use SMSkin\LaravelOpenAi\Models\Run;

class Create extends BaseController
{
    use GetListExceptionHandlerTrait;
    use CreateExceptionHandlerTrait;

    /**
     * @throws ThreadNotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @throws AssistantNotFound
     * @throws RunInProcess
     * @throws VectorStoreIsExpired
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(string $threadId, Run $run): ThreadRunResponse
    {
        try {
            return $this->getClient()->threads()->runs()->create(
                $threadId,
                $run->toArray()
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->createExceptionHandler($exception);
            $this->getListExceptionHandler($exception);
            $this->globalExceptionHandler($exception);
        }
    }
}
