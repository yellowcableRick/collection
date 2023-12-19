<?php

namespace YellowCable\Collection\Traits;

use YellowCable\Collection\Interfaces\CollectionInterface;
use YellowCable\Collection\Traits\Generic\ArrayAccessTrait;
use YellowCable\Collection\Traits\Generic\CountableTrait;
use YellowCable\Collection\Traits\Generic\FirstTrait;
use YellowCable\Collection\Traits\Generic\GeneratorTrait;
use YellowCable\Collection\Traits\Generic\IteratorTrait;
use YellowCable\Collection\Traits\Generic\JsonSerializeTrait;
use YellowCable\Collection\Traits\Generic\MagicMethodsTrait;
use YellowCable\Collection\Traits\Generic\SeekableIteratorTrait;
use YellowCable\Collection\Traits\Locators\IterativeGetTrait;

trait CollectionTrait
{
    use ArrayAccessTrait;
    use CountableTrait;
    use FirstTrait;
    use GeneratorTrait;
    use IteratorTrait;
    use JsonSerializeTrait;
    use MagicMethodsTrait;
    use SeekableIteratorTrait;

    /** @var array<int, mixed> $collection Mixed array which will contain any type of item */
    private array $collection = [];
    /** @var int $fixedCount Placeholder for the output of count, when the collection is cleared */
    private int $fixedCount;
    /** @var string $identifier String to hold a value to later identify this specific collection */
    private string $identifier;

    /**
     * Set array as collection.
     *
     * @param iterable  $source
     * @param bool|null $verify
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
     * @return CollectionInterface
     */
    public function getEncapsulation(): CollectionInterface
    {
        $encapsulation = clone($this);
        $encapsulation->fixedCount = $this->count();
        $encapsulation->collection = [];
        $encapsulation->rewind();
        return $encapsulation;
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
     * @return CollectionInterface
     */
    public function setIdentifier(string $identifier): CollectionInterface
    {
        $this->identifier = $identifier;
        return $this;
    }
}
