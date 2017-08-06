<?php

namespace App\Console\Input;

interface InputInterface
{

    /**
     * Get argument by name
     *
     * @param string $name The name of the argument
     * @return string|null
     */
    public function getArgument($name, $default = null);

    /**
     * Get first argument if exists
     * 
     * @return string|null
     */
    public function getFirstArgument();
}