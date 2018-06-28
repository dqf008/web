<?php 
exit;
session_start();
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/function.php';
include_once '../class/user.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
$userinfo = user::getinfo($uid);
$gamename = trim($_GET['gamename']);
?>
<!DOCTYPE html> 
<html class="ui-mobile ui-mobile-viewport ui-overlay-a"> 
<head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
  <title><?=$web_site['web_title'];?></title> 
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"> 
  <meta content="yes" name="apple-mobile-web-app-capable"> 
  <meta content="black" name="apple-mobile-web-app-status-bar-style"> 
  <meta content="telephone=no" name="format-detection"> 
  <meta name="viewport" content="width=device-width"> 
  <link rel="shortcut icon" href="images/favicon.ico"> 
  <link rel="stylesheet" href="css/style.css"> 
  <link rel="stylesheet" href="css/style_index.css" type="text/css" media="all"> 
  <link rel="stylesheet" href="js/jquery.mobile-1.4.5.min.css"> 
  <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script> 
  <script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script> 
  <!--js判断横屏竖屏自动刷新--> 
  <script type="text/javascript" src="js/top.js"></script> 
  <style type="text/css"> 
	  #collapsibles div{ 
		  padding: 0 15px 5px 10px;
	  } 
	  #collapsibles ul{ 
		  padding: 0 0 0 10px;
	  } 
  </style> 
  <script> 
	  function mg_submitlive_dz(flashid) 
	  { 
		  var myuid =<?=intval($uid);?>;
		  if(myuid <= 0){ 
			  alert('请先登录！');
			  return false;
		  }else{ 
			  var url="/cj/live/index.php?type=MG&gameType="+flashid;
			  window.open(url, "_blank");
			  return true;
		  } 
	  } 
  </script> 
</head> 
<body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" tabindex="0" style="min-height: 659px;"> 
<!--头部开始--> 
<header id="header">
<?php if ($uid != 0){?>
	  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a>
<?php }?>
	  <span>MG电子游戏</span> 
	  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"></a> 

	
	

</header> 
<!--头部结束--> 
<form action="mggame.php" method="get"> 
  <ul  style="background:#FFF;padding-top:36px;position: fixed;width:100%;"> 
	  <li class="cl first"> 
		  <div class="fl f" style="padding-left:20px;"> 
			  <input name="gamename" id="gamename" type="text"  value="<?php if (trim($gamename) == ''){echo "搜索游戏...";}else{echo trim($gamename);}?> " onBlur="if(this.value=='')this.value='搜索游戏...'" onFocus="if(this.value=='搜索游戏...')this.value=''" maxlength="60" style="padding-top:12px;line-height: 25px;"/> 
		  </div> 
		  <div class="fr f" style="padding-left:20px;"> 
			  <input type="submit" value="搜索"/> 
		  </div> 
	  </li> 
  </ul> 
</form> 
<!--赛事列表--> 
<section class="mContent clearfix" style="padding:0px;margin-top:100px;"> 
  <div class="content_n">
<?php 
$params = array();
$sql = '';
if ((trim($gamename) != '') && (trim($gamename) != '搜索游戏...'))
{
$params['gamename'] = '%' . trim($gamename) . '%';
$sql .= 'and chinese like :gamename ';
}
$sql = 'select id,gamename,imagefilename,chinese,english from mggamelist l where is_able=1 and category=\'mobile\' ' . $sql . 'order by id';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$C_Path = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']) . '/mggame/img/';
while ($row = $stmt->fetch())
{
$row_id = $row['id'];
$row_gamename = $row['gamename'];
$row_imagefilename = $row['imagefilename'];
$row_chinese = $row['chinese'];
$row_english = $row['english'];
if (($row_imagefilename == NULL) || ($row_imagefilename == '') || !file_exists($C_Path . $row_imagefilename))
{
$row_imagefilename = 'default.png';
}
?>
		  <div class="game_list"> 
		  <a href="javascript:void(0);;" class="ui-link"><!--'5ReelDrive'--> 
			  <table width="100%"> 
				  <tbody> 
					  <tr> 
						  <td class="gimage" style="width:150px;background:transparent url('../mggame/img/<?=$row_imagefilename;?>') no-repeat 0px 0px;margin:0px auto;"></td> 
						  <td align="left" style="padding:0 10px;"> 
							  <div class="gtitle">
							  <?php 
							  if ($row_chinese != ''){
								echo $row_chinese;
							  }else if ($row_english != ''){
								echo $row_english;
							  }else{
								echo $row_gamename;
							  }
							  ?> 									  
							  </div> 
							  <div class="gbtn" style="background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#ff0), to(#8A0202));" onClick="mg_submitlive_dz('<?=$row_gamename;?>');"> 
								  <div class="PlayNowLink" style="border:none;color:#000;text-shadow:none;">立刻开始</div> 
							  </div> 
						  </td> 
					  </tr> 
				  </tbody> 
			  </table> 
		  </a> 
	  </div>
	  <?php }?>
	  </div> 
</section> 

<!--底部开始--><?php include_once 'bottom.php';?>	  <!--底部结束--> 
<!--我的资料--><?php include_once 'member/myinfo.php';?>
</html>