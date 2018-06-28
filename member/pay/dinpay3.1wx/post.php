<?php
$payType = array(1 => '支付宝', 2 => '微信');
$type = isset($_GET['type'])&&isset($payType[$_GET['type']])?$_GET['type']:2;
$type = 2;
if(
    !isset($_POST['S_Name'])||empty($_POST['S_Name'])||
    !isset($_POST['MOAmount'])||empty($_POST['MOAmount'])||
    !isset($_POST['pay_online'])||empty($_POST['pay_online'])
){
    exit('Access Denied');
}
$pay_online = $_POST['pay_online'];
include("../moneyconfig.php");
include('../../../database/mysql.config.php');
$query = $mydata1_db->prepare('SELECT `uid` FROM `k_user` WHERE `username`=:username');
$query->execute(array(':username' => $_POST['S_Name']));
if($query->rowCount()>0){
    $uid = $query->fetch();
    $uid = $uid['uid'];
}else{
    exit('Access Denied');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

      <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"> 
      <meta content="yes" name="apple-mobile-web-app-capable"> 
      <meta content="black" name="apple-mobile-web-app-status-bar-style"> 
      <meta content="telephone=no" name="format-detection"> 
      <meta name="viewport" content="width=device-width">  
        <title>扫码充值</title>
        <script type="text/javascript" src="../skin/jquery-1.7.2.min.js"></script>
        <script type="text/javascript">
            $(document.body).ready(function(){
                $.ajax({
                    url: "<?php echo $advice_url; ?>",
                    type: "get",
                    dataType: "jsonp",
                    jsonp: "callback",
                    data: {"uid": "<?php echo $uid; ?>", "amount": "<?php echo $_POST['MOAmount']; ?>", "type": "<?php echo $type; ?>", "pay_online": "<?php echo $_POST['pay_online']; ?>"},
                    success: function(data){
                        if(data['status']=="error"){
                            alert(data['message']);
                        }else{
                            $("div").eq(0).html("<img src=\"../qrcode.php?s="+encodeURIComponent(data['message'])+"\" />").siblings().show();
                        }
                    }
                });
            });
        </script>
    </head>
    <body style="padding:0;margin:0">
        <div style="text-align:center;margin:20px auto 10px"><img src="loading.gif"  /><br />二维码加载中，请稍后...</div>
        <div style="text-align:center;display:none;">请保存二维码或者截屏，使用 <?php echo $payType[$type]; ?> 识别二维码</div>
    </body>
</html>