<?php

namespace YellowCable\Collection\Traits\Datastore;

use Exception;
use Throwable;
use YellowCable\Collection\Collection;
use YellowCable\Collection\Exceptions\FailedToPersistException;
use YellowCable\Collection\Exceptions\FailedToUnpersistException;
use YellowCable\Collection\Interfaces\CollectionInterface;
use YellowCable\Collection\Interfaces\PersistenceInterface;

/**
 * PersistenceTrait allows any type of collection to be cached in a cache using PersistenceService.
 * Every persisted collection will be prefixed with a standard prefix and postfixed with its identifier.
 * Persisting any collection will always invalidate the previous version.
 */
trait PersistenceTrait
{
    protected static string $PERSISTENT_PREFIX = "PersistenceTrait-";
    public static PersistenceInterface $persistenceService;

    /**
     * Persisting Collection onto Redis.
     *
     * @param Collection $collection
     *
     * @return Collection
     * @throws Exception
     */
    public static function persistCollection(CollectionInterface $collection): CollectionInterface
    {
        if (self::getPersistence($collection->getIdentifier())) {
            self::unpersistCollection($collection);
        }
        try {
            self::$persistenceService::put(
                self::$PERSISTENT_PREFIX . $collection->getIdentifier(),
                fn() => gzdeflate(serialize($collection))
            );
            return $collection;
        } catch (Throwable $e) {
            throw new FailedToPersistException($e);
        }
    }

    /**
     * Unpersisting Collection from Redis.
     *
     * @param Collection $collection
     * @return void
     * @throws Exception
     */
    public static function unpersistCollection(CollectionInterface $collection): void
    {
        try {
            self::$persistenceService->delete(self::$PERSISTENT_PREFIX . $collection->getIdentifier());
        } catch (Throwable) {
            throw new FailedToUnpersistException();
        }
    }

    /**
     * Get a persisted Collection based on the identifier.
     *
     * @param string $identifier
     * @return ?Collection
     * @throws Exception
     */
    public static function getPersistence(string $identifier): ?CollectionInterface
    {
        try {
            $cache = self::$persistenceService->get(self::$PERSISTENT_PREFIX . $identifier);
            if (is_string($cache)) {
                return unserialize(gzinflate($cache));
            }
        } catch (Throwable) {
            return null;
        }
        return null;
    }

    /**
     * Persist this specific Collection.
     *
     * @return Collection
     * @throws Exception
     */
    public function persist(): CollectionInterface
    {
        return self::persistCollection($this);
    }

    /**
     * Unpersist this specific Collection.
     *
     * @return CollectionInterface
     * @throws Exception
     */
    public function unpersist(): CollectionInterface
    {
            self::unpersistCollection($this);
            return $this;
    }

    /**
     * Read this Collection from the database and set all properties of this Collection
     * with all the values known in the persisted version. You can set the condition to
     * be a callable boolean method on the item that will be restored if true.
     *
     * @param callable|null $condition
     *
     * @return CollectionInterface
     * @throws Exception
     */
    public function hydrate(?callable $condition = null): CollectionInterface
    {
        if ($cache = self::getPersistence($this->getIdentifier())) {
            foreach ($cache as $key => $item) {
                if (!is_null($condition)) {
                    !$condition($item) ?: $this->offsetSet($key, $item);
                } else {
                    $this->offsetSet($key, $item);
                }
            }
        }
        return $this;
    }
}
