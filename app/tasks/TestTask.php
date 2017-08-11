<?php

namespace App\Tasks;

use App\Jobs\Test;
use App\Utils\Queue;

class TestTask extends \Phalcon\Cli\Task
{

    public function mainAction()
    {
        Queue::push(new Test(1));
    }

}

