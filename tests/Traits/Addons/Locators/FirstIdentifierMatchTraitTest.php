<?php

namespace YellowCable\Collection\Tests\Traits\Addons\Locators;

use PHPUnit\Framework\TestCase;
use YellowCable\Collection\Exceptions\DuplicateItemException;
use YellowCable\Collection\Exceptions\EmptyException;
use YellowCable\Collection\Exceptions\NotImplementedException;
use YellowCable\Collection\Exceptions\ValidationException;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\Items;
use YellowCable\Collection\Tests\Example\ItemsAggregation;

class FirstIdentifierMatchTraitTest extends TestCase
{
    /**
     * @throws EmptyException
     * @throws NotImplementedException
     * @throws DuplicateItemException
     * @throws ValidationException
     */
    public function test(): void
    {
        $collection = new Items("test");
        $aggregation = new ItemsAggregation();

        $collection[] = new Item("1", 1, 1);
        $aggregation->addCollection($collection, false);
        $this->assertEquals($collection->getEncapsulation(), $aggregation->getFirstIdentifierMatch("test"));
    }
}
