<?php

namespace SMSkin\LaravelOpenAi;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Files\CreateResponse;
use OpenAI\Responses\Files\DeleteResponse;
use OpenAI\Responses\Files\ListResponse;
use OpenAI\Responses\Files\RetrieveResponse;
use SMSkin\LaravelOpenAi\Controllers\File\Delete;
use SMSkin\LaravelOpenAi\Controllers\File\Download;
use SMSkin\LaravelOpenAi\Controllers\File\GetList;
use SMSkin\LaravelOpenAi\Controllers\File\Retrieve;
use SMSkin\LaravelOpenAi\Controllers\File\Upload;
use SMSkin\LaravelOpenAi\Enums\FilePurposeEnum;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;
use SMSkin\LaravelOpenAi\Exceptions\InvalidExtension;
use SMSkin\LaravelOpenAi\Exceptions\NotAllowedToDownload;
use SMSkin\LaravelOpenAi\Exceptions\NotFound;

class File
{
    /**
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function getList(): ListResponse
    {
        return (new GetList())->execute();
    }

    /**
     * @throws InvalidExtension
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function upload(mixed $resource, FilePurposeEnum $purpose): CreateResponse
    {
        return (new Upload())->execute($resource, $purpose);
    }

    /**
     * @throws NotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function retrieve(string $id): RetrieveResponse
    {
        return (new Retrieve())->execute($id);
    }

    /**
     * @throws NotFound
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function delete(string $id): DeleteResponse
    {
        return (new Delete())->execute($id);
    }

    /**
     * @throws NotFound
     * @throws NotAllowedToDownload
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     */
    public function download(string $id): string
    {
        return (new Download())->execute($id);
    }
}
