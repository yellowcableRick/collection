<?php

namespace YellowCable\Collection\Tests\Traits\Datastore;

use YellowCable\Collection\CollectionInterface;
use YellowCable\Collection\CollectionTrait;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Test;
use YellowCable\Collection\Traits\Datastore\PrimaryKeysTrait;

class PrimaryKeysTraitTest extends Test
{
    public function testPrimaryKeys(): void
    {
        $collection = new class () implements CollectionInterface
        {
            use CollectionTrait;
            use PrimaryKeysTrait;

            public function getClass(): string
            {
                return Item::class;
            }

            public function getPrimaryKey(): string
            {
                return "getName";
            }
        };

        $collection[] = new Item("1", 1, 1);
        $collection[] = new Item("2", 2, 2);

        $this->assertEquals([Item::class => ["1", "2"]], $collection->getPrimaryKeyValues());
    }
}
