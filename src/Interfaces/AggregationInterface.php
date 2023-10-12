<?php

namespace YellowCable\Collection\Interfaces;

interface AggregationInterface extends CollectionInterface
{
    public function addCollection(
        CollectionInterface $collection,
        bool $preventDuplicates = true
    ): AggregationInterface;
    public function delete(): bool;
}
