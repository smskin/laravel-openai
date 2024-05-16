<?php

namespace SMSkin\LaravelOpenAi\Controllers\Thread;

use BaseController;
use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Threads\Runs\ThreadRunListResponse;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;

class ListRuns extends BaseController
{
    public function __construct(
        private readonly string $threadId,
        private readonly int $limit
    ) {
    }

    /**
     * @throws ThreadNotFound
     */
    public function execute(): ThreadRunListResponse
    {
        try {
            return $this->getClient()->threads()->runs()->list($this->threadId, [
                'limit' => $this->limit,
            ]);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'No thread found with id')) {
                throw new ThreadNotFound($exception->getMessage(), 500, $exception);
            }

            $this->errorExceptionHandler($exception);
        }
    }
}
