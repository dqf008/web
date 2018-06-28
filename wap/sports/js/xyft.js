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
    $.post("../../Lottery/class/odds_8.php", function(data)
        {
           if(data.opentime>0){
                $("#open_qihao").html(data.number);
                ball_odds = data.oddslist;
                loadodds(data.oddslist);
                endtime(data.opentime,data.endtime);
                auto(1);
            }else{
                //$(".qh").html("第 "+data.number+" 期");
				$(".bian_td_odds").html("-");
				$(".bian_td_inp").html("封盘");
				$("#autoinfo").html("已经封盘，请稍后进行投注！");
				alert('幸运飞艇已经封盘，请稍后再进行下注！', '提示');
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

    for(var i = 1; i<17; i++){
        if(i==1){
            for(var s = 1; s<22; s++){
                odds = oddslist.ball[i][s];
                $("#ball_"+i+"_h"+s).html(odds);
                loadinput(i, s);
            }
        }else if(i>=2 && i<12){
            for(var s = 1; s<15; s++){
                odds = oddslist.ball[i][s];
                $("#ball_"+i+"_h"+s).html(odds);
                loadinput(i , s);
            }
        }else if(i>=12 && i<=16){
            for(var s = 1; s<3; s++){
                odds = oddslist.ball[i][s];
                $("#ball_"+i+"_h"+s).html(odds);
                loadinput(i , s);
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
    $.post("../../Lottery/class/auto_8.php", {ball : ball}, function(data)
        {
			
			var txt = $("#autoinfo").html();
        	if(txt == '<span>正在开奖...</span>' && $("#numbers").html() != data.numbers)
        	{
				xhm = setTimeout("auto(1)",3000);
				return ;
			}
			
			$("#numbers").html(data.numbers);
            var openqihao = $("#open_qihao").html();
            if(auto_new == false || openqihao - data.numbers == 1){
                var numinfo = data.hm.join(',');	
                //numinfo = numinfo+'冠亚军和：<span>'+data.hms[0]+'</span><span>'+data.hms[1]+'</span><span>'+data.hms[2]+'</span>1V10龙虎：<span>'+data.hms[3]+'</span>2V9龙虎：<span>'+data.hms[4]+'</span>3V8龙虎：<span>'+data.hms[5]+'</span>4V7龙虎：<span>'+data.hms[6]+'</span>';
                $("#autoinfo").html(numinfo);
                var i=0;
                var fun=5;
                $('.kick').each(function(){
                    var e=$(this).children('img');
                    var nu=data.hm[i];
                    setTimeout(function(){e.prop('src','images/Ball_5/'+nu+'.png');},fun*600);
                    i++;
                    fun--;
                });
                auto_new = true;
                if(openqihao - data.numbers != 1){
                    xhm = setTimeout("auto(1)",3000);
                } 
            }else{
                xhm = setTimeout("auto(1)",3000);
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
		var tt = $("input.inp1");
		var mix = 10; cou = m = 0, txt = '', c=true;
		mix = data.cp_zd;
		var max = 1000000, d=true;
		max = data.cp_zg;
		
		for (var i = 1; i < 17; i++){
			if(i==1){
				for(var s = 1; s < 22; s++){
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
						var odds = $("#ball_"+i+"_h" + s).html();
						var q = did(i);
						var w = wan(s);
						txt = txt + q + '[' + w +'] @ ' + odds + ' x ￥' + parseInt($("#ball_" + i + "_" + s).val()) + '\n';
						cou++;
					}
				}
			}else if(i>=2&&i<=11){
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
						var odds = $("#ball_2_h" + s).html();
						var q = did(i);
						var w = wan2(s);
						txt = txt + q + '[' + w +'] @ ' + odds + ' x ￥' + parseInt($("#ball_" + i + "_" + s).val()) + '\n';
						cou++;
					}
				}
			}else{
				for(var s = 1; s < 3; s++){
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
						var odds = $("#ball_12_h" + s).html();
						var q = did(i);
						var w = wan12(s);
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
		if (ok)
		document.xyftOrder.submit()
		document.xyftOrder.reset()
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
        case 1 : r = '冠、亚军和'; break;
        case 2 : r = '冠军'; break;
        case 3 : r = '亚军'; break;
        case 4 : r = '第三名'; break;
        case 5 : r = '第四名'; break;
        case 6 : r = '第五名'; break;
        case 7 : r = '第六名'; break;
        case 8 : r = '第七名'; break;
        case 9 : r = '第八名'; break;
        case 10 : r = '第九名'; break;
        case 11 : r = '第十名'; break;
        case 12 : r = '1V10 龙虎'; break;
        case 13 : r = '2V9 龙虎'; break;
        case 14 : r = '3V8 龙虎'; break;
        case 15 : r = '4V7 龙虎'; break;
        case 16 : r = '5V6 龙虎'; break;
    }
    return r;
}
//读取玩法
function wan (type)
{
    var r = '';
    switch (type)
    {
        case 1 : r = '3'; break;
        case 2 : r = '4'; break;
        case 3 : r = '5'; break;
        case 4 : r = '6'; break;
        case 5 : r = '7'; break;
        case 6 : r = '8'; break;
        case 7 : r = '9'; break;
        case 8 : r = '10'; break;
        case 9 : r = '11'; break;
        case 10 : r = '12'; break;
        case 11 : r = '13'; break;
        case 12 : r = '14'; break;
        case 13 : r = '15'; break;
        case 14 : r = '16'; break;
        case 15 : r = '17'; break;
        case 16 : r = '18'; break;
        case 17 : r = '19'; break;
        case 18 : r = '冠亚大'; break;
        case 19 : r = '冠亚小'; break;
        case 20 : r = '冠亚单'; break;
        case 21 : r = '冠亚双'; break;
    }
    return r;
}
//读取玩法
function wan2 (type)
{
    var r = '';
    switch (type)
    {
        case 1 : r = '1'; break;
        case 2 : r = '2'; break;
        case 3 : r = '3'; break;
        case 4 : r = '4'; break;
        case 5 : r = '5'; break;
        case 6 : r = '6'; break;
        case 7 : r = '7'; break;
        case 8 : r = '8'; break;
        case 9 : r = '9'; break;
        case 10 : r = '10'; break;
        case 11 : r = '大'; break;
        case 12 : r = '小'; break;
        case 13 : r = '单'; break;
        case 14 : r = '双'; break;
    }
    return r;
}
//读取玩法
function wan12 (type)
{
    var r = '';
    switch (type)
    {
        case 1 : r = '龙'; break;
        case 2 : r = '虎'; break;
    }
    return r;
}

function getSwfId(id) { //与as3交互 跨浏览器
    if (navigator.appName.indexOf("Microsoft") != -1) { 
        return window[id]; 
    } else { 
        return document[id]; 
    } 
} 