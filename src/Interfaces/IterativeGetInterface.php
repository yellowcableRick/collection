<?php

namespace YellowCable\Collection\Interfaces;

interface IterativeGetInterface
{
    public function getKey(callable $condition): ?int;
    public function getItem(callable $condition): mixed;
}
