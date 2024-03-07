<?php

namespace YellowCable\Collection\Traits\Addons\Calculation\Counter;

use YellowCable\Collection\Collection;
use YellowCable\Collection\Interfaces\Locators\IterativeGetInterface;
use YellowCable\Collection\Traits\Addons\Locators\IterativeGetTrait;
use YellowCable\Collection\Traits\Addons\Locators\PrimaryKeysTrait;

/**
 * @extends Collection<Counter>
 * @implements IterativeGetInterface<Counter>
 */
class Counters extends Collection implements IterativeGetInterface
{
    /** @use IterativeGetTrait<Counter> */
    use IterativeGetTrait;
    /** @use PrimaryKeysTrait<Counter> */
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
