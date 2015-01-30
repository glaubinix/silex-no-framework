<?php

namespace Glaubinix\Silex\Provider;

use Glaubinix\Silex\View\SilexTemplateGuesser;
use QafooLabs\Bundle\NoFrameworkBundle\EventListener\ParamConverterListener;
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
            return new ViewListener($app['twig'], $app['glaubinix.view.template_guesser'], 'twig');
        });

        $app['glaubinix.view.template_guesser'] = $app->share(function(Application $app) {
            return new SilexTemplateGuesser();
        });

        $app['silex.twig.template_name_parser'] = $app->share(function() {
            return new TemplateNameParser();
        });

        $app->extend('twig', function($twig, Application $app) {
            return new TwigEngine($twig, $app['silex.twig.template_name_parser']);
        });
    }

    public function boot(Application $app)
    {
        $app->on(KernelEvents::VIEW, [$app['qafoo.listener.view'], 'onKernelView']);
    }
}
