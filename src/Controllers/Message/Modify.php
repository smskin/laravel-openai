<?php

namespace SMSkin\LaravelOpenAi\Controllers\Message;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Threads\Messages\ThreadMessageResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Controllers\Message\Traits\RetrieveExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Controllers\Run\Traits\GetListExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;

class Modify extends BaseController
{
    use GetListExceptionHandlerTrait;
    use RetrieveExceptionHandlerTrait;

    /**
     * @throws ThreadNotFound
     * @throws NotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(string $threadId, string $messageId, array|null $metadata): ThreadMessageResponse
    {
        try {
            return $this->getClient()->threads()->messages()->modify(
                $threadId,
                $messageId,
                $this->prepareData($metadata)
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->retrieveExceptionHandler($exception);
            $this->getListExceptionHandler($exception);
            $this->globalExceptionHandler($exception);
        }
    }

    private function prepareData(
        array|null $metadata
    ): array {
        $payload = [];
        if ($metadata) {
            $payload['metadata'] = $metadata;
        }
        return $payload;
    }
}
