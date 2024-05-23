<?php

namespace SMSkin\LaravelOpenAi\Support\SerializesModels\Models;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use ReflectionClass;
use ReflectionException;
use RuntimeException;

class ResponseModel
{
    public int $statusCode;
    public string $reasonPhrase;

    public function __construct(ResponseInterface $response)
    {
        $this->statusCode = $response->getStatusCode();
        $this->reasonPhrase = $response->getReasonPhrase();
    }

    public function unSerialize(): ResponseInterface
    {
        $ref = new ReflectionClass(Response::class);
        /**
         * @var $instance ResponseInterface
         */
        try {
            $instance = $ref->newInstanceWithoutConstructor();
            $ref->getProperty('statusCode')->setValue($instance, $this->statusCode);
            $ref->getProperty('reasonPhrase')->setValue($instance, $this->reasonPhrase);
            return $instance;
        } catch (ReflectionException $exception) {
            throw new RuntimeException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
