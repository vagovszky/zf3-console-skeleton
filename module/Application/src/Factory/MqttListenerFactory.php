<?php

namespace Application\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Service\MqttListener;

class MqttListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $logger = $container->get('logger');
        $client = $container->get('MqttClient');

        $listener = new MqttListener($entityManager, $client);

        return $listener->setLogger($logger);
    }
}