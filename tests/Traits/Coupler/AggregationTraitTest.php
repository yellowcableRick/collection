<?php

namespace YellowCable\Collection\Tests\Traits\Coupler;

use YellowCable\Collection\Collection;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Test;
use YellowCable\Collection\Traits\Addons\Locators\PrimaryKeysTrait;
use YellowCable\Collection\Traits\Coupler\AggregationTrait;

class AggregationTraitTest extends Test
{
    public function test(): void
    {
        $collection = new class () extends Collection
        {
            use AggregationTrait;
            /** @use PrimaryKeysTrait<Item> */
            use PrimaryKeysTrait;

            public function getClass(): string
            {
                return Item::class;
            }

            public function declaredPrimaryKey(): string
            {
                return "name";
            }
        };

        $collection[] = new Item("AggregationTraitTest", 1, 1);
        $collection->setIdentifier("AggregationTraitTest");
        $aggregation = $collection->aggregate();
        $this->assertEquals("AggregationTraitTest", $aggregation->getIdentifier());
        $this->assertEquals(
            $aggregation,
            $collection->getAggregation()
        );

        $this->assertEquals(
            $collection->getEncapsulation(),
            $aggregation[0]
        );
        $this->assertEquals(
            $collection->getPrimaryKeyValues(),
            $aggregation[0]?->getPrimaryKeyValues()
        );
    }
}
