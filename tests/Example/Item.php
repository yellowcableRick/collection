<?php

namespace YellowCable\Collection\Tests\Example;

class Item
{
    public function __construct(
        private readonly string $name,
        public int $counter,
        public mixed $anything
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
