<?php

namespace App\Config\Loader;

class ArrayLoader extends AbstractLoader
{
    /**
     * Load config file
     * 
     * @return array
     * @throws Exception\ParseException
     */
    public function load(): array
    {
        $array = include $this->file;

        if (!is_array($array)) {
            throw new Exception\ParseException(
                sprintf('The file `%s` must return an array', $this->file)
            );
        }

        return $array;
    }
}