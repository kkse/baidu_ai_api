<?php
namespace kkse\baidu_ai\ocr\bankcard;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        $app['bankcard'] = function ($app) {
            return new Client($app);
        };
    }
}