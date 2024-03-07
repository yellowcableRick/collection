<?php

namespace YellowCable\Collection\Traits\Addons\Manipulation;

use YellowCable\Collection\Exceptions\SplitException;
use YellowCable\Collection\Interfaces\CollectionInterface;
use YellowCable\Collection\Interfaces\Locators\PrimaryKeysInterface;
use YellowCable\Collection\Traits\Addons\Locators\PrimaryKeysTrait;
use YellowCable\Collection\Traits\CollectionTrait;

/**
 * @template Item
 */
trait SplitTrait
{
    private string $splitIdentifier;

    /**
     * @param callable $condition
     * @return PrimaryKeysInterface&CollectionInterface
     */
    public function split(callable $condition): CollectionInterface&PrimaryKeysInterface
    {
        /** @var array<CollectionInterface> $subs */
        $subs = [];
        foreach ($this as $item) {
            $unique = $condition($item);
            if ($unique !== null) {
                if (!isset($subs[$unique])) {
                    /** @var self $cap */
                    $cap = $this->getEncapsulation();
                    $subs[$unique] = $cap;
                    !property_exists($subs[$unique], "fixedCount") ?: $subs[$unique]->fixedCount = 0;
                    $subs[$unique]->setSplitIdentifier($unique);
                }
                $subs[$unique][] = $item;
            }
        }

        /** @var CollectionInterface&PrimaryKeysInterface $class */
        $class = new class ($this->getIdentifier(), $subs) implements CollectionInterface, PrimaryKeysInterface {
            /** @use CollectionTrait<Item> */
            use CollectionTrait;
            /** @use PrimaryKeysTrait<Item> */
            use PrimaryKeysTrait;

            public function __construct(string $identifier, mixed $subs)
            {
                $this->setIdentifier($identifier);
                $this->setCollection($subs, false);
            }

            public function getClass(): string
            {
                return CollectionInterface::class;
            }

            public function declaredPrimaryKey(): string
            {
                return "getSplitIdentifier";
            }
        };

        return $class;
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
