<?php

namespace YellowCable\Collection\Traits\Generic;

trait CountableTrait
{
    /** @var int $fixedCount Placeholder for the output of count, when the collection is cleared */
    protected int $fixedCount;

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return (property_exists($this, "fixedCount") && isset($this->fixedCount) && $this->fixedCount !== 0) ?
            $this->fixedCount :
            count($this->collection);
    }
}
