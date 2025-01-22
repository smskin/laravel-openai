<?php

namespace SMSkin\LaravelOpenAi\Controllers\Run;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Threads\Runs\ThreadRunResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Controllers\Run\Traits\GetListExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Models\Run;

class Create extends BaseController
{
    use GetListExceptionHandlerTrait;

    public function __construct(
        private readonly string $threadId,
        private readonly Run $run
    ) {
    }

    /**
     * @throws ThreadNotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(): ThreadRunResponse
    {
        try {
            return $this->getClient()->threads()->runs()->create(
                $this->threadId,
                $this->run->toArray()
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->getListExceptionHandler($exception);
            $this->globalExceptionHandler($exception);
        }
    }
}
