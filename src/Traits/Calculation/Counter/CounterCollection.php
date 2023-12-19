<?php

namespace YellowCable\Collection\Traits\Calculation\Counter;

use YellowCable\Collection\Collection;
use YellowCable\Collection\Interfaces\IterativeGetInterface;
use YellowCable\Collection\Traits\Datastore\PrimaryKeysTrait;
use YellowCable\Collection\Traits\Locators\IterativeGetTrait;

class CounterCollection extends Collection implements IterativeGetInterface
{
    use IterativeGetTrait;
    use PrimaryKeysTrait;

    /**
     * @inheritDoc
     */
    public function getClass(): string
    {
        return Counter::class;
    }

    public function getPrimaryKey(): string
    {
        return "name";
    }
}
