<?php

namespace App\Api\Data;

use ArrayIterator;

class Collection implements CollectionInterface
{
    /**
     * The source data
     *
     * @var array
     */
    protected $data = [];

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->set($key, $value);
        }
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function get($key, $default = null)
    {
        return $this->has($key) ? $this->data[$key] : $default;
    }

    public function getAll()
    {
        return $this->data;
    }

    public function has($key)
    {
        return array_key_exists($key, $this->data);
    }

    public function remove($key)
    {
        unset($this->data[$key]);
    }

    public function clear()
    {
        $this->data = [];
    }

    public function count()
    {
        return count($this->data);
    }

    public function offsetGet($key)
    {
        return $this->get($key);
    }

    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    public function offsetUnset($key)
    {
        $this->remove($key);
    }

    public function offsetExists($key)
    {
        return $this->has($key);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }
}