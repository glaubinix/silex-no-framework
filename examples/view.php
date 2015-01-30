<?php

require_once './../vendor/autoload.php';

$app = new \Silex\Application(['debug' => true]);

$app->register(new \Silex\Provider\TwigServiceProvider());
$app->register(new \Glaubinix\Silex\Provider\ViewProvider());

$app->get('/', function() {
    return [];
});

$app->run();
