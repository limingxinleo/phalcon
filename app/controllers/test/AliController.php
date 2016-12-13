<?php

namespace MyApp\Controllers\Test;

use Sms\Request\V20160927 as Sms;

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

    /**
     * [infoAction desc]
     * @desc 支付宝内WAP获取用户信息
     * @author limx
     * @return mixed
     * @throws \Exception
     */
    public function infoAction()
    {
        $code = $this->request->get('auth_code');
        $appid = env('ALIPAY_APPID');
        $redirect_uri = env('APP_URL') . '/test/ali/info';
        if (empty($code)) {
            // 获取code
            $url = 'https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?';
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
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $user_id = $result->$responseNode->user_id;
        $access_token = $result->$responseNode->access_token;

        dump($result->$responseNode);
        $request = new \AlipayUserInfoShareRequest();
        $result = $aop->execute($request, $access_token);

        dump($result);

    }

    /**
     * [userinfoAction desc]
     * @desc APP 获取用户信息
     * @author limx
     * @throws \Exception
     */
    public function userinfoAction()
    {
        $code = $this->request->get('auth_code');
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
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $user_id = $result->$responseNode->user_id;
        $access_token = $result->$responseNode->access_token;

        dump($result->$responseNode);
        $request = new \AlipayUserUserinfoShareRequest();
        $result = $aop->execute($request, $access_token);

        dump($result);

    }

    public function echoAction()
    {
        $res = $this->request->get();
        dump($res);
    }

    /**
     * [smsAction desc]
     * @desc 下载阿里短信官方sdk
     * @author limx
     */
    public function smsAction()
    {
        library('alisms/aliyun-php-sdk-core/Config.php');

        $iClientProfile = \DefaultProfile::getProfile("cn-hangzhou", env('ALIYUN_ACCESS_KEY'), env('ALIYUN_ACCESS_SECRET'));
        $client = new \DefaultAcsClient($iClientProfile);
        $request = new Sms\SingleSendSmsRequest();
        $request->setSignName("祎昕测试");/*签名名称*/
        $request->setTemplateCode("SMS_33520803");/*模板code*/
        $request->setRecNum("13250874521");/*目标手机号*/
        $request->setParamString("{\"name\":\"李铭昕\"}");/*模板变量，数字一定要转换为字符串*/
        try {
            $response = $client->getAcsResponse($request);
            print_r($response);
        } catch (ClientException  $e) {
            print_r($e->getErrorCode());
            print_r($e->getErrorMessage());
        } catch (ServerException  $e) {
            print_r($e->getErrorCode());
            print_r($e->getErrorMessage());
        }
    }

    /**
     * [loginAction desc]
     * @desc 支付宝登录 签名
     * @author limx
     */
    public function loginAction()
    {
        library('alipay/AopSdk.php');
        $aop = new \AopClient();
        $aop->rsaPrivateKey = env('ALIPAY_PRIKEY');
        $aop->alipayrsaPublicKey = env('ALIPAY_PUBKEY');

        /** 待签名数组 */
        $data['apiname'] = 'com.alipay.account.auth';
        $data['method'] = 'alipay.open.auth.sdk.code.get';
        $data['app_id'] = env('ALIPAY_APPID');
        $data['app_name'] = 'mc';
        $data['biz_type'] = 'openservice';
        $data['pid'] = env('ALIPAY_PID');
        $data['product_id'] = 'APP_FAST_LOGIN';
        $data['scope'] = 'kuaijie';
        $data['target_id'] = uniqid();
        $data['auth_type'] = 'AUTHACCOUNT';
        $data['sign_type'] = 'RSA';
        $data['sign'] = urlencode($aop->rsaSign($data));

        return success($data);

    }

}

