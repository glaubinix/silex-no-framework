<?php

namespace Glaubinix\Tests\Silex\Web;

use Glaubinix\Silex\Provider\ViewProvider;
use Glaubinix\Tests\Silex\Fixtures\DummyController;
use Glaubinix\TwigEngine\TwigEngineServiceProvider;
use Silex\Application;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\WebTestCase;

class ViewTest extends WebTestCase
{
    public function createApplication()
    {
        $app = new Application();
        $app->register(new TwigServiceProvider(), [
            'twig.path' => [
                dirname(__DIR__).'/Fixtures/templates',
            ],
        ]);
        $app->register(new TwigEngineServiceProvider());
        $app->register(new ViewProvider());
        $app->register(new ServiceControllerServiceProvider());
        $app['dummy.controller'] = $app->share(function () {
            return new DummyController();
        });

        return $app;
    }

    public function setUp()
    {
        parent::setUp();

        $this->app->get('/closure', function () {
            return [];
        });

        // This only works with full qualified namespaces! In this case we dont use a namespace
        $this->app->get('/namespace', sprintf('%s::dummyAction', DummyController::class));
        $this->app->get('/service', 'dummy.controller:dummyAction');
    }

    public function testClosure()
    {
        $client = $this->createClient();
        $client->request('GET', '/closure');

        $this->assertFalse($client->getResponse()->isSuccessful());
    }

    public function testNamespace()
    {
        $client = $this->createClient();
        $client->request('GET', '/namespace');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertSame("Hello \"dummy\"\n", $client->getResponse()->getContent());
    }

    public function testService()
    {
        $client = $this->createClient();
        $client->request('GET', '/service');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertSame("Hello \"dummy\"\n", $client->getResponse()->getContent());
    }
}
