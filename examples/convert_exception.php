<?php

require_once dirname(__DIR__) .'/vendor/autoload.php';

class IAmATeaPodException extends \Exception {}
class UnderConstructionException extends \Exception {}

$app = new \Silex\Application(['debug' => true]);

$app->register(new \Glaubinix\Silex\Provider\ConvertExceptionProvider(),
    [
        'qafoo.exception_class_map' => [
            'IAmATeaPodException' => '419',
            'UnderConstructionException' => \InvalidArgumentException::class,
        ],
    ]
);

$app->get('/', function() {
    throw new UnderConstructionException();
});

// accessing /teapod will return 419 status code
$app->get('/teapod', function() {
    throw new IAmATeaPodException();
});

$app->run();
