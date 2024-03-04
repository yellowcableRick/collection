<?php

namespace YellowCable\Collection;

use YellowCable\Collection\Interfaces\HashMapInterface;
use YellowCable\Collection\Traits\HashMapTrait;

/**
 * @template Item
 * @extends Collection<Item>
 */
abstract class HashMap extends Collection implements HashMapInterface
{
    use HashMapTrait;
}
