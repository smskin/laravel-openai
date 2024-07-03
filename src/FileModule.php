<?php

namespace SMSkin\LaravelOpenAi;

use OpenAI\Responses\Files\CreateResponse;
use OpenAI\Responses\Files\DeleteResponse;
use OpenAI\Responses\Files\ListResponse;
use OpenAI\Responses\Files\RetrieveResponse;
use SMSkin\LaravelOpenAi\Contracts\IFileModule;
use SMSkin\LaravelOpenAi\Controllers\File\Delete;
use SMSkin\LaravelOpenAi\Controllers\File\Download;
use SMSkin\LaravelOpenAi\Controllers\File\GetList;
use SMSkin\LaravelOpenAi\Controllers\File\Retrieve;
use SMSkin\LaravelOpenAi\Controllers\File\Upload;

class FileModule implements IFileModule
{
    public function getList(): ListResponse
    {
        return (new GetList)->execute();
    }

    public function delete(string $fileId): DeleteResponse
    {
        return (new Delete($fileId))->execute();
    }

    public function retrieve(string $fileId): RetrieveResponse
    {
        return (new Retrieve($fileId))->execute();
    }

    public function upload(string $purpose, mixed $resource): CreateResponse
    {
        return (new Upload($purpose, $resource))->execute();
    }

    public function download(string $fileId): string
    {
        return (new Download($fileId))->execute();
    }
}
