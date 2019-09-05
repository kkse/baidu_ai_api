<?php
namespace kkse\baidu_ai\ocr\business_license;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        $app['business_license'] = function ($app) {
            return new Client($app);
        };
    }
}