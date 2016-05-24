<?php

namespace Glaubinix\Silex\Provider;

use Glaubinix\Silex\View\ControllerServiceTemplateGuesser;
use Glaubinix\Silex\View\SilexClosureTemplateGuesser;
use Glaubinix\Silex\View\SymfonyNamespaceControllerTemplateGuesser;
use Glaubinix\Silex\View\TemplateGuesserChain;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use QafooLabs\Bundle\NoFrameworkBundle\EventListener\ViewListener;
use Silex\Api\BootableProviderInterface;
use Silex\Application;
use Symfony\Component\HttpKernel\KernelEvents;

class ViewProvider implements ServiceProviderInterface, BootableProviderInterface
{
    public function register(Container $app)
    {
        $app['qafoo.listener.view'] = function (Container $app) {
            return new ViewListener($app['templating'], $app['glaubinix.view.template_guesser'], 'twig');
        };

        $app['glaubinix.view.template_guesser'] = function (Container $app) {
            return new TemplateGuesserChain([
                new SilexClosureTemplateGuesser(),
                new ControllerServiceTemplateGuesser($app),
                new SymfonyNamespaceControllerTemplateGuesser(),
            ]);
        };
    }

    public function boot(Application $app)
    {
        $app->on(KernelEvents::VIEW, [$app['qafoo.listener.view'], 'onKernelView']);
    }
}
