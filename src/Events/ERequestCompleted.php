<?php

namespace SMSkin\LaravelOpenAi\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use OpenAI\Contracts\ResponseContract;

class ERequestCompleted
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public readonly string $correlationId,
        public readonly string $class,
        public readonly string $method,
        public readonly array $arguments,
        public readonly ResponseContract $response
    ) {
    }
}
