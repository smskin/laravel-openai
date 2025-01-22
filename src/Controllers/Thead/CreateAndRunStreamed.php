<?php

namespace SMSkin\LaravelOpenAi\Controllers\Thead;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\StreamResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Models\Run;
use SMSkin\LaravelOpenAi\Models\Thread;

class CreateAndRunStreamed extends BaseController
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
    public function execute(): StreamResponse
    {
        try {
            return $this->getClient()->threads()->createAndRunStreamed(
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
