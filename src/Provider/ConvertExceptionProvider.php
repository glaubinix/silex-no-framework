<?php

namespace Glaubinix\Silex\Provider;

use QafooLabs\Bundle\NoFrameworkBundle\EventListener\ConvertExceptionListener;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ConvertExceptionProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        if (!isset($app['qafoo.exception_class_map'])) {
            $app['qafoo.exception_class_map'] = [];
        }

        $app['qafoo.listener.convert_exception'] = $app->share(function (Application $app) {
            return new ConvertExceptionListener($app['logger'], $app['qafoo.exception_class_map']);
        });
    }

    public function boot(Application $app)
    {
        $app->on(KernelEvents::EXCEPTION, [$app['qafoo.listener.convert_exception'], 'onKernelException']);
    }
}
