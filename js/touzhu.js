var cg_count=0; //串关串数
var time_id='';

$(document).ready(function(){
////////////////////////////////////////////////////

	 $("#order_delBTN").click(function(){
	 								$("#win_span").html('0.00');
								    $("#confirm_gold").html('0.00');
								    $("#confirm_wingold").html('0.00');
								    $("#bet_win").val('0.00');
								    $("#bet_money").val("");


	 });

	 $("#bet_money").keyup(function(){
									 //输入金额，最高可赢跟着改变
									 var bet_money=parseFloat($("#bet_money").val()*1);
									// alert(bet_money);
									 var user_money=$("#user_money").html();
									 user_money=parseFloat(user_money.replace("RMB"," "));
								    
								     if(bet_money>user_money)
									 {
                                      alert("您的账户余额不足");
									  return false;
                                     }
									 
									 if(top.t_type != 'parlay'){//单式下注
										 temp_point=parseFloat($("input[name='bet_point[]']").val())+parseInt($("input[name='ben_add[]']").val(),10)
							             var win=(bet_money*temp_point).toFixed(2);
									     $("#win_span").html(win);
									     $("#confirm_gold").html(bet_money);
									     $("#confirm_wingold").html(win);
										 $("#bet_win").val(win);
										 return false;
									 }
									 
									 if(top.t_type == 'parlay'){
                                       //串关下注,计算串关最多可以赢
                                        var temp_point=1;				   
									   for(i=0;i<cg_count;i++)
										 {	  
										temp_point=(parseFloat($("input[name='bet_point[]']:eq("+i+")").val())+parseFloat($("input[name='ben_add[]']:eq("+i+")").val()))*parseFloat(temp_point);
										 }
									
										// var win=bet_money*temp_point;
										 var win=(bet_money*temp_point).toFixed(2);
										 $("#win_span").html(win);
										 $("#confirm_gold").html(bet_money);
								     	 $("#confirm_wingold").html(win);
										 $("#bet_win").val(win);
									
   								     }
									 return false;
								});
});


$(window).load(function() {
	if(top.gunqiu != ''){
		$t = top.gunqiu.split("_");
		Go_RB_page($t[0]);
		if($('#shuaxin').html() != 'Y'){
		  	urlOnclick('show/'+$t[0]+'_gunqiu.html');
		}
		
	}else{
		document.getElementById("title_"+top.t_type).className = "ord_memuBTN_on";
	  	document.getElementById("wager_"+top.w_type).setAttribute("select", top.select);
	  	top.gunqiu = '';
		chgWtype(top.select);
	  	//chgTitle(top.w_type);
	}
	
 	pl_click_off();

     $.getJSON("/leftDao.php?callback=?",function(json){

					var hgNum = top.hgNum;

					//今日赛事统计
					hgNum["today"][0] = json.ft;
					hgNum["today"][1] = json.bk;
					hgNum["today"][2] = json.tn;
					hgNum["today"][3] = json.vb;
					hgNum["today"][4] = json.bs;
					hgNum["today"][5] = json.op;
					hgNum["today"][6] = json.tt;
					hgNum["today"][7] = json.bm;
					hgNum["today"][8] = json.sk;

					//早盘赛事统计
					hgNum["early"][0] = json.ftz;
					hgNum["early"][1] = json.bkz;
					hgNum["early"][2] = json.tnz;
					hgNum["early"][3] = json.vbz;
					hgNum["early"][4] = json.bsz;
					hgNum["early"][5] = json.opz;
					hgNum["early"][6] = json.ttz;
					hgNum["early"][7] = json.bmz;
					hgNum["early"][8] = json.skz;

					//过关赛事统计
					hgNum["parlay"][0] = json.ft_zhgg;
					hgNum["parlay"][1] = json.bk_zhgg;
					hgNum["parlay"][2] = json.tn_zhgg;
					hgNum["parlay"][3] = json.vb_zhgg;
					hgNum["parlay"][4] = json.bs_zhgg;
					hgNum["parlay"][5] = json.op_zhgg;
					hgNum["parlay"][6] = json.tt_zhgg;
					hgNum["parlay"][7] = json.bm_zhgg;
					hgNum["parlay"][8] = json.sk_zhgg;

					//滚球赛事统计
					hgNum["live"][0] = json.ft_rb;
					hgNum["live"][1] = json.bk_rb;
					hgNum["live"][2] = json.tn_rb;
					hgNum["live"][3] = json.vb_rb;
					hgNum["live"][4] = json.bs_rb;
					hgNum["live"][5] = json.op_rb;
					hgNum["live"][6] = json.tt_rb;
					hgNum["live"][7] = json.bm_rb;
					hgNum["live"][8] = json.sk_rb;

					top.hgNum = hgNum;
					$("#tz_money").html(json.tz_money);
					$("#user_money").html(json.user_money);
					$("#user_num").html(json.user_num);
					if(json.wjs>0 && json.uid>0){
						top.uid = json.uid;
						$("#count_mybet").html(json.wjs);
						$("#count_mybet").css("display","");	
					}else{
						$("#count_mybet").html("");
						$("#count_mybet").css("display","none");
					}																
					loading();
			  }
		);


     
});

function quxiao_bet(){
    clear_input();
      $("#xp").fadeOut();
      $("#touzhudiv").html('');
      pl_click_off();
      showMenu("menu");

      $("#show_parlay").css("display","none");
      $("#pr_menu").css("display","none");

      $("#SIN_BET").css('display','');	
      $("#PAR_BET").css('display','none');
      $("#bet_nodata").css('display','');
      $("#gold_show_cancle").css('display','none');


      if(top.t_type == 'parlay'){
          $("#cg_num").html('0');
          cg_count=0;
      }else{

      }	
}


function clear_input(){
	$("#bet_money").val("");
	$("#win_span").html("0.00");
	$("#win_span1").html("0.00");
	$("#bet_win").val("0.00");
	$("#confirm_gold").html("0.00");
	$("#confirm_wingold").html("0.00");
	$("#cg_msg").hide();
	$("#confirm_div").css("display","none");
	$("#confirm_div").css("height","");
	$("#bet_money").attr("readonly",false);
}

function del_bet(obj){
	if(top.t_type != 'parlay'){
		quxiao_bet();
	}else{
		var inNameStr = $(obj).next().val();
		var lastParlayID = top.lastParlayID;
		var last = new Array();
		if(lastParlayID.length>0){
			for(var i=0;i<lastParlayID.length;i++){
				if(lastParlayID[i].indexOf(inNameStr)>0){
					var idName = lastParlayID[i].split('_')[0];
					parent.document.getElementById('mainFrame').contentWindow.Bright_gg(idName);
				}else{
					last.push(lastParlayID[i]);
				}
			}
		}

		top.lastParlayID = last;

		$(obj).parent().remove();
		cg_count--;
        $("#cg_num").html(cg_count); //add at 2015.04.15
		if(cg_count>=3){
	   		$('#gold_show').css('display','');	
		 	$('#gold_show_cancle').css('display','none');
	   	}else{
	   		$('#gold_show').css('display','none');	
		 	$('#gold_show_cancle').css('display','');
	   	}
		
		if(cg_count==0)
		{
			quxiao_bet();
		}
	}
	//clear_input(); //del at 2015.04.15
}

function waite(){
	if(top.t_type != 'parlay'){ //单式 10 秒不交易，取消交易
		time_id = window.setTimeout("quxiao_bet()",60000);
	}
}

//显示串关条数信息  add at 2015.04.15
function show_cg_count(){
	if(cg_count>0){
		$("#cg_num").html(cg_count);
		$("#cg_msg").show();
	}
}

function bet(data){
	//下注函数
	   clear_input();
	   showMenu("betslip");
 	   if(top.t_type != 'parlay'){  
			 $("#touzhudiv").hide();
			 $("#touzhudiv").html(data).fadeIn(); 
			 $("#bet_moneydiv").show(); 
			 $("#xp").show();

			 $('#bet_money').removeAttr("disabled");

			 $('#gold_show').css('display','');	
			 $('#gold_show_cancle').css('display','none');	

			 $("#show_parlay").css("display","none");
      		 $("#pr_menu").css("display","none");

      		 $("#SIN_BET").css('display','');	
      		 $("#PAR_BET").css('display','none');
      		 $("#bet_nodata").css('display','none');	
			 cg_count=1;
	   }else{

			if(cg_count>7){
				alert("串关最多允许8场赛事");
				show_cg_count();//显示串关条数信息  add at 2015.04.15
				return ;
			}
			if(data.indexOf("滚球")>=0){
				alert("滚球未开放串关功能");
				show_cg_count();//显示串关条数信息  add at 2015.04.15
				return ;
			}
			if(data.indexOf("半全场")>=0){
		    	alert("半全场未开放串关功能");
				show_cg_count();//显示串关条数信息  add at 2015.04.15
				return ;
			}
			if(data.indexOf("角球数")>=0){
		    	alert("角球数未开放串关功能");
				show_cg_count();//显示串关条数信息  add at 2015.04.15
				return ;
			}
			if(data.indexOf("先开球")>=0){
		    	alert("先开球未开放串关功能");
				show_cg_count();//显示串关条数信息  add at 2015.04.15
				return ;
			}
			if(data.indexOf("入球数")>=0){
		    	alert("入球数未开放串关功能");
				show_cg_count();//显示串关条数信息  add at 2015.04.15
				return ;
			}
			if(data.indexOf("波胆")>=0){
		    	alert("波胆未开放串关功能");
				show_cg_count();//显示串关条数信息  add at 2015.04.15
				return ;
			}
			if(data.indexOf("网球")>=0){
		    	alert("网球未开放串关功能");
				show_cg_count();//显示串关条数信息  add at 2015.04.15
				return ;
			}
			if(data.indexOf("排球")>=0){
		    	alert("排球未开放串关功能");
				show_cg_count();//显示串关条数信息  add at 2015.04.15
				return ;
			}
			if(data.indexOf("棒球")>=0){
		    	alert("棒球未开放串关功能");
				show_cg_count();//显示串关条数信息  add at 2015.04.15
				return ;
			}
			if(data.indexOf("金融")>=0){
		    	alert("金融未开放串关功能");
				show_cg_count();//显示串关条数信息  add at 2015.04.15
				return ;
			}
			/*if(data.indexOf("冠军")>=0){
		    	alert("冠军未开放串关功能");
				show_cg_count();//显示串关条数信息  add at 2015.04.15
				return ;
			}*/
			if(data.indexOf("主场")>=0){
		    	alert("同场赛事不能重复参与串关!");
				show_cg_count();//显示串关条数信息  add at 2015.04.15
				return ;
			}
			
			
			//串关  在判断同场赛事不能重复参与串关前，先将赛事名称排除掉，因为赛事名称里可能带有比赛球队名称，如：歐洲足球錦標賽2016(在法國)
			//var cpdata = $(data);
			//cpdata.find("input[name='match_name[]']").remove();
			//var cpdata = cpdata.html();
			for(i=0;i<cg_count;i++){ 
				var master_guest=$("input[name='master_guest[]']:eq("+i+")").val();
				var team=master_guest.split("VS.");
				team_a=team[0].split(" -");
				team_b=team[1].split(" -");
				//alert(team_a[0]);
				//alert(team_b[0]);
				
				if((data.indexOf(team_a[0])>=0)||(data.indexOf(team_b[0])>=0)){
					alert("同场赛事不能重复参与串关");
					show_cg_count();//显示串关条数信息  add at 2015.04.15
					return ;
				} 
				/*if(data.indexOf(master_guest)>=0){
					alert("同场赛事不能重复参与串关");
					show_cg_count();//显示串关条数信息  add at 2015.04.15
					return ;
				} */
			}
			
		    cg_count++;
		    $("#show_parlay").css("display","none");
      		$("#pr_menu").css("display","");	
			$("#cg_num").html(cg_count);
			$("#cg_msg").css('display','');
		    $("#touzhudiv").fadeIn().append(data);
		   	if(cg_count>=3){
		   		$('#gold_show').css('display','');	
			 	$('#gold_show_cancle').css('display','none');
		   	}else{
		   		$('#gold_show').css('display','none');	
			 	$('#gold_show_cancle').css('display','');
		   	}
		   		
		 	$("#SIN_BET").css('display','none');	
      		$("#PAR_BET").css('display','');
      		$("#bet_nodata").css('display','none');
		   
		    $("#maxmsg_div").show();
              
              $("#xp").show();  
              $("#left_ids").hide();
              $("#usersid").hide();			
	   }
}

function isnum(obj){
	v = obj.value;
	if(v!=""){
		if(v == (parseInt(v)*1)){
		     num = v.indexOf(".");
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
}

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

function check_bet(){ //提交按钮，提交数据检查
	if($("#confirm_div").css("display")=="block"){
		return true;
	}else{
		var min_ty = $("#min_ty").html();
			min_ty = min_ty*1;
		var xe	=	$("#max_ds_point_span").html().replace(/,/g,'');
			xe	=	xe*1;
		if(xe	< 1){
			alert("您已经退出系统或赛事已关闭\n如您还有疑问请联系在线客服");
			$("#submit_from").attr("disabled",false); //按钮有效
			return false;
		}
		var bet_money=parseFloat($("#bet_money").val()*1);
		if(bet_money!=(bet_money*1)) bet_money=0;
		
		if(bet_money<min_ty){ //最小10
			alert("交易金额最少为 "+min_ty+" RMB");
			$("#submit_from").attr("disabled",false); //按钮有效
			return false;
		}
		
		var user_money=$("#user_money").html();
		user_money=parseFloat(user_money.replace("RMB"," "));
		if(bet_money>user_money){
			alert("您的账户余额不足,不能完成本次交易");
			$("#submit_from").attr("disabled",false); //按钮有效
			return false;
		}
		
		if(!checknum()) return false; //验证是否为正整数
		
		var touzhuxiang=$('input[name="touzhuxiang[]"]').val();
		var ball_sort=$('input[name="ball_sort[]"]').val();
		var bet_info=$('input[name="bet_info[]"]').val();
		if(touzhuxiang=="大小" || touzhuxiang=="总分:大小" || touzhuxiang=="总局数:大 / 小"){
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
				$("#submit_from").attr("disabled",false); //按钮有效
				return false;
			}
		}
		if(touzhuxiang=="让球" || touzhuxiang=="让盘" || touzhuxiang=="让局" || touzhuxiang=="让分"){
			var match_dxgg=$('input[name="match_rgg[]"]').val();
			bet_info=bet_info.match(/-[主|客]让[0-9.\/]{0,}-/);
			bet_info=bet_info+"-";
			bet_info=bet_info.substr(3,bet_info.length-5);
			if(bet_info!=match_dxgg){
				alert("当前盘口已经改变，请重新下单");
				$("#submit_from").attr("disabled",false); //按钮有效
				return false;
			}
		}
		
		var yinghuo=parseFloat($("#win_span").html());
		if(yinghuo!=(yinghuo*1)) yinghuo=0;
		
		if(top.t_type != 'parlay'){
			var bet_point=parseFloat($("input[name='bet_point[]']").val())*1;
			if(bet_point==0.01){
				alert("赔率已改变，请重新下单");
				$("#submit_from").attr("disabled",false); //按钮有效
				return false;
			}
			bet_point = bet_point+parseInt($("input[name='ben_add[]']").val(),10);
			bet_point=(bet_money*bet_point).toFixed(2);
			if(yinghuo!=bet_point*1){
				alert("交易金额必须手动输入");
				$("#submit_from").attr("disabled",false); //按钮有效
				return false;
			}
			if( bet_money>=yinghuo ){
				alert("赔率已改变，请重新下单");
				$("#submit_from").attr("disabled",false); //按钮有效
				return false;
			}
			ball_sort = encodeURI(ball_sort);
			touzhuxiang = encodeURI(touzhuxiang);
			var match_id = $('input[name="match_id[]"]').val();
			$.getJSON(
				"checkxe.php?ball_sort="+ball_sort+"&touzhuxiang="+touzhuxiang+"&bet_money="+bet_money+"&match_id="+match_id,
				function(json){
					if(json.result == "ok"){
							$("#confirm_div").css("display","block");
							$("#confirm_div").css("height","500px");
							$("#bet_money").attr("readonly",true);

							//按钮提交
							$("#confirm_bet").click(function(){
								$("#form1").submit();
							});
							//按钮取消
							$("#confirm_cancel").click(function(){
								$("#confirm_div").css("display","none");
								$("#confirm_div").css("height","");
								$("#bet_money").attr("readonly",false);

							});
							return false;
					}else if(json.result == "wdl"){
						window.location.href = "left.php";
					}else{
						alert(json.result);
						$("#submit_from").attr("disabled",false); //按钮有效
						return false;
					}
				}
			);
			return false;
		}else{
			var bet_point=1;				   
			for(i=0;i<cg_count;i++){	  
				bet_point=(parseFloat($("input[name='bet_point[]']:eq("+i+")").val())+parseFloat($("input[name='ben_add[]']:eq("+i+")").val()))*parseFloat(bet_point);
			}
			bet_point=(bet_money*bet_point).toFixed(2);
			if(yinghuo!=bet_point*1){
				alert("交易金额必须手动输入");
				$("#submit_from").attr("disabled",false); //按钮有效
				return false;
			}
			if(bet_money>=yinghuo ){
				alert("赔率已改变，请重新下单");
				$("#submit_from").attr("disabled",false); //按钮有效
				return false;
			}
			$.getJSON(
				"checkcg.php?bet_money="+bet_money,
				function(json){
					if(json.result == "ok"){
						$("#confirm_div").css("display","block");
						$("#confirm_div").css("height","500px");
						$("#bet_money").attr("readonly",true);

						//按钮提交
						$("#confirm_bet").click(function(){
							$("#form1").submit();
						});
						//按钮取消
						$("#confirm_cancel").click(function(){
							$("#confirm_div").css("display","none");
							$("#confirm_div").css("height","");
							$("#bet_money").attr("readonly",false);

						});
						return false;
					}else if(json.result == "wdl"){
						window.location.href = "left.php";
					}else{
						alert(json.result);
						$("#submit_from").attr("disabled",false); //按钮有效
						return false;
					}
				}
			);
			return false;
		}
	}
}


function urlOnclick(url){ 
	if($('#shuaxin').html() == 'Y'){
		$('#shuaxin').html('N');
	}else{
	  	window.open(url,"mainFrame");
	}
} 

function urlrule(){ 
  window.open("sm/sports.php","_blank");
} 

function offAll(){//清除所有高亮栏目
	var gtypeAry = top.gtypeAry;
	for(var i=0;i<gtypeAry.length;i++){

		//体育栏目 显示灰色
	var objS = document.getElementById("title_"+gtypeAry[i]);
	if(objS != null){
		var classNameS = objS.className;
		objS.className = classNameS.replace(/_on/gi,"_off");
	}

	//滚球栏目 显示灰色
	var objRB = document.getElementById(gtypeAry[i]+"_div_rb");
	if(objRB != null){
		var classNameRB = objRB.className;
		objRB.className = classNameRB.replace(/_on/gi,"_off");
	}

	document.getElementById("wager_"+gtypeAry[i]).style.display = "none";
	}
}

//滚球栏目
function Go_RB_page(RBgtype){
	offAll();
	top.w_type = RBgtype;
	top.gunqiu = RBgtype+'_div_rb';
	document.getElementById("title_today").className = "ord_memuBTN";
	document.getElementById("title_early").className = "ord_memuBTN";
	document.getElementById("title_parlay").className = "ord_memuBTN no_margin";
	var obj = document.getElementById(RBgtype+"_div_rb");
	if(obj != null){
		var newClassName = obj.className;
  		obj.className = newClassName.replace(/_off/gi,"_on");
	}

	if(top.t_type == 'parlay'){//如果停留在过关下注就清除
		top.t_type = 'today';
		quxiao_bet();
	}
}

//体育栏目
function chgTitle(gtype){
	offAll();
	var obj = document.getElementById("title_"+gtype);
	if(obj != null){
		var newClassName = obj.className;
			obj.className = newClassName.replace(/_off/gi,"_on");
	}

	if(top.t_type == "parlay"){
		if(top.w_type != gtype){
			quxiao_bet();
		}
	}

	top.w_type = gtype;
	if(top.t_type == "parlay"){//综合过关
		document.getElementById("title_parlay").className = "ord_memuBTN_on no_margin";
	}else{
		document.getElementById("wager_"+top.w_type).style.display = "";	
	}
	top.gunqiu = '';
	chgShowType(top.t_type);
	//loading();

}

function chgShowType(type){
	offAll();
	document.getElementById("title_today").className = "ord_memuBTN";
	document.getElementById("title_early").className = "ord_memuBTN";
	document.getElementById("title_parlay").className = "ord_memuBTN no_margin";
	//清除背景滚球
	$("ul[id^='wager_']").css('display','none');


	if(top.t_type != type && type=='parlay'){//之前选择不是过关 现在选择过关
		$("#gold_show").css('display','none');
		quxiao_bet();
	}

	if(top.t_type == 'parlay' && type != 'parlay'){//之前选择过关, 现在选择其他

		quxiao_bet();
	}

	top.t_type = type;
	if(type == "parlay"){
		document.getElementById("title_parlay").className = "ord_memuBTN_on no_margin";
	}else{
		document.getElementById("title_"+type).className = "ord_memuBTN_on";
	}
	loading();
}

function ulrSkip(){
var wObj = document.getElementById("wager_"+top.w_type);
if(wObj==null) return;
var _id = wObj.getAttribute("select");
//alert(_id);
chg_type(_id);
}

function chgWtype(_id){
	if(!_id) return;

	var tmp = _id.split("_");
	var gtype = tmp[1];

	var wObj = document.getElementById("wager_"+gtype);
	if(wObj==null) return;


	$("li[id^='wtype_"+gtype+"_']").attr("class","");
	$("li[id='wtype_"+gtype+"_fs']").attr("class","no_margin");

	var tagetObj = document.getElementById(_id);
	if(_id == 'wtype_FT_hpd' || _id == 'wtype_FT_pd35' || _id == 'wtype_FT_pd57'){//上半波胆
		tagetObj = document.getElementById('wtype_FT_pd');
	}

		if(tagetObj!=null) tagetObj.className = "On";
		if(_id == "wtype_"+gtype+"_fs"){
		if(tagetObj!=null) tagetObj.className = "On no_margin";
	}
	top.gunqiu = '';
	wObj.setAttribute("select", _id);
	top.select = _id;

}

function chg_type(a,b){
if(!a) return;
var tmp = a.split("_");
var gtype = tmp[1];
var ltype = tmp[2];


var t = gtype+'_';
if(top.t_type=='early'){
	t = gtype+'z_';
	
}

if(ltype=="fs"){
	t = '';
}


var name = 'danshi.html';
switch(ltype){
	case 'r'://单式
		name = 'danshi.html';
		break;
	case 'pd'://足球-波胆
		name = 'bodan.html';
		break;
	case 'hpd'://足球-上半场波胆
		name = 'shangbanbodan.html';
		break;
	case 'pd35':
		name = 'bodan.html';
		break;
	case 'pd57':
		name = 'bodan.html';
		break;
	case 't'://总入球
		name = 'ruqiushu.html';
		break;
	case 'f'://半全场
		name = 'banquanchang.html';
		break;
	case 'fs'://冠军
		name = 'guanjun.html';
		break;
	default:
		name = 'danshi.html';
		break;
}

var url = "show/"+t+name;
urlOnclick(url);
}


function showMenu(type,isTV){
var ary = new Array("div_menu","div_betslip","div_mybets");
var cssName = document.getElementById("title_"+type).className;
if(cssName == "ord_memuBTN" ||  cssName == "ord_memuBTN no_margin"){
	document.getElementById("title_menu").className = "ord_memuBTN";
	document.getElementById("title_betslip").className = "ord_memuBTN";
	document.getElementById("title_mybets").className = "ord_memuBTN no_margin";

	for(var i=0; i<ary.length; i++){
		var divname = ary[i];
		var dis = "none";
		if(divname=="div_"+type){ 
			dis="";
			if(type == "mybets"){
				document.getElementById("title_"+type).className = "ord_memuBTN_on no_margin";
				document.getElementById("count_mybet").style.display = "none";
				document.getElementById("rec_frame").src = "show/order_mybet.html";
			}else{
				document.getElementById("title_"+type).className = "ord_memuBTN_on";
				if(top.uid>0){
					if($("#count_mybet").html() != "" && $("#count_mybet").html() != 0){
						document.getElementById("count_mybet").style.display = "";
					}else{
						document.getElementById("count_mybet").style.display = "none";
					}
				}else{
					document.getElementById("count_mybet").style.display = "none";
				}
			}

			
		}

		if(top.t_type!="parlay"){
			document.getElementById("show_parlay").style.display = "none";
			document.getElementById("pr_menu").style.display = "none";
			if(cg_count==0){
				document.getElementById("bet_nodata").style.display = "";
			}else{
				document.getElementById("bet_nodata").style.display = "none";
			}
			$("#SIN_BET").css('display','');	
	      	$("#PAR_BET").css('display','none');
		}else{
			if(cg_count>=1){
				if(type == "betslip"){
					document.getElementById("show_parlay").style.display = "none";
					document.getElementById("pr_menu").style.display = "";
				}else{
					document.getElementById("show_parlay").style.display = "";
					document.getElementById("pr_menu").style.display = "none";
				}
				document.getElementById("bet_nodata").style.display = "none";
			}else{
				document.getElementById("bet_nodata").style.display = "";

				document.getElementById("show_parlay").style.display = "none";
				document.getElementById("pr_menu").style.display = "none";
			}

			$("#SIN_BET").css('display','none');	
      		$("#PAR_BET").css('display','');
		}

		document.getElementById(divname).style.display = dis;

	}
}
	
}

function bt_moeny(num){
var money = parseFloat($("#bet_money").val()*1)+parseFloat(num);
$("#bet_money").val(money);
$("#bet_money").keyup();
}

function ok_bet(){
	if(top.t_type == 'parlay') {
		if (parseInt($('#cg_num').html()*1)>=3) {
			return check_bet();
		}else{
			alert('投注失败，请至少选择三场比赛后再进行投注！');
			return false;
		}
	}else{
		return check_bet();
	}

}

function onloadSet(w,h,frameName){
	document.getElementById(frameName).width =200+"px";
	document.getElementById(frameName).height=h+"px";

	try{
		document.getElementById(frameName+"_bak").width =200+"px";
		document.getElementById(frameName+"_bak").height=h+"px";
	}catch(e){}

}

//清除已选赔率
function pl_click_off(){
  if( typeof( top.lastidName ) != "undefined" && top.lastidName != ""){
	   parent.document.getElementById('mainFrame').contentWindow.Bright(top.lastidName);
	   top.lastidName = '';
  }

  var lastParlayID = top.lastParlayID;
  if(lastParlayID.length>0){
	for(var i=0;i<lastParlayID.length;i++){
		var idName = lastParlayID[i].split('_')[0];
		parent.document.getElementById('mainFrame').contentWindow.Bright_gg(idName);
	}
  }
  
  top.lastParlayID = new Array();

}

function loading(){
	var hgNum = top.hgNum;
	//加载滚球
	var gtypeAry = top.gtypeAry; 
	var live = hgNum["live"];
	var rbSum = 0;
	
	//滚球
	for(var i=0; i<live.length;i++){
		if(live[i]>0){
			$("#RB_"+gtypeAry[i]+"_games").html(live[i]);
		$("#"+gtypeAry[i]+"_div_rb").css("display","");
		rbSum = Number(live[i]) + Number(rbSum);
		}else{
			$("#RB_"+gtypeAry[i]+"_games").html("");
		$("#"+gtypeAry[i]+"_div_rb").css("display","none");
		}
	}
	
	if(rbSum>0)	{
		$("#div_rb").css("display","");
		$("#RB_nodata").css("display","none");
	}else{
	$("#div_rb").css("display","none");
	$("#RB_nodata").css("display","");
	}

	//滚球结束
	
	var nums = 0;
	var titleType = "";
	switch(top.t_type){
		case "today":
			titleType = hgNum["today"];
			break;
		case "early":
			titleType = hgNum["early"];
			break;
		case "parlay":
			titleType = hgNum["parlay"];
			cg_count=0;
			break;
	}

	//关闭全部子栏目
	$("ul[id^='wager_']").css('display','none');
	for(var i=0;i<titleType.length;i++){
		var v = titleType[i];
		if(v>0){
			$("#title_"+gtypeAry[i]).css("display","");
			$("#"+gtypeAry[i]+"_games").html(v);
			nums = Number(v) + Number(nums);
		}else{
			$("#title_"+gtypeAry[i]).css("display","none");
			$("#wager_"+gtypeAry[i]).css("display","none");
			$("#"+gtypeAry[i]+"_games").html("");
		}

		//栏目高亮关闭
		var obj = document.getElementById("title_"+gtypeAry[i]);
		if(obj != null){
			var newClassName = obj.className;
	  		obj.className = newClassName.replace(/_on/gi,"_off");
		}


	}
	//跳转网页
  	var num = $("#"+top.w_type+"_games").html();
  	var ttype = top.w_type;
  	
  	if(top.gunqiu != ''){
		$t = top.gunqiu.split("_");
		Go_RB_page($t[0]);
		urlOnclick('show/'+$t[0]+'_gunqiu.html')
	}else{

		if(top.t_type == "parlay"){//综合过关 目前只支持FT BK
			
			var url = 'show/ft_zhgg.html';
			if(top.w_type == "BK"){
				url = 'show/bk_zhgg.html';
				//默认打开项
				var wObj = document.getElementById("wager_BK");
				if(wObj==null) return;
				wObj.getAttribute("select","wtype_BK_r");

				//栏目设置高亮
				var obj = document.getElementById("title_BK");
				if(obj != null){
					var newClassName = obj.className;
			  		obj.className = newClassName.replace(/_off/gi,"_on");
				}
			}else{
				//默认打开项
				var wObj = document.getElementById("wager_FT");
				if(wObj==null) return;
				wObj.getAttribute("select","wtype_FT_r");

				//栏目设置高亮
				var obj = document.getElementById("title_FT");
				if(obj != null){
					var newClassName = obj.className;
			  		obj.className = newClassName.replace(/_off/gi,"_on");
				}
			}

		  	urlOnclick(url);
		}else if(top.t_type == "early"){//早盘 目前只支持FT BK

			if(top.w_type == "BK"){//这里的titleType[2] 表示篮球早餐场数
				if(titleType[2] > 0){
					//栏目设置高亮
					var obj = document.getElementById("title_BK");
					if(obj != null){
						var newClassName = obj.className;
				  		obj.className = newClassName.replace(/_off/gi,"_on");
					}

					//子栏目展开
					$("#wager_BK").css("display","");

					ulrSkip();
				}else{
					//栏目设置高亮
					var obj = document.getElementById("title_FT");
					if(obj != null){
						var newClassName = obj.className;
				  		obj.className = newClassName.replace(/_off/gi,"_on");
					}

					//子栏目展开
					$("#wager_FT").css("display","");

					//默认子栏目
					//$("ul[id^='wtype_FT_']").attr('className','');
					document.getElementById("wtype_FT_pd").className = "";
					document.getElementById("wtype_FT_t").className = "";
					document.getElementById("wtype_FT_f").className = "";
					top.select = 'wtype_FT_r';
					document.getElementById('wtype_FT_r').className = 'On';
					url = 'show/ftz_danshi.html';
					urlOnclick(url);
				}
			}else if(top.w_type == "FT"){
				//栏目设置高亮
				var obj = document.getElementById("title_FT");
				if(obj != null){
					var newClassName = obj.className;
			  		obj.className = newClassName.replace(/_off/gi,"_on");
				}
				//子栏目展开
				$("#wager_FT").css("display","");

				ulrSkip();
			}else{
				//栏目设置高亮
				var obj = document.getElementById("title_FT");
				if(obj != null){
					var newClassName = obj.className;
			  		obj.className = newClassName.replace(/_off/gi,"_on");
				}

				//子栏目展开
				$("#wager_FT").css("display","");
				document.getElementById("wtype_FT_pd").className = "";
				document.getElementById("wtype_FT_t").className = "";
				document.getElementById("wtype_FT_f").className = "";
				//默认子栏目
				$("ul[id^='wtype_FT_']").attr('className','');
				document.getElementById('wtype_FT_r').className = 'On';

				url = 'show/ftz_danshi.html';
				urlOnclick(url);
			}
			
		}else{
			
			//默认打开项
			var wObj = document.getElementById("wager_"+top.w_type);
			if(wObj==null) return;
			wObj.getAttribute("select","wtype_"+top.w_type+"_r");

			//栏目设置高亮
			var obj = document.getElementById("title_"+top.w_type);
			if(obj != null){
				var newClassName = obj.className;
		  		obj.className = newClassName.replace(/_off/gi,"_on");
			}

			//子栏目展开
			$("#wager_"+top.w_type).css("display","");

			ulrSkip();
		}
	}

	if(top.t_type == "parlay"){
		$("#touzhutype").val(1);
	}else{
		$("#touzhutype").val(0);
	}

	if(nums == 0){
  		$("#FT_today_nodata").css("display","none");
  		$("#FT_early_nodata").css("display","none");
  		$("#FT_parlay_nodata").css("display","none");

  		$("#FT_"+top.t_type+"_nodata").css("display","");
  	}else{
  		$("#FT_today_nodata").css("display","none");
  		$("#FT_early_nodata").css("display","none");
  		$("#FT_parlay_nodata").css("display","none");
  	}

}
