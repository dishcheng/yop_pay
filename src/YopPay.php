<?php

namespace DishCheng\YopPay;

use DishCheng\YopPay\Lib\YopClient3;
use DishCheng\YopPay\Lib\YopRequest;
use DishCheng\YopPay\Lib\YopResponse;
use DishCheng\YopPay\Lib\YopRsaClient;
use DishCheng\YopPay\Util\UriUtils;
use DishCheng\YopPay\Util\YopSignUtils;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class YopPay extends YopRsaClient
{
    #将参数转换成k=v拼接的形式
    public static function arrayToString($arraydata)
    {
        $Str="";
        foreach ($arraydata as $k=>$v) {
            $Str.=strlen($Str)==0 ? "" : "&";
            $Str.=$k."=".$v;
        }
        return $Str;
    }

    /**
     * 创建订单
     * https://open.yeepay.com/docs/retail000001/rest__v1.0__sys__trade__order.html
     *
     * [
     * 'merchantNo' => '10015386847',//收单商户商编
     * 'orderId' => string_make_guid(),//商户订单号，请自定义
     * 'orderAmount' => 0.01,//单位： 元， 需保留到小数点后两位， 最低 0.01
     * 'timeoutExpress' => 100,//订单有效期    , 默认72小时， 最小1秒， 最大5年,
     * 'timeoutExpressType' => 'SECOND',//订单过期时间类型    枚举：SECOND("秒"), MINUTE("分"), HOUR("时"), DAY("天")
     * 'requestDate' => Carbon::now()->toDateTimeString(),//请求时间,请求时间，用于计算订单有效期， 格式 yyyy-MM-dd HH:mm:ss， 不传默认为易宝接收到请求的时间
     * 'redirectUrl' => '',//前端页面跳转
     * 'hmacKey' =>'5Td040B217L4X9964IC8F0y4nNe2LQ217Q0C82p0k60Vd37m701S47q46922',//
     * 'notifyUrl' => 'http://a460f243bd7b4ceba6ed2ca8e3fad25d.can.test/api/test',//服务器通知地址
     * 'goodsParamExt' => json_encode(['goodsName' => 'sss']),//商品拓展信息,业务上是必须参数， Json 格式， key 支持 goodsName （必填） 、 goodsDesc
     * ]
     *
     * 返回
     * YopResponse {#248 ▼
     * +state: "SUCCESS"
     * +result: {#249 ▼
     * +"code": "OPR00000"
     * +"message": "成功"
     * +"parentMerchantNo": "10014929805"
     * +"merchantNo": "10015386847"
     * +"orderId": "83729bbb1f524d22aec4aca15a6b975d"
     * +"uniqueOrderNo": "1001201907290000000971645009"
     * +"goodsParamExt": "{"goodsName":"sss"}"
     * +"token": "5FB84187DCED8553E0ADF69F5303FF2C8C10A047F7C6C2D29DE0A04CD87D9B87"
     * +"fundProcessType": "REAL_TIME"
     * +"parentMerchantName": "易宝支付产品中心测试账户4， 大算系统商测试子商户"
     * +"merchantName": "yp_test_840@yeepay.com"
     * }
     * +sign: null
     * +error: null
     * +requestId: "5d3ebc7c1142f761845227e807898137"
     * +"validSign": true
     * }
     */
    public static function createOrder(array $params)
    {
        $request=new YopRequest();
        $parentMerchantNo=config('yop_pay.parentMerchantNo');
        $request->addParam("parentMerchantNo", $parentMerchantNo);

        $data['parentMerchantNo']=$parentMerchantNo;
        $data['merchantNo']=$params['merchantNo'];
        $data['orderId']=$params['orderId'];
        $data['orderAmount']=$params['orderAmount'];
        $data['notifyUrl']=$params['notifyUrl'];

        //这个hmackey与merchantNo对应
        $hmacKey=$params['hmacKey'];
        $hmacstr=hash_hmac('sha256', self::arrayToString($data), $hmacKey, true);
        $hmac=bin2hex($hmacstr);
        foreach ($params as $key=>$value) {
            $request->addParam($key, $value);
        }
        $request->addParam('hmac', $hmac);
        $response=YopClient3::post(UriUtils::CreateOrder, $request);
        return $response;
    }


    /**
     * 聚合API收银台接口，调起支付信息
     * https://open.yeepay.com/docs/retail000001/5b3aeae9080cd0005e86a54e.html
     *
     * @param $token '使用createOrder返回的result的token
     * @param $params
     * [
     * 'userNo' => 1,//用户id
     * 'appId' => 'wxbfe439d3e1d6fbc1',
     * 'openId' => 'of5Iv1HUakDWekE0iCukEiEKTz_o',
     * 'userIp' => \request()->ip(),
     * ]
     * @return Lib\YopResponse|mixed
     *
     * 返回值：直接返回前台result.resultData支付参数
     * YopResponse {#244 ▼
     * +state: "SUCCESS"
     * +result: {#245 ▼
     * +"code": "CAS00000"
     * +"message": "调用成功"
     * +"payTool": "WECHAT_OPENID"
     * +"payType": "WECHAT"
     * +"merchantNo": "10014929805"
     * +"token": "5FB84187DCED8553E0ADF69F5303FF2CAD77E5F9B756C068A0090DBDD2F010F1"
     * +"resultType": "json"
     * +"resultData": "{"appId":"wxbfe439d3e1d6fbc1","timeStamp":"1564390386","nonceStr":"c702a63a693d4ede96b613f697c426a2","package":"prepay_id=wx29165306175812ce68507af21474275600", ▶"
     * }
     * +sign: null
     * +error: null
     * +requestId: "5d3eb5d52fbd8876969764e055380f63"
     * +"validSign": true
     * }
     */
    public static function getPayApiInfo($token, $params)
    {
        $request=new YopRequest();
        $request->addParam("token", $token);

        //设置默认支付工具为，WECHAT_OPENID（公众号支付）
        if (!Arr::has($params, 'payTool')) {
            $request->addParam('payTool', 'WECHAT_OPENID');
        }
        //设置默认用户标识类型为USER_ID(用户ID)
        if (!Arr::has($params, 'userType')) {
            $request->addParam('userType', 'USER_ID');
        }
        //设置默认支付类型为WECHAT：微信
        if (!Arr::has($params, 'payType')) {
            $request->addParam('payType', 'WECHAT');
        }
        //固定值
        $request->addParam('version', '1.0');

        //默认为线上场景
        if (!Arr::has($params, 'extParamMap')) {
            $request->addParam('extParamMap', json_encode(['reportFee'=>'XIANXIA']));
        }
        foreach ($params as $key=>$paramValue) {
            $request->addParam($key, $paramValue);
        }
        $response=YopClient3::post(UriUtils::NcCashierApiPay, $request);
        return $response;
    }


    /**
     * 关闭订单，幂等
     * https://open.yeepay.com/docs/retail000001/rest__v1.0__sys__trade__orderclose.html
     *
     * @param $params
     * 请求参数：
     * [
     * 'merchantNo' => '10015386847',//子商编
     * 'hmacKey' => '5Td040B217L4X9964IC8F0y4nNe2LQ217Q0C82p0k60Vd37m701S47q46922',
     * 'orderId' => '83729bbb1f524d22aec4aca15a6b975d',//要关闭的订单的商户订单号
     * 'uniqueOrderNo' => '1001201907290000000971645009',//易宝内部生成唯一订单流水号
     * 'description' => '',//关闭订单原因
     * ]
     *
     *
     * @return Lib\YopResponse|mixed
     * 返回参数：
     * YopResponse {#248 ▼
     * +state: "SUCCESS"
     * +result: {#249 ▼
     * +"code": "OPR00000"
     * +"message": "成功"
     * +"parentMerchantNo": "10014929805"
     * +"merchantNo": "10015386847"
     * +"orderId": "83729bbb1f524d22aec4aca15a6b975d"
     * }
     * +sign: null
     * +error: null
     * +requestId: "5d3ebcbf9f8d5450199932ef4bef5208"
     * +"validSign": true
     * }
     */
    public static function orderClose($params)
    {
        $request=new YopRequest();
        $parentMerchantNo=config('yop_pay.parentMerchantNo');
        $request->addParam("parentMerchantNo", $parentMerchantNo);
        foreach ($params as $key=>$value) {
            $request->addParam($key, $value);
        }
        $data=[];
        $data['parentMerchantNo']=$parentMerchantNo;
        $data['merchantNo']=$params['merchantNo'];
        $data['orderId']=$params['orderId'];
        $data['uniqueOrderNo']=$params['uniqueOrderNo'];
        $hmacstr=hash_hmac('sha256', self::arrayToString($data), $params['hmacKey'], true);
        $hmac=bin2hex($hmacstr);
        $request->addParam('hmac', $hmac);
        $response=YopClient3::post(UriUtils::TradeOrderClose, $request);
        return $response;
    }


    /**
     * 查询订单结果
     * https://open.yeepay.com/docs/retail000001/rest__v1.0__sys__trade__orderquery.html
     *
     * @param $params
     * [
     * 'merchantNo' => '',//子商编，必须
     * 'hmacKey' => '',//必须
     * 'orderId' => '',//要关闭的订单的商户订单号，必须
     * 'uniqueOrderNo' => '',//易宝内部生成唯一订单流水号,,非必须
     * ]
     *
     * @return Lib\YopResponse|mixed
     *
     * `订单查询返回结果
     * YopResponse {#248 ▼
     * +state: "SUCCESS"
     * +result: {#249 ▼
     * +"code": "OPR00000"
     * +"message": "成功"
     * +"parentMerchantNo": "10014929805"
     * +"merchantNo": "10015386847"
     * +"orderId": "83729bbb1f524d22aec4aca15a6b975d"
     * +"uniqueOrderNo": "1001201907290000000971645009"
     * +"status": "CLOSE"
     * +"orderAmount": 0.01
     * +"requestDate": "2019-07-29 17:29:32"
     * +"goodsParamExt": "{"goodsName":"sss"}"
     * +"fundProcessType": "REAL_TIME"
     * +"haveAccounted": false
     * +"residualDivideAmount": "0"
     * +"parentMerchantName": "易宝支付产品中心测试账户4， 大算系统商测试子商户"
     * +"merchantName": "yp_test_840@yeepay.com"
     * +"ypSettleAmount": 0.01
     * }
     * +sign: null
     * +error: null
     * +requestId: "5d3ebe7b486092259899173e39c5aa64"
     * +"validSign": true
     * }
     */
    public static function queryOrder($params)
    {
        $request=new YopRequest();
        $parentMerchantNo=config('yop_pay.parentMerchantNo');

        $request->addParam("parentMerchantNo", $parentMerchantNo);
        foreach ($params as $key=>$value) {
            $request->addParam($key, $value);
        }
        $data=[];
        $data['parentMerchantNo']=$parentMerchantNo;
        $data['merchantNo']=$params['merchantNo'];
        $data['orderId']=$params['orderId'];
        if (isset($params['uniqueOrderNo'])) {
            $data['uniqueOrderNo']=$params['uniqueOrderNo'];
        }
        $hmacstr=hash_hmac('sha256', self::arrayToString($data), $params['hmacKey'], true);
        $hmac=bin2hex($hmacstr);
        $request->addParam('hmac', $hmac);
        $response=YopClient3::post(UriUtils::QueryOrder, $request);
        return $response;
    }


    /**
     * 分账接口
     * https://open.yeepay.com/docs/retail000001/rest__v1.0__sys__trade__divide.html
     *
     * @param $params
     * [
     * 'merchantNo' => '',//子商编，必须
     * 'orderId' => '',//商户订单号，必须，
     * 'uniqueOrderNo' => '',//统一订单号，必须
     * 'divideRequestId' => '',//分账请求号,必须
     * 'contractNo' => '',//合同号,必须
     * 'divideDetail' => '',//分账明细,必须(https://open.yeepay.com/docs/retail000001/5b14e38d2181f82aa49df218.html)
     * 'isUnfreezeResidualAmount' => '',//是否解冻收单商户剩余可用金额,非必须；可选TRUE、FALSE 默认TRUE
     * 'divideNotifyUrl' => '',//分账回调地址
     * ]
     *
     * @return Lib\YopResponse|mixed
     *
     */
    public static function tradeDivide($params)
    {
        $request=new YopRequest();
        $parentMerchantNo=config('yop_pay.parentMerchantNo');
        $request->addParam("parentMerchantNo", $parentMerchantNo);
        foreach ($params as $key=>$value) {
            $request->addParam($key, $value);
        }
        $data=[
            'parentMerchantNo'=>$parentMerchantNo,
            'merchantNo'=>$params['merchantNo'],
            'orderId'=>$params['orderId'],
            'uniqueOrderNo'=>$params['uniqueOrderNo'],
            'divideRequestId'=>$params['divideRequestId'],
        ];
        $hmac=bin2hex(hash_hmac('sha256', self::arrayToString($data), $params['hmacKey'], true));
        $request->addParam('hmac', $hmac);
        return YopClient3::post(UriUtils::TradeDivide, $request);
    }


    /**
     * 订单处理器-分账查询
     * https://open.yeepay.com/docs/retail000001/rest__v1.0__sys__trade__dividequery.html
     *
     * @param $params
     * [
     * 'merchantNo' => '',//子商编，必须，
     * 'orderId' => '',//商户订单号，必须
     * 'uniqueOrderNo' => '',//统一订单号    ，必须
     * 'divideRequestId' => '',//分账请求号，必须
     *]
     * @return Lib\YopResponse|mixed
     *
     */
    public static function divideQuery($params)
    {
        $request=new YopRequest();
        $parentMerchantNo=config('yop_pay.parentMerchantNo');
        $request->addParam("parentMerchantNo", $parentMerchantNo);
        foreach ($params as $key=>$value) {
            $request->addParam($key, $value);
        }
        $data=[
            'parentMerchantNo'=>$parentMerchantNo,
            'merchantNo'=>$params['merchantNo'],
            'orderId'=>$params['orderId'],
            'uniqueOrderNo'=>$params['uniqueOrderNo'],
            'divideRequestId'=>$params['divideRequestId'],
        ];
        $hmac=bin2hex(hash_hmac('sha256', self::arrayToString($data), $params['hmacKey'], true));
        $request->addParam('hmac', $hmac);
        return YopClient3::post(UriUtils::TradeDivideQuery, $request);
    }


    /**
     * 订单处理器-完结分账
     * https://open.yeepay.com/docs/retail000001/rest__v1.0__sys__trade__enddivide.html
     *
     * @param $params
     * [
     * 'orderId' => '',//商户订单号，必须，
     * 'uniqueOrderNo' => '',//统一订单号，必须
     * 'endDivideRequestId' => '',//完结分账请求号    ，必须
     * 'endDivideDesc' => '',//完结分账描述，必须
     * 'merchantNo' => '',//收单商商编，必须
     * 'endDivideUrl' => '',//完结分账通知地址，非必须
     * ]
     *
     * @return Lib\YopResponse|mixed
     *
     */
    public static function endDivide($params)
    {
        $request=new YopRequest();
        $parentMerchantNo=config('yop_pay.parentMerchantNo');
        $request->addParam("parentMerchantNo", $parentMerchantNo);
        foreach ($params as $key=>$value) {
            $request->addParam($key, $value);
        }
        $data=[
            'parentMerchantNo'=>$parentMerchantNo,
            'merchantNo'=>$params['merchantNo'],
            'orderId'=>$params['orderId'],
            'uniqueOrderNo'=>$params['uniqueOrderNo'],
            'endDivideRequestId'=>$params['endDivideRequestId'],
        ];
        $hmac=bin2hex(hash_hmac('sha256', self::arrayToString($data), $params['hmacKey'], true));
        $request->addParam('hmac', $hmac);
        return YopClient3::post(UriUtils::TradeEndDivide, $request);
    }


    /**
     * 订单处理器——资金全额确认     支持沙箱
     * https://open.yeepay.com/docs/retail000001/rest__v1.0__sys__trade__enddivide.html
     *
     * @param $params
     * [
     * 'merchantNo'=>'',//子商编,必须
     * 'orderId' => '',//商户订单号，必须，原商户支付订单号
     * 'uniqueOrderNo' => '',//易宝统一订单号，必须，原交易订单的易宝流水号（订单创建接口获取）
     * 'hmacKey'=>'',//子商编密钥
     * ]
     *
     * @return Lib\YopResponse|mixed
     *
     */
    public static function fullSettle($params)
    {
        $request=new YopRequest();
        $parentMerchantNo=config('yop_pay.parentMerchantNo');
        $request->addParam("parentMerchantNo", $parentMerchantNo);
        foreach ($params as $key=>$value) {
            $request->addParam($key, $value);
        }
        $data=[
            'parentMerchantNo'=>$parentMerchantNo,
            'merchantNo'=>$params['merchantNo'],
            'orderId'=>$params['orderId'],
            'uniqueOrderNo'=>$params['uniqueOrderNo'],
        ];
        $hmac=bin2hex(hash_hmac('sha256', self::arrayToString($data), $params['hmacKey'], true));
        $request->addParam('hmac', $hmac);
        return YopClient3::post(UriUtils::TradeFullSettle, $request);
    }


    /**
     * 订单退款
     * https://open.yeepay.com/docs/retail000001/rest__v1.0__sys__trade__refund.html
     *
     * @param $params
     * [
     * 'merchantNo' => '10015386847',//子商编
     * 'hmacKey' => '5Td040B217L4X9964IC8F0y4nNe2LQ217Q0C82p0k60Vd37m701S47q46922',
     * 'orderId' => '83729bbb1f524d22aec4aca15a6b975d',//要关闭的订单的商户订单号
     * 'uniqueOrderNo' => '1001201907290000000971645009',//易宝内部生成唯一订单流水号
     * 'refundRequestId' => string_make_guid(),//退款请求号
     * 'refundAmount' => '0.01',//退款金额
     * 'description' => '',//退款说明
     * 'notifyUrl' => '',//接收退款结果通知地址
     * ]
     *
     * @return Lib\YopResponse|mixed
     *
     * 没办法付钱。。
     * YopResponse {#248 ▼
     * +state: "SUCCESS"
     * +result: {#249 ▼
     * +"code": "OPR13006"
     * +"message": "订单状态不合法CLOSE"
     * +"parentMerchantNo": "10014929805"
     * +"merchantNo": "10015386847"
     * +"orderId": "83729bbb1f524d22aec4aca15a6b975d"
     * +"refundRequestId": "e7a8e362eeff4be5959705067e25612c"
     * +"refundAmount": "0.01"
     * }
     * +sign: null
     * +error: null
     * +requestId: "5d3ec210dfa2c65982441616af90a37f"
     * +"validSign": true
     * }
     */
    public static function refundOrder($params)
    {
        $request=new YopRequest();
        $parentMerchantNo=config('yop_pay.parentMerchantNo');

        $request->addParam("parentMerchantNo", $parentMerchantNo);
        foreach ($params as $key=>$value) {
            $request->addParam($key, $value);
        }
        $data=[];
        $data['parentMerchantNo']=$parentMerchantNo;
        $data['merchantNo']=$params['merchantNo'];
        $data['orderId']=$params['orderId'];
        $data['uniqueOrderNo']=$params['uniqueOrderNo'];
        $data['refundRequestId']=$params['refundRequestId'];
        $data['refundAmount']=$params['refundAmount'];

        $hmacstr=hash_hmac('sha256', self::arrayToString($data), $params['hmacKey'], true);
        $hmac=bin2hex($hmacstr);
        $request->addParam('hmac', $hmac);

        $response=YopClient3::post(UriUtils::TradeRefund, $request);
        return $response;
    }

    /**
     * 统一公众号配置     支持沙箱
     * https://open.yeepay.com/docs/retail000001/rest__v1.0__router__open-pay-async-report__config.html
     * @param $params
     * [
     *      'appId'=>'xxxx',
     *      'merchantNo'=>'10015386847',
     *      'appId'=>'appId',
     *      'channelIds    '=>'渠道号集合',
     *      'senceType'=>'场景',
     * ]
     * @return Lib\YopResponse|mixed
     */
    public static function upLoadpayJsapiConfig($params)
    {
        $request=new YopRequest();
        foreach ($params as $key=>$value) {
            $request->addParam($key, $value);
        }
        $response=YopClient3::post(UriUtils::OpenPayAsyncReportConfig, $request);
        return $response;
    }

    /**
     * 统一公众号配置查询     支持沙箱
     * https://open.yeepay.com/docs/retail000001/rest__v1.0__router__open-pay-jsapi-config__query.html
     * @param $params
     * [
     *      'merchantNo'=>'10015386847',
     *      'appId'=>'appId',
     *      'channelIds    '=>'渠道号集合',
     *      'senceType'=>'场景',
     * ]
     * @return Lib\YopResponse|mixed
     */
    public static function payJsapiConfigQuery($params)
    {
        $request=new YopRequest();
        foreach ($params as $key=>$value) {
            $request->addParam($key, $value);
        }
        $response=YopClient3::post(UriUtils::OpenPayJsApiConfigQuery, $request);
        return $response;
    }


    /**
     * 聚合报备——报备服务
     * https://open.yeepay.com/docs/retail000001/rest__v1.0__router__open-pay-async-report__report.html
     * @param $params
     * [
     *      'merchantNo'=>'10015386847',
     *      'appId'=>'appId',
     *      'channelIds    '=>'渠道号集合',
     *      'senceType'=>'场景',
     * ]
     * @return Lib\YopResponse|mixed
     */
    public static function openPayAsyncReport($params)
    {
        $request=new YopRequest();
        foreach ($params as $key=>$value) {
            $request->addParam($key, $value);
        }
        $response=YopClient3::post(UriUtils::OpenPayAsyncReport, $request);
        return $response;
    }


    /**
     * 代付代发--单笔出款请求     支持沙箱
     * 1、接口开通
     * https://open.yeepay.com/docs/remit001/rest__v1.0__balance__transfer_send.html
     * 2、如何获取公私钥信息（需要子商户申请）
     * https://open.yeepay.com/docs/platform_profile/export_public_key.html
     * @param $customer_number
     * @param $customer_private_key
     * @param $customer_yop_public_key
     * @param $params
     * [
     *  'batchNo'=>'',//批次号
     *  'orderId'=>'',//订单id
     *  'amount'=>'',//金额
     *  'accountName'=>'',//收款帐户的开户名称
     *  'accountNumber'=>'',//收款帐户的卡号
     *  'bankCode'=>'',//银行编码-必填
     *  'bankName'=>'',//银行名称-非必填
     *  'bankBranchName'=>'',//支行名称
     *  'feeType'=>'',//手续费方式
     *  'desc'=>'',//描述
     *  'leaveWord'=>'',//留言-给收款人银行备注，最长30
     *  'abstractInfo'=>'',
     * ]
     * @return YopResponse|mixed
     */
    public static function dfTransferToSingle($customer_number, $customer_private_key, $customer_yop_public_key, $params)
    {
        $request=new YopRequest("OPR:".$customer_number, $customer_private_key, null, $customer_yop_public_key);
        /**
         * customerNumber和groupNumber都是易宝子商户的账号，每笔转账一元手续费
         */
        $request->addParam("customerNumber", $customer_number);
        $request->addParam("groupNumber", $customer_number);
        foreach ($params as $key=>$value) {
            $request->addParam($key, $value);
        }
        $response=YopClient3::post(UriUtils::DFTransferToSingle, $request);
        return $response;
    }


    /**
     * 代付代发--出款查询     支持沙箱
     * https://open.yeepay.com/docs/remit001/rest__v1.0__balance__transfer_query.html
     * @param $customer_number
     * @param $customer_private_key
     * @param $customer_yop_public_key
     * @param $params
     * [
     *  'batchNo'=>'',//必须
     *  'orderId'=>'',
     *  'product'=>'',
     *  'pageNo'=>'',//默认1
     *  'pageSize'=>'',//默认100
     * ]
     * @return YopResponse|mixed
     */
    public static function dfTransferQuery($customer_number, $customer_private_key, $customer_yop_public_key, $params)
    {
        $request=new YopRequest("OPR:".$customer_number, $customer_private_key, null, $customer_yop_public_key);
        $request->addParam("customerNumber", $customer_number);
        $request->addParam("groupNumber", $customer_number);
        foreach ($params as $key=>$value) {
            $request->addParam($key, $value);
        }
        $response=YopClient3::post(UriUtils::DFTransferQuery, $request);
        return $response;
    }


    /**
     * 获取商户余额接口     支持沙箱
     * https://open.yeepay.com/docs/retail000001/rest__v1.0__sys__merchant__balancequery.html
     * @param $params
     * [
     *      'merchantNo'=>'10015386847',
     * ]
     * @return Lib\YopResponse|mixed
     */
    public static function merchantBalanceQuery($params)
    {
        $request=new YopRequest();
        $request->addParam("parentMerchantNo", config('yop_pay.parentMerchantNo'));
        foreach ($params as $key=>$value) {
            $request->addParam($key, $value);
        }
        $response=YopClient3::post(UriUtils::MerchantBalanceQuery, $request);
        return $response;
    }


    /**
     * 获取子商户密钥接口     支持沙箱
     * @param $params
     * [
     *  'merchantNo'=>''
     * ]
     * @return YopResponse|mixed
     */
    public static function merchantHmacKeyQuery($params)
    {
        $request=new YopRequest();
        $request->addParam("parentMerchantNo", config('yop_pay.parentMerchantNo'));
        foreach ($params as $key=>$value) {
            $request->addParam($key, $value);
        }
        $response=YopClient3::post(UriUtils::QueryHmacKey, $request);
        return $response;
    }


    /**
     * 查询银行卡卡bin信息
     * @param $params
     * [
     * 'merchantNo'=>'',//子商编
     * 'hmacKey'=>'',//
     * 'bankCardNo'=>'',
     * ]
     * @return YopResponse|mixed
     */
    public static function QueryBankInfo($params)
    {
        $request=new YopRequest();
        $request->addParam("parentMerchantNo", config('yop_pay.parentMerchantNo'));
        $request->addParam("merchantNo", $params['merchantNo']);
        foreach ($params as $key=>$value) {
            $request->addParam($key, $value);
        }
        $response=YopClient3::post(UriUtils::QueryQueryBanCardBinInfo, $request);
        return $response;
    }

    /**
     * 回调验签
     * @param $responseString
     * @return bool|string
     */
    public static function callback_decrypt($responseString)
    {
        return YopSignUtils::decrypt($responseString, config('yop_pay.private_key'), config('yop_pay.yop_public_key'));
    }
}
