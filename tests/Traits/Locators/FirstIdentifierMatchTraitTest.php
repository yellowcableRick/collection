<?php

namespace YellowCable\Collection\Tests\Traits\Locators;

use PHPUnit\Framework\TestCase;
use YellowCable\Collection\Exceptions\DuplicateItemException;
use YellowCable\Collection\Exceptions\EmptyException;
use YellowCable\Collection\Exceptions\NotImplementedException;
use YellowCable\Collection\Exceptions\ValidationException;
use YellowCable\Collection\Tests\Example\FullTraitedItem\FullTraitedItemAggregation;
use YellowCable\Collection\Tests\Example\FullTraitedItem\FullTraitedItemCollection;
use YellowCable\Collection\Tests\Example\Item;

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
        $collection = new FullTraitedItemCollection("test");
        $aggregation = new FullTraitedItemAggregation();

        $collection[] = new Item("1", 1, 1);
        $aggregation->addCollection($collection);
        $this->assertEquals($collection->getEncapsulation(), $aggregation->getFirstIdentifierMatch("test"));
    }
}
