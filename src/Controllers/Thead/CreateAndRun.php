<?php

namespace SMSkin\LaravelOpenAi\Controllers\Thead;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Threads\Runs\ThreadRunResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Models\Run;
use SMSkin\LaravelOpenAi\Models\Thread;

class CreateAndRun extends BaseController
{
    public function __construct(
        private readonly Run $run,
        private readonly Thread|null $thread,
    ) {
    }

    /**
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(): ThreadRunResponse
    {
        try {
            return $this->getClient()->threads()->createAndRun(
                $this->prepareData()
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->globalExceptionHandler($exception);
        }
    }

    private function prepareData(): array
    {
        $payload = $this->run->toArray();
        if ($this->thread) {
            $payload = array_merge($payload, [
                'thread' => $this->thread->toArray(),
            ]);
        }
        return $payload;
    }
}
