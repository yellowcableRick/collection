<?php

namespace YellowCable\Collection\Tests\Traits\Addons\Validation;

use YellowCable\Collection\Interfaces\CollectionInterface;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Test;
use YellowCable\Collection\Traits\Addons\Validation\HashTrait;
use YellowCable\Collection\Traits\CollectionTrait;

class HashTraitTest extends Test
{
    public function testHash(): void
    {
        $collection = new class () implements CollectionInterface
        {
            /** @use CollectionTrait<Item> */
            use CollectionTrait;
            use HashTrait;

            public function getClass(): string
            {
                return Item::class;
            }
        };

        $this->assertTrue($collection->verifyHash($collection->getHash()));
        $collection[] = new Item("1", 1, 1);
        $this->assertFalse($collection->verifyHash());
        $this->assertTrue($collection->verifyHash());
    }
}
