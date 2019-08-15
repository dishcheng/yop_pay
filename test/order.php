<?php

date_default_timezone_set('Asia/Shanghai');
$orderId = "DS" . date("ymd_His") . rand(10, 99);

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
		  	<td colspan="2" bgcolor="#CEE7BD">订单创建接口</td>
		  </tr>

			<form method="post" action="sendOrder.php" targe="_blank">
		  <tr>
		  	<td align="left">&nbsp;&nbsp;商户订单号</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="orderId" id="orderId"  value="<?php echo $orderId ?>"/>
      	&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td></tr>
      		
      				  <tr>
		  	<td align="left">&nbsp;&nbsp;订单金额</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="orderAmount" id="orderAmount"  value=""/>
      	&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td></tr>
		       				  <tr>
		  	<td align="left">&nbsp;&nbsp;订单有效期</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="timeoutExpress" id="timeoutExpress"  value=""/>
      	&nbsp; </td></tr>
		  	 <tr>
		  	<td align="left">&nbsp;&nbsp;请求时间</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="requestDate" id="requestDate"  value="<?php echo date("Y-m-d H:i:s",time())  ?>"/> 
		  		&nbsp; </td></tr>
     
		    <tr>
		  	<td align="left">&nbsp;&nbsp;页面回调地址</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="redirectUrl" id="redirectUrl"  value=""/>
      	&nbsp; </td></tr>
		  <tr>
		  	<td align="left">&nbsp;&nbsp;服务器回调地址</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="notifyUrl" id="notifyUrl"  value="http://10.151.31.134/test/yop-ds/callback.php"/>
      	&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td></tr>
		  <tr>
		  	<td align="left">&nbsp;&nbsp;商品信息</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="goodsParamExt" id="goodsParamExt" value='{"goodsName":"测试","goodsDesc":"123456"}' />		  		
		  		&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td>
      </tr>
	   <tr>
		  	<td align="left">&nbsp;&nbsp;支付扩展参数</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="paymentParamExt" id="paymentParamExt"  value="{}"/> 
		  	 		&nbsp; </td>
      </tr>
		  <tr>
		  	<td align="left">&nbsp;&nbsp;行业扩展参数</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="industryParamExt" id="industryParamExt"  value=""/>
      	&nbsp; </td></tr>

		 <tr>
		  	<td align="left">&nbsp;&nbsp;自定义对账备注</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="memo" id="memo"  value=""/> 
		  		&nbsp; </td></tr>
     
	  <tr>
		  	<td align="left">&nbsp;&nbsp;风控信息</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="riskParamExt" id="riskParamExt"  value=""/></td>
      </tr>
	   
	   <tr>
		  	<td align="left">&nbsp;&nbsp;清算成功回调地址</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="csUrl" id="csUrl"  value=""/></td>
      </tr>
    	   <tr>
		  	<td align="left">&nbsp;&nbsp;资金处理类型</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="fundProcessType" id="fundProcessType"  value="REAL_TIME"/></td>
      </tr>
	    	   <tr>
		  	<td align="left">&nbsp;&nbsp;分账明细</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="divideDetail" id="divideDetail"  value=""/></td>
      </tr>
	    	   <tr>
		  	<td align="left">&nbsp;&nbsp;分账回调地址</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="divideNotifyUrl" id="divideNotifyUrl"  value=""/></td>
      </tr>
	  
      <tr>
		  	<td align="center"> </td>
		  	 <td align="left">&nbsp;&nbsp;<font color="red">以下为标准收银台URL拼接参数</font></td>
      </tr>
      
      	  	   <tr>
		  	<td align="left">&nbsp;&nbsp;订单时间戳</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="timestamp" id="timestamp"  value="<?php echo time(); ?>"/></td>
      </tr>
      
		  	   <tr>
		  	<td align="left">&nbsp;&nbsp;直连参数</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="directPayType" id="directPayType"  value=""/></td>
      </tr>
 
		  
		  	   <tr>
		  	<td align="left">&nbsp;&nbsp;卡种</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="cardType" id="cardType"  value=""/></td>
      </tr>
 
		  		  <tr>
		  	<td align="left">&nbsp;&nbsp;用户标识</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="userNo" id="userNo" value="" />		  		
		  		&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td>
      </tr>
      		  <tr>
		  	<td align="left">&nbsp;&nbsp;用户表示类型</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="userType" id="userType" value="" />		  		
		  		&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td>
      </tr>
		  	   <tr>
		  	<td align="left">&nbsp;&nbsp;扩展字段</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="ext" id="ext"  value=""/></td>
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
