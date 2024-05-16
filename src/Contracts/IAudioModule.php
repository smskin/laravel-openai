<?php

namespace SMSkin\LaravelOpenAi\Contracts;

use SMSkin\LaravelOpenAi\Enums\AudioResponseFormatEnum;
use SMSkin\LaravelOpenAi\Enums\AudioVoiceEnum;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Exceptions\NotValidModel;

interface IAudioModule
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
    ): string;
}
