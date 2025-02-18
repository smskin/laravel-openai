<?php

namespace SMSkin\LaravelOpenAi\Models;

class ToolOutput
{
    public function __construct(public readonly string $toolCallId, public readonly string|null $output)
    {
    }
}
