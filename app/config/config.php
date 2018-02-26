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
        'version' => '2.2.8',

        /*
        |--------------------------------------------------------------------------
        | Environment
        |--------------------------------------------------------------------------
        |
        | This value is environment for this project.
        |
        */
        'env' => env('APP_ENV', 'local'),

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
            'port' => env('DB_PORT', 3306),
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
        | MongoDB Environment
        |--------------------------------------------------------------------------
        |
        | This value determines the "environment" your mongo.
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
            'coreDir' => APP_PATH . '/core/',
            'jobsDir' => APP_PATH . '/jobs/',
            'libraryDir' => APP_PATH . '/library/',
            'middlewareDir' => APP_PATH . '/middleware/',
            'modelsDir' => APP_PATH . '/models/',
            'tasksDir' => APP_PATH . '/tasks/',
            'utilsDir' => APP_PATH . '/utils/',
            'viewsDir' => APP_PATH . '/views/',

            'cacheDir' => ROOT_PATH . '/storage/cache/',
            'lockDir' => ROOT_PATH . '/storage/lock/',
            'logDir' => ROOT_PATH . '/storage/log/',
            'metaDataDir' => ROOT_PATH . '/storage/meta/',
            'migrationsDir' => ROOT_PATH . '/storage/migrations/',
            'pidsDir' => ROOT_PATH . '/storage/pids/',
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
        | QUEUE Environment
        |--------------------------------------------------------------------------
        |
        | key: 消息队列的KEY键
        | delayKey: 延时消息队列的KEY键
        | errorKey: 失败的消息队列的KEY键
        |
        */
        'queue' => [
            'key' => env('QUEUE_KEY', 'phalcon:queue:default'),
            'delayKey' => env('QUEUE_DELAY_KEY', 'phalcon:queue:delay'),
            'errorKey' => env('QUEUE_ERROR_KEY', 'phalcon:queue:error'),
        ],

        /*
        |--------------------------------------------------------------------------
        | Services
        |--------------------------------------------------------------------------
        |
        | 依赖注入服务
        |
        */
        'services' => [
            'common' => [
                'config' => App\Core\Services\ConfigService::class, // 系统配置
                'db' => App\Core\Services\Db::class,
                'modelsMetadata' => App\Core\Services\ModelsMetadata::class,
                'filter' => App\Core\Services\Filter::class,
                'cache' => App\Core\Services\Cache::class,
                'error' => App\Core\Services\Error::class,
                'crypt' => App\Core\Services\Crypt::class,
                'redis' => App\Core\Services\Redis::class,
                'mongo' => App\Core\Services\Mongo::class,
                'cookies' => App\Core\Services\Cookies::class,
                'session' => App\Core\Services\Session::class,
                'modelsManager' => App\Core\Services\ModelsManager::class,
                'logger' => App\Core\Services\Logger::class,
            ],
            'cli' => [
                'dispatcher' => App\Core\Services\Cli\Dispatcher::class,
                'console' => App\Core\Services\Cli\Console::class,
                'xconsole' => App\Core\Services\Cli\XConsole::class,
            ],
            'mvc' => [
                'router' => App\Core\Services\Mvc\Router::class,
                'url' => App\Core\Services\Mvc\Url::class,
                'view' => App\Core\Services\Mvc\View::class,
                'dispatcher' => App\Core\Services\Mvc\Dispatcher::class,
                'middleware' => App\Core\Services\Mvc\Middleware::class,
                'request' => App\Core\Services\Mvc\Request::class,
            ],
        ],

    ]
);
