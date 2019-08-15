<?php	
include 'conf.php';
require_once ("./lib/YopClient3.php");
$data=array();
$data['parentMerchantNo']=$parentMerchantNo;
$data['merchantNo']=$merchantNo;
$data['startSettleDate']=$_REQUEST['startSettleDate'];
$data['endSettleDate']=$_REQUEST['endSettleDate'];
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

 
function settlementsquery($hmac){
       global $merchantNo;
	   global $parentMerchantNo;
	   global $private_key;
	   global $yop_public_key;
	   
    $request = new YopRequest("OPR:10014929805", $private_key, "https://openapi.yeepay.com/yop-center",$yop_public_key);
    $request->addParam("parentMerchantNo", $parentMerchantNo);
    $request->addParam("merchantNo", $merchantNo);
    $request->addParam("startSettleDate", $_REQUEST['startSettleDate']);
    $request->addParam("endSettleDate", $_REQUEST['endSettleDate']);	
	$request->addParam("hmac",$hmac);
	//print_r($request);
    $response = YopClient3::post("/rest/v1.0/sys/trade/settlementsquery", $request);
    if($response->validSign==1){
        echo "返回结果签名验证成功!\n";
    }
    //取得返回结果
    $data=object_array($response);
    
    return $data;    
 }
  $array=settlementsquery($hmac);  
  
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
<title> 结算历史查询结果</title>
</head>
	<body>	
		<br /> <br />
		<table width="70%" border="0" align="center" cellpadding="5" cellspacing="0" style="border:solid 1px #107929">
			<tr>
		  		<th align="center" height="30" colspan="5" bgcolor="#6BBE18">
					 结算历史查询查询结果
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
				<td width="25%" align="left">&nbsp;主商户编号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['parentMerchantNo'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">parentMerchantNo</td> 
			</tr>
			
			<tr>
				<td width="25%" align="left">&nbsp;商户编号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['merchantNo'];?></td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">merchantNo</td> 
			</tr>
			<tr>
				<td width="25%" align="left">&nbsp;结算处理开始日期</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['startSettleDate'];?></td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">startSettleDate</td> 
			</tr>
			
						
			<tr>
				<td width="25%" align="left">&nbsp;结算处理截至日期</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['endSettleDate'];?></td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">endSettleDate</td> 
			</tr>
			 
			
					<tr>
				<td width="25%" align="left">&nbsp;结束历史数据</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left">  <textarea cols="70" rows="5">  <?php  if (empty($result['settleRecordList'])) {echo "";} else {echo preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", json_encode($result['settleRecordList'])), "\n";  }?>  </textarea> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">settleRecordList</td> 
			</tr>
 

		</table>

	</body>
</html>