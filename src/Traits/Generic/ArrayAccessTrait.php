<?php

namespace YellowCable\Collection\Traits\Generic;

use YellowCable\Collection\Exceptions\ValidationException;

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
     * @throws ValidationException
     * @TODO: Should check if the int used as offset is in accordance to the ordered set already present.
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        //@phpstan-ignore-next-line For some reason, Stan thinks it's always null or int.
        if (is_null($offset) || is_int($offset)) {
            if ($this->getClass() && !is_a($value, $this->getClass())) {
                throw new ValidationException(
                    "Trying to add an item to the collection which is not a " . $this->getClass()
                );
            }
            $offset !== null ? $this->collection[$offset] = $value : $this->collection[] = $value;
        } else {
            throw new ValidationException("Offset not allowed. Should be a null or integer");
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
