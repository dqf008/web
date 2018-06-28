// JavaScript Document
var _mc;
var _set;
var ReloadTimeID = null;

function init(){
	trace("init");

	_mc = new Object();
	_set = new Object();

	//_set["ReloadTimeID"] = null;
	//_set["run_retime"] = parent.myBetSec || 90;
	_set["ticket"] = new Object();
	_set["unsettled_count"] = 0;
	_set["settled_count"] = 0;
	_set["nowShow"] = document.getElementById("unord_setTitle").getAttribute("id");
	_set["win"] = "dark_GreenWord";
	_set["loss"] = "RedWord";
	_set["draw"] = "dark_grayWord";
	_set["icon_W"] = "ord_winIcon";
	_set["icon_L"] = "ord_lossIcon";
	_set["icon_P"] = "ord_darwIcon";
	_set["icon_D"] = "ord_cancelIcon";
	_set["icon_LL"] = "ord_loss_halfIcon";
	_set["icon_LW"] = "ord_win_halfIcon";
	_set["show_off"] = "ord_setTitle_off noFloat";
	_set["div_ord_main"]=parent.document.getElementById("div_ord_main");
  _set["unsettled"]=null;
  _set["settled"]=null;

	_set["unsettled_model"]=document.getElementById("unsettled_detail_model").innerHTML;
	_set["settled_model"]=document.getElementById("settled_detail_model").innerHTML;
	document.getElementById("unord_setTitle").onclick = function(){ showBets(this,"ord_setTitle"); }
	document.getElementById("ord_setTitle").onclick = function(){ showBets(this,"unord_setTitle"); }

	loadData();

}


function Refresh(cr){
	if(cr == "")	return;
	loadData();
}

function loadData(){
	$.getJSON("order_mybet_data.php",function(json){
		top.unsettled = json.unsettled;
		top.settled = json.settled;
		loadDataUnsettled(json.unsettled,json.settled);
		showBets(document.getElementById("unord_setTitle"),"ord_setTitle");
	})
	
}

function loadDataUnsettled(unsettled,settled){//未结算注单
	//var unsettled = top.unsettled;
	if(unsettled!=null){ _set["unsettled_count"] = unsettled.length;}
	if(settled!=null){ _set["settled_count"] = settled.length;}
	
	if(_set["unsettled_count"]>0){//有注单
		var nowUn = "un";
		tmp_screen = "";
		for(var k=0;k<_set["unsettled_count"];k++){
			var tmp_model = document.getElementById("unsettled_model").innerHTML;
			var betid = unsettled[k]["id"];
			var isSp = "";
			var tmp_screen_detail = "";
			var ticket_detailLength = unsettled[k]["ticket_detail"].length;
			var ms = "";

			for(var j=0; j<ticket_detailLength; j++){
				var ticket_detail = unsettled[k]["ticket_detail"][j];
				var tmp_betcontent_model = document.getElementById("betcontent_model").innerHTML;

				var ratio_H = ticket_detail["ratio_H"];
				var ratio_A = ticket_detail["ratio_A"];
				var choose = ticket_detail["choose"];
				var betratio = ticket_detail["betratio"];
				var ioratio = ticket_detail["ioratio"];
				var resultdetail = ticket_detail["resultdetail"];
				ms = ticket_detail["ms"];
				var betdetail = ticket_detail["betdetail"];

				var wlcolor = getWL_inside(resultdetail,betdetail);
				var ulc = "";
				if(nowUn=="" && wlcolor[0]=="D" && resultdetail!=""){
					isSp = "SP";
					ulc = "ord_ul_cancel";
				}
				if(nowUn=="un" && resultdetail=="-"){
					isSp = "SS";
					ulc = "ord_ul_cancel";
				}

				var icon = _set["icon_"+wlcolor[0]];
				var iconclass = "ord_parLI";

				if(nowUn=="un" || ticket_detailLength==1)	icon = "";
				if(icon == "")	iconclass = "";

				tmp_betcontent_model = tmp_betcontent_model.replace(/\*ULCANCEL\*/g,ulc);
				tmp_betcontent_model = tmp_betcontent_model.replace(/\*BETICON\*/g,icon);
				tmp_betcontent_model = tmp_betcontent_model.replace(/\*ICONCLASS\*/g,iconclass);
				tmp_betcontent_model = tmp_betcontent_model.replace(/\*CHOOSE\*/g,choose);
				tmp_betcontent_model = tmp_betcontent_model.replace(/\*BETRATIO\*/g,betratio);
				tmp_betcontent_model = tmp_betcontent_model.replace(/\*IORCLASS\*/g,(ioratio * 1 < 0)?"ior_blue fatWord":"RedWord fatWord");
				tmp_betcontent_model = tmp_betcontent_model.replace(/\*IORATIO\*/g,ioratio);

				tmp_screen_detail += tmp_betcontent_model;
			}

			var betstate = unsettled[k]["betstate"];

			var cr = '';
			var thisTypes = 'unsettled';
			
			var isSp = 'SS';
			if(betstate == "dangerN")	cr = betid;
			var wtype = unsettled[k]["wtype"];
			var vs = unsettled[k]["vs"];
			var _home = unsettled[k]["ticket_detail"][0]["home"];
			var _away = unsettled[k]["ticket_detail"][0]["away"];
			
			var org_score = unsettled[k]["ticket_detail"][0]["org_score"];
			var score = unsettled[k]["ticket_detail"][0]["score"];
			var stake = unsettled[k]["stake"];
			var gold = unsettled[k]["gold"];
			var betinfo = unsettled[k]["betinfo"];
			var result = unsettled[k]["result"];
			var bet_time = unsettled[k]["bet_time"];
			var wlcolor = getWLcolor(result,gold,betstate);

			var sb = "_S";
			var showbetinfo = "";
			var showresult = "";
			if(betstate == "dangerN")	cr = betid;
			var	ms = unsettled[k]["ticket_detail"]["ms"];
			if(ms == "")	sb = "_B";
			if(betinfo == "")	showbetinfo = "None";
			if(result == "")	showresult = "None";

			tmp_model = tmp_model.replace(/\*BETSTATE\*/g,betstate);
			tmp_model = tmp_model.replace(/\*CR\*/g,cr);
			tmp_model = tmp_model.replace(/\*TYPES\*/g,thisTypes);
			tmp_model = tmp_model.replace(/\*BETID\*/g,betid+"_"+k);
			tmp_model = tmp_model.replace(/\*SP\*/g,isSp);
			tmp_model = tmp_model.replace(/\*WTYPE\*/g,wtype);
			tmp_model = tmp_model.replace(/\*SHOWVS\*/g,vs);
			tmp_model = tmp_model.replace(/\*HOME\*/g,_home);
			tmp_model = tmp_model.replace(/\*AWAY\*/g,_away);
			tmp_model = tmp_model.replace(/\*RATIO_H\*/g,ratio_H);
			tmp_model = tmp_model.replace(/\*RATIO_A\*/g,ratio_A);
			tmp_model = tmp_model.replace(/\*ORGSCORE\*/g,org_score);
			tmp_model = tmp_model.replace(/\*SCORE\*/g,score);
			tmp_model = tmp_model.replace(/\*BETCONTENT\*/g,tmp_screen_detail);
			tmp_model = tmp_model.replace(/\*STAKE\*/g,stake);
			if(gold=="-" || gold==0)
			{ 
				if(betstate=="cancel")
				 {tmp_model = tmp_model.replace(/\*GOLD\*/g,"-");}
				 else
				{tmp_model = tmp_model.replace(/\*GOLD\*/g,result.split(" ",1));}
			}
			else{
				
				tmp_model = tmp_model.replace(/\*GOLD\*/g,gold);
				}
			
			tmp_model = tmp_model.replace(/\*BETINFO\*/g,betinfo);
			tmp_model = tmp_model.replace(/\*SHOWBETINFO\*/g,showbetinfo);
			tmp_model = tmp_model.replace(/\*MS\*/g,ms);
			tmp_model = tmp_model.replace(/\*SB\*/g,sb);
			tmp_model = tmp_model.replace(/\*WLCOLOR\*/g,wlcolor["WLC"]);
			tmp_model = tmp_model.replace(/\*WLCOLORGOLD\*/g,wlcolor["WLCG"]);
		  	tmp_model = tmp_model.replace(/\*RESULT\*/g,result); 
			tmp_model = tmp_model.replace(/\*SHOWRESULT\*/g,showresult);
			tmp_screen += tmp_model;
		}

		document.getElementById("unord_setTxT").innerHTML = tmp_screen;
		
	}
}

function closeMore(){
	document.getElementById("ord_DIV_Mask").style.display = "none";
	document.getElementById("ord_DIV_Mask").innerHTML = "";

	//sdocument.getElementById("ord_main").style.overflowY="";
}

function showMore(types,betid){
	var settled = top.settled;
	if(types=="unsettled"){
		settled = top.unsettled;
	}

	var b = betid.split("_");
	var id = b[1];
	betid = b[0];

	var tmp_screen=_set[types+"_model"];
	var tmp_screen_detail = "";
	var ticket_detailLength = settled[id]["ticket_detail"].length;

	var bettime = "";
	var gametime = "";
	var nomalshow = (ticket_detailLength == 1)?"":"None";
	var pshow = (ticket_detailLength == 1)?"":"_p";
	var ms = "";

	for(var k=0; k<ticket_detailLength; k++){//串关
		var tmp_betdetail_model = document.getElementById("betdetail_model"+pshow).innerHTML;

		var game_time = settled[id]["ticket_detail"][k]["game_time"];
		var wtype_detail = settled[id]["ticket_detail"][k]["wtype_detail"];
		var vs_detail = settled[id]["ticket_detail"][k]["vs_detail"];
		var league = settled[id]["ticket_detail"][k]["league"];
		var vs = settled[id]["ticket_detail"][k]["vs"];
		var _home = settled[id]["ticket_detail"][k]["home"];
		var away = settled[id]["ticket_detail"][k]["away"];
		var ratio_H = settled[id]["ticket_detail"][k]["ratio_H"];
		var ratio_A = settled[id]["ticket_detail"][k]["ratio_A"];
		var org_score = settled[id]["ticket_detail"][k]["org_score"];
		var score = settled[id]["ticket_detail"][k]["score"];
		var choose = settled[id]["ticket_detail"][k]["choose"];
		var betratio = settled[id]["ticket_detail"][k]["betratio"];
		var ioratio = settled[id]["ticket_detail"][k]["ioratio"];
		var resultdetail = settled[id]["ticket_detail"][k]["resultdetail"];
		ms = settled[id]["ticket_detail"][k]["ms"];

		var betdetail = settled[id]["ticket_detail"][k]["betdetail"];

		//if(wtype_detail === null){
			wtype_detail = settled[id]["wtype"];
		//}

		if(ticket_detailLength>1 && k==0){
			var wtype = settled[id]["wtype"];
			wtype_detail = wtype+"<br>"+wtype_detail;
		}

		if(vs_detail === null){
			vs_detail = settled[id]["vs"];
		}

		var game_timeAry = game_time.split(" ");
		var dateAry = game_timeAry[0].split("-");
		var timeAry = game_timeAry[1].split(":");

		gametime = dateAry[2]+"/"+dateAry[1]+" "+timeAry[0]+":"+timeAry[1];

		var sb = "_S";
		var it = "";
		var iscancel = "";
		var wl = getWL_inside(resultdetail,betdetail);
		if(ticket_detailLength>1 && (betdetail==top.str_cancel || resultdetail=="-"))	iscancel = "ord_CanBG";
		if(ms=="" && betdetail=="")	it = "None";
		if(ms == "")	sb = "_B";
        
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*ISCANCEL\*/g,iscancel);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*WTYPE\*/g,wtype_detail);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*LEAGUE\*/g,league);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*SHOWVS\*/g,vs_detail);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*HOME\*/g,_home);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*AWAY\*/g,away);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*RATIO_H\*/g,ratio_H);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*RATIO_A\*/g,ratio_A);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*ORGSCORE\*/g,org_score);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*SCORE\*/g,score);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*CHOOSE\*/g,choose);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*BETRATIO\*/g,betratio);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*IORCLASS\*/g,(ioratio * 1 < 0)?"ior_blue fatWord":"RedWord fatWord");
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*IORATIO\*/g,ioratio);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*COLOR\*/g,_set[wl[1]]);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*BETDETAIL\*/g,betdetail);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*MS\*/g,ms);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*SB\*/g,sb);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*IT\*/g,it);
		tmp_betdetail_model = tmp_betdetail_model.replace(/\*GAMETIME\*/g,gametime);

		tmp_screen_detail += tmp_betdetail_model;
	}

	var stake = settled[id]["stake"];
	var gold = settled[id]["gold"];
	var result = settled[id]["result"];
	var bet_time = settled[id]["bet_time"];
	var betstate = settled[id]["betstate"];

	var wlcolor = getWLcolor(result,gold,betstate);
	var bet_timeAry = bet_time.split(" ");
	var dateAry = bet_timeAry[0].split("-");
	var timeAry = bet_timeAry[1].split(":");
	
	bettime = dateAry[2]+"/"+dateAry[1]+" "+timeAry[0]+":"+timeAry[1];

	var sb = "_S";
	var showresult = "";
	var showcancel = "";
	if(ticket_detailLength > 1)	ms = "";
	if(ms == "")	sb = "_B";
	if(result == "")	showresult = "None";
	if(betstate == "cancel")	showcancel = "ord_CanBG";


	tmp_screen = tmp_screen.replace(/\*ALLDETAIL\*/g,tmp_screen_detail);
	tmp_screen = tmp_screen.replace(/\*SHOWCANCEL\*/g,showcancel);
	tmp_screen = tmp_screen.replace(/\*MODEL\*/g,"id_"+types);
	tmp_screen = tmp_screen.replace(/\*STAKE\*/g,stake);
	
	if(gold=="-" || gold==0 ){ 
		if(betstate=="cancel") {
			tmp_screen = tmp_screen.replace(/\*GOLD\*/g,"-");
		}else{
			tmp_screen = tmp_screen.replace(/\*GOLD\*/g,result.split(" ",1));
		}
	}else{
		tmp_screen = tmp_screen.replace(/\*GOLD\*/g,gold);
	}
	tmp_screen = tmp_screen.replace(/\*WLCOLOR\*/g,wlcolor["WLC"]);
	tmp_screen = tmp_screen.replace(/\*WLCOLORGOLD\*/g,wlcolor["WLCG"]);
	tmp_screen = tmp_screen.replace(/\*BETINFO\*/g,result);
	tmp_screen = tmp_screen.replace(/\*SHOWBETINFO\*/g,showresult);
	tmp_screen = tmp_screen.replace(/\*MS\*/g,ms);
	tmp_screen = tmp_screen.replace(/\*SB\*/g,sb);
	tmp_screen = tmp_screen.replace(/\*BETTIME\*/g,bettime);
	tmp_screen = tmp_screen.replace(/\*GAMETIME\*/g,gametime);
	tmp_screen = tmp_screen.replace(/\*BETID\*/g,betid);
	tmp_screen = tmp_screen.replace(/\*NOMALSHOW\*/g,nomalshow);

	divScroll = document.getElementById("ord_main");
	document.getElementById("ord_DIV_Mask").innerHTML = tmp_screen;
	document.getElementById("ord_DIV_Mask").style.display = "";
	_set["ord_Mask_set"]=document.getElementById("id_"+types+"_detail_model");
		
	trace("scrollHeight===>"+_set["div_ord_main"].scrollHeight);
	trace("clientHeight===>"+_set["div_ord_main"].clientHeight);
	trace("offsetHeight===>"+_set["div_ord_main"].offsetHeight);
	trace("_set['div_ord_main'].scrollTop===>"+_set["div_ord_main"].scrollTop);
	trace("document.body.scrollTop===>"+document.body.scrollTop);
	//var top_value=(_set["div_ord_main"].clientHeight/2-_set["ord_Mask_set"].scrollHeight)/2;
	var top_value = 114*id+100;
	_set["ord_Mask_set"].style.top=(top_value<0)?0+"px":top_value+"px";
	
	parent.onloadSet(document.body.scrollWidth,document.body.scrollHeight,"rec_frame");
	document.getElementById("ord_DIV_Mask").style.height = divScroll.scrollHeight+"px";

}

function getWL_inside(result,betdetail){
	var out = new Array("","");
	out[0] = result;
	//console.log(result);
	//console.log(betdetail.split(" ")[0]);
	//console.log(top.str_draw);
	if(result == "-"){
		out[0] = "D";
		out[1] = "loss";
	}else if(result=="W"){
		out[0] = "W";
		out[1] = "win";
	}else if(result=="L"){
		out[0] = "L";
		out[1] = "loss";
	}else if(result=="LW"){
		out[0] = (betdetail.split(" ")[0] == top.str_draw)?"P":"LW";
		out[1] = (betdetail.split(" ")[0] == top.str_draw)?"draw":"win";
	}else if(result=="LL"){
		out[0] = (betdetail.split(" ")[0] == top.str_draw)?"P":"LL";
		out[1] = (betdetail.split(" ")[0] == top.str_draw)?"draw":"loss";
	}else if(result == "P"){
		out[1] = "draw";
	}else{
		if(result == "LM"){
			out[0] = "P";
			out[1] = "draw";
		}else{
			out[0] = "D";
			out[1] = "loss";
		}
	}

	return out;
}

function getWLcolor(result,gold,betstate){
	var wlcolor = {"WLC":"","WLCG":""};
	gold = gold.replace(/\,/g,"");
	if(gold == "-"){
		wlcolor["WLC"] = _set["draw"];
		wlcolor["WLCG"] = _set["draw"];
		
		// 2016-12-22 新會員端-最新十筆交易-已結算-過關單的退還秀成-   ，單式的和局秀成退還
		if(result.indexOf(top.str_refund)!=-1 || result.indexOf(top.str_irish_kiss)!=-1)	wlcolor["WLC"] = _set["draw"];
	}else{
		if(gold*1 < 0){
			wlcolor["WLC"] = _set["loss"] = "RedWord";
			wlcolor["WLCG"] = _set["loss"] = "RedWord";
		}else if(gold*1 > 0){
			wlcolor["WLC"] = _set["win"];
			wlcolor["WLCG"] = _set["win"];
		}else{
			wlcolor["WLC"] = _set["draw"];
			wlcolor["WLCG"] = _set["draw"];
		}
	}
  if(betstate=="cancel") wlcolor["WLC"] = _set["loss"] = "RedWord";	

	return wlcolor;
}

function showBets(targetObj,lastType){
	if(targetObj.getAttribute("id") == _set["nowShow"]){
		_set["nowShow"] = "";

		var nowUn = "un";
		if(targetObj.getAttribute("id") == "ord_setTitle")	nowUn = "";

		var noMyBet = "none";
		var setTxT = "none";
		var oldcss = "ord_setTitle";
		var newcss = "ord_setTitle_off";

		if(targetObj.className.indexOf("ord_setTitle_off") != -1){
			oldcss = "ord_setTitle_off";
			newcss = "ord_setTitle";
			noMyBet = "";

			if(_set[nowUn+"settled_count"] > 0){
				noMyBet = "none";
				setTxT = "";
				
			}
		}

		targetObj.className = targetObj.className.replace(oldcss,newcss);

		document.getElementById(nowUn+"ord_noMyBet").style.display = noMyBet;
		document.getElementById(nowUn+"ord_setTxT").style.display = setTxT;
		document.getElementById(nowUn+"ord_viewG").style.display = setTxT;
	}else{
		_set["nowShow"] = targetObj.getAttribute("id");

		var lastobj = document.getElementById(lastType);
		lastobj.className = lastobj.className.replace("ord_setTitle_off","tmp");
		lastobj.className = lastobj.className.replace("ord_setTitle","ord_setTitle_off");
		lastobj.className = lastobj.className.replace("tmp","ord_setTitle_off");
		targetObj.className = targetObj.className.replace("ord_setTitle_off","ord_setTitle");

		var lastUn = "";
		var nowUn = "un";
		if(_set["nowShow"] == "ord_setTitle"){
			lastUn = "un";
			nowUn = "";
		}

		var noMyBet = "";
		var setTxT = "none";
		if(_set[nowUn+"settled_count"] > 0){
			noMyBet = "none";
			setTxT = "";
		}

		document.getElementById(lastUn+"ord_noMyBet").style.display = "none";
		document.getElementById(lastUn+"ord_setTxT").style.display = "none";
		document.getElementById(lastUn+"ord_viewG").style.display = "none";
		document.getElementById(nowUn+"ord_noMyBet").style.display = noMyBet;
		document.getElementById(nowUn+"ord_setTxT").style.display = setTxT;
		document.getElementById(nowUn+"ord_viewG").style.display = setTxT;
	}

	if(targetObj.className==_set["show_off"] &&document.getElementById("unord_setTitle").className==document.getElementById("ord_setTitle").className){
		resethei("off");
	}else{
		resethei("open");
	}
	//================================
}

function resethei(show_type){
  var sheight=(show_type=="off")?document.getElementById("ord_main").scrollHeight:document.body.scrollHeight;
	try{
		parent.document.getElementById("div_ord_main").scrollTop="0";
	}catch(e){
  }
  parent.onloadSet(document.body.scrollWidth,0,"rec_frame");
  parent.onloadSet(document.body.scrollWidth,sheight,"rec_frame");
  document.getElementById("ord_DIV_Mask").style.height = document.getElementById("ord_main").scrollHeight+"px";
}

function clearTimer(){
	if(_set["ReloadTimeID"])	clearInterval(_set["ReloadTimeID"]);
}

function showPage(types){
	alert('请到[下注记录]中查询...');
}

function systemMsg(msg){
	util.systemMsg("[order_mybet.js]"+msg);
}

function trace(msg){
	util.trace("[order_mybet.js]"+msg);
}