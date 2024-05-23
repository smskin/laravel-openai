<?php

namespace SMSkin\LaravelOpenAi\Support\SerializesModels\Models;

use GuzzleHttp\Exception\RequestException;
use ReflectionClass;
use ReflectionException;
use RuntimeException;
use SMSkin\LaravelOpenAi\Support\SerializesModels\Contracts\ISerializableException;

class RequestExceptionModel extends ThrowableModel implements ISerializableException
{
    public RequestModel $request;
    public ResponseModel|null $response;
    public array $handledContext;

    public function __construct(RequestException $exception)
    {
        parent::__construct($exception);
        $this->request = new RequestModel($exception->getRequest());
        $this->response = $exception->getResponse() ? new ResponseModel($exception->getResponse()) : null;
        $this->handledContext = $exception->getHandlerContext();
    }

    public function unSerialize(): RequestException
    {
        try {
            $ref = new ReflectionClass(RequestException::class);
            /**
             * @var $instance RequestException
             */
            $instance = $ref->newInstanceWithoutConstructor();
            $this->fillBasicProps($ref, $instance);
            $ref->getProperty('request')->setValue($instance, $this->request->unSerialize());
            $ref->getProperty('handledContext')->setValue($instance, $this->handledContext);
            $ref->getProperty('response')->setValue($instance, $this->response?->unSerialize());
            return $instance;
        } catch (ReflectionException $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
