<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
  <meta charset="UTF-8">
  <title>用户登录</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flat-ui/2.3.0/css/vendor/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flat-ui/2.3.0/css/flat-ui.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <style>
   html,body{padding:0;margin:0;}.main{width:400px;padding:5px;}form{padding:30px 35px;padding-bottom:0;}form i{font-size:30px !important;}.input-group-addon{padding:0px;width:45px !important;}.input-group-addon img{width:90px;height:41px;}.form-group{width:100%;margin-bottom:30px !important;}.input-group{width:100%;}.botton{font-size:15px;height:36px;line-height:36px;}.botton a{text-decoration:underline;float:left;}.botton span{margin-left:50px;}.botton input{float:right;}#yzm{cursor:pointer;}
  </style>
</head>
<body>
<div class="main">
    <div><img src="//cdn.fox008.cc/Common/User/login_header.png"></div>
    <form id="loginForm" class="form-inline">
        <div class="form-group">
            <label class="sr-only" for="username">账号</label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></div>
                <input type="text" class="form-control input-lg" id="username" name="username" placeholder="账号" required>
            </div>
        </div>
        <div class="form-group">
            <label class="sr-only" for="password">密码</label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
                <input type="password" class="form-control input-lg" id="password" name="password" placeholder="密码" required>
            </div>
        </div>
        <div class="form-group">
            <label class="sr-only" for="vlcodes">验证码</label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-shield" aria-hidden="true"></i></div>
                <input type="text" class="form-control input-lg" id="vlcodes" name="vlcodes" placeholder="验证码" maxlength="4" required >
                <div class="input-group-addon"><img id="yzm" src="/yzm.php"></div>
            </div>
        </div>
        <div class="form-group">
            <input type="hidden" name="action" value="login">
            <input class="btn btn-primary btn-block btn-lg" id="submit" type="button" value="登录">
        </div>
        <div class="form-group botton">
            <a href="javascript:void(0);" class="left pwdforget">忘记密码？</a>
            <span class="center">还没有账号？</span>
            <input class="btn btn-success btn-sm right join" type="button" value="+加入会员">
        </div>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="/public/layer/layer.js"></script>
<script>
$(function(){
    $(".join").click(function(){
        <?php
            if(is_dir(__DIR__."/ci/")){
                $reg_url = "/ci/reg";
            }else{
                $reg_url = "/myreg.php";
            }
        ?>
        $("#index", top.document).attr("src","<?=$reg_url?>");
    });
    $("#vlcodes").focus(function(){
        $("#yzm").attr("src","/yzm.php?"+Math.random());
    });
    $("#yzm").click(function(){$(this).attr("src","/yzm.php?"+Math.random())});
    $(".pwdforget").click(function(){
        window.open("/pwdforget.php","pwdforget","toolbar=yes, location=yes, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=400, height=645");
    });
    $(document).keypress(function(e) {  
        if(e.which == 13) {  
            $("#submit").click();  
        }  
   }); 
    var validator = $('#loginForm').validate({
        showErrors: function (errorMap, errorList) {  
            if (errorList.length > 0) {
                var id = errorList[0].element.id;
                $("#"+id).parent().addClass("has-error"); 
                //$("#"+id).parent().removeClass("has-success"); 
            }  
        }
    });
    $("input").blur(function(){
        validator.element($(this));
        if($(this).attr("aria-invalid") == "false"){
            $(this).parent().removeClass("has-error");
            //$(this).parent().addClass("has-success"); 
        }
    });
    $("#submit").click(function(){
        if(validator.form()){
            $.ajax({
                type: 'post',
                url: '/logincheck.php',
                data: $('#loginForm').serialize(),
                success: function(data){
                    switch(data){
                        case "4":
                            alert("登录成功");
                            top.window.location.reload();
                            break;
                        case "2":
                            alert("用户名或密码错误");
                            $("#vlcodes").val("");
                            $("#password").val("");
                            $("#password").focus();
                            $("#yzm").attr("src","yzm.php?"+Math.random());
                            break;
                        default:
                            alert("验证码错误");
                            $("#vlcodes").val("");
                            $("#vlcodes").focus();
                    }
                }
            });            
        }
    });
});
</script>
</body>
</html>