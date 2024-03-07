<?php

namespace YellowCable\Collection\Tests\Example;

use YellowCable\Collection\Exceptions\DoesNotExistException;
use YellowCable\Collection\Interfaces\Datastore\PersistenceInterface;

class Persistence implements PersistenceInterface
{
    /** @var array<mixed>  */
    private static array $store = [];

    /**
     * @throws DoesNotExistException
     */
    public static function get(string $key): ?string
    {
        return self::$store[$key] ?? throw new DoesNotExistException();
    }

    public static function put(string $key, callable $resource): void
    {
        self::$store[$key] = $resource();
    }

    public static function delete(string $key): void
    {
        unset(self::$store[$key]);
    }
}
