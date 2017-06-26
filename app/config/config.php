<?php
/*
 * Modified: preppend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('ROOT_PATH') || define('ROOT_PATH', realpath(__DIR__ . '/../..'));
defined('APP_PATH') || define('APP_PATH', ROOT_PATH . '/app');

use Dotenv\Dotenv;
use Phalcon\Config;

if (file_exists(ROOT_PATH . '/.env')) {
    (new Dotenv(ROOT_PATH))->load();
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
        'version' => '1.9.1',

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
        | Timezone Environment
        |--------------------------------------------------------------------------
        |
        | This value is the timezone for app.
        |
        */
        'timezone' => env('APP_TIMEZONE', 'Asia/Shanghai'),

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
            // 是否开启Redis辅助类
            'isUtils' => env('REDIS_IS_UTILS', false),
        ],

        /*
        |--------------------------------------------------------------------------
        | MongoDB Environment
        |--------------------------------------------------------------------------
        |
        | This value determines the "environment" your redis.
        |
        */
        'mongo' => [
            'host' => env('MONGODB_HOST', '127.0.0.1'),
            'port' => env('MONGODB_PORT', '27017'),
            'connect' => env('MONGODB_CONNECT', true),
            'timeout' => env('MONGODB_TIMEOUT', null),
            'replicaSet' => env('MONGODB_REPLICA_SET', null),
            'username' => env('MONGODB_USERNAME', null),
            'password' => env('MONGODB_PASSWORD', null),
            'db' => env('MONGODB_DB', null),
            'collection' => env('MONGODB_COLLECTION', null),
            // 是否开启Mongo辅助类
            'isUtils' => env('MONGODB_IS_UTILS', false),
            // 是否开启Mongo Collection集合类
            'isCollection' => env('MONGODB_IS_COLLECTION', false),
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
            'libraryDir' => APP_PATH . '/library/',
            'listenersDir' => APP_PATH . '/listeners/',
            'logicsDir' => APP_PATH . '/logics/',
            'modelsDir' => APP_PATH . '/models/',
            'servicesDir' => APP_PATH . '/services/',
            'tasksDir' => APP_PATH . '/tasks/',
            'traitsDir' => APP_PATH . '/traits/',
            'utilsDir' => APP_PATH . '/utils/',
            'viewsDir' => APP_PATH . '/views/',

            'cacheDir' => ROOT_PATH . '/storage/cache/',
            'logDir' => ROOT_PATH . '/storage/log/',
            'metaDataDir' => ROOT_PATH . '/storage/meta/',
            'migrationsDir' => ROOT_PATH . '/storage/migrations/',
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
        | If db is set to true, then we write a log at the end of each sql.
        |
        */
        'log' => [
            'db' => env('LOG_DB', true),
            'error' => env('LOG_ERROR', true),
        ],

        /*
        |--------------------------------------------------------------------------
        | Model Meta Environment
        |--------------------------------------------------------------------------
        |
        | The modelMetaData support file and redis.
        |
        */
        'modelMeta' => [
            'driver' => env('MODELMETA_DRIVER', 'file'),
            'statsKey' => '_PHCM_MM',
            'lifetime' => 172800,
            'index' => env('REDIS_INDEX', 0),
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
        | SESSION Environment
        |--------------------------------------------------------------------------
        |
        | The default setting is file.
        | If you want to use redis ,you must set type=redis,
        |
        */
        'session' => [
            'type' => env('SESSION_DRIVER', 'file'),
        ],

        /*
        |--------------------------------------------------------------------------
        | COOKIES Environment
        |--------------------------------------------------------------------------
        |
        | isCrypt::是否加密 默认值false.
        |
        */
        'cookies' => [
            'isCrypt' => env('COOKIE_ISCRYPT', false),
        ],

        /*
        |--------------------------------------------------------------------------
        | CRYPT Environment
        |--------------------------------------------------------------------------
        |
        | key::The secret key.
        |
        */
        'crypt' => [
            'key' => env('CRYPT_KEY', 'phalcon-project-cookie->key'),
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
            'common' => [
                'config' => App\Services\Config::class, // 系统配置
                'app' => App\Services\App::class, // 自定义配置
                'db' => App\Services\Db::class,
                'modelsMetadata' => App\Services\ModelsMetadata::class,
                'filter' => App\Services\Filter::class,
                'cache' => App\Services\Cache::class,
                'error' => App\Services\Error::class,
                'crypt' => App\Services\Crypt::class,
                'redis' => App\Services\Redis::class,
                'mongo' => App\Services\Mongo::class,
                'cookies' => App\Services\Cookies::class,
                'session' => App\Services\Session::class,
            ],
            'cli' => [
                'dispatcher' => App\Services\Cli\Dispatcher::class,
                'console' => App\Services\Cli\Console::class,
            ],
            'http' => [
                'router' => App\Services\Http\Router::class,
                'url' => App\Services\Http\Url::class,
                'view' => App\Services\Http\View::class,
                'dispatcher' => App\Services\Http\Dispatcher::class,
            ],
        ],

    ]
);
