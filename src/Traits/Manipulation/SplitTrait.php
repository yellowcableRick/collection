<?php

namespace YellowCable\Collection\Traits\Manipulation;

use YellowCable\Collection\Collection;
use YellowCable\Collection\Exceptions\SplitException;
use YellowCable\Collection\Interfaces\CollectionInterface;

trait SplitTrait
{
    private string $splitIdentifier;
    public function split(callable $condition): CollectionInterface
    {
        $subs = [];
        foreach ($this as $item) {
            $unique = $condition($item);
            if (!isset($subs[$unique])) {
                /** @var self $cap */
                $cap = $this->getEncapsulation();
                $subs[$unique] = $cap;
                !property_exists($subs[$unique], "fixedCount") ?: $subs[$unique]->fixedCount = 0;
                $subs[$unique]->setSplitIdentifier($unique);
            }
            $subs[$unique][] = $item;
        }

        return new class ($this->getIdentifier(), $subs) extends Collection {
            public function getClass(): string
            {
                return CollectionInterface::class;
            }
        };
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
