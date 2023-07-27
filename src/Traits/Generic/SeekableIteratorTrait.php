<?php

namespace YellowCable\Collection\Traits\Generic;

use OutOfBoundsException;

trait SeekableIteratorTrait
{
    /**
     * @inheritDoc
     */
    public function seek(int $offset): void
    {
        $this->offsetGet($offset) ? $this->index = $offset :
            throw new OutOfBoundsException("Offset $offset does not exist.");
    }
}
