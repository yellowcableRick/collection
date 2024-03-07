<?php

namespace YellowCable\Collection\Traits;

use YellowCable\Collection\Collection;
use YellowCable\Collection\Exceptions\DoesNotExistException;
use YellowCable\Collection\Exceptions\EmptyException;
use YellowCable\Collection\Exceptions\NotImplementedException;
use YellowCable\Collection\Exceptions\ValidationException;
use YellowCable\Collection\Interfaces\AggregationInterface;
use YellowCable\Collection\Interfaces\CollectionInterface;
use YellowCable\Collection\Interfaces\Locators\FirstIdentifierMatchInterface;
use YellowCable\Collection\Interfaces\Locators\IterativeGetInterface;
use YellowCable\Collection\Traits\Addons\Locators\FirstIdentifierMatchTrait;
use YellowCable\Collection\Traits\Addons\Locators\IterativeGetTrait;

/**
 * @template Item
 * @extends Collection<Item>
 * @implements FirstIdentifierMatchInterface<Item>
 * @implements IterativeGetInterface<Item>
 */
final class AggregationRegistry extends Collection implements FirstIdentifierMatchInterface, IterativeGetInterface
{
    /** @use CollectionTrait<Item> */
    use CollectionTrait;
    /** @use FirstIdentifierMatchTrait<Item> */
    use FirstIdentifierMatchTrait;
    /** @use IterativeGetTrait<Item> */
    use IterativeGetTrait;

    /** @var AggregationRegistry<AggregationInterface<Item>> $registry */
    private static self $registry;

    private function __construct()
    {
        parent::__construct();
        $this->rewind();
    }

    public function getClass(): string
    {
        return AggregationInterface::class;
    }

    /**
     * @return AggregationRegistry<AggregationInterface<Item>>
     */
    public static function registry(): self
    {
        return self::$registry ?? self::$registry = new self();
    }

    /**
     * @return AggregationInterface<Item>
     * @throws DoesNotExistException
     * @throws EmptyException
     * @throws NotImplementedException
     */
    public static function get(string $identifier): AggregationInterface
    {
        return AggregationRegistry::registry()->getFirstIdentifierMatch($identifier) ??
            throw new DoesNotExistException();
    }

    /**
     * Register an Aggregation in the static list.
     *
     * @param AggregationInterface<Item> $aggregation
     * @return AggregationInterface<Item>
     * @throws ValidationException
     */
    public static function set(AggregationInterface $aggregation): AggregationInterface
    {
        AggregationRegistry::registry()->offsetSet(null, $aggregation);
        return $aggregation;
    }

    /**
     *
     * @param string $identifier
     * @return bool
     */
    public static function remove(string $identifier): bool
    {
        if (
            is_int($key = self::registry()->getKey(fn(AggregationInterface $x) => $x->getIdentifier() === $identifier))
        ) {
            self::registry()->offsetUnset($key);
            if (!is_int(self::registry()->getKey(fn(AggregationInterface $x) => $x->getIdentifier() === $identifier))) {
                return true;
            }
        }
        return false;
    }
}
