<?php

namespace Glaubinix\Tests\Silex\Web;

use Glaubinix\Silex\Provider\ParamConverterProvider;
use QafooLabs\MVC\Flash;
use QafooLabs\MVC\FormRequest;
use QafooLabs\MVC\TokenContext;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\WebTestCase;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;

class ParamConverterTest extends WebTestCase
{
    public function createApplication()
    {
        $app = new \Silex\Application(['debug' => true]);
        $app->register(new ParamConverterProvider());
        $app->register(new SessionServiceProvider(), [
            'session.test' => true,
        ]);
        $app->register(new SecurityServiceProvider(), [
            'security.firewalls' => [
                'unsecured' => [
                    'anonymous' => true,
                ],
            ],
        ]);
        $app->register(new FormServiceProvider());

        return $app;
    }

    public function setUp()
    {
        parent::setUp();

        $this->app->get('/flash', function (Flash $flashBag) {
            $flashBag->add('error', 'flashy');

            return new Response('flash added');
        });

        $this->app->get('/security', function (TokenContext $context) {
            if ($context->hasNonAnonymousToken()) {
                $userName = $context->getCurrentUser()->getUsername();

                return new Response(sprintf('user: %s', $userName));
            } else {
                return new Response('anonymous user');
            }
        });

        $this->app->get('/form', function (FormRequest $formRequest) {
            $formRequest->handle(TextType::class);
        });
    }

    public function testFlash()
    {
        $client = $this->createClient();
        $client->request('GET', '/flash');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertSame('flash added', $client->getResponse()->getContent());
    }

    public function testSecurity()
    {
        $client = $this->createClient();
        $client->request('GET', '/security');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertSame('anonymous user', $client->getResponse()->getContent());
    }

    public function testForm()
    {
        $this->markTestSkipped('https://github.com/QafooLabs/QafooLabsNoFrameworkBundle/issues/19');
        $client = $this->createClient();
        $client->request('GET', '/form');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertSame('anonymous user', $client->getResponse()->getContent());
    }
}
