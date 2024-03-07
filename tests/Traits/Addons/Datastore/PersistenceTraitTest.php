<?php

namespace YellowCable\Collection\Tests\Traits\Addons\Datastore;

use Exception;
use YellowCable\Collection\Exceptions\DuplicateItemException;
use YellowCable\Collection\Exceptions\EmptyException;
use YellowCable\Collection\Exceptions\NotImplementedException;
use YellowCable\Collection\Exceptions\ValidationException;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\Items;
use YellowCable\Collection\Tests\Example\ItemsAggregation;
use YellowCable\Collection\Tests\Test;

class PersistenceTraitTest extends Test
{
    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    /**
     * @throws Exception
     */
    public function testPersistence(): void
    {
        $collection = new Items();
        $collection->setIdentifier("test");
        $collection2 = clone $collection;

        $collection[] = new Item("1", 1, 1);
        $collection[] = new Item("2", 2, 2);
        $collection->persist();
        $this->assertEquals(2, $collection->count());

        $this->assertEquals(0, $collection2->count());
        $collection2->hydrate();
        $this->assertEquals(2, $collection2->count());
        $collection->unpersist();
    }

    /**
     * @throws NotImplementedException
     * @throws EmptyException
     * @throws DuplicateItemException
     * @throws ValidationException
     * @throws Exception
     */
    public function testAggregationPersistence(): void
    {
        $aggregation = new ItemsAggregation("dreams");
        $collection = new Items();
        $collection[] = new Item("1", 1, 1);
        $aggregation->addCollection($collection, false);
        $aggregation->persist();

        $aggregation2 = new ItemsAggregation("dreams");
        $this->assertEquals(0, $aggregation2->count());
        $aggregation2->hydrate();
        $this->assertEquals(1, $aggregation2->count());
        $aggregation2->unpersist();
    }
}
