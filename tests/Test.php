<?php

namespace YellowCable\Collection\Tests;

use PHPUnit\Framework\TestCase;
use YellowCable\Collection\Aggregation;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Traits\AggregationRegistry;

abstract class Test extends TestCase
{
    public function __construct(string $name)
    {
        parent::__construct($name);
        foreach (AggregationRegistry::registry() as $aggregation) {
            $aggregation->delete();
        }
    }
}
