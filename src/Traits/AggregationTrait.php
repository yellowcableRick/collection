<?php

namespace YellowCable\Collection\Traits;

use YellowCable\Collection\Exceptions\DuplicateItemException;
use YellowCable\Collection\Exceptions\EmptyException;
use YellowCable\Collection\Exceptions\NotImplementedException;
use YellowCable\Collection\Exceptions\ValidationException;
use YellowCable\Collection\Interfaces\AggregationInterface;
use YellowCable\Collection\Interfaces\CollectionInterface;

/**
 * @template Item
 * @template Collection
 */
trait AggregationTrait
{
    /**
     * @inheritDoc
     * @TODO: Duplication check is rather expensive, and might be subject to refactoring
     * @return AggregationInterface<Item, Collection>
     * @throws DuplicateItemException
     * @throws NotImplementedException
     * @throws ValidationException
     * @throws EmptyException
     */
    public function addCollection(
        CollectionInterface $collection,
        bool $preventDuplicates = true
    ): AggregationInterface {
        if ($collection->count() === 0) {
            throw new EmptyException();
        }

        if ($preventDuplicates) {
            if (
                method_exists($collection, "getPrimaryKeyValues") &&
                isset($collection->getPrimaryKeyValues()[$collection->getClass()])
            ) {
                $checkDuplication = fn($x, $y): bool => $x !== array_unique($x) || array_intersect($y ?? [], $x) !== [];
                $collectionKeys = $collection->getPrimaryKeyValues()[$collection->getClass()];
                $knownKeys = [];
                foreach ($this->__call("getPrimaryKeyValues") as $getPrimaryKeyValues) {
                    $knownKeys = array_merge($knownKeys, $getPrimaryKeyValues[$collection->getClass()] ?? []);
                }

                if ($checkDuplication($collectionKeys, $knownKeys)) {
                    throw new DuplicateItemException();
                }
            } else {
                throw new ValidationException("Preconditions for validation failed.");
            }
        }

        $this->offsetSet(null, $collection->getEncapsulation());
        return $this;
    }

    /**
     * @inheritDoc
     *
     * @return bool
     */
    public function delete(): bool
    {
        return static::remove($this->getIdentifier());
    }
}
