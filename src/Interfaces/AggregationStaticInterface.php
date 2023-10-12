<?php

namespace YellowCable\Collection\Interfaces;

interface AggregationStaticInterface
{
    public static function aggregate(
        CollectionInterface $collection,
        bool $preventDuplicates = true
    ): AggregationInterface;
    public static function registry(): CollectionInterface;
    public static function get(string $identifier): AggregationInterface;
    public static function remove(string $identifier): bool;
}
