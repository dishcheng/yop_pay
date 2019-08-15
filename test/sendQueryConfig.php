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


function queryconfig(){
	
	   
	   global $parentMerchantNo;
	   global $private_key;
	   global $yop_public_key;
	     
    $request = new YopRequest("OPR:10014929805", $private_key, "https://openapi.yeepay.com/yop-center",$yop_public_key);
     
    $request->addParam("merchantNo", $_REQUEST['merchantNo']);
    $request->addParam("sceneType", $_REQUEST['sceneType']);
    $request->addParam("channelIds", $_REQUEST['channelIds']);
    $request->addParam("appId", $_REQUEST['appId']);
    $response = YopClient3::post("/rest/v1.0/router/open-pay-jsapi-config/query", $request);
	
	var_dump($response);
    if($response->validSign==1){
        echo "返回结果签名验证成功!\n";
    }
    //取得返回结果
    $data=object_array($response);
 
    return $data;
    
 }
  $array=queryconfig();  
  
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
<title> 公众号配置结果</title>
</head>
	<body>	
		<br /> <br />
		<table width="70%" border="0" align="center" cellpadding="5" cellspacing="0" style="border:solid 1px #107929">
			<tr>
		  		<th align="center" height="30" colspan="5" bgcolor="#6BBE18">
					 公众号配置查询结果
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
				<td width="25%" align="left">&nbsp;公众号配置查询结果列表</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php print_r ($result['jsapiConfigDTOList']);?></td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">jsapiConfigDTOList</td> 
			</tr>
				 
 

		</table>

	</body>
</html>
