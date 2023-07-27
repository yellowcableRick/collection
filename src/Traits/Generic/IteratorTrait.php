<?php

namespace YellowCable\Collection\Traits\Generic;

trait IteratorTrait
{
    /**
     * @inheritDoc
     */
    public function current(): mixed
    {
        return !$this->offsetExists($this->index) ?: $this->collection[$this->index];
    }

    /**
     * @inheritDoc
     */
    public function next(): void
    {
        ++$this->index;
    }

    /**
     * @inheritDoc
     */
    public function key(): int
    {
        return $this->index;
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return $this->offsetExists($this->index);
    }

    /**
     * @inheritDoc
     */
    public function rewind(): void
    {
        $this->index = 0;
    }
}
