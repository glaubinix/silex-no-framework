<?php

namespace Glaubinix\Silex\View;

use QafooLabs\Bundle\NoFrameworkBundle\View\TemplateGuesser;

class TemplateGuesserChain implements TemplateGuesser
{
    /**
     * @var ChainableTemplateGuesser[]
     */
    private $templateGuesser;

    /**
     * @param ChainableTemplateGuesser[] $templateGuesser
     */
    public function __construct(array $templateGuesser)
    {
        $this->templateGuesser = $templateGuesser;
    }

    /**
     * Return a template reference for the given controller, format, engine.
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
        foreach ($this->templateGuesser as $templateGuesser) {
            if ($templateGuesser->supports($controller)) {
                return $templateGuesser->guessControllerTemplateName($controller, $actionName, $format, $engine);
            }
        }
    }
}
