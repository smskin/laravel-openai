<?php

namespace SMSkin\LaravelOpenAi\Controllers\File;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Files\CreateResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Enums\FilePurposeEnum;
use SMSkin\LaravelOpenAi\Exceptions\InvalidExtension;

class Upload extends BaseController
{
    public function __construct(
        private readonly mixed $resource,
        private readonly FilePurposeEnum $purpose
    ) {
    }

    /**
     * @throws InvalidExtension
     */
    public function execute(): CreateResponse
    {
        try {
            return $this->getClient()->files()->upload([
                'file' => $this->resource,
                'purpose' => $this->purpose->value,
            ]);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'Invalid extension')) {
                throw new InvalidExtension($exception->getMessage(), 500, $exception);
            }
            $this->globalExceptionHandler($exception);
        }
    }
}
