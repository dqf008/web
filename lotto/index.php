<?php
 session_start();
require_once 'conjunction.php';
require_once 'config.php';
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
	  <title></title>
	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	  <style type="text/css">
		  body {
			  margin-left: 0px;
			  margin-top: 0px;
			  margin-right: 0px;
			  margin-bottom: 0px;
			  background-color: #FFFFFF;
		  }
		  .dndn {
			  BORDER-RIGHT: #d6d3ce 0px outset;BORDER-TOP: #d6d3ce 0px outset;FONT-SIZE: 9pt;BACKGROUND: #d6d3ce;BORDER-LEFT: #d6d3ce 0px outset;BORDER-BOTTOM: #d6d3ce 0px outset
		  }
		  body,td,th {
			  font-size: 12px;
			  color: #333333;
		  }
		  .b-03 {FONT-WEIGHT: bold;FONT-SIZE: 12px;COLOR: #040177;FONT-STYLE: normal;FONT-FAMILY: "细明体", "新细明体"
		  }
		  .b-04 {FONT-WEIGHT: bold;FONT-SIZE: 12px;COLOR: #ffffff;FONT-STYLE: normal;FONT-FAMILY: "细明体", "新细明体"
		  }
		  .style2 {FONT-SIZE: 12px;FONT-STYLE: normal;FONT-FAMILY: "细明体", "新细明体"
		  }
		  .style3 {COLOR: #000000
		  }
	  </style>
  </head>
  <body>
 <?php 
 $six_action = array('ds', 'h', 'k_bb', 'k_gg', 'k_ggsave', 'k_lm', 'k_lmsave', 'k_sx', 'k_sx6', 'k_sxp', 'k_sxt2', 'k_sxt2save', 'k_tangg', 'k_tanlm', 'k_tansave', 'k_tansx', 'k_tansxt2', 'k_tanwbz', 'k_tanwsl', 'k_tm', 'k_wbz', 'k_wbzsave', 'k_wsl', 'k_wslsave', 'k_zm', 'k_zm6', 'k_zt', 'kakithe', 'kq', 'l', 'left', 'list', 'logout', 'n1', 'n2', 'n4', 'n5', 'n55', 'server', 'serverf');
if (in_array($action, $six_action))
{
	if ($action != 'logout')
	{
		require_once 'login.php';
	}
	if (in_array($action, array('k_tangg', 'k_tanlm', 'k_tansave', 'k_tansx', 'k_tansxt2', 'k_tanwbz', 'k_tanwsl')))
	{
		if ($admin_info2 != 1)
		{?> <script>alert('请登陆后再进行投单！');history.go(-1);</script><?php exit();
		}
	}
	require_once $action . '.php';
}?> </body>
  </html>