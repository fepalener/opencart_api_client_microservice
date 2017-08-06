<?php

namespace App\Api\Http;

use App\Api\Data\Collection;

class Headers extends Collection
{

    /**
     * @return array
     */
    public function getFormatedArray()
    {
        $result = [];
        foreach ($this->getAll() as $name => $value) {
            $result[] = sprintf('%s: %s', $name, $value);
        }

        return $result;
    }
}