<?php

namespace Glaubinix\Silex\Provider;

use Glaubinix\Silex\ParamConverter\SilexServiceProvider;
use QafooLabs\Bundle\NoFrameworkBundle\EventListener\ParamConverterListener;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ParamConverterProvider implements ServiceProviderInterface
{
    /**
     * @param Application $app
     */
    public function register(Application $app)
    {
        $app['glaubinix.param_converter.provider'] = $app->share(function (Application $app) {
            return new SilexServiceProvider($app);
        });

        $app['qafoo.listener.param_converter'] = $app->share(function (Application $app) {
            return new ParamConverterListener($app['glaubinix.param_converter.provider']);
        });
    }

    /**
     * @param Application $app
     */
    public function boot(Application $app)
    {
        $app->on(KernelEvents::CONTROLLER, [$app['qafoo.listener.param_converter'], 'onKernelController']);
    }
}
