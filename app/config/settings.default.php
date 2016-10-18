<?php

use Propel\Runtime\Connection\DebugPDO;

return [
    'propel' => [
        'database' => [
            'connections' => [
                'default' => [
                    'adapter'    => 'mysql',
                    'classname'  => DebugPDO::class,
                    'dsn'        => 'mysql:host=localhost;dbname=taisiya',
                    'user'       => 'root',
                    'password'   => 'root',
                    'attributes' => [],
                ],
            ],
        ],
        'runtime' => [
            'defaultConnection' => 'default',
            'connections'       => ['default'],
        ],
        'generator' => [
            'defaultConnection' => 'default',
            'connections'       => ['default'],
        ],
    ],
];
