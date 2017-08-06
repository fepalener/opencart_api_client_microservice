<?php

namespace App\Api\Handler;

class JsonHandler
{

    public static function encode($value, $options = 0)
    {
        $result = json_encode($value, $options);

        if ($result) {
            return $result;
        }

        throw new Exception\InvalidJsonException("JSON Error: " . json_last_error());
    }

    public static function decode($json, $assoc = false)
    {
        $result = json_decode($json, $assoc);

        if ($result) {
            return $result;
        }

        throw new Exception\InvalidJsonException("JSON Error: " . json_last_error());
    }
}