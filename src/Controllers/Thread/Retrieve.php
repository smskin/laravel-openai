<?php

namespace SMSkin\LaravelOpenAi\Controllers\Thread;

use BaseController;
use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Threads\ThreadResponse;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;

class Retrieve extends BaseController
{
    public function __construct(private readonly string $id)
    {
    }


    /**
     * @throws ThreadNotFound
     */
    public function execute(): ThreadResponse
    {
        try {
            return $this->getClient()->threads()->retrieve($this->id);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'No thread found with id')) {
                throw new ThreadNotFound($exception->getMessage(), 500, $exception);
            }

            $this->errorExceptionHandler($exception);
        }
    }
}
