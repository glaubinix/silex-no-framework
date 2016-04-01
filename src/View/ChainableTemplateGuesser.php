<?php

namespace Glaubinix\Silex\View;

use QafooLabs\Bundle\NoFrameworkBundle\View\TemplateGuesser;

interface ChainableTemplateGuesser extends TemplateGuesser
{
    /**
     * @param mixed $controller
     *
     * @return bool
     */
    public function supports($controller);
}
