<?php
use Zend\Mvc\Application;

include __DIR__ . '/vendor/autoload.php';

if (! class_exists(Application::class)) {
    throw new RuntimeException("Unable to load application.\n");
}

$appConfig = require __DIR__ . '/config/application.config.php';
Application::init($appConfig)->run();