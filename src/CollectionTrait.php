<?php

namespace YellowCable\Collection;

use YellowCable\Collection\Traits\Generic\ArrayAccessTrait;
use YellowCable\Collection\Traits\Generic\CountableTrait;
use YellowCable\Collection\Traits\Generic\IteratorTrait;
use YellowCable\Collection\Traits\Generic\JsonSerializeTrait;
use YellowCable\Collection\Traits\Generic\MagicMethodsTrait;
use YellowCable\Collection\Traits\Generic\SeekableIteratorTrait;

trait CollectionTrait
{
    use ArrayAccessTrait;
    use IteratorTrait;
    use CountableTrait;
    use JsonSerializeTrait;
    use SeekableIteratorTrait;
    use MagicMethodsTrait;

    /** @var array<int, mixed> $collection Mixed array which will contain any type of item */
    private array $collection;
    /** @var int $index Iterator index which holds the current iteration key */
    private int $index;
    /** @var int $fixedCount Placeholder for the output of count, when the collection is cleared */
    private int $fixedCount;
    /** @var string $identifier String to hold a value to later identify this specific collection */
    private string $identifier;

    /**
     * Set array as collection.
     *
     * @param array $array
     * @param bool|null $verify
     * @return void
     */
    protected function setCollection(array $array, ?bool $verify = true): void
    {
        if ($verify && $array && $this->getClass()) {
            $this->collection = [];
            $i = 0;
            foreach ($array as $item) {
                $this->offsetSet($i++, $item);
            }
        } else {
            $this->collection = array_values($array);
        }
    }

    /**
     * Return this collection and all additional information, but without the actual collection.
     *
     * @return Collection
     */
    public function getEncapsulation(): self
    {
        $encapsulation = clone($this);
        $encapsulation->fixedCount = $this->count();
        $encapsulation->collection = [];
        $encapsulation->rewind();
        return $encapsulation;
    }

    /**
     * Get the first key from the collection where the item meets the condition.
     *
     * @param callable $condition
     * @return int|null
     */
    public function getKey(callable $condition): ?int
    {
        foreach ($this->collection as $key => $item) {
            if ($condition($item)) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Get the first item from the collection where the item meets the condition.
     *
     * @param callable $condition
     * @return mixed
     */
    public function getItem(callable $condition): mixed
    {
        foreach ($this->collection as $item) {
            if ($condition($item)) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Getter for the identifier of the collection.
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return ($this->identifier ?? "");
    }

    /**
     * Setter for the identifier of the collection.
     *
     * @param string $identifier
     * @return $this
     */
    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;
        return $this;
    }
}
