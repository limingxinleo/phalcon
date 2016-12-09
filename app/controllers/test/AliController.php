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
        $request = new \AlipayUserInfoAuthRequest();
        $data = ['scopes' => ['auth_base'], 'state' => 'init'];
        $request->setBizContent(json_encode($data));
        $result = $aop->execute($request);
        dump(json_encode($data));
        dump($result);
        exit;

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        if (!empty($resultCode) && $resultCode == 10000) {
            echo "成功";
        } else {
            echo "失败";
        }
    }

}

