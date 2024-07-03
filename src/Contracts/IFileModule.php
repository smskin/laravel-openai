<?php

namespace SMSkin\LaravelOpenAi\Contracts;

use OpenAI\Responses\Files\CreateResponse;
use OpenAI\Responses\Files\DeleteResponse;
use OpenAI\Responses\Files\ListResponse;
use OpenAI\Responses\Files\RetrieveResponse;

interface IFileModule
{
    public function getList(): ListResponse;

    public function delete(string $fileId): DeleteResponse;

    public function retrieve(string $fileId): RetrieveResponse;

    public function upload(string $purpose, mixed $resource): CreateResponse;

    public function download(string $fileId): string;
}
