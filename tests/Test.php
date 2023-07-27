<?php

namespace YellowCable\Collection\Tests;

use PHPUnit\Framework\TestCase;
use YellowCable\Collection\Aggregation;

class Test extends TestCase
{
    public function __construct(string $name)
    {
        parent::__construct($name);
        foreach (Aggregation::registry() as $aggregation) {
            $aggregation->delete();
        }
    }
}
