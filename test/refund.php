<?php

date_default_timezone_set('Asia/Shanghai');
$refundRequestId = "DS" . date("ymd_His") . rand(10, 99);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #107929">
		  <tr>
		    <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1">
		  </tr>
		 
		 
		  <tr>
		  	<td colspan="2" bgcolor="#CEE7BD">退款请求接口演示：</td>
		  </tr>

			<form method="post" action="sendRefund.php" targe="_blank">
		  <tr>
		  	<td align="left">&nbsp;&nbsp;原商户订单号</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="orderId" id="orderId"  value=""/>
      	&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td></tr>
		  <tr>
		  	<td align="left">&nbsp;&nbsp;易宝流水号</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="uniqueOrderNo" id="uniqueOrderNo"  value=""/>
      	&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td></tr>
		 		  <tr>
		  	<td align="left">&nbsp;&nbsp;退款请求号</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="refundRequestId" id="refundRequestId"  value="<?php echo $refundRequestId ?>"/>
      	&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td></tr>
		 
		 <tr>
		  	<td align="left">&nbsp;&nbsp;退款金额</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="refundAmount" id="refundAmount"  value=""/> 
		  		&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td></tr>
        
	     
	   <tr>
		  	<td align="left">&nbsp;&nbsp;订单退款说明</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="description" id="description"  value=""/></td>
      </tr>
		  
	   <tr>
		  	<td align="left">&nbsp;&nbsp;自定义对账备注</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="memo" id="memo"  value=""/>
      </td></tr>
      </tr>		  
		 		
		    <tr>
		  	<td align="left">&nbsp;&nbsp;退款服务器通知地址 </td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="notifyUrl" id="notifyUrl"  value=""/></td>
      </tr>
 
		     		  <tr>
		  	<td align="left">&nbsp;&nbsp;分账退款明细</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="accountDivided" id="accountDivided"  value=""/>
      </td></tr>
      </tr>		  
		 		
		    <tr>
		  	<td align="left">&nbsp;&nbsp;退款策略 </td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="refundStrategy" id="refundStrategy"  value=""/></td>
      </tr>
		  
		  <tr>
		  	<td align="left">&nbsp;</td>
		  	<td align="left">&nbsp;&nbsp;<input type="submit" value="submit" /></td>
      </tr>
    </form>
      <tr>
      	<td height="5" bgcolor="#6BBE18" colspan="2"></td>
      </tr>
      </table></td>
        </tr>
      </table>
	</body>
</html>
