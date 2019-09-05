<?php
namespace kkse\baidu_ai\kernel;


use GuzzleHttp\Client;
use kkse\baidu_ai\kernel\providers\AccessTokenServiceProvider;
use kkse\baidu_ai\kernel\providers\ConfigServiceProvider;
use kkse\baidu_ai\kernel\providers\EventDispatcherServiceProvider;
use kkse\baidu_ai\kernel\providers\HttpClientServiceProvider;
use kkse\baidu_ai\kernel\providers\LogServiceProvider;
use Monolog\Logger;
use Pimple\Container;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class ServiceContainer
 * @package kkse\baidu_ai\kernel
 *
 * @property Config                          $config
 * @property Client                          $http_client
 * @property Logger                          $logger
 * @property EventDispatcher                 $events
 */
class ServiceContainer extends Container
{

    /**
     * @var array
     */
    protected $providers = [];

    /**
     * @var array
     */
    protected $defaultConfig = [];

    /**
     * @var array
     */
    protected $userConfig = [];

    /**
     * Constructor.
     *
     * @param array       $config
     */
    public function __construct(array $config = [])
    {
        $this->registerProviders($this->getProviders());

        parent::__construct();

        $this->userConfig = $config;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        $base = [
            'http' => [
                'timeout' => 30.0,
                'base_uri' => 'https://aip.baidubce.com/',
            ],
        ];

        return array_replace_recursive($base, $this->defaultConfig, $this->userConfig);
    }

    /**
     * Return all providers.
     *
     * @return array
     */
    public function getProviders()
    {
        return array_merge([
            ConfigServiceProvider::class,
            LogServiceProvider::class,
            HttpClientServiceProvider::class,
            EventDispatcherServiceProvider::class,
            AccessTokenServiceProvider::class,
        ], $this->providers);
    }

    /**
     * @param string $id
     * @param mixed  $value
     */
    public function rebind($id, $value)
    {
        $this->offsetUnset($id);
        $this->offsetSet($id, $value);
    }

    /**
     * Magic get access.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function __get($id)
    {
        return $this->offsetGet($id);
    }

    /**
     * Magic set access.
     *
     * @param string $id
     * @param mixed  $value
     */
    public function __set($id, $value)
    {
        $this->offsetSet($id, $value);
    }

    /**
     * @param array $providers
     */
    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register(new $provider());
        }
    }
}