<?php defined('IN_AGENT')||exit('Access denied'); ?>
<!DOCTYPE html>
<!--[if lte IE 9]> <html class="no-js lte-ie9"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js">
<!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $web_site['web_name']; ?>--推广代理</title>
	<meta name="description" content="">
	<meta name="robots" content="noarchive">
	<meta name="format-detection" content="telephone=no">
	<!-- <link rel="shortcut icon" href="/Assets/dist/themes/maya8/img/favicon.ico" type="image/x-icon"> -->
	<link rel="stylesheet" href="static/style/agency-<?php echo AGENT_SKIN; ?>.css">
</head>
<body>
	<div class="page-wrap">
		<div class="top-bar">
			<div class="wrapper">
				<a href="../"><i class="icon home"></i>返回官网</a>
<?php if($AGENT['user']['login']){ ?>				<div class="top-r fr">
					<span class="item fl"><i class="icon account"></i><?php echo $AGENT['user']['username']; ?>，您好！</span>
					<a href="?action=logout" class="item quit fl"><i class="icon quit-icon"></i>退出</a>
				</div>
<?php }else{ ?>				<div class="fr"><span class="item login fl" id="j-login"><i class="icon account"></i>登录</span></div>
<?php } ?>			</div>
		</div>
		<div class="header">
			<div class="wrapper">
				<a class="logo fl" href="?action=index"><img src="<?php echo isset($AGENT['config']['AgentLogo'])&&!empty($AGENT['config']['AgentLogo'])?$AGENT['config']['AgentLogo']:'../static/images/logo.png'; ?>" style="max-height:53px" alt="" /></a>
				<div class="word fl"><span class="text">推广代理</span></div>
				<div class="top-nav fr">
					<ul>
<?php if($AGENT['user']['login']&&$AGENT['user']['agent']){ ?>						<li class="tab"><a class="<?php echo $action=='mycommission'?'active':''; ?>" href="?action=mycommission"><i class="icon commission"></i>我的佣金</a></li>
<?php }else{ ?>						<li class="tab"><a class="<?php echo $action=='index'?'active':''; ?>" href="?action=index"><i class="icon index"></i>首页</a></li>
						<li class="tab j-about pointer"><a href="javascript:;"><i class="icon about"></i>关于<?php echo $web_site['web_name']; ?></a></li>
<?php } ?>						<li><a href="?action=commissionrule" class="no-border-r<?php echo $action=='commissionrule'?' active':''; ?>"><i class="icon clause"></i>佣金条款</a></li>
					</ul>
				</div>
			</div>
		</div>
