<?php

date_default_timezone_set('Asia/Shanghai');
$divideRequestId = "DS" . date("ymd_His") . rand(10, 99);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #107929">
		  <tr>
		    <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1">
		  </tr>
		 
		 
		  <tr>
		  	<td colspan="2" bgcolor="#CEE7BD">分账接口</td>
		  </tr>

			<form method="post" action="sendDivide.php" targe="_blank">
		  <tr>
		  	<td align="left">&nbsp;&nbsp;商户分账请求号</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="divideRequestId" id="divideRequestId"  value="<?php echo $divideRequestId ?>"/>
      	&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td></tr>
      		
      				  <tr>
		  	<td align="left">&nbsp;&nbsp;商户订单号</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="orderId" id="orderId"  value=""/>
      	&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td></tr>
		       				  <tr>
		  	<td align="left">&nbsp;&nbsp;易宝统一订单号</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="uniqueOrderNo" id="uniqueOrderNo"  value=""/>
      	 &nbsp;<span style="color:#FF0000;font-weight:100;">*</span> </td></tr>
		  	 <tr>
		  	<td align="left">&nbsp;&nbsp;分账详情</td>
		  	<td align="left">&nbsp;&nbsp;<textarea id="divideDetail" style="width: 70%;" name="divideDetail" rows="5"  >[{"ledgerNo":"10015004197","ledgerName":"测试","amount":"0.01"}]</textarea>
		  		  &nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td></tr>
     
		    <tr>
		  	<td align="left">&nbsp;&nbsp;分账账务历史拓展信息</td>
		  	<td align="left">&nbsp;&nbsp;<textarea id="infoParamExt" style="width: 70%;" name="infoParamExt" rows="5"  >{"10012426766":"{\"bizType\":\"2225\",\"historyType\":\"1115\",\"historyDesc\":\"交易分账,订单号:4445\",\"trxId\":\"3335\"}","10012426767":"{\"bizType\":\"222\",\"historyType\":\"111\",\"historyDesc\":\"交易分账,订单号:444\",\"trxId\":\"333\"}"}</textarea>
      	&nbsp; </td></tr>
		
		<tr>
		  	<td align="left">&nbsp;&nbsp;是否解冻收单商户剩余可用金额</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="isUnfreezeResidualAmount" id="isUnfreezeResidualAmount"  value=""/>
      	&nbsp; </td></tr>
		  <tr>
		  	<td align="left">&nbsp;&nbsp;合同号</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="contractNo" id="contractNo"  value=""/>
      	&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td></tr>
		 
 	  
		  
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
