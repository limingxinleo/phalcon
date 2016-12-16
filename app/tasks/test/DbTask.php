<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/12/16 Time: 13:49
// +----------------------------------------------------------------------
namespace MyApp\Tasks\Test;

use Phalcon\Cli\Task;
use limx\phalcon\DB;

class DbTask extends Task
{
    public function mainAction()
    {
        for ($i = 0; $i < 10000; $i++) {
            $start = rand(1, 5);
            $end = rand(5, 10);
            $this->test($start, $end);
        }
        echo "FINISH\n";
    }

    public function test($start, $end)
    {
        $sql = "SELECT * FROM book WHERE uid > ? AND uid < ?;";
        $res = DB::query($sql, [$start, $end]);
        $count1 = count($res);

        $sql = "SELECT * FROM book WHERE uid > {$start} AND uid < {$end};";
        $res = DB::query($sql);
        $count2 = count($res);

        if ($count1 !== $count2 || $count1 = 0) {
            echo $count1 . '|' . $count2 . "\n";
        }
    }

}