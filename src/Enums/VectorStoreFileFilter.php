<?php

namespace SMSkin\LaravelOpenAi\Enums;

enum VectorStoreFileFilter: string
{
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
    case CANCELED = 'canceled';
}
