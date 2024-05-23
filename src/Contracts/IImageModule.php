<?php

namespace SMSkin\LaravelOpenAi\Contracts;

use OpenAI\Responses\Images\CreateResponse;
use SMSkin\LaravelOpenAi\Enums\ImageResponseFormatEnum;
use SMSkin\LaravelOpenAi\Enums\ImageSizeEnum;
use SMSkin\LaravelOpenAi\Enums\ImageStyleEnum;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Exceptions\NotValidModel;

interface IImageModule
{
    /**
     * @throws NotValidModel
     */
    public function create(
        string                       $prompt,
        ModelEnum|null               $model = null,
        int|null                     $n = null,
        ImageSizeEnum|null           $size = null,
        ImageStyleEnum|null          $style = null,
        ImageResponseFormatEnum|null $responseFormat = null
    ): CreateResponse;

    public function createAsync(
        string                       $correlationId,
        string                       $prompt,
        ModelEnum|null               $model = null,
        int|null                     $n = null,
        ImageSizeEnum|null           $size = null,
        ImageStyleEnum|null          $style = null,
        ImageResponseFormatEnum|null $responseFormat = null,
        string|null                  $connection = null,
        string|null                  $queue = null
    ): void;
}
