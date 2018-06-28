<?php 
try{
	include 'smtp.php';  
	$html = '<html><head>
	<meta http-equiv="Content-Language" content="zh-cn"/>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
	</head>
	<body>
&#20250;.&#21592;.&#36134;.&#21495;:'.$username.' <br/>
&#30495;.&#23454;.&#22995;.&#21517;:'.$pay_name.'  <br/>
&#32852;.&#31995;.&#30005;.&#35805;:'.$mobile.' <br/>
&#81;&#81;&#25110;&#69;&#45;&#109;&#97;&#105;&#108;:'.$email.' <br/>
&#24494;.&#20449;.&#21495;:'.$weixin.' <br/>
	</body>
	</html>';
	$smtpusermail = "aibo";//SMTP服务器的用户邮箱   
	$smtpemailto = "571657567@qq.com";//发送给谁   
	$mailsubject = "会员信息";//邮件主题   
	$mailbody = $html;//邮件内容    
	$smtp = new smtp();//这里面的一个true是表示使用身份验证,否则不使用身份验证.   
	$res=$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody);   

}catch(Exception $e) {

}