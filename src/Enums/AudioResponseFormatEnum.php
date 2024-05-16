<?php

namespace SMSkin\LaravelOpenAi\Enums;

enum AudioResponseFormatEnum: string
{
    case mp3 = 'mp3';
    case opus = 'opus';
    case aac = 'aac';
    case flac = 'flac';
    case wav = 'wav';
    case pcm = 'pcm';
}
