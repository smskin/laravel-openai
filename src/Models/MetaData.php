<?php

namespace SMSkin\LaravelOpenAi\Models;

class MetaData
{
    public function __construct(
        public readonly string|null $name = null
    ) {
    }

    public function toArray(): array
    {
        $data = [];
        if (filled($this->name)) {
            $data['name'] = $this->name;
        }
        return $data;
    }
}
