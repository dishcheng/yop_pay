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
	
	$request->addParam("hmac", $hmac);
   
    
    $response = YopClient3::post("/rest/v1.0/sys/trade/order", $request);
	//    var_dump($response);
    if($response->validSign==1){
    //取得返回结果
    $data=object_array($response);}
	
    $token=$data['result']['token'];
	//echo  $token;
    return $token ;
  
}

function APIorder($token){
	
	   
	   global $merchantNo;
	   global $parentMerchantNo;
	   global $private_key;
	   global $yop_public_key;
	     
    $request = new YopRequest("OPR:10014929805", $private_key, "https://openapi.yeepay.com/yop-center",$yop_public_key); 
    $request->addParam("token", $token);
    $request->addParam("payTool", $_REQUEST['payTool']);
    $request->addParam("payType", $_REQUEST['payType']);
    $request->addParam("userNo", $_REQUEST['userNo']);
    $request->addParam("userType", $_REQUEST['userType']);
    $request->addParam("appId", $_REQUEST['appId']);
    $request->addParam("openId", $_REQUEST['openId']);
    $request->addParam("payEmpowerNo", $_REQUEST['payEmpowerNo']);
    $request->addParam("merchantTerminalId", $_REQUEST['merchantTerminalId']);
    $request->addParam("merchantStoreNo", $_REQUEST['merchantStoreNo']);
    $request->addParam("userIp", $_REQUEST['userIp']);
    $request->addParam("version", $_REQUEST['version']);
 
     //var_dump($request);
    
    $response = YopClient3::post("/rest/v1.0/nccashierapi/api/pay", $request);
    if($response->validSign==1){
         echo "返回结果签名验证成功!\n";
    }
    //取得返回结果
    $data=object_array($response);
    return $data ;  
}
$gettoken=order($hmac);
 
$array=APIorder($gettoken);
 if( $array['result'] == NULL)
 {
 	echo "error:".$array['error'];
  return;}
 else{
 $result= $array['result'] ;
 // var_dump($result);
}
?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>API收银台URL</title>
</head>
	<body>	
		<br /> <br />
		<table width="70%" border="0" align="center" cellpadding="5" cellspacing="0" style="border:solid 1px #107929">
			<tr>
		  		<th align="center" height="30" colspan="5" bgcolor="#6BBE18">
					API收银台URL
				</th>
		  	</tr>

				<tr >
				<td width="25%" align="left">&nbsp;请求返回码</td>
				<td width="5%"  align="center"> : </td> 
				<td width="45"  align="left"> <?php echo $result['code'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">code</td> 
			</tr>

			<tr>
				<td width="25%" align="left">&nbsp;请求返回信息</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['message'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">message</td> 
			</tr>
			
						
			<tr>
				<td width="25%" align="left">&nbsp;商户编号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['merchantNo'];?></td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">merchantNo</td> 
			</tr>
			<tr>
				<td width="25%" align="left">&nbsp;支付工具</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['payTool'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">payTool</td> 
			</tr>

 
			
			<tr>
				<td width="25%" align="left">&nbsp;支付类型</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['payType'];?></td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">payType</td> 
			</tr>
			<tr>
				<td width="25%" align="left">&nbsp;订单token</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['token'];?></td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">token</td> 
			</tr>

			
			 

			
			<tr>
				<td width="25%" align="left">&nbsp;返回支付数据类型</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['resultType'];?></td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">resultType</td> 
			</tr>
		<tr>
				<td width="25%" align="left">&nbsp;支付数据</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['resultData'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">resultData</td> 
			</tr>
			 
		</table>

	</body>
</html>