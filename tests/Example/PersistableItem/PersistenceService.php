<?php

namespace YellowCable\Collection\Tests\Example\PersistableItem;

use Exception;
use Throwable;
use YellowCable\Collection\Interfaces\PersistenceInterface;

class PersistenceService implements PersistenceInterface
{
    /**
     * @throws Exception
     */
    public static function get(string $key): ?string
    {
        try {
            if (file_exists("tmp/$key")) {
                $file = file_get_contents("tmp/$key");
                return $file ?: null;
            }
        } catch (Throwable) {
            throw new Exception();
        }
        return null;
    }

    /**
     * @throws Exception
     */
    public static function put(string $key, callable $resource): void
    {
        if (!file_put_contents("tmp/$key", $resource())) {
            throw new Exception();
        }
    }

    /**
     * @throws Exception
     */
    public static function delete(string $key): void
    {
        if (!unlink("tmp/$key")) {
            throw new Exception();
        }
    }
}
