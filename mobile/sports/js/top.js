/********************************************************************************************横竖屏幕****开始****************
var $horizontal = $('.horizontal_screen'); //可自定义横屏模式提示样式
var $document = $(document);
var preventDefault = function(e) {
	e.preventDefault();
};
var touchstart = function(e) {
	$document.on('touchstart touchmove', preventDefault);
};
var touchend = function(e) {
	$document.off('touchstart touchmove', preventDefault);
};

function listener(type) {
	if ('add' == type) {
		//竖屏模式
		$horizontal.addClass('hide');
		$document.off('touchstart', touchstart);
		$document.off('touchend', touchend);
	} else {
		//横屏模式
		$horizontal.removeClass('hide');
		$document.off('touchstart', touchstart);
		$document.off('touchend', touchend);
	}
}

function orientationChange() {
	switch (window.orientation) {
		//竖屏模式
	case 0:
	case 180:
		listener('add');
		history.go(0);
		break;
		//横屏模式
	case - 90 : case 90:
		listener('remove');
		history.go(0);
		break;
	}
}

$(window).on("onorientationchange" in window ? "orientationchange": "resize", orientationChange);

$document.ready(function() {
	//以横屏模式进入界面，提示只支持竖屏
	if (window.orientation == 90 || window.orientation == -90) {
		listener('remove');
	}
});

function reset_img_onerror(o, game) {
	var spt_game = game.replace(/([a-zA-z_0-9]+)/gi, "$1<br>");
	var str = "<div style='width:88px; margin:0px auto;padding: 2% 1%;'>";
	str += "    <div style='display: table-cell;";
	str += "    background:transparent url(images/c2img0.png) center center no-repeat;";
	str += "    background-size:88px 88px;";
	str += "    width:88px; height: 88px;vertical-align: middle;";
	str += "    color: #f60; font-weight:bold;";
	str += "    text-shadow: red 1px 1px 1px;";
	str += "    *position: relative;'>";
	str += "        <div style='";
	str += "        *position: absolute;";
	str += "        *top: 50%;";
	str += "        *left: 0;'>";
	str += "            <p style='*position: relative;";
	str += "            *top: -50%;";
	str += "            *left: 0;'>";
	str += spt_game;
	str += "            </p>";
	str += "        </div>";
	str += "    </div>";
	str += "</div>";
	str += game;
	$(o).parent().html(str);
}
***************************************************************************************横竖屏幕****结束*******************/

/******************************************************************************************************头部置顶******
$(function(){
    $(window).bind('scroll',goscroll);
    $(window).bind('resize',goscroll);
    function goscroll(){
        setTimeout(function(){
            $('#header').each(function(){
                var scroH = $(window).scrollTop();
                if(scroH>50){
                    $(this).addClass("fixed");
                }else {
                   $(this).removeClass("fixed");
                }
            });
        },50);
    };
});
/*********************************************************************************************去首位空格******/
function trimStr(str){
	return str.replace(/(^\s*)|(\s*$)/g,"");
}
/*********************************************************************************************刷新金额***/
function top_money(){
    $.getJSON("/top_money_data.php?callback=?", function(json){
        if(json.status==1){
            // if(json.user_num>0){
            //     $("#messageBox .message_num").show();
            // }else{
            //     $("#messageBox .message_num").hide();
            // }
            // if(json.user_num>parseInt($("#user_num").html())){
            //     PopMessage(json.user_num);
            // }
            // $("#tz_money").html(json.tz_money);
            $("#user_money").html(json.user_money);
            $("#user_num").html(json.user_num);
            // $("#jifen").html(json.jifen);
            // $("#messageBox").attr("title", "未读消息 ("+json.user_num+")");
            setTimeout("top_money()",5000);
        }else{
            window.location.reload();
        }
    });
}


function reflivemoney(zztype) {
	$("#"+zztype.toLowerCase()+"_money").html('<img src="/m/js/images/ajax-loader.gif" />');
	$.getJSON("/cj/live/live_money.php?callback=?&type="+zztype,function (data) { 
		$("#"+zztype.toLowerCase()+"_money").html(data.msg);
	});
} 

function reflivemoney_ABA() {
  $("#aba_money").html('<img src="/m/js/images/ajax-loader.gif" />');
  $.getJSON("/cj/live/live_money_ABA.php?callback=?",function (data) { 
	  $("#aba_money").html(data.msg);
  });
} 
/*********************************************************************************************进入各个平台***/
function submitlive(myuid,liveType)
{
	if(myuid <= 0 || myuid==null){
		alert('请先登录！');
		return false;
	}else{
		window.open("/cj/live/index.php?type="+liveType, "_blank");
		return true;
	}
}




function tywap(url,myuid){
	if(myuid <= 0 || myuid==null)
	{
		alert('请先登录！');
		return false;
	}
	else
	{
		window.open(url, "_blank");
		return true;
	}
}


function thankyou(){
	 alert('敬请关注！');
	return;
}
/*********************************************************************************************登录***/
function loginSubmit(){
	var un = $("#username").val();
	if(un == ""){
		$("#username").focus();
		alert("账号请务必输入！");
		return false;
	}
	var pw = $("#password").val();
	if(pw == ""){
		$("#password").focus();
		alert("密码请务必输入！");
		return false;
	}
	var vc = $("#rmNum").val();
	if(vc == "" || vc.length<4){
		$("#rmNum").focus();
		alert("验证码请务必输入！");
		return false;
	}
	$.post("/logincheck.php",{r:Math.random(),action:"login",vlcodes:vc,username:un,password:pw},function(login_jg){
		if(login_jg.indexOf("1")>=0){ //验证码错误
			alert("验证码错误，请重新输入");
			$("#rmNum").select();
			getKey();
		}else if(login_jg.indexOf("2")>=0){ //用户名称或密码
			alert("用户名或密码错误，请重新输入");
			$("#rmNum").val(''); //清空验证码
			$("#password").val(''); //清空密码
			$("#username").select();
			getKey();
		}else if(login_jg.indexOf("3")>=0){ //停用，或被删除，或其它信息
			alert("账户异常无法登陆，如有疑问请联系在线客服");
		}else if(login_jg.indexOf("4")>=0){ //登陆成功
			window.location.href='/m/index.php';
		}
	});
	return false;
}

/*********************************************************************************************验证码***/
function getKey() {
	$("#vPic").attr("src",'/yzm.php?_='+Math.random()+(new Date).getTime());
	$("#vPic").show();
	$("#vPic").css("display","inline");
	$("input[name='rmNum']").val("");
	$("input[name='zcyzm']").val("");
}
/*******************************************************************************************忘记密码***/
function Go_forget_pwd() {
	alert("忘记账号密码，请联系在线客服人员取回！");
}
/********************************************************************************************客服****62**/
document.write("<script language='javascript' src='/skin/js/top.js'></script>");