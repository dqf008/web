<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('sjgl');
if (@($_GET['ok'])){
	$db1_table = 'ag_zhenren_zz,agaccounttransfer,agbetdetail,agxmlconfig,ban_ip,c_auto_2,c_auto_3,c_auto_4,c_bet,c_bet_3,c_odds_2,c_odds_2_m,c_odds_3,c_odds_3_m,c_odds_4,c_odds_4_m,c_opentime_2,c_opentime_3,c_opentime_4,fs_account,fs_level,history_bank,huikuan,k_bet,k_bet_cg,k_bet_cg_group,k_group,k_hyfl,k_money,k_money_log,k_notice,k_um,k_user,k_user_daili,k_user_daili_result,k_user_login,k_user_msg,lottery_data,lottery_k_3d,lottery_k_kl8,lottery_k_pl3,lottery_k_ssl,lottery_odds,lottery_t_kl8,lottery_t_ssl,message,web_config,webinfo,zhenren_config,hgbetdetail,hgtransferdetail,hgxmlconfig,bbbetdetail,bbtransferdetail,bbxmlconfig,mgaccounttransfer,mgbetdetail,mgxmlconfig,dsbetdetail,dsxmlconfig';
	$mydata1_db->query('REPAIR TABLE ' . $db1_table);
	$mydata1_db->query('OPTIMIZE TABLE ' . $db1_table);
	$db2_table = 'mydata2_db.adad,mydata2_db.config,mydata2_db.ha_kithe,mydata2_db.ha_num,mydata2_db.ha_tan,mydata2_db.ka_admin,mydata2_db.ka_bl,mydata2_db.ka_color,mydata2_db.ka_drop,mydata2_db.ka_guan,mydata2_db.ka_guands,mydata2_db.ka_kithe,mydata2_db.ka_mem,mydata2_db.ka_quota,mydata2_db.ka_sxnumber,mydata2_db.ka_tan,mydata2_db.ka_tong,mydata2_db.ka_zi,mydata2_db.m_color,mydata2_db.tj,mydata2_db.ya_kithe';
	$mydata2_db->query('REPAIR TABLE ' . $db2_table);
	$mydata2_db->query('OPTIMIZE TABLE ' . $db2_table);
	$db3_table = 'mydata3_db.admin_login,mydata3_db.history_login,mydata3_db.ip_la,mydata3_db.save_user,mydata3_db.securitycard,mydata3_db.sys_admin,mydata3_db.sys_log';
	$mydata1_db->query('REPAIR TABLE ' . $db3_table);
	$mydata1_db->query('OPTIMIZE TABLE ' . $db3_table);
	$db4_table = 'mydata4_db.baseball_match,mydata4_db.bet_match,mydata4_db.gunqiu,mydata4_db.lq_match,mydata4_db.t_guanjun,mydata4_db.t_guanjun_team,mydata4_db.tennis_match,mydata4_db.volleyball_match';
	$mydata1_db->query('REPAIR TABLE ' . $db4_table);
	$mydata1_db->query('OPTIMIZE TABLE ' . $db4_table);
	message('数据库一键修复优化完成');
}
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
<title>数据优化</title> 
<link rel="stylesheet" href="../Images/CssAdmin.css"> 
<style> 
  .input { width: 150px;float: left;} 
  .clear { clear: both;} 
</style> 
</head> 
<body> 
<br /><br /><br /><br /> 
<form id="form1" name="form1" method="post" action="?ok=1"> 
<div align="center"> 
  <p> 
	  <input type="submit" name="Submit" value="一键修复优化数据库" /> 
  </p> 
</div> 
</form> 
<br /> 
<p>一键自动优化数据库用于回收闲置的数据库空间，当表上的数据行被删除时，所占据的磁盘空间并没有立即被回收。</p> 
<p>执行了一键自动优化数据库后这些空间将被回收，并且对磁盘上的数据行进行重排（注意：是磁盘上，而非数据库）。</p> 
<p>多数时间并不需要运行一键自动优化数据库，只需在批量删除数据行之后，或定期（每周一次或每月一次）进行操作即可 。</p> 
</body> 
</html>