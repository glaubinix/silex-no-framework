<?php

namespace Glaubinix\Tests\Silex\Web;

use Glaubinix\Silex\Provider\RedirectRouteProvider;
use QafooLabs\MVC\RedirectRoute;
use Silex\Application;
use Silex\Provider\RoutingServiceProvider;
use Symfony\Component\HttpFoundation\Response;

class RedirectRouteTest extends \Silex\WebTestCase
{
    public function createApplication()
    {
        $app = new Application();
        $app->register(new RedirectRouteProvider());
        $app->register(new RoutingServiceProvider());

        return $app;
    }

    public function setUp()
    {
        parent::setUp();

        $this->app->get('/redirect', function () {
            return new RedirectRoute('dummy');
        })->bind('redirectTo');

        $this->app->get('/dummy', function () {
            return new Response();
        })->bind('dummy');
    }

    public function testRedirect()
    {
        $client = $this->createClient();
        $client->request('GET', '/redirect');

        $this->assertTrue($client->getResponse()->isRedirect());
        $this->assertSame($client->getResponse()->headers->get('location'), '/dummy');
    }
}
