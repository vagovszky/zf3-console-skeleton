<?php
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
];