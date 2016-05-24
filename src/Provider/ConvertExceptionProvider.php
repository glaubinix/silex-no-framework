<?php

namespace Glaubinix\Silex\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use QafooLabs\Bundle\NoFrameworkBundle\EventListener\ConvertExceptionListener;
use Silex\Api\BootableProviderInterface;
use Silex\Application;
use Symfony\Component\HttpKernel\KernelEvents;

class ConvertExceptionProvider implements ServiceProviderInterface, BootableProviderInterface
{
    public function register(Container $app)
    {
        if (!isset($app['qafoo.exception_class_map'])) {
            $app['qafoo.exception_class_map'] = [];
        }

        $app['qafoo.listener.convert_exception'] = function (Container $app) {
            return new ConvertExceptionListener($app['logger'], $app['qafoo.exception_class_map']);
        };
    }

    public function boot(Application $app)
    {
        $app->on(KernelEvents::EXCEPTION, [$app['qafoo.listener.convert_exception'], 'onKernelException']);
    }
}
