<?php

namespace YellowCable\Collection\Traits;

use YellowCable\Collection\Aggregation;
use YellowCable\Collection\Exceptions\DoesNotExistException;
use YellowCable\Collection\Exceptions\EmptyException;
use YellowCable\Collection\Exceptions\NotImplementedException;
use YellowCable\Collection\Interfaces\AggregationInterface;
use YellowCable\Collection\Interfaces\CollectionInterface;

/**
 * @template Item
 */
trait AggregationStaticTrait
{
    /**
     * @param CollectionInterface<Item> $collection
     * @param bool                $preventDuplicates
     * @return AggregationInterface<Item>
     * @throws DoesNotExistException
     * @throws EmptyException
     * @throws NotImplementedException
     */
    public static function aggregate(
        CollectionInterface $collection,
        bool $preventDuplicates = true
    ): AggregationInterface {
        try {
            AggregationRegistry::get($collection->getIdentifier());
        } catch (EmptyException | DoesNotExistException) {
            (new class ($collection->getIdentifier()) extends Aggregation implements AggregationInterface {
                public function getClass(): string
                {
                    return CollectionInterface::class;
                }
            });
        }
        $staticAggregation = AggregationRegistry::get($collection->getIdentifier());
        $staticAggregation->addCollection($collection, $preventDuplicates);
        return $staticAggregation;
    }
}
