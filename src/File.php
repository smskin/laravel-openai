<?php

namespace SMSkin\LaravelOpenAi;

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
use SMSkin\LaravelOpenAi\Exceptions\NotFound;

class File
{
    /**
     * @throws TransporterException
     */
    public function getList(): ListResponse
    {
        return (new GetList())->execute();
    }

    /**
     * @throws Exceptions\InvalidExtension
     * @throws TransporterException
     */
    public function upload(mixed $resource, FilePurposeEnum $purpose): CreateResponse
    {
        return (new Upload($resource, $purpose))->execute();
    }

    /**
     * @throws NotFound
     * @throws TransporterException
     */
    public function retrieve(string $id): RetrieveResponse
    {
        return (new Retrieve($id))->execute();
    }

    /**
     * @throws NotFound
     * @throws TransporterException
     */
    public function delete(string $id): DeleteResponse
    {
        return (new Delete($id))->execute();
    }

    /**
     * @throws NotFound
     * @throws Exceptions\NotAllowedToDownload
     * @throws TransporterException
     */
    public function download(string $id): string
    {
        return (new Download($id))->execute();
    }
}
