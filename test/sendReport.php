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



function report(){
    
       global $parentMerchantNo;
	   global $private_key;
	   global $yop_public_key;
	     
    $request = new YopRequest("OPR:10014929805", $private_key, "https://openapi.yeepay.com/yop-center",$yop_public_key);
     
    
    $request->addParam("merchantNo", $_REQUEST['merchantNo']);
    $request->addParam("channelNo", $_REQUEST['channelNo']);
    $request->addParam("callBackUrl", $_REQUEST['callBackUrl']);
    $request->addParam("channelCode", $_REQUEST['channelCode']);
    $request->addParam("merchantName", $_REQUEST['merchantName']); 
    $request->addParam("reportMerchantName", $_REQUEST['reportMerchantName']);
    $request->addParam("reportMerchantAlias", $_REQUEST['reportMerchantAlias']);
    $request->addParam("reportMerchantComment", $_REQUEST['reportMerchantComment']);
    $request->addParam("serviceTel", $_REQUEST['serviceTel']);
    $request->addParam("contactName", $_REQUEST['contactName']);
    $request->addParam("contactPhone", $_REQUEST['contactPhone']);
    $request->addParam("contactMobile", $_REQUEST['contactMobile']);
    $request->addParam("contactEmail", $_REQUEST['contactEmail']);
    $request->addParam("institutionCode", $_REQUEST['institutionCode']); 
    $request->addParam("merchantAddress", $_REQUEST['merchantAddress']);
    $request->addParam("merchantProvince", $_REQUEST['merchantProvince']);
    $request->addParam("merchantCity", $_REQUEST['merchantCity']);
    $request->addParam("merchantDistrict", $_REQUEST['merchantDistrict']);
    $request->addParam("merchantLicenseNo", $_REQUEST['merchantLicenseNo']);
    $request->addParam("corporateIdCardNo", $_REQUEST['corporateIdCardNo']);
    $request->addParam("contactType", $_REQUEST['contactType']);
    $request->addParam("reportInfosJsonStr", $_REQUEST['reportInfosJsonStr']);            
    $request->addParam("reportFeeType", $_REQUEST['reportFeeType']);
    $request->addParam("promotionType", $_REQUEST['promotionType']);
   
 
 
    $response = YopClient3::post("/rest/v1.0/router/open-pay-async-report/report", $request);
	
	
	var_dump($response);
    if($response->validSign==1){
        echo "返回结果签名验证成功!\n";
    }
    //取得返回结果
    $data=object_array($response);
    
    return $data;
    
 }
  $array=report();  
   
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
<title> 报备服务--返回参数 </title>
</head>
	<body>	
		<br /> <br />
		<table width="70%" border="0" align="center" cellpadding="5" cellspacing="0" style="border:solid 1px #107929">
			<tr>
		  		<th align="center" height="30" colspan="5" bgcolor="#6BBE18">
					报备服务--返回参数 
				</th>
		  	</tr>
	<tr >
				<td width="25%" align="left">&nbsp;路由跟踪号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="45"  align="left"> <?php echo $result['traceId'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">traceId</td> 
			</tr>

			<tr>
				<td width="25%" align="left">&nbsp;处理结果</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['dealStatus'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">dealStatus</td> 
			</tr>
 
 
			
			<tr>
				<td width="25%" align="left">&nbsp;业务返回码</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['bizCode'];?></td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">bizCode</td> 
			</tr>
			
			<tr >
				<td width="25%" align="left">&nbsp;业务返回信息</td>
				<td width="5%"  align="center"> : </td> 
				<td width="45"  align="left"> <?php echo $result['bizMsg'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">bizMsg</td> 
			</tr>

			 
			 

		</table>

	</body>
</html>