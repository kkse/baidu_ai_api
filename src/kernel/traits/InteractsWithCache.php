<?php

namespace kkse\baidu_ai\kernel\traits;

use InvalidArgumentException;
use kkse\baidu_ai\kernel\ServiceContainer;
use Psr\Cache\CacheItemPoolInterface;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;

/**
 * Trait InteractsWithCache.
 * @property $app
 */
trait InteractsWithCache
{
    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * Get cache instance.
     *
     * @return CacheInterface
     *
     * @throws InvalidArgumentException
     */
    public function getCache()
    {
        if ($this->cache) {
            return $this->cache;
        }

        if (property_exists($this, 'app') && $this->app instanceof ServiceContainer && isset($this->app['cache'])) {
            $this->setCache($this->app['cache']);

            // Fix PHPStan error
            assert($this->cache instanceof CacheInterface);

            return $this->cache;
        }

        return $this->cache = $this->createDefaultCache();
    }

    /**
     * Set cache instance.
     *
     * @param CacheInterface|CacheItemPoolInterface $cache
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function setCache($cache)
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

        $this->cache = $cache;

        return $this;
    }

    /**
     * @return CacheInterface
     */
    protected function createDefaultCache()
    {
        return new Psr16Cache(new FilesystemAdapter('baiduai', 1500));
    }

}
