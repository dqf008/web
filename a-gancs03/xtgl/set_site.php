<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../member/pay/moneyconfig.php';
check_quanxian('xtgl');
if (@($_GET['action']) == 'save'){
	if (count($_POST) < 1){
		message('网站设置失败!');
	}
	$modify_pwd_c = intval(clear_html_code($_POST['modify_pwd_c']));
	if ($modify_pwd_c == 0){
		$modify_pwd_c = 15;
	}
	$params = array(':web_name' => clear_html_code($_POST['web_name']), ':conf_www' => clear_html_code($_POST['conf_www']), ':close' => intval($_POST['close']), ':why' => encoding_html($_POST['why']), ':reg_msg_title' => clear_html_code($_POST['reg_msg_title']), ':reg_msg_info' => encoding_html($_POST['reg_msg_info']), ':reg_msg_from' => clear_html_code($_POST['reg_msg_from']), ':ck_limit' => clear_html_code($_POST['ck_limit']), ':qk_limit' => clear_html_code($_POST['qk_limit']), ':qk_time_begin' => clear_html_code($_POST['qk_time_begin']), ':qk_time_end' => clear_html_code($_POST['qk_time_end']), ':modify_pwd_c' => $modify_pwd_c);
	$sql = 'update web_config set web_name=:web_name,conf_www=:conf_www,close=:close,why=:why,reg_msg_title=:reg_msg_title,reg_msg_info=:reg_msg_info,reg_msg_from=:reg_msg_from,ck_limit=:ck_limit,qk_limit=:qk_limit,qk_time_begin=:qk_time_begin,qk_time_end=:qk_time_end,modify_pwd_c=:modify_pwd_c';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	include_once '../../class/admin.php';
	admin::insert_log($_SESSION['adminid'], '修改了系统参数配置');
	$str = '<?php ' . "\r\n";
	$str .= 'unset($web_site);' . "\r\n";
	$str .= '$web_site' . "\t\t\t" . '=' . "\t" . 'array();' . "\r\n";
	$str .= '$web_site[\'close\']' . "\t" . '=' . "\t" . intval($_POST['close']) . ';' . "\r\n";
	$str .= '$web_site[\'web_name\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($_POST['web_name']) . '\';' . "\r\n";
	$str .= '$web_site[\'why\']' . "\t" . '=' . "\t" . '\'' . encoding_html(addslashes($_POST['why'])) . '\';' . "\r\n";
	$str .= '$web_site[\'reg_msg_from\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($_POST['reg_msg_from']) . '\';' . "\r\n";
	$str .= '$web_site[\'reg_msg_title\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($_POST['reg_msg_title']) . '\';' . "\r\n";
	$str .= '$web_site[\'reg_msg_msg\']' . "\t" . '=' . "\t" . '\'' . encoding_html($_POST['reg_msg_info']) . '\';' . "\r\n";
	$str .= '$web_site[\'ck_limit\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($_POST['ck_limit']) . '\';' . "\r\n";
	$str .= '$web_site[\'qk_limit\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($_POST['qk_limit']) . '\';' . "\r\n";
	$str .= '$web_site[\'qk_time_begin\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($_POST['qk_time_begin']) . '\';' . "\r\n";
	$str .= '$web_site[\'qk_time_end\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($_POST['qk_time_end']) . '\';' . "\r\n";
	$str .= '$web_site[\'ssc\']' . "\t" . '=' . "\t" . intval($_POST['ssc']) . ';' . "\r\n";
	$str .= '$web_site[\'klsf\']' . "\t" . '=' . "\t" . intval($_POST['klsf']) . ';' . "\r\n";
	$str .= '$web_site[\'pk10\']' . "\t" . '=' . "\t" . intval($_POST['pk10']) . ';' . "\r\n";
	$str .= '$web_site[\'xyft\']' . "\t" . '=' . "\t" . intval($_POST['xyft']) . ';' . "\r\n";
	$str .= '$web_site[\'kl8\']' . "\t" . '=' . "\t" . intval($_POST['kl8']) . ';' . "\r\n";
	$str .= '$web_site[\'ssl\']' . "\t" . '=' . "\t" . intval($_POST['ssl']) . ';' . "\r\n";
	$str .= '$web_site[\'d3\']' . "\t" . '=' . "\t" . intval($_POST['d3']) . ';' . "\r\n";
	$str .= '$web_site[\'pl3\']' . "\t" . '=' . "\t" . intval($_POST['pl3']) . ';' . "\r\n";
	$str .= '$web_site[\'qxc\']' . "\t" . '=' . "\t" . intval($_POST['qxc']) . ';' . "\r\n";
	$str .= '$web_site[\'hg\']' . "\t" . '=' . "\t" . intval($_POST['hg']) . ';' . "\r\n";
	$str .= '$web_site[\'web_title\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($_POST['web_title']) . '\';' . "\r\n";
	$str .= '$web_site[\'zh_low\']' . "\t" . '=' . "\t" . '\'' . intval($_POST['zh_low']) . '\';' . "\r\n";
	$str .= '$web_site[\'zh_high\']' . "\t" . '=' . "\t" . '\'' . intval($_POST['zh_high']) . '\';' . "\r\n";
	$str .= '$web_site[\'pk10_ktime\']' . "\t" . '=' . "\t" . '\'2018-02-21\';' . "\r\n";
	$str .= '$web_site[\'pk10_knum\']' . "\t" . '=' . "\t" . '\'667278\';' . "\r\n";
	$str .= '$web_site[\'kl8_ktime\']' . "\t" . '=' . "\t" . '\'2018-02-21\';' . "\r\n";
	$str .= '$web_site[\'kl8_knum\']' . "\t" . '=' . "\t" . '\'873256\';' . "\r\n";
	$str .= '$web_site[\'wxalipay\']' . "\t\t" . '=' . "\t" . intval($_POST['wxalipay']) . ';' . "\r\n";
	$str .= '$web_site[\'show_tel\']' . "\t\t" . '=' . "\t" . intval($_POST['show_tel']) . ';' . "\r\n";
	$str .= '$web_site[\'show_qq\']' . "\t\t" . '=' . "\t" . intval($_POST['show_qq']) . ';' . "\r\n";
	$str .= '$web_site[\'show_weixin\']' . "\t\t" . '=' . "\t" . intval($_POST['show_weixin']) . ';' . "\r\n";
	$str .= '$web_site[\'show_question\']' . "\t" . '=' . "\t" . intval($_POST['show_question']) . ';' . "\r\n";
	$str .= '$web_site[\'allow_samename\']' . "\t" . '=' . "\t" . intval($_POST['allow_samename']) . ';' . "\r\n";
	$str .= '$web_site[\'allow_ip\']' . "\t" . '=' . "\t" . intval($_POST['allow_ip']) . ';' . "\r\n";
	$str .= '$web_site[\'zc_dl\']' . "\t" . '=' . "\t" . intval($_POST['zc_dl']) . ';' . "\r\n";
	$str .= '$web_site[\'lqgq4\']' . "\t" . '=' . "\t" . intval($_POST['lqgq4']) . ';' . "\r\n";
	$str .= '$web_site[\'default_hkzs\']' . "\t" . '=' . "\t" . floatval($_POST['default_hkzs']) . ';' . "\r\n";
	$str .= '$web_site[\'service_url\']' . "\t" . '=' . "\t'" . clear_html_code($_POST['service_url']) . '\';' . "\r\n";
    $str .= '$web_site[\'close_time\']' . "\t" . '=' . "\t'" . clear_html_code($_POST['close_time']) . '\';' . "\r\n";
    $str .= '$web_site[\'member_theme\']' . "\t" . '=' . "\t'" . clear_html_code($_POST['member_theme']) . '\';' . "\r\n";

    $str .= '$tmp = explode("/",$_SERVER["SCRIPT_FILENAME"]);$tmp = explode("_",isset($tmp[2])?$tmp[2]:"");if(count($tmp)==2) include_once  __DIR__ . "/website_".$tmp[1].".php";';

	if (@!chmod('../../cache', 511))
	{
		message('缓存文件写入失败！请先设 /cache 文件权限为：0777');
	}
	if (!write_file('../../cache/website.php', $str . '?>'))
	{
		message('缓存文件写入失败！请先设/website.php文件权限为：0777');
	}
	
	message('网站设置成功!');
}
$sql = 'select * from web_config limit 1';
$query = $mydata1_db->query($sql);
$rows = $query->fetch();
include_once '../../cache/website.php';
?> 
<HTML> 
<HEAD> 
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" /> 
<TITLE>网站信息设置</TITLE> 
<link rel="stylesheet" href="../Images/CssAdmin.css"> 
<style type="text/css"> 
body { 
  margin-left: 0px;
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 0px;
  font-size: 12px;
} 
</style> 
<script type="text/javascript" charset="utf-8" src="/js/jquery.js" ></script> 
<script language="JavaScript" src="/js/calendar.js"></script> 
<script language='javascript' src='../js/layer/layer.js'></script>

<script> 
function betDetailUrl(url) { 
  layer.open({ 
	  type : 2, 
	  shadeClose : true, 
	  fix:true, 
	  skin: 'layui-layer-lan', 
	  title : "配置在线支付", 
	  content: url, 
	  area : ['800px' , '500px'], 
	  shift : 0, 
	  scrollbar: false 
  });
} 
</script> 
</HEAD> 

<body> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 
  <td height="24" nowrap background="../images/06.gif"><img src="../images/Explain.gif" width="18" height="18" border="0" align="absmiddle">&nbsp;系统管理：添加，修改站点的相关信息</td> 
</tr> 
<tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<form action="set_site.php?action=save" method="post" name="editForm1" id="editForm1" > 
<tr> 
  <td height="24" nowrap bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" id=editProduct idth="100%"> 
	<tr> 
	  <td height="30" align="right">  <img src="../images/07.gif" width="12" height="12"> 网站标题：</td> 
	  <td><input name="web_title" type="text" class="textfield" id="web_title"  value="<?=$web_site['web_title'];?>" size="100" >&nbsp;*</td> 
	</tr> 
	<tr> 
	  <td height="30" align="right">  <img src="../images/07.gif" width="12" height="12"> 网站名称：</td> 
	  <td><input name="web_name" type="text" class="textfield" id="web_name"  value="<?=$rows['web_name'];?>" size="40" >&nbsp;*</td> 
	</tr> 
	<tr> 
	  <td height="30" align="right">  <img src="../images/07.gif" width="12" height="12"> 网站域名：</td> 
	  <td><input name="conf_www" type="text" class="textfield" id="conf_www"  value="<?=$rows['conf_www'];?>" size="40" >&nbsp;*&nbsp;不要加http://  </td> 
	</tr> 
	<tr> 
	  <td height="30" align="right">  网站客服链接：</td> 
	  <td><input name="service_url" type="text" class="textfield" id="service_url"  value="<?=$web_site['service_url'];?>" size="40" >&nbsp;*&nbsp;需要添加http://或https://</td> 
	</tr> 
			<tr> 
	  <td height="30" align="right" >  注册消息标题：</td> 
	  <td><input name="reg_msg_title" type="text" class="textfield" id="reg_msg_title" value="<?=$rows['reg_msg_title'];?>" size="40"></td> 
	</tr> 
			<tr> 
	  <td height="20" align="right" >  注册消息内容：</td> 
	  <td> 
	  <textarea name="reg_msg_info" cols="80" rows="4" class="textfield"><?=$rows['reg_msg_info'];?></textarea></td> 
	</tr> 
			<tr> 
	  <td height="30" align="right" >  注册消息发送者：</td> 
	  <td><input name="reg_msg_from" type="text" class="textfield" id="reg_msg_from" value="<?=$rows['reg_msg_from'];?>" size="40"></td> 
	</tr> 
	<tr> 
	  <td height="30" align="right" >  注册显示项目控制：</td> 
	  <td><input name="show_tel" type="checkbox" id="show_tel" value="1" <?=$web_site['show_tel']==1 ? 'checked' : '';?>>是否显示电话 
		  <input name="show_qq" type="checkbox" id="show_qq" value="1" <?=$web_site['show_qq']==1 ? 'checked' : '';?>>是否显示QQ 
		  <input name="show_weixin" type="checkbox" id="show_weixin" value="1" <?=$web_site['show_weixin']==1 ? 'checked' : '';?>>是否显示微信 
		  <input name="show_question" type="checkbox" id="show_question" value="1" <?=$web_site['show_question']==1 ? 'checked' : '';?>>是否显示密码问题 
		  <input name="allow_samename" type="checkbox" id="allow_samename" value="1" <?=$web_site['allow_samename']==1 ? 'checked' : '';?>>是否允许同名
		  <input name="allow_ip" type="checkbox" id="allow_ip" value="1" <?=$web_site['allow_ip']==1 ? 'checked' : '';?>>是否允许同IP
		  <input name="zc_dl" type="checkbox" id="zc_dl" value="1" <?=$web_site['zc_dl']==1 ? 'checked' : '';?>>显示介绍人
	  </td> 
	</tr> 
	<tr> 
	  <td height="30" align="right" >  选择在线支付平台：</td> 
	  <td> 
			  <input type="button" onClick="betDetailUrl('set_pay.php?id=<?=$rows['id'];?>')" value="配置在线支付"> 
		  <!-- <select name="pay_online" id="pay_online"> 
			  <option value="">==请选择==</option> 
						  </select>
		  目前支持智付2.0、智付3.0、环讯、易宝、快捷宝、汇潮、宝付、新生、国富宝、魔宝、环讯新版、融宝、币付宝等在线支付平台 -->
      </td>
	</tr> 
	<tr> 
	  <td height="30" align="right" >  开通微信/支付宝：</td> 
	  <td><input name="wxalipay" type="checkbox" id="wxalipay" value="1" <?=$web_site['wxalipay']==1 ? 'checked' : '';?>></td> 
	</tr> 
	<tr> 
	  <td height="30" align="right" >  最低存汇款：</td> 
	  <td><input name="ck_limit" type="text" class="textfield" maxlength="10" id="ck_limit" value="<?=$rows['ck_limit'];?>" size="10"> 
		  最低取款：<input name="qk_limit" type="text" class="textfield" maxlength="10" id="qk_limit" value="<?=$rows['qk_limit'];?>" size="10"> 
		  可取款时间：<input name="qk_time_begin" type="text" class="textfield" maxlength="5" id="qk_time_begin" value="<?=$rows['qk_time_begin'];?>" size="4"> 
		  ~ 
		  <input name="qk_time_end" type="text" class="textfield" maxlength="5" id="qk_time_end" value="<?=$rows['qk_time_end'];?>" size="4"></td> 
	</tr> 
	<tr> 
	  <td height="30" align="right" >  采种关闭：</td> 
	  <td><input name="ssc" type="checkbox" <?=$web_site['ssc']==1 ? 'checked' : '';?> id="ssc" value="1" />重庆时时彩 
		  <input name="klsf" type="checkbox" <?=$web_site['klsf']==1 ? 'checked' : '';?> id="klsf" value="1" />广东快乐十分 
		  <input name="pk10" type="checkbox" <?=$web_site['pk10']==1 ? 'checked' : '';?> id="pk10" value="1" />北京赛车PK拾 
		  <input name="xyft" type="checkbox" <?=$web_site['xyft']==1 ? 'checked' : '';?> id="xyft" value="1" />幸运飞艇
		  <input name="kl8" type="checkbox" <?=$web_site['kl8']==1 ? 'checked' : '';?> id="kl8" value="1" />北京快乐8 
		  <input name="ssl" type="checkbox" <?=$web_site['ssl']==1 ? 'checked' : '';?> id="ssl" value="1" />上海时时乐 
		  <input name="d3" type="checkbox" <?=$web_site['d3']==1 ? 'checked' : '';?> id="d3" value="1" />福彩3D 
		  <input name="pl3" type="checkbox" <?=$web_site['pl3']==1 ? 'checked' : '';?> id="pl3" value="1" />排列三
<!--		  <input name="qxc" type="checkbox" --><?//=$web_site['qxc']==1 ? 'checked' : '';?><!-- id="qxc" value="1" />七星彩-->
		  <input name="hg" type="checkbox" <?=$web_site['hg']==1 ? 'checked' : '';?> id="hg" value="1" />皇冠体育
		  </td> 
	</tr> 
	<!--tr> 
	  <td height="30" align="right" >  北京赛车期数校对：</td> 
	  <td>开奖时间:<input type="text" class="textfield" value="<?=$web_site['pk10_ktime'];?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" name="des_pk10time" id="des_pk10time" readonly="readonly"/>开奖期号:<input type="text" class="textfield" value="<?=$web_site['pk10_knum'];?>" size="10" name="des_pk10num" id="des_pk10num" />(例如:2013-06-30开的最后一期是369979)</td> 
	</tr> 
	<tr> 
	  <td height="30" align="right" >  快乐8期数校对：</td> 
	  <td>开奖时间:<input type="text" class="textfield" value="<?=$web_site['kl8_ktime'];?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" name="des_kl8time" id="des_kl8time" readonly="readonly"/>开奖期号:<input type="text" class="textfield" value="<?=$web_site['kl8_knum'];?>" size="10" name="des_kl8num" id="des_kl8num" />(例如:2013-05-30开的最后一期是569859)</td> 
	</tr--> 
	<tr> 
	  <td height="30" align="right" >皇冠体育：</td> 
	  <td><input name="lqgq4" type="checkbox" <?=$web_site['lqgq4']==1 ? 'checked' : '';?> id="lqgq4" value="1" />关闭篮球滚球第4节</td> 
	</tr> 
	<!-- 
	<tr> 
	  <td height="30" align="right" >  真人维护：</td> 
	  <td> 
		  <input name="zrwh_zhou1" type="checkbox"<?=$web_site['zrwh_zhou1']==1 ? 'checked' : '';?>id="zrwh_zhou1" value="1" />周一 
		  <input name="zrwh_zhou2" type="checkbox"<?=$web_site['zrwh_zhou2']==2 ? 'checked' : '';?>id="zrwh_zhou2" value="2" />周二 
		  <input name="zrwh_zhou3" type="checkbox"<?=$web_site['zrwh_zhou3']==3 ? 'checked' : '';?>id="zrwh_zhou3" value="3" />周三 
		  <input name="zrwh_zhou4" type="checkbox"<?=$web_site['zrwh_zhou4']==4 ? 'checked' : '';?>id="zrwh_zhou4" value="4" />周四 
		  <input name="zrwh_zhou5" type="checkbox"<?=$web_site['zrwh_zhou5']==5 ? 'checked' : '';?>id="zrwh_zhou5" value="5" />周五 
		  <input name="zrwh_zhou6" type="checkbox"<?=$web_site['zrwh_zhou6']==6 ? 'checked' : '';?>id="zrwh_zhou6" value="6" />周六 
		  <input name="zrwh_zhou7" type="checkbox"<?=$web_site['zrwh_zhou7']==7 ? 'checked' : '';?>id="zrwh_zhou7" value="7" />周日 
		  维护时间:<input name="zrwh_begin" type="text" class="textfield" maxlength="5" id="zrwh_begin" value="<?=$web_site['zrwh_begin'];?>" size="4"> 
		  ~ 
		  <input name="zrwh_end" type="text" class="textfield" maxlength="5" id="zrwh_end" value="<?=$web_site['zrwh_end'];?>" size="4"><br> 
	  </td> 
	</tr> 
	--> 
	<tr> 
	  <td height="30" align="right" >  额度转换最低：</td> 
	  <td><input name="zh_low" type="text" class="textfield" maxlength="10" id="zh_low" value="<?=$web_site['zh_low'];?>" size="10"> 
		  额度转换最高：<input name="zh_high" type="text" class="textfield" maxlength="10" id="zh_high" value="<?=$web_site['zh_high'];?>" size="10"> 
		  汇款赠送比例：<select name="default_hkzs" id="default_hkzs"> 
			  <option value="0.0"<?=$web_site['default_hkzs']==0 ? ' selected' : '';?>>0.0%</option> 
			  <option value="0.1"<?=$web_site['default_hkzs']==0.1 ? ' selected' : '';?>>0.1%</option> 
			  <option value="0.2"<?=$web_site['default_hkzs']==0.2 ? ' selected' : '';?>>0.2%</option> 
			  <option value="0.3"<?=$web_site['default_hkzs']==0.3 ? ' selected' : '';?>>0.3%</option> 
			  <option value="0.4"<?=$web_site['default_hkzs']==0.4 ? ' selected' : '';?>>0.4%</option> 
			  <option value="0.5"<?=$web_site['default_hkzs']==0.5 ? ' selected' : '';?>>0.5%</option> 
			  <option value="0.6"<?=$web_site['default_hkzs']==0.6 ? ' selected' : '';?>>0.6%</option> 
			  <option value="0.7"<?=$web_site['default_hkzs']==0.7 ? ' selected' : '';?>>0.7%</option> 
			  <option value="0.8"<?=$web_site['default_hkzs']==0.8 ? ' selected' : '';?>>0.8%</option> 
			  <option value="0.9"<?=$web_site['default_hkzs']==0.9 ? ' selected' : '';?>>0.9%</option> 
			  <option value="1.0"<?=$web_site['default_hkzs']==1 ? ' selected' : '';?>>1.0%</option> 
			  <option value="1.1"<?=$web_site['default_hkzs']==1.1 ? ' selected' : '';?>>1.1%</option> 
			  <option value="1.2"<?=$web_site['default_hkzs']==1.2 ? ' selected' : '';?>>1.2%</option> 
			  <option value="1.3"<?=$web_site['default_hkzs']==1.3 ? ' selected' : '';?>>1.3%</option> 
			  <option value="1.4"<?=$web_site['default_hkzs']==1.4 ? ' selected' : '';?>>1.4%</option> 
			  <option value="1.5"<?=$web_site['default_hkzs']==1.5 ? ' selected' : '';?>>1.5%</option> 
			  <option value="1.6"<?=$web_site['default_hkzs']==1.6 ? ' selected' : '';?>>1.6%</option> 
			  <option value="1.7"<?=$web_site['default_hkzs']==1.7 ? ' selected' : '';?>>1.7%</option> 
			  <option value="1.8"<?=$web_site['default_hkzs']==1.8 ? ' selected' : '';?>>1.8%</option> 
			  <option value="1.9"<?=$web_site['default_hkzs']==1.9 ? ' selected' : '';?>>1.9%</option> 
			  <option value="2.0"<?=$web_site['default_hkzs']==2 ? ' selected' : '';?>>2.0%</option> 
			  <option value="2.1"<?=$web_site['default_hkzs']==2.1 ? ' selected' : '';?>>2.1%</option> 
			  <option value="2.2"<?=$web_site['default_hkzs']==2.2 ? ' selected' : '';?>>2.2%</option> 
			  <option value="2.3"<?=$web_site['default_hkzs']==2.3 ? ' selected' : '';?>>2.3%</option> 
			  <option value="2.4"<?=$web_site['default_hkzs']==2.4 ? ' selected' : '';?>>2.4%</option> 
			  <option value="2.5"<?=$web_site['default_hkzs']==2.5 ? ' selected' : '';?>>2.5%</option> 
			  <option value="2.6"<?=$web_site['default_hkzs']==2.6 ? ' selected' : '';?>>2.6%</option> 
			  <option value="2.7"<?=$web_site['default_hkzs']==2.7 ? ' selected' : '';?>>2.7%</option> 
			  <option value="2.8"<?=$web_site['default_hkzs']==2.8 ? ' selected' : '';?>>2.8%</option> 
			  <option value="2.9"<?=$web_site['default_hkzs']==2.9 ? ' selected' : '';?>>2.9%</option> 
			  <option value="3.0"<?=$web_site['default_hkzs']==3 ? ' selected' : '';?>>3.0%</option> 
		  </select></td> 
	</tr> 
	<tr> 
	  <td height="30" align="right" >  会员中心主题：</td> 
	  <td><select name="member_theme" id="member_theme"> 
			  <option value="default">默认主题</option> 
			  <option value="greed"<?=$web_site['member_theme']=='greed' ? ' selected' : '';?>>绿色主题</option> 
			  <option value="blue"<?=$web_site['member_theme']=='blue' ? ' selected' : '';?>>蓝色主题</option> 
		  </select></td> 
	</tr> 
	<!--//2015-05-23(功能：提醒用户按时更换密码) --> 
	<tr> 
	  <td height="30" align="right" >  会员安全管理：</td> 
	  <td>提示会员定期&nbsp;<input name="modify_pwd_c" type="text" class="textfield" maxlength="3" style="width:30px;" id="modify_pwd_c" value="<?=$rows['modify_pwd_c'];?>" size="3"/>&nbsp;天修改密码</td> 
	</tr> 
	<tr> 
	  <td width="160" height="30" align="right">&nbsp;</td> 
	  <td width="816"><input name="close" type="checkbox" id="close" value="1" <?=$web_site['close']==1 ? 'checked' : '';?>>
		网站关闭&nbsp;（出现攻击时请先关闭再排查）</td> 
	</tr>
    <tr>
      <td height="20" align="right" >  网站关闭时间：</td>
      <td>
          <input name="close_time" value="<?=$web_site['close_time'];?>">
      </td>
    </tr>
    <tr>
	  <td height="20" align="right" >  网站关闭原因：</td>
	  <td> 
	  <textarea name="why" cols="80" class="textfield" rows="2" id="why" ><?=$web_site['why'];?></textarea></td>
	</tr> 
	<tr> 
	  <td height="30" align="right">&nbsp;</td> 
	  <td valign="bottom"><input name="submitSaveEdit" type="submit" class="button"  id="submitSaveEdit" value="保存" style="width: 60px;" ></td>
	</tr> 
	<tr> 
	  <td height="20" align="right">&nbsp;</td> 
	  <td valign="bottom">&nbsp;</td> 
	</tr> 
  </table></td> 
</tr> 
</form> 
</table></td> 
</tr> 
</table> 
</body> 
</html>