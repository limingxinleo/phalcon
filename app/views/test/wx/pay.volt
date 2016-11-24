<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<script type="text/javascript">
    //调用微信JS api 支付
    function jsApiCall() {
        WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                {{ jsApiParameters }},
                function (res) {
                    WeixinJSBridge.log(res.err_msg);
                    //alert(res.err_code+res.err_desc+res.err_msg);
                    if (res.err_msg == "get_brand_wcpay_request:ok") {
                        alert('支付成功')
                    } else if (res.err_msg == "get_brand_wcpay_request:cancel") {
                        alert("用户取消支付！");
                    } else {
                        alert("支付失败！");
                    }
                }
        );
    }

    function callpay() {
        if (typeof WeixinJSBridge == "undefined") {
            if (document.addEventListener) {
                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
            } else if (document.attachEvent) {
                document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
            }
        } else {
            jsApiCall();
        }
    }
</script>
<script type="text/javascript">
    //获取共享地址
    //    function editAddress() {
    //        WeixinJSBridge.invoke(
    //                'editAddress',
    //                {$ editAddress},
    //                function (res) {
    //                    var value1 = res.proviceFirstStageName;
    //                    var value2 = res.addressCitySecondStageName;
    //                    var value3 = res.addressCountiesThirdStageName;
    //                    var value4 = res.addressDetailInfo;
    //                    var tel = res.telNumber;
    //                    alert(value1 + value2 + value3 + value4 + ":" + tel);
    //                }
    //        );
    //    }
    //    window.onload = function () {
    //        if (typeof WeixinJSBridge == "undefined") {
    //            if (document.addEventListener) {
    //                document.addEventListener('WeixinJSBridgeReady', editAddress, false);
    //            } else if (document.attachEvent) {
    //                document.attachEvent('WeixinJSBridgeReady', editAddress);
    //                document.attachEvent('onWeixinJSBridgeReady', editAddress);
    //            }
    //        } else {
    //            editAddress();
    //        }
    //    };
</script>
<style type="text/css">
    body {
        /*font-family: "微软雅黑";*/
        margin: 0;
        padding: 0;
        background-color: #F5F5F5;
    }

    .payDetail {
        width: 100%;
        height: 115px;
        border-bottom: solid 1px #e7e7e7;
        padding-top: 35px;
        background-color: #f5f5f5;
    }

    .payDetail_p {
        font-size: 16px;
        font-weight: bold;
        letter-spacing: 1px;
        color: #282828;
        text-align: center;
        margin: 0 auto;
        line-height: 20px;
        width: 100%;
        height: 20px;;
        text-align: center;
        max-width: 95%;
        max-height: 20px;
        overflow: hidden;
        min-width: 280px;
    }

    .payDetail_span {
        color: #323232;
        font-size: 50px;
        line-height: 70px;
        text-align: center;
        margin: 0px auto;

    }

    .wj_cell_change {
        padding: 0px 5%;
        padding-top: 0px;
    }

    .wj_cell_font1 {
        color: #7e7e7e;
        font-size: 16px;
    }

    .wj_cell_font2 {
        color: black;
        font-size: 16px;
        font-weight: bold;
        /*font-family: "微软雅黑";*/
    }

    .wj_payconfirm {
        width: 90%;
        /*background-color: #f5f5f5;*/
    }

    .wj_payconfirm a {
        margin-top: 30px;
    }

    .wj_pay_bottom {
        width: 100%;
        margin: 0 auto;
        position: fixed;
        bottom: 10px;
    }

    .wj_pay_bottom p {
        text-align: center;
        color: #8d8d8d;
        font-size: 14px;
    }

    .weui_cells {
        margin-top: 1.17647059em;
        background-color: #FFFFFF;
        line-height: 1.41176471;
        font-size: 17px;
        overflow: hidden;
        position: relative;
    }

    .weui_cell {
        padding: 10px 15px;
        position: relative;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
    }

    .weui_cell_bd {
        padding-left: 15px;
    }

    .weui_cell_bd:after {
        display: none;
    }

    .weui_cell_primary {
        -webkit-box-flex: 1;
        -webkit-flex: 1;
        -ms-flex: 1;
        flex: 1;
    }

    .weui_cell_ft {
        padding-left: 0.35em;
        font-size: 0;
        font-size: 1em;
        text-align: right;
    }

    .weui_btn {
        position: relative;
        display: block;
        margin-left: auto;
        margin-right: auto;
        padding-left: 14px;
        padding-right: 14px;
        box-sizing: border-box;
        font-size: 18px;
        text-align: center;
        text-decoration: none;
        color: #FFFFFF;
        line-height: 2.33333333;
        border-radius: 5px;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        overflow: hidden;
    }

    .weui_btn_primary {
        background-color: #04BE02;
    }
</style>
<div class="page" style="background-color:#f5f5f5;">

    <!--<header class="bar bar-nav">
        <h1 class="title">确认交易</h1>
    </header>-->
    <div class="payDetail">
        <font color="#9ACD32">
            <p class="payDetail_p">DEMO订单-11111</p>
            <p class="payDetail_span">¥ 0.01</p>
        </font>
    </div>

    <div class="weui_cells wj_cell_change" style="margin-top: 0;">
        <div class="weui_cell">
            <div class="weui_cell_bd weui_cell_primary wj_cell_font1">
                <p>收款方</p>
            </div>
            <div class="weui_cell_ft wj_cell_font2">
                Demo
            </div>
        </div>
    </div>

    <div align="center" style="background-color: #F5F5F5;border-top: solid 1px #dddddd;">
        <div class="wj_payconfirm">
            <a onclick="callpay()" class="weui_btn weui_btn_primary"
               style="height: 3.5rem;font-size: 18px;line-height: 3.5rem;">立即支付</a>
        </div>
        <div class="wj_pay_bottom">
            <p>解释权归Demo所有</p>
        </div>
    </div>


</div>