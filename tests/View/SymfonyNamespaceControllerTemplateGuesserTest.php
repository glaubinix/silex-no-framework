<?php

namespace Glaubinix\Tests\Silex\View;

use Glaubinix\Silex\View\SymfonyNamespaceControllerTemplateGuesser;
use Glaubinix\Tests\Silex\Fixtures\Dummy;
use Glaubinix\Tests\Silex\Fixtures\DummyController;

class SymfonyNamespaceControllerTemplateGuesserTest extends \PHPUnit_Framework_TestCase
{
    /** @var SymfonyNamespaceControllerTemplateGuesser */
    private $guesser;

    protected function setUp()
    {
        $this->guesser = new SymfonyNamespaceControllerTemplateGuesser();
    }

    public function testSupportsSymfonyServiceDefinition()
    {
        $this->assertTrue($this->guesser->supports(sprintf('%s::dummyAction', DummyController::class)));
    }

    public function testSupportsDoesNotSupportClosures()
    {
        $this->assertFalse($this->guesser->supports(function () {}));
    }

    public function testGuessControllerTemplateName()
    {
        $this->assertSame('Dummy/dummy.html.twig', $this->guesser->guessControllerTemplateName(sprintf('%s::dummyAction', DummyController::class), '', 'html', 'twig'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGuessControllerTemplateNameNonController()
    {
        $this->guesser->guessControllerTemplateName(sprintf('%s::dummy', Dummy::class), '', 'html', 'twig');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGuessControllerTemplateNameUnknownService()
    {
        $this->guesser->guessControllerTemplateName('unknown::dummy', '', 'html', 'twig');
    }
}
