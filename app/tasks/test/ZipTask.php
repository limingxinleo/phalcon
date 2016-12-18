<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/12/18 Time: 21:37
// +----------------------------------------------------------------------
namespace MyApp\Tasks\Test;

use Phalcon\Cli\Task;
use ZipArchive;

class ZipTask extends Task
{
    public function MainAction()
    {   //加压缩文件
        $zip = new ZipArchive();
        $file = BASE_PATH . "/public/uploads/file.zip";
        $output = BASE_PATH . "/public/uploads/";
        // open archive
        if ($zip->open($file) !== TRUE) {
            echo "Don`t find zip file!\n";
            return;
        }
        // extract contents to destination directory
        if (!is_dir($output)) {
            mkdir($output, 0777, true);
        }
        $zip->extractTo($output);
        // close archive
        $zip->close();
        echo "SUCCESS\n";
    }
}