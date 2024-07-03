<?php

namespace SMSkin\LaravelOpenAi\Controllers\File;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Files\ListResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;

class GetList extends BaseController
{
    public function __construct()
    {
    }

    public function execute(): ListResponse
    {
        try {
            return $this->getClient()->files()->list();
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->errorExceptionHandler($exception);
        }
    }
}
