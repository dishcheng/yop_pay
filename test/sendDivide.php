<?php	
include 'conf.php';
require_once ("./lib/YopClient3.php");
 
$data=array();
$data['parentMerchantNo']=$parentMerchantNo;
$data['merchantNo']=$merchantNo;
$data['orderId']=$_REQUEST['orderId'];
$data['uniqueOrderNo']=$_REQUEST['uniqueOrderNo'];
$data['divideRequestId']=$_REQUEST['divideRequestId'];
$hmacstr = hash_hmac('sha256', toString($data), $hmacKey, true);
$hmac = bin2hex($hmacstr);
 
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
 #将参数转换成k=v拼接的形式
function toString($arraydata){
        $Str="";
        foreach ($arraydata as $k=>$v){
           $Str .= strlen($Str) == 0 ? "" : "&";
            $Str.=$k."=".$v;
        }
        return $Str;
    }


function divide($hmac){
       global $merchantNo;
       global $parentMerchantNo;
	   global $private_key;
	   global $yop_public_key;
	     
    $request = new YopRequest("OPR:10014929805", $private_key, "https://openapi.yeepay.com/yop-center",$yop_public_key);
    $request->addParam("parentMerchantNo", $parentMerchantNo);
    $request->addParam("merchantNo", $merchantNo);
    $request->addParam("divideRequestId", $_REQUEST['divideRequestId']);
    $request->addParam("orderId", $_REQUEST['orderId']);
    $request->addParam("uniqueOrderNo", $_REQUEST['uniqueOrderNo']); 
    $request->addParam("divideDetail", $_REQUEST['divideDetail']);
    $request->addParam("infoParamExt", $_REQUEST['infoParamExt']);
	 $request->addParam("isUnfreezeResidualAmount", $_REQUEST['isUnfreezeResidualAmount']);
    $request->addParam("contractNo", $_REQUEST['contractNo']);
    $request->addParam("hmac",$hmac);
 
    $response = YopClient3::post("/rest/v1.0/sys/trade/divide", $request);
    if($response->validSign==1){
        echo "返回结果签名验证成功!\n";
    }
    //取得返回结果
    $data=object_array($response);
    
    return $data;
    
 }
  $array=divide($hmac);  
  
 if( $array['result'] == NULL)
 {
 	echo "error:".$array['error'];
  return;}
 else{
 $result= $array['result'] ;
 //var_dump($result);
}
?> 


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>分账响应参数 </title>
</head>
	<body>	
		<br /> <br />
		<table width="70%" border="0" align="center" cellpadding="5" cellspacing="0" style="border:solid 1px #107929">
			<tr>
		  		<th align="center" height="30" colspan="5" bgcolor="#6BBE18">
					分账响应参数 
				</th>
		  	</tr>
	<tr >
				<td width="25%" align="left">&nbsp;返回码</td>
				<td width="5%"  align="center"> : </td> 
				<td width="45"  align="left"> <?php echo $result['code'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">code</td> 
			</tr>

			<tr>
				<td width="25%" align="left">&nbsp;返回信息</td>
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
			
			<tr >
				<td width="25%" align="left">&nbsp;商户订单号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="45"  align="left"> <?php echo $result['orderId'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">orderId</td> 
			</tr>

			<tr>
				<td width="25%" align="left">&nbsp;易宝统一订单号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['uniqueOrderNo'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">uniqueOrderNo</td> 
			</tr>

			<tr>
				<td width="25%" align="left">&nbsp;商户分账请求号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['divideRequestId'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">divideRequestId</td> 
			</tr>

		<tr>
				<td width="25%" align="left">&nbsp;分账状态</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['status'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">status</td> 
			</tr>
			
			 		<tr>
				<td width="25%" align="left">&nbsp;分账详情</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['divideDetail'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">divideDetail</td> 
			</tr>

		</table>

	</body>
</html>