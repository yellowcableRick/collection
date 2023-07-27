<?php

namespace YellowCable\Collection;

use ArrayAccess;
use Countable;
use Iterator;
use JsonSerializable;
use SeekableIterator;

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
