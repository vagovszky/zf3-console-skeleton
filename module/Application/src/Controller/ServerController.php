<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Adapter\AdapterInterface as Console;
use Application\Service\MqttListener;

class ServerController extends AbstractActionController
{

    private $console;
    private $mqttListener;

    public function __construct(Console $console, MqttListener $mqttListener)
    {
        $this->console = $console;
        $this->mqttListener = $mqttListener;
    }

    private function getConsole()
    {
        return $this->console;
    }

    public function listenAction()
    {
        $this->getConsole()->writeLine("Starting MQTT listener...");
        $this->mqttListener->listen();
    }
}
