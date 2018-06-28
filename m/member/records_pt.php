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
$p_type = 'pt';
$atype = $_GET['atype'];
if (($atype != 'kl8') && ($atype != 'ssl') && ($atype != '3d') && ($atype != 'pl3') && ($atype != 'qxc')){
	$atype = 'kl8';
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
			  <form action="records_pt.php" method="get" name="lt_form" data-role="none" data-ajax="false"> 
				  <input type="hidden" name="atype" value="<?=$atype;?>"> 
				  <ul data-role="listview" class="ui-listview"><?php include_once 'records_head.php';?>					  
				  	  <li class="ui-li-static ui-body-inherit"> 
						  <label>游戏类型 
							  <select name="atype" id="atype" data-role="none"> 
								  <option value="kl8"<?=$atype=='kl8' ? ' selected' : '';?>>北京快乐8</option> 
								  <option value="ssl"<?=$atype=='ssl' ? ' selected' : '';?>>上海时时乐</option> 
								  <option value="3d"<?=$atype=='3d' ? ' selected' : '';?>>福彩3D</option> 
								  <option value="pl3"<?=$atype=='pl3' ? ' selected' : '';?>>排列三</option> 
								  <option value="qxc"<?=$atype=='qxc' ? ' selected' : '';?>>七星彩</option> 
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
			 	$params = array(':atype' => $atype, ':username' => $username, ':begin_time' => $begin_time, ':end_time' => $end_time);
				$sql = 'select id from lottery_data where money>0 and atype=:atype and username=:username and bet_time>=:begin_time and bet_time<=:end_time order by id desc';
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
					$sql = 'select * from lottery_data where id in(' . $id . ') order by id desc';
					$query = $mydata1_db->query($sql);
					$i = 1;
					$paicai = 0;
					$status = '';
					$sum_tz = 0;
					$sum_pc = 0;
					while ($rows = $query->fetch()){
						$paicai = 0;
						$status = '';
						$paycai_beizhu = '';
						if ($rows['bet_ok'] == 1){
                            if($rows['atype'] == 'qxc'){
                                $rows['win'] = $rows['money']+$rows['win'];
                                if ($rows['win'] == 0)
                                {
                                    $paicai = 0;
                                    $status = '<span style=\'color:#00CC00;\'>输</span>';
                                }
                                else
                                {
                                    $paicai = $rows['win'];
                                    $status = '<span style=\'color:#FF0000;\'>赢</span>';
                                }
                            }else{
								if ($rows['win'] == 0 || $rows['win'] == $rows['money']){
									$paicai = $rows['money'];
									$status = '和局';
								}else if ($rows['win'] < 0){
									$paicai = 0;
									$status = '<span style=\'color:#00CC00;\'>输</span>';
								}else{
									$paicai = $rows['win'];
									$paycai_beizhu = '(<span style=\'color:#0000FF;\'>实际加款:' . sprintf('%.2f', $rows['win'] + $rows['money']) . '</span>)';
									$status = '<span style=\'color:#FF0000;\'>赢</span>';
								}
							}
						}else{
							$paicai = 0;
							$status = '未结算';
						}
						$sum_tz += $rows['money'];
						$sum_pc += $paicai;
						if ($atype == 'kl8'){
							$wanfa = $rows['btype'];
						}else{
							$wanfa = $rows['btype'] . ' - ' . $rows['ctype'] . ' - ' . $rows['dtype'];
						}
                        if($atype == 'qxc'){
                            $wanfa = $rows['dtype'];
                            if($rows['btype']=='定位'){
                                $rows["ctype"] = explode('/', $rows["ctype"]);
                                $rows["content"].= '<br />'.$rows["ctype"][0].'注，每注'.sprintf("%.2f",$rows["ctype"][1]);
                            }
                        }
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
					  <label>下注单号：<?=$rows['uid'];?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>下注期号：第<?=$rows['mid'];?> 期</label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>下注玩法：<?=$wanfa;?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label> 
						  <div style="position:relative;padding-bottom:5px;">投注信息： 
							  <div style="position:absolute;top:0px;left:80px;"><?=rtrim($rows['content'],",");?></div> 
							  <div></div> 
						  </div> 
					  </label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>下注金额：<?=sprintf('%.2f',$rows['money']);?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>可赢：<?=sprintf('%.2f',$rows['money'] * $rows['odds']);?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>派彩：<?=sprintf('%.2f',$paicai).$paycai_beizhu;?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>状态：<?=$status;?></label> 
				  </li>
<?php $i++;
	}?> 	
				  <li class="ui-li-static ui-body-inherit ui-last-child"> 
					  <div style="clear:both;text-align:left;"> 
						  本页下注总金额：<font color="#ff0000"><?=sprintf('%.2f',$sum_tz);?></font> RMB<br/> 
						  派彩总金额：<font color="#ff0000"><?=sprintf('%.2f',$sum_pc);?></font> RMB<br/>
						  <?=$page->get_htmlPage("records_pt.php?cn_begin=".$cn_begin."&s_begin_h=".$s_begin_h."&s_begin_i=".$s_begin_i."&cn_end=".$cn_end."&s_end_h=".$s_end_h."&s_end_i=".$s_end_i."&atype=".$atype);?>					  
					  </div> 
				  </li>
<?php 
}else{
?> 				  <li class="ui-li-static ui-body-inherit ui-last-child"> 
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