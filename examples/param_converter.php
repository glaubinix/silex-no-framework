<?php

require_once dirname(__DIR__) .'/vendor/autoload.php';

$app = new \Silex\Application(['debug' => true]);

$app->register(new \Glaubinix\Silex\Provider\ParamConverterProvider());

// Flash example
$app->register(new \Silex\Provider\SessionServiceProvider());
$app->get('/flash', function(\QafooLabs\MVC\Flash $flashBag) {
    $flashBag->add('error', 'flashy');

    return new \Symfony\Component\HttpFoundation\Response('flash added');
});

// Token context example
$app->register(new \Silex\Provider\SecurityServiceProvider(),
    [
        'security.firewalls' => [
            'unsecured' => [
                'anonymous' => true,
            ]
        ]
    ]
);

$app->get('/security', function(\QafooLabs\MVC\TokenContext $context) {
    if ($context->hasNonAnonymousToken()) {
        $userName = $context->getCurrentUser()->getUsername();
        return new \Symfony\Component\HttpFoundation\Response(sprintf('user: %s', $userName));
    } else {
        return new \Symfony\Component\HttpFoundation\Response('anonymous user');
    }
});

// FormRequest example (will throw an exception because no form is defined)
$app->register(new \Silex\Provider\FormServiceProvider());
$app->get('/form', function(\QafooLabs\MVC\FormRequest $formRequest) {
    $formRequest->handle('dummyform');
});

$app->run();
