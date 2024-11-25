<?php

namespace SMSkin\LaravelOpenAi\Models;

use SMSkin\LaravelOpenAi\Enums\RoleEnum;

class ChatMessage
{
    public function __construct(public readonly RoleEnum $role, public readonly string $content)
    {
    }
}
