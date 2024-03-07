<?php

namespace YellowCable\Collection\Interfaces;

/**
 * @template Item
 * @extends CollectionInterface<Item>
 */

interface AggregationInterface extends CollectionInterface
{
    /**
     * Add a collection to this Aggregation. If you choose to prevent duplications in
     *  the aggregated Collections, it will compare the new primary keys with the
     *  primary keys already present in the aggregation. You can only prevent duplication
     *  if the Collections use the PrimaryKeyTrait, which defines the unique property
     *  between the collected Items.
     *
     * @param Item $collection
     * @param bool                      $preventDuplicates
     * @return AggregationInterface<Item>
     */
    public function addCollection(
        mixed $collection,
        bool $preventDuplicates = true
    ): AggregationInterface;

    /**
     * Remove this aggregation from the registry.
     *
     * @return bool
     */
    public function delete(): bool;
}
