<?php

namespace SMSkin\LaravelOpenAi\Controllers\File;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Files\CreateResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Enums\FilePurposeEnum;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\InvalidExtension;

class Upload extends BaseController
{
    /**
     * @throws InvalidExtension
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(mixed $resource, FilePurposeEnum $purpose): CreateResponse
    {
        try {
            return $this->getClient()->files()->upload([
                'file' => $resource,
                'purpose' => $purpose->value,
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
