<?php

namespace YellowCable\Collection;

use YellowCable\Collection\Exceptions\DoesNotExistException;
use YellowCable\Collection\Exceptions\NotImplementedException;

trait AggregationStaticTrait
{
    /** @var CollectionInterface $aggregations */
    private static CollectionInterface $aggregations;

    /**
     * Get an array of all Aggregations registered in the static list.
     *
     * @return CollectionInterface
     */
    public static function registry(): CollectionInterface
    {
        return self::$aggregations ?? self::$aggregations = new class () extends Collection
        {
            /**
             * @inheritDoc
             */
            public function getClass(): string
            {
                return AggregationInterface::class;
            }
        };
    }

    /**
     * Aggregate a Collection.
     *
     * @param CollectionInterface $collection
     * @param bool       $preventDuplicates
     * @return AggregationInterface
     * @throws DoesNotExistException
     */
    public static function aggregate(
        CollectionInterface $collection,
        bool $preventDuplicates = true
    ): AggregationInterface {
        if (
            !self::registry()->getItem(
                fn(AggregationInterface $x) => $x->getIdentifier() === $collection->getIdentifier()
            )
        ) {
            (new class ($collection->getIdentifier()) extends Aggregation implements AggregationInterface {
                public function getClass(): string
                {
                    return CollectionInterface::class;
                }
            });
        }
        return self::get($collection->getIdentifier())->addCollection($collection, $preventDuplicates);
    }

    /**
     * Disaggregate a Collection.
     *
     * @param Collection $collection
     * @return AggregationInterface
     * @throws NotImplementedException
     */
    public static function disaggregate(CollectionInterface $collection): AggregationInterface
    {
        throw new NotImplementedException("Method not (yet) implemented.");
    }

    /**
     * Get an Aggregation based on the identifier. The identifier may have been set
     * by retrieving it from the initial aggregated Collection.
     *
     * @param string $identifier
     *
     * @return AggregationInterface
     * @throws DoesNotExistException
     */
    public static function get(string $identifier): AggregationInterface
    {
        return self::registry()->getItem(
            fn(AggregationInterface $x) => $x->getIdentifier() === $identifier
        ) ?? throw new DoesNotExistException("Aggregation does not exist!");
    }

    /**
     * Register an Aggregation in the static list.
     *
     * @param AggregationInterface $aggregation
     * @return AggregationInterface
     */
    protected static function set(AggregationInterface $aggregation): AggregationInterface
    {
        return self::registry()[] = $aggregation;
    }

    /**
     * Remove an aggregation from the register.
     *
     * @param string $identifier
     * @return bool
     */
    public static function remove(string $identifier): bool
    {
        if (
            is_int($key = self::registry()->getKey(fn(AggregationInterface $x) => $x->getIdentifier() === $identifier))
        ) {
            self::registry()->offsetUnset($key);
            if (!is_int(self::registry()->getKey(fn(AggregationInterface $x) => $x->getIdentifier() === $identifier))) {
                return true;
            }
        }
        return false;
    }
}