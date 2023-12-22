<?php

namespace YellowCable\Collection\Interfaces;

use YellowCable\Collection\Aggregation;

/**
 * @template Item
 * @template Collection
 */
interface AggregationStaticInterface
{
    /**
     * Aggregate a Collection.
     *
     * @param CollectionInterface<Item> $collection
     * @param bool                      $preventDuplicates
     * @return AggregationInterface<Item, Collection>&AggregationStaticInterface<Item, Collection>
     */
    public static function aggregate(
        CollectionInterface $collection,
        bool $preventDuplicates = true
    ): AggregationInterface&AggregationStaticInterface;

    /**
     * @return CollectionInterface<Aggregation<Item, Collection>> & FirstIdentifierMatchInterface & IterativeGetInterface
     */
    public static function registry(): CollectionInterface & FirstIdentifierMatchInterface & IterativeGetInterface;

    /**
     * Get an Aggregation based on the identifier. The identifier may have been set
     * by retrieving it from the initial aggregated Collection.
     *
     * @param string $identifier
     * @return AggregationInterface<Item, Collection>
     */
    public static function get(string $identifier): AggregationInterface;

    /**
     * Remove an aggregation from the register.
     *
     * @param string $identifier
     * @return bool
     */
    public static function remove(string $identifier): bool;
}
