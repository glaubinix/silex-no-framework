<?php

namespace Glaubinix\Silex\View;

use Silex\Application;

class ControllerServiceTemplateGuesser implements ChainableTemplateGuesser
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
     * {@inheritDoc}
     */
    public function supports($controller)
    {
        if (false === strpos($controller, '::') && false !== strpos($controller, ':')) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function guessControllerTemplateName($controller, $actionName, $format, $engine)
    {
        list($serviceAlias, $method) = explode(':', $controller, 2);
        $fullClassName =  get_class($this->app[$serviceAlias]);

        $reflection = new \ReflectionClass($fullClassName);
        $className = $reflection->getShortName();

        if (!preg_match('/((.)+)Controller$/', $className, $matchController)) {
            throw new \InvalidArgumentException(sprintf('The "%s" class does not look like a controller class (the class name must end with "Controller")', $className));
        }

        if (preg_match('/^(.+)Action$/', $method, $matchAction)) {
            $method = $matchAction[1];
        }

        return sprintf('%s/%s.%s.%s', $matchController[1], $method, $format, $engine);
    }
}
