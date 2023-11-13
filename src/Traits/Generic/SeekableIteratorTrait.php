<?php

namespace YellowCable\Collection\Traits\Generic;

use OutOfBoundsException;

trait SeekableIteratorTrait
{
    /** @var int $index Iterator index which holds the current iteration key */
    private int $index;

    abstract public function offsetGet(mixed $offset): mixed;

    /**
     * @inheritDoc
     */
    public function seek(int $offset): void
    {
        $this->offsetGet($offset) ? $this->index = $offset :
            throw new OutOfBoundsException("Offset $offset does not exist.");
    }
}
