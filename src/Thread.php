<?php

namespace SMSkin\LaravelOpenAi;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\StreamResponse;
use OpenAI\Responses\Threads\Runs\ThreadRunResponse;
use OpenAI\Responses\Threads\ThreadDeleteResponse;
use OpenAI\Responses\Threads\ThreadResponse;
use SMSkin\LaravelOpenAi\Controllers\Thead\Create;
use SMSkin\LaravelOpenAi\Controllers\Thead\CreateAndRun;
use SMSkin\LaravelOpenAi\Controllers\Thead\CreateAndRunStreamed;
use SMSkin\LaravelOpenAi\Controllers\Thead\Delete;
use SMSkin\LaravelOpenAi\Controllers\Thead\Modify;
use SMSkin\LaravelOpenAi\Controllers\Thead\Retrieve;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;
use SMSkin\LaravelOpenAi\Exceptions\UnsupportedImageFormat;
use SMSkin\LaravelOpenAi\Exceptions\UnsupportedMessageContent;
use SMSkin\LaravelOpenAi\Models\CodeInterpreterToolResource;
use SMSkin\LaravelOpenAi\Models\FileSearchToolResource;
use SMSkin\LaravelOpenAi\Models\UnsupportedRetrievalFile;

class Thread
{
    /**
     * @param Models\Thread|null $thread
     * @return ThreadResponse
     * @throws NotFound
     * @throws UnsupportedImageFormat
     * @throws UnsupportedMessageContent
     * @throws UnsupportedRetrievalFile
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function create(Models\Thread|null $thread): ThreadResponse
    {
        return (new Create())->execute($thread);
    }

    /**
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function createAndRun(
        Models\Run $run,
        Models\Thread|null             $thread,
    ): ThreadRunResponse {
        return (new CreateAndRun())->execute($run, $thread);
    }

    /**
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function createAndRunStreamed(
        Models\Run $run,
        Models\Thread|null             $thread,
    ): StreamResponse {
        return (new CreateAndRunStreamed())->execute($run, $thread);
    }

    /**
     * @throws NotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function retrieve(string $id): ThreadResponse
    {
        return (new Retrieve())->execute($id);
    }

    /**
     * @throws NotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function modify(
        string                           $id,
        CodeInterpreterToolResource|null $codeInterpreterToolResource = null,
        FileSearchToolResource|null      $fileSearchToolResource = null,
        array|null                       $metadata = null
    ): ThreadResponse {
        return (new Modify())->execute($id, $codeInterpreterToolResource, $fileSearchToolResource, $metadata);
    }

    /**
     * @throws NotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function delete(string $id): ThreadDeleteResponse
    {
        return (new Delete())->execute($id);
    }

    public function runs(): Run
    {
        return new Run();
    }

    public function messages(): Message
    {
        return new Message();
    }
}
