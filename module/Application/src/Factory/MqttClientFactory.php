<?php

namespace Application\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Mosquitto\Client;

class MqttClientFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $configuration = $container->get('Config');
        $client = new Client($configuration['mqtt']['name']);
        $client->setCredentials($configuration['mqtt']['username'], $configuration['mqtt']['password']);
        $client->connect($configuration['mqtt']['host'], $configuration['mqtt']['port'], 60);
        return $client;
    }
}