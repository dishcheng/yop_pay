<?php	
include 'conf.php';
require_once ("./lib/YopClient3.php");
require_once ("./lib/Util/YopSignUtils.php"); 


function bill(){
	
	   
 
	   global $parentMerchantNo;
	   global $private_key;
	   global $yop_public_key;
	 


    $request = new YopRequest("OPR:10014929805", $private_key, "","https://openapi.yeepay.com/yop-center",$yop_public_key);
    
    $request->addParam("merchantNo", $_REQUEST['merchantNo']);
    $request->addParam("dataType", "trade");
    $request->addParam("dayString",  $_REQUEST['date']);
    $response = YopClient3::get("/yos/v1.0/std/bill/tradedaydownload", $request);

    return $response;
}

$array=bill();
    

?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>对账结果</title>
</head>
	<body>	
		<br /> <br />
		<table width="90%" border="0" align="center" cellpadding="5" cellspacing="0" style="border:solid 1px #107929">
			<tr>
		  		<th align="center" height="30" colspan="5" bgcolor="#6BBE18">
                    对账结果
				</th>
		  	</tr>

				<tr >
				<td width="100"  align="left"> <?php  echo $array;?> </td>
			</tr>


		</table>

	</body>
</html>