<?php

namespace MyApp\Controllers\Test;

use limx\func\Encoder;

class QiniuController extends \Phalcon\Mvc\Controller
{

    public function createAction()
    {
        // Instantiate an Hub object
        $credentials = new \Qiniu\Credentials(env('QINIU_ACCESS_KEY'), env('QINIU_SECRET_KEY')); #=> Credentials Object
        $hub = new \Pili\Hub($credentials, env('QINIU_HUB')); # => Hub Object
        $title = 'TEST';     // optional, auto-generated as default
        $publishKey = '584e52499e353';     // optional, auto-generated as default
        $publishSecurity = 'dynamic';     // optional, can be "dynamic" or "static", "dynamic" as default

        $stream = $hub->createStream($title, $publishKey, $publishSecurity); # => Stream Object

        echo "createStream() =>\n";
        dump($stream);
        echo "\n\n";
    }

    public function getAction()
    {
        // Instantiate an Hub object
        $credentials = new \Qiniu\Credentials(env('QINIU_ACCESS_KEY'), env('QINIU_SECRET_KEY')); #=> Credentials Object
        $hub = new \Pili\Hub($credentials, env('QINIU_HUB')); # => Hub Object

        $streamId = 'z1.peppertv.TEST';

        $stream = $hub->getStream($streamId); # => Stream Object

        echo "getStream() =>\n";
        dump($stream);
        echo "\n\n";
    }

    public function roomAction()
    {
        /** 下载七牛带连麦的sdk php包 */
        library('pili-sdk-php-master/lib/Pili.php');
        $mac = new \Qiniu\Credentials(env('QINIU_ACCESS_KEY'), env('QINIU_SECRET_KEY')); #=> Credentials Object
        $client = new \Pili\RoomClient($mac);
        $resp = $client->createRoom(1, "testroom");
        //dump($resp);

        //鉴权的有效时间: 1个小时.
        $resp = $client->roomToken("testroom", 1, 'admin', (time() + 3600));
        dump($resp);

        $resp = $client->roomToken("testroom", 2, 'user', (time() + 3600));
        dump($resp);

        $resp = $client->getRoom("testroom");
        //dump($resp);

//        $resp = $client->deleteRoom("testroom");
//        print_r($resp);

    }

}

