<?php
namespace kkse\baidu_ai\kernel\providers;

use kkse\baidu_ai\kernel\LogManager;
use kkse\baidu_ai\kernel\ServiceContainer;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class LoggingServiceProvider.
 *
 * @author overtrue <i@overtrue.me>
 */
class LogServiceProvider implements ServiceProviderInterface
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
        $pimple['logger'] = $pimple['log'] = function (ServiceContainer $app) {
            $config = $this->formatLogConfig($app);

            if (!empty($config)) {
                $app->rebind('config', $app['config']->merge($config));
            }

            return new LogManager($app);
        };
    }

    public function formatLogConfig(ServiceContainer $app)
    {
        if (!empty($app->config->get('log.channels'))) {
            return $app->config->get('log');
        }

        if (empty($app->config->get('log'))) {
            return [
                'log' => [
                    'default' => 'errorlog',
                    'channels' => [
                        'errorlog' => [
                            'driver' => 'errorlog',
                            'level' => 'debug',
                        ],
                    ],
                ],
            ];
        }

        return [
            'log' => [
                'default' => 'single',
                'channels' => [
                    'single' => [
                        'driver' => 'single',
                        'path' => $app->config->get('log.file') ?: sys_get_temp_dir().'/logs/baidu_ai.log',
                        'level' => $app->config->get('log.level', 'debug'),
                    ],
                ],
            ],
        ];
    }
}
