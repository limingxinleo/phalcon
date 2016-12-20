<?php
/*
 * Modified: preppend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

use Phalcon\Config;
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

if (file_exists(BASE_PATH . '/.env')) {
    (new Dotenv(BASE_PATH))->load();
}

/**
 * The System EVN.
 */
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
        'version' => '1.3.0',

        /*
        |--------------------------------------------------------------------------
        | Unique_id Environment
        |--------------------------------------------------------------------------
        |
        | This value is your-private-app for this project.
        |
        */
        'unique_id' => env('UNIQUE_ID', 'phalcon'),

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
        'domain' => env('APP_URL', 'localhost'),

        /*
        |--------------------------------------------------------------------------
        | Database Environment
        |--------------------------------------------------------------------------
        |
        | This value determines the "environment" your database.
        |
        */
        'database' => [
            'adapter' => env('DB_ADAPTER', 'Mysql'),
            'host' => env('DB_HOST', 'localhost'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', null),
            'dbname' => env('DB_DBNAME', 'phalcon'),
            'charset' => env('DB_CHARSET', 'utf8'),
        ],

        /*
        |--------------------------------------------------------------------------
        | Redis Environment
        |--------------------------------------------------------------------------
        |
        | This value determines the "environment" your redis.
        |
        */
        'redis' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'port' => env('REDIS_PORT', '6379'),
            'auth' => env('REDIS_AUTH', null),
            'persistent' => env('REDIS_PERSISTENT', false),
            'index' => env('REDIS_INDEX', 0),
            'prefix' => env('REDIS_PREFIX', ''),
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
            'metaDataDir' => BASE_PATH . '/storage/meta/',
            'servicesDir' => APP_PATH . '/services/',
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
            'sql' => env('LOG_SQL', true),
            'error' => env('LOG_ERROR', true),
        ],

        /*
        |--------------------------------------------------------------------------
        | Cache Environment
        |--------------------------------------------------------------------------
        |
        | The default setting is file.
        | If you want to use redis ,you must set type=redis,
        |
        */
        'cache' => [
            'type' => env('CACHE_DRIVER', 'file'),
            'lifetime' => 172800,
        ],

        /*
        |--------------------------------------------------------------------------
        | Cache Environment
        |--------------------------------------------------------------------------
        |
        | The default setting is file.
        | If you want to use redis ,you must set type=redis,
        |
        */
        'session' => [
            'type' => env('SESSION_DRIVER', 'file')
        ],

        /*
        |--------------------------------------------------------------------------
        | Services
        |--------------------------------------------------------------------------
        |
        | The default setting is file.
        | If you want to use redis ,you must set type=redis,
        |
        */
        'services' => [
            'system/session.php',
            'system/cache.php',
            'system/log.php',
            'system/error.php',
        ],

    ]
);
