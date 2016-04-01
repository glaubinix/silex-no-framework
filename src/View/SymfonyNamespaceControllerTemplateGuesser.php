<?php

namespace Glaubinix\Silex\View;

class SymfonyNamespaceControllerTemplateGuesser implements ChainableTemplateGuesser
{
    /**
     * {@inheritdoc}
     */
    public function supports($controller)
    {
        if (is_string($controller) && false !== strpos($controller, '::')) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function guessControllerTemplateName($controller, $actionName, $format, $engine)
    {
        list($fullClassName, $method) = explode('::', $controller, 2);

        if (!class_exists($fullClassName)) {
            throw new \InvalidArgumentException(sprintf('The "%s" class does not look like a valid controller class', $fullClassName));
        }

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
