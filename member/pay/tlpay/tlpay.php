<?php
session_start();
include_once 'config.php';
include_once '../../database/mysql.config.php';
$pay_online = $_REQUEST['pay_online'];
include_once 'moneyconfig.php';
include_once 'moneyfunc.php';
include_once '../function.php';
include_once '../../common/function.php';
$main_url = $_REQUEST['hosturl'];
$uid = intval($_REQUEST['uid']);
$username = $_REQUEST['username'];
$rows = check_user_login($uid, $username);
if (!$rows)
{
	message('请登录后再进行存款操作');
	exit();
}
?> <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
  <html xmlns="http://www.w3.org/1999/xhtml" > 
  <head> 
	  <title>会员中心</title> 
	  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
      <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
	  <link type="text/css" rel="stylesheet" href="../images/member.css"/> 
	  <script type="text/javascript" src="../images/member.js"></script> 
	  <!--[if IE 6]><script type="text/javascript" src="../images/DD_belatedPNG.js"></script><![endif]--> 
	  <link href="skin/thickbox.css" rel="stylesheet" type="text/css" /> 
	  <script type="text/javascript" src="skin/jquery-1.7.2.min.js"></script> 
	  <script language="JAVAScript"> 
          //数字验证 过滤非法字符 
          function clearNoNum(obj){ 
	          obj.value = obj.value.replace(/[^\d.]/g,"");//先把非数字的都替换掉，除了数字和. 
	          obj.value = obj.value.replace(/^\./g,"");//必须保证第一个为数字而不是. 
	          obj.value = obj.value.replace(/\.{2,}/g,".");//保证只有出现一个.而没有多个. 
	          obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");//保证.只出现一次，而不能出现两次以上 
	          if(obj.value != ''){ 
				  var re=/^\d+\.{0,1}\d{0,2}$/;
				  if(!re.test(obj.value))    
				  {    
					  obj.value = obj.value.substring(0,obj.value.length-1);
					  return false;
				  }  
	          } 
          } 
		
		function VerifyData(payType) {
			var paymoney = document.form1.MOAmount.value;
			var limitmoney = document.form1.ck_limit.value;
			if (document.form1.MOAmount.value == "") {
				alert("请输入存款金额！")
				document.form1.MOAmount.focus();
				return false;
			}

			if (eval(paymoney) < eval(limitmoney)) {
				alert("最低冲值"+limitmoney+"元！");
				document.form1.MOAmount.focus();
				return false;
			}
			tb_show("请使用<?php echo $arr_online_config[$pay_online]['pay_name']; ?>客户端扫码","#TB_inline?width=320&height=320&inlineId=info",false);
			$("#qrimg").html("<img src=\"jaf/loading.gif\" style=\"padding-top:130px\" /><br />二维码加载中，请稍后...");
			$.ajax({
  				url: "<?php echo $post_url; ?>",
   				type: "POST",
  				dataType: "jsonp",
  				jsonp: "callback",
   				data: {"S_Name":"<?=$rows['username'];?>", "MOAmount":paymoney, "type":"<?php echo $arr_online_config[$pay_online]['pay_type']; ?>", "pay_online":"<?php echo $pay_online; ?>"},
   				success: function(data){
   					if(data['status']=="error"){
   						alert(data['message']);
   						tb_remove();
   					}else{
   						$("#qrimg").html("<img src=\"qrcodex.php?s="+encodeURIComponent(data['message'])+"\" height=\"300\" />");
   					}
   				}
			});
			return false;
		}

	  </script> 
	  <script type="text/javascript" src="skin/thickbox.js"></script> 
	  <script type="text/javascript">  
		  $(function(){ 
			  //付款完成，返回付款历史页面 
			  $('#btnOKpay').click(function(){ 
				  tb_remove();
				  self.location.href="<?=$main_url;?>member/data_money.php";
			  });
			  $('#btnFail').click(function(){ 
				  tb_remove();
				  self.location.href='<?=$input_url;?>?username=<?=$username;?>&uid=<?=$uid;?>&hosturl=<?=$main_url;?>';
			  });
			  $('#back').click(function(){ 
				  tb_remove();
				  self.location.href='<?=$input_url;?>?username=<?=$username;?>&uid=<?=$uid;?>&hosturl=<?=$main_url;?>';
			  });
		  }) 
	  </script> 
  </head> 
  <body> 
  <table width="960" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #FFF solid;"><?php include_once '../mainmenu.php';?>	  <tr> 
		  <td colspan="2" align="center" valign="middle"><?php include_once '../moneymenu.php';?>			  <div class="content"> 
				  <table width="98%" border="0" cellspacing="0" cellpadding="5"> 
					  <tr> 
						  <td align="left" bgcolor="#FFFFFF" style="line-height:22px;"> 
							  <table width="100%" border="0" cellspacing="0" cellpadding="5"> 
								  <form id="form1" name="form1" action="/" method="post" onsubmit="return false;"> 
								  <tr> 
									  <td align="right" bgcolor="#FAFAFA">用户账号：</td> 
									  <td align="left"><?=$username;?>
										  &nbsp;&nbsp;<span class="lan">目前额度： <?=sprintf('%.2f',$rows['money']);?></span></td> 
								  </tr> 
								  <tr> 
									  <td align="right" bgcolor="#FAFAFA">存款金额：</td> 
									  <td align="left"><input name="MOAmount" type="text" class="input_150" id="MOAmount" onkeyup="clearNoNum(this);" maxlength="10" size="15"/> 
										  &nbsp;&nbsp;<span class="lan">最少冲值<?=$web_site['ck_limit'];?>元</span> 
										  <input id="ck_limit" type="hidden" value="<?=$web_site['ck_limit'];?>" /></td> 
								  </tr> 
								  <tr> 
									  <td align="right" bgcolor="#FAFAFA">&nbsp;</td> 
									  <td align="left"><input name="SubTran" type="button" class="submit_108" id="SubTran" value="<?php echo $arr_online_config[$pay_online]['pay_name']; ?>扫码" onclick="VerifyData();" /></td> 
								  </tr> 
								  </form> 
							  </table> 
						  </td> 
					  </tr> 
				  </table> 
			  </div> 
		  </td> 
	  </tr> 
  </table>       
  <div id="info" style="display:none;">
	  <p align="center" id="qrimg"></p>
  </div>
  </body> 
  </html>