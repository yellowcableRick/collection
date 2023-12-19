<?php

namespace YellowCable\Collection\Traits\Generic;

trait IteratorTrait
{
    /** @var int $index Iterator index which holds the current iteration key */
    private int $index;

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
        $this->index = (count($this->collection) === 0) ? 0 : min(array_keys($this->collection));
    }
}
