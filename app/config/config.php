<?php

use Phalcon\Config;

return new Config(
    [
        'database' => [
            'adapter' => 'Mysql',
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'dbname' => 'test',
        ],
        'application' => [
            'configDir' => APP_PATH . '/config/',
            'controllersDir' => APP_PATH . '/controllers/',
            'modelsDir' => APP_PATH . '/models/',
            'viewsDir' => APP_PATH . '/views/',
            'pluginsDir' => APP_PATH . '/plugins/',
            'libraryDir' => APP_PATH . '/library/',
            'cacheDir' => APP_PATH . '/cache/',
            'baseUri' => '/',
        ]
    ]
);
