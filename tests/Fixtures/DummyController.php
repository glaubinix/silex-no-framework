<?php

namespace Glaubinix\Tests\Silex\Fixtures;

class DummyController
{
    public function dummyAction()
    {
        return [
            'name' => 'dummy',
        ];
    }
}
