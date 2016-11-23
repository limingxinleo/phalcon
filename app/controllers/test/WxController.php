<?php

namespace MyApp\Controllers\Test;

use limx\tools\wx\OAuth;

class WxController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        $name = "";
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')) {
            // 微信内打开
            $name .= "微信";
        }
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {
            $name .= "IOS";
        } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) {
            $name .= "Android";
        }
        $this->view->name = $name;
        return $this->view->render('test/wx', 'index');
    }

    /**
     * [infoAction desc]
     * @desc 微信获取授权OPENID的测试
     * @composer require limingxinleo/wx-api
     * @author limx
     */
    public function infoAction()
    {
        $code = $this->request->get('code');
        $appid = env('APPID');
        $appsec = env('APPSECRET');
        $api = new OAuth($appid, $appsec);
        $api->code = $code;// 微信官方回调回来后 会携带code
        $url = env('APP_URL') . '/test/wx/info';//当前的URL
        $api->setRedirectUrl($url);
        $res = $api->getUserInfo();
        dump($res);
    }

}

