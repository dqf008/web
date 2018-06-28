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
if (($t <= 0) || (7 < $t))
{
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
  <style> 
  #haoma span{ 
	  text-align: center;width:20px;height: 22px;line-height: 23px;font-size: 14px;padding: 2px;display: inline-block;font-weight: bold;font-family: "微软雅黑";
  } 
  .ball_a{ 
	  background:url(../images/blue1.png) no-repeat;
  } 
  .ball_b{ 
	  background:url(../images/blue2.png) no-repeat;
  } 
  </style> 
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
		  <h1 class="ui-title" role="heading" aria-level="1">北京快乐8</h1> 
	  </div> 
  </section> 

  <!--功能列表--> 
  <section class="mContent clearfix" style="padding:0px;"> 
	  <div data-role="cotent"> 
		  <form action="result_kl8.php" method="get" name="lt_form" data-role="none" data-ajax="false"> 
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
		    $qday = date('Y-m-d', $lottery_time - (($t - 1) * 24 * 3600));
			$params = array(':kaipan' => $qday);
			$sql = 'select * from lottery_k_kl8 where ok=1 and DATEDIFF(kaipan,:kaipan)=0 order by qihao desc';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$sum = $stmt->rowCount();
			$thisPage = 1;
			if ($_GET['page']){
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
				$sql = 'select * from lottery_k_kl8 where  id in (' . $id . ') order by qihao desc';
				$query = $mydata1_db->query($sql);
				$i = 1;
				while ($row = $query->fetch()){
					$sumhm = $row['hm1'] + $row['hm2'] + $row['hm3'] + $row['hm4'] + $row['hm5'] + $row['hm6'] + $row['hm7'] + $row['hm8'] + $row['hm9'] + $row['hm10'] + $row['hm11'] + $row['hm12'] + $row['hm13'] + $row['hm14'] + $row['hm15'] + $row['hm16'] + $row['hm17'] + $row['hm18'] + $row['hm19'] + $row['hm20'];
					if ($sumhm % 2 == 0){
						$hzds = '<font color=\'#32fc6b\'>双</font>';
					}else{
						$hzds = '单';
					}
					
					if (810 < $sumhm){
						$hzdx = '<font color=\'#32fc6b\'>大</font>';
					}else if ($sumhm < 810){
						$hzdx = '小';
					}else{
						$hzdx = '<font color=\'#c6fe6f\'>和</font>';
					}
					$spsum = 0;
					$jpsum = 0;
					
					for ($i = 1;$i <= 20;$i++){
						if ($row['hm' . $i] <= 40){
							$spsum++;
						}
						
						if ($row['hm' . $i] % 2 != 0){
							$jpsum++;
						}
					}
					
					if (10 < $spsum){
						$sxp = '上';
					}else if ($spsum < 10){
						$sxp = '<font color=\'#32fc6b\'>下</font>';
					}else{
						$sxp = '<font color=\'#c6fe6f\'>中</font>';
					}
					
					if (10 < $jpsum){
						$jop = '奇';
					}else if ($jpsum < 10){
						$jop = '<font color=\'#32fc6b\'>偶</font>';
					}else{
						$jop = '<font color=\'#c6fe6f\'>和</font>';
					}
					
					?> 						  
					  <li data-role="list-divider" role="heading" class="ui-li-divider ui-bar-inherit ui-first-child"> 
						  <label>开奖期数：<?=$row['qihao'];?></label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>开奖时间：<?=$row['addtime'];?></label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label> 
							  <div style="position:relative;padding-bottom:5px;height:33px;">号码： 
								  <div style="position:absolute;top:0px;left:43px;" id="haoma"> 
									  <span class="<?=$row['hm1']==40 ? 'ball_a' : 'ball_b';?>"><?=buling($row['hm1']);?></span> 
									  <span class="<?=$row['hm2']==40 ? 'ball_a' : 'ball_b';?>"><?=buling($row['hm2']);?></span> 
									  <span class="<?=$row['hm3']==40 ? 'ball_a' : 'ball_b';?>"><?=buling($row['hm3']);?></span> 
									  <span class="<?=$row['hm4']==40 ? 'ball_a' : 'ball_b';?>"><?=buling($row['hm4']);?></span> 
									  <span class="<?=$row['hm5']==40 ? 'ball_a' : 'ball_b';?>"><?=buling($row['hm5']);?></span> 
									  <span class="<?=$row['hm6']==40 ? 'ball_a' : 'ball_b';?>"><?=buling($row['hm6']);?></span> 
									  <span class="<?=$row['hm7']==40 ? 'ball_a' : 'ball_b';?>"><?=buling($row['hm7']);?></span> 
									  <span class="<?=$row['hm8']==40 ? 'ball_a' : 'ball_b';?>"><?=buling($row['hm8']);?></span> 
									  <span class="<?=$row['hm9']==40 ? 'ball_a' : 'ball_b';?>"><?=buling($row['hm9']);?></span> 
									  <span class="<?=$row['hm10']==40 ? 'ball_a' : 'ball_b';?>"><?=buling($row['hm10']);?></span><br/> 
									  <span class="<?=$row['hm11']==40 ? 'ball_a' : 'ball_b';?>"><?=buling($row['hm11']);?></span> 
									  <span class="<?=$row['hm12']==40 ? 'ball_a' : 'ball_b';?>"><?=buling($row['hm12']);?></span> 
									  <span class="<?=$row['hm13']==40 ? 'ball_a' : 'ball_b';?>"><?=buling($row['hm13']);?></span> 
									  <span class="<?=$row['hm14']==40 ? 'ball_a' : 'ball_b';?>"><?=buling($row['hm14']);?></span> 
									  <span class="<?=$row['hm15']==40 ? 'ball_a' : 'ball_b';?>"><?=buling($row['hm15']);?></span> 
									  <span class="<?=$row['hm16']==40 ? 'ball_a' : 'ball_b';?>"><?=buling($row['hm16']);?></span> 
									  <span class="<?=$row['hm17']==40 ? 'ball_a' : 'ball_b';?>"><?=buling($row['hm17']);?></span> 
									  <span class="<?=$row['hm18']==40 ? 'ball_a' : 'ball_b';?>"><?=buling($row['hm18']);?></span> 
									  <span class="<?=$row['hm19']==40 ? 'ball_a' : 'ball_b';?>"><?=buling($row['hm19']);?></span> 
									  <span class="<?=$row['hm20']==40 ? 'ball_a' : 'ball_b';?>"><?=buling($row['hm20']);?></span> 
								  </div> 
							  </div> 
						  </label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>总和：<?=$sumhm;?> /<?=$hzdx;?> /<?=$hzds;?></label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>上下盘：<?=$sxp;?></label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>奇偶盘：<?=$jop;?></label> 
					  </li>
					 <?php 
					  $i++;
					}
					$total_page = intval($sum / $perpage) + ($sum % $perpage == 0 ? 0 : 1);
					?>				  
				  <li class="ui-li-static ui-body-inherit ui-last-child"> 
				  <div style="clear:both;text-align:left;margin:10px auto;line-height:28px;"> 
					  共<?=$sum;?>期，每页<?=$perpage;?>期，共<?=$total_page;?>页 
					  <br/> 
					  当前：<span style="color:red;"><?=$thisPage;?>页</span> 
					  <a class="ui-link" href="result_kl8.php?t=<?=$t;?>&page=1">首页</a> 
					  <a class="ui-link" href="result_kl8.php?t=<?=$t;?>&page=<?=($thisPage - 1) < 1 ? 1 : $thisPage - 1;?>">上一页</a> 
					  <a class="ui-link" href="result_kl8.php?t=<?=$t;?>&page=<?=$total_page < ($thisPage + 1) ? $total_page : $thisPage + 1;?>">下一页</a> 
					  <a class="ui-link" href="result_kl8.php?t=<?=$t;?>&page=<?=$total_page;?>">末页</a> 
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
<?php 
function BuLing($num){
	if ($num < 10){
		$num = '0' . $num;
	}
	return $num;
}
?>