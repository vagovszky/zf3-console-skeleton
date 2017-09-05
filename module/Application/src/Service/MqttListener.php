<?php

namespace Application\Service;

use Doctrine\ORM\EntityManagerInterface;
use Application\Entity\MqttEvent;
use Mosquitto\Client;

use Zend\Log\LoggerAwareInterface;
use Zend\Log\LoggerInterface;
use Zend\Log\Logger;

class MqttListener implements LoggerAwareInterface{

    private $em;
    private $mqttClient;
    private $mqttConfiguration;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(EntityManagerInterface $em, Client $mqttClient)
    {
        $this->em = $em;
        $this->mqttClient = $mqttClient;
    }

    public function setLogger(LoggerInterface $logger){
        $this->logger = $logger;
        return $this;
    }

    public function setMqttConfiguration($mqttConfiguration){
        $this->mqttConfiguration = $mqttConfiguration;
        return $this;
    }

    private function onMessage($message){
        $this->logger->log(Logger::INFO, "Message received...");
    }

    public function listen(){
        $this->logger->log(Logger::INFO, "Starting listener...");
        $this->logger->log(Logger::INFO, "Connecting...");
        $this->mqttClient->connect($this->mqttConfiguration['host'], $this->mqttConfiguration['port'], 60);
        $this->mqttClient->loop();
        $this->logger->log(Logger::INFO, "Setting callback...");
        $this->mqttClient->onMessage(array($this, "onMessage"));
        $this->mqttClient->loop();
        $this->logger->log(Logger::INFO, "Subscribing All...");
        $this->mqttClient->subscribe('#', 0);
        $this->logger->log(Logger::INFO, "Looping forever...");
        $this->mqttClient->loopForever();
    }



}