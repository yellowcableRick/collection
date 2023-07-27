<?php

namespace YellowCable\Collection\Traits\Datastore;

use DateTime;
use Laravel\SerializableClosure\Exceptions\PhpVersionNotSupportedException;
use Laravel\SerializableClosure\SerializableClosure;
use Laravel\SerializableClosure\UnsignedSerializableClosure;
use YellowCable\Collection\Collection;
use YellowCable\Collection\Exceptions\FailedInheritanceException;
use YellowCable\Collection\Exceptions\UnequalCountException;

/**
 * DataProviderTrait enables any collection
 */
trait DataProviderTrait
{
    /** @var UnsignedSerializableClosure $dataProvider Method to provide the data for the collection */
    private UnsignedSerializableClosure $dataProvider;
    /** @var UnsignedSerializableClosure $updateProvider Method to provide updates for the collection */
    private UnsignedSerializableClosure $updateProvider;
    /** @var UnsignedSerializableClosure $countProvider Method to provide a count on the original data source */
    private UnsignedSerializableClosure $countProvider;
    /** @var UnsignedSerializableClosure $primaryKeyValuesProvider Method to provide the primary keys of the original data source */
    private UnsignedSerializableClosure $primaryKeyValuesProvider;
    /** @var ?DateTime $lastUpdated DateTime when the last time the updateProvider ran */
    private ?DateTime $lastUpdated = null;

    /**
     * @inheritDoc
     *
     * @param mixed $offset
     * @param mixed $value
     *
     * @return void
     */
    abstract public function offsetSet(mixed $offset, mixed $value): void;

    /**
     * Setter for the dataProvider property. Uses Laravel\SerializableClosure
     * to ensure the serialization of the property.
     *
     * @param callable $dataProvider
     *
     * @return $this
     */
    public function setDataProvider(callable $dataProvider): static
    {
        $this->dataProvider = SerializableClosure::unsigned($dataProvider);
        return $this;
    }

    /**
     * Execute the dataProvider method after deserializing. Method is variadic
     * due to the expandable $args which is passed to the dataProvider method
     * directly.
     *
     * The dataProvider assumes to have all concerning data, so the full collection
     * is going to be overwritten. It also assumes to only contain the appropriate
     * data type so the verification of the new data is turned off.
     *
     * @param mixed ...$args
     *
     * @return DataProviderTrait
     * @throws FailedInheritanceException
     * @throws PhpVersionNotSupportedException
     */
    public function runDataProvider(mixed ...$args): static
    {
        if ($this instanceof Collection) {
            $this->setCollection($this->dataProvider->getClosure()(...$args), false);
            $this->lastUpdated = new DateTime();
            return $this;
        } else {
            throw new FailedInheritanceException("DataProviderTrait used on something other than a Collection");
        }
    }

    /**
     * Setter for the updateProvider property. Uses Laravel\SerializableClosure
     * to ensure the serialization of the property.
     *
     * @param callable $updateProvider
     *
     * @return $this
     */
    public function setUpdateProvider(callable $updateProvider): static
    {
        $this->updateProvider = SerializableClosure::unsigned($updateProvider);
        return $this;
    }

    /**
     * Execute the updateProvider method after deserializing. Method is variadic
     * due to the expandable $args which is passed to the updateProvider method
     * directly.
     *
     * The updateDriver assumes to only contain refreshed data, so it will search
     * the existing primary key of the item and replace the item, or insert a new
     * item with the offset as null, which expects to generate a new offset.
     *
     * If the class uses this trait, but does not have the primaryKey trait, all
     * data gathered from the updateProvider will be appended to the collection.
     *
     * @param mixed ...$args
     *
     * @return DataProviderTrait
     * @throws FailedInheritanceException
     * @throws PhpVersionNotSupportedException
     */
    public function runUpdateProvider(mixed ...$args): static
    {
        if ($this instanceof Collection) {
            $changes = 0;
            //TODO: Reduce complexity
            if (method_exists($this, "getPrimaryKey") && $primaryKey = $this->getPrimaryKey()) {
                foreach ($this->updateProvider->getClosure()(...$args) as $item) {
                    if (method_exists($item, "get" . ucfirst($primaryKey))) {
                        $getter = "get" . ucfirst($primaryKey);
                        $reference = $item->$getter();
                        $this->offsetSet($this->getKey(fn($x) => $x->$getter() === $reference), $item);
                        $changes++;
                    } elseif (property_exists($item, $primaryKey)) {
                        $reference = $item->$$primaryKey;
                        $this->offsetSet($this->getKey(fn($x) => $x->$$primaryKey === $reference), $item);
                        $changes++;
                    }
                }
            } else {
                foreach ($this->updateProvider->getClosure()(...$args) as $item) {
                    $this->offsetSet(null, $item);
                    $changes++;
                }
            }
            if ($changes && isset($this->fixedCount)) {
                $this->fixedCount += $changes;
            }
            $this->lastUpdated = new DateTime();
            return $this;
        } else {
            throw new FailedInheritanceException("DataProviderTrait used on something other than a Collection");
        }
    }

    /**
     * Setter for the countProvider property. Uses Laravel\SerializableClosure
     * to ensure the serialization of the property.
     *
     * @param callable $countProvider
     *
     * @return $this
     */
    public function setCountProvider(callable $countProvider): static
    {
        $this->countProvider = SerializableClosure::unsigned($countProvider);
        return $this;
    }

    /**
     *
     * Execute the countProvider and compare it against a local count.
     * If the count isn't equal, it will throw an Exception.
     *
     * @throws UnequalCountException
     * @throws PhpVersionNotSupportedException
     * @throws FailedInheritanceException
     */
    public function runCountProvider(mixed ...$args): static
    {
        if ($this instanceof Collection) {
            $sourceCount = $this->updateProvider->getClosure()(...$args);
            if ($sourceCount !== $this->count()) {
                throw new UnequalCountException("Source: $sourceCount. Collection: {$this->count()}");
            }
            return $this;
        } else {
            throw new FailedInheritanceException("DataProviderTrait used on something other than a Collection");
        }
    }

    /**
     * Getter for the lastUpdated property.
     *
     * @return DateTime|null
     */
    public function getDataProviderLastUpdated(): ?DateTime
    {
        return $this->lastUpdated;
    }
}
