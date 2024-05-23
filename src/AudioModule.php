<?php

namespace SMSkin\LaravelOpenAi;

use SMSkin\LaravelOpenAi\Contracts\IAudioModule;
use SMSkin\LaravelOpenAi\Controllers\Audio\Speech;
use SMSkin\LaravelOpenAi\Enums\AudioResponseFormatEnum;
use SMSkin\LaravelOpenAi\Enums\AudioVoiceEnum;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Exceptions\NotValidModel;
use SMSkin\LaravelOpenAi\Jobs\ExecuteMethodJob;

class AudioModule implements IAudioModule
{
    /**
     * @throws NotValidModel
     */
    public function speech(
        ModelEnum                    $model,
        string                       $input,
        AudioVoiceEnum               $voice,
        AudioResponseFormatEnum|null $responseFormat = null,
        int|null                     $speed = null
    ): string {
        $responseFormat ??= AudioResponseFormatEnum::mp3;
        $speed ??= 1;
        return (new Speech($model, $input, $voice, $responseFormat, $speed))->execute();
    }

    public function speechAsync(
        string                       $correlationId,
        ModelEnum                    $model,
        string                       $input,
        AudioVoiceEnum               $voice,
        AudioResponseFormatEnum|null $responseFormat = null,
        int|null                     $speed = null,
        string|null                  $connection = null,
        string|null                  $queue = null
    ): void {
        dispatch(new ExecuteMethodJob($correlationId, self::class, 'speech', $connection, $queue, $model, $input, $voice, $responseFormat, $speed));
    }
}
