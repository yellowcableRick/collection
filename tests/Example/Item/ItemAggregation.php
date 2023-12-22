<?php

namespace YellowCable\Collection\Tests\Example\Item;

use YellowCable\Collection\Aggregation;
use YellowCable\Collection\Tests\Example\Item;

/**
 * @extends Aggregation<Item, ItemCollection>
 */
class ItemAggregation extends Aggregation
{
    public function getClass(): string
    {
        return ItemCollection::class;
    }
}
