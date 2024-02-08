<?php

namespace YellowCable\Collection\Traits\Manipulation;

use YellowCable\Collection\Collection;
use YellowCable\Collection\Exceptions\SplitException;
use YellowCable\Collection\Interfaces\CollectionInterface;
use YellowCable\Collection\Interfaces\Locators\PrimaryKeysInterface;
use YellowCable\Collection\Traits\CollectionTrait;
use YellowCable\Collection\Traits\Locators\PrimaryKeysTrait;

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
        /**
         * @template Item
         * @implements CollectionInterface<Item>
         * @implements PrimaryKeysInterface<Item>
         */
        $class = new class ($this->getIdentifier(), $subs) implements CollectionInterface, PrimaryKeysInterface {
            /** @use CollectionTrait<Item> */
            use CollectionTrait;
            /** @use PrimaryKeysTrait<Item> */
            use PrimaryKeysTrait;

            public function __construct(string $identifier, array $subs)
            {
                $this->setIdentifier($identifier);
                $this->setCollection($subs);
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
