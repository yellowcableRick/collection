<?php

namespace YellowCable\Collection\Tests\Traits\Locators;

use YellowCable\Collection\Interfaces\CollectionInterface;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Test;
use YellowCable\Collection\Traits\CollectionTrait;
use YellowCable\Collection\Traits\Locators\PrimaryKeysTrait;

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

            public function declaredPrimaryKey(): string
            {
                return "getName";
            }
        };

        $collection[] = new Item("1", 1, 1);
        $collection[] = new Item("2", 2, 2);

        $this->assertEquals([Item::class => ["1", "2"]], $collection->getPrimaryKeyValues());
        $this->assertEquals(1, $collection->getCollectionKey(new Item("2", 2, 2)));
        $this->assertEquals(new Item("1", 1, 1), $collection->getItemByPrimaryKey("1", Item::class));
        $collection[] = new Item("4", 1, 2);
        $this->assertEquals(3, count($collection->getPrimaryKeyValues()[Item::class]));
    }
}
