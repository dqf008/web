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
    $.post("../../Lottery/class/odds_3.php", function(data)
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
				alert('广东快乐10分已经封盘，请稍后再进行下注！', '提示');
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

    for(var i = 1; i<10; i++)
	{
		if(i == 9)
		{
			//龙虎 
			for(var s =1;s<9;s++)
			{
				odds = oddslist.ball[i][s];
                $("#ball_"+i+"_h"+s).html(odds);
				loadinput(i, s);
			}
			
		}
		else
		{
			//1-8球 每个球下有35项投注，将赔率分别设置
			for(var s =1;s<36;s++)
			{
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
    $.post("../../Lottery/class/auto_3.php", {ball : ball}, function(data)
        {
			var txt = $("#autoinfo").html();
        	if(txt == '<span>正在开奖...</span>' && $("#numbers").html() != data.numbers)
        	{
				xhm = setTimeout("auto(1)",3000);
				return ;
			}
			
			
			$("#numbers").html(data.numbers);
            var openqihao = $("#open_qihao").html();
            if(auto_new == false || openqihao - data.numbers == 1)
			{
                var numinfo = data.hm.join(',');	
                //numinfo = numinfo+'总和：<span>'+data.hms[0]+'</span><span>'+data.hms[1]+'</span><span>'+data.hms[2]+'</span><span>'+data.hms[3]+'</span>龙虎：<span>'+data.hms[4]+'</span>';
                $("#autoinfo").html(numinfo);
                var i=0;
                var fun=5;
                $('.kick').each(function(){
                    var e=$(this).children('img');
                    var nu=BuLing(data.hm[i]);
                    setTimeout(function(){e.prop('src','images/Ball_3/'+nu+'.png');},fun*600);
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
		
		for (var i = 1; i < 10; i++){
			if(i==9){
				for(var s = 1; s < 9; s++){
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
						var w = wan9(s);
						txt = txt + q + '[' + w +'] @ ' + odds + ' x ￥' + parseInt($("#ball_" + i + "_" + s).val()) + '\n';
						cou++;
					}
				}
			}else{
				for(var s = 1; s < 36; s++){
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
			}
		}
		if (!c) {alert("最低下注金额："+mix+"￥");return false;}
		if (!d) {alert("最高下注金额："+max+"￥");return false;}
		if (cou <= 0) {alert("请输入下注金额!!!");return false;}
		var t = "共 ￥"+m+" / "+cou+" 笔，确定下注吗？\n\n下注明细如下：\n\n";
		txt = t + txt;
		var ok = confirm(txt);
		if (ok)
		document.gdklsfOrder.submit()
		document.gdklsfOrder.reset()
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
        case 6 : r = '第六球'; break;
        case 7 : r = '第七球'; break;
        case 8 : r = '第八球'; break;
        case 9 : r = '总和 龙虎'; break;
    }
    return r;
}
//读取玩法
function wan (type)
{
    var r = '';
    switch (type)
    {
        case 1 : r = '01'; break;
        case 2 : r = '02'; break;
        case 3 : r = '03'; break;
        case 4 : r = '04'; break;
        case 5 : r = '05'; break;
        case 6 : r = '06'; break;
        case 7 : r = '07'; break;
        case 8 : r = '08'; break;
        case 9 : r = '09'; break;
        case 10 : r = '10'; break;
        case 11 : r = '11'; break;
        case 12 : r = '12'; break;
        case 13 : r = '13'; break;
        case 14 : r = '14'; break;
        case 15 : r = '15'; break;
        case 16 : r = '16'; break;
        case 17 : r = '17'; break;
        case 18 : r = '18'; break;
        case 19 : r = '19'; break;
        case 20 : r = '20'; break;
        case 21 : r = '大'; break;
        case 22 : r = '小'; break;
        case 23 : r = '单'; break;
        case 24 : r = '双'; break;
        case 25 : r = '尾大'; break;
        case 26 : r = '尾小'; break;
        case 27 : r = '合单'; break;
        case 28 : r = '合双'; break;
        case 29 : r = '东'; break;
        case 30 : r = '南'; break;
        case 31 : r = '西'; break;
        case 32 : r = '北'; break;
        case 33 : r = '中'; break;
        case 34 : r = '发'; break;
        case 35 : r = '白'; break;
    }
    return r;
}
//读取玩法
function wan9 (type)
{
    var r = '';
    switch (type)
    {
        case 1 : r = '总和大'; break;
        case 2 : r = '总和小'; break;
        case 3 : r = '总和单'; break;
        case 4 : r = '总和双'; break;
        case 5 : r = '总和尾大'; break;
        case 6 : r = '总和尾小'; break;
        case 7 : r = '龙'; break;
        case 8 : r = '虎'; break;
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