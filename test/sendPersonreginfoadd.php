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



function personreginfoadd(){
      
     global $parentMerchantNo;
	   global $private_key;
	   global $yop_public_key;
	     
    $request = new YopRequest("OPR:10014929805", $private_key, "https://openapi.yeepay.com/yop-center",$yop_public_key);
     
    $request->addParam("parentMerchantNo", $parentMerchantNo);
    $request->addParam("requestNo", $_REQUEST['requestNo']);
    $request->addParam("merShortName", $_REQUEST['merShortName']);
    $request->addParam("legalName", $_REQUEST['legalName']); 
    $request->addParam("legalIdCard", $_REQUEST['legalIdCard']);
    $request->addParam("merLegalPhone", $_REQUEST['merLegalPhone']);
    $request->addParam("merLegalEmail", $_REQUEST['merLegalEmail']);
    $request->addParam("merLevel1No", $_REQUEST['merLevel1No']);
    $request->addParam("merLevel2No", $_REQUEST['merLevel2No']);
    $request->addParam("merProvince", $_REQUEST['merProvince']);
    $request->addParam("merCity", $_REQUEST['merCity']);
    $request->addParam("merDistrict", $_REQUEST['merDistrict']);
    $request->addParam("merAddress", $_REQUEST['merAddress']); 
    $request->addParam("merScope", $_REQUEST['merScope']);
    $request->addParam("cardNo", $_REQUEST['cardNo']);
    $request->addParam("headBankCode", $_REQUEST['headBankCode']);
    $request->addParam("bankCode", $_REQUEST['bankCode']);
    $request->addParam("bankProvince", $_REQUEST['bankProvince']);
    $request->addParam("bankCity", $_REQUEST['bankCity']);
    $request->addParam("productInfo", $_REQUEST['productInfo']);
    $request->addParam("fileInfo", $_REQUEST['fileInfo']);            
    $request->addParam("businessFunction", $_REQUEST['businessFunction']);
    $request->addParam("notifyUrl", $_REQUEST['notifyUrl']);
    $request->addParam("merAuthorizeType", $_REQUEST['merAuthorizeType']);
 
 
 
    $response = YopClient3::post("/rest/v1.0/sys/merchant/personreginfoadd", $request);
    if($response->validSign==1){
        echo "返回结果签名验证成功!\n";
    }
    //取得返回结果
    $data=object_array($response);
    
    return $data;
    
 }
  $array=personreginfoadd();  
   
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
<title> 个人注册--返回参数 </title>
</head>
	<body>	
		<br /> <br />
		<table width="70%" border="0" align="center" cellpadding="5" cellspacing="0" style="border:solid 1px #107929">
			<tr>
		  		<th align="center" height="30" colspan="5" bgcolor="#6BBE18">
					个人注册--返回参数 
				</th>
		  	</tr>
	<tr >
				<td width="25%" align="left">&nbsp;返回码</td>
				<td width="5%"  align="center"> : </td> 
				<td width="45"  align="left"> <?php echo $result['returnCode'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">returnCode</td> 
			</tr>

			<tr>
				<td width="25%" align="left">&nbsp;返回信息</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['returnMsg'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">returnMsg</td> 
			</tr>
 
 
			
			<tr>
				<td width="25%" align="left">&nbsp;代理商编号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['parentMerchantNo'];?></td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">parentMerchantNo</td> 
			</tr>
			
			<tr >
				<td width="25%" align="left">&nbsp;商户编号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="45"  align="left"> <?php echo $result['merchantNo'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">merchantNo</td> 
			</tr>

			<tr>
				<td width="25%" align="left">&nbsp;入网请求号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['requestNo'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">requestNo</td> 
			</tr>

			<tr>
				<td width="25%" align="left">&nbsp;内部流水号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['externalId'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">externalId</td> 
			</tr>

		<tr>
				<td width="25%" align="left">&nbsp;协议内容</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['agreementContent'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">agreementContent</td> 
			</tr>
			
			 

		</table>

	</body>
</html>