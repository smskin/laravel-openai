<?php

namespace SMSkin\LaravelOpenAi\Controllers\Thead;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Threads\ThreadResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;
use SMSkin\LaravelOpenAi\Exceptions\UnsupportedImageFormat;
use SMSkin\LaravelOpenAi\Exceptions\UnsupportedMessageContent;
use SMSkin\LaravelOpenAi\Models\Thread;
use SMSkin\LaravelOpenAi\Models\UnsupportedRetrievalFile;

class Create extends BaseController
{
    public function __construct(private readonly Thread|null $thread)
    {
    }

    /**
     * @throws UnsupportedImageFormat
     * @throws NotFound
     * @throws UnsupportedMessageContent
     * @throws UnsupportedRetrievalFile
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(): ThreadResponse
    {
        try {
            return $this->getClient()->threads()->create(
                $this->thread ? $this->thread->toArray() : []
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), '.image_url.url\'. Expected url to end in a supported format')) {
                throw new UnsupportedImageFormat($exception->getMessage(), 500, $exception);
            }
            if (Str::contains($exception->getMessage(), 'Invalid message content: Expected file type to be a supported format')) {
                throw new UnsupportedMessageContent($exception->getMessage(), 500, $exception);
            }
            if (Str::contains($exception->getMessage(), 'were not found')) {
                throw new NotFound($exception->getMessage(), 500, $exception);
            }
            if (Str::contains($exception->getMessage(), 'are not supported for retrieval')) {
                throw new UnsupportedRetrievalFile($exception->getMessage(), 500, $exception);
            }
            $this->globalExceptionHandler($exception);
        }
    }
}
