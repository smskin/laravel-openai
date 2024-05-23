<?php

namespace SMSkin\LaravelOpenAi\Support\SerializesModels\Models;

use ReflectionClass;
use ReflectionException;
use RuntimeException;
use SMSkin\LaravelOpenAi\Support\SerializesModels\Contracts\ISerializableException;
use Throwable;

class ThrowableModel implements ISerializableException
{
    public string $class;
    public string $message;
    public int $code;
    public string $file;
    public int $line;

    public function __construct(Throwable $exception)
    {
        $this->class = get_class($exception);
        $this->message = $exception->getMessage();
        $this->code = $exception->getCode();
        $this->file = $exception->getFile();
        $this->line = $exception->getLine();
    }

    public function unSerialize(): Throwable
    {
        try {
            $ref = new ReflectionClass($this->class);
            /**
             * @var $instance Throwable
             */
            $instance = $ref->newInstanceWithoutConstructor();
            $this->fillBasicProps($ref, $instance);
            return $instance;
        } catch (ReflectionException $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @throws ReflectionException
     */
    protected function fillBasicProps(ReflectionClass $ref, Throwable $instance)
    {
        $ref->getProperty('message')->setValue($instance, $this->message);
        $ref->getProperty('code')->setValue($instance, $this->code);
        $ref->getProperty('file')->setValue($instance, $this->file);
        $ref->getProperty('line')->setValue($instance, $this->line);
    }
}
