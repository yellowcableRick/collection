<?php

namespace YellowCable\Collection\Traits\Addons\Manipulation;

use YellowCable\Collection\Interfaces\CollectionInterface;

trait FilterTrait
{
    public function filter(callable $condition): CollectionInterface
    {
        foreach ($this as $key => $item) {
            if ($condition($item) === false) {
                $this->offsetUnset($key);
            }
        }
        $this->collection = array_values($this->collection);
        return $this;
    }
}
