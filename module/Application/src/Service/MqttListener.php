<?php

namespace Application\Service;

use Mosquitto\Client;

use Zend\Log\LoggerAwareInterface;
use Zend\Log\LoggerInterface;
use Zend\Log\Logger;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;

class MqttListener implements LoggerAwareInterface, EventManagerAwareInterface
{


    private $mqttClient;
    private $topics = [];

    /**
     * @var LoggerInterface
     */
    private $logger;

    protected $eventManager;

    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers([
            __CLASS__,
            get_called_class(),
        ]);
        $this->eventManager = $eventManager;
        return $this;
    }

    public function getEventManager()
    {
        if (null === $this->eventManager) {
            $this->setEventManager(new EventManager());
        }
        return $this->eventManager;
    }

    public function __construct(Client $mqttClient)
    {
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

        $this->getEventManager()->trigger(__FUNCTION__, $this, $message);
    }

    public function listen()
    {
        $this->logger->log(Logger::INFO, "Starting MQTT listener...");
        $this->mqttClient->loopForever();
    }

}
