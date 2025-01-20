<?php

namespace SMSkin\LaravelOpenAi\Controllers\Thead;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Threads\ThreadDeleteResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Controllers\Thead\Traits\RetrieveExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;

class Delete extends BaseController
{
    use RetrieveExceptionHandlerTrait;

    public function __construct(
        private readonly string $id,
    ) {
    }

    /**
     * @throws NotFound
     * @throws TransporterException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(): ThreadDeleteResponse
    {
        try {
            return $this->getClient()->threads()->delete(
                $this->id
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->retrieveExceptionHandler($exception);
            $this->globalExceptionHandler($exception);
        }
    }
}
