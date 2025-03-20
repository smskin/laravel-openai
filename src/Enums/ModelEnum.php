<?php

namespace SMSkin\LaravelOpenAi\Enums;

enum ModelEnum: string
{
    case Gpt35Turbo = 'gpt-3.5-turbo';
    case Gpt4 = 'gpt-4';
    case Gpt4o = 'gpt-4o';
    case Whisper1 = 'whisper-1';
}
