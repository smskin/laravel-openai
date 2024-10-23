<?php

namespace SMSkin\LaravelOpenAi\Models;

use Illuminate\Contracts\Support\Arrayable;
use SMSkin\LaravelOpenAi\Enums\TruncationStrategyEnum;

class TruncationStrategy implements Arrayable
{
    public function __construct(
        public TruncationStrategyEnum $type,
        public int|null               $lastMessages = null
    ) {
    }

    public function toArray(): array
    {
        $payload = [
            'type' => $this->type->value,
        ];
        if ($this->lastMessages !== null) {
            $payload['last_messages'] = $this->lastMessages;
        }
        return $payload;
    }
}
