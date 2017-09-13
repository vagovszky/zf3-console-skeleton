<?php

namespace Application\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Mqtt\DbEvent;

class DbEventFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $eventManager = $container->get('MqttListener')->getEventManager();

        $listener = new DbEvent($entityManager);
        $listener->attach($eventManager);


        return $listener;
    }
}
