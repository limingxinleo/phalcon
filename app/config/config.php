<?php
/*
 * Modified: preppend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

use Phalcon\Config;

return new Config(
    [
        /*
        |--------------------------------------------------------------------------
        | Version Environment
        |--------------------------------------------------------------------------
        |
        | This value is version for this project.
        |
        */
        'version' => '1.0.11',

        /*
        |--------------------------------------------------------------------------
        | Domain Environment
        |--------------------------------------------------------------------------
        |
        | This value is the base url for app. When you need a wx redirecturl, but
        | you have many applications, you can set this value is "http://wx.xxx.com/phal/"
        | then set nginx proxy to this application.
        |
        */
        'domain' => 'localhost',

        /*
        |--------------------------------------------------------------------------
        | Database Environment
        |--------------------------------------------------------------------------
        |
        | This value determines the "environment" your database.
        |
        */
        'database' => [
            'adapter' => 'Mysql',
            'host' => 'localhost',
            'username' => 'root',
            'password' => '910123',
            'dbname' => 'laravel',
        ],

        /*
        |--------------------------------------------------------------------------
        | Application Environment
        |--------------------------------------------------------------------------
        |
        | This value determines the "environment" your application is currently
        | running in. This may determine how you prefer to configure various
        | services your application utilizes.
        |
        */
        'application' => [
            'configDir' => APP_PATH . '/config/',
            'controllersDir' => APP_PATH . '/controllers/',
            'modelsDir' => APP_PATH . '/models/',
            'viewsDir' => APP_PATH . '/views/',
            'tasksDir' => APP_PATH . '/tasks/',
            'pluginsDir' => APP_PATH . '/plugins/',
            'libraryDir' => APP_PATH . '/library/',
            'cacheDir' => BASE_PATH . '/storage/cache/',
            'migrationsDir' => BASE_PATH . '/storage/migrations/',
            'logDir' => BASE_PATH . '/storage/log/',
            'baseUri' => '/',
        ],

        /*
        |--------------------------------------------------------------------------
        | printNewLine Environment
        |--------------------------------------------------------------------------
        |
        | If configs is set to true, then we print a new line at the end of each execution
        |
        */
        'printNewLine' => true,

        /*
        |--------------------------------------------------------------------------
        | Log Environment
        |--------------------------------------------------------------------------
        |
        | If sql is set to true, then we write a log at the end of each sql.
        |
        */
        'log' => [
            'sql' => false,
        ],

    ]
);
