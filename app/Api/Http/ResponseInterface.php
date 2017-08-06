<?php

namespace App\Api\Http;

interface ResponseInterface
{

    public function getCode();

    public function getBody();

    public function hasBody();
    
    public function getHeaders();
}