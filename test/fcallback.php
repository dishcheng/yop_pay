<?php
include 'conf.php';
require_once ("./lib/YopClient3.php");
require_once ("./lib/Util/YopSignUtils.php"); 
 
$data = $_SERVER["QUERY_STRING"]; 
$sign=strstr($_REQUEST['sign'], '$', TRUE); 
$result = YopSignUtils::verifySign($data,$sign,$yop_public_key);
 
if ($result == true) {
    echo "签名验证成功"; 
    echo"<br>";
    
} else {
    Die("verifySign fail!");
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title> 页面回调 </title>
</head>
	<body>	
		<br /> <br />
		<table width="70%" border="0" align="center" cellpadding="5" cellspacing="0" style="border:solid 1px #107929">
			<tr>
		  		<th align="center" height="30" colspan="5" bgcolor="#6BBE18">
				页面回调			</th>
		  	</tr>
     
     
    
			
			
			<tr >
				<td width="25%" align="left">&nbsp;商户商编</td>
				<td width="5%"  align="center"> : </td> 
				<td width="45"  align="left"> <?php echo $_REQUEST['parentMerchantNo'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">parentMerchantNo</td> 
			</tr>
 	<tr>
				<td width="25%" align="left">&nbsp;收款商户编号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $_REQUEST['merchantNo'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">merchantNo</td> 
			</tr>
			
			<tr>
				<td width="25%" align="left">&nbsp;商户订单号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php echo $_REQUEST['orderId'];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">orderId</td> 
			</tr>

		


			
		</table>

	</body>
</html>