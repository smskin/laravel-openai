<?php

namespace SMSkin\LaravelOpenAi\Support\SerializesModels\Models;

use GuzzleHttp\Exception\ConnectException;
use ReflectionClass;
use ReflectionException;
use RuntimeException;
use SMSkin\LaravelOpenAi\Support\SerializesModels\Contracts\ISerializableException;

class ConnectExceptionModel extends ThrowableModel implements ISerializableException
{
    public RequestModel $request;
    public array $handlerContext;

    public function __construct(ConnectException $exception)
    {
        parent::__construct($exception);
        $this->request = new RequestModel($exception->getRequest());
        $this->handlerContext = $exception->getHandlerContext();
    }

    public function unSerialize(): ConnectException
    {
        try {
            $ref = new ReflectionClass(ConnectException::class);
            /**
             * @var $instance ConnectException
             */
            $instance = $ref->newInstanceWithoutConstructor();
            $this->fillBasicProps($ref, $instance);
            $ref->getProperty('request')->setValue($instance, $this->request->unSerialize());
            $ref->getProperty('handlerContext')->setValue($instance, $this->handlerContext);
            return $instance;
        } catch (ReflectionException $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
