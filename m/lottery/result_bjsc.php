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
include_once '../../include/lottery.inc.php';
include_once '../../Lottery/include/auto_class4.php';
include '../../Lottery/include/order_info.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($uid);
$t = $_GET['t'];
$t = intval($t);
if (($t <= 0) || (7 < $t)){
	$t = 1;
}
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
  <link rel="stylesheet" href="../css/style.css"> 
  <link rel="stylesheet" href="../js/jquery.mobile-1.4.5.min.css"> 
  <script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script> 
  <script type="text/javascript" src="../js/jquery.mobile-1.4.5.min.js"></script> 
  <!--js判断横屏竖屏自动刷新--> 
  <script type="text/javascript" src="../js/top.js"></script> 
</head> 
<body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" data-theme="a"  tabindex="0" style="min-height: 892px;"> 
  <!--头部开始--> 
  <header id="header"> 
	  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a> 
	  <span>开奖结果</span> 
	  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"></a> 
  </header> 
  <div class="mrg_header"></div> 
  <!--头部结束--> 



  <section class="sliderWrap clearfix"> 
	  <div data-role="header" style="overflow:hidden;" role="banner" class="ui-header ui-bar-inherit"> 
		  <h1 class="ui-title" role="heading" aria-level="1">北京赛车PK拾</h1> 
	  </div> 
  </section> 

  <!--功能列表--> 
  <section class="mContent clearfix" style="padding:0px;"> 
	  <div data-role="cotent"> 
		  <form action="result_bjsc.php" method="get" name="lt_form" data-role="none" data-ajax="false"> 
			  <ul data-role="listview" class="ui-listview"> 
				  <li class="ui-li-static ui-body-inherit ui-first-child"> 
					  <label>选择日期查看： 
						  <select name="t" id="t" data-role="none"> 
							  <option value="1"<?=$t=='1' ? ' selected' : '';?>> <?=date('Y-m-d',$lottery_time);?></option> 
							  <option value="2"<?=$t=='2' ? ' selected' : '';?>> <?=date('Y-m-d',$lottery_time - (1 * 24 * 3600));?></option> 
							  <option value="3"<?=$t=='3' ? ' selected' : '';?>> <?=date('Y-m-d',$lottery_time - (2 * 24 * 3600));?></option> 
							  <option value="4"<?=$t=='4' ? ' selected' : '';?>> <?=date('Y-m-d',$lottery_time - (3 * 24 * 3600));?></option> 
							  <option value="5"<?=$t=='5' ? ' selected' : '';?>> <?=date('Y-m-d',$lottery_time - (4 * 24 * 3600));?></option> 
							  <option value="6"<?=$t=='6' ? ' selected' : '';?>> <?=date('Y-m-d',$lottery_time - (5 * 24 * 3600));?></option> 
							  <option value="7"<?=$t=='7' ? ' selected' : '';?>> <?=date('Y-m-d',$lottery_time - (6 * 24 * 3600));?></option> 
						  </select> 
					  </label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit ui-last-child"> 
					  <div style="clear:both;text-align:center;"> 
						  <input type="submit" name="query" class="ui-btn ui-btn-inline" value="查询" data-role="none"> 
					  </div> 
				  </li> 
			  </ul> 
		  </form> 
		  <ul data-role="listview" class="ui-listview">
		  <?php 
		    $tday = date('Y-m-d', $lottery_time - (($t - 1) * 24 * 3600));
			$params = array(':datetime' => $tday);
			$sql = 'select * from c_auto_4 where DATEDIFF(datetime,:datetime)=0 order by qishu desc';
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
				$sql = 'select * from c_auto_4 where  id in (' . $id . ') order by qishu desc';
				$query = $mydata1_db->query($sql);
				$i = 1;
				while ($rows = $query->fetch())
				{
					$hm = array();
					$hm[] = $rows['ball_1'];
					$hm[] = $rows['ball_2'];
					$hm[] = $rows['ball_3'];
					$hm[] = $rows['ball_4'];
					$hm[] = $rows['ball_5'];
					$hm[] = $rows['ball_6'];
					$hm[] = $rows['ball_7'];
					$hm[] = $rows['ball_8'];
					$hm[] = $rows['ball_9'];
					$hm[] = $rows['ball_10'];
		?>						  
					  <li data-role="list-divider" role="heading" class="ui-li-divider ui-bar-inherit ui-first-child"> 
						  <label>开奖期数：<?=$rows['qishu'];?></label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>开奖时间：<?=$rows['datetime'];?></label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>号码： 
							  <img src="/Lottery/Images/Ball_2/<?=$rows['ball_1'];?>.png" /> 
							  <img src="/Lottery/Images/Ball_2/<?=$rows['ball_2'];?>.png" /> 
							  <img src="/Lottery/Images/Ball_2/<?=$rows['ball_3'];?>.png" /> 
							  <img src="/Lottery/Images/Ball_2/<?=$rows['ball_4'];?>.png" /> 
							  <img src="/Lottery/Images/Ball_2/<?=$rows['ball_5'];?>.png" /> 
							  <img src="/Lottery/Images/Ball_2/<?=$rows['ball_6'];?>.png" /> 
							  <img src="/Lottery/Images/Ball_2/<?=$rows['ball_7'];?>.png" /> 
							  <img src="/Lottery/Images/Ball_2/<?=$rows['ball_8'];?>.png" /> 
							  <img src="/Lottery/Images/Ball_2/<?=$rows['ball_9'];?>.png" /> 
							  <img src="/Lottery/Images/Ball_2/<?=$rows['ball_10'];?>.png" /> 
						  </label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>冠军总和：<?=Ssc_Auto($hm, 1);?> /<?=Ssc_Auto($hm, 2);?> /<?=Ssc_Auto($hm, 3);?></label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>1V10：<?=Ssc_Auto($hm, 4);?></label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>2V9：<?=Ssc_Auto($hm, 5);?></label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>3V8：<?=Ssc_Auto($hm, 6);?></label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>4V7：<?=Ssc_Auto($hm, 7);?></label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>5V6：<?=Ssc_Auto($hm, 8);?></label> 
					  </li>
				<?php $i++;
				  }
				  $total_page = intval($sum / $perpage) + ($sum % $perpage == 0 ? 0 : 1);
				?>				  
				<li class="ui-li-static ui-body-inherit ui-last-child"> 
				  <div style="clear:both;text-align:left;margin:10px auto;line-height:28px;"> 
					  共<?=$sum;?>期，每页<?=$perpage;?>期，共<?=$total_page;?>页 
					  <br/> 
					  当前：<span style="color:red;"><?=$thisPage;?>页</span> 
					  <a class="ui-link" href="result_bjsc.php?t=<?=$t;?>&page=1">首页</a> 
					  <a class="ui-link" href="result_bjsc.php?t=<?=$t;?>&page=<?=($thisPage - 1) < 1 ? 1 : $thisPage - 1;?>">上一页</a> 
					  <a class="ui-link" href="result_bjsc.php?t=<?=$t;?>&page=<?=$total_page < ( $thisPage + 1) ? $total_page : $thisPage + 1;?>">下一页</a> 
					  <a class="ui-link" href="result_bjsc.php?t=<?=$t;?>&page=<?=$total_page;?>">末页</a> 
				  </div>     
			  </li>
			  <?php }?> 			  
			</ul> 
	  </div> 
  </section> 
  <!--底部开始--><?php include_once '../bottom.php';?>	  <!--底部结束--> 
  <!--我的资料--><?php include_once '../member/myinfo.php';?></body> 
<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div> 
</html>