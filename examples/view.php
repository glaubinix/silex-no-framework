<?php

require_once dirname(__DIR__) .'/vendor/autoload.php';

class ExampleController
{
    public function example()
    {
        return [
            'name' => 'example',
        ];
    }
}

$app = new \Silex\Application(['debug' => true]);
$app->register(new \Silex\Provider\TwigServiceProvider(),[
    'twig.path' => [
        __DIR__ . '/templates',
    ]
]);
$app->register(new \Glaubinix\TwigEngine\TwigEngineServiceProvider());
$app->register(new \Glaubinix\Silex\Provider\ViewProvider());

$app->get('/closure', function() {
    return [];
});

// This only works with full qualified namespaces! In this case we dont use a namespace
$app->get('/namespace', 'ExampleController::example');

// Controller as a service example
$app->register(new \Silex\Provider\ServiceControllerServiceProvider());
$app['example.controller'] = $app->share(function() {
    return new ExampleController();
});

$app->get('/service', 'example.controller:example');

$app->run();
