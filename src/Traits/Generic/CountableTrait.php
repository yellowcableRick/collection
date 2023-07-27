<?php

namespace YellowCable\Collection\Traits\Generic;

trait CountableTrait
{
    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return (isset($this->fixedCount)) && $this->fixedCount !== 0 ? $this->fixedCount : count($this->collection);
    }
}
