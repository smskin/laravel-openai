<?php

namespace SMSkin\LaravelOpenAi\Enums;

enum ImageSizeEnum: string
{
    case s256_256 = '256x256';
    case s512_512 = '512x512';
    case s1024_1024 = '1024x1024';
    case s1024_1792 = '1024x1792';
    case s1792_1024 = '1792x1024';
}
