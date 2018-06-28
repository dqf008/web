var serviceUrl;
(function(){$.get("/service.php",function(data){typeof(data.url)!="undefined"&&data.url!==false&&(serviceUrl=data.url)},"json")})();

$(function () {
    $('[notice]').click(function () {
        layer.alert(
            $(this).html(),
            {skin:'Popcontent',title:'最新公告',area: '516px'}
        );
    });
});



function memberUrl(url) {
    layer.open({
        type: 2,
        title: "会员中心",
        content: url,
        area: ['960px', '545px']
    });
}


function menu_url(i){
    var index = top.document.getElementById("index");
    
    switch (i) {
        case 1:
            index.src = "myhome.php";
            break;
        case 2:
            index.src = "sports.php";
            break;
        case 3:
            index.src = "six.php";
            break;
        case 4:
            index.src = "ssc.php"; //重庆时时彩
            break;
        case 18:
            index.src = "ssc.php?t=2"; //广东快乐十分
            break;
        case 19:
            index.src = "ssc.php?t=3"; //北京赛车PK拾
            break;
        case 6:
            index.src = "ssc.php?t=4"; //北京快乐8
            break;
        case 8:
            index.src = "ssc.php?t=5"; //上海时时乐
            break;
        case 5:
            index.src = "ssc.php?t=6"; //福彩3D
            break;
        case 7:
            index.src = "ssc.php?t=7"; //排列三
            break;
        case 17:
            index.src = "logout.php";
            break;
        case 9:
			memberUrl("member/sys_msg.php");
            break;
        case 10:
			memberUrl("member/userinfo.php");
            break;
        case 11:
			memberUrl("member/set_money.php");
            break;
        case 12:
			memberUrl("member/get_money.php");
            break;
        case 13:
			memberUrl("member/record_ty.php");
            break;
        case 14:
			memberUrl("member/report.php");
            break;
        case 15:
			memberUrl("member/agent.php");
            break;
        case 16:
			memberUrl("member/agent_reg.php");
            break;
        case 20:
			memberUrl("member/zr_money.php");
            break;
        case 21:
			memberUrl("member/zr_data_money.php");
            break;
        case 61: //关于我们
            index.src = "myabout.php?code=gywm";
            break;
        case 62: //联系我们
            //index.src = "myabout.php?code=lxwm";
            if(typeof(serviceUrl)!="undefined"){
                window.open(serviceUrl, "_blank");
            }
            break;
        case 63: //合作伙伴
            index.src = "myabout.php?code=hzhb";
            break;
        case 64: //存款帮助
            index.src = "myabout.php?code=ckbz";
            break;
        case 65: //取款帮助
            index.src = "myabout.php?code=qkbz";
            break;
        case 66: //常见问题
            index.src = "myabout.php?code=cjwt";
            break;
        case 67: //优惠活动
            index.src = "myhot.php";
            break;
        case 68: //彩票游戏
            index.src = "mylottery.php";
            break;
        case 69: //玩法介绍
            index.src = "myabout.php?code=wfjs";
            break;
        case 70: //会员注册
            index.src = "myreg.php";
            break;
        case 71: //手机投注
            index.src = "mywap.php";
            break;
        case 72: //负责任博彩
            index.src = "myabout.php?code=fzrbc";
            break;
        case 73: //真人娱乐
            index.src = "mylive.php";
			//window.open("http://www.33msc.com/game.aspx", "_blank");
            break;
        case 74: //底部联系我们
            index.src = "myabout.php?code=lxwm";
            break;
        case 75: //备用网址
            index.src = "myline.php";
            break;
        case 76: //QQ联系
            // window.open("http://wpa.qq.com/msgrd?v=3&uin=7548908&site=qq&menu=yes", "_blank");
            break;
		case 77: //AG手机端
            // window.open("http://agin.cc/promotion/index.html", "_blank");
            break;
        case 78: //HG手机端
            alert('敬请关注！');
            break;
        case 79: //BBIN手机端
            alert('敬请关注！');
            break;
        case 80: //BBIN电子游艺
            window.open("/cj/live/index.php?type=BBIN&&gameType=5", "_blank");
            break;
        case 81: //BBIN体育赛事
            window.open("/cj/live/index.php?type=BBIN&&gameType=4", "_blank");
            break;
        case 82: //BBIN彩票游戏
            window.open("/cj/live/index.php?type=BBIN&gameType=3", "_blank");
            break;
        case 83: //BBIN视讯直播
            window.open("/cj/live/index.php?type=BBIN&gameType=1", "_blank");
             break;
        case 84: //MG手机端   // 2015-07-30 MG
            alert('敬请关注！');
            break;
        case 85: //MG电子游戏页面   // 2015-07-30 MG
            index.src = "mygame.php";
            break;
        case 86: //DS手机端   // 2015-08-02 DS
            alert('敬请关注！');
            break;
        case 87: //AG电子游戏页面   // 2015-12-15
            index.src = "myaggame.php";
            break;
        case 98:
            window.open("/cj/live/index.php?type=SHABA", "_blank");
            break;
        case 99: //即时比分
            window.open("http://99814.com/free.html", "_blank");
            break;
        case 41: //游戏规则
            index.src = "clause.php";
            break;
        default:
            index.src = "myhome.php";
    }
}


function tourl(i){
    var index = top.document.getElementById("index");
    switch (i) {
        case 100://首页
            index.src = "myhome.php";
            break;
        case 101://体育
            index.src = "sports.php";
            break;
        case 102://六合彩
            index.src = "six.php";
            break;
        case 103://时时彩
            index.src = "ssc.php"; 
            break;
        case 104: //优惠活动
            index.src = "myhot.php";
            break;
        case 105: //彩票游戏
            index.src = "mylottery.php";
            break;
        case 106: //会员注册
            index.src = "myreg.php";
            break;
        case 107: //手机投注
            index.src = "mywap.php";
            break;
        case 108: //备用网址
            index.src = "myline.php";
            break;
        case 109: //真人娱乐
            index.src = "mylive.php";
            break;
        case 110: //MG电子游戏页面
            index.src = "mygame.php";
            break;
        case 111: //AG电子游戏页面
            index.src = "myaggame.php";
            break;
        case 112: //游戏规则
            index.src = "clause.php";
            break;
        
        //彩票
        case 200://重庆时时彩
            index.src = "ssc.php?t=1"; 
            break;
        case 201://广东快乐十分
            index.src = "ssc.php?t=2"; 
            break;
        case 202://北京赛车PK拾
            index.src = "ssc.php?t=3"; 
            break;
        case 203://北京快乐8
            index.src = "ssc.php?t=4"; 
            break;
        case 204://上海时时乐
            index.src = "ssc.php?t=5"; 
            break;
        case 205://福彩3D
            index.src = "ssc.php?t=6"; 
            break;
        case 206://排列三
            index.src = "ssc.php?t=7"; 
            break;
        case 207://七星彩
            index.src = "ssc.php?t=8"; 
            break;
        case 208://幸运飞艇
            index.src = "ssc.php?t=9"; 
            break;
        case 209://极速赛车
            index.src = "ssc.php?t=100"; 
            break;
        case 210://极速时时彩
            index.src = "ssc.php?t=101"; 
            break;
        case 211://极速六合
            index.src = "ssc.php?t=102"; 
            break;
        
        case 300://退出
            index.src = "logout.php";
            break;
        case 301://消息
            memberUrl("member/sys_msg.php");
            break;
        case 302://详情
            memberUrl("member/userinfo.php");
            break;
        case 303://存款
            memberUrl("member/set_money.php");
            break;
        case 304://取款
            memberUrl("member/get_money.php");
            break;
        case 305:
            memberUrl("member/record_ty.php");
            break;
        case 306://报表
            memberUrl("member/report.php");
            break;
        case 307:
            memberUrl("member/agent.php");
            break;
        case 308:
            memberUrl("member/agent_reg.php");
            break;
        case 309:
            memberUrl("member/zr_money.php");
            break;
        case 310:
            memberUrl("member/zr_data_money.php");
            break;
            
            
        case 400: //关于我们
            index.src = "myabout.php?i=us";
            break;
        case 401: //联系我们
            index.src = "myabout.php?i=contact";
            if(typeof(serviceUrl)!="undefined"){
                //window.open(serviceUrl, "_blank");
            }
            break;
        case 402: //合作伙伴
            index.src = "myabout.php?i=partner";
            break;
        case 403: //存款帮助
            index.src = "myabout.php?i=deposit";
            break;
        case 404: //取款帮助
            index.src = "myabout.php?i=withdraw";
            break;
        case 405: //常见问题
            index.src = "myabout.php?i=help";
            break;
        case 406: //玩法介绍
            index.src = "myabout.php?code=wfjs";
            break;
        case 407: //负责任博彩
            index.src = "myabout.php?code=fzrbc";
            break;
        case 408: //底部联系我们
            index.src = "myabout.php?code=lxwm";
            break;
            
        case 500:
            index.src = "xp.php?i=hg";
            break;
        case 501:
            index.src = "xp.php?i=sabah";
            break;
        case 502:
            index.src = "xp.php?i=ipm";
            break;
        case 503: //BBIN体育赛事
            window.open("/cj/live/index.php?type=BBIN&&gameType=4", "_blank");
            break;  

        case 600: 
            window.open("/cj/live/index.php?type=BBIN&&gameType=5", "_blank");
            break;
        case 601:
            index.src = "mygame.php?p=XIN";
            break;
        case 602:
            index.src = "mygame.php?p=MG";
            break;
        case 603:
            index.src = "mygame.php?p=PT";
            break;
        case 604:
            index.src = "mygame.php?p=ENDO";
            break;
        case 605:
            index.src = "mygame.php?p=BG";
            break;
        case 606: //AG电子游戏页面   // 2015-12-15
            //index.src = "myaggame.php";
            break;
        
        case 700:
            liveClick('BBIN&gameType=1', true);
            break;
        case 701:
            liveClick('AGIN');
            break;
        case 702:
            liveClick('AG');
            break;
        case 703:
            liveClick('OG');
            break;
        case 704:
            liveClick('MAYA');
            break;
        case 705:
            liveClick('HG');
            break;
        case 706:
            liveClick('MG&gameType=0');
            break;
        case 707:
            liveClick('PT&gameType=bal');
            break;
            
            
            
            
        case 76: //QQ联系
            // window.open("http://wpa.qq.com/msgrd?v=3&uin=7548908&site=qq&menu=yes", "_blank");
            break;
        case 77: //AG手机端
            // window.open("http://agin.cc/promotion/index.html", "_blank");
            break;
        case 78: //HG手机端
            alert('敬请关注！');
            break;
        case 79: //BBIN手机端
            alert('敬请关注！');
            break;
        case 80: //BBIN电子游艺
            window.open("/cj/live/index.php?type=BBIN&&gameType=5", "_blank");
            break;
        case 81: //BBIN体育赛事
            window.open("/cj/live/index.php?type=BBIN&&gameType=4", "_blank");
            break;
        case 82: //BBIN彩票游戏
            window.open("/cj/live/index.php?type=BBIN&gameType=3", "_blank");
            break;
        case 83: //BBIN视讯直播
            window.open("/cj/live/index.php?type=BBIN&gameType=1", "_blank");
             break;
        case 84: //MG手机端   // 2015-07-30 MG
            alert('敬请关注！');
            break;
        
            
        case 86: //DS手机端   // 2015-08-02 DS
            alert('敬请关注！');
            break;
            
        case 98:
            window.open("/cj/live/index.php?type=SHABA", "_blank");
            break;
        case 99: //即时比分
            window.open("http://99814.com/free.html", "_blank");
            break;
        
        
        default:
            index.src = "myhome.php";
            
    }
}



function aLeftForm1Sub(){
	var un	=	$("#username").val();
	if(un == "" || un == "帐户"){
		$("#username").focus();
        alert("账号请务必输入！");
		return false;
	}
	var pw	=	$("#passwd").val();
	if(pw == "" || pw == "******"){
		$("#passwd").focus();
        alert("密码请务必输入！");
		return false;
	}
	var vc	=	$("#rmNum").val();
	if(vc == "" || vc == "验证码" || vc.length<4){
		$("#rmNum").focus();
        alert("验证码请务必输入！");
		return false;
	}
 
	$("#formsub").attr("disabled",true); //按钮失效
	          
	$.post("logincheck.php",{r:Math.random(),action:"login",vlcodes:vc,username:un,password:pw},function(login_jg){
		if(login_jg.indexOf("1")>=0){ //验证码错误
			alert("验证码错误，请重新输入");
			$("#rmNum").select();
            document.getElementById("vPic").src = "yzm.php?"+Math.random();
		}else if(login_jg.indexOf("2")>=0){ //用户名称或密码
			alert("用户名或密码错误，请重新输入");
			$("#rmNum").val(''); //清空验证码
			$("#passwd").val(''); //清空验证码
			$("#username").select();
            document.getElementById("vPic").src = "yzm.php?"+Math.random();
		}else if(login_jg.indexOf("3")>=0){ //停用，或被删除，或其它信息
			alert("账户异常无法登陆，如有疑问请联系在线客服");
		}else if(login_jg.indexOf("4")>=0){ //登陆成功
            var showClause = arguments[0] ? arguments[0] : 1;
            if(showClause==1){
                menu_url(41);
            }else{
                window.location.reload();
            }
		}
		$("#formsub").attr("disabled",false); //按钮有效
	});
	return false;
}