<?php
$data = array();
if(!empty($_GET['act'])){
    session_start();
    if($_GET['act'] == "verify"){
        $account = trim($_POST['account']);
        $pwd = trim($_POST['pwd']);
        $code = trim($_POST['code']);
        if($code != $_SESSION['randcode']){
            unset($_SESSION['randcode']);            
            die(json_encode(['code'=>'01']));
        }
        unset($_SESSION['randcode']); 
        if(strlen($pwd) != 6 || strlen($account) < 5){
            unset($_SESSION['randcode']);            
            die(json_encode(['code'=>'021']));
        }
        include __DIR__ . "/class/Db.class.php";
        $db = new DB();
        $row = $db->row("select uid,sex,birthday from k_user where username=:username",['username'=>$account]);
        if(empty($row) || $row['birthday'] != $pwd){
            unset($_SESSION['randcode']);   
            die(json_encode(['code'=>'02'])); 
        }
        die(json_encode(['code'=>'00', 'data'=>$row['sex']]));
    }else{
        die();
    }
}
    
?><!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
  <meta charset="UTF-8">
  <title>忘记密码</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flat-ui/2.3.0/css/vendor/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flat-ui/2.3.0/css/flat-ui.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
    <script type="text/javascript" src="/public/layer/layer.js"></script>
  <style>
   html,body{padding:0;margin:0;background:#293242;overflow-x:hidden;overflow-y:hidden;}.container{position:relative;width:390px;height:490px;margin:150px auto 0;padding-top:106px;background:#FFF;border-radius:10px;}.lock-pic-wrap{position:absolute;top:-140px;left:50%;margin-left:-106px;width:212px;height:235px;background:url(//cdn.fox008.cc/Common/User/safe.svg) 50% 0 no-repeat;background:url(//cdn.fox008.cc/Common/User/safe.svg) 50% 0 no-repeat\9;}.lock-pic-wrap .lock-line{position:absolute;left:39px;top:49px;width:135px;height:135px;background:url(//cdn.fox008.cc/Common/User/safe-line.svg) 50% 0 no-repeat;background:0 0\9;}.lock-pic-wrap .lock-line.motion{-webkit-animation:safe-circle 8s infinite linear;animation:safe-circle 8s infinite linear;}@-webkit-keyframes safe-circle{0%,100%{-webkit-transform:rotate(0);transform:rotate(0);}40%{-webkit-transform:rotate(180deg);transform:rotate(180deg);}60%{-webkit-transform:rotate(90deg);transform:rotate(90deg);}}@keyframes safe-circle{0%,100%{-webkit-transform:rotate(0);transform:rotate(0);}40%{-webkit-transform:rotate(180deg);transform:rotate(180deg);}60%{-webkit-transform:rotate(90deg);transform:rotate(90deg);}}.title{color:#242424;font-size:22px;text-align:center;letter-spacing:2px;}.main{width:304px;margin:0 auto;}form{padding:28px 0 10px;}form i{font-size:30px !important;}.input-group-addon{padding:0px;width:45px !important;}.input-group-addon img{width:90px;height:41px;}.form-group{width:100%;margin-bottom:15px !important;}.input-group{width:100%;}.botton{font-size:15px;height:36px;line-height:36px;}.botton a{text-decoration:underline;float:left;}.botton span{margin-left:20px;}.botton input{float:right;}.sec-pic-wrap{width:120px;height:42px;padding-left:48px;margin:0 auto;background:url(//cdn.fox008.cc/Common/User/secure.svg) no-repeat;background:url(//cdn.fox008.cc/Common/User/secure.png) no-repeat\9;}.sec-pic-wrap .sec-pic-txt{padding-left:5px;border-left:2px solid #EFEFEF;}.sec-pic-wrap .sec-pic-txt p{display:block;font-size:22px;line-height:18px;color:#7A7A7A;padding-top:5px;font-family:'Open Sans',sans-serif;margin-bottom:0px;}.sec-pic-wrap .sec-pic-txt span{color:#0B85CC;font-size:12px;display:block;}#yzm{cursor:pointer;}a.layui-layer-btn0{font-size:12px;}.Success{display:none;}.Success input{margin-top:20px;}
  </style>
</head>
<body>
<div class="container">
    <div class="lock-pic-wrap"><div class="lock-line motion"></div></div>
    <div class="main">
        <div class="title">忘记密码</div>
        <form class="form-inline" id="pwdforgetFrom">
            <div class="form-group">
                <label class="sr-only" for="account">会员账号</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></div>
                    <input type="text" class="form-control input-lg" id="account" name="account" placeholder="会员账号" required>
                </div>
            </div>
            <div class="form-group">
                <label class="sr-only" for="account">取款密码</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
                    <input type="text" class="form-control input-lg" maxlength="6" id="password" name="pwd" placeholder="取款密码" required>
                </div>
            </div>
            <div class="form-group">
                <label class="sr-only" for="account">验证码</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-shield" aria-hidden="true"></i></div>
                    <input type="text" class="form-control input-lg" id="verify" name="code" maxlength="4" placeholder="验证码" required>
                    <div class="input-group-addon"><img id="yzm" src="/yzm.php"></div>
                </div>
            </div>
            <div class="form-group">
                <input class="btn btn-danger btn-block btn-lg" id="submit" type="button" value="立即验证">
            </div>
        </form>
        <div class="Success" style="height: 240px;margin:20px 0">
        <div style="font-size:37px;"><i class="fa fa-check-circle" aria-hidden="true"></i> 帐号验证通过！</div>
            <input class="form-control" id="oldPwd">
            <input class="btn btn-danger btn-block btn-lg" data-clipboard-target="#oldPwd" id="btn_copy" type="button" value="复制密码">
        </div>
        <div class="sec-pic-wrap">
            <div class="sec-pic-txt"><p>secure</p><span>安全加密</span></div>
        </div>
    </div>
</div>

<script>
$(function(){ 
    var clip = new ClipboardJS('#btn_copy');
    clip.on('success', function(e) {
        layer.msg("复制成功")
        e.clearSelection();
    });
    $("#verify").focus(function(){
        $("#yzm").attr("src","/yzm.php?"+Math.random());
    });
    $("#yzm").click(function(){$(this).attr("src","/yzm.php?"+Math.random())});
    $("#pwdforgetFrom").keypress(function(e) {  
        if(e.which == 13) {  
            $("#submit").click();  
        }  
   }); 
    var validator = $('#pwdforgetFrom').validate({
        showErrors: function (errorMap, errorList) {  
            if (errorList.length > 0) {
                var id = errorList[0].element.id;
                $("#"+id).parent().addClass("has-error"); 
                //$("#"+id).focus();
            }  
        }
    });
    $("#pwdforgetFrom input").blur(function(){
        validator.element($(this));
        if($(this).attr("aria-invalid") == "false"){
            $(this).parent().removeClass("has-error");
        }
    });
    $("#submit").click(function(){
        if(validator.form()){
            $("#submit").addClass("disabled");
            $("#pwdforgetFrom input").blur();
            $.ajax({
                type: 'post',
                url: '?act=verify',
                dataType: 'json',
                data: $('#pwdforgetFrom').serialize(),
                success: function(data){
                    if(data.code == '01'){
                        layer.alert('验证码错误', {
                            icon:2,skin: 'layui-layer-molv',closeBtn: 0
                        },function(index){
                            $("#verify").val("").focus();
                            layer.close(index);
                        });
                    }else if(data.code == '02'){
                        layer.alert('帐号验证失败，请稍后重试', {
                            icon:2,skin: 'layui-layer-molv',closeBtn: 0
                        },function(index){
                            $("#password").val("").focus();
                            $("#verify").val("");
                            layer.close(index);
                        });
                    }else if(data.code == '00'){
                        $("#oldPwd").val(data.data);
                        $(".title").hide();
                        $("#pwdforgetFrom").hide();
                        $(".Success").show();
                    }else{
                        layer.alert('系统内部错误，请稍后重试', {
                            icon:2,skin: 'layui-layer-molv',closeBtn: 0
                        },function(index){
                            $("#verify").val("").focus();;
                            layer.close(index);
                        });
                    }
                    $("#submit").removeClass("disabled");
                }
            });            
        }
    });
    $(".btn-block").click(function(){

    });
});
</script>
</body>
</html>