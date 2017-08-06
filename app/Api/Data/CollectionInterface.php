<?php

namespace App\Api\Data;

interface CollectionInterface extends \ArrayAccess, \Countable, \IteratorAggregate
{

    public function set($key, $value);

    public function get($key, $default = null);

    public function getAll();

    public function has($key);

    public function remove($key);

    public function clear();
}