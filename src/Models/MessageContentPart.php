<?php

namespace SMSkin\LaravelOpenAi\Models;

use Illuminate\Contracts\Support\Arrayable;

abstract class MessageContentPart implements Arrayable
{
    public string $type;

    public function toArray(): array
    {
        return [
            'type' => $this->type,
        ];
    }
}
