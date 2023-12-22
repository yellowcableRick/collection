<?php

namespace YellowCable\Collection\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Item
{
    /**
     * @param class-string $class
     */
    public function __construct(public readonly string $class)
    {
    }
}
