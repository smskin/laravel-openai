<?php

namespace SMSkin\LaravelOpenAi;

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
    public function getList(): ListResponse
    {
        return (new GetList())->execute();
    }

    /**
     * @throws Exceptions\InvalidExtension
     */
    public function upload(mixed $resource, FilePurposeEnum $purpose): CreateResponse
    {
        return (new Upload($resource, $purpose))->execute();
    }

    /**
     * @throws NotFound
     */
    public function retrieve(string $id): RetrieveResponse
    {
        return (new Retrieve($id))->execute();
    }

    /**
     * @throws NotFound
     */
    public function delete(string $id): DeleteResponse
    {
        return (new Delete($id))->execute();
    }

    /**
     * @throws NotFound
     * @throws Exceptions\NotAllowedToDownload
     */
    public function download(string $id): string
    {
        return (new Download($id))->execute();
    }
}
