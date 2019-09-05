<?php


namespace kkse\baidu_ai\kernel\providers;


use kkse\baidu_ai\kernel\Config;
use kkse\baidu_ai\kernel\ServiceContainer;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ConfigServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        $pimple['config'] = function (ServiceContainer $app) {
            return new Config($app->getConfig());
        };
    }
}