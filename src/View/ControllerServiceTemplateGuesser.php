<?php

namespace Glaubinix\Silex\View;

use Pimple\Container;

class ControllerServiceTemplateGuesser implements ChainableTemplateGuesser
{
    /** @var Container */
    private $app;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($controller)
    {
        if (is_string($controller) && false === strpos($controller, '::') && false !== strpos($controller, ':')) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function guessControllerTemplateName($controller, $actionName, $format, $engine)
    {
        list($serviceAlias, $method) = explode(':', $controller, 2);
        $fullClassName = get_class($this->app[$serviceAlias]);

        $reflection = new \ReflectionClass($fullClassName);
        $className = $reflection->getShortName();
        $method = $actionName ? $actionName : $method;

        if (!preg_match('/((.)+)Controller$/', $className, $matchController)) {
            throw new \InvalidArgumentException(sprintf('The "%s" class does not look like a controller class (the class name must end with "Controller")', $className));
        }

        if (preg_match('/^(.+)Action$/', $method, $matchAction)) {
            $method = $matchAction[1];
        }

        return sprintf('%s/%s.%s.%s', $matchController[1], $method, $format, $engine);
    }
}
