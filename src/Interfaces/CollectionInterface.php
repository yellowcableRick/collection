<?php

namespace YellowCable\Collection\Interfaces;

use ArrayAccess;
use Countable;
use Iterator;
use JsonSerializable;
use SeekableIterator;

/**
 * @template Item
 * @extends ArrayAccess<int, Item>
 * @extends Iterator<int, Item>
 * @extends SeekableIterator<int, Item>
 */
interface CollectionInterface extends
    ArrayAccess,
    Iterator,
    Countable,
    JsonSerializable,
    SeekableIterator
{
    /**
     * getClass must return the class (FQN) of the allowed objects in the Collection.
     *
     * @return class-string
     */
    public function getClass(): string;

    /**
     * Return the Collection object without the items.
     *
     * @return CollectionInterface<Item>
     */
    public function getEncapsulation(): CollectionInterface;

    /**
     * Get the identifier for this collection.
     *
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * Set the identifier for this collection.
     *
     * @param string $identifier
     * @return CollectionInterface<Item>
     */
    public function setIdentifier(string $identifier): CollectionInterface;
}
