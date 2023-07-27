<?php

namespace YellowCable\Collection\Tests\Traits\Datastore;

use PHPUnit\Framework\TestCase;
use YellowCable\Collection\Collection;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Traits\Datastore\DataProviderTrait;
use YellowCable\Collection\Traits\Datastore\PrimaryKeysTrait;

class DataProviderTraitTest extends TestCase
{
    public function test(): void
    {
        $subject = new class () extends Collection
        {
            use DataProviderTrait;
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

        $subject->setDataProvider(fn() => [new Item("1", 1, 1), new Item("2", 2, 2), new Item("3", 3, 3)]);
        $subject->runDataProvider();
        $this->assertEquals(1, $subject->getItem(fn(Item $x) => $x->getName() === "1")?->anything);
        $subject->setUpdateProvider(fn() => [new Item("1", 1, 4)]);
        $subject->runUpdateProvider();
        $this->assertEquals(4, $subject->getItem(fn(Item $x) => $x->getName() === "1")?->anything);
    }
}
