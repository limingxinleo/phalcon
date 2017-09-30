<?php
// +----------------------------------------------------------------------
// | Common 逻辑类 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Logics;

use Phalcon\Di\Injectable;
use Phalcon\Exception;
use Phalcon\Version;
use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;
use Symfony\Component\Finder\Finder;

class System extends Injectable
{
    /**
     * @desc   获取项目版本号
     * @author limx
     * @return mixed
     */
    public function version()
    {
        return $this->config->version;
    }

    /**
     * @desc   获取所有控制器的方法注释
     * @author limx
     */
    public static function getControllersAnnotations($limitCount = 0, $onlyAction = false)
    {
        if (!class_exists(Finder::class)) {
            $msg = "Not Find " . Finder::class . "! Please composer require symfony/finder" . PHP_EOL;
            throw new Exception($msg);
        }

        $reader = new MemoryAdapter();
        $result = [];
        // 取出所有的控制器
        $controllerDir = di('config')->application->controllersDir;
        $finder = new Finder();
        $res = $finder->files()->in($controllerDir)->name("*.php");

        if ($res->count() === 0) {
            $msg = "Controller is not defined" . PHP_EOL;
            throw new Exception($msg);
        }

        foreach ($res as $file) {
            $linesCode = file($file->getRealPath());
            $namespace = "";
            $classname = "";
            // 获取控制器命名空间
            foreach ($linesCode as $line) {
                preg_match('#^namespace (.+);$#', $line, $matches);
                if (isset($matches[1])) {
                    $namespace = $matches[1];
                    break;
                }
            }
            if (empty($namespace)) {
                continue;
            }
            // 获取控制器类名
            foreach ($linesCode as $line) {
                preg_match('#class (.+) extends#', $line, $matches);
                if (isset($matches[1])) {
                    $classname = $matches[1];
                    break;
                }
            }
            if (empty($classname)) {
                continue;
            }

            $full_classname = $namespace . "\\" . $classname;
            if (in_array($full_classname, static::getIgnoreController())) {
                // 如果是忽略的控制器则跳过
                continue;
            }
            $methods = $reader->getMethods($full_classname);
            if (empty($methods)) {
                // 没有匹配到方法则跳过
                continue;
            }
            foreach ($methods as $name => $collection) {
                if ($onlyAction) {
                    preg_match('#Action$#', $name, $matches);
                    // 匹配控制器方法，如果不是Action结尾，则跳过
                    if (empty($matches)) {
                        continue;
                    }
                }
                $method = [];
                $method['method'] = $full_classname . "@" . $name;
                // 读取类中注释块中的注释
                $annotations = $collection->getAnnotations();
                // 遍历注释
                foreach ($annotations as $annotation) {
                    $item = [];
                    $name = $annotation->getName();
                    $number = $annotation->numberArguments();
                    $arguments = $annotation->getArguments();
                    if ($number < $limitCount) {
                        continue;
                    }
                    // 注释名称
                    $item['name'] = $name;
                    $item['number'] = $number;
                    $item['arguments'] = $arguments;
                    $method['annotation'][] = $item;
                }
                $result[] = $method;
            }

        }
        return $result;
    }

    public static function getVersions()
    {
        return [
            'Phalcon Version' => Version::get(),
            'Project Version' => (new System())->version(),
        ];
    }

    public static function getEnvironment()
    {
        return [
            'OS' => php_uname(),
            'PHP Version' => PHP_VERSION,
            'PHP SAPI' => php_sapi_name(),
            'PHP Bin' => PHP_BINARY,
            'PHP Extension Dir' => PHP_EXTENSION_DIR,
            'PHP Bin Dir' => PHP_BINDIR,
            'Loaded PHP config' => php_ini_loaded_file(),
        ];
    }

    protected static function getIgnoreController()
    {
        return [
            "App\\Controllers\\Controller",
            "App\\Controllers\\ErrorController"
        ];
    }
}