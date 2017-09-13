<?php

namespace Application\Mqtt;

use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Doctrine\ORM\EntityManagerInterface;
use Application\Entity\MqttEvent;

class DbEvent implements ListenerAggregateInterface
{
    private $listeners = [];
    private $entityManager;


    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach('onMessage', [$this, 'onMessage'], $priority);
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            $events->detach($listener);
            unset($this->listeners[$index]);
        }
    }

    public function onMessage(EventInterface $e)
    {
        $event = $e->getName();
        $params = $e->getParams();

        $entity = new MqttEvent;
        $entity->setDateTime(new \DateTime());
        $entity->setTopic($params->topic);
        $entity->setPayload($params->payload);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        
    }
}
