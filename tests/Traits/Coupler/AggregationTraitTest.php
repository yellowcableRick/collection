<?php

namespace YellowCable\Collection\Tests\Traits\Coupler;

use PHPUnit\Framework\TestCase;
use YellowCable\Collection\Collection;
use YellowCable\Collection\Exceptions\NotImplementedException;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Test;
use YellowCable\Collection\Traits\Coupler\AggregationTrait;
use YellowCable\Collection\Traits\Datastore\PrimaryKeysTrait;

class AggregationTraitTest extends Test
{
    public function test(): void
    {
        $collection = new class () extends Collection
        {
            use AggregationTrait;
            use PrimaryKeysTrait;

            public function getClass(): string
            {
                return Item::class;
            }

            public function getPrimaryKey(): string
            {
                return "name";
            }
        };

        $collection[] = new Item("test", 1, 1);
        $collection->setIdentifier("test");
        $aggregation = $collection->aggregate();
        $this->assertEquals("test", $aggregation->getIdentifier());
        $this->assertEquals(
            $collection->getEncapsulation()->getIdentifier(),
            $collection->getAggregation()->getItem(fn($x) => $x->getIdentifier() === "test")->getIdentifier()
        );
    }
}
