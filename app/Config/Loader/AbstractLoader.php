<?php

namespace App\Config\Loader;

abstract class AbstractLoader implements LoaderInterface
{
    /**
     * @var string
     */
    protected $file;

    /**
     * Constructor
     * 
     * @param string $file File path
     * @throws Exception\FileNotReadableException
     */
    public function __construct($file)
    {
        if (!is_readable($file)) {
            throw new Exception\FileNotReadableException(
                sprintf('The file `%s` is not readable or cannot be found.', $file)
            );
        }

        $this->file = $file;
    }

    abstract public function load(): array;
}