<?php

namespace MyApp\Controllers\Test;

use limx\tools\wx\OAuth;
/** 微信支付 S */
use limx\tools\wx\pay\JsApiPay;
use limx\tools\wx\pay\data\WxPayUnifiedOrder;
use limx\tools\wx\pay\lib\WxPayApi;

/** 微信支付 E */
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

    /**
     * [payAction desc]
     * @desc 微信JsApiPay支付
     * @composer require limingxinleo/wx-api
     * @author limx
     * @return mixed
     */
    public function payAction()
    {
        //①、获取用户openid
        $tools = new JsApiPay();
        $tools->setBaseUrl(env('APP_URL') . '/test/wx/pay');
        $openId = $tools->GetOpenid();

        //②、统一下单
        $input = new WxPayUnifiedOrder();
        $input->SetBody("test");
        $input->SetAttach("test");
        $input->SetOut_trade_no(date("YmdHis"));
        $input->SetTotal_fee("1");
        $input->SetTime_start(date("YmdHis"));
        //$input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = WxPayApi::unifiedOrder($input);
        echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
        dump($order);
        $jsApiParameters = $tools->GetJsApiParameters($order);
        dump($jsApiParameters);

        //获取共享收货地址js函数参数
        $editAddress = $tools->GetEditAddressParameters();
        dump($editAddress);

        //③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
        /**
         * 注意：
         * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
         * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
         * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
         */
        $this->view->jsApiParameters = $jsApiParameters;
        return $this->view->render('test/wx', 'pay');
    }

}

