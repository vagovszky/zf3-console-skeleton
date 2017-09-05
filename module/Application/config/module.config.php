<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zend\Log\Logger;

return [

    'controllers' => [
        'factories' => [
            Controller\ServerController::class => Controller\Factory\ServerControllerFactory::class,
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
    'console' => [
        'router' => [
            'routes' => [
                'listen' => [
                    'type'    => 'simple',
                    'options' => [
                        'route'    => 'listen',
                        'defaults' => [
                            'controller' => Controller\ServerController::class,
                            'action'     => 'listen',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'factories' => [
            Service\MqttListener::class => Factory\MqttListenerFactory::class,
            'MqttClient' => Factory\MqttClientFactory::class
        ],
        'aliases' => [
            'MqttListener' => Service\MqttListener::class
        ],
    ],
    'log' => [
        'logger' => [
            'writers' => [
                [
                    'name' => 'stream',
                    'priority' => Logger::DEBUG,
                    'options' => [
                        'stream' => 'php://output',
                    ],
                ],
            ],
        ],
    ],
];
