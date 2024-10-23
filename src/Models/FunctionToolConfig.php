<?php

namespace SMSkin\LaravelOpenAi\Models;

use Illuminate\Contracts\Support\Arrayable;

class FunctionToolConfig implements Arrayable
{
    public function __construct(
        public string      $name,
        public string|null $description = null,
        public array|null  $parameters = null,
        public bool|null   $strict = null,
    ) {
    }

    public function toArray(): array
    {
        $payload = [
            'name' => $this->name,
        ];
        if ($this->description) {
            $payload['name'] = $this->description;
        }
        if ($this->parameters) {
            $payload['parameters'] = $this->parameters;
        }
        if ($this->strict !== null) {
            $payload['strict'] = $this->strict;
        }
        return $payload;
    }
}
