<?php

namespace SMSkin\LaravelOpenAi\Controllers\Run;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\StreamResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Controllers\Run\Traits\GetListExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Exceptions\VectorStoreIsExpired;
use SMSkin\LaravelOpenAi\Models\Run;

class CreateStreamed extends BaseController
{
    use GetListExceptionHandlerTrait;

    public function __construct(
        private readonly string $threadId,
        private readonly Run $run
    )
    {
    }

    /**
     * @throws ThreadNotFound
     * @throws VectorStoreIsExpired
     */
    public function execute(): StreamResponse
    {
        try {
            return $this->getClient()->threads()->runs()->createStreamed(
                $this->threadId,
                $this->run->toArray()
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (preg_match('/(Vector store \w+ is expired)/i', $exception->getMessage())) {
                throw new VectorStoreIsExpired($exception->getMessage(), 500, $exception);
            }
            $this->getListExceptionHandler($exception);
            $this->globalExceptionHandler($exception);
        }
    }
}
