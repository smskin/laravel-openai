<?php

namespace SMSkin\LaravelOpenAi\Models;

use Illuminate\Contracts\Support\Arrayable;

abstract class ToolChoice implements Arrayable
{
    protected string $type;

    public function toArray(): array
    {
        return [
            'type' => $this->type,
        ];
    }
}
