<?php
/*
 * Modified: preppend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('ROOT_PATH') || define('ROOT_PATH', realpath(__DIR__ . '/../..'));
defined('APP_PATH') || define('APP_PATH', ROOT_PATH . '/app');

use Phalcon\Config;
use Phalcon\Config\Adapter\Ini;

$ini = new Ini(ROOT_PATH . '/config.ini');

/**
 * The System Config.
 */
$config = new Config(
    [
        /*
        |--------------------------------------------------------------------------
        | Version Environment
        |--------------------------------------------------------------------------
        |
        | This value is version for this project.
        |
        */
        'version' => '2.4.0',

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
                'logger' => App\Core\Services\Logger::class,
                'error' => App\Core\Services\Error::class,
                'crypt' => App\Core\Services\Crypt::class,
                'redis' => App\Core\Services\Redis::class,
                'mongo' => App\Core\Services\Mongo::class,
                'cookies' => App\Core\Services\Cookies::class,
                'session' => App\Core\Services\Session::class,
                'modelsManager' => App\Core\Services\ModelsManager::class,
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

return $config->merge($ini);
