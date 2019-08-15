<?php	
include 'conf.php';
require_once ("./lib/YopClient3.php");
require_once ("./lib/Util/YopSignUtils.php"); 
 
$data=array();
$data['parentMerchantNo']=$parentMerchantNo;
$data['merchantNo']=$merchantNo;
$data['orderId']=$_REQUEST['orderId'];
$data['orderAmount']=$_REQUEST['orderAmount'];
$data['notifyUrl']=$_REQUEST['notifyUrl'];
 
$hmacstr = hash_hmac('sha256', toString($data), $hmacKey, true);
$hmac = bin2hex($hmacstr);
 
 #将参数转换成k=v拼接的形式
function toString($arraydata){
        $Str="";
        foreach ($arraydata as $k=>$v){
           $Str .= strlen($Str) == 0 ? "" : "&";
            $Str.=$k."=".$v;
        }
        return $Str;
    }

function object_array($array) { 
    if(is_object($array)) { 
        $array = (array)$array; 
     } if(is_array($array)) { 
         foreach($array as $key=>$value) { 
             $array[$key] = object_array($value); 
             } 
     } 
     return $array; 
}

function order($hmac){
	
	   
	   global $merchantNo;
	   global $parentMerchantNo;
	   global $private_key;
	   global $yop_public_key;
	     
    $request = new YopRequest("OPR:10027426365", $private_key, "https://openapi.yeepay.com/yop-center",$yop_public_key);
    $request->addParam("parentMerchantNo", $parentMerchantNo);
    $request->addParam("merchantNo", $merchantNo);
    $request->addParam("orderId", $_REQUEST['orderId']);
    $request->addParam("orderAmount", $_REQUEST['orderAmount']);
    $request->addParam("timeoutExpress", $_REQUEST['timeoutExpress']);
	    $request->addParam("timeoutExpressType", "HOUR");
    $request->addParam("requestDate", $_REQUEST['requestDate']);
 // $request->addParam("redirectUrl", $_REQUEST['redirectUrl']);
    $request->addParam("notifyUrl", $_REQUEST['notifyUrl']);
    $request->addParam("goodsParamExt", $_REQUEST['goodsParamExt']);
   // $request->addParam("paymentParamExt", $_REQUEST['paymentParamExt']);
    $request->addParam("industryParamExt", $_REQUEST['industryParamExt']);
    $request->addParam("memo", $_REQUEST['memo']);
	 $request->addParam("hmac", $hmac);
    $request->addParam("riskParamExt", $_REQUEST['riskParamExt']);
    $request->addParam("csUrl", $_REQUEST['csUrl']);
    $request->addParam("fundProcessType", $_REQUEST['fundProcessType']);
	$request->addParam("divideDetail", $_REQUEST['divideDetail']);
	$request->addParam("divideNotifyUrl", $_REQUEST['divideNotifyUrl']);
	$request->addParam("timeoutNotifyUrl", $_REQUEST['timeoutNotifyUrl']);
  $request->addParam("payTool", $_REQUEST['payTool']);
    $request->addParam("payType", $_REQUEST['payType']);
    
    $request->addParam("appId", $_REQUEST['appId']);
    $request->addParam("openId", $_REQUEST['openId']);
    $request->addParam("payEmpowerNo", $_REQUEST['payEmpowerNo']);
    $request->addParam("merchantTerminalId", $_REQUEST['merchantTerminalId']);
    $request->addParam("merchantStoreNo", $_REQUEST['merchantStoreNo']);
    $request->addParam("userIp", $_REQUEST['userIp']);
    $request->addParam("extParamMap", $_REQUEST['extParamMap']);

   
    
    $response = YopClient3::post("/rest/v1.0/nccashierapi/api/orderpay", $request);
	    var_dump($response);
   
  
}

 order($hmac);
 
?>

 