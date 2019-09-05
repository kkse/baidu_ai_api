<?php
namespace kkse\baidu_ai\ocr;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['ocr'] = function ($app) {
            return new Application($app);
        };
    }
}