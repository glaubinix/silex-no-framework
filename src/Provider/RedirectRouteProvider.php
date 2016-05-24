<?php

namespace Glaubinix\Silex\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use QafooLabs\Bundle\NoFrameworkBundle\EventListener\RedirectListener;
use Silex\Api\BootableProviderInterface;
use Silex\Application;
use Symfony\Component\HttpKernel\KernelEvents;

class RedirectRouteProvider implements ServiceProviderInterface, BootableProviderInterface
{
    public function register(Container $app)
    {
        $app['qafoo.listener.redirect'] = function (Container $app) {
            return new RedirectListener($app['url_generator']);
        };
    }

    public function boot(Application $app)
    {
        $app->on(KernelEvents::VIEW, [$app['qafoo.listener.redirect'], 'onKernelView']);
    }
}
