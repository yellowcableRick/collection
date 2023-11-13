<?php

namespace YellowCable\Collection\Traits\Manipulation;

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
        return $this;
    }
}
