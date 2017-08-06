<?php

namespace App\Api\Http;

use App\Api\Http\Headers;
use App\Api\Handler\JsonHandler;

class Response implements ResponseInterface
{
    /**
     * @var int
     */
    protected $code;

    /**
     * @var array|null
     */
    protected $body;

    /**
     * @var Headers
     */
    protected $headers;

    /**
     * Constructor
     * 
     * @param int $code
     * @param mixed|null $body
     * @param Headers    $headers
     */
    public function __construct($code, $body = null, Headers $headers = null)
    {
        $this->code = intval($code);

        $this->setBody($body);

        $this->headers = $headers ? $headers : new Headers();
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return array|null
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed|null $body
     */
    protected function setBody($body)
    {
        $this->body = is_array($body) ? $body : JsonHandler::decode($body, true);
    }

    /**
     * @return bool
     */
    public function hasBody()
    {
        return !is_null($this->body);
    }

    /**
     * @return Headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}