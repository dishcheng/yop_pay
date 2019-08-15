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


function config(){
	
	   
	   global $parentMerchantNo;
	   global $private_key;
	   global $yop_public_key;
	     
    $request = new YopRequest("OPR:10014929805", $private_key, "https://openapi.yeepay.com/yop-center",$yop_public_key);
     
    $request->addParam("merchantNo", $_REQUEST['merchantNo']);
    $request->addParam("appId", $_REQUEST['appId']);
    $request->addParam("tradeAuthorizationDirectories", $_REQUEST['tradeAuthorizationDirectories']);
    $request->addParam("wxpMerAppId", $_REQUEST['wxpMerAppId']);
    $request->addParam("senceType", $_REQUEST['senceType']);
    $request->addParam("channelNo", $_REQUEST['merchantNo']);
   
    $response = YopClient3::post("/rest/v1.0/router/open-pay-async-report/config", $request);
	
//	  var_dump($response);
    if($response->validSign==1){
        echo "返回结果签名验证成功!\n";
    }
    //取得返回结果
    $data=object_array($response);
 
    return $data;
    
 }
  $array=config();  
  
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
<title> 公众号配置 </title>
</head>
	<body>	
		<br /> <br />
		<table width="70%" border="0" align="center" cellpadding="5" cellspacing="0" style="border:solid 1px #107929">
			<tr>
		  		<th align="center" height="30" colspan="5" bgcolor="#6BBE18">
					 公众号配置 
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
				<td width="25%" align="left">&nbsp;业务返回编码</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['bizCode'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">bizCode</td> 
			</tr>

 
			
			<tr>
				<td width="25%" align="left">&nbsp;业务返回信息</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $result['bizMsg'];?></td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">bizMsg</td> 
			</tr>
			<tr>
				<td width="25%" align="left">&nbsp;configDetail</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php print_r ($result['configDetail']);?></td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">configDetail</td> 
			</tr>
				 
 

		</table>

	</body>
</html>
