<?php
// Configuration for doctrine
use Doctrine\DBAL\Driver\PDOPgSql\Driver as PDOPgSqlDriver;
return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => PDOPgSqlDriver::class,
                'params' => array(
                    'host'     => 'localhost',
                    'port'     => '5432',
                    'user'     => 'test',
                    'password' => 'test',
                    'dbname'   => 'test',
                ),
            ],
        ],
    ],
    'mqtt' => [
        'name' => 'PHP-client',
        'host' => 'localhost',
        'username' => 'martin',
        'password' => 'mojetajneheslo',
        'port' => 1883,
        'topics' => [
            '#' => 0
        ]
    ]
];