<?php

namespace SMSkin\LaravelOpenAi\Controllers\Thread;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Threads\ThreadResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Models\MetaData;

class Modify extends BaseController
{
    public function __construct(
        private readonly string $id,
        private readonly MetaData|null $metaData
    ) {
    }

    /**
     * @throws ThreadNotFound
     */
    public function execute(): ThreadResponse
    {
        try {
            return $this->getClient()->threads()->modify($this->id, $this->prepareData());
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'No thread found with id')) {
                throw new ThreadNotFound($exception->getMessage(), 500, $exception);
            }

            $this->errorExceptionHandler($exception);
        }
    }

    private function prepareData(): array
    {
        $data = [];
        if (filled($this->metaData)) {
            $data['metadata'] = $this->metaData->toArray();
        }
        return $data;
    }
}
