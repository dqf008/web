var ball_odds;
var fp;
var xhm;
var auto_new = false;
var pankouflag = true;//true 开盘，false封盘 


//限制只能输入1-9纯数字 
function digitOnly ($this) {
    var n = $($this);
    var r = /^\+?[1-9][0-9]*$/;
    if (!r.test(n.val())) {
        n.val("");
    }
}

//加载盘口信息
function loadinfo(){
    $.post("../../Lottery/class/odds_2.php", function(data)
        {
            if(data.opentime>0){
                $("#open_qihao").html(data.number);
                $("#qishu").val(data.number);
                ball_odds = data.oddslist;
                loadodds(data.oddslist);//加载赔率
                endtime(data.opentime,data.endtime);//获取盘口信息
                auto(1);//获取最新开奖结果
            }else{
				$(".bian_td_odds").html("-");
				$(".bian_td_inp").html("封盘");
				alert('重庆时时彩已经封盘，请稍后再进行下注！', '提示');
				return false;
            }
        }, "json");
}

//加载赔率
function loadodds(oddslist){
    if (oddslist == null || oddslist == "") {
            $(".bian_td_odds").html("-");
            $(".bian_td_inp").html("封盘");
            return false;
    }
    for(var i = 1; i<10; i++){
        if(i==6){
            for(var s = 1; s<8; s++){
                odds = oddslist.ball[i][s];
                $("#ball_"+i+"_h"+s).html(odds);
				loadinput(i, s);
            }
        }else if(i>=7){
            for(var s = 1; s<6; s++){
                odds = oddslist.ball[i][s];
                $("#ball_"+i+"_h"+s).html(odds);
				loadinput(i, s);
            }
        }else if(i<=5){
            for(var s = 1; s<15; s++){
                odds = oddslist.ball[i][s];
                $("#ball_"+i+"_h"+s).html(odds);
				loadinput(i, s);
            }
        }
    } 
    
}

//更新投注框
function loadinput(ball, s){
    b = "ball_"+ball+"_"+s;
    n = "<input id=\""+b+"\" name=\""+b+"\" style=\"width:80%;\" type=\"text\" onkeyup=\"digitOnly(this)\" maxLength=\"7\" data-role=\"none\" />";
    $("#ball_"+ball+"_t"+s).html(n);
}

//封盘时间
function endtime(iTime,fTime){
    var iHour,iMinute,iSecond;
    var sHour="",sMinute="",sSecond="",sTime="";

    /*iHour = parseInt(iTime/3600);
    if(iHour == 0){
        sHour = "00";
    }
    if(iHour > 0 && iHour < 10){
        sHour = "0" + iHour;
    }
    if(iHour >= 10){
        sHour = iHour;
    }*/
    iMinute = parseInt((iTime/60)%60);
    if(iMinute == 0){
        sMinute = "00";
    }
    if(iMinute > 0 && iMinute < 10){
        sMinute = "0" + iMinute;
    }
    if(iMinute >= 10){
        sMinute = iMinute;
    }
    iSecond = parseInt(iTime%60);
    if(iSecond >= 0 && iSecond < 10 ){
        sSecond = "0" + iSecond;
    }
    if(iSecond >= 10 ){
        sSecond =iSecond;
    }

    sTime = sMinute.toString() +':'+ sSecond.toString();

    if(iTime==0){
        var xnumbers = parseInt($("#open_qihao").html());
        var numinfo= '<span>正在开奖...</span>';
        $("#numbers").html(xnumbers);
        $("#autoinfo").html(numinfo);
    }
    if(fTime<0){
        $(".bian_td_odds").html("-");
        $(".bian_td_inp").html("封盘");
		pankouflag = false;
    }
    if(iTime<0){
		pankouflag = true;
        clearTimeout(fp);
        loadinfo();
    }else{
        iTime--;
		fTime--;
		
        $("#endhtml").html("距离封盘");
        var iStyle = "color:#f60;font-weight:bold;";
        if(fTime<0){
            iStyle = "color:#f00;font-weight:bold;";
            $("#endhtml").html("等待开奖");
        }

        $("#endtime").attr("style",iStyle);
        $("#endtime").html(sTime);
        fp = setTimeout("endtime("+iTime+","+fTime+")",1000);
    }
}

//更新开奖号码
function auto(ball){
    $.post("../../Lottery/class/auto_2.php", {ball : ball}, function(data)
        {
			var openqihao = $("#open_qihao").html();//当前期
			var endtime = $("#endtime").html();//当前期时间
			if(auto_new==false){//人工刷新，不是自动刷新
				//最新开奖
				$("#numbers").html(data.numbers);
				//开奖结果
				$("#autoinfo").html(data.hm[0] + " " + data.hm[1]+ " " + data.hm[2]+ " " + data.hm[3]+ " " + data.hm[4]);
				auto_new = true;
			}else{
				if(openqihao - data.numbers == 1){
					//最新开奖
					$("#numbers").html(data.numbers);
					//开奖结果
					$("#autoinfo").html(data.hm[0] + " " + data.hm[1]+ " " + data.hm[2]+ " " + data.hm[3]+ " " + data.hm[4]);
					clearTimeout(xhm);
				}
			}
			if(openqihao - data.numbers != 1){
				xhm = setTimeout("auto(1)",5000);
			}
        }, "json");
}


//取消下注
function del_bet(){
    $(".bian_td_inp").find("input:text").val("");
}
//投注提交
function sub_bet(){
	if(pankouflag==false){
        alert("已封盘！");
        return;
	}
    if(isLogin()==false){
        alert("登录后才能进行此操作");
        return;
    }
	$.post("../../Lottery/Include/Lottery_PK.php", function(data) {
		var mix = 10; cou = m = 0, txt = '', c=true;
		if(data.cp_zd>=0){
			mix = data.cp_zd;
		}
		var max = 1000000, d=true;
		if(data.cp_zg>=0){
			max = data.cp_zg;
		}
		
		for (var i = 1; i < 10; i++){
			if(i<6){
				for(var s = 1; s < 15; s++){
					if ($("#ball_" + i + "_" + s).val() != "" && $("#ball_" + i + "_" + s).val() != null) {
						//判断最小下注金额
						if (parseInt($("#ball_" + i + "_" + s).val()) < mix) {
							c = false;
							alert("最低下注金额："+mix+"￥");return false;
						}
						if (parseInt($("#ball_" + i + "_" + s).val()) > max) {
							d = false;
							alert("最高下注金额："+max+"￥");return false;
						}
						m = m + parseInt($("#ball_" + i + "_" + s).val());
						//获取投注项，赔率
						var odds = $("#ball_1_h" + s).html();
						var q = did(i);
						var w = wan(s);
						txt = txt + q + '[' + w +'] @ ' + odds + ' x ￥' + parseInt($("#ball_" + i + "_" + s).val()) + '\n';
						cou++;
					}
				}
			}else if(i==6){
				for(var s = 1; s < 8; s++){
					if ($("#ball_" + i + "_" + s).val() != "" && $("#ball_" + i + "_" + s).val() != null) {
						//判断最小下注金额
						if (parseInt($("#ball_" + i + "_" + s).val()) < mix) {
							c = false;
							alert(did(i)+","+wan(s)+",下注金额不能低于最低下注金额："+mix+"￥");return false;
						}
						if (parseInt($("#ball_" + i + "_" + s).val()) > max) {
							d = false;
							alert(did(i)+","+wan(s)+",下注金额不能高于最高下注金额："+max+"￥");return false;
						}
						m = m + parseInt($("#ball_" + i + "_" + s).val());
						//获取投注项，赔率
						var odds = $("#ball_"+i+"_h" + s).html();
						var q = did(i);
						var w = wan6(s);
						txt = txt + q + '[' + w +'] @ ' + odds + ' x ￥' + parseInt($("#ball_" + i + "_" + s).val()) + '\n';
						cou++;
					}
				}
			}else if(i==7 || i==8 || i==9){
				for(var s = 1; s < 6; s++){
					if ($("#ball_" + i + "_" + s).val() != "" && $("#ball_" + i + "_" + s).val() != null) {
						//判断最小下注金额
						if (parseInt($("#ball_" + i + "_" + s).val()) < mix) {
							c = false;
							alert("最低下注金额："+mix+"￥");return false;
						}
						if (parseInt($("#ball_" + i + "_" + s).val()) > max) {
							d = false;
							alert("最高下注金额："+max+"￥");return false;
						}
						m = m + parseInt($("#ball_" + i + "_" + s).val());
						//获取投注项，赔率
						var odds = $("#ball_7_h" + s).html();
						var q = did(i);
						var w = wan789(s);
						txt = txt + q + '[' + w +'] @ ' + odds + ' x ￥' + parseInt($("#ball_" + i + "_" + s).val()) + '\n';
						cou++;
					}
				}
			}
		}
		if (!c) {alert("最低下注金额："+mix+"￥");return false;}
		if (!d) {alert("最高下注金额："+max+"￥");return false;}
		if (cou <= 0) {alert("请输入下注金额!!!");return false;}
		var t = "共 ￥"+m+" / "+cou+" 笔，确定下注吗？\n\n下注明细如下：\n\n";
		txt = t + txt;
		var ok = confirm(txt);
		if (ok){
			document.cqsscOrder.submit();
		}
		document.cqsscOrder.reset();
	}, "json");
}
//是否登录
function isLogin(){
    var uid = $("#uid").val();
    if(uid<=0){
        return false;
    }
    return true;
}
//读取第几球
function did (type)
{
    var r = '';
    switch (type)
    {
        case 1 : r = '第一球'; break;
        case 2 : r = '第二球'; break;
        case 3 : r = '第三球'; break;
        case 4 : r = '第四球'; break;
        case 5 : r = '第五球'; break;
        case 6 : r = '总和、龙虎和'; break;
        case 7 : r = '前三'; break;
        case 8 : r = '中三'; break;
        case 9 : r = '后三'; break;
    }
    return r;
}
//读取玩法
function wan (type)
{
    var r = '';
    switch (type)
    {
        case 1 : r = '0'; break;
        case 2 : r = '1'; break;
        case 3 : r = '2'; break;
        case 4 : r = '3'; break;
        case 5 : r = '4'; break;
        case 6 : r = '5'; break;
        case 7 : r = '6'; break;
        case 8 : r = '7'; break;
        case 9 : r = '8'; break;
        case 10 : r = '9'; break;
        case 11 : r = '大'; break;
        case 12 : r = '小'; break;
        case 13 : r = '单'; break;
        case 14 : r = '双'; break;
    }
    return r;
}
//读取玩法
function wan6 (type)
{
    var r = '';
    switch (type)
    {
        case 1 : r = '总和大'; break;
        case 2 : r = '总和小'; break;
        case 3 : r = '总和单'; break;
        case 4 : r = '总和双'; break;
        case 5 : r = '龙'; break;
        case 6 : r = '虎'; break;
        case 7 : r = '和'; break;
    }
    return r;
}
//读取玩法
function wan789 (type)
{
    var r = '';
    switch (type)
    {
        case 1 : r = '豹子'; break;
        case 2 : r = '顺子'; break;
        case 3 : r = '对子'; break;

        case 4 : r = '半顺'; break;
        case 5 : r = '杂六'; break;
    }
    return r;
}