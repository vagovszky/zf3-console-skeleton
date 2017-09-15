<?php

namespace Application\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Mqtt\MessageListener;

class MessageListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $eventManager = $container->get('MqttListener')->getEventManager();
        $logger = $container->get('logger');

        $listener = new MessageListener($entityManager);

        $listener->attach($eventManager);
        $listener->setLogger($logger);

        return $listener;
    }
}
