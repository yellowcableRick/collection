<?php

namespace YellowCable\Collection\Traits\Generic;

trait ArrayAccessTrait
{
    abstract public function getClass(): string;

    /**
     * @inheritDoc
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->collection[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->offsetExists($offset) ? $this->collection[$offset] : null;
    }

    /**
     * @inheritDoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (($offset === null || is_int($offset)) && (!$this->getClass() || is_a($value, $this->getClass()))) {
            $offset !== null ? $this->collection[$offset] = $value : $this->collection[] = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset(mixed $offset): void
    {
        if ($this->offsetExists($offset)) {
            unset($this->collection[$offset]);
        }
    }
}
