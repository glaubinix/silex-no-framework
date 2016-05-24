<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

$app = new \Silex\Application(['debug' => true]);

$app->register(new \Silex\Provider\RoutingServiceProvider());
$app->register(new \Glaubinix\Silex\Provider\RedirectRouteProvider());

$app->get('/', function () {
    return new \QafooLabs\MVC\RedirectRoute('redirected');
});

$app->get('/redirected', function () {
    return 'redirected';
})->bind('redirected');

$app->run();
