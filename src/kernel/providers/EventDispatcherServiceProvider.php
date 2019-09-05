<?php

namespace kkse\baidu_ai\kernel\providers;

use kkse\baidu_ai\kernel\ServiceContainer;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class EventDispatcherServiceProvider.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class EventDispatcherServiceProvider implements ServiceProviderInterface
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
        $pimple['events'] = function (ServiceContainer $app) {
            $dispatcher = new EventDispatcher();

            foreach ($app->config->get('events.listen', []) as $event => $listeners) {
                foreach ($listeners as $listener) {
                    $dispatcher->addListener($event, $listener);
                }
            }

            return $dispatcher;
        };
    }
}
