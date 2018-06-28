<?php header('Content-Type:text/html;charset=utf-8');
session_start();
include_once '../../include/config.php';
website_close();
website_deny();
include_once '../../database/mysql.config.php';
include_once '../../common/login_check.php';
include_once '../../common/logintu.php';
include_once '../../common/function.php';
include_once '../../class/user.php';
include_once '../../member/function.php';
$pay_online = $_GET['pay_online'];
include_once '../../member/pay/moneyconfig.php';
include_once '../../member/pay/moneyfunc.php';
$username = $_GET['username'];
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$rows = check_user_login($uid, $username);
if (!$rows)
{
	message('请登录后再进行存款操作');
	exit();
}
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
	  <link rel="stylesheet" href="../css/style.css" type="text/css" media="all"> 
	  <link rel="stylesheet" href="../js/jquery.mobile-1.4.5.min.css"> 
	  <link rel="stylesheet" href="../css/style_index.css" type="text/css" media="all"> 
	  <script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script> 
	  <script type="text/javascript" src="../js/jquery.mobile-1.4.5.min.js"></script> 
	  <!--js判断横屏竖屏自动刷新--> 
	  <script type="text/javascript" src="../js/top.js"></script> 
	
	  <style> 

	   
	  .modal { 

		   
		  position: fixed !important;
		  top: 0;
		  left: 0;
		  right: 0;
		  bottom: 0;
		  background: rgba(0,0,0,0.5);
		  /*box-shadow: 0 0 0 9999px rgba(0,0,0,0.5);
		  z-index: 10000;
		   
	      

		   
		   
		   
		    vertical-align:middle;height:100vh;width:100vw;
		  overflow:auto;
		   -webkit-user-select: none;/* Chrome all / Safari all */ 
	    -moz-user-select: none;
	    -ms-user-select: none;

		
	  } 
	    
	   
	   
	  .modal:target { 
		  opacity: 1;
		   
		   
	  } 

	   

	  .modal > div { 
		  width: 350px;
		  background: #fff;
		  position: relative;
		  margin: 1px auto  10%;

		   
	      -webkit-animation: minimise 500ms linear;
		  -moz-animation: minimise 500ms linear;
		   
		  box-shadow: 0 3px 20px rgba(0,0,0,0.9);
		  background: #fff;
		  background: -moz-linear-gradient(#fff, #ccc);
		  background: -webkit-linear-gradient(#fff, #ccc);
		  background: -o-linear-gradient(#fff, #ccc);
		  font-family: "微软雅黑";
		  font-size: 14px;
	  } 
	  @media only screen and (min-width: 300px) {.modal > div {    margin: 40px auto  10%;}} 
	   
	   
	  @media all and (min-width:480px) and (orientation:landscape) {  	
		  .modal {position: fixed;} 
		  .modal > div { margin: 1px auto  10%;} 
	  } 
	  @media all and (min-width:768px) {  	
		  .modal {position: fixed;} 
		  .modal > div { margin: 13px auto  10%;} 
	  } 
	   
	   
	  .modal:target > div { 
	      
	  } 
	  .betslip_header { 
		  background-image: url(../images/header_inplay.jpg);
		  height: 30px;
	  } 
	  .ord_close {float: right;width: 46px;height: 30px;line-height: 30px;text-align: center;border-right: 1px solid #000;background:url(../images/close.png) no-repeat 50%;} 
	  </style> 
  </head> 
  <body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" data-url="/m/member/hk_money.php" tabindex="0" style="min-height: 659px;"> 
	  <!--头部开始--> 
	  <header id="header"> 
		  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a> 
			  <span>在线充值</span> 
		  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"></a> 
	  </header> 
	  <div class="mrg_header"></div> 
	  <!--头部结束--> 
	  <div id="div_pay" style="animation-name: Alpha;display:none;" class="modal"> 
		  <div style="animation-name: Zoom;" class="betslip"> 
			  <div class="betslip_header"> 
				  <div id="order_close" name="order_close" class="ord_close" onClick="javascript:colse_payorder();"> </div> 
			  </div> 
			  <div> 
				  <ul style="padding:6px;"> 
					  <li style="padding-top:4px;"> 
						  <img src="../images/i.gif" border="0" align="absmiddle" />&nbsp;存款完成前请不要关闭此窗口。 
					  </li> 
					  <li style="padding-top:4px;"> 
						  <img src="../images/i.gif" border="0" align="absmiddle" />&nbsp;请在新开页面完成付款后再选择。 
					  </li> 
					  <li style="padding-top:4px;"> 
						  <img src="../images/i.gif" border="0" align="absmiddle" />&nbsp;完成存款后请根据你的情况点击下面的按钮： 
					  </li> 
					  <li style="float:left;width: 40%;"> 
						  <input type="button" id="btnOKpay" name="btnOKpay" value="已完成付款"> 
					  </li> 
					  <li style="float:left;width: 60%;"> 
						  <input type="button" id="btnFail" name="btnFail" value="付款未成功，重新输入" /> 
					  </li> 
					  <li style="clear:both;"> 
					  </li> 
				  </ul> 
			  </div> 
		  </div> 
	  </div> 
	
	  <!--功能列表--> 
	  <section class="mContent clearfix" style="padding:0px;"> 
		  <form name="form1" id="form1" action="<?=$post_url;?>" method="post" data-role="none" data-ajax="false" target="_blank"> 
			  <div data-role="cotent"> 
				  <ul data-role="listview" class="ui-listview"> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label> 
							  用户账号：<?=$_SESSION['username'];?><input type="hidden" Name="S_Name" value="<?=$rows['username'];?>"> 
						  </label> 
						
					  </li> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label> 
							  存款金额： 
							  <input name="MOAmount" type="text" class="input_150" id="MOAmount" onKeyUp="clearNoNum(this);" maxlength="10" size="15" data-role="none"/> 
							  最低存款：<?=$web_site['ck_limit'];?>元 
							  <input id="ck_limit" type="hidden" value="<?=$web_site['ck_limit'];?>" /> 
						  </label> 
					  </li>
					  <?php if (strpos($input_url, 'xbeipay.php') !== false){?> 					  
					  <li> 
						  <input type="radio" name="Bankco" checked value="100040" style="display: none;"/>  					
					  </li>
					  <?php }else if (strpos($input_url, 'yfbpay.php') !== false){
					  
						if ($arr_online_config[$pay_online]['online_type'] == 1)?> 					
					  <li> 
						  <span style="float:left;">微信充值</span> 
						  <span style="float:left;"> 
							  <input name="rechargeType" type="radio" value="1" checked="checked"/> 
						  </span>  							
					  </li> 
					  <li>  						
						  <span style="float:left;">网银充值</span> 
						  <span style="float:left;"> 
							  <input name="rechargeType" type="radio" value="0"/> 
						  </span> 
					  </li> 
					  <input type="hidden" id="bank_code" name="bank_code" value="WEIXIN"/>
					  <?php }else if ($arr_online_config[$pay_online]['online_type'] == 2){?> 					  
					  <li>  						
						  <span style="float:left;">网银充值</span> 
						  <span style="float:left;"> 
							  <input name="rechargeType" type="radio" value="0" checked="checked"/> 
						  </span> 
					  </li> 
					  <input type="hidden" id="bank_code" name="bank_code" value=""/>
					  <?php }else if ($arr_online_config[$pay_online]['online_type'] == 3){?> 					  
					  <li>  						
						  <span style="float:left;">微信充值</span> 
						  <span style="float:left;"> 
							  <input name="rechargeType" type="radio" value="1" checked="checked"/> 
						  </span> 
					  </li> 
					  <input type="hidden" id="bank_code" name="bank_code" value="WEIXIN"/>
					  <?php 
					  }else if (strpos($input_url, 'ybpay.php') !== false){?> 	
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>支付方式： 
							  <select name="Bankco" id="Bankco" data-role="none" style="margin-bottom:5px;"> 
								  <option value="">==请选择方式==</option> 
								  <option value="ICBC">中国工商银行</option> 
								  <option value="CMB">招商银行</option> 
								  <option value="CCB">中国建设银行</option> 
								  <option value="BOC">中国银行</option> 
								  <option value="ABC">中国农业银行</option> 
								  <option value="BOCOM">交通银行</option> 
								  <option value="SPDB">上海浦东发展银行</option> 
								  <option value="CGB">广发银行</option> 
								  <option value="CTITC">中信银行</option> 
								  <option value="CEB">中国光大银行</option> 
								  <option value="CIB">兴业银行</option> 
								  <option value="SDB">平安银行</option> 
								  <option value="CMBC">中国民生银行</option> 
								  <option value="HXB">华夏银行</option> 
								  <option value="PSBC">中国邮政储蓄</option> 
								  <option value="BCCB">北京银行</option> 
								  <option value="SHBANK">上海银行</option> 
								  <option value="BOHAI">渤海银行</option> 
								  <option value="SHNS">上海农村商业银行</option> 
								  <option value="ALIPAY">支付宝</option> 
								  <option value="TENPAY">财付通</option> 
								  <option value="WECHAT">微信支付</option> 
							  </select> 
						  </label> 
					  </li>
					  <?php }else if (strpos($input_url, 'gfpay.php') !== false){?> 	
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>支付方式： 
							  <select name="Bankco" id="Bankco" data-role="none" style="margin-bottom:5px;"> 
								  <option value="">==请选择方式==</option> 
								  <option value="ICBC">中国工商银行</option> 
								  <option value="CCB">中国建设银行</option> 
								  <option value="ABC">中国农业银行</option> 
								  <option value="CMB">招商银行</option> 
								  <option value="BOCOM">交通银行</option> 
								  <option value="CMBC">中国民生银行</option> 
								  <option value="CIB">兴业银行</option> 
								  <option value="BOC">中国银行</option> 
								  <option value="NJCB">南京银行</option> 
								  <option value="CEB">中国光大银行</option> 
								  <option value="GDB">广发银行</option> 
								  <option value="PAB">平安银行</option> 
								  <option value="PSBC">中国邮政储蓄</option> 
								  <option value="BOBJ">北京银行</option> 
								  <option value="NBCB">宁波银行</option> 
								  <option value="CITIC">中信银行</option> 
								  <option value="BOS">上海银行</option> 
								  <option value="HXBC">华夏银行</option> 
								  <option value="SPDB">上海浦东发展银行</option> 
								  <option value="TCCB">天津银行</option> 
							  </select> 
						  </label> 
					  </li>
					  <?php }else if (strpos($input_url, 'yeepay.php') !== false){?> 	
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>支付方式： 
							  <select name="Bankco" id="Bankco" data-role="none" style="margin-bottom:5px;"> 
								  <option value="">==请选择方式==</option> 
								  <option value="ICBC-NET-B2C">中国工商银行</option> 
								  <option value="CCB-NET-B2C">中国建设银行</option> 
								  <option value="ABC-NET-B2C">中国农业银行</option> 
								  <option value="CMBCHINA-NET-B2C">招商银行</option> 
								  <option value="BOCO-NET-B2C">交通银行</option> 
								  <option value="CMBC-NET-B2C">中国民生银行</option> 
								  <option value="CIB-NET-B2C">兴业银行</option> 
								  <option value="BOC-NET-B2C">中国银行</option> 
								  <option value="NJCB-NET-B2C">南京银行</option> 
								  <option value="GDB-NET-B2C">广发银行</option> 
								  <option value="PINGANBANK-NET">平安银行</option> 
								  <option value="POST-NET-B2C">中国邮政储蓄</option> 
								  <option value="BCCB-NET-B2C">北京银行</option> 
								  <option value="CBHB-NET-B2C">渤海银行</option> 
								  <option value="HKBEA-NET-B2C">BEA东亚银行</option> 
								  <option value="NBCB-NET-B2C">宁波银行</option> 
								  <option value="ECITIC-NET-B2C">中信银行</option> 
								  <option value="SHB-NET-B2C">上海银行</option> 
								  <option value="CZ-NET-B2C">浙商银行</option> 
								  <option value="BJRCB-NET-B2C">北京农村商业银行</option> 
								  <option value="HZBANK-NET-B2C">杭州银行</option> 
								  <option value="NCBBANK-NET-B2C">南洋商业银行</option> 
								  <option value="SPDB-NET-B2C">上海浦东发展银行</option> 
								  <option value="SRCB-NET-B2C">上海农村商业银行</option> 
								  <option value="SCCB-NET-B2C">河北银行</option> 
								  <option value="ZJTLCB-NET-B2C">浙江泰隆商业银行</option> 
							  </select> 
						  </label> 
					  </li>
					  <?php }else if (strpos($input_url, 'kjbpay.php') !== false){?> 	
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>支付方式： 
							  <select name="Bankco" id="Bankco" data-role="none" style="margin-bottom:5px;"> 
								  <option value="">==请选择方式==</option> 
								  <option value="ICBC-KJB-B2C">中国工商银行</option> 
								  <option value="CCB-KJB-B2C">中国建设银行</option> 
								  <option value="ABC-KJB-B2C">中国农业银行</option> 
								  <option value="CMBCHINA-KJB-B2C">招商银行</option> 
								  <option value="BOCO-KJB-B2C">交通银行</option> 
								  <option value="CMBC-KJB-B2C">中国民生银行</option> 
								  <option value="CIB-KJB-B2C">兴业银行</option> 
								  <option value="BOC-KJB-B2C">中国银行</option> 
								  <option value="NJCB-KJB-B2C">南京银行</option> 
								  <option value="CEB-KJB-B2C">中国光大银行</option> 
								  <option value="GDB-KJB-B2C">广发银行</option> 
								  <option value="PINGANBANK-KJB">平安银行</option> 
								  <option value="POST-KJB-B2C">中国邮政储蓄</option> 
								  <option value="BCCB-KJB-B2C">北京银行</option> 
								  <option value="CBHB-KJB-B2C">渤海银行</option> 
								  <option value="HKBEA-KJB-B2C">BEA东亚银行</option> 
								  <option value="NBCB-KJB-B2C">宁波银行</option> 
								  <option value="ECITIC-KJB-B2C">中信银行</option> 
								  <option value="SHB-KJB-B2C">上海银行</option>  	
								  <option value="CZ-KJB-B2C">浙商银行</option> 
								  <option value="ALIPAY-KJB-B2C">支付宝</option> 
								  <option value="BJRCB-KJB-B2C">北京农村商业银行</option> 
								  <option value="HZBANK-KJB-B2C">杭州银行</option> 
								  <option value="NCBBANK-KJB-B2C">南洋商业银行</option> 
								  <option value="SPDB-KJB-B2C">上海浦东发展银行</option> 
								  <option value="SRCB-KJB-B2C">上海农村商业银行</option> 
								  <option value="SCCB-KJB-B2C">河北银行</option> 
								  <option value="ZJTLCB-KJB-B2C">浙江泰隆商业银行</option> 
							  </select> 
						  </label> 
					  </li>
					  <?php }else if (strpos($input_url, 'befupay.php') !== false){?> 	
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>支付方式： 
							  <select name="Bankco" id="Bankco" data-role="none" style="margin-bottom:5px;"> 
								  <option value="">==请选择方式==</option> 
								  <option value="10001">招商银行</option> 
								  <option value="10002">兴业银行</option> 
								  <option value="10003">中信银行</option> 
								  <option value="10004">中国民生银行</option> 
								  <option value="10005">中国光大银行</option> 
								  <option value="10006">华夏银行</option> 
								  <option value="10007">北京农村商业银行</option> 
								  <option value="10008">深圳发展银行</option> 
								  <option value="10009">中国银行</option> 
								  <option value="10010">北京银行</option> 
								  <option value="10011">中国邮政储蓄</option> 
								  <option value="10012">上海浦东发展银行</option> 
								  <option value="10013">BEA东亚银行</option> 
								  <option value="10014">广发银行</option> 
								  <option value="10015">南京银行</option> 
								  <option value="10016">交通银行</option> 
								  <option value="10017">平安银行</option> 
								  <option value="10018">中国工商银行</option> 
								  <option value="10019">杭州银行</option> 
								  <option value="10020">中国建设银行</option> 
								  <option value="10021">宁波银行</option> 
								  <option value="10022">中国农业银行</option> 
								  <option value="10023">浙商银行</option> 
							  </select> 
						  </label> 
					  </li>
					  <?php }else if (strpos($input_url, 'hxpay.php') !== false){?> 	
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>支付方式： 
							  <select name="Bankco" id="Bankco" data-role="none" style="margin-bottom:5px;"> 
								  <option value="">==请选择方式==</option> 
								  <option value="00004">中国工商银行</option> 
								  <option value="00015">中国建设银行</option> 
								  <option value="00017">中国农业银行</option> 
								  <option value="00021">招商银行</option> 
								  <option value="00005">交通银行</option> 
								  <option value="00013">中国民生银行</option> 
								  <option value="00016">兴业银行</option> 
								  <option value="00083">中国银行</option> 
								  <option value="00055">南京银行</option> 
								  <option value="00057">中国光大银行</option> 
								  <option value="00052">广发银行</option> 
								  <option value="00087">平安银行</option> 
								  <option value="00051">中国邮政储蓄</option> 
								  <option value="00050">北京银行</option> 
								  <option value="00095">渤海银行</option> 
								  <option value="00096">BEA东亚银行</option> 
								  <option value="00085">宁波银行</option> 
								  <option value="00054">中信银行</option> 
								  <option value="00084">上海银行</option> 
								  <option value="00086">浙商银行</option> 
								  <option value="00023">深圳发展银行</option> 
								  <option value="00056">北京农村商业银行</option> 
								  <option value="00081">杭州银行</option> 
								  <option value="00041">华夏银行</option> 
								  <option value="00032">上海浦东发展银行</option> 
							  </select> 
						  </label> 
					  </li>
					  <?php }?> 	
					    <?php if(strpos($input_url, 'dinkjpay.php')){ ?>
    					  <li class="ui-li-static ui-body-inherit"> 
    						  <label>支付银行： 
    							  <select name="Bankco" id="Bankco" data-role="none" style="margin-bottom:5px;"> 
    								  <option value="">==请选择方式==</option> 
    								  <option value="ICBC">中国工商银行</option> 
    								  <option value="CCB">中国建设银行</option> 
    								  <option value="ABC">中国农业银行</option> 
    								  <option value="CMB">招商银行</option> 
    								  <option value="BCOM">交通银行</option> 
    								  <option value="CMBC">中国民生银行</option> 
    								  <option value="CIB">兴业银行</option> 
    								  <option value="BOC">中国银行</option> 
    								  <option value="CEBB">中国光大银行</option> 
    								  <option value="PSBC">中国邮政储蓄</option> 
    								  <option value="ECITIC">中信银行</option> 
    								  
    							  </select> 
    						  </label> 
    					  </li>
    					  <style>.input_150{width: 180px;}
    					  </style>
    					  <li class="ui-li-static ui-body-inherit"> 
    						  <label> 
    							 电话号码： 
    							  <input name="mobile" type="text" class="input_150" id="MOAmount" onKeyUp="clearNoNum(this);" maxlength="15" size="15" data-role="none"/> 
    						  </label> 
    					  </li>
    					  <li class="ui-li-static ui-body-inherit"> 
    						  <label> 
    							 用户姓名： 
    							  <input name="card_name" type="text" class="input_150" id="card_name"  maxlength="15" size="15" data-role="none"/> 
    						  </label> 
    					  </li>
    					  <li class="ui-li-static ui-body-inherit"> 
    						  <label> 
    							 银行卡号： 
    							  <input name="card_no" type="text" class="input_150" id="card_no" onKeyUp="clearNoNum(this);" maxlength="30" size="15" data-role="none"/> 
    						  </label> 
    					  </li>
    					  
    					  <li class="ui-li-static ui-body-inherit"> 
    						  <label> 
    							 身份号码： 
    							  <input name="id_no" type="text" class="input_150" id="id_no"  maxlength="18" size="15" data-role="none"/> 
    						  </label> 
    					  </li>
					  <?php } ?>				  
					  <li class="ui-li-static ui-body-inherit ui-last-child"> 
						  <button name="btnSubmit" class="ui-btn ui-btn-inline" data-role="none" data-ajax="false" value="马上充值" onClick="return SubInfo();">马上充值</button> 
						  <input type="hidden" name="pay_online" value="<?=$pay_online;?>"></input> 
					  </li> 
				  </ul> 
			  </div> 
		  </form> 
	  </section> 
	  <!--底部开始--><?php include_once '../bottom.php';?>	  <!--底部结束--> 
	  <!--我的资料--><?php include_once 'myinfo.php';?>	
	  <script type="text/javascript"> 

          //数字验证 过滤非法字符 
          function clearNoNum(obj){ 
	          obj.value = obj.value.replace(/[^\d.]/g,"");//先把非数字的都替换掉，除了数字和. 
	          obj.value = obj.value.replace(/^\./g,"");//必须保证第一个为数字而不是. 
	          obj.value = obj.value.replace(/\.{2,}/g,".");//保证只有出现一个.而没有多个. 
	          obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");//保证.只出现一次，而不能出现两次以上 
	          if(obj.value != ''){ 
				  var re=/^\d+\.{0,1}\d{0,2}$/;
				  if(!re.test(obj.value)) 
				  { 
					  obj.value = obj.value.substring(0,obj.value.length-1);
					  return false;
				  } 
	          } 
          } 

          function SubInfo(){ 
			  var hk = $('#MOAmount').val();
              if(hk==''){ 
                  alert('请输入转账金额');
                  $('#MOAmount').focus();
                  return false;
              }else{ 
				  hk = hk*1;
				  if(hk<<?=$web_site['ck_limit'];?>){ 
					  alert('转账金额最低为：<?=$web_site['ck_limit'];?>元');
					  $('#MOAmount').select();
					  return false;
				  } 
			  } 
			  if($('#Bankco').val()==''){ 
                  alert('请选择支付方式');
                  $('#Bankco').focus();
                  return false;
              } 
              if(navigator.userAgent.indexOf('iPhone')>=0){
              	$('#form1').removeAttr('target');
              } 
              $('#form1').submit();
			  $("#div_pay").css("display","block");
          } 
		
		  function VerifyData() { 
			  var paymoney = document.form1.MOAmount.value;
			  var limitmoney = document.form1.ck_limit.value;
			  if (document.form1.MOAmount.value == "") { 
				  alert("请输入存款金额！") 
				  document.form1.MOAmount.focus();
				  return false;
			  } 

			  if (eval(paymoney) < eval(limitmoney)) { 
				  alert("最低冲值"+limitmoney+"元！");
				  document.form1.MOAmount.focus();
				  return false;
			  } 
			
			  tb_show("在线存款","#TB_inline?width=480&height=200&inlineId=info",false);
			  return true;
		  } 
		  //关闭付款弹窗页面 
		  function colse_payorder(){ 
			  $("#div_pay").css("display","none");
		  } 
          //是否是中文 
		  function isChinese(str){ 
			  return /[\u4E00-\u9FA0]/.test(str);
		  } 
          </script> 
		  <script type="text/javascript">  
			  $(function(){ 
				  //付款完成，返回付款历史页面 
				  $('#btnOKpay').click(function(){ 
					  self.location.href="<?=$main_url;?>orders.php";
				  });
				  $('#btnFail').click(function(){ 
					  self.location.href='<?=$main_url;?>mobilePay.php?username=<?=$username;?>&uid=<?=$uid;?>&pay_online=<?=$pay_online;?>';
				  });
				  $('#back').click(function(){ 
					  self.location.href='<?=$input_url;?>?username=<?=$username;?>&uid=<?=$uid;?>&hosturl=<?=$main_url;?>';
				  });
			  }) 
			  //易付宝选择充值方式 
			  $("input:radio[name='rechargeType']").change(function (){  
					
				  if($(this).val()*1){ 
					  $("#bank_code").val("WEIXIN");
				  }else{ 
					  $("#bank_code").val("");
				  } 
			  });
		  </script> 
  </body> 
  <div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div> 
  </html>