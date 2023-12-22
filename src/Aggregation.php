<?php

namespace YellowCable\Collection;

use YellowCable\Collection\Interfaces\AggregationInterface;
use YellowCable\Collection\Interfaces\AggregationStaticInterface;
use YellowCable\Collection\Traits\AggregationStaticTrait;
use YellowCable\Collection\Traits\AggregationTrait;
use YellowCable\Collection\Collection as AbstractCollection;

/**
 * Aggregation is used to aggregate items using Collections as containers,
 * where all calculating methods should be present. Aggregation tries to
 * remove any internal collection without removing any or all additional properties
 * of the Collections. Any method within the aggregated Collections can be called
 * through the Aggregation and the output will be returned as array of results.
 *
 * Aggregation is statically stored; If you try to aggregate anything with the
 * same identifier it should be compatible with one-another. Make sure you separate
 * your aggregations by setting the correct identifiers in the Collections.
 *
 * @template Item
 * @template Collection
 * @extends AbstractCollection<Collection>
 * @implements AggregationInterface<Item, Collection>
 * @implements AggregationStaticInterface<Item, Collection>
 */
abstract class Aggregation extends AbstractCollection implements AggregationInterface, AggregationStaticInterface
{
    /** @use AggregationStaticTrait<Item, Collection> */
    use AggregationStaticTrait;
    /** @use AggregationTrait<Item, Collection> */
    use AggregationTrait;

    /**
     * Constructor for Aggregation. Any and all Aggregation constructed will
     * be directly stored in the static property.
     *
     * @param string $identifier
     */
    public function __construct(string $identifier = "")
    {
        parent::__construct($identifier);
        static::set($this);
    }
}
