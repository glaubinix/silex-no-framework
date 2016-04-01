<?php

namespace Glaubinix\Silex\View;

class SilexClosureTemplateGuesser implements ChainableTemplateGuesser
{
    /**
     * {@inheritdoc}
     */
    public function supports($controller)
    {
        if (is_object($controller) && ($controller instanceof \Closure)) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function guessControllerTemplateName($controller, $actionName, $format, $engine)
    {
        // There is currently no way to resolve a closure without adding a lot of constraints to the user
        throw new \InvalidArgumentException('Cannot guess template for closure!');
    }
}
