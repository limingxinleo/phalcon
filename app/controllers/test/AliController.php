<?php

namespace MyApp\Controllers\Test;

class AliController extends ControllerBase
{

    public function indexAction()
    {
        /** 接入alipay后台SDK */
        library('alipay/AopSdk.php');
        $c = new \AopClient();
        $c->gatewayUrl = "https://openapi.alipay.com/gateway.do";
        $c->appId = env("ALIPAY_APPID");
        $c->rsaPrivateKey = env('ALIPAY_PRIKEY');
        $c->format = "json";
        $c->alipayrsaPublicKey = env('ALIPAY_PUBKEY');
        $req = new \AlipayTradeWapPayRequest();
        $data['out_trade_no'] = time();
        $data['total_amount'] = 0.01;
        $data['subject'] = 'test';
        $data['seller_id'] = env('ALIPAY_SELLERID');
        $data['product_code'] = 'QUICK_WAP_PAY';
        $bizContent = json_encode($data);
        $req->setBizContent($bizContent);

        $form = $c->pageExecute($req);
        echo $form;
    }

    public function checkSignAction()
    {
        library('alipay/AopSdk.php');
        $aop = new \AopClient();
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = env('ALIPAY_APPID');
        $aop->rsaPrivateKey = env('ALIPAY_PRIKEY');
        $aop->alipayrsaPublicKey = env('ALIPAY_PUBKEY');
        $aop->apiVersion = '1.0';
        $aop->format = 'json';

        $request = new \MonitorHeartbeatSynRequest();
        $request->setBizContent("{任意值}");
        $result = $aop->execute($request);
        dump($result);
    }

    public function infoAction()
    {
        library('alipay/AopSdk.php');
        $aop = new \AopClient();
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = env('ALIPAY_APPID');
        $aop->rsaPrivateKey = env('ALIPAY_PRIKEY');
        $aop->alipayrsaPublicKey = env('ALIPAY_PUBKEY');
        $aop->apiVersion = '1.0';
        $aop->format = 'json';

        $request = new \MonitorHeartbeatSynRequest();
        $request->setBizContent("{任意值}");
        $result = $aop->execute($request);
        dump($result);
        exit;
        $code = $this->request->get('code');
        if (empty($code)) {
            $aop->return_url = 'http://phalcon.phal.lmx0536.cn/test/ali/info';
            $request = new \AlipayUserInfoAuthRequest();
            $data = ['scopes' => ['auth_base'], 'state' => 'init'];
            $request->setBizContent(json_encode($data));
            $result = $aop->execute($request);
            dump($result);
        } else {
            dump($code);
        }
    }

}

