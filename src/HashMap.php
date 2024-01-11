<?php

namespace YellowCable\Collection;

use YellowCable\Collection\Interfaces\HashMapInterface;
use YellowCable\Collection\Traits\HashMapTrait;

abstract class HashMap implements HashMapInterface
{
    use HashMapTrait;
}
