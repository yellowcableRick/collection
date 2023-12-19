<?php

namespace YellowCable\Collection\Tests\Traits\Datastore;

use PHPUnit\Framework\TestCase;
use YellowCable\Collection\Collection;
use YellowCable\Collection\Exceptions\UnequalCountException;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Test;
use YellowCable\Collection\Traits\Datastore\DataProviderTrait;
use YellowCable\Collection\Traits\Datastore\PrimaryKeysTrait;
use YellowCable\Collection\Traits\Locators\FirstIdentifierMatchTrait;

class DataProviderTraitTest extends Test
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
        $this->assertEquals(1, $subject->getItemByPrimaryKey("1", Item::class)?->anything);
        $subject->setUpdateProvider(fn() => [new Item("1", 1, 4)]);
        $subject->runUpdateProvider();
        $this->assertEquals(4, $subject->getItemByPrimaryKey("1", Item::class)?->anything);
        $subject->setCountProvider(fn() => 3);
        $subject->runCountProvider();
        $subject->setCountProvider(fn() => 4);
        $this->expectException(UnequalCountException::class);
        $subject->runCountProvider();
    }
}
