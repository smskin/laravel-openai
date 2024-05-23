<?php

namespace SMSkin\LaravelOpenAi\Support\SerializesModels\Models;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;
use ReflectionClass;
use ReflectionException;
use RuntimeException;

class UriModel
{
    public string $scheme;
    public string $userInfo;
    public string $host;
    public int|null $port;
    public string $path;
    public string $query;
    public string $fragment;

    public function __construct(UriInterface $uri)
    {
        $this->scheme = $uri->getScheme();
        $this->userInfo = $uri->getUserInfo();
        $this->host = $uri->getHost();
        $this->port = $uri->getPort();
        $this->path = $uri->getPath();
        $this->query = $uri->getQuery();
        $this->fragment = $uri->getFragment();
    }

    public function unSerialize(): UriInterface
    {
        $ref = new ReflectionClass(Uri::class);
        /**
         * @var $instance UriInterface
         */
        try {
            $instance = $ref->newInstanceWithoutConstructor();
            $ref->getProperty('scheme')->setValue($instance, $this->scheme);
            $ref->getProperty('userInfo')->setValue($instance, $this->userInfo);
            $ref->getProperty('host')->setValue($instance, $this->host);
            $ref->getProperty('port')->setValue($instance, $this->port);
            $ref->getProperty('path')->setValue($instance, $this->path);
            $ref->getProperty('query')->setValue($instance, $this->query);
            $ref->getProperty('fragment')->setValue($instance, $this->fragment);
            return $instance;
        } catch (ReflectionException $exception) {
            throw new RuntimeException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
