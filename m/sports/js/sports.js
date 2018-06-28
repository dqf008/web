//体育菜单，赛事统计
function index_load(){
	$.getJSON("/leftDao1.php?callback=?",function(json){
		$("#s_zq").html("("+json.zq+")");
		$("#s_zq_ds").html("("+json.zq_ds+")");
		$("#s_zq_gq").html("("+json.zq_gq+")");
		$("#s_zq_sbc").html("("+json.zq_sbc+")");
		$("#s_zq_sbbd").html("("+json.zq_sbbd+")");
		$("#s_zq_bd").html("("+json.zq_bd+")");
		$("#s_zq_rqs").html("("+json.zq_rqs+")");
		$("#s_zq_bqc").html("("+json.zq_bqc+")");
		$("#s_zq_jg").html("("+json.zq_jg+")");
		$("#s_zqzc").html("("+json.zqzc+")");
		$("#s_zqzc_ds").html("("+json.zqzc_ds+")");
		$("#s_zqzc_sbc").html("("+json.zqzc_sbc+")");
		$("#s_zqzc_sbbd").html("("+json.zqzc_sbbd+")");
		$("#s_zqzc_bd").html("("+json.zqzc_bd+")");
		$("#s_zqzc_rqs").html("("+json.zqzc_rqs+")");
		$("#s_zqzc_bqc").html("("+json.zqzc_bqc+")");
		$("#s_lm").html("("+json.lm+")");
		$("#s_lm_ds").html("("+json.lm_ds+")");
		$("#s_lm_dj").html("("+json.lm_dj+")");
		$("#s_lm_gq").html("("+json.lm_gq+")");
		$("#s_lm_jg").html("("+json.lm_jg+")");
		$("#s_lmzc").html("("+json.lmzc+")");
		$("#s_lmzc_ds").html("("+json.lmzc_ds+")");
		$("#s_lmzc_dj").html("("+json.lmzc_dj+")");
		$("#s_wq").html("("+json.wq+")");
		$("#s_wq_ds").html("("+json.wq_ds+")");
		$("#s_wq_bd").html("("+json.wq_bd+")");
		$("#s_wq_jg").html("("+json.wq_jg+")");
		$("#s_pq").html("("+json.pq+")");
		$("#s_pq_ds").html("("+json.pq_ds+")");
		$("#s_pq_bd").html("("+json.pq_bd+")");
		$("#s_pq_jg").html("("+json.pq_jg+")");
		$("#s_bq").html("("+json.bq+")");
		$("#s_bq_ds").html("("+json.bq_ds+")");
		$("#s_bq_zdf").html("("+json.bq_zdf+")");
		$("#s_bq_jg").html("("+json.bq_jg+")");
		$("#s_jr").html("("+json.jr+")");
		$("#s_jr_jr").html("("+json.jr_jr+")");
		$("#s_jr_jg").html("("+json.jr_jg+")");
		$("#s_gj").html("("+json.gj+")");
		$("#s_gj_gj").html("("+json.gj_gj+")");
		$("#s_gj_jg").html("("+json.gj_jg+")");
		$("#f5").css("display","");
		$("#tz_money").html(json.tz_money);
		$("#user_num").html(json.user_num);
		$("#cg_f").html("("+(parseInt(json.zq_ds)+parseInt(json.zq_sbc)+parseInt(json.lm_ds))+")");
		$("#cg_f1").html("("+(parseInt(json.zqzc_ds)+parseInt(json.zqzc_sbc)+parseInt(json.lmzc_ds))+")");
		$("#cg_f_0").html("("+json.zq_ds+")");
		$("#cg_f_1").html("("+json.zq_sbc+")");
		$("#cg_f_2").html("("+json.lm_ds+")");
		$("#cg_f_3").html("("+json.lm_dj+")");
		$("#cg_f1_0").html("("+json.zqzc_ds+")");
		$("#cg_f1_1").html("("+json.zqzc_sbc+")");	
		$("#cg_f1_2").html("("+json.lmzc_ds+")");
		$("#cg_f1_3").html("("+json.lmzc_dj+")");
		$("#s_gq_zq_gq").html("("+json.zq_gq+")");
		$("#s_gq_zq_gq_0").html("("+json.zq_gq+")");
		$("#s_gq_lm_gq").html("("+json.lm_gq+")");
		$("#s_gq_lm_gq_0").html("("+json.lm_gq+")");
	  }
	);
}
$(window).load(function() {
     index_load();
});


//选择多少场赛事
var betnumber = 0;

//下注页面定时关闭
var closetime = 21;
var forwaitclose="";
function waitclose() {
	if (closetime==1) {
		colse_betorder();
	} else {
		closetime -= 1;
		$('#order_reload_sec').html(closetime);
		forwaitclose = setTimeout("waitclose()",1000);
	}
}

//可赢
function may_win(){
	touzhutype = $("#touzhutype").val();
	if(touzhutype==1){
		var bet_money = parseFloat($("input[name='bet_money']").val());
		var bet_point = 1;
		var cg_count = $("#cg_num").html();
		for(i=0;i<cg_count;i++){	  
			bet_point=(parseFloat($("input[name='bet_point[]']:eq("+i+")").val())+parseFloat($("input[name='ben_add[]']:eq("+i+")").val()))*parseFloat(bet_point);
		}	
		$("#win_span").html((bet_point*bet_money).toFixed(2));
	}else{
		var odd = parseFloat($("input[name='bet_point[]']").val());
		var bet_money = parseFloat($("input[name='bet_money']").val());
		var ben_add = parseFloat($("input[name='ben_add[]']").val());
		$("#win_span").html(((odd+ben_add)*bet_money).toFixed(2));
	}
};


//取消下注
function del_bet(obj){
	touzhutype = $("#touzhutype").val();
	$(obj).parent().parent().remove();
	if(touzhutype==1){
		betnumber = $("#cg_num").html()-1;
		$("#cg_num").html(betnumber);
		may_win();
		//for_cg
		for_cg();
	}
	if(betnumber==0){
		betnumber = 0;
		colse_betorder();
	}
};

//关闭注单信息确认页面
function colse_betorder(){
	touzhutype = $("#touzhutype").val();
	$("#div_bet").css("display","none");
	$("input[name='bet_money']").val("");//金额
	$("#win_span").html("0");//可赢金额
	window.clearTimeout(forwaitclose);//去除投注页面的倒计时
	$("#istz").css("display","none");//确认下注，红色字体
	if(touzhutype==0){//单式
		closetime = 21;//重新计算
		$("#touzhudiv").html("").fadeOut();
	}else{//串关
		closetime = 31;//重新计算
	}
};

//显示注单信息确认页面
function bet(data){
	touzhutype = $("#touzhutype").val();
	if(touzhutype==0){
		$("#div_bet").css("display","block");
		$("#touzhudiv").html(data).fadeIn();
		//if(sporttime<=25){
		//	window.clearTimeout(forbeginrefresh);//去除-整个页面刷新
		//}
		window.clearTimeout(forwaitclose);//去除投注页面的倒计时,避免因手机卡，导致，及时混乱
		betnumber =1;
		waitclose();//倒计时关闭,下注窗口
	}else{
		var cg_count = $("#cg_num").html();
		if(cg_count>7){
			alert("串关最多允许8场赛事");
			return ;
		}
		if(data.indexOf("滚球")>=0){
			alert("滚球未开放串关功能");
			return ;
		}
		if(data.indexOf("半全场")>=0){
			alert("半全场未开放串关功能");
			return ;
		}
		if(data.indexOf("角球数")>=0){
			alert("角球数未开放串关功能");
			return ;
		}
		if(data.indexOf("先开球")>=0){
			alert("先开球未开放串关功能");
			return ;
		}
		if(data.indexOf("入球数")>=0){
			alert("入球数未开放串关功能");
			return ;
		}
		if(data.indexOf("波胆")>=0){
			alert("波胆未开放串关功能");
			return ;
		}
		if(data.indexOf("网球")>=0){
			alert("网球未开放串关功能");
			return ;
		}
		if(data.indexOf("排球")>=0){
			alert("排球未开放串关功能");
			return ;
		}
		if(data.indexOf("棒球")>=0){
			alert("棒球未开放串关功能");
			return ;
		}
		if(data.indexOf("金融")>=0){
			alert("金融未开放串关功能");
			return ;
		}
		if(data.indexOf("冠军")>=0){
			alert("冠军未开放串关功能");
			return ;
		}
		if(data.indexOf("主場")>=0){
			alert("同场赛事不能重复参与串关");
			return ;
		}

		//串关  在判断同场赛事不能重复参与串关前，先将赛事名称排除掉，因为赛事名称里可能带有比赛球队名称，如：歐洲足球錦標賽2016(在法國)
		var cpdata = $(data);
		cpdata.find("input[name='match_name[]']").remove();
		var cpdata = cpdata.html();

		for(i=0;i<cg_count;i++){ 
			var master_guest=$("input[name='master_guest[]']:eq("+i+")").val();
			var team=master_guest.split("VS");
			team_a=team[0].split(" -");
			team_b=team[1].split(" -");
			team_a=team_a[0].split("-");
			team_b=team_b[0].split("-");
			team_a=team_a[0].split("[");
			team_b=team_b[0].split("[");
			//alert(team_a[0]);
			//alert(team_b[0]);
			if((cpdata.indexOf(team_a[0])>=0)||(cpdata.indexOf(team_b[0])>=0)){
				alert("同场赛事不能重复参与串关");
				return ;
			} 
		}

		cg_count++;
		betnumber = cg_count;
		$("#cg_num").html(cg_count);
		$("#touzhudiv").fadeIn().append(data);
		alert("已选择赛事："+cg_count+" 场");
		for_cg();
	}
}

//点击，串关的数量，展现详细注单信息
function show_cg_message(){
	var cg_count = $("#cg_num").html();
	if(cg_count<=0){
		alert("尚未选择赛事");
		return false;
	}
	$("#div_bet").css("display","block");
	window.clearTimeout(forwaitclose);//去除投注页面的倒计时,避免因手机卡，导致，及时混乱
	closetime = 31;
	waitclose();//倒计时关闭,下注窗口
	
}

//核对金额
function checknum(){
	var v = $("#bet_money").val();
	if(v == (parseInt(v)*1)){
		 var num = v.indexOf(".");
		 if(num == -1) return true;
		 else{
			alert("交易金额只能为整数");
			return false;
		 }
	}else{
		alert("交易金额只能为整数");
		return false;
	}
}

//点击确认下注 - 校验
function check_bet(){ //提交按钮，提交数据检查
	touzhutype = $("#touzhutype").val();
	//$("#submit_from").attr("disabled",true); //按钮失效
	if($("#istz").css("display")=="block"){
		to_bet();//提交
		return true;
	}else{
		var min_ty = $("#min_ty").html();
			min_ty = min_ty*1;
		var xe	=	$("#max_ds_point_span").html();
			xe	=	xe*1;
		if(xe	< 1){
			alert("您已经退出系统或赛事已关闭\n如您还有疑问请联系在线客服");
			//$("#submit_from").attr("disabled",false); //按钮有效
			return false;
		}
		var bet_money=parseFloat($("#bet_money").val());
		if(bet_money!=(bet_money*1)) bet_money=0;
		
		if(bet_money<min_ty){ //最小10
			alert("投注额最少为 "+min_ty+" RMB");
			$("#bet_money").focus();
			//$("#submit_from").attr("disabled",false); //按钮有效
			return false;
		}
		
		var user_money=$("#user_money").html();
		user_money=parseFloat(user_money.replace("RMB"," "));
		if(bet_money>user_money){
			alert("您的账户余额不足,不能完成本次交易");
			//$("#submit_from").attr("disabled",false); //按钮有效
			return false;
		}
		
		if(!checknum()) return false; //验证是否为正整数
		
		var touzhuxiang=$('input[name="touzhuxiang[]"]').val();
		var ball_sort=$('input[name="ball_sort[]"]').val();
		var bet_info=$('input[name="bet_info[]"]').val();
		if(touzhuxiang=="大小"){
			var match_dxgg=$('input[name="match_dxgg[]"]').val();
			if(ball_sort.indexOf("足球滚球")>=0 || ball_sort.indexOf("足球上半场滚球")>=0){
				bet_info=bet_info.match(/-[U|O][0-9.\/]{0,}\(/);
				bet_info=bet_info+"-";
				bet_info=bet_info.substr(2,bet_info.length-4);
			}else{
				bet_info=bet_info.match(/-[U|O][0-9.\/]{0,}@/);
				bet_info=bet_info+"-";
				bet_info=bet_info.substr(2,bet_info.length-4);
			}
			if(bet_info!=match_dxgg || match_dxgg==176){
				alert("当前盘口已经改变，请重新下单");
				//$("#submit_from").attr("disabled",false); //按钮有效
				return false;
			}
		}
		if(touzhuxiang=="让球"){
			var match_dxgg=$('input[name="match_rgg[]"]').val();
			bet_info=bet_info.match(/-[主|客]让[0-9.\/]{0,}-/);
			bet_info=bet_info+"-";
			bet_info=bet_info.substr(3,bet_info.length-5);
			if(bet_info!=match_dxgg){
				alert("当前盘口已经改变，请重新下单");
				//$("#submit_from").attr("disabled",false); //按钮有效
				return false;
			}
		}
		
		var yinghuo=parseFloat($("#win_span").html());
		if(yinghuo!=(yinghuo*1)) yinghuo=0;
		
		if(touzhutype==0){
			var bet_point=parseFloat($("input[name='bet_point[]']").val())*1;
			if(bet_point==0.01){
				alert("赔率已改变，请重新下单");
				$("#submit_from").attr("disabled",false); //按钮有效
				return false;
			}
			bet_point = bet_point+parseInt($("input[name='ben_add[]']").val(),10);
			bet_point=(bet_money*bet_point).toFixed(2);
			if(yinghuo!=bet_point*1){
				alert(yinghuo);
				alert(bet_point);
				alert("交易金额必须手动输入");
				//$("#submit_from").attr("disabled",false); //按钮有效
				return false;
			}
			if( bet_money>=yinghuo ){
				alert("赔率已改变，请重新下单");
				//$("#submit_from").attr("disabled",false); //按钮有效
				return false;
			}
			ball_sort = encodeURI(ball_sort);
			touzhuxiang = encodeURI(touzhuxiang);
			var match_id = $('input[name="match_id[]"]').val();
			$.getJSON(
				"/checkxe.php?ball_sort="+ball_sort+"&touzhuxiang="+touzhuxiang+"&bet_money="+bet_money+"&match_id="+match_id,
				function(json){
					if(json.result == "ok"){
							closetime = 21;
							$("#istz").css("display","block");
							//$("#submit_from").attr("disabled",false); //按钮有效
							//$("#submit_from").focus();
							return false;
					}else if(json.result == "wdl"){
						alert("请登录");
					}else{
						alert(json.result);
						//$("#submit_from").attr("disabled",false); //按钮有效
						return false;
					}
				}
			);
			return false;
		}else{
			var bet_point=1;
			var cg_count = $("#cg_num").html();
			if(cg_count<3){
				alert("串关最少允许3场赛事");
				return ;
			}		
			if(cg_count>8){
				alert("串关最多允许8场赛事");
				return ;
			}			
			for(i=0;i<cg_count;i++){	  
				bet_point=(parseFloat($("input[name='bet_point[]']:eq("+i+")").val())+parseFloat($("input[name='ben_add[]']:eq("+i+")").val()))*parseFloat(bet_point);
			}
			bet_point=(bet_money*bet_point).toFixed(2);
			if(yinghuo!=bet_point*1){
				alert("交易金额必须手动输入");
				//$("#submit_from").attr("disabled",false); //按钮有效
				return false;
			}
			if(bet_money>=yinghuo ){
				alert("赔率已改变，请重新下单");
				//$("#submit_from").attr("disabled",false); //按钮有效
				return false;
			}
			$.getJSON(
				"/checkcg.php?bet_money="+bet_money,
				function(json){
					if(json.result == "ok"){
							closetime = 31;
							$("#istz").css("display","block");
							//$("#submit_from").attr("disabled",false); //按钮有效
							//$("#submit_from").focus();
							return false;
					}else if(json.result == "wdl"){
						alert("请登录");
					}else{
						alert(json.result);
						//$("#submit_from").attr("disabled",false); //按钮有效
						return false;
					}
				}
			);
			return false;
		}
	}
}

//异步提交
function to_bet(){	
	touzhutype = $("#touzhutype").val();
    if($("#uid").val()=="" || $("#uid").val()=="0"){ //没有登录
		alert("登录后才能进行此操作");
		return ;
	}
	if($("#user_money").html()=="" || $("#user_money").html()=="0"){ //金额不足
		alert("金额不足，请先充值");
		return ;
	}
	
	if(touzhutype==0){
		var ball_sort=$('input[name="ball_sort[]"]').val();
		var point_column=$('input[name="point_column[]"]').val();
		var match_name=$('input[name="match_name[]"]').val();
		var master_guest=$('input[name="master_guest[]"]').val();
		var match_id=$('input[name="match_id[]"]').val();
		var tid=$('input[name="tid[]"]').val();
		var bet_info=$('input[name="bet_info[]"]').val();
		var touzhuxiang=$('input[name="touzhuxiang[]"]').val();
		var match_showtype=$('input[name="match_showtype[]"]').val();
		var match_rgg=$('input[name="match_rgg[]"]').val();
		var match_dxgg=$('input[name="match_dxgg[]"]').val();
		var match_nowscore=$('input[name="match_nowscore[]"]').val();
		var bet_point=$('input[name="bet_point[]"]').val();
		var match_type=$('input[name="match_type[]"]').val();
		var ben_add=$('input[name="ben_add[]"]').val();
		var match_time=$('input[name="match_time[]"]').val();
		var match_endtime=$('input[name="match_endtime[]"]').val();
		var Match_HRedCard=$('input[name="Match_HRedCard[]"]').val();
		var Match_GRedCard=$('input[name="Match_GRedCard[]"]').val();
		var orderkey=$('input[name="orderkey[]"]').val();
		var is_lose=$('input[name="is_lose"]').val();
	}else{
		var ball_sort=GetArray("ball_sort[]");
		var point_column=GetArray("point_column[]");
		var match_name=GetArray("match_name[]");
		var master_guest=GetArray("master_guest[]");
		var match_id=GetArray("match_id[]");
		var tid=GetArray("tid[]");
		var bet_info=GetArray("bet_info[]");
		var touzhuxiang=GetArray("touzhuxiang[]");
		var match_showtype=GetArray("match_showtype[]");
		var match_rgg=GetArray("match_rgg[]");
		var match_dxgg=GetArray("match_dxgg[]");
		var match_nowscore=GetArray("match_nowscore[]");
		var bet_point=GetArray("bet_point[]");
		var match_type=GetArray("match_type[]");
		var ben_add=GetArray("ben_add[]");
		var match_time=GetArray("match_time[]");
		var match_endtime=GetArray("match_endtime[]");
		var Match_HRedCard=GetArray("Match_HRedCard[]");
		var Match_GRedCard=GetArray("Match_GRedCard[]");
		var orderkey=GetArray("orderkey[]");
		var is_lose="0";
	}
	
	var touzhutype=$('input[name="touzhutype"]').val();
	var bet_money=$('input[name="bet_money"]').val();

	$.post("/m/sports/common/bet.php",
		{
		"ball_sort[]":ball_sort,
		"point_column[]":point_column,
		"match_name[]":match_name,
		"master_guest[]":master_guest,
		"match_id[]":match_id,
		"tid[]":tid,
		"bet_info[]":bet_info,
		"touzhuxiang[]":touzhuxiang,
		"match_showtype[]":match_showtype,
		"match_rgg[]":match_rgg,
		"match_dxgg[]":match_dxgg,
		"match_nowscore[]":match_nowscore,
		"bet_point[]":bet_point,
		"match_type[]":match_type,
		"ben_add[]":ben_add,
		"match_time[]":match_time,
		"match_endtime[]":match_endtime,
		"Match_HRedCard[]":Match_HRedCard,
		"Match_GRedCard[]":Match_GRedCard,
		"orderkey[]":orderkey,
		"is_lose":is_lose,
		touzhutype:touzhutype,
		bet_money:bet_money,
		rand:Math.random()
		},function (data){
			//提示
			var alertmsg = "";
			switch (data){
				case "1": alertmsg = "交易成功";break;
				case "2": alertmsg = "交易确认中";break;
				case "3": alertmsg = "交易失败";break;
				case "4": alertmsg = "交易失败1";break;
				case "5": alertmsg = "账户余额不足<br>交易失败";break;
				case "6": alertmsg = "扣款失败<br>交易失败";break;
				case "7": alertmsg = "交易金额有误<br>交易失败";break;
				case "8": alertmsg = "交易金额多于系统限额";break;
				case "9": alertmsg = "交易金额不能少于最低限额";break;
				case "10": alertmsg = "赛事已结束<br>交易失败";break;
				case "11": alertmsg = "盘口已关闭<br>交易失败";break;
				case "12": alertmsg = "串关最少允许3场赛事";break;
				case "13": alertmsg = "串关最多允许8场赛事";break;
				case "14": alertmsg = "信息被篡改，投注失败，请返回重新投注！";break;
				case "15": alertmsg = "错误操作，已被系统自动踢线！";break;
				case "16": alertmsg = "非法操作，账号已被停用！";break;
				case "17": alertmsg = "非法打水，账号已被停用（1）！";break;
				case "18": alertmsg = "非法打水，账号已被停用（2）！";break;
				case "19": alertmsg = "非法打水，账号已被停用（3）！";break;
				case "20": alertmsg = "非法打水，账号已被停用（4）！";break;
				case "21": alertmsg = "网络异常,交易失败！";break;
				case "22": alertmsg = "盘口已变更(让球，大小球),交易失败,请刷新！";break;
				case "23": alertmsg = "数据[表]查询失败，交易失败";break;
				case "24": alertmsg = "数据[字段]查询失败，交易失败";break;
				default: alertmsg = data;break;
			}
			if(touzhutype!=0){//清除串关数据
				cg_count = 0;
				betnumber = cg_count;
				$("#cg_num").html(cg_count);
				$("#touzhudiv").html("").fadeOut();
				for_cg();
			}
			alert(alertmsg);
			//关闭注单信息确认页面
			colse_betorder();
	}); 
}

function GetArray(name){
	var tempArray = new Array();	
	$('input[name="'+name+'"]').each(function(){
		tempArray.push($(this).val());
	});
	return tempArray;
}

//体育除滚球外，数据格式
function formatNumber(num,exponent){
	if(num > 0){
		return parseFloat(num).toFixed(exponent);
	}else{
		return '';
	}
} 

//滚球数据格式
function formatNumber(num,exponent){
	return parseFloat(num).toFixed(exponent);
}  

//选页
function NumPage(thispage){
	g_num		=	0;
	var league	=	document.getElementById('league').value;
	document.getElementById('aaaaa').value = thispage;
	loaded(league,thispage,'p');
}

//选择联赛--单击联赛名
function choose_lsm(lsm){
	document.getElementById("league").value	=	lsm;
	loaded(lsm);
}

//选择联赛--下拉框选择
function for_choose_lsm(){
	var lsm = document.getElementById("lsm").value;
	choose_lsm(lsm);
}

//for_cg
function for_cg(){
	
	var ball_sort=GetArray("ball_sort[]");
	var point_column=GetArray("point_column[]");
	var match_name=GetArray("match_name[]");
	var master_guest=GetArray("master_guest[]");
	var match_id=GetArray("match_id[]");
	var tid=GetArray("tid[]");
	var bet_info=GetArray("bet_info[]");
	var touzhuxiang=GetArray("touzhuxiang[]");
	var match_showtype=GetArray("match_showtype[]");
	var match_rgg=GetArray("match_rgg[]");
	var match_dxgg=GetArray("match_dxgg[]");
	var match_nowscore=GetArray("match_nowscore[]");
	var bet_point=GetArray("bet_point[]");
	var match_type=GetArray("match_type[]");
	var ben_add=GetArray("ben_add[]");
	var match_time=GetArray("match_time[]");
	var match_endtime=GetArray("match_endtime[]");
	var Match_HRedCard=GetArray("Match_HRedCard[]");
	var Match_GRedCard=GetArray("Match_GRedCard[]");
	var orderkey=GetArray("orderkey[]");
	var is_lose=GetArray("is_lose[]");
	
	$.post("/m/sports/common/for_cg.php",
		{
		"ball_sort[]":ball_sort,
		"point_column[]":point_column,
		"match_name[]":match_name,
		"master_guest[]":master_guest,
		"match_id[]":match_id,
		"tid[]":tid,
		"bet_info[]":bet_info,
		"touzhuxiang[]":touzhuxiang,
		"match_showtype[]":match_showtype,
		"match_rgg[]":match_rgg,
		"match_dxgg[]":match_dxgg,
		"match_nowscore[]":match_nowscore,
		"bet_point[]":bet_point,
		"match_type[]":match_type,
		"ben_add[]":ben_add,
		"match_time[]":match_time,
		"match_endtime[]":match_endtime,
		"Match_HRedCard[]":Match_HRedCard,
		"Match_GRedCard[]":Match_GRedCard,
		"orderkey[]":orderkey,
		"is_lose[]":is_lose,
		rand:Math.random()
		},function (data){
			if(data!="ok"){
				alert("出现异常，请刷新重试:"+data);
			}
	});
}
