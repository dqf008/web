<?php 
unset($web_site);
$web_site			=	array();
$web_site['close']	=	0;
$web_site['web_name']	=	'爱博平台';
$web_site['why']	=	'';
$web_site['reg_msg_from']	=	'爱博演示站';
$web_site['reg_msg_title']	=	'';
$web_site['reg_msg_msg']	=	'';
$web_site['ck_limit']	=	'5';
$web_site['qk_limit']	=	'1';
$web_site['qk_time_begin']	=	'00:00';
$web_site['qk_time_end']	=	'23:59';
$web_site['ssc']	=	0;
$web_site['klsf']	=	0;
$web_site['pk10']	=	0;
$web_site['xyft']	=	0;
$web_site['kl8']	=	0;
$web_site['ssl']	=	0;
$web_site['d3']	=	0;
$web_site['pl3']	=	0;
$web_site['qxc']	=	0;
$web_site['hg']	=	0;
$web_site['web_title']	=	'爱博平台欢迎您~~~~~~~！！！！！';
$web_site['zh_low']	=	'10';
$web_site['zh_high']	=	'500000';
$web_site['pk10_ktime']	=	'2018-02-21';
$web_site['pk10_knum']	=	'667278';
$web_site['kl8_ktime']	=	'2018-02-21';
$web_site['kl8_knum']	=	'873256';
$web_site['wxalipay']		=	1;
$web_site['show_tel']		=	1;
$web_site['show_qq']		=	0;
$web_site['show_weixin']		=	0;
$web_site['show_question']	=	1;
$web_site['allow_samename']	=	1;
$web_site['allow_ip']	=	1;
$web_site['zc_dl']	=	1;
$web_site['lqgq4']	=	1;
$web_site['default_hkzs']	=	3;
$web_site['service_url']	=	'';
$web_site['close_time']	=	'15.00-19.30';
$web_site['member_theme']	=	'blue';
$tmp = explode("/",$_SERVER["SCRIPT_FILENAME"]);$tmp = explode("_",isset($tmp[2])?$tmp[2]:"");if(count($tmp)==2) include_once  __DIR__ . "/website_".$tmp[1].".php";?>