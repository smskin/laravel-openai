<?php

namespace SMSkin\LaravelOpenAi\Controllers\ThreadRun;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Threads\Runs\ThreadRunResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Exceptions\RunNotFound;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Models\MetaData;

class Modify extends BaseController
{
    public function __construct(
        private readonly string $threadId,
        private readonly string $runId,
        private readonly MetaData|null $metaData
    ) {
    }

    /**
     * @throws ThreadNotFound
     * @throws RunNotFound
     */
    public function execute(): ThreadRunResponse
    {
        try {
            return $this->getClient()->threads()->runs()->modify(
                $this->threadId,
                $this->runId,
                $this->prepareData()
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'No thread found with id')) {
                throw new ThreadNotFound($exception->getMessage(), 500, $exception);
            }
            if (Str::contains($exception->getMessage(), 'No run found with id')) {
                throw new RunNotFound($exception->getMessage(), 500, $exception);
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
