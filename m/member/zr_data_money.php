<?php 
session_start();
include_once '../../include/config.php';
website_close();
website_deny();
include_once '../../database/mysql.config.php';
include_once '../../common/login_check.php';
include_once '../../common/logintu.php';
include_once '../../common/function.php';
include_once '../../include/newpage.php';
include_once '../../class/user.php';
include_once '../../member/function.php';
include_once '../../cj/include/function.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($uid);
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
$live_type = $_GET['live_type'];
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
<body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" data-url="/m/member/zr_money.php" tabindex="0" style="min-height: 640px;"> 
	
  <!--头部开始--> 
  <header id="header"> 
		  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a> 
		  <span>转换记录</span> 
	  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"></a> 
  </header> 
  <div class="mrg_header"></div> 
  <!--头部结束--> 



  <!--功能列表--> 
  <section class="mContent clearfix" style="padding:0px;"> 
	  <div data-role="cotent"> 
		  <form action="zr_data_money.php" method="get" name="lt_form" data-role="none" data-ajax="false"> 
			  <ul data-role="listview" class="ui-listview"> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>转账类型： 
						  <select name="live_type" id="live_type" data-role="none"> 
							  <option value="" <?=$live_type==''? 'selected' :'' ;?>>全部</option> 
							  <option value="AGIN" <?=$live_type=='AGIN' ? 'selected' : '';?>>AG国际厅</option> 
							  <option value="AG" <?=$live_type=='AG' ? 'selected' :'' ;?>>AG极速厅</option> 
                              <option value="BBIN" <?=$live_type=='BBIN' ? 'selected' :'' ;?>>BB波音厅</option> 
                              <option value="OG" <?=$live_type=='OG' ? 'selected' :'' ;?>>OG东方厅</option>
                              <option value="MAYA" <?=$live_type=='MAYA' ? 'selected' :'' ;?>>玛雅娱乐厅</option>
                              <option value="ABA" <?=$live_type=='ABA' ? 'selected' :'' ;?>>ABA壹号馆</option>
                              <option value="SHABA" <?=$live_type=='SHABA' ? 'selected' : '';?>>沙巴体育</option>   
                              <option value="MG" <?=$live_type=='MG' ? 'selected' :'' ;?>>MG电子游戏</option> 
                              <option value="MW" <?=$live_type=='MW' ? 'selected' :'' ;?>>MW电子游戏</option> 
                              <option value="KG" <?=$live_type=='KG' ? 'selected' :'' ;?>>AV女优</option> 
						  </select> 
					  </label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>开始日期 
						  <select name="cn_begin" id="cn_begin" data-role="none">
						  <?php 
							for ($bh_d = 0;$bh_d < 60;$bh_d++){
								$b_d_value = date('Y-m-d', strtotime('-' . $bh_d . ' day'));
						  ?>								  
						  <option value="<?=$b_d_value;?>" <?=$cn_begin==$b_d_value ? ' selected' : '';?>><?=$b_d_value;?></option>
						  <?php }?> 							  
						  </select> 
						  
						  <select name="s_begin_h" id="s_begin_h" data-role="none">
						  <?php 
							for ($bh_i = 0;$bh_i < 24;$bh_i++){
								$b_h_value = ($bh_i < 10 ? '0' . $bh_i : $bh_i);
						  ?>								  
						  	<option value="<?=$b_h_value;?>" <?=$s_begin_h==$b_h_value ? ' selected' : '';?>><?=$b_h_value;?></option>
						  <?php }?> 							  
						  </select> 
						  
						  <select name="s_begin_i" id="s_begin_i" data-role="none">
						  <?php 
							for ($bh_j = 0;$bh_j < 60;$bh_j++){
								$b_i_value = ($bh_j < 10 ? '0' . $bh_j : $bh_j);
						  ?>								  
						  <option value="<?=$b_i_value;?>"<?=$s_begin_i==$b_i_value ? ' selected' : '';?>><?=$b_i_value;?></option>
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
							<option value="<?=$e_d_value;?>"<?=$cn_end==$e_d_value ? ' selected' : '';?>><?=$e_d_value;?></option>
						  <?php }?> 							  
						  </select> 
						  
						  <select name="s_end_h" id="s_end_h" data-role="none">
						  <?php 						  
							for ($eh_i = 0;$eh_i < 24;$eh_i++){
								$e_h_value = ($eh_i < 10 ? '0' . $eh_i : $eh_i);
						  ?>								  
						  <option value="<?=$e_h_value;?>"<?=$s_end_h==$e_h_value ? ' selected' : '';?>><?=$e_h_value;?></option>
						  <?php }?> 							  
						  </select> 
						  <select name="s_end_i" id="s_end_i" data-role="none">
						  <?php 
							for ($eh_j = 0;$eh_j < 60;$eh_j++){
								$e_i_value = ($eh_j < 10 ? '0' . $eh_j : $eh_j);
						  ?>								  
							<option value="<?=$e_i_value;?>"<?=$s_end_i==$e_i_value ? ' selected' : '';?>><?=$e_i_value;?></option>
						  <?php }?> 							  
						  </select> 
					  </label> 
				  </li> 
				   
				  <li class="ui-li-static ui-body-inherit ui-last-child"> 
					  <div style="clear:both;text-align:center;"> 
						  <input type="submit"  class="ui-btn ui-btn-inline" value="查询" data-role="none"> 
					  </div> 
				  </li> 
			  </ul> 
		  </form> 
		  <ul data-role="listview" class="ui-listview">
			<?php 
			$params = array();
			if ($live_type != ''){
				$params[':live_type'] = $live_type;
				$sqlwhere = ' and live_type=:live_type';
			}
			$params[':uid'] = $uid;
			$params[':begin_time'] = $begin_time;
			$params[':end_time'] = $end_time;
			$sql = 'select id from `ag_zhenren_zz` where `uid`=:uid ' . $sqlwhere . ' and `zz_time`>=:begin_time and `zz_time`<=:end_time order by `id` desc';
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
					$id .= intval($row['id']) . ',';
				}
				
				if ($end < $i){
					break;
				}
				$i++;
			}
			
			if ($id){
				$id = rtrim($id, ',');
				$sql = 'select * from `ag_zhenren_zz` where id in(' . $id . ') order by id desc';
				$query = $mydata1_db->query($sql);
				$i = 1;
				$inmoney = 0;
				$outmoney = 0;
				while ($rows = $query->fetch()){
			?> 				 
			  <li data-role="list-divider" role="heading" class="ui-li-divider ui-bar-inherit ui-first-child"> 
			  记录：<?=$rows['id'];?>                    
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
			  美东时间：<?=date('Y-m-d H:i:s',strtotime($rows['zz_time']));?>                     
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
			  北京时间：<?=date('Y-m-d H:i:s',strtotime($rows['zz_time']) + (1 * 12 * 3600));?>                     
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
			  转换类型：
			  <?php

					$str = typeName($rows["live_type"]);
					$typeName = $str['title'];
				

				if($rows['zz_type']=='IN'){
					echo '体育/彩票 → '.$typeName;
				}elseif($rows['zz_type']=='OUT'){
					echo $typeName.' → 体育/彩票';
				}

				
			  ?>                    
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
			  转换流水号：<?=$rows['billno'];?>                     
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
			  金额：<?=sprintf('%.2f',$rows['zz_money']);?>                    
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
			  状态：<?=$rows["ok"]==0?"处理中":"已处理"?>                   
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
			  结果：<?=$rows['result'];?>                   
			  </li>
			  <?php 
			  	if ($rows['ok'] == 1){
					if ($rows['zz_type'] == 'IN'){
						$inmoney += abs($rows['zz_money']);
					}else if ($rows['zz_type'] == 'OUT'){
						$outmoney += abs($rows['zz_money']);
					}
					
				}
				$i++;
			}

			?> 				  
				<li class="ui-li-static ui-body-inherit ui-last-child"> 
				  <div style="clear:both;text-align:left;"> 
				  本页转账成功：<br> 
				  [转入]<font color="#FF0000"><?=sprintf('%.2f',$inmoney);?></font>RMB<br> 
				  [转出]<font color="#FF0000"><?=sprintf('%.2f',$outmoney);?></font>RMB<br>
				  <?=$page->get_htmlPage('zr_data_money.php?cn_begin='.$cn_begin.'&s_begin_h='.$s_begin_h.'&s_begin_i='.$s_begin_i.'&cn_end='.$cn_end.'&s_end_h='.$s_end_h.'&s_end_i='.$s_end_i.'&live_type='.$live_type);?>                      
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