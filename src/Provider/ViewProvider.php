<?php

namespace Glaubinix\Silex\Provider;

use Glaubinix\Silex\View\ControllerServiceTemplateGuesser;
use Glaubinix\Silex\View\SilexClosureTemplateGuesser;
use Glaubinix\Silex\View\SymfonyNamespaceControllerTemplateGuesser;
use Glaubinix\Silex\View\TemplateGuesserChain;
use QafooLabs\Bundle\NoFrameworkBundle\EventListener\ViewListener;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ViewProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['qafoo.listener.view'] = $app->share(function (Application $app) {
            return new ViewListener($app['templating'], $app['glaubinix.view.template_guesser'], 'twig');
        });

        $app['glaubinix.view.template_guesser'] = $app->share(function (Application $app) {
            return new TemplateGuesserChain([
                new SilexClosureTemplateGuesser(),
                new ControllerServiceTemplateGuesser($app),
                new SymfonyNamespaceControllerTemplateGuesser(),
            ]);
        });
    }

    public function boot(Application $app)
    {
        $app->on(KernelEvents::VIEW, [$app['qafoo.listener.view'], 'onKernelView']);
    }
}
