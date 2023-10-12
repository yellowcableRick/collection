<?php

namespace YellowCable\Collection\Interfaces;

use ArrayAccess;
use Countable;
use Iterator;
use JsonSerializable;
use SeekableIterator;

/**
 * @extends ArrayAccess<int, object>
 * @extends Iterator<int, object>
 * @extends SeekableIterator<int, object>
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
     * @return string
     */
    public function getClass(): string;
    public function getEncapsulation(): self;
    public function getKey(callable $condition): ?int;
    public function getItem(callable $condition): mixed;
    public function getIdentifier(): string;
    public function setIdentifier(string $identifier): self;
}
