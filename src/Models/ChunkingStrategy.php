<?php

namespace SMSkin\LaravelOpenAi\Models;

use Illuminate\Contracts\Support\Arrayable;

abstract class ChunkingStrategy implements Arrayable
{
    public string $type;

    public function toArray(): array
    {
        return [
            'type' => 'auto',
        ];
    }
}
