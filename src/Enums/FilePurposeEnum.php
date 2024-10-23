<?php

namespace SMSkin\LaravelOpenAi\Enums;

enum FilePurposeEnum: string
{
    case ASSISTANTS = 'assistants';
    case VISION = 'vision';
    case BATCH = 'batch';
    case FINE_TUNE = 'fine-tune';
}
