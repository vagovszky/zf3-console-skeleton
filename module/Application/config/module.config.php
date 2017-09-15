<?php
namespace Application;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zend\Log\Logger;

return [
    'controllers' => [
        'factories' => [
            Controller\ServerController::class => Factory\ServerControllerFactory::class,
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
            'MqttListener' => Factory\MqttListenerFactory::class,
            'MqttClient' => Factory\MqttClientFactory::class,
            'MessageListener' => Factory\MessageListenerFactory::class,
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
    'listeners' => [
        'MessageListener'
    ]
];
