<?php

namespace SMSkin\LaravelOpenAi\Models;

abstract class BaseTool
{
    public readonly string $type;

    public function toArray(): array
    {
        return [
            'type' => $this->type,
        ];
    }
}
