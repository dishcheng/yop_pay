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


  
function  getUrl($response,$private_key)
    {
       $content=toString($response);
       $sign=YopSignUtils::signRsa($content,$private_key);
       $url=$content."&sign=".$sign;
       return  $url;
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
	     
    $request = new YopRequest("OPR:10014929805", $private_key, "https://openapi.yeepay.com/yop-center",$yop_public_key);
    $request->addParam("parentMerchantNo", $parentMerchantNo);
    $request->addParam("merchantNo", $merchantNo);
    $request->addParam("orderId", $_REQUEST['orderId']);
    $request->addParam("orderAmount", $_REQUEST['orderAmount']);
    $request->addParam("timeoutExpress", $_REQUEST['timeoutExpress']);
    $request->addParam("requestDate", $_REQUEST['requestDate']);
    $request->addParam("redirectUrl", $_REQUEST['redirectUrl']);
    $request->addParam("notifyUrl", $_REQUEST['notifyUrl']);
    $request->addParam("goodsParamExt", $_REQUEST['goodsParamExt']);
    $request->addParam("paymentParamExt", $_REQUEST['paymentParamExt']);
    $request->addParam("industryParamExt", $_REQUEST['industryParamExt']);
    $request->addParam("memo", $_REQUEST['memo']);
    $request->addParam("riskParamExt", $_REQUEST['riskParamExt']);
    $request->addParam("csUrl", $_REQUEST['csUrl']);
    $request->addParam("fundProcessType", $_REQUEST['fundProcessType']);
	$request->addParam("divideDetail", $_REQUEST['divideDetail']);
	$request->addParam("divideNotifyUrl", $_REQUEST['divideNotifyUrl']);
	
	$request->addParam("hmac",$hmac); 
    
    
    $response = YopClient3::post("/rest/v1.0/sys/trade/order", $request);
	 var_dump(  $response);
    if($response->validSign==1){
         echo "返回结果签名验证成功!\n";
    }
    //取得返回结果
    $data=object_array($response);
     
//     echo  $token;
    $token=$data['result']['token'];
    $cashter = array(
        "merchantNo" => $parentMerchantNo,
        "token" => $token,
        "timestamp" => $_REQUEST['timestamp'],
        "directPayType" => $_REQUEST['directPayType'],
        "cardType" => $_REQUEST['cardType'],
        "userNo" => $_REQUEST['userNo'],
        "userType" => $_REQUEST['userType'],
        "ext" => $_REQUEST['ext'],
    ); 
    
    $getUrl = getUrl($cashter, $private_key);   
    $getUrl=str_replace("&timestamp","&amp;timestamp",$getUrl);
	// print_r($getUrl );
    $url = "https://cash.yeepay.com/cashier/std?" . $getUrl;
    
    return $url ;
  
}

$payurl=order($hmac);
 
?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title> 订单支付URL</title>
</head>
	<body>	
		<br /> <br />
		<table width="70%" border="0" align="center" cellpadding="5" cellspacing="0" style="border:solid 1px #107929">
			<tr>
		  		<th align="center" height="30" colspan="5" bgcolor="#6BBE18">
				订单支付URL
				</th>
		  	</tr>
     
			<tr >
				<td width="25%" align="left">&nbsp;URL</td>
				<td width="5%"  align="center"> : </td> 
				<td width="45"  align="left"><a href="<?php echo $payurl ;?>"><?php echo  $payurl ;?></a>   </td>
				  
			</tr>

			
		</table>

	</body>
</html>