<?php

namespace YellowCable\Collection\Traits;

use YellowCable\Collection\Interfaces\CollectionInterface;
use YellowCable\Collection\Traits\Generic\ArrayAccessTrait;
use YellowCable\Collection\Traits\Generic\CountableTrait;
use YellowCable\Collection\Traits\Generic\GeneratorTrait;
use YellowCable\Collection\Traits\Generic\IteratorTrait;
use YellowCable\Collection\Traits\Generic\JsonSerializeTrait;
use YellowCable\Collection\Traits\Generic\MagicMethodsTrait;
use YellowCable\Collection\Traits\Generic\SeekableIteratorTrait;

/**
 * @template Item
 */
trait CollectionTrait
{
    use ArrayAccessTrait;
    use CountableTrait;
    /** @use GeneratorTrait<Item> */
    use GeneratorTrait;
    /** @use IteratorTrait<Item> */
    use IteratorTrait;
    use JsonSerializeTrait;
    use MagicMethodsTrait;
    use SeekableIteratorTrait;

    /** @var array<int, Item> $collection Mixed array which will contain any type of item */
    protected array $collection = [];
    /** @var string $identifier String to hold a value to later identify this specific collection */
    protected string $identifier;

    /**
     * Set array as collection.
     *
     * @param iterable<Item>    $source
     * @param bool|null         $verify
     * @return void
     */
    protected function setCollection(iterable $source, ?bool $verify = true): void
    {
        $this->collection = [];
        if ($verify && $this->getClass()) {
            $i = 0;
            foreach ($source as $item) {
                $this->offsetSet($i++, $item);
            }
        } else {
            if (is_array($source)) {
                $this->collection = array_values($source);
            } else {
                foreach ($source as $item) {
                    $this->collection[] = $item;
                }
            }
        }
    }

    /**
     * Return this collection and all additional information, but without the actual collection.
     *
     * @return CollectionInterface<Item>
     */
    public function getEncapsulation(): CollectionInterface
    {
        $encapsulation = clone($this);
        !property_exists($encapsulation, "fixedCount") ?: $encapsulation->fixedCount = $this->count();
        $encapsulation->collection = [];
        $encapsulation->rewind();
        return $encapsulation;
    }

    /**
     * @inheritDoc
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return ($this->identifier ?? "");
    }

    /**
     * @inheritDoc
     *
     * @param string $identifier
     * @return CollectionInterface<Item>
     */
    public function setIdentifier(string $identifier): CollectionInterface
    {
        $this->identifier = $identifier;
        return $this;
    }
}
