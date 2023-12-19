<?php

namespace YellowCable\Collection\Traits\Manipulation;

use YellowCable\Collection\Collection;
use YellowCable\Collection\Exceptions\SplitException;
use YellowCable\Collection\Interfaces\CollectionInterface;
use YellowCable\Collection\Traits\Locators\IterativeGetTrait;

trait SplitTrait
{
    private string $splitIdentifier;
    public function split(callable $condition): CollectionInterface
    {
        $collection = new class ($this->getIdentifier()) extends Collection {
            use IterativeGetTrait;

            public function getClass(): string
            {
                return CollectionInterface::class;
            }
        };

        foreach ($this as $item) {
            $unique = $condition($item);
            if (
                !($sub = $collection->getItem(fn(CollectionInterface $sub) =>
                method_exists($sub, "getSplitIdentifier") && $sub->getSplitIdentifier() === $unique))
            ) {
                $sub = $collection[] = clone $this;
                $sub->__construct($this->getIdentifier(), []);
                $sub->setSplitIdentifier($unique);
            }
            $sub[] = $item;
        }

        return $collection;
    }

    /**
     * @throws SplitException
     */
    public function getSplitIdentifier(): string
    {
        return $this->splitIdentifier ?? throw new SplitException("Not a spliced collection, or there is no split id");
    }

    private function setSplitIdentifier(string $identifier): CollectionInterface
    {
        $this->splitIdentifier = $identifier;
        return $this;
    }
}
