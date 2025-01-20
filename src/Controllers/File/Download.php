<?php

namespace SMSkin\LaravelOpenAi\Controllers\File;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Controllers\File\Traits\RetrieveExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Exceptions\NotAllowedToDownload;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;

class Download extends BaseController
{
    use RetrieveExceptionHandlerTrait;

    public function __construct(
        private readonly string $id
    ) {
    }

    /**
     * @throws NotFound
     * @throws NotAllowedToDownload
     * @throws TransporterException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(): string
    {
        try {
            return $this->getClient()->files()->download($this->id);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'Not allowed to download files of purpose:')) {
                throw new NotAllowedToDownload($exception->getMessage(), 500, $exception);
            }
            $this->retrieveExceptionHandler($exception);
            $this->globalExceptionHandler($exception);
        }
    }
}
