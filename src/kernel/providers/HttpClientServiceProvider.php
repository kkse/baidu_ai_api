<?php

namespace kkse\baidu_ai\kernel\providers;

use GuzzleHttp\Client;
use kkse\baidu_ai\kernel\ServiceContainer;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class HttpClientServiceProvider.
 */
class HttpClientServiceProvider implements ServiceProviderInterface
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
        $pimple['http_client'] = function (ServiceContainer $app) {
            return new Client($app->config->get('http', []));
        };
    }
}
