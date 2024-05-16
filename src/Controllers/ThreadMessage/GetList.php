<?php

namespace SMSkin\LaravelOpenAi\Controllers\ThreadMessage;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Threads\Messages\ThreadMessageListResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;

class GetList extends BaseController
{
    public function __construct(
        private readonly string $threadId,
        private readonly int $limit
    ) {
    }

    /**
     * @throws ThreadNotFound
     */
    public function execute(): ThreadMessageListResponse
    {
        try {
            return $this->getClient()->threads()->messages()->list($this->threadId, [
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
