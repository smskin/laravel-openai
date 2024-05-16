<?php

namespace SMSkin\LaravelOpenAi\Enums;

enum ModelEnum: string
{
    case tts1 = 'tts-1';
    case tts1_hd = 'tts-1-hd';
    case dall_e_2 = 'dall-e-2';
    case dall_e_3 = 'dall-e-3';
    case gpt_4 = 'gpt-4';
}
