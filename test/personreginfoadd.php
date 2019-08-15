<?php
 
$requestNo = "DS" . date("ymd_His") . rand(10, 99);

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
		  	<td colspan="2" bgcolor="#CEE7BD">个人注册</td>
		  </tr>

			<form method="post" action="sendPersonreginfoadd.php" targe="_blank">
		  <tr>
		  	<td align="left">&nbsp;&nbsp;入网请求号</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="requestNo" id="requestNo"  value="<?php echo $requestNo; ?>"/>
      	&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td></tr>
      		
      				  <tr>
		  	<td align="left">&nbsp;&nbsp;商户品牌名称/简称</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="merShortName" id="merShortName"  value="测试"/>
      	&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td></tr>
		       				  <tr>
		  	<td align="left">&nbsp;&nbsp;法人姓名</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="legalName" id="legalName"  value=""/>
      	&nbsp;<span style="color:#FF0000;font-weight:100;">*</span> </td></tr>
		  	 <tr>
		  	<td align="left">&nbsp;&nbsp;法人身份证号</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="legalIdCard" id="legalIdCard"  value=""/> 
		  		&nbsp; </td></tr>
     
		    <tr>
		  	<td align="left">&nbsp;&nbsp;商户法人手机</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="merLegalPhone" id="merLegalPhone"  value=""/>
      	&nbsp; <span style="color:#FF0000;font-weight:100;">*</span></td></tr>
		  <tr>
		  	<td align="left">&nbsp;&nbsp;商户法人邮箱</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="merLegalEmail" id="merLegalEmail"  value=""/></td></tr>
		  <tr>
		  	<td align="left">&nbsp;&nbsp;商户一级分类编码</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="merLevel1No" id="merLevel1No" value="" />		  		
		  		&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td>
      </tr>
	   <tr>
		  	<td align="left">&nbsp;&nbsp;商户二级分类编码</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="merLevel2No" id="merLevel2No"  value=""/> 
		  	 		&nbsp;<span style="color:#FF0000;font-weight:100;">*</span> </td>
      </tr>
		  <tr>
		  	<td align="left">&nbsp;&nbsp;商户经营地址所在省</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="merProvince" id="merProvince"  value=""/>
      	&nbsp;<span style="color:#FF0000;font-weight:100;">*</span> </td></tr>

		 <tr>
		  	<td align="left">&nbsp;&nbsp;商户经营地址所在市</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="merCity" id="merCity"  value=""/> 
		  		&nbsp;<span style="color:#FF0000;font-weight:100;">*</span> </td></tr>
     
	  <tr>
		  	<td align="left">&nbsp;&nbsp;商户经营地址所在区</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="merDistrict" id="merDistrict"  value=""/>&nbsp;<span style="color:#FF0000;font-weight:100;">*</span> </td>
      </tr>
	   
	   <tr>
		  	<td align="left">&nbsp;&nbsp;商户经营地具体地址</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="merAddress" id="merAddress"  value=""/>&nbsp;<span style="color:#FF0000;font-weight:100;">*</span> </td>
      </tr>
 
      
       <tr>
		  	<td align="left">&nbsp;&nbsp;商户经营范围</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="merScope" id="merScope"  value=""/>&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td>
      </tr>
      
		  	   <tr>
		  	<td align="left">&nbsp;&nbsp;银行账户</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="cardNo" id="cardNo"  value=""/>&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td>
      </tr>
 
 
		  		  <tr>
		  	<td align="left">&nbsp;&nbsp;开户银行总行编码</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="headBankCode" id="headBankCode" value="" />		  		
		  		&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td>
      </tr>
      		  <tr>
		  	<td align="left">&nbsp;&nbsp;开户银行编码</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="bankCode" id="bankCode" value="" />		  		
		  		&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td>
      </tr>
		  	   <tr>
		  	<td align="left">&nbsp;&nbsp;开户省</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="bankProvince" id="bankProvince"  value=""/>	&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td>
      </tr>
 	  
 	  		  	   <tr>
		  	<td align="left">&nbsp;&nbsp;开户市</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="bankCity" id="bankCity"  value=""/>	&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td>
      </tr>
      		  	   <tr>
		  	<td align="left">&nbsp;&nbsp;开通产品</td>
		  	<td align="left">&nbsp;&nbsp;<textarea id="productInfo" style="width: 69%;" name="productInfo" rows="5"  >{"payProductMap":{"USER_SCAN_PAY":{"dsPayBankMap":{"UPOP_ATIVE_SCAN":{"rateType":"PERCENTAGE","rate":"0.48"},"ALIPAY":{"rateType":"PERCENTAGE","rate":"0.48"},"WECHAT_ATIVE_SCAN":{"rateType":"PERCENTAGE","rate":"0.48"},"JD_ATIVE_SCAN":{"rateType":"PERCENTAGE","rate":"0.48"}}},"OFFICIAL_ACCOUNT_PAY":{"dsPayBankMap":{"WECHAT_OPENID":{"rateType":"PERCENTAGE","rate":"0.48"}},"recommendOfficialAccAppId":"23424","officialAccAppId":"3234234","weChatId":"303408568","officialAccAuthorizeDirectory": "http://www.baidu.com"},"EWALLETH5":{"dsPayBankMap":{"ALIPAY_H5":{"rateType":"PERCENTAGE","rate":"0.48"}}}},"payScenarioMap":{"H5_ACCESS":{"webUrl":"http://www.jiaboyan.com"},"OFFICIAL_ACCOUNT_ACCESS":{},"WEB_ACCESS":{"webUrl":"http://www.jiaboyan.com","icp":"111111111"},"APP_ACCESS":{"appName":"jiajunAPP","appDownloadUrl":"324234111111111111111"},"FACE_TO_FACE_ACCESS":{}}} </textarea>	&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td>
      </tr>
      	  <tr>
		  	<td align="left">&nbsp;&nbsp;资质影印件</td>
		  	<td align="left">&nbsp;&nbsp;<textarea id="fileInfo" style="width: 69%;" name="fileInfo" rows="5"  > [{"quaType":"HAND_IDCARD",
"quaUrl":"http://attachment.yeepay.com/yop/201707/446ae3e115474f1e85bc91a9a444fe37.JPG"},
{"quaType":"SETTLE_BANKCARD",
"quaUrl":"http://attachment.yeepay.com/yop/201707/446ae3e115474f1e85bc91a9a444fe37.JPG"},
{"quaType":"IDCARD_BACK",
"quaUrl":"http://attachment.yeepay.com/yop/201707/446ae3e115474f1e85bc91a9a444fe37.JPG"},
{"quaType":"IDCARD_FRONT",
"quaUrl":"http://attachment.yeepay.com/yop/201707/446ae3e115474f1e85bc91a9a444fe37.JPG"}]</textarea>&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td>
      </tr>
        		  	   <tr>
		  	<td align="left">&nbsp;&nbsp;业务功能</td>
		  	<td align="left">&nbsp;&nbsp;<textarea id="businessFunction" style="width: 69%;" name="businessFunction" rows="5"  > </textarea></td>
      </tr>
		  
		  		  <tr>
		  	<td align="left">&nbsp;&nbsp;商户回调地址</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="notifyUrl" id="notifyUrl" value="http://10.151.31.134/test/yop-xtsbz/callback.php" />		  		
		  		&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td>
      </tr>
   		  		  <tr>
		  	<td align="left">&nbsp;&nbsp;授权类型</td>
		  	<td align="left">&nbsp;&nbsp;<input size="50" type="text" name="merAuthorizeType" id="merAuthorizeType" value="SMS_AUTHORIZE" />		  		
		  		&nbsp;<span style="color:#FF0000;font-weight:100;">*</span></td>
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
