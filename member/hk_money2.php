<?php session_start();
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../common/logintu.php';
include_once '../class/user.php';
include_once '../common/function.php';
$uid = $_SESSION['uid'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
if ($_GET['into'] == 'true')
{
	$params = array(':uid' => $uid);
	$sql = 'select count(1) as num from huikuan where status=0 and  uid=:uid and adddate>=date_add(now(),interval  -1 day)';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$rows = $stmt->fetch();
	if (0 < $rows['num'])
	{?> <script>alert('您有未处理的订单，请联系客服处理，再继续提交！');window.location.href='hk_money2.php'</script><?php exit();
	}
	$params = array(':uid' => $uid);
	$sql = 'select money from k_user where uid=:uid limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$rows = $stmt->fetch();
	$assets = sprintf('%.2f', $rows['money']);
	$money = sprintf('%.2f', floatval($_POST['paymoney']));
	$bank = str_replace('***', '<br/>', htmlEncode($_POST['IntoBank']));
	$payname = htmlEncode($_POST['payname']);
	if ($money < $web_site['ck_limit'])
	{
		message('转账金额最低为：' . $web_site['ck_limit'] . '元');
		exit();
	}
	$manner = '会员昵称：' . $payname;
	$params = array(':money' => $money, ':bank' => $bank, ':date' => date('YmdHis'), ':manner' => $manner, ':address' => '', ':uid' => $uid, ':lsh' => $_SESSION['username'] . '_' . date('YmdHis'), ':assets' => $assets, ':balance' => $assets);
	$sql = 'Insert Into `huikuan`  (money,bank,date,manner,address,adddate,status,uid,lsh,assets,balance) values  (:money,:bank,:date,:manner,:address,now(),0,:uid,:lsh,:assets,:balance)';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1 == 1)
	{
		message('恭喜您，充值信息提交成功。\\n我们将尽快审核，谢谢您对' . $web_site['reg_msg_from'] . '的支持。', 'data_h_money.php');
	}
	else
	{
		message('对不起，由于网络堵塞原因。\\n您提交的汇款信息失败，请您重新提交。');
	}
}

include_once '../cache/bank2.php';
$banklist = $bank[$_SESSION['gid']];
foreach ($banklist as $k => $v) {
  if($v['state'] === false) unset($banklist[$k]);
}

?> <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
  <html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
	  <title>会员中心</title> 
	  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
      <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
	  <link type="text/css" rel="stylesheet" href="images/member.css"/> 
	  <script type="text/javascript" src="images/member.js"></script> 
	  <!--[if IE 6]><script type="text/javascript" src="images/DD_belatedPNG.js"></script><![endif]--> 
	  <script type="text/javascript" src="../js/calendar.js"></script> 
      <script type="text/javascript" src="../skin/js/jquery-1.7.2.min.js"></script> 
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
                   
          function SubInfo(){ 
              var pn = $('#payname').val();
              if(pn==''){ 
                  alert('请输入【昵称】');
                  $('#payname').focus();
                  return false;
              } 
			  var hk = $('#paymoney').val();
              if(hk==''){ 
                  alert('请输入【充值金额】');
                  $('#paymoney').focus();
                  return false;
              } 
              if($('#IntoBank').val()==''){ 
                  alert('请选择【扫一扫账号】');
                  $('#IntoBank').focus();
                  return false;
              } 
              $('#form1').submit();
          } 
          //是否是中文 
		  function isChinese(str){ 
			  return /[\u4E00-\u9FA0]/.test(str);
		  } 
	  </script> 
  </head> 
  <body> 
  <table width="960" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #FFF solid;"><?php include_once 'mainmenu.php';?>	  <tr> 
		  <td colspan="2" align="center" valign="middle"><?php include_once 'moneymenu.php';?>			  <div class="content" > 
                  <table width="98%" border="0" cellspacing="0" cellpadding="5"> 
                      <tr> 
                          <td> 
                              <table width="500" border="0" cellspacing="0" cellpadding="5" align="left" style="min-height:250px;*height:250px;"> 
                                  <tr> 
                                      <td height="30" colspan="6" align="center" bgcolor="#FAFAFA" class="hong"><strong>请选择以下微信、支付宝账号进行扫描支付</strong></td> 
                                  </tr>
                                <?php  foreach ($banklist as $k => $arr):?>
                                  <tr bank onMouseOver="this.style.backgroundColor='#ebebeb'" onMouseOut="this.style.backgroundColor='#FFFFFF'" style="background-color:#FFFFFF;">
                                      <td height="24"><?=$arr['card_bankName'];?>：</td> 
                                      <td> 
                                          <span class="lan" id="<?=$arr['card_ID'];?>" onclick="myonclick('<?=$arr['card_img']?>','<?=$arr['card_bankName']?>');"  style="cursor:pointer;"><?=$arr['card_ID']?></span></td> 
                                      <td>昵称：</td> 
                                      <td><span><?=$arr['card_name']?></span></td> 
                                  </tr>
                                <?php endforeach;?> 
                                   <tr> 
                                      <td colspan="6" align="left" bgcolor="#FAFAFA" style="line-height:22px;"> 
                                          <p><strong>温馨提示：</strong></p> 
                                          <div class="bank_notice" style="color:red;">※1. 请<span style="color:blue;">鼠标单击【账号】,<span style="color:blue;">最低充值：<?=$web_site['ck_limit'];?>元</span></span>，扫描显示出来的二维码，进行充值。<br>※2. 请勿存入整数金额(如存 1000.32元 , 500.77元 )，以免延误财务查收。<br> ※3. 转帐完成后请保留单据作为核对证明。<br> ※4. 扫描充值后，为了方便核对会员账号入款，请填写下面信息。 
                                          </div> 
                                      </td> 
                                  </tr> 
                              </table> 
                          </td> 
                      </tr> 
                      <tr> 
                          <td> 
                              <table width="100%" border="0" cellspacing="0" cellpadding="5"> 
                                  <form id="form1" name="form1" action="hk_money2.php?into=true" method="post"> 
                                  <tr> 
                                      <td width="150" align="right" bgcolor="#FAFAFA">会员的微信、支付宝昵称：</td> 
                                      <td align="left"><input name="payname" type="text" class="input_130" id="payname" size="15" maxlength="20"/></td> 
                                      <td align="right" bgcolor="#FAFAFA">充值金额：</td> 
                                      <td align="left"><input name="paymoney" type="text" class="input_130" id="paymoney" onkeyup="clearNoNum(this);" size="15" maxlength="10"/></td> 
                                      <td align="right" bgcolor="#FAFAFA">扫一扫账号</td> 
                                      <td align="left"> 
                                          <select id="IntoBank" name="IntoBank"> 
                                              <option value="" selected="selected">==请选择==</option>
                                              <?php foreach ($banklist as $k => $arr):?>
                                              <option value="<?=$arr['card_bankName']?>***<?=$arr['card_ID']?>"><?=$arr['card_bankName']?></option>
                                              <?php endforeach;?>                                         
                                          </select> 
                                      </td> 
                                      <td align="left"><input name="SubTran" type="button" class="submit_108" id="SubTran" onclick="SubInfo();" value="提交信息" /></td> 
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
  <div id="saoyisaodiv" style="position:absolute;top:110px;margin-left:600px;width:350px;height:250px;"> 
      <span style="width:250px;font-weight: bold;font-size: 16px;">二维码扫描区</span> 
      <br/><?php if (0 < count($bank[$_SESSION['gid']])): $info = reset($banklist);?>     
      <img id="saoyisaoimg" height="200" src="/newindex/<?=$info['card_img']?>"/>  
      <br/> 
      <span id="saoyisaospan" style="width:250px;color:blue"> 您选择的是：<?=$info['card_bankName']?></span>
    <?php else:?>
       <img id="saoyisaoimg" src="/newindex/saoyisao.jpg"/>  
      <br/> 
      <span id="saoyisaospan" style="width:250px;color:blue"></span><?php endif;?> 
      </div> 
  <script> 
  function myonclick(img,item) 
  { 
      $("#saoyisaodiv").css('display','block');//显示 
      $("#saoyisaospan").html("您选择的是："+item);
      $("#saoyisaoimg").attr('src',"/newindex/"+img);
  } 
  $('[bank]').get(0).find('.lan').trigger("click");
  </script> 
  </body> 
  </html>