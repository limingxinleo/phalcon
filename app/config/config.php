<?php

use Phalcon\Config;

return new Config(
    [
        'database' => [
            'adapter' => 'Mysql',
            'host' => 'localhost',
            'username' => 'root',
            'password' => '910123',
            'dbname' => 'laravel',
        ],
        'application' => [
            'configDir' => __DIR__,
            'controllersDir' => __DIR__ . '/../controllers/',
            'modelsDir' => __DIR__ . '/../models/',
            'viewsDir' => __DIR__ . '/../views/',
            'pluginsDir' => __DIR__ . '/../plugins/',
            'libraryDir' => __DIR__ . '/../library/',
            'cacheDir' => __DIR__ . '/../cache/',
            'baseUri' => '/',
        ]
    ]
);
