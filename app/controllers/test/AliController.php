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
        $code = $this->request->get('app_auth_code');
        $appid = env('ALIPAY_APPID');
        $redirect_uri = env('APP_URL') . '/test/ali/info';
        if (empty($code)) {
            // 获取code
            $url = 'https://openauth.alipay.com/oauth2/appToAppAuth.htm?';
            $params = [
                'app_id' => $appid,
                'scope' => 'auth_user',
                'redirect_uri' => $redirect_uri
            ];
            return $this->response->redirect($url . http_build_query($params));
        }
        library('alipay/AopSdk.php');
        $aop = new \AopClient();
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = env('ALIPAY_APPID');
        $aop->rsaPrivateKey = env('ALIPAY_PRIKEY');
        $aop->alipayrsaPublicKey = env('ALIPAY_PUBKEY');
        $aop->apiVersion = '1.0';
        $aop->format = 'json';

        $request = new \AlipaySystemOauthTokenRequest();
        $request->setGrantType("authorization_code");
        $request->setCode($code);
//        $request->setRefreshToken("201208134b203fe6c11548bcabd8da5bb087a83b");
        $result = $aop->execute($request);
        dump($code);
        dump($result);

    }

    public function echoAction()
    {
        $res = $this->request->get();
        dump($res);
    }

}

