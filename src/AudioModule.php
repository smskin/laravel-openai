<?php

namespace SMSkin\LaravelOpenAi;

use SMSkin\LaravelOpenAi\Contracts\IAudioModule;
use SMSkin\LaravelOpenAi\Controllers\Audio\Speech;
use SMSkin\LaravelOpenAi\Enums\AudioResponseFormatEnum;
use SMSkin\LaravelOpenAi\Enums\AudioVoiceEnum;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Exceptions\NotValidModel;

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
}
