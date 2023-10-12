<?php

namespace YellowCable\Collection\Tests\Traits\Validation;

use YellowCable\Collection\Interfaces\CollectionInterface;
use YellowCable\Collection\Tests\Test;
use YellowCable\Collection\Traits\CollectionTrait;
use YellowCable\Collection\Traits\Validation\HashTrait;

class HashTraitTest extends Test
{
    public function testHash(): void
    {
        $collection = new class () implements CollectionInterface
        {
            use CollectionTrait;
            use HashTrait;

            public function getClass(): string
            {
                return "";
            }
        };

        $this->assertTrue($collection->verifyHash($collection->getHash()));
        $collection[] = new class () {
        };
        $this->assertFalse($collection->verifyHash());
        $this->assertTrue($collection->verifyHash());
    }
}
