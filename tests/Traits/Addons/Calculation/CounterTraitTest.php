<?php

namespace YellowCable\Collection\Tests\Traits\Addons\Calculation;

use Laravel\SerializableClosure\Exceptions\PhpVersionNotSupportedException;
use YellowCable\Collection\Collection;
use YellowCable\Collection\Exceptions\ValidationException;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\Items;
use YellowCable\Collection\Tests\Test;
use YellowCable\Collection\Traits\Addons\Calculation\Counter\CounterTrait;

class CounterTraitTest extends Test
{
    /**
     * @throws ValidationException
     * @throws PhpVersionNotSupportedException
     */
    public function test(): void
    {
        $subject = new class () extends Items
        {
            use CounterTrait;
        };

        $subject[] = new Item("test1", 1, 1);
        $subject[] = new Item("test2", 2, 2);
        $subject[] = new Item("3", 3, 3);
        $subject[] = new Item("test4", 3, "123");
        $subject[] = new Item("test5", 3, "test");
        $subject[] = new Item("test6", 3, "collection");
        $subject->registerCounter("nameLikeTest", fn(Item $x) => is_int(strpos($x->getName(), "test")));
        $subject->registerCounter("anythingString", fn(Item $x) => is_string($x->anything));
        $subject->registerCounter("counterEquals3", fn(Item $x) => $x->counter === 3);
        $subject->registerCounter("uni", fn(Item $x) => $x->getName() == $x->counter && $x->counter == $x->anything);
        $subject->executeCount();
        $this->assertEquals(5, $subject->getCount("nameLikeTest"));
        $this->assertEquals(3, $subject->getCount("anythingString"));
        $this->assertEquals(4, $subject->getCount("counterEquals3"));
        $this->assertEquals(1, $subject->getCount("uni"));
    }
}
