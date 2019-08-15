<?php

date_default_timezone_set('Asia/Shanghai');

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
		  	<td colspan="2" bgcolor="#CEE7BD">对账接口</td>
		  </tr>

			<form method="post" action="sendGetBill.php" targe="_blank">

             <tr>
		  	<td align="left" width="25%">&nbsp;&nbsp;收款商户编号</td>
		  	<td align="left">&nbsp;&nbsp;：<input size="50" type="text" name="merchantNo" id="merchantNo"  value=""/>
      	&nbsp; </td></tr>
                <tr>
                   
                   </tr>
		    <tr>
		  	<td align="left" width="25%">&nbsp;&nbsp;对账时间</td>
		  	<td align="left">&nbsp;&nbsp;：<input size="50" type="text" name="date" id="date"  value=""/>
      	&nbsp; </td></tr>
                <tr>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;&nbsp;格式：YYYY-MM-DD</td>
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
