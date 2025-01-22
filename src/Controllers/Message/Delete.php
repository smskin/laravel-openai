<?php

namespace SMSkin\LaravelOpenAi\Controllers\Message;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Threads\Messages\ThreadMessageDeleteResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Controllers\Message\Traits\RetrieveExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Controllers\Run\Traits\GetListExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;

class Delete extends BaseController
{
    use GetListExceptionHandlerTrait;
    use RetrieveExceptionHandlerTrait;

    public function __construct(
        private readonly string $threadId,
        private readonly string $messageId
    ) {
    }

    /**
     * @throws ThreadNotFound
     * @throws NotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(): ThreadMessageDeleteResponse
    {
        try {
            return $this->getClient()->threads()->messages()->delete($this->threadId, $this->messageId);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->retrieveExceptionHandler($exception);
            $this->getListExceptionHandler($exception);
            $this->globalExceptionHandler($exception);
        }
    }
}
