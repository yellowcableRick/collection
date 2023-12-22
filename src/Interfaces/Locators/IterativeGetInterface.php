<?php

namespace YellowCable\Collection\Interfaces\Locators;

interface IterativeGetInterface
{
    public function getKey(callable $condition): ?int;
    public function getItem(callable $condition): mixed;
}
