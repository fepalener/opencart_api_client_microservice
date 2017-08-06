<?php

namespace App\Api\Http;

interface RequestInterface
{

    public function getPath();

    public function getBody();

    public function hasBody();
    
    public function getMethod();

    public function getHeaders();
}