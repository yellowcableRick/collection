<?php

namespace YellowCable\Collection\Traits\Calculation\Counter;

use YellowCable\Collection\Collection;

class CounterCollection extends Collection
{
    /**
     * @inheritDoc
     */
    public function getClass(): string
    {
        return Counter::class;
    }
}
