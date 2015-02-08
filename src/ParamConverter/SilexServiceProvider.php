<?php

namespace Glaubinix\Silex\ParamConverter;

use QafooLabs\Bundle\NoFrameworkBundle\ParamConverter\ServiceProviderInterface;
use Silex\Application;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SilexServiceProvider implements ServiceProviderInterface
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @return FormFactoryInterface
     */
    public function getFormFactory()
    {
        return $this->app['form.factory'];
    }

    /**
     * @return SecurityContextInterface
     */
    public function getSecurityContext()
    {
        return $this->app['security'];
    }
}
