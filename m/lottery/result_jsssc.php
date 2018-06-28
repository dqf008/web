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
		  <h1 class="ui-title" role="heading" aria-level="1">极速时时彩</h1> 
	  </div> 
  </section> 

  <!--功能列表--> 
  <section class="mContent clearfix" style="padding:0px;"> 
	  <div data-role="cotent"> 
		  <form action="result_jsssc.php" method="get" name="lt_form" data-role="none" data-ajax="false"> 
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
		  	$qtime = date('Y-m-d', time()+43200-(($t-1)*86400));
			$params = array(':type' => 'JSSSC', ':qtime' => strtotime($qtime.' 00:00:00'), ':etime' => strtotime($qtime.' 23:59:59'));
			$sql = 'SELECT COUNT(*) AS `count` FROM `c_auto_data` WHERE `type`=:type AND `qishu` BETWEEN :qtime AND :etime AND `status` BETWEEN 0 AND 1';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->fetch();
			$sum = $count['count'];
			$thisPage = 1;
			
			if (@($_GET['page'])){
				$thisPage = $_GET['page'];
			}
			$page = new newPage();
			$perpage = 20;
			$thisPage = $page->check_Page($thisPage, $sum, $perpage);
			if ($sum>0){
				$params[':limit'] = $perpage;
				$params[':index'] = ($thisPage-1)*$perpage;
				$sql = 'SELECT * FROM `c_auto_data` WHERE `type`=:type AND `qishu` BETWEEN :qtime AND :etime AND `status` BETWEEN 0 AND 1 ORDER BY `qishu` DESC LIMIT :index, :limit';
				$query = $mydata1_db->prepare($sql);
				$query->execute($params);
				$i = 1;
				while ($rows = $query->fetch())
				{
					$rows['value'] = unserialize($rows['value']);
		?>						  
					  <li data-role="list-divider" role="heading" class="ui-li-divider ui-bar-inherit ui-first-child"> 
						  <label>开奖期数：<?=$rows['value']['qishu'];?></label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>开奖时间：<?=date('Y-m-d H:i:s', $rows['opentime']);?></label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>号码： 
							  <?php foreach($rows['value']['opencode'] as $ball){ ?><img src="/Lottery/Images/Ball_2/<?=$ball;?>.png" /> <?php } ?>
						  </label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>总和：<?=$rows['value']['info'][0];?></label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>龙虎和：<?=$rows['value']['info'][3];?></label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>前三/中三/后三：<?=$rows['value']['info'][4].' / '.$rows['value']['info'][5].' / '.$rows['value']['info'][6];?></label> 
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
					  <a class="ui-link" href="result_jsssc.php?t=<?=$t;?>&page=1">首页</a> 
					  <a class="ui-link" href="result_jsssc.php?t=<?=$t;?>&page=<?=($thisPage - 1) < 1 ? 1 : $thisPage - 1;?>">上一页</a> 
					  <a class="ui-link" href="result_jsssc.php?t=<?=$t;?>&page=<?=$total_page < ( $thisPage + 1) ? $total_page : $thisPage + 1;?>">下一页</a> 
					  <a class="ui-link" href="result_jsssc.php?t=<?=$t;?>&page=<?=$total_page;?>">末页</a> 
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