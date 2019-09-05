<?php


namespace kkse\baidu_ai\kernel;


class SubServiceContainer extends ServiceContainer
{
    /**
     * @var array
     */
    protected $rebinds = [
        'cache'
    ];

    public function __construct(ServiceContainer $container)
    {
        parent::__construct($container->userConfig);

        foreach ($this->rebinds as $key) {
            isset($container[$key]) and $this->rebind($key, $container[$key]);
        }
    }
}