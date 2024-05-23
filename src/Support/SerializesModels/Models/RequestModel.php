<?php

namespace SMSkin\LaravelOpenAi\Support\SerializesModels\Models;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use ReflectionClass;
use ReflectionException;
use RuntimeException;

class RequestModel
{
    public string $method;
    public string $requestTarget;
    public UriModel $uri;
    public array $headers;
    public string $protocolVersion;

    public function __construct(RequestInterface $request)
    {
        $this->method = $request->getMethod();
        $this->requestTarget = $request->getRequestTarget();
        $this->uri = new UriModel($request->getUri());
        $this->headers = $request->getHeaders();
        $this->protocolVersion = $request->getProtocolVersion();
    }

    public function unSerialize(): RequestInterface
    {
        $ref = new ReflectionClass(Request::class);
        /**
         * @var $instance RequestInterface
         */
        try {
            $instance = $ref->newInstanceWithoutConstructor();
            $ref->getProperty('method')->setValue($instance, $this->method);
            $ref->getProperty('requestTarget')->setValue($instance, $this->requestTarget);
            $ref->getProperty('uri')->setValue($instance, $this->uri->unSerialize());
            $ref->getProperty('headers')->setValue($instance, $this->headers);
            $ref->getProperty('protocol')->setValue($instance, $this->protocolVersion);
            return $instance;
        } catch (ReflectionException $exception) {
            throw new RuntimeException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
