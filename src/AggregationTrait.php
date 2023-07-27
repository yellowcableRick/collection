<?php

namespace YellowCable\Collection;

use YellowCable\Collection\Exceptions\DuplicateItemException;
use YellowCable\Collection\Exceptions\NotImplementedException;
use YellowCable\Collection\Exceptions\ValidationException;

trait AggregationTrait
{
    /**
     * Constructor for Aggregation. Any and all Aggregation constructed will
     * be directly stored in the static property.
     *
     * @param string $identifier
     */
    public function __construct(string $identifier = "")
    {
        parent::__construct($identifier);
        static::set($this);
    }

    /**
     * Add a collection to this Aggregation. If you choose to prevent duplications in
     * the aggregated Collections, it will compare the new primary keys with the
     * primary keys already present in the aggregation. You can only prevent duplication
     * if the Collections use the PrimaryKeyTrait, which defines the unique property
     * between the collected Items.
     *
     * @param CollectionInterface $collection
     * @param bool $preventDuplicates
     * @return AggregationInterface
     * @throws DuplicateItemException
     * @throws NotImplementedException
     * @throws ValidationException
     */
    public function addCollection(
        CollectionInterface $collection,
        bool $preventDuplicates = true
    ): AggregationInterface {
        if ($collection->count() === 0) {
            return $this;
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
     * Remove this aggregation from the registry.
     *
     * @return bool
     */
    public function delete(): bool
    {
        return static::remove($this->getIdentifier());
    }
}
