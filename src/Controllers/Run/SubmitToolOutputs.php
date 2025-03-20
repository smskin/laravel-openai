<?php

namespace SMSkin\LaravelOpenAi\Controllers\Run;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Threads\Runs\ThreadRunResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Controllers\Run\Traits\GetListExceptionHandlerTrait;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\ExpectedToolOutputs;
use SMSkin\LaravelOpenAi\Exceptions\RunIsExpired;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Models\ToolOutput;

class SubmitToolOutputs extends BaseController
{
    use GetListExceptionHandlerTrait;

    /**
     * @throws ThreadNotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @throws ExpectedToolOutputs
     * @throws RunIsExpired
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(string $threadId, string $runId, Collection $toolOutputs): ThreadRunResponse
    {
        try {
            return $this->getClient()->threads()->runs()->submitToolOutputs($threadId, $runId, [
                'tool_outputs' => $toolOutputs->map(static function (ToolOutput $output) {
                    $data = [
                        'tool_call_id' => $output->toolCallId,
                    ];
                    if ($output->output) {
                        $data['output'] = $output->output;
                    }
                    return $data;
                })->toArray(),
            ]);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'Runs in status "expired" do not accept tool outputs')) {
                throw new RunIsExpired($exception->getMessage(), $exception->getCode(), $exception);
            }
            if (Str::contains($exception->getMessage(), 'Expected tool outputs for call_ids')) {
                throw new ExpectedToolOutputs($exception->getMessage(), $exception->getCode(), $exception);
            }
            $this->globalExceptionHandler($exception);
        }
    }
}
