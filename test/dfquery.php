<?php	
include 'conf.php';
require_once ("./lib/YopClient3.php");
 


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



function balancequery(){
   
	 global $merchantNo;
     global $parentMerchantNo;
	 global $private_key;
	 global $yop_public_key;
	     
    $request = new YopRequest("OPR:10014929805", $private_key, "https://openapi.yeepay.com/yop-center",$yop_public_key);
     
  //  $request->addParam("groupNumber", $parentMerchantNo);
    $request->addParam("customerNumber", $merchantNo);
   
 
    $response = YopClient3::post("/rest/v1.0/balance/yop-group-remit/query-customer-amount", $request);
    var_dump($response);
    if($response->validSign==1){
        echo "返回结果签名验证成功!\n";
    }
    //取得返回结果
    $data=object_array($response);
    
    return $data;
    
 }
  $array=balancequery();  
   
 if( $array['result'] == NULL)
 {
 	echo "error:".$array['error'];
  return;}
 else{
 $result= $array['result'] ;
  
}
?> 


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title> 余额查询--返回参数 </title>
</head>
	<body>	
		<br /> <br />
		<table width="70%" border="0" align="center" cellpadding="5" cellspacing="0" style="border:solid 1px #107929">
			<tr>
		  		<th align="center" height="30" colspan="5" bgcolor="#6BBE18">
					余额查询--返回参数 
				</th>
		  	</tr>
           <tr >
				<td width="25%" align="left">&nbsp;请求返回码</td>
				<td width="5%"  align="center"> : </td> 
				<td width="45"  align="left"> <?php echo $result['returnCode'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">returnCode</td> 
			</tr>

			<tr>
				<td width="25%" align="left">&nbsp;请求返回信息</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo  $result['returnMsg'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">returnMsg</td> 
			</tr>
 
            <tr >
				<td width="25%" align="left">&nbsp;商户账户余额</td>
				<td width="5%"  align="center"> : </td> 
				<td width="45"  align="left"> <?php echo $result['merBalance'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">merBalance</td> 
			</tr>

			 
		</table>

	</body>
</html>