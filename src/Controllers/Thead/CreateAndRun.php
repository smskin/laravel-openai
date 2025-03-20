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
    /**
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(Run $run, Thread|null $thread): ThreadRunResponse
    {
        try {
            return $this->getClient()->threads()->createAndRun(
                $this->prepareData($run, $thread)
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->globalExceptionHandler($exception);
        }
    }

    private function prepareData(Run $run, Thread|null $thread): array
    {
        $payload = $run->toArray();
        if ($thread) {
            $payload = array_merge($payload, [
                'thread' => $thread->toArray(),
            ]);
        }
        return $payload;
    }
}
