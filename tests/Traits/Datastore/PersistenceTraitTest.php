<?php

namespace YellowCable\Collection\Tests\Traits\Datastore;

use Exception;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\PersistableItemCollection;
use YellowCable\Collection\Tests\Test;

class PersistenceTraitTest extends Test
{
    /**
     * @throws Exception
     */
    public function testPersistence(): void
    {
        $collection = new PersistableItemCollection();
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
}
