<?php

namespace SMSkin\LaravelOpenAi\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use SMSkin\LaravelOpenAi\Support\SerializesModels\CustomSerializesModels;
use Throwable;

class ERequestFailed
{
    use Dispatchable;
    use InteractsWithSockets;
    use CustomSerializesModels;

    public function __construct(
        public readonly string $correlationId,
        public readonly string $class,
        public readonly string $method,
        public readonly array $arguments,
        public readonly Throwable $exception
    ) {
    }
}
