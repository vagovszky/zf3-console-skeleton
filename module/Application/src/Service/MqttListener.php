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
    private $topics = [];

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(EntityManagerInterface $em, Client $mqttClient)
    {
        $this->em = $em;
        $this->mqttClient = $mqttClient;

        $this->mqttClient->onConnect([$this, 'onConnect']);
        $this->mqttClient->onMessage([$this, 'onMessage']);
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    public function setTopics(array $topics)
    {
        $this->topics = $topics;
    }

    public function onConnect(){

        $this->logger->log(Logger::INFO, "Connected to MQTT client...");

        foreach ($this->topics as $topic => $qos) {

            $this->logger->log(Logger::INFO, "Subscribing to - " . $topic);

            $this->mqttClient->subscribe($topic, $qos);
        }
    }

    public function onMessage($message)
    {
        $this->logger->log(Logger::INFO, "Message received - topic: " . $message->topic . ", payload: " . $message->payload);

        $entity = new MqttEvent;
        $entity->setDateTime(new \DateTime());
        $entity->setTopic($message->topic);
        $entity->setPayload($message->payload);

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function listen()
    {
        $this->logger->log(Logger::INFO, "Starting MQTT listener...");
        $this->mqttClient->loopForever();
    }

}
