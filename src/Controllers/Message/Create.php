<?php

namespace SMSkin\LaravelOpenAi\Controllers\Message;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Threads\Messages\ThreadMessageResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Controllers\Run\Traits\GetListExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\FileNotSupportedForRetrieval;
use SMSkin\LaravelOpenAi\Exceptions\RunInProcess;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Models\Message as MessageModel;

class Create extends BaseController
{
    use GetListExceptionHandlerTrait;

    /**
     * @throws ThreadNotFound
     * @throws RunInProcess
     * @throws FileNotSupportedForRetrieval
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(string $threadId, MessageModel $message): ThreadMessageResponse
    {
        try {
            return $this->getClient()->threads()->messages()->create(
                $threadId,
                $message->toArray()
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
