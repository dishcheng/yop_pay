<?php	
include 'conf.php';
require_once ("./lib/YopRsaClient.php");
 
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


 
function upload(){
	
	   
 
	   global $parentMerchantNo;
	   global $private_key;
	   global $yop_public_key;
	     
       $request = new YopRequest("OPR:10014929805", $private_key,"https://open.yeepay.com/yop-center",$yop_public_key);
  
     //  $request->addParam("fileType", "IMAGE");
      $request->addFile("merQual", $_REQUEST['fileURI']);
var_dump($request );

//提交Post请求

 
$response = YopRsaClient::upload("/yos/v1.0/sys/merchant/qual/upload", $request);
 
  var_dump($response );
 
	      if($response->validSign==1){
        echo "返回结果签名验证成功!\n";
    }
      //取得返回结果
    $data=object_array($response);
 
    return $data;
 }
   
$array=upload();  
  
 if( $array['result'] == NULL)
 {
 	echo "error:".$array['error'];
  return;}
 else{
 $result= $array['result'] ;
 //var_dump($result['files'][0]);
}
?> 
 