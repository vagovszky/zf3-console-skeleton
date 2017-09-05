<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;


class Module implements ConsoleBannerProviderInterface, ConsoleUsageProviderInterface
{
    const VERSION = '0.0.1';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getConsoleBanner(Console $console)
    {
        return "Version: " . self::VERSION;
    }

    public function getConsoleUsage(Console $console)
    {
        return [
            'listen' => 'Listen on MQTT events and write them to log',
        ];
    }
}
