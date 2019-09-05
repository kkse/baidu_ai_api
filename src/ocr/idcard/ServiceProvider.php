<?php
namespace kkse\baidu_ai\ocr\idcard;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        $app['idcard'] = function ($app) {
            return new Client($app);
        };
    }
}