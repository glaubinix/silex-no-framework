<?php

namespace Glaubinix\Silex\ParamConverter;

use QafooLabs\Bundle\NoFrameworkBundle\ParamConverter\ServiceProviderInterface;
use Silex\Application;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SilexServiceProvider implements ServiceProviderInterface
{
    /**
     * @var Application
     */
    private $app;

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
     * @return TokenStorageInterface
     */
    public function getTokenStorage()
    {
        return $this->app['security.token_storage'];
    }

    /**
     * @return AuthorizationCheckerInterface
     */
    public function getAuthorizationChecker()
    {
        return $this->app['security.authorization_checker'];
    }
}
