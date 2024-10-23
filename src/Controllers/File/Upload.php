<?php

namespace SMSkin\LaravelOpenAi\Controllers\File;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Files\CreateResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Enums\FilePurposeEnum;

class Upload extends BaseController
{
    public function __construct(
        private readonly mixed $resource,
        private readonly FilePurposeEnum $purpose
    ) {
    }

    public function execute(): CreateResponse
    {
        try {
            return $this->getClient()->files()->upload([
                'file' => $this->resource,
                'purpose' => $this->purpose->value,
            ]);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->globalExceptionHandler($exception);
        }
    }
}
