<?php

namespace SMSkin\LaravelOpenAi\Controllers\Message;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Threads\Messages\ThreadMessageResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Controllers\Run\Traits\GetListExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Exceptions\FileNotSupportedForRetrieval;
use SMSkin\LaravelOpenAi\Exceptions\RunInProcess;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Models\Message;

class Create extends BaseController
{
    use GetListExceptionHandlerTrait;

    public function __construct(
        private readonly string $threadId,
        private readonly Message $message
    ) {
    }

    /**
     * @throws ThreadNotFound
     * @throws RunInProcess
     * @throws FileNotSupportedForRetrieval
     */
    public function execute(): ThreadMessageResponse
    {
        try {
            return $this->getClient()->threads()->messages()->create(
                $this->threadId,
                $this->message->toArray()
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->getListExceptionHandler($exception);
            if (preg_match('/(Can\'t add messages to \w+ while a run \w+ is active)/i', $exception->getMessage())) {
                throw new RunInProcess($exception->getMessage(), 500, $exception);
            }
            if (preg_match('/(Files with extensions \S+ are not supported for retrieval)/i', $exception->getMessage())) {
                throw new FileNotSupportedForRetrieval($exception->getMessage(), 500, $exception);
            }
            $this->globalExceptionHandler($exception);
        }
    }
}
