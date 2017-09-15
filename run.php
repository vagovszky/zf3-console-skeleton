<?php
use Zend\Mvc\Application;

include __DIR__ . '/vendor/autoload.php';

if (! class_exists(Application::class)) {
    throw new RuntimeException("Unable to load application.\n");
}

$appConfig = [
    'modules' => [
        'Zend\Log',
        'Zend\Mvc\Console',
        //'Zend\Cache',
        //'Zend\Form',
        //'Zend\InputFilter',
        //'Zend\Filter',
        //'Zend\Paginator',
        //'Zend\Hydrator',
        'Zend\Router',
        //'Zend\Validator',
        'DoctrineModule',
        'DoctrineORMModule',
        'Application',
    ],
    'module_listener_options' => [
        'module_paths' => [
            './module',
            './vendor',
        ],
    ],
];
Application::init($appConfig)->run();