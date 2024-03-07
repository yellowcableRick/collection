<?php

namespace YellowCable\Collection\Traits\Addons\Manipulation;

use YellowCable\Collection\Exceptions\FailedInheritanceException;
use YellowCable\Collection\Interfaces\CollectionInterface;

trait SortTrait
{
    public function usort(callable $condition): CollectionInterface
    {
        usort($this->collection, $condition);
        return $this;
    }

    /**
     * @throws FailedInheritanceException
     */
    public function uasort(callable $condition): CollectionInterface
    {
        if (method_exists($this, "generator")) {
            uasort($this->collection, $condition);
            return $this;
        } else {
            throw new FailedInheritanceException("This object is not a Generator, uasort will not effect iteration");
        }
    }
}
