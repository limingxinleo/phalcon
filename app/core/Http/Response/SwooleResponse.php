<?php
// +----------------------------------------------------------------------
// | SwooleResponse.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Http\Response;

use Phalcon\Http\Response;
use swoole_http_response;
use Exception;

class SwooleResponse extends Response
{
    protected $response;

    public function init(swoole_http_response $response)
    {
        $this->response = $response;
        $this->_sent = false;
        $this->_content = null;
        $this->setStatusCode(200);
    }

    public function send()
    {
        if ($this->_sent) {
            throw new Exception("Response was already sent");
        }

        $this->_sent = true;
        $this->response->status($this->getStatusCode());
        $this->response->end($this->_content);
        return $this;
        // this->sendHeaders();
        // this->sendCookies();
        //
        // /**
        //      * Output the response body
        //      */
        // let content = this->_content;
        // if content != null {
        //         echo content;
        //     } else {
        //         let file = this->_file;
        //
        // 	if typeof file == "string" && strlen(file) {
        //         readfile(file);
        // 	}
        // }
        //
        // let this->_sent = true;
        // return this;
    }
}