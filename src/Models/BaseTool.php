<?php

namespace SMSkin\LaravelOpenAi\Models;

use JetBrains\PhpStorm\ArrayShape;

abstract class BaseTool
{
    public readonly string $type;

    #[ArrayShape(['type' => 'string'])]
    public function toArray(): array
    {
        return [
            'type' => $this->type,
        ];
    }
}
