<?php	
include 'conf.php';
require_once ("./lib/YopClient3.php");

$data=array();
$data['parentMerchantNo']=$parentMerchantNo;
$data['merchantNo']=$merchantNo;
$data['orderId']=$_REQUEST['orderId'];
$data['uniqueOrderNo']=$_REQUEST['uniqueOrderNo'];
$data['refundRequestId']=$_REQUEST['refundRequestId'];
$data['refundAmount']=$_REQUEST['refundAmount'];
  
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




function refund($hmac){
      global $merchantNo;
	   global $parentMerchantNo;
	   global $private_key;
	   global $yop_public_key;
	     
    $request = new YopRequest("OPR:10014929805", $private_key, "https://openapi.yeepay.com/yop-center",$yop_public_key);
    $request->addParam("parentMerchantNo", $parentMerchantNo);
    $request->addParam("merchantNo", $merchantNo);
    $request->addParam("orderId", $_REQUEST['orderId']);
    $request->addParam("uniqueOrderNo", $_REQUEST['uniqueOrderNo']);
    $request->addParam("refundRequestId", $_REQUEST['refundRequestId']); 
    $request->addParam("refundAmount", $_REQUEST['refundAmount']);
    $request->addParam("description", $_REQUEST['description']);
    $request->addParam("memo", $_REQUEST['memo']);
	 $request->addParam("accountDivided", $_REQUEST['accountDivided']);
     $request->addParam("refundStrategy", $_REQUEST['refundStrategy']);
    $request->addParam("notifyUrl", $_REQUEST['notifyUrl']);
    $request->addParam("hmac",$hmac);
    $response = YopClient3::post("/rest/v1.0/sys/trade/refund", $request);
    if($response->validSign==1){
        echo "返回结果签名验证成功!\n";
    }
    //取得返回结果
    $data=object_array($response);
    
    return $data;
    
 }
  $array=refund($hmac);  
  
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
<title>退款请求返回参数</title>
</head>
	<body>	
		<br /> <br />
		<table width="70%" border="0" align="center" cellpadding="5" cellspacing="0" style="border:solid 1px #107929">
			<tr>
		  		<th align="center" height="30" colspan="5" bgcolor="#6BBE18">
					退款请求返回参数
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
				<td width="35%" align="left"> <?php echo $result['parentMerchantNo'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">parentMerchantNo</td> 
			</tr>

 
			
			<tr>
				<td width="25%" align="left">&nbsp;收款商户编号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['merchantNo'];?></td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">merchantNo</td> 
			</tr>
			
			<tr >
				<td width="25%" align="left">&nbsp;原商户订单号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="45"  align="left"> <?php echo $result['orderId'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">orderId</td> 
			</tr>

			<tr>
				<td width="25%" align="left">&nbsp;退款请求号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['refundRequestId'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">refundRequestId</td> 
			</tr>

			<tr>
				<td width="25%" align="left">&nbsp;易宝退款流水号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['uniqueRefundNo'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">uniqueRefundNo</td> 
			</tr>

		<tr>
				<td width="25%" align="left">&nbsp;退款金额</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['refundAmount'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">refundAmount</td> 
			</tr>
			
			<tr>
				<td width="25%" align="left">&nbsp;剩余可退款金额</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['residualAmount'];?></td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">residualAmount</td> 
			</tr>
			<tr>
				<td width="25%" align="left">&nbsp;订单退款说明</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['description'];?></td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">description</td> 
			</tr>	
 
			<tr>
				<td width="25%" align="left">&nbsp;退款请求时间</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['refundRequestDate'];?>  </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">refundRequestDate</td> 
			</tr>


			<tr>
				<td width="25%" align="left">&nbsp;退款状态</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo  $result['status'];?>  </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">status</td> 
			</tr> 

		</table>

	</body>
</html>