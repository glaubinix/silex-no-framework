<?php

namespace Glaubinix\Silex\Provider;

use QafooLabs\Bundle\NoFrameworkBundle\EventListener\RedirectListener;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class RedirectRouteProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['qafoo.listener.redirect'] = $app->share(function(Application $app) {
            return new RedirectListener($app['url_generator']);
        });
    }

    public function boot(Application $app)
    {
        $app->on(KernelEvents::VIEW, [$app['qafoo.listener.redirect'], 'onKernelView']);
    }
}
