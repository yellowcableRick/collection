<?php

namespace YellowCable\Collection\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use YellowCable\Collection\Aggregation;
use YellowCable\Collection\CollectionInterface;
use YellowCable\Collection\Exceptions\DoesNotExistException;
use YellowCable\Collection\Exceptions\DuplicateItemException;
use YellowCable\Collection\Exceptions\NotImplementedException;
use YellowCable\Collection\Exceptions\ValidationException;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\ItemAggregation;
use YellowCable\Collection\Tests\Example\ItemCollection;

class AggregationTest extends TestCase
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
            Aggregation::get("test")->getItem(fn(CollectionInterface $x) => $x->getIdentifier() === "test"),
            $col->getEncapsulation()
        );
        $this->assertEquals(
            Aggregation::registry()->getItem(fn(CollectionInterface $x) => $x->getIdentifier() === "test")
                ->getItem(fn(CollectionInterface $x) => $x->getIdentifier() === "test"),
            $col->getEncapsulation()
        );
        $this->assertTrue(Aggregation::remove("test"));
        $this->expectException(DoesNotExistException::class);
        Aggregation::get("test")->getItem(fn(CollectionInterface $x) => $x->getIdentifier() === "test");
        $this->expectException(NotImplementedException::class);
        Aggregation::disaggregate(Aggregation::get("test"));
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
        $agg = new ItemAggregation("bliep");
        $this->expectException(ValidationException::class);
        $agg->addCollection(new ItemCollection("test", [new Item("item", 1, 1)]));
    }
}
