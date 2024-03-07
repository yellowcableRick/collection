<?php

namespace YellowCable\Collection\Interfaces;

/**
 * @template Item
 */
interface AggregationStaticInterface
{
    /**
     * Aggregate a Collection.
     *
     * @param CollectionInterface<Item> $collection
     * @param bool                      $preventDuplicates
     * @return AggregationInterface<Item>
     */
    public static function aggregate(
        CollectionInterface $collection,
        bool $preventDuplicates = true
    ): AggregationInterface;
}
