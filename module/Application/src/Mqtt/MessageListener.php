<?php

namespace Application\Mqtt;

use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Doctrine\ORM\EntityManagerInterface;
use Application\Entity\MqttEvent;
use Zend\Log\LoggerAwareInterface;
use Zend\Log\LoggerInterface;
use Zend\Log\Logger;

class MessageListener implements ListenerAggregateInterface, LoggerAwareInterface
{
    private $listeners = [];
    private $entityManager;
    private $logger;

    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach('onMessage', [$this, 'saveToDb'], $priority);
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            $events->detach($listener);
            unset($this->listeners[$index]);
        }
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    public function saveToDb(EventInterface $e)
    {
        //$event = $e->getName();
        $params = $e->getParams();

        $entity = new MqttEvent;
        $entity->setDateTime(new \DateTime());
        $entity->setTopic($params->topic);
        $entity->setPayload($params->payload);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        $this->logger->log(Logger::INFO, "MQTT Message successfully saved to the database: " . $params->topic . ", payload: " . $params->payload);
    }
}
