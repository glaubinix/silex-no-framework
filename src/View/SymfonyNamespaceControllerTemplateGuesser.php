<?php

namespace Glaubinix\Silex\View;

class SymfonyNamespaceControllerTemplateGuesser implements ChainableTemplateGuesser
{
    /**
     * {@inheritDoc}
     */
    public function supports($controller)
    {
        if (false !== strpos($controller, '::')) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function guessControllerTemplateName($controller, $actionName, $format, $engine)
    {
        list($fullClassName, $method) = explode('::', $controller, 2);

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
