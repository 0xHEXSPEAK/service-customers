<?php

namespace common\components\cache;

use yii\base\Component;

/**
 * Class AppCache
 *
 * @package common\components\cache
 */
class AppCache extends Component
{
    /** Defines a cache key prefix */
    const CACHE_PREFIX = '_customers';

    /**
     * Defines a cache time to live before it expires
     *
     * @var int $ttl
     */
    public $ttl;

    /**
     * Stores a value identified by a key into cache.
     *
     * @param mixed $key
     * @param mixed $value
     * @return bool
     */
    public function create($key, $value)
    {
        $cacheKey = $this->buildKey($key);
        return \Yii::$app->cache->set($cacheKey, $value, (int) $this->ttl);
    }

    /**
     * Retrieves a value from cache with a specified key.
     *
     * @param mixed $key
     * @return mixed
     */
    public function retrieve($key)
    {
        $cacheKey = $this->buildKey($key);
        return \Yii::$app->cache->get($cacheKey);
    }

    /**
     * Checks whether a specified key exists in the cache.
     *
     * @param mixed $key
     * @return bool
     */
    public function isExists($key)
    {
        $cacheKey = $this->buildKey($key);
        return \Yii::$app->cache->exists($cacheKey);
    }

    /**
     * Builds a cache key
     *
     * @param mixed $key
     * @return array
     */
    protected function buildKey($key)
    {
        return [
            __CLASS__,
            self::CACHE_PREFIX,
            $key
        ];
    }
}
