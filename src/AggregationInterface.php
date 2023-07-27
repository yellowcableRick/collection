<?php

namespace YellowCable\Collection;

interface AggregationInterface extends CollectionInterface
{
    public static function aggregate(
        CollectionInterface $collection,
        bool $preventDuplicates = true
    ): AggregationInterface;
    public static function disaggregate(CollectionInterface $collection): self;
    public static function registry(): CollectionInterface;
    public static function get(string $identifier): AggregationInterface;
    public static function remove(string $identifier): bool;

    public function addCollection(
        CollectionInterface $collection,
        bool $preventDuplicates = true
    ): AggregationInterface;
    public function delete(): bool;
}
