<?php

namespace App\Config\Loader;

interface LoaderInterface
{
    /**
     * Load and return config file
     */
    public function load(): array;
}