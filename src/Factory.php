<?php

namespace kkse\baidu_ai;

use InvalidArgumentException;
use kkse\baidu_ai\Application;
use Psr\Cache\CacheItemPoolInterface;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;

class Factory
{
    /**
     * @var CacheInterface
     */
    protected static $cache;

    /**
     * 获取api对象
     * @param array $config
     * @return Application
     */
    public static function api(array $config){
        return new Application($config);
    }


    public static function getCache()
    {
        if (self::$cache) {
            return self::$cache;
        }

        return self::$cache = self::createDefaultCache();
    }

    /**
     * Set cache instance.
     *
     * @param CacheInterface|CacheItemPoolInterface $cache
     * @throws InvalidArgumentException
     */
    public static function setCache($cache)
    {
        if (empty(array_intersect([CacheInterface::class, CacheItemPoolInterface::class], class_implements($cache)))) {
            throw new InvalidArgumentException(
                sprintf('The cache instance must implements %s or %s interface.',
                    CacheInterface::class, CacheItemPoolInterface::class
                )
            );
        }

        if ($cache instanceof CacheItemPoolInterface) {
            $cache = new Psr16Cache($cache);
        }

        self::$cache = $cache;
    }

    /**
     * @return CacheInterface
     */
    protected static function createDefaultCache()
    {
        return new Psr16Cache(new FilesystemAdapter('kkse_baidu_ai', 1500));
    }
}
