<?php

namespace YellowCable\Collection\Traits\Calculation\Counter;

use YellowCable\Collection\Collection;
use YellowCable\Collection\Interfaces\Locators\IterativeGetInterface;
use YellowCable\Collection\Traits\Locators\IterativeGetTrait;
use YellowCable\Collection\Traits\Locators\PrimaryKeysTrait;

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

    public function declaredPrimaryKey(): string
    {
        return "name";
    }
}
