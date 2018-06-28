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
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($uid);
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
  <body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" data-theme="a" data-url="/m/lotto/result.php" tabindex="0" style="min-height: 892px;"> 
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
		  <h1 class="ui-title" role="heading" aria-level="1">香港六合彩</h1> 
		  </div> 
	  </section> 

	  <!--功能列表--> 
	  <section class="mContent clearfix" style="padding:0px;"> 
		  <div data-role="cotent"> 
			  <ul data-role="listview" class="ui-listview">
			  <?php 
			    $sql = 'select * from mydata2_db.ka_kithe where na<>0 order by nn desc';
				$stmt = $mydata1_db->prepare($sql);
				$stmt->execute();
				$sum = $stmt->rowCount();
				$thisPage = 1;
				if (@($_GET['page'])){
					$thisPage = $_GET['page'];
				}
				
				$page = new newPage();
				$perpage = 5;
				$thisPage = $page->check_Page($thisPage, $sum, $perpage);
				$id = '';
				$i = 1;
				$start = (($thisPage - 1) * $perpage) + 1;
				$end = $thisPage * $perpage;
				while ($row = $stmt->fetch()){
					if (($start <= $i) && ($i <= $end)){
						$id .= intval($row['nn']) . ',';
					}
					
					if ($end < $i){
						break;
					}
					$i++;
				}
				
				if ($id){
					$id = rtrim($id, ',');
					$sql = 'select * from mydata2_db.ka_kithe where na<>0 and nn in (' . $id . ') order by nn desc';
					$query = $mydata1_db->query($sql);
					$i = 1;
					while ($rows = $query->fetch()){
				?> 				  
				  <li data-role="list-divider" role="heading" class="ui-li-divider ui-bar-inherit ui-first-child"> 
					  <label>期号：<b><?=$rows['nn'];?></b></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>日期：<?=date('Y-m-d H:i:s',strtotime($rows['nd']));?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>号码： 
						  <img src="../../lotto/images/num<?=$rows['n1'];?>.gif" /> 
						   <img src="../../lotto/images/num<?=$rows['n2'];?>.gif" /> 
						   <img src="../../lotto/images/num<?=$rows['n3'];?>.gif" /> 
						   <img src="../../lotto/images/num<?=$rows['n4'];?>.gif" /> 
						   <img src="../../lotto/images/num<?=$rows['n5'];?>.gif" /> 
						   <img src="../../lotto/images/num<?=$rows['n6'];?>.gif" /> 
						   <b>＋</b> 
						   <img src="../../lotto/images/num<?=$rows['na'];?>.gif" /> 
					  </label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>正码：</label> 
					  <div class="ui-grid-a"> 
						  <div class="ui-block-a"><span>生肖</span></div> 
						  <div class="ui-block-b"><span><?=$rows['x1'];?>&nbsp;<?=$rows['x2'];?>&nbsp;<?=$rows['x3'];?>&nbsp;<?=$rows['x4'];?>&nbsp;<?=$rows['x5'];?>&nbsp;<?=$rows['x6'];?></span></div> 
					  </div> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>特码：</label> 
					  <div class="ui-grid-a"> 
						  <div class="ui-block-a"><span>生肖</span></div> 
						  <div class="ui-block-b"><span><?=$rows['sx'];?></span></div> 
						  <div class="ui-block-a"><span>单双</span></div> 
						  <div class="ui-block-b"><span><?php if ($rows['na'] % 2 == 1){ echo '<span >单</span>'; }else{ echo "<span class='Font_R'>双</span>"; }?></span></div> 
						  <div class="ui-block-a"><span>大小</span></div> 
						  <div class="ui-block-b"><span><?php if (25 <= $rows['na']){ echo "<span>大</span>";}else{ echo "<span class='Font_R'>小</span>"; }?> </span></div> 
						  <div class="ui-block-a"><span>尾数</span></div> 
						  <div class="ui-block-b"><span><?php if (5 <= substr($rows['na'], -1, 1)){ echo '<span >大</span>'; }else{ echo "<span class='Font_R'>小</span>"; }?> </span></div> 
					  </div> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>特合：</label> 
					  <div class="ui-grid-a"> 
						  <div class="ui-block-a"><span>单双</span></div> 
						  <div class="ui-block-b">
						  	<span><span><?php if ((($rows['na'] % 10) + (intval($rows['na']) / 10)) % 2 == 1){ echo '<span >单</span>'; }else{ echo "<span class='Font_R'>双</span>"; }?> </span></span>
						  </div> 
					  </div> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>总数：</label> 
					  <div class="ui-grid-a"> 
						  <div class="ui-block-a"><span>总和</span></div> 
						  <div class="ui-block-b"><span><?=$rows['na'] + $rows['n1'] + $rows['n2'] + $rows['n3'] + $rows['n4'] + $rows['n5'] + $rows['n6'];?></span>
						  </div> 
						  <div class="ui-block-a"><span>单双</span></div> 
						  <div class="ui-block-b"><span><span style="color:red;"><?php if ($zh % 2 == 1){ echo '<span >单</span>'; }else{ echo "<span class='Font_R'>双</span>"; }?> </span></span></div> 
						  <div class="ui-block-a"><span>大小</span></div> 
						  <div class="ui-block-b"><span><span style="color:red;"><?php if (175 <= $zh){ echo '<span >大</span>'; }else{ echo "<span class='Font_R'>小</span>";}?> </span></span></div> 
					  </div> 
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
						  <a class="ui-link" href="result_lh.php?page=1">首页</a> 
						  <a class="ui-link" href="result_lh.php?page=<?=($thisPage - 1) < 1 ? 1 :$thisPage - 1;?>">上一页</a> 
						  <a class="ui-link" href="result_lh.php?page=<?=$total_page < ( $thisPage + 1) ? $total_page : $thisPage + 1;?>">下一页</a> 
						  <a class="ui-link" href="result_lh.php?page=<?=$total_page;?>">末页</a> 
					  </div>     
				  </li>
			<?php }?> 			  
			 </ul> 
	  </section> 
	  <!--底部开始--><?php include_once '../bottom.php';?>	  <!--底部结束--> 
	  <!--我的资料--><?php include_once '../member/myinfo.php';?></body> 
  <div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div> 
  </html>