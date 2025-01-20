<?php

namespace SMSkin\LaravelOpenAi\Controllers\File;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Files\ListResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;

class GetList extends BaseController
{
    public function __construct()
    {
    }

    /**
     * @return ListResponse
     * @throws TransporterException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(): ListResponse
    {
        try {
            return $this->getClient()->files()->list();
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->globalExceptionHandler($exception);
        }
    }
}
