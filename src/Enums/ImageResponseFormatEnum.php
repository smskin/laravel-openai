<?php

namespace SMSkin\LaravelOpenAi\Enums;

enum ImageResponseFormatEnum: string
{
    case  URL = 'url';
    case BASE64_JSON = 'b64_json';
}
