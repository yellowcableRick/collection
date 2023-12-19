<?php

namespace YellowCable\Collection\Traits;

use YellowCable\Collection\Aggregation;
use YellowCable\Collection\Collection;
use YellowCable\Collection\Exceptions\DoesNotExistException;
use YellowCable\Collection\Exceptions\EmptyException;
use YellowCable\Collection\Exceptions\NotImplementedException;
use YellowCable\Collection\Interfaces\AggregationInterface;
use YellowCable\Collection\Interfaces\CollectionInterface;
use YellowCable\Collection\Interfaces\FirstIdentifierMatchInterface;
use YellowCable\Collection\Interfaces\IterativeGetInterface;
use YellowCable\Collection\Traits\Locators\FirstIdentifierMatchTrait;
use YellowCable\Collection\Traits\Locators\IterativeGetTrait;

trait AggregationStaticTrait
{
    /** @var CollectionInterface & FirstIdentifierMatchInterface & IterativeGetInterface $aggregations */
    private static CollectionInterface & FirstIdentifierMatchInterface & IterativeGetInterface $aggregations;

    /**
     * Get an array of all Aggregations registered in the static list.
     *
     * @return CollectionInterface
     */
    public static function registry(): CollectionInterface & FirstIdentifierMatchInterface & IterativeGetInterface
    {
        /** @var CollectionInterface & FirstIdentifierMatchInterface & IterativeGetInterface $bliep */
        $bliep =
            new class () extends Collection implements FirstIdentifierMatchInterface, IterativeGetInterface
            {
                use FirstIdentifierMatchTrait;
                use IterativeGetTrait;

                /**
                 * @inheritDoc
                 */
                public function getClass(): string
                {
                    return AggregationInterface::class;
                }
            };

        return self::$aggregations ?? self::$aggregations = $bliep;
    }

    /**
     * Aggregate a Collection.
     *
     * @param CollectionInterface $collection
     * @param bool                $preventDuplicates
     * @return AggregationInterface
     * @throws DoesNotExistException
     * @throws EmptyException
     * @throws NotImplementedException
     */
    public static function aggregate(
        CollectionInterface $collection,
        bool $preventDuplicates = true
    ): AggregationInterface {
        try {
            self::get($collection->getIdentifier())
                ?? throw new DoesNotExistException();
        } catch (EmptyException | DoesNotExistException) {
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
     * Get an Aggregation based on the identifier. The identifier may have been set
     * by retrieving it from the initial aggregated Collection.
     *
     * @param string $identifier
     *
     * @return AggregationInterface
     * @throws DoesNotExistException
     * @throws EmptyException
     * @throws NotImplementedException
     */
    public static function get(string $identifier): AggregationInterface
    {
        try {
            return self::registry()->getFirstIdentifierMatch($identifier) ?? throw new DoesNotExistException();
        } catch (EmptyException) {
            throw new DoesNotExistException("Aggregation does not exist!");
        }
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
