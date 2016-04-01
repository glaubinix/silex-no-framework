<?php

namespace Glaubinix\Tests\Silex\View;

use Glaubinix\Silex\View\ControllerServiceTemplateGuesser;
use Glaubinix\Tests\Silex\Fixtures\Dummy;
use Glaubinix\Tests\Silex\Fixtures\DummyController;
use Silex\Application;

class ControllerServiceTemplateGuesserTest extends \PHPUnit_Framework_TestCase
{
    /** @var ControllerServiceTemplateGuesser */
    private $guesser;

    protected function setUp()
    {
        $this->guesser = new ControllerServiceTemplateGuesser(new Application([
            'controller' => new DummyController(),
            'service' => new Dummy(),
        ]));
    }

    public function testSupportsSilexServiceDefinition()
    {
        $this->assertTrue($this->guesser->supports('controller:name'));
    }

    public function testSupportsDoesNotSupportClosures()
    {
        $this->assertFalse($this->guesser->supports(function () {}));
    }

    public function testSupportsDoesNotSupportSymfonyServiceDefinition()
    {
        $this->assertFalse($this->guesser->supports('controller::name'));
    }

    public function testGuessControllerTemplateName()
    {
        $this->assertSame('Dummy/dummy.html.twig', $this->guesser->guessControllerTemplateName('controller:dummy', '', 'html', 'twig'));
    }

    public function testGuessControllerTemplateNameControllerAction()
    {
        $this->assertSame('Dummy/other.html.twig', $this->guesser->guessControllerTemplateName('controller:dummy', 'otherAction', 'html', 'twig'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGuessControllerTemplateNameNonController()
    {
        $this->guesser->guessControllerTemplateName('service:dummy', '', 'html', 'twig');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGuessControllerTemplateNameUnknownService()
    {
        $this->guesser->guessControllerTemplateName('unknown:dummy', '', 'html', 'twig');
    }
}
