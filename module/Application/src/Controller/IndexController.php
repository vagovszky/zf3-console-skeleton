<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Adapter\AdapterInterface as Console;

class IndexController extends AbstractActionController
{

    private $console;

    public function __construct(Console $console)
    {
        $this->console = $console;
    }

    private function getConsole()
    {
        return $this->console;
    }

    public function testAction()
    {
        $this->getConsole()->writeLine("Hello world from console");
    }
}
