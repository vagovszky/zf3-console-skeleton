<?php

namespace Application\Service;

use Doctrine\ORM\EntityManagerInterface;
use Application\Entity\MqttEvent;
use Mosquitto\Client;

use Zend\Log\LoggerAwareInterface;
use Zend\Log\LoggerInterface;
use Zend\Log\Logger;

class MqttListener implements LoggerAwareInterface
{

    private $em;
    private $mqttClient;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(EntityManagerInterface $em, Client $mqttClient)
    {
        $this->em = $em;
        $this->mqttClient = $mqttClient;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        return $this;
    }


    private function onMessage($message)
    {
        $this->logger->log(Logger::INFO, "Topic: " . $message->topic . ", payload: " . $message->payload);

        $entity = new MqttEvent;
        $entity->setDateTime(new \DateTime());
        $entity->setTopic($message->topic);
        $entity->setPayload($message->payload);

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function listen()
    {
        $this->logger->log(Logger::INFO, "Starting listener...");
        $this->mqttClient->loop();
        $this->logger->log(Logger::INFO, "Setting callback...");
        $this->mqttClient->onMessage(function ($message) {
            $this->onMessage($message);
        });
        $this->mqttClient->loop();
        $this->logger->log(Logger::INFO, "Subscribing All...");
        $this->mqttClient->subscribe('#', 0);
        $this->logger->log(Logger::INFO, "Looping forever...");
        $this->mqttClient->loopForever();
    }


}
