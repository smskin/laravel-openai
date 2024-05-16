<?php

namespace SMSkin\LaravelOpenAi\Controllers\Thread;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Threads\ThreadDeleteResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;

class Delete extends BaseController
{
    public function __construct(private readonly string $id)
    {
    }


    /**
     * @throws ThreadNotFound
     */
    public function execute(): ThreadDeleteResponse
    {
        try {
            return $this->getClient()->threads()->delete($this->id);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'No thread found with id')) {
                throw new ThreadNotFound($exception->getMessage(), 500, $exception);
            }

            $this->errorExceptionHandler($exception);
        }
    }
}
