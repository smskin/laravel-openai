<?php

namespace SMSkin\LaravelOpenAi;

use OpenAI\Responses\Images\CreateResponse;
use SMSkin\LaravelOpenAi\Contracts\IImageModule;
use SMSkin\LaravelOpenAi\Controllers\Image\Create;
use SMSkin\LaravelOpenAi\Enums\ImageResponseFormatEnum;
use SMSkin\LaravelOpenAi\Enums\ImageSizeEnum;
use SMSkin\LaravelOpenAi\Enums\ImageStyleEnum;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Exceptions\NotValidModel;
use SMSkin\LaravelOpenAi\Jobs\ExecuteMethodJob;

class ImageModule implements IImageModule
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
    ): CreateResponse {
        $n ??= 1;
        $responseFormat ??= ImageResponseFormatEnum::URL;
        $style ??= ImageStyleEnum::vivid;
        $size ??= ImageSizeEnum::s1024_1024;
        $model ??= ModelEnum::dall_e_2;

        return (new Create($prompt, $model, $n, $size, $style, $responseFormat))->execute();
    }

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
    ): void {
        dispatch(new ExecuteMethodJob($correlationId, self::class, substr(__FUNCTION__, 0, -5), $connection, $queue, $prompt, $model, $n, $size, $style, $responseFormat));
    }
}
