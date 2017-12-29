<?php
// +----------------------------------------------------------------------
// | Version.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core;

use App\Core\Support\InstanceBase;
use Phalcon\Version;

class System extends InstanceBase
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

    public function getVersions()
    {
        return [
            'Phalcon Version' => Version::get(),
            'Project Version' => $this->version(),
        ];
    }

    public function getEnvironment()
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
}
