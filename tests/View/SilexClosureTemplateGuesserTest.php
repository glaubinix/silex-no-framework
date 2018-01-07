<?php

namespace Glaubinix\Tests\Silex\View;

use Glaubinix\Silex\View\SilexClosureTemplateGuesser;
use PHPUnit\Framework\TestCase;

class SilexClosureTemplateGuesserTest extends TestCase
{
    /** @var SilexClosureTemplateGuesser */
    private $guesser;

    protected function setUp()
    {
        $this->guesser = new SilexClosureTemplateGuesser();
    }

    public function testSupportsClosure()
    {
        $this->assertTrue($this->guesser->supports(function () {
        }));
    }

    public function testSupportsDoesNotSupportServiceMethodDefinition()
    {
        $this->assertFalse($this->guesser->supports('service::method'));
        $this->assertFalse($this->guesser->supports('service:method'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGuessControllerTemplateName()
    {
        $this->guesser->guessControllerTemplateName('', '', '', '');
    }
}
