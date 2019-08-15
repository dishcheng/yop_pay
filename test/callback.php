<?php
 include 'conf.php';
require_once ("./lib/YopClient.php");
require_once ("./lib/YopClient3.php");
require_once ("./lib/Util/YopSignUtils.php");

//结果通知返回原文数据
function callback($source){
	 
       global $merchantno;
	   global $private_key;
	   global $yop_public_key;
    //返回的密文
    //还原出原文
    return YopSignUtils::decrypt($source,$private_key, $yop_public_key);

}

$data = $_REQUEST["response"];
//var_dump($data);
callback($data);
echo "SUCCESS"; 	
?>