<?php

namespace Glaubinix\Silex\View;

use QafooLabs\Bundle\NoFrameworkBundle\View\TemplateGuesser;

class SilexTemplateGuesser implements TemplateGuesser
{
    /**
     * Return a template reference for the given controller, format, engine
     *
     * @param string $controller
     * @param string $actionName
     * @param string $format
     * @param string $engine
     *
     * @return string
     */
    public function guessControllerTemplateName($controller, $actionName, $format, $engine)
    {
        return 'temp/temp';
    }
}
