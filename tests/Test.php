<?php

namespace YellowCable\Collection\Tests;

use PHPUnit\Framework\TestCase;
use YellowCable\Collection\AggregationRegistry;

/**
 * @suppressWarnings(PHPMD.NumberOfChildren)
 */
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
