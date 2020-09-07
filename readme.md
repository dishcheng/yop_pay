# lumen+laravel易宝支付依赖

tips:测试无问题后建议锁死稳定版本，不要使用dev-master，不定期更新

# lumen
bootstrap/app.php
移动配置文件到config目录下
```php
$app->configure('yop_pay');

$app->register(DishCheng\YopPay\YopPayProvider::class);
```

## Usage
### 配置config文件
config/yop_pay.php

```php
return [
//    父商编
    'appKey'=>'OPR:xxxxxxxx',
    'parentMerchantNo' => 'xxxxxxxx',
//    //收单子商户
//    'merchantNo' => '0000000',
//    //子商户对称密钥,可调密钥获取接口获取,下单生成hmac使用
//    'hmacKey' => '00000000000000000000000',
    //父商编私钥
    "private_key"=>"MIIEowIBAAKCAQxxxxxxxQAB",//很长
    //易宝公钥
    "yop_public_key"=>"MIIBIjANxxxxxfjaorxsuwIDAQAB",//很长
    //根地址
    'serverRoot' => 'https://openapi.yeepay.com/yop-center',
    //退款通知地址
    'refundNotifyUrl'=>env('YOP_PAY_NOTIFY_URL',''),
];
```

### 下单
```php
use Carbon\Carbon;
use DishCheng\YopPay\YopPay;
/**
 * 包含中文字符的数组，转换为字符串
 */
if (!function_exists('chinese_json_encode')) {
    function chinese_json_encode(array $array)
    {
//遍历已有数组，将每个值 urlencode 一下
        foreach ($array as $key=>$value) {
            if (is_array($value)) {
                $array[$key]=chinese_json_encode($value);
            } else {
                $array[$key]=urlencode($value);
            }
        }
//用urldecode将值反解
        return urldecode(json_encode($array));
    }
}

$YBOrderData=[
       'merchantNo'=>$payConfig->merchantNo,//收单商户商编
       'orderId'=>$orderId,//商户订单号，请自定义
       'hmacKey'=>$payConfig->hmacKey,//收单商户密钥

       'orderAmount'=> 0.03,//单位：元， 需保留到小数点后两位， 最低 0.02(有可能需要分账)
       'timeoutExpress'=>900,//订单有效期	, 默认72小时， 最小1秒， 最大5年,
       'timeoutExpressType'=>'SECOND',//订单过期时间类型	枚举：SECOND("秒"), MINUTE("分"), HOUR("时"), DAY("天")
       'requestDate'=>Carbon::now()->toDateTimeString(),//请求时间,请求时间，用于计算订单有效期， 格式 yyyy-MM-dd HH:mm:ss， 不传默认为易宝接收到请求的时间
       'notifyUrl'=>config('yop_pay.notifyUrl'),//服务器通知地址
       'goodsParamExt'=>chinese_json_encode(['goodsName'=>'产品名称']),//商品拓展信息,业务上是必须参数， Json 格式， key 支持 goodsName （必填） 、 goodsDesc
 ];

 $submit_order=YopPay::createOrder($YBOrderData);
if ($submit_order->state!='SUCCESS') {
    throw new \Exception('xxxxx');
}
if ($submit_order->result->code!='OPR00000') {
    //每个接口返回码都不一样
    throw new \Exception('xxxxx');
}

```
