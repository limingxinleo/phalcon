<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader
    ->registerNamespaces(
        [
            'MyApp\Controllers' => $config->application->controllersDir,
            'MyApp\Controllers\Admin' => $config->application->controllersDir . 'admin/',
            'MyApp\Controllers\Test' => $config->application->controllersDir . 'test/',

            'MyApp\Models' => $config->application->modelsDir,
            'MyApp\Models\Test' => $config->application->modelsDir . 'test/',

            'MyApp\Tasks' => $config->application->tasksDir,
            'MyApp\Tasks\System' => $config->application->tasksDir . 'system/',
        ]
    )->registerFiles(
        [
            'function' => $config->application->libraryDir . 'helper.php',
        ]
    )->register();
