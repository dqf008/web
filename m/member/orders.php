<?php 
session_start();
include_once '../../include/config.php';
website_close();
website_deny();
include_once '../../database/mysql.config.php';
include_once '../../common/login_check.php';
include_once '../../common/logintu.php';
include_once '../../common/function.php';
include_once '../../class/user.php';
include_once '../../include/newpage.php';
include_once '../../member/function.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($uid);
$p_type = $_GET['p_type'];
$m_type = $_GET['m_type'];
$order_name = '';
if ($p_type == 'c'){
	$m_type = 1;
	$order_name = '存款';
	$order_name2 = '手续费(公司支付)';
}else if ($p_type == 'h'){
	$m_type = 7;
	$order_name = '汇款';
	$order_name2 = '赠送金额';
}else if ($p_type == 't'){
	$m_type = 2;
	$order_name = '提款';
	$order_name2 = '手续费(公司支付)';
}else if ($p_type == 'o'){
	$m_type = ($m_type == '' ? '3,4,5,6' : intval($m_type));
	$order_name = '加减款';
}else{
	$p_type = 'c';
	$m_type = 1;
	$order_name = '存款';
	$order_name2 = '手续费(公司支付)';
}
$cn_begin = $_GET['cn_begin'];
$s_begin_h = $_GET['s_begin_h'];
$s_begin_i = $_GET['s_begin_i'];
$cn_begin = ($cn_begin == '' ? date('Y-m-d', time()) : $cn_begin);
$s_begin_h = ($s_begin_h == '' ? '00' : $s_begin_h);
$s_begin_i = ($s_begin_i == '' ? '00' : $s_begin_i);
$cn_end = $_GET['cn_end'];
$s_end_h = $_GET['s_end_h'];
$s_end_i = $_GET['s_end_i'];
$cn_end = ($cn_end == '' ? date('Y-m-d', time()) : $cn_end);
$s_end_h = ($s_end_h == '' ? '23' : $s_end_h);
$s_end_i = ($s_end_i == '' ? '59' : $s_end_i);
$begin_time = $cn_begin . ' ' . $s_begin_h . ':' . $s_begin_i . ':00';
$end_time = $cn_end . ' ' . $s_end_h . ':' . $s_end_i . ':59';
?>
<!DOCTYPE html> 
<html class="ui-mobile ui-mobile-viewport ui-overlay-a"> 
<head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
  <title><?=$web_site['web_title'];?></title> 
  <!--[if lt IE 9]> 
	  <script src="js/html5.js" type="text/javascript"> 
	  </script> 
	  <script src="js/css3-mediaqueries.js" type="text/javascript"> 
	  </script> 
  <![endif]--> 
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"> 
  <meta content="yes" name="apple-mobile-web-app-capable"> 
  <meta content="black" name="apple-mobile-web-app-status-bar-style"> 
  <meta content="telephone=no" name="format-detection"> 
  <meta name="viewport" content="width=device-width"> 
  <link rel="shortcut icon" href="../images/favicon.ico"> 
  <link rel="stylesheet" href="../css/style.css" type="text/css" media="all"> 
  <link rel="stylesheet" href="../js/jquery.mobile-1.4.5.min.css"> 
  <link rel="stylesheet" href="../css/style_index.css" type="text/css" media="all"> 
  <script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script> 
  <script type="text/javascript" src="../js/jquery.mobile-1.4.5.min.js"></script> 
  <!--js判断横屏竖屏自动刷新--> 
  <script type="text/javascript" src="../js/top.js"></script> 
</head> 
<body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" data-url="/m/member/orders.php" tabindex="0" style="min-height: 659px;"> 
  <!--头部开始--> 
  <header id="header"> 
	  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a> 
		  <span>财务记录</span> 
	  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"></a> 
  </header> 
  <div class="mrg_header"></div> 
  <!--头部结束--> 


  <!--功能列表--> 
  <section class="mContent clearfix" style="padding:0px;"> 
	  <div data-role="cotent"> 
		  <form action="orders.php" method="get" name="lt_form" data-role="none" data-ajax="false"> 
			  <input type="hidden" name="p_type" value="<?=$p_type;?>"> 
			  <ul data-role="listview" class="ui-listview"> 
				  <li class="ui-li-static ui-body-inherit ui-first-child"> 
					  <div data-role="controlgroup" data-type="horizontal" class="ui-controlgroup ui-controlgroup-horizontal ui-corner-all"> 
						  <div class="ui-controlgroup-controls "> 
							  <a href="orders.php?p_type=c" data-ajax="false" data-role="button" data-mini="true" data-corners="false" data-shadow="false" <?=$p_type=='c' ? 'style="color:#f60;"' : '';?> class="ui-link ui-btn ui-mini ui-first-child" role="button">存款</a> 
							  <a href="orders.php?p_type=h" data-ajax="false" data-role="button" data-mini="true" data-corners="false" data-shadow="false" <?=$p_type=='h' ? 'style="color:#f60;"' : '';?> class="ui-link ui-btn ui-mini" role="button">汇款</a> 
							  <a href="orders.php?p_type=t" data-ajax="false" data-role="button" data-mini="true" data-corners="false" data-shadow="false" <?=$p_type=='t' ? 'style="color:#f60;"' : '';?> class="ui-link ui-btn ui-mini" role="button">提款</a> 
							  <a href="orders.php?p_type=o" data-ajax="false" data-role="button" data-mini="true" data-corners="false" data-shadow="false" <?=$p_type=='o' ? 'style="color:#f60;"' : '';?> class="ui-link ui-btn ui-mini ui-last-child" role="button">其他</a> 
						  </div> 
					  </div> 
				  </li>
				  <?php if ($p_type == 'o'){?> 					  
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>操作类型 
						  <select name="m_type" id="m_type" data-role="none"> 
							  <option value=""  <?=$m_type=='3,4,5,6' ? 'selected' : '';?>>全部</option> 
							  <option value="3" <?=$m_type==3 ? 'selected' : '';?>>人工汇款</option> 
							  <option value="4" <?=$m_type==4 ? 'selected' : '';?>>彩金派送</option> 
							  <option value="5" <?=$m_type==5 ? 'selected' : '';?>>反水派送</option> 
							  <option value="6" <?=$m_type==6 ? 'selected' : '';?>>其他情况</option> 
						  </select> 
					  </label> 
				  </li>
				  <?php }?> 					  
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>开始日期 
						  <select name="cn_begin" id="cn_begin" data-role="none">
						  <?php 
							for ($bh_d = 0;$bh_d < 60;$bh_d++){
								$b_d_value = date('Y-m-d', strtotime('-' . $bh_d . ' day'));
						  ?>								  
						  	<option value="<?=$b_d_value;?>"<?=$cn_begin==$b_d_value ? 'selected' : '';?>><?=$b_d_value;?></option>
						  <?php }?> 							  
						  </select> 
						  
						  
						  <select name="s_begin_h" id="s_begin_h" data-role="none">
						  <?php 
							for ($bh_i = 0;$bh_i < 24;$bh_i++){
								$b_h_value = ($bh_i < 10 ? '0' . $bh_i : $bh_i);
						  ?>								  
						  	<option value="<?=$b_h_value;?>"<?=$s_begin_h==$b_h_value ? 'selected' : '';?>><?=$b_h_value;?></option>
						  <?php }?> 							  
						  </select> 
						  
						  <select name="s_begin_i" id="s_begin_i" data-role="none">
						  <?php 
							for ($bh_j = 0;$bh_j < 60;$bh_j++){
							$b_i_value = ($bh_j < 10 ? '0' . $bh_j : $bh_j);
						  ?>								  
						  <option value="<?=$b_i_value;?>"<?=$s_begin_i==$b_i_value ? 'selected' : '';?>><?=$b_i_value;?></option>
						  <?php }?> 							  
						  </select> 
					  </label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>结束日期 
						  <select name="cn_end" id="cn_end" data-role="none">
						  <?php 
							for ($eh_d = 0;$eh_d < 60;$eh_d++){
							$e_d_value = date('Y-m-d', strtotime('-' . $eh_d . ' day')) . '';
						  ?>								  
						  <option value="<?=$e_d_value;?>"<?=$cn_end==$e_d_value ? 'selected' : '';?>><?=$e_d_value;?></option>
						  <?php }?> 							  
						  </select> 
						  
						  <select name="s_end_h" id="s_end_h" data-role="none">
						  <?php 
							for ($eh_i = 0;$eh_i < 24;$eh_i++){
							$e_h_value = ($eh_i < 10 ? '0' . $eh_i : $eh_i);
						  ?>								  
						  <option value="<?=$e_h_value;?>"<?=$s_end_h==$e_h_value ? 'selected' : '';?>><?=$e_h_value;?></option>
						  <?php }?> 							  
						  </select> 
						  
						  
						  <select name="s_end_i" id="s_end_i" data-role="none">
						  <?php 
							for ($eh_j = 0;$eh_j < 60;$eh_j++){
								$e_i_value = ($eh_j < 10 ? '0' . $eh_j : $eh_j);
						  ?>								  
						  <option value="<?=$e_i_value;?>"<?=$s_end_i==$e_i_value ? 'selected' : '';?>><?=$e_i_value;?></option>
						  <?php }?> 							  
						  </select> 
					  </label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit ui-last-child"> 
					  <div style="clear:both;text-align:center;"> 
						  <input type="submit" id="ipt_query" name="query" class="ui-btn ui-btn-inline" value="查询" data-role="none"> 
					  </div> 
				  </li> 
			  </ul> 
		  </form> 
		  <ul data-role="listview" class="ui-listview">
			<?php 
			$params = array(':uid' => $uid, ':begin_time' => $begin_time, ':end_time' => $end_time);
			if ($p_type == 'h'){
				$sql = 'select id as m_id from `huikuan` where `uid`=:uid and `adddate`>=:begin_time and `adddate`<=:end_time order by `id` desc';
			}else{
				$sql = 'select m_id from `k_money` where `uid`=:uid and type in(' . $m_type . ') and `m_make_time`>=:begin_time and `m_make_time`<=:end_time order by `m_id` desc';
			}
			
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$sum = $stmt->rowCount();
			$thisPage = 1;
			
			if (@($_GET['page'])){
				$thisPage = $_GET['page'];
			}
			
			$page = new newPage();
			$perpage = 20;
			$thisPage = $page->check_Page($thisPage, $sum, $perpage);
			$id = '';
			$i = 1;
			$start = (($thisPage - 1) * $perpage) + 1;
			$end = $thisPage * $perpage;
			
			while ($row = $stmt->fetch()){
				if (($start <= $i) && ($i <= $end)){
					$id .= intval($row['m_id']) . ',';
				}
				
				if ($end < $i){
					break;
				}
				$i++;
			}
			
			if ($id){
				$id = rtrim($id, ',');
				if ($p_type == 'h'){
					$sql = 'select lsh as m_order,adddate as m_make_time,money as m_value,zsjr,bank,manner,status from `huikuan` where id in(' . $id . ') order by id desc';
				}else{
					$sql = 'select * from k_money where m_id in(' . $id . ') order by m_id desc';
				}
				$query = $mydata1_db->query($sql);
				$i = 1;
				$sum_money = 0;
				$sum_sxf = 0;
				while ($rows = $query->fetch())
				{
			?> 							  
						  <li data-role="list-divider" role="heading" class="ui-li-divider ui-bar-inherit ui-first-child"> 
							  <label style="width:87px;float:left;"><?=$order_name;?>流水号:</label> 
							  <label style="float:left;"><?=$rows['m_order'];?></label> 
						  </li> 
						  <li class="ui-li-static ui-body-inherit"> 
							  <label>美东时间：<?=date('Y-m-d H:i:s',strtotime($rows['m_make_time']));?></label> 
						  </li> 
						  <li class="ui-li-static ui-body-inherit"> 
							  <label>北京时间：<?=date('Y-m-d H:i:s',strtotime($rows['m_make_time']) + (1 * 12 * 3600));?></label> 
						  </li>
						  <?php if ($p_type == 'h'){?> 							  
						  <li class="ui-li-static ui-body-inherit"> 
							  <label style="width:80px;float:left;">汇款银行：</label> 
							  <label style="float:left;"><?=$rows['bank'];?></label> 
						  </li> 
						  <li class="ui-li-static ui-body-inherit"> 
							  <label>汇款方式：<?=$rows['manner'];?></label> 
						  </li> 
						  <li class="ui-li-static ui-body-inherit"> 
							  <label>汇款赠送：<?=sprintf('%.2f',$rows['zsjr']);?></label> 
						  </li>
						  <?php }?> 							  
						  <li class="ui-li-static ui-body-inherit"> 
							  <label><?=$order_name;?>金额：<?=sprintf('%.2f',$rows['m_value']);?></label> 
						  </li>
						  <?php if (($p_type == 'c') || ($p_type == 't')){?> 							  
						  <li class="ui-li-static ui-body-inherit"> 
							  <label>手续费：<?=sprintf('%.2f',abs($rows['sxf']));?></label> 
						  </li>
						  <?php }
							if ($p_type == 'o'){
						  ?> 							  
						  <li class="ui-li-static ui-body-inherit"> 
							  <label>类型：<?=mtypeName($rows['type']);?></label> 
						  </li>
						  <?php }
							if ($p_type == 't'){
						  ?> 							  
						  <li class="ui-li-static ui-body-inherit"> 
							  <label>银行卡号：<?=cutNum($rows['pay_num']);?></label> 
						  </li>
						  <?php }?> 							  
						  <li class="ui-li-static ui-body-inherit"> 
							  <label style="width:80px;float:left;">备注说明：</label> 
							  <label style="float:left;white-space:normal;"><?=$rows['about'];?></label> 
						  </li> 
						  <li class="ui-li-static ui-body-inherit"> 
							  <label><?=$order_name;?>状态：
								  <?php 
								  if ($rows['status'] == 1){
									if ($p_type != 'o'){
										$sum_money += $rows['m_value'];
									}
									
									if ($p_type == 'h'){
										$sum_sxf += $rows['zsjr'];
									}else if ($p_type == 'o'){
										if (0 < $rows['m_value']){
											$sum_money += abs($rows['m_value']);
										}else{
											$sum_sxf += abs($rows['m_value']);
										}
									}else{
										$sum_sxf += $rows['sxf'];
									}
									echo '<span style="color:#FF0000;">成功</span>';
								}else if ((($rows['status'] == 0) && ($p_type != 'h')) || (($rows['status'] == 2) && ($p_type == 'h'))){
									echo '<span style="color:#000000;">失败</span>';
								}else{
									echo '<span style="color:#0000FF;">系统审核中</span>';
								}
								?>                       
							  </label> 
						  </li>
						  <?php 
						  	$i++;
						  }?> 						  
						  <li class="ui-li-static ui-body-inherit ui-last-child"> 
						  <div style="clear:both;text-align:left;line-height:28px;">
						  <?php if ($p_type != 'o'){?> 								  
						  本页<?=$order_name;?>成功总金额：<font color="#FF0000"><?=$sum_money;?></font>RMB<br><?=$order_name2;?>：<font color="#FF0000"><?=$sum_sxf;?></font>RMB<br>
						  <?php }else{?> 								  
						  本页加款成功总金额：<font color="#FF0000"><?=$sum_money;?></font>RMB<br> 
						  本页减款成功总金额：<font color="#FF0000"><?=$sum_sxf;?></font>RMB<br>
						  <?php }
							echo $page->get_htmlPage('orders.php?cn_begin='.$cn_begin.'&s_begin_h='.$s_begin_h.'&s_begin_i='.$s_begin_i.'&cn_end='.$cn_end.'&s_end_h='.$s_end_h.'&s_end_i='.$s_end_i);
						  ?>                       
						  </div> 
					  </li>
					  <?php }else{?> 				  
					  <li class="ui-li-static ui-body-inherit ui-last-child"> 
				  <div style="clear:both;text-align:left;"> 
						  查找不到记录！ 
				  </div> 
			  </li>
			  <?php }?> 			  
			</ul> 
	  </div> 
  </section> 
  <!--底部开始--><?php include_once '../bottom.php';?>	  <!--底部结束--> 
  <!--我的资料--><?php include_once 'myinfo.php';?>
  </body> 
<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div> 
</html>