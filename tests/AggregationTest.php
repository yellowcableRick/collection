<?php

namespace YellowCable\Collection\Tests;

use Exception;
use YellowCable\Collection\AggregationRegistry;
use YellowCable\Collection\Exceptions\DoesNotExistException;
use YellowCable\Collection\Exceptions\DuplicateItemException;
use YellowCable\Collection\Exceptions\EmptyException;
use YellowCable\Collection\Exceptions\NotImplementedException;
use YellowCable\Collection\Exceptions\ValidationException;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\Items;
use YellowCable\Collection\Tests\Example\ItemsAggregation;

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
        $col = new Items("test", [new Item("test", 1, 1)]);
        AggregationRegistry::aggregateCollection($col, false);
        $this->assertEquals(
            AggregationRegistry::get("test")[0],
            $col->getEncapsulation()
        );
        $this->assertEquals(
            AggregationRegistry::registry()->getFirstIdentifierMatch("test")[0],
            $col->getEncapsulation()
        );
        $this->assertTrue(AggregationRegistry::remove("test"));
        $this->expectException(EmptyException::class);
        AggregationRegistry::get("test");
    }

    /**
     * @throws DuplicateItemException
     * @throws ValidationException
     * @throws NotImplementedException
     * @throws EmptyException
     */
    public function testAddCollection(): void
    {
        $agg = new ItemsAggregation("bliep");
        $agg->addCollection(new Items("test", [new Item("item", 1, 1)]), false);
        $this->assertEquals(
            $agg->offsetGet(0),
            (new Items("test", [new Item("item", 1, 1)]))->getEncapsulation()
        );
    }

    /**
     * @throws DuplicateItemException
     * @throws NotImplementedException
     * @throws EmptyException
     * @throws ValidationException
     * @throws DoesNotExistException
     */
    public function testDuplicationVerification(): void
    {
        $agg = new ItemsAggregation("blaat");
        $col = new Items("test", [new Item("item", 1, 1)]);
        $agg->addCollection($col);
        $agg2 = AggregationRegistry::get("blaat");
        $this->expectException(DuplicateItemException::class);
        $agg2->addCollection($col);
    }
}
