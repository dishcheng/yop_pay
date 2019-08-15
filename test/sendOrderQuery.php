<?php	
include 'conf.php';
require_once ("./lib/YopClient3.php");
$data=array();
$data['parentMerchantNo']=$parentMerchantNo;
$data['merchantNo']=$merchantNo;
$data['orderId']=$_REQUEST['orderId'];
$data['uniqueOrderNo']=$_REQUEST['uniqueOrderNo'];
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

 
function orderQuery($hmac){
       global $merchantNo;
	   global $parentMerchantNo;
	   global $private_key;
	   global $yop_public_key;
	   
    $request = new YopRequest("OPR:10014929805", $private_key, "https://openapi.yeepay.com/yop-center",$yop_public_key);
    $request->addParam("parentMerchantNo", $parentMerchantNo);
    $request->addParam("merchantNo", $merchantNo);
    $request->addParam("orderId", $_REQUEST['orderId']);
    $request->addParam("uniqueOrderNo", $_REQUEST['uniqueOrderNo']);	
	$request->addParam("hmac",$hmac);
	//print_r($request);
    $response = YopClient3::post("/rest/v1.0/sys/trade/orderquery", $request);
    if($response->validSign==1){
        echo "返回结果签名验证成功!\n";
    }
    //取得返回结果
    $data=object_array($response);
    
    return $data;    
 }
  $array=orderQuery($hmac);  
  
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
<title>订单查询结果</title>
</head>
	<body>	
		<br /> <br />
		<table width="70%" border="0" align="center" cellpadding="5" cellspacing="0" style="border:solid 1px #107929">
			<tr>
		  		<th align="center" height="30" colspan="5" bgcolor="#6BBE18">
					订单查询结果
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
			<tr>
				<td width="25%" align="left">&nbsp;商户订单号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['orderId'];?></td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">orderId</td> 
			</tr>
			
						
			<tr>
				<td width="25%" align="left">&nbsp;易宝流水号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['uniqueOrderNo'];?></td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">uniqueOrderNo</td> 
			</tr>
			
			 

			
			<tr>
				<td width="25%" align="left">&nbsp;订单状态</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['status'];?></td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">status</td> 
			</tr>
		<tr>
				<td width="25%" align="left">&nbsp;订单金额</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['orderAmount'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">orderAmount</td> 
			</tr>
					<tr>
				<td width="25%" align="left">&nbsp;实付金额</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['payAmount'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">payAmount</td> 
			</tr>
	 

			<tr>
				<td width="25%" align="left">&nbsp;用户手续费</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['customerFee']?>  </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">customerFee</td> 
			</tr> 

			<tr>
				<td width="25%" align="left">&nbsp;商户手续费</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['merchantFee'];?>  </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">merchantFee</td> 
			</tr>

		<tr>
				<td width="25%" align="left">&nbsp;请求时间</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['bankcode'];?>  </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">bankcode</td> 
			</tr>

		<tr>
				<td width="25%" align="left">&nbsp;交易成功时间</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['requestDate'];?>  </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">requestDate</td> 
			</tr>
			
 
			<tr>
				<td width="25%" align="left">&nbsp;支付时间</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['paySuccessDate'];?>  </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">paySuccessDate</td> 
			</tr>


			<tr>
				<td width="25%" align="left">&nbsp;商品名称</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo  $result['goodsParamExt'];?>  </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">goodsParamExt</td> 
			</tr> 
			
			
					<tr>
				<td width="25%" align="left">&nbsp;自定义对账备注</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo  $result['memo'];?>  </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">memo</td> 
			</tr>
			
			
					<tr>
				<td width="25%" align="left">&nbsp;TOKEN</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo  $result['token'];?>  </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">token</td> 
			</tr>
			
			
					<tr>
				<td width="25%" align="left">&nbsp;分期期数</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo  $result['instNumber'];?>  </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">instNumber</td> 
			</tr>
			
					<tr>
				<td width="25%" align="left">&nbsp;分期公司</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo  $result['instCompany'];?>  </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">instCompany</td> 
			</tr>
			
					<tr>
				<td width="25%" align="left">&nbsp;行业扩展参数</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo  $result['industryParamExt'];?>  </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">industryParamExt</td> 
			</tr>
 

		</table>

	</body>
</html>