<?php

namespace YellowCable\Collection\Tests\Example;

use YellowCable\Collection\Aggregation;

class ItemAggregation extends Aggregation
{
    public function getClass(): string
    {
        return ItemCollection::class;
    }
}
