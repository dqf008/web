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
$p_type = 'ty';
$atype = $_GET['atype'];
if (($atype != 'ds') && ($atype != 'cg')){
	$atype = 'ds';
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
<body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" tabindex="0" style="min-height: 659px;"> 
  <!--头部开始--> 
  <header id="header"> 
  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a> 
  <span>下注记录</span> 
  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"></a> 
  </header> 
  <div class="mrg_header"></div> 
  <!--头部结束--> 

  <!--功能列表--> 
  <section class="mContent clearfix" style="padding:0px;"> 
	  <div data-role="cotent"> 
		  <form action="records_ty.php" method="get" name="lt_form" data-role="none" data-ajax="false"> 
			  <input type="hidden" name="atype" value="<?=$atype;?>"> 
			  <ul data-role="listview" class="ui-listview">
			  <?php include_once 'records_head.php';?>					  
			  	  <li class="ui-li-static ui-body-inherit"> 
					  <label>游戏类型 
						  <select name="atype" id="atype" data-role="none"> 
							  <option value="ds"<?=$atype=='ds' ? ' selected' : '';?>>体育单式</option> 
							  <option value="cg"<?=$atype=='cg' ? ' selected' : '';?>>体育串关</option> 
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
						  <input type="submit" id="ipt_query" name="query" class="ui-btn ui-btn-inline" value="查询" data-role="none"> 
					  </div> 
				  </li> 
			  </ul> 
		  </form> 
		  <ul data-role="listview" class="ui-listview">
<?php 
if ($atype == 'ds'){
$params = array(':uid' => $uid, ':begin_time' => $begin_time, ':end_time' => $end_time);
$sql = 'select bid from k_bet where status in (0,1,2,3,4,5,6,7,8) and uid=:uid and bet_time>=:begin_time and bet_time<=:end_time order by bid desc';
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
		$id .= intval($row['bid']) . ',';
	}
	
	if ($end < $i){
		break;
	}
	$i++;
}

if ($id){
	$id = rtrim($id, ',');
	$sql = 'select * from k_bet where bid in(' . $id . ') order by bid desc';
	$query = $mydata1_db->query($sql);
	$i = 1;
	$sum_tz = 0;
	$sum_pc = 0;
	$sum_fs = 0;
	while ($rows = $query->fetch()){
		$sum_tz += $rows['bet_money'];
		$sum_pc += $rows['win'];
		$sum_fs += $rows['fs'];
?>				  
			  <li data-role="list-divider" role="heading" class="ui-li-divider ui-bar-inherit ui-first-child"> 
				  <label> 
					  <div style="position:relative;padding-bottom:5px;">投注时间： 
						  <div style="position:absolute;top:0px;left:80px;"> 
							 <?=date('Y-m-d H:i:s',strtotime($rows['bet_time']));?>(美东)<br> 
							 <?=date('Y-m-d H:i:s',strtotime($rows['bet_time']) + (12 * 3600));?>(北京) 
						  </div> 
						  <div></div> 
					  </div> 
				  </label> 
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
				  <label>下注单号：<?=$rows['number'];?></label> 
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
				  <label>投注模式：<?=$rows['ball_sort'];?>
				  <?
					$m = explode('-', $rows['bet_info']);
					if (($rows['ball_sort'] == '冠军') || ($rows['ball_sort'] == '金融')){
					
					}else{
						echo $tz_type = $m[0];
					}
					
					if (3 < count($m)){
						$m[2] = preg_replace('[\\[(.*)\\]]', '', $m[2] . $m[3]);
						unset($m[3]);
					}
					
					if (mb_strpos($m[0], '胆')){
						$bodan_score = explode('@', $m[1], 2);
						$score = $bodan_score[0];
						$m[1] = '波胆@' . $bodan_score[1];
					}else{
						$score = '';
					}
					?> 					  
				</label> 
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
				  <label> 
					  <div style="position:relative;padding-bottom:5px;height:75px;">投注信息： 
						  <div style="position:absolute;top:0px;left:80px;"> 
							  <span style="color:#005481"><b><?=$rows['match_name'];?></b></span>
							  <?php 
							  	$m_count = count($m);
								preg_match('[\\((.*)\\)]', $m[$m_count - 1], $matches);
								if (strpos($rows['master_guest'], 'VS.')){
									$team = explode('VS.', $rows['master_guest']);
								}else{
									$team = explode('VS', $rows['master_guest']);
								}
								
								if ($rows['match_type'] == 2){
									echo $rows['match_time'];
									if (($rows['match_nowscore'] == '') && (strpos($rows['ball_sort'], '滚球') == false)){
										echo "(0:0)";
									}else if ((strtolower($rows['match_showtype']) == 'h') && (strpos($rows['ball_sort'], '滚球') == false)){ 
										echo "(".$rows['match_nowscore'].")";
									}else if (strpos($rows['ball_sort'], '滚球') == false){
										echo "(".strrev($rows['match_nowscore']).")";
									}
								}
								?> 								  
								<br />
								<?php 
								if (0 < mb_strpos($m[1], '让')){
									if (strtolower($rows['match_showtype']) == 'c'){
										echo $team[1];
										echo str_replace(array("主让","客让"),array("",""),$m[1]);
										echo $team[0];
										echo "(主)";
									}else{
										echo $team[0];
										echo str_replace(array("主让","客让"),array("",""),$m[1]);
										echo $team[1];
									}
									$m[1] = '';
								}else{
									echo $team[0];
									if (isset($score)){
										echo $score;
									}else{
										if ($team[1] != ''){ echo "VS.";}
									}
									echo '<font style="color:#890209">'.$team[1].'</font>';
								}
								?> 								  
							   <br />
							   <?php 
							    $arraynew = array($team[0], $team[1], '和局', ' / ', '局');
								$arrayold = array('主', '客', '和', '/', '局局');
								if (($rows['ball_sort'] == '冠军') || ($rows['ball_sort'] == '金融')){
									$ss = explode('@', $rows['bet_info']);
									echo '<font color="red">'.$ss[0].'</font> @ <font color="red">'.$ss[1].'</font>';
								}else{
									$ss = str_replace($arrayold, $arraynew, preg_replace('[\\((.*)\\)]', '', $m[$m_count - 1]));
									
									$ss = explode('@', $ss);
									if ($ss[0] == '独赢'){
										echo $m[1]."&nbsp;";
									}else if (strpos($ss[0], '独赢')){
										echo $m[1]."-";
									}
									
									echo str_replace(" ",'',$ss[0]);
									
									if ($rows['match_nowscore'] == ''){
									
									}else if ((strtolower($rows['match_showtype']) == 'h') || !strrpos($tz_type, '球')){
										echo "(".$rows['match_nowscore'].")";
									}else{
										echo "(".strrev($rows['match_nowscore']).")";
									}
									echo '  @ <font color="red">'.$ss[1].'</font>';
								}
								
								if (($rows['status'] != 0) && ($rows['status'] != 3) && ($rows['status'] != 7) && ($rows['status'] != 6)){
									if ((strtolower($rows['match_showtype']) == 'c') && (0 < strpos('&match_ao,match_ho,match_bho,match_bao&', $rows['point_column']))){
										echo "[".$rows['TG_Inball'].":".$rows['MB_Inball']."]";
									}else if (($rows['ball_sort'] == '冠军') || ($rows['ball_sort'] == '金融')){
										$paramsSub = array(':match_id' => $rows['match_id']);
										$sqlSub = 'select x_result from t_guanjun where match_id=:match_id';
										$stmtSub = $mydata1_db->prepare($sqlSub);
										$stmtSub->execute($paramsSub);
										if ($rs = $stmtSub->fetch()){
											$rs['x_result'] = str_replace('<br>', '&nbsp;', $rs['x_result']);
											echo "[".$rs['x_result']."]";
										}
									}else{
										echo "[".$rows['MB_Inball'].":".$rows['TG_Inball']."]";
									}
								}
								
								if (($rows['lose_ok'] == 0) && ($rows['ball_sort'] == '足球滚球' || $rows['ball_sort'] == '篮球滚球')){
									echo "[确认中]";
								}else if (($rows['status'] == 0) && ($rows['ball_sort'] == '足球滚球' || $rows['ball_sort'] == '篮球滚球')){
									echo "[已确认]";
							    }
								?>
						  </div> 
						  <div></div> 
					  </div> 
				  </label> 
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
				  <label>下注金额：<?=sprintf('%.2f',$rows['bet_money']);?></label> 
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
				  <label>可赢：<?=sprintf('%.2f',$rows['bet_win']);?></label> 
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
				  <label>派彩：<?=sprintf('%.2f',$rows['win']);?></label> 
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
				  <label>返水：<?=sprintf('%.2f',$rows['fs']);?></label> 
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
				  <label>状态：
				  <?php 
				  if ($rows['status'] == 0){
				  	echo "未结算";
				  }else if ($rows['status'] == 1){
				  	echo '<span style="color:#FF0000;">赢</span>';
				  }else if ($rows['status'] == 2){
				  	echo '<span style="color:#00CC00;">输</span>';
				  }else if ($rows['status'] == 8){
				  	echo '和局';
				  }else if ($rows['status'] == 3){
				  	echo '注单无效';
				  }else if ($rows['status'] == 4){
				  	echo '<span style="color:#FF0000;">赢一半</span>';
				  }else if ($rows['status'] == 5){
				  	echo '<span style="color:#00CC00;">输一半</span>';
				  }else if ($rows['status'] == 6){
				  	echo '进球无效';
				  }else if ($rows['status'] == 7){
				  	echo '红卡取消';
				  }
				  ?> 					  
				  </label> 
			  </li>
<?php 
			$i++;
		}
	}
}else{
	$params = array(':uid' => $uid, ':begin_time' => $begin_time, ':end_time' => $end_time);
	$sql = 'select gid from k_bet_cg_group where status in (0,1,2,3,4) and uid=:uid and bet_time>=:begin_time and bet_time<=:end_time order by gid desc';
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
			$id .= intval($row['gid']) . ',';
		}
		
		if ($end < $i){
			break;
		}
		$i++;
	}
	
	if ($id){
		$id = rtrim($id, ',');
		$sql = 'select * from k_bet_cg_group where gid in(' . $id . ') order by gid desc';
		$query = $mydata1_db->query($sql);
		$arr_b_cg = array();
		while ($rows = $query->fetch()){
			$arr_b_cg[$rows['gid']]['bet_time'] = $rows['bet_time'];
			$arr_b_cg[$rows['gid']]['cg_count'] = $rows['cg_count'];
			$arr_b_cg[$rows['gid']]['bet_money'] = $rows['bet_money'];
			$arr_b_cg[$rows['gid']]['bet_win'] = $rows['bet_win'];
			$arr_b_cg[$rows['gid']]['win'] = $rows['win'];
			$arr_b_cg[$rows['gid']]['fs'] = $rows['fs'];
			$arr_b_cg[$rows['gid']]['status'] = $rows['status'];
			$gid .= intval($rows['gid']) . ',';
		}
		$gid = rtrim($gid, ',');
		if ($gid != ''){
			$arr_cg = array();
			$sql = 'select gid,bid,bet_info,match_name,master_guest,bet_time,MB_Inball,TG_Inball,status from k_bet_cg where gid in (' . $gid . ') order by bid desc';
			$query = $mydata1_db->query($sql);
			while ($rows_cg = $query->fetch()){
				$arr_cg[$rows_cg['gid']][$rows_cg['bid']]['bet_info'] = $rows_cg['bet_info'];
				$arr_cg[$rows_cg['gid']][$rows_cg['bid']]['match_name'] = $rows_cg['match_name'];
				$arr_cg[$rows_cg['gid']][$rows_cg['bid']]['master_guest'] = $rows_cg['master_guest'];
				$arr_cg[$rows_cg['gid']][$rows_cg['bid']]['bet_time'] = $rows_cg['bet_time'];
				$arr_cg[$rows_cg['gid']][$rows_cg['bid']]['MB_Inball'] = $rows_cg['MB_Inball'];
				$arr_cg[$rows_cg['gid']][$rows_cg['bid']]['TG_Inball'] = $rows_cg['TG_Inball'];
				$arr_cg[$rows_cg['gid']][$rows_cg['bid']]['status'] = $rows_cg['status'];
			}
		}
	}
}

if ($arr_b_cg){
	$sum_tz = 0;
	$sum_pc = 0;
	$sum_fs = 0;
	foreach ($arr_b_cg as $gid => $rows){
		$i = 1;
		$sum_tz += $rows['bet_money'];
		$sum_pc += $rows['win'];
		$sum_fs += $rows['fs'];
?>				  
			  <li data-role="list-divider" role="heading" class="ui-li-divider ui-bar-inherit ui-first-child"> 
				  <label> 
					  <div style="position:relative;padding-bottom:5px;">投注时间： 
						  <div style="position:absolute;top:0px;left:80px;"> 
							 <?=date('Y-m-d H:i:s',strtotime($rows['bet_time']));?>(美东)<br> 
							 <?=date('Y-m-d H:i:s',strtotime($rows['bet_time']) + (12 * 3600));?>(北京) 
						  </div> 
						  <div></div> 
					  </div> 
				  </label> 
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
				  <label>下注单号：<?=$gid;?></label> 
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
				  <label>下注模式：<?=$rows['cg_count'];?>串1</label> 
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
				  <label>
				  <?php $tz_height = 'height:' . ($rows['cg_count'] * 75) . 'px';?>						  
						  <div style="position:relative;padding-bottom:5px;<?=$tz_height;?>">投注信息： 
						  <div style="position:absolute;top:0px;left:80px;">
	<?php 
	$x = 0;
	$nums = count($arr_cg[$gid]);
	$ok_num = 0;
	foreach ($arr_cg[$gid] as $k => $myrows){
		if (($myrows['status'] != 0) && ($myrows['status'] != 3)){
			$ok_num++;
		}
		$m = explode('-', $myrows['bet_info']);
		echo $m[0];
		if (mb_strpos($myrows['bet_info'], ' - ')){
			$m[2] = $m[2] . preg_replace('[\\[(.*)\\]]', '', $m[3]);
		}
		$m[2] = @(preg_replace('[\\[(.*)\\]]', '', $m[2] . $m[3]));
		unset($m[3]);
		
		if (mb_strpos($m[0], '胆')){
			$bodan_score = explode('@', $m[1], 2);
			$score = $bodan_score[0];
			$m[1] = '波胆@' . $bodan_score[1];
		}else{
			$score = '';
		}
		
		echo '<span style="color:#005481"><b>'.$myrows['match_name'].'</b></span><br />';
		$m_count = count($m);
		preg_match('[\\((.*)\\)]', $m[$m_count - 1], $matches);
		if (strpos($myrows['master_guest'], 'VS.')){
			$team = explode('VS.', $myrows['master_guest']);
		}else{
			$team = explode('VS', $myrows['master_guest']);
		}
		
		if (0 < count(@($matches))){
			echo @$myrows['bet_time'].@$matches[0]."<br/>";
		}
			
		if (0 < mb_strpos($m[1], '让')){
			if (mb_strpos($m[1], '主') === false){
				echo $team[1];
				echo str_replace(array("主让","客让"),array("",""),$m[1]);
				echo $team[0];
				echo "(主)";
			}else{
				echo $team[0];
				echo str_replace(array("主让","客让"),array("",""),$m[1]);
				echo $team[1];
			}
			$m[1] = '';
		}else{
			echo $team[0];
			if (isset($score)){
				echo $score;
			}else{
				echo " VS.";
			}
			echo $team[1];
		}
		echo "<br />";
		
		if ($m_count == 3){
			if (strpos($m[1], '@')){
				$ss = explode('@', $m[1]);
				echo '<font color="red">'.$ss[0].'</font> @ <font color="red">'.$ss[1].'</font>';
			}else{
				echo $m[1] ;
				$arraynew = array($team[0], ' / ', $team[1], '和局');
				$arrayold = array('主', '/', '客', '和');
				$ss = str_replace($arrayold, $arraynew, preg_replace('[\\((.*)\\)]', '', $m[$m_count - 1]));
				$ss = explode('@', $ss);
				echo '<font color="red">'.$ss[0].'</font> @ <font color="red">'.$ss[1].'</font>';
			}
		}
		
		if (($myrows['status'] == 3) || ($myrows['MB_Inball'] < 0)){
			echo "[取消]";
		}else if (0 < $myrows['status']){
			echo "[".$myrows['MB_Inball'].":".$myrows['TG_Inball']."]";
		}
		
		if ($x < ($nums - 1)){
			echo '<hr style="height:1px;width:99%;color:#555555" />';
		}
		
		$x++;
	}
	?> 								  </div> 
						  </div> 
				  </label> 
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
				  <label>下注金额：<?=sprintf('%.2f',$rows['bet_money']);?></label> 
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
				  <label>可赢：<?=sprintf('%.2f',$rows['bet_win']);?></label> 
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
				  <label>派彩：<?=sprintf('%.2f',$rows['win']);?></label> 
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
				  <label>返水：<?=sprintf('%.2f',$rows['fs']);?></label> 
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
				  <label>状态：
				  <?php 
				  if ((($rows['status'] == 1) || ($rows['status'] == 3)) && ($ok_num == $rows['cg_count'])){
				  	echo "<span style='color:#FF0000;'>已结算</span>";
				  }else if ($ok_num == $rows['cg_count']){
				  	echo "<span style='color:#00cc00;'>可结算</span>";
				  }else{
				  	echo "等待单式";
				  }
				  ?> 					  
				  </label> 
			  </li>
<?php 
		$i++;
	}
}
$total_page = intval($sum / $perpage) + ($sum % $perpage == 0 ? 0 : 1);
if ($id){
?> 				  
			  <li class="ui-li-static ui-body-inherit ui-last-child"> 
				  <div style="clear:both;text-align:left;"> 
					  本页下注总金额：<font color="#ff0000"><?=sprintf('%.2f',$sum_tz);?></font> RMB<br/> 
					  派彩总金额：<font color="#ff0000"><?=sprintf('%.2f',$sum_pc);?></font> RMB<br/> 
					  反水总金额：<font color="#ff0000"><?=sprintf('%.2f',$sum_fs);?></font> RMB<br/>
					  <?=$page->get_htmlPage("records_ty.php?cn_begin=".$cn_begin."&s_begin_h=".$s_begin_h."&s_begin_i=".$s_begin_i."&cn_end=".$cn_end."&s_end_h=".$s_end_h."&s_end_i=".$s_end_i."&atype=".$atype);?>					  
				 </div> 
			  </li>
<?php 
}else{
?> 				  
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
  <!--我的资料--><?php include_once 'myinfo.php';?></body> 
<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div> 
</html>