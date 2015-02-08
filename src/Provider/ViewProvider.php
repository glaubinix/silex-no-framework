<?php

namespace Glaubinix\Silex\Provider;

use Glaubinix\Silex\View\ControllerServiceTemplateGuesser;
use Glaubinix\Silex\View\SilexClosureTemplateGuesser;
use Glaubinix\Silex\View\SilexTemplateGuesser;
use Glaubinix\Silex\View\SymfonyNamespaceControllerTemplateGuesser;
use Glaubinix\Silex\View\TemplateGuesserChain;
use QafooLabs\Bundle\NoFrameworkBundle\Controller\QafooControllerNameParser;
use QafooLabs\Bundle\NoFrameworkBundle\EventListener\ViewListener;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Templating\TemplateNameParser;

class ViewProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['qafoo.listener.view'] = $app->share(function(Application $app) {
            return new ViewListener($app['templating'], $app['glaubinix.view.template_guesser'], 'twig');
        });

        $app['glaubinix.view.template_guesser'] = $app->share(function(Application $app) {
            return new TemplateGuesserChain([
                new SilexClosureTemplateGuesser(),
                new ControllerServiceTemplateGuesser($app),
                new SymfonyNamespaceControllerTemplateGuesser(),
            ]);
        });

        $app['silex.twig.template_name_parser'] = $app->share(function() {
            return new TemplateNameParser();
        });

        $app['templating'] = $app->share(function (Application $app) {
            return new TwigEngine($app['twig'], $app['silex.twig.template_name_parser']);
        });
    }

    public function boot(Application $app)
    {
        $app->on(KernelEvents::VIEW, [$app['qafoo.listener.view'], 'onKernelView']);
    }
}
