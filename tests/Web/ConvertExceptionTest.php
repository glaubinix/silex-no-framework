<?php

namespace Glaubinix\Tests\Silex\Web;

use Glaubinix\Silex\Provider\ConvertExceptionProvider;
use Glaubinix\Tests\Silex\Fixtures\IAmATeaPodException;
use Silex\Application;
use Silex\WebTestCase;

class ConvertExceptionTest extends WebTestCase
{
    public function createApplication()
    {
        $app = new Application();
        $app->register(new ConvertExceptionProvider(), [
            'qafoo.exception_class_map' => [
                IAmATeaPodException::class => 419,
            ],
        ]);

        return $app;
    }

    public function setUp()
    {
        parent::setUp();

        $this->app->get('/exception', function () {
            throw new IAmATeaPodException();
        })->bind('exception');
    }

    public function testConvert()
    {
        $client = $this->createClient();
        $client->request('GET', '/exception');

        $this->assertSame(419, $client->getResponse()->getStatusCode());
    }
}
