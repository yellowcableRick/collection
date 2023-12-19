<?php

namespace YellowCable\Collection\Tests\Traits\Coupler;

use PHPUnit\Framework\TestCase;
use YellowCable\Collection\Collection;
use YellowCable\Collection\Exceptions\NotImplementedException;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Test;
use YellowCable\Collection\Traits\CollectionTrait;
use YellowCable\Collection\Traits\Coupler\AggregationTrait;
use YellowCable\Collection\Traits\Datastore\PrimaryKeysTrait;
use YellowCable\Collection\Traits\Validation\HashTrait;

class AggregationTraitTest extends Test
{
    public function test(): void
    {
        $collection = new class () extends Collection
        {
            use AggregationTrait;
            use PrimaryKeysTrait;
            use HashTrait;

            public function getClass(): string
            {
                return Item::class;
            }

            public function getPrimaryKey(): string
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
        /** @var CollectionTrait&HashTrait $cap */
        $cap = $collection->getEncapsulation();
        $this->assertEquals(
            $cap->getHash(),
            $aggregation[0]?->getHash()
        );
        $this->assertEquals(
            $collection->getPrimaryKeyValues(),
            $aggregation[0]?->getPrimaryKeyValues()
        );
    }
}
