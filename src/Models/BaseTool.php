<?php

namespace SMSkin\LaravelOpenAi\Models;

abstract class BaseTool
{
    public readonly string $type;

    public function fromArray(): self
    {
        return $this;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
        ];
    }
}
