<?php

namespace SMSkin\LaravelOpenAi\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ReflectionClass;
use SMSkin\LaravelOpenAi\Events\ERequestCompleted;
use SMSkin\LaravelOpenAi\Events\ERequestFailed;
use Throwable;

class ExecuteMethodJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $args;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $correlationId,
        public readonly string $class,
        public readonly string $method, ...$args)
    {
        $this->args = array_pop($args);
    }

    public function handle(): void
    {
        try {
            $ref = new ReflectionClass($this->class);
            $instance = $ref->newInstance();
            $response = $ref->getMethod($this->method)->invokeArgs($instance, $this->args);
            event(new ERequestCompleted(
                $this->correlationId,
                $this->class,
                $this->method,
                $this->args,
                $response
            ));

        } catch (Throwable $exception) {
            event(new ERequestFailed(
                $this->correlationId,
                $this->class,
                $this->method,
                $this->args,
                $exception
            ));
        }
    }
}
