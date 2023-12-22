<?php

namespace YellowCable\Collection\Interfaces\Datastore;

interface PersistenceInterface
{
    public static function get(string $key): ?string;
    public static function put(string $key, callable $resource): void;
    public static function delete(string $key): void;
}
