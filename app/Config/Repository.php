<?php

namespace App\Config;

use App\Config\Loader\LoaderInterface;

class Repository implements \ArrayAccess
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * Constructor
     * 
     * @param LoaderInterface $loader
     */
    public function __construct(LoaderInterface $loader)
    {
        $this->config = $loader->load();
    }

    public function get($key, $default = null)
    {
        if (!isset($this->config[$key]) && is_null($default)) {
            throw new Exception\UndefinedOffsetException(
                sprintf('Undefined offset `%s` in config repository and no default provided', $key)
            );
        }

        return (isset($this->config[$key])) ? $this->config[$key] : $default;
    }

    public function set($key, $value)
    {
        $this->config[$key] = $value;
    }
    
    /**
     * ArrayAccess Exists method
     *
     * @param  mixed $offset
     * @return boolean
     */
    public function offsetExists($offset): bool
    {
        return isset($this->config[$offset]);
    }

    /**
     * ArrayAccess Get method
     *
     * @param  mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * ArrayAccess Set method
     *
     * @param  mixed $offset
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        $this->set($offset, $value);
    }

    /**
     * ArrayAccess Unset method
     *
     * @param  mixed $offset
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->config[$offset]);
    }
}