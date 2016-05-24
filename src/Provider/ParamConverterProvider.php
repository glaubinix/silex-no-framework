<?php

namespace Glaubinix\Silex\Provider;

use Glaubinix\Silex\ParamConverter\SilexServiceProvider;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use QafooLabs\Bundle\NoFrameworkBundle\EventListener\ParamConverterListener;
use Silex\Api\BootableProviderInterface;
use Silex\Application;
use Symfony\Component\HttpKernel\KernelEvents;

class ParamConverterProvider implements ServiceProviderInterface, BootableProviderInterface
{
    public function register(Container $app)
    {
        $app['glaubinix.param_converter.provider'] = function (Container $app) {
            return new SilexServiceProvider($app);
        };

        $app['qafoo.listener.param_converter'] = function (Container $app) {
            return new ParamConverterListener($app['glaubinix.param_converter.provider']);
        };
    }

    public function boot(Application $app)
    {
        $app->on(KernelEvents::CONTROLLER, [$app['qafoo.listener.param_converter'], 'onKernelController']);
    }
}
