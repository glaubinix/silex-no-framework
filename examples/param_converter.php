<?php

require_once './../vendor/autoload.php';

$app = new \Silex\Application(['debug' => true]);

$app->register(new \Glaubinix\Silex\Provider\ParamConverterProvider());

// Flash example
$app->register(new \Silex\Provider\SessionServiceProvider());
$app->get('/flash', function(\QafooLabs\MVC\Flash $flashBag) {
    $flashBag->add('error', 'flashy');

    return new \Symfony\Component\HttpFoundation\Response('flash added');
});

$app->run();
