<?php 
session_start();
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
	if (0 < $rows['num']){ 
		echo "<script>alert('您有未处理的订单，请联系客服处理，再继续提交！');window.location.href='hk_money.php'</script>";
		exit();
	}
	$params = array(':uid' => $uid);
	$sql = 'select money from k_user where uid=:uid limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$rows = $stmt->fetch();
	$assets = sprintf('%.2f', $rows['money']);
	$money = sprintf('%.2f', floatval($_POST['v_amount']));
	$bank = str_replace('***', '<br/>', htmlEncode($_POST['IntoBank']));
	$date = htmlEncode($_POST['cn_date']);
	$date1 = $date . ' ' . $_POST['s_h'] . ':' . $_POST['s_i'] . ':' . $_POST['s_s'];
	$manner = htmlEncode($_POST['InType']);
	$address = htmlEncode($_POST['v_site']);
	if ($money < $web_site['ck_limit'])
	{
		message('转账金额最低为：' . $web_site['ck_limit'] . '元');
		exit();
	}
	if ($manner == '网银转账')
	{
		$manner .= '<br />持卡人姓名：' . htmlEncode($_POST['v_Name']);
	}
	if ($manner == '0')
	{
		$manner = htmlEncode($_POST['IntoType']);
	}
	$params = array(':money' => $money, ':bank' => $bank, ':date' => $date1, ':manner' => $manner, ':address' => $address, ':uid' => $uid, ':lsh' => $_SESSION['username'] . '_' . date('YmdHis'), ':assets' => $assets, ':balance' => $assets);
	$sql = 'Insert Into `huikuan` (money,bank,date,manner,address,adddate,status,uid,lsh,assets,balance) values (:money,:bank,:date,:manner,:address,now(),0,:uid,:lsh,:assets,:balance)';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1 == 1)
	{
		message('恭喜您，汇款信息提交成功。\\n我们将尽快审核，谢谢您对' . $web_site['reg_msg_from'] . '的支持。', 'data_h_money.php');
	}
	else
	{
		message('对不起，由于网络堵塞原因。\\n您提交的汇款信息失败，请您重新提交。');
	}
}

include_once '../cache/bank.php';
$banklist = $bank[$_SESSION['gid']];
foreach ($banklist as $k => $v) {
	if($v['state'] === false) unset($banklist[$k]);
}

?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
  <html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
	  <title>会员中心</title> 
	  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
      <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
	  <link type="text/css" rel="stylesheet" href="images/member.css"/> 
	  <script type="text/javascript" src="images/member.js"></script> 
	  <!--[if IE 6]><script type="text/javascript" src="images/DD_belatedPNG.js"></script><![endif]--> 
	  <script type="text/javascript" src="../js/calendar.js"></script> 
	  <script language="JAVAScript"> 
		  var $ = function(id){ 
              return document.getElementById(id);
          } 
		
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
           
          function showType(){ 
              if($('InType').value=='0'){ 
                  $('v_type').style.display='';
                  $('tr_v').style.display='none';
              }else if($('InType').value=='网银转账'){ 
                  $('tr_v').style.display='';
                  $('v_Name').value='请输入持卡人姓名';
                  $('v_type').style.display='none';
                  $('IntoType').value=$('InType').value;
              }else{ 
                  $('v_type').style.display='none';
                  $('IntoType').value=$('InType').value;
                  $('tr_v').style.display='none';
              } 
          } 
           
          function SubInfo(){ 
			  var hk = $('v_amount').value;
              if(hk==''){ 
                  alert('请输入转账金额');
                  $('v_amount').focus();
                  return false;
              }else{ 
				  hk = hk*1;
				  if(hk<<?=$web_site['ck_limit'];?>){ 
					  alert('转账金额最低为：<?=$web_site['ck_limit'];?>元');
					  $('v_amount').select();
					  return false;
				  } 
			  } 
              if($('IntoBank').value==''){ 
                  alert('为了更快确认您的转账，请选择汇款银行');
                  $('IntoBank').focus();
                  return false;
              } 
              if($('cn_date').value==''){ 
                  alert('请选择汇款日期');
                  $('cn_date').focus();
                  return false;
              } 
     
              if($('InType').value==''){ 
                  alert('为了更快确认您的转账，请选择汇款方式');
                  $('InType').focus();
	              return false;
              } 
              if($('InType').value=='0'){ 
                  if($('v_type').value!=''&& $('v_type').value!='请输入其它汇款方式'){ 
                      $('IntoType').value=$('v_type').value;
                  }else{ 
                      alert('请输入其它汇款方式');
					  $('v_type').focus();
                      return false;
                  } 
              } 
              if($('InType').value=='网银转账'){ 
                  if($('v_Name').value!=''&& $('v_Name').value!='请输入持卡人姓名' && $('v_Name').value.length>1 && $('v_Name').value.length<20){ 
                      var tName =$('v_Name').value;
                      var yy = tName.length;
                      for(var xx=0;xx<yy;xx++){ 
                          var zz = tName.substring(xx,xx+1);
                          if(zz!='·'){ 
                              if(!isChinese(zz)){ 
                                  alert('请输入中文持卡人姓名，如有其他疑问，请联系在线客服');
								  $('v_Name').focus();
	                              return false;
                              } 
                          } 
                      } 
                  }else{ 
                      alert('为了更快确认您的转账，网银转账请输入持卡人姓名');
					  $('v_Name').focus();
                      return false;
                  } 
              } 
              if($('v_site').value==''){ 
                  alert('请填写汇款地点');
				  $('v_site').focus();
                  return false;
              } 
              if($('v_site').value.length>50){ 
                  alert('汇款地点不要超过50个中文字符');
				  $('v_site').focus();
                  return false;
              } 
              $('form1').submit();
          } 
          //是否是中文 
		  function isChinese(str){ 
			  return /[\u4E00-\u9FA0]/.test(str);
		  } 
	  </script> 
  </head> 
  <body> 
<table width="960" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #FFF solid;">
	<?php  include_once("mainmenu.php"); ?>
	<tr>
		<td colspan="2" align="center" valign="middle">
			<?php  include_once("moneymenu.php"); ?>
			<div class="content">
				  <table width="98%" border="0" cellspacing="0" cellpadding="5"> 
					  <tr> 
						  <td height="30" colspan="6" align="center" bgcolor="#FAFAFA" class="hong"><strong>请选择以下公司账号进行转账汇款</strong></td> 
                      </tr>
                      <?php  foreach ($banklist as $k => $arr):?>                     
                      <tr onMouseOver="this.style.backgroundColor='#ebebeb'" onMouseOut="this.style.backgroundColor='#FFFFFF'" style="background-color:#FFFFFF;"> 
						  <td height="24"><?=$arr['card_bankName'];?>：</td> 
						  <td><span class="lan"><?=$arr['card_ID'];?></span></td> 
						  <td>开户名：</td> 
						  <td><span class="lan"><?=$arr['card_userName'];?></span></td> 
						  <td>开户行所在城市：</td> 
						  <td class="lan"><?=$arr['card_address'];?></td> 
					  </tr>
						<?php endforeach;?>  
						<tr> 
						  <td colspan="6" align="left" bgcolor="#FAFAFA" style="line-height:22px;"> 
							  <p><strong>温馨提示：</strong></p> 
							  <p>一、在金额转出之后请务必填写该页下方的汇款信息表格，以便财务系统能够及时的为您确认并添加金额到您的会员帐户中。</p> 
							  <p>二、本公司<span style="color:blue;">最低存款金额为<?=$web_site['ck_limit'];?>元</span>，公司财务系统将对银行存款的会员按实际存款金额实行返利派送。</p> 
							  <p>三、跨行转帐请您使用跨行快汇。</p> 
						  </td> 
                      </tr> 
				  </table> 
				  <table width="98%" border="0" cellspacing="0" cellpadding="5" style="margin-top:5px;"> 
					  <tr> 
						  <td height="30" colspan="6" align="center" bgcolor="#FAFAFA" class="hong"><strong>请认真填写以下汇款单</strong></td> 
					  </tr> 
					  <tr> 
						  <td colspan="6" align="left" bgcolor="#FFFFFF" style="line-height:22px;"> 
							  <table width="100%" border="0" cellspacing="0" cellpadding="5"> 
								  <form id="form1" name="form1" action="?into=true" method="post"> 
								  <tr> 
									  <td width="150" align="right" bgcolor="#FAFAFA">用户账号：</td> 
									  <td align="left"><?=$_SESSION['username'];?></td> 
								  </tr> 
								  <tr> 
									  <td align="right" bgcolor="#FAFAFA">存款金额：</td> 
									  <td align="left"><input name="v_amount" type="text" class="input_150" id="v_amount" onKeyUp="clearNoNum(this);" size="15" maxlength="10"/></td> 
								  </tr> 
								  <tr> 
									  <td align="right" bgcolor="#FAFAFA">汇款银行：</td> 
									  <td align="left"> 
										  <select id="IntoBank" name="IntoBank"> 
											  <option value="" selected="selected">==请选择汇款银行==</option>
											  <?php foreach ($banklist as $k => $arr):?> 											  
											  	<option value="<?=$arr['card_bankName']?>***<?=$arr['card_ID']?>"><?=$arr['card_bankName']?></option>
											  <?php endforeach;?>
											</select> 
									  </td> 
								  </tr> 
								  <tr> 
									  <td align="right" bgcolor="#FAFAFA">汇款日期：</td> 
									  <td align="left"> 
										  <input name="cn_date" type="text" id="cn_date" size="10" maxlength="10" readonly="readonly" value="<?=date("Y-m-d",time())?>" onClick="new Calendar(2008,2020,0,'-','yyyy-MM-dd','ymd',0,-300).show(this);"/>  
										  时间：  
										  <select name="s_h" id="s_h"> 
											  <option value="00">00</option> 
											  <option value="01">01</option> 
											  <option value="02">02</option> 
											  <option value="03">03</option> 
											  <option value="04">04</option> 
											  <option value="05">05</option> 
											  <option value="06">06</option> 
											  <option value="07">07</option> 
											  <option value="08">08</option> 
											  <option value="09">09</option> 
											  <option value="10">10</option> 
											  <option value="11">11</option> 
											  <option value="12">12</option> 
											  <option value="13">13</option> 
											  <option value="14">14</option> 
											  <option value="15">15</option> 
											  <option value="16">16</option> 
											  <option value="17">17</option> 
											  <option value="18">18</option> 
											  <option value="19">19</option> 
											  <option value="20">20</option> 
											  <option value="21">21</option> 
											  <option value="22">22</option> 
											  <option value="23">23</option> 
										  </select> 
										  时 
										  <select name="s_i" id="s_i"> 
											  <option value="00">00</option> 
											  <option value="01">01</option> 
											  <option value="02">02</option> 
											  <option value="03">03</option> 
											  <option value="04">04</option> 
											  <option value="05">05</option> 
											  <option value="06">06</option> 
											  <option value="07">07</option> 
											  <option value="08">08</option> 
											  <option value="09">09</option> 
											  <option value="10">10</option> 
											  <option value="11">11</option> 
											  <option value="12">12</option> 
											  <option value="13">13</option> 
											  <option value="14">14</option> 
											  <option value="15">15</option> 
											  <option value="16">16</option> 
											  <option value="17">17</option> 
											  <option value="18">18</option> 
											  <option value="19">19</option> 
											  <option value="20">20</option> 
											  <option value="21">21</option> 
											  <option value="22">22</option> 
											  <option value="23">23</option> 
											  <option value="24">24</option> 
											  <option value="25">25</option> 
											  <option value="26">26</option> 
											  <option value="27">27</option> 
											  <option value="28">28</option> 
											  <option value="29">29</option> 
											  <option value="30">30</option> 
											  <option value="31">31</option> 
											  <option value="32">32</option> 
											  <option value="33">33</option> 
											  <option value="34">34</option> 
											  <option value="35">35</option> 
											  <option value="36">36</option> 
											  <option value="37">37</option> 
											  <option value="38">38</option> 
											  <option value="39">39</option> 
											  <option value="40">40</option> 
											  <option value="41">41</option> 
											  <option value="42">42</option> 
											  <option value="43">43</option> 
											  <option value="44">44</option> 
											  <option value="45">45</option> 
											  <option value="46">46</option> 
											  <option value="47">47</option> 
											  <option value="48">48</option> 
											  <option value="49">49</option> 
											  <option value="50">50</option> 
											  <option value="51">51</option> 
											  <option value="52">52</option> 
											  <option value="53">53</option> 
											  <option value="54">54</option> 
											  <option value="55">55</option> 
											  <option value="56">56</option> 
											  <option value="57">57</option> 
											  <option value="58">58</option> 
											  <option value="59">59</option> 
										  </select> 
										  分 
										  <select name="s_s" id="s_s"> 
											  <option value="00">00</option> 
											  <option value="01">01</option> 
											  <option value="02">02</option> 
											  <option value="03">03</option> 
											  <option value="04">04</option> 
											  <option value="05">05</option> 
											  <option value="06">06</option> 
											  <option value="07">07</option> 
											  <option value="08">08</option> 
											  <option value="09">09</option> 
											  <option value="10">10</option> 
											  <option value="11">11</option> 
											  <option value="12">12</option> 
											  <option value="13">13</option> 
											  <option value="14">14</option> 
											  <option value="15">15</option> 
											  <option value="16">16</option> 
											  <option value="17">17</option> 
											  <option value="18">18</option> 
											  <option value="19">19</option> 
											  <option value="20">20</option> 
											  <option value="21">21</option> 
											  <option value="22">22</option> 
											  <option value="23">23</option> 
											  <option value="24">24</option> 
											  <option value="25">25</option> 
											  <option value="26">26</option> 
											  <option value="27">27</option> 
											  <option value="28">28</option> 
											  <option value="29">29</option> 
											  <option value="30">30</option> 
											  <option value="31">31</option> 
											  <option value="32">32</option> 
											  <option value="33">33</option> 
											  <option value="34">34</option> 
											  <option value="35">35</option> 
											  <option value="36">36</option> 
											  <option value="37">37</option> 
											  <option value="38">38</option> 
											  <option value="39">39</option> 
											  <option value="40">40</option> 
											  <option value="41">41</option> 
											  <option value="42">42</option> 
											  <option value="43">43</option> 
											  <option value="44">44</option> 
											  <option value="45">45</option> 
											  <option value="46">46</option> 
											  <option value="47">47</option> 
											  <option value="48">48</option> 
											  <option value="49">49</option> 
											  <option value="50">50</option> 
											  <option value="51">51</option> 
											  <option value="52">52</option> 
											  <option value="53">53</option> 
											  <option value="54">54</option> 
											  <option value="55">55</option> 
											  <option value="56">56</option> 
											  <option value="57">57</option> 
											  <option value="58">58</option> 
											  <option value="59">59</option> 
										  </select> 
										  秒 
									  </td> 
								  </tr> 
								  <tr> 
									  <td align="right" bgcolor="#FAFAFA">汇款方式：</td> 
									  <td align="left"> 
										  <select id="InType" name="InType" onChange="showType();"> 
											  <option value="">==请选择汇款方式==</option> 
											  <option value="银行柜台">银行柜台</option> 
											  <option value="ATM现金">ATM现金</option> 
											  <option value="ATM卡转">ATM卡转</option> 
											  <option value="网银转账">网银转账</option> 
                                              <option value="支付宝转账">支付宝转账</option> 
											  <option value="微信转账">微信转账</option> 
											  <option value="0">其它[手动输入]</option> 
										  </select> 
										  <input id="v_type" name="v_type" type="text" size="19" value="请输入其它汇款方式" onFocus="javascript:$('v_type').select();" class="font-hhblack" maxlength="20" style="border:1px solid #CCCCCC;height:18px;line-height:20px;font-size:12px;display:none;" /> 
										  <input type="hidden" id="IntoType" name="IntoType" value="" /> 
									  </td> 
								  </tr> 
								  <tr id="tr_v" style="display:none;"> 
									  <td align="right" bgcolor="#FAFAFA">汇款人姓名：</td> 
									  <td align="left"><input name="v_Name" type="text" class="input_150" id="v_Name" onFocus="javascript:this.select();" size="34" maxlength="20" /></td> 
								  </tr> 
								  <tr> 
									  <td align="right" bgcolor="#FAFAFA">汇款地点：</td> 
									  <td align="left"> 
                                          <input name="v_site" type="text" class="input_250" id="v_site" size="34" maxlength="50" />&nbsp;&nbsp;
                                          <span>注：微信 支付宝转账请在此填写姓名</span> 
                                          </td> 
								  </tr> 
								  <tr> 
									  <td align="right" bgcolor="#FAFAFA">&nbsp;</td> 
									  <td align="left"><input name="SubTran" type="button" class="submit_108" id="SubTran" onClick="SubInfo();" value="提交信息" /></td> 
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
  </body> 
  </html>