<?php

namespace YellowCable\Collection\Tests;

use Exception;
use YellowCable\Collection\Aggregation;
use YellowCable\Collection\Exceptions\DoesNotExistException;
use YellowCable\Collection\Exceptions\DuplicateItemException;
use YellowCable\Collection\Exceptions\EmptyException;
use YellowCable\Collection\Exceptions\NotImplementedException;
use YellowCable\Collection\Exceptions\ValidationException;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\Item\ItemAggregation;
use YellowCable\Collection\Tests\Example\Item\ItemCollection;

class AggregationTest extends Test
{
    /**
     * @throws DuplicateItemException
     * @throws ValidationException
     * @throws NotImplementedException
     * @throws Exception
     */
    public function testStatics(): void
    {
        $col = new ItemCollection("test", [new Item("test", 1, 1)]);
        Aggregation::aggregate($col, false);
        $this->assertEquals(
            Aggregation::get("test")[0],
            $col->getEncapsulation()
        );
        $this->assertEquals(
            Aggregation::registry()->getFirstIdentifierMatch("test")[0],
            $col->getEncapsulation()
        );
        $this->assertTrue(Aggregation::remove("test"));
        $this->expectException(EmptyException::class);
        Aggregation::get("test");
    }

    /**
     * @throws DuplicateItemException
     * @throws ValidationException
     * @throws NotImplementedException
     */
    public function testAddCollection()
    {
        $agg = new ItemAggregation("bliep");
        $agg->addCollection(new ItemCollection("test", [new Item("item", 1, 1)]), false);
        $this->assertEquals(
            $agg->offsetGet(0),
            (new ItemCollection("test", [new Item("item", 1, 1)]))->getEncapsulation()
        );
    }

    /**
     * @throws DuplicateItemException
     * @throws NotImplementedException
     */
    public function testDuplicationVerification()
    {
        $agg = new ItemAggregation("blaat");
        $agg->addCollection(new ItemCollection("test", [new Item("item", 1, 1)]), false);
        $agg2 = new ItemAggregation("blaat");
        $this->expectException(ValidationException::class);
        $agg2->addCollection(new ItemCollection("test", [new Item("item", 1, 1)]));
    }
}
