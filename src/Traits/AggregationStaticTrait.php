<?php

namespace YellowCable\Collection\Traits;

use YellowCable\Collection\Aggregation;
use YellowCable\Collection\Collection;
use YellowCable\Collection\Exceptions\DoesNotExistException;
use YellowCable\Collection\Exceptions\EmptyException;
use YellowCable\Collection\Exceptions\NotImplementedException;
use YellowCable\Collection\Interfaces\AggregationInterface;
use YellowCable\Collection\Interfaces\AggregationStaticInterface;
use YellowCable\Collection\Interfaces\CollectionInterface;
use YellowCable\Collection\Interfaces\FirstIdentifierMatchInterface;
use YellowCable\Collection\Interfaces\IterativeGetInterface;
use YellowCable\Collection\Traits\Locators\FirstIdentifierMatchTrait;
use YellowCable\Collection\Traits\Locators\IterativeGetTrait;

/**
 * @template Item
 * @template Collection
 */
trait AggregationStaticTrait
{
    /** @var CollectionInterface<AggregationInterface> & FirstIdentifierMatchInterface & IterativeGetInterface $aggregations */
    private static CollectionInterface & FirstIdentifierMatchInterface & IterativeGetInterface $aggregations;

    /**
     * Get an array of all Aggregations registered in the static list.
     *
     * @return IterativeGetInterface&FirstIdentifierMatchInterface&CollectionInterface<AggregationInterface>
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
     * @inheritDoc
     *
     * @return AggregationInterface<Item, Collection>&AggregationStaticInterface<Item, Collection>
     * @throws DoesNotExistException
     */
    public static function aggregate(
        CollectionInterface $collection,
        bool $preventDuplicates = true
    ): AggregationInterface&AggregationStaticInterface {
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
     * @inheritDoc
     * @return AggregationInterface<Item, Collection>
     * @throws DoesNotExistException
     */
    public static function get(string $identifier): AggregationInterface
    {
        return self::registry()->getFirstIdentifierMatch($identifier) ?? throw new DoesNotExistException();
    }

    /**
     * Register an Aggregation in the static list.
     *
     * @param AggregationInterface<Item, Collection> $aggregation
     * @return AggregationInterface<Item, Collection>
     */
    protected static function set(AggregationInterface $aggregation): AggregationInterface
    {
        return self::registry()[] = $aggregation;
    }

    /**
     * @inheritDoc
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
