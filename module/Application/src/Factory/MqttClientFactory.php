<?php

namespace Application\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Mosquitto\Client;

class MqttClientFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $configuration = $container->get('configuration');
        $client = new Client($configuration['mqtt']['name']);
        $client->setCredentials($configuration['mqtt']['username'], $configuration['mqtt']['password']);
        return $client;
    }
}