<?php

namespace SMSkin\LaravelOpenAi\Controllers\File;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Files\CreateResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;

class Upload extends BaseController
{
    public function __construct(private readonly string $purpose, private readonly mixed $resource)
    {
    }

    public function execute(): CreateResponse
    {
        try {
            return $this->getClient()->files()->upload([
                'purpose' => $this->purpose,
                'file' => $this->resource,
            ]);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->errorExceptionHandler($exception);
        }
    }
}
