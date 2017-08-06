<?php

namespace App\Api\Http;

use App\Api\Http\Headers;
use App\Api\Handler\JsonHandler;

class Request implements RequestInterface
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var mixed
     */
    protected $body;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var Headers
     */
    protected $headers;

    /**
     * Constructor
     * 
     * @param string|null  $path    Uri path
     * @param mixed|null   $body    Request body
     * @param string       $method  HTTP method
     * @param Headers|null $headers
     */
    public function __construct($path = null, $body = null, $method = 'POST', Headers $headers = null)
    {
        $this->method  = $method;
        $this->headers = $headers ? $headers : new Headers();

        $this->setPath($path);
        $this->setBody($body);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    protected function setPath($path)
    {
        $this->path = $path ? ltrim($path, '/') : $path;
    }

    /**
     * @return string JSON Encoded string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return boolean
     */
    public function hasBody()
    {
        return is_null($this->body);
    }

    protected function setBody($body)
    {
        if (is_array($body)) {
            $this->body = JsonHandler::encode($body);
        } else {
            $this->body = $body;
        }
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return Headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}