<?php

namespace kkse\baidu_ai\kernel\events;

use kkse\baidu_ai\kernel\ServiceContainer;

/**
 * Class ApplicationInitialized.
 */
class ApplicationInitialized
{
    /**
     * @var ServiceContainer
     */
    public $app;

    /**
     * @param ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }
}
