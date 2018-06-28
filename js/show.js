var myLeg=new Array();
var NoshowLeg=new Array();
//取消赔率变化后背景颜色
function pl_color_off(){
	//$(".bet_bg_color_chg").fadeOut();
	$(".bet_bg_color_chg").attr('class','bet_bg_color');
}

function escape2Html(str) { 
 var arrEntities={'lt':'<','gt':'>','nbsp':' ','amp':'&','quot':'"'}; 
 return str.replace(/&(lt|gt|nbsp|amp|quot);/ig,function(all,t){return arrEntities[t];}); 
} 

//赔率变化 背景色
function pl_color(pl_A,pl_B,id_A,id_B){
	var color = "bet_bg_color";
	if(pl_A!=pl_B && id_A==id_B){
		color = "bet_bg_color_chg";
	}
	return color;
}

//初始化 已点底色
function pl_bg_color(str){
	if(top.t_type != 'parlay'){
		if( typeof( top.lastidName ) != "undefined" && top.lastidName != ""){
			var s = 'id="'+top.lastidName+'" class="bet_bg_color_bet"';
			var s1 = 'id="'+top.lastidName+'" class="bet_bg_color"';
			var s2 = 'id="'+top.lastidName+'" class="bet_bg_color_chg"';
			str = str.replace(s1,s);
			str = str.replace(s2,s);
			
		}
	}else{
		var lastParlayID = top.lastParlayID;
		if(lastParlayID.length>0){
			for(var i=0;i<lastParlayID.length;i++){

				var s  = 'id="'+lastParlayID[i].split('_')[0]+'" class="bet_bg_color_bet"';
				var s1 = 'id="'+lastParlayID[i].split('_')[0]+'" class="bet_bg_color"';
				var s2 = 'id="'+lastParlayID[i].split('_')[0]+'" class="bet_bg_color_chg"';
				str = str.replace(s1,s);
				str = str.replace(s2,s);
			}
		}
	}
	return str;
}


//點了要有底色再點一次要取消注單 William 2016-03-15
function Bright(idName,_name){
	if(top.t_type != 'parlay'){
		if( typeof( top.lastidName ) != "undefined" && top.lastidName != ""){
			if(top.lastidName == idName){
				var obj = document.getElementById(idName);
				if(obj != null){
					obj.className = "bet_bg_color";
				}
				top.lastidName = "";
				parent.document.getElementById('leftFrame').contentWindow.quxiao_bet();
			}else{

				var obj = document.getElementById(top.lastidName);
				if(obj != null){
					obj.className = "bet_bg_color";
				}

				document.getElementById(idName).className = "bet_bg_color_bet";
				top.lastidName = idName;

			}
		}else{
			var obj = document.getElementById(idName);
			if(obj != null){
				obj.className = "bet_bg_color_bet";
			}
			top.lastidName = idName;
		}
	}else{
		var lastParlayID = top.lastParlayID;
		if(lastParlayID.length>0){
			var isParlay = 'N';

			var s = _name.split('vs');
			var s1 = s[0].split(' -')[0];
			var s2 = s[1].split(' -')[0];

			_name = s1+'vs'+s2;

			for(var i=0;i<lastParlayID.length;i++){
				if(lastParlayID[i].indexOf(_name)>0){
					isParlay = 'Y';
				}
			}

			if(isParlay == 'N'){
				var obj = document.getElementById(idName);
				if(obj != null){
					obj.className = "bet_bg_color_bet";
				}

				top.lastParlayID.push(idName+'_'+_name);
			}

		}else{
			var s = _name.split('vs');
			var s1 = s[0].split(' -')[0];
			var s2 = s[1].split(' -')[0];

			_name = s1+'vs'+s2;
			
			top.lastParlayID.push(idName+'_'+_name);
			var obj = document.getElementById(idName);
			if(obj != null){
				obj.className = "bet_bg_color_bet";
			}
		}

		
	}
}

//清除过关底色
function Bright_gg(idName){
	var obj = document.getElementById(idName);
	if(obj != null){
		obj.className = "bet_bg_color";
	}
}

function divOnBlur(showdiv,selid){
	selid.click=null;
	showdiv.style.display='';

	showdiv.focus();

}

function initDivBlur_PFunction(showdiv,selid){
	showdiv.tabIndex=100;
	showdiv.onblur=function(){
		showdiv.style.display='none';
		setTimeout(function(){
			selid.onclick=function(){
				divOnBlur(showdiv,selid);
				set_class();
			}
		},300);

	};

}

function createTTClass(str,aclass){
    return "<tt class='"+aclass+"'>"+str+"</tt>";
}

function initDivBlur_PFunction_new(showdiv,selid){
	showdiv.tabIndex=100;
	
	showdiv.onblur=function(){
		blurHash[selid.id] = "Y";
		showdiv.style.display='none';
		setTimeout(function(){
				blurHash[selid.id] = "N";
		},300);
	};

}

//將時間 轉回 24小時//04:00p
function  change_time(get_time){

	if (get_time.indexOf("font") > 0 ) return get_time;
	if (get_time.indexOf("p")>0 || get_time.indexOf("a")>0){
		gtime=get_time.split(":");
		if (gtime[1].indexOf("p")>0){

			if (gtime[0]!="12"){
				gtime[0]=gtime[0]*1+12;
			}
		}
		gtime[1]=gtime[1].replace("a","").replace("p","");

	}else{
		return get_time;
	}
	return gtime[0]+":"+gtime[1];

}

function TeamName(Name){
	return Name.replace(" [中]","").split(" - (")[0];
}

//我的收藏
function addShowLoveI(id,_id){

	var love = top.myLove[top.w_type][gtype];
	if(typeof(love)=='undefined'){
		love = new Array();
	}

	if($.inArray(_id,love)==-1){
		love.push(_id);

		var d_id = document.getElementById(id);
		d_id.className = "bet_game_star_on";
		d_id.title = "删除收藏";
		d_id.style.display = "";
		nid = id+"_off";
		d_id.id = nid;
		document.getElementById(id+'_none').id = nid+"_none";
		$("#"+nid).click(function(){
			chkDelshowLoveI(nid,_id);
		});
		top.myLove[top.w_type][gtype] = love;
	}
	
	chkOKshowLoveI();
}

//删除我的收藏
function chkDelshowLoveI(id,_id){
	
	var love = top.myLove[top.w_type][gtype];
	if(typeof(love)=='undefined'){
		love = new Array();
	}

	if($.inArray(_id,love)>=0){
		
		love.splice($.inArray(_id,love),1);
		var d_id = document.getElementById(id);
		d_id.className = "bet_game_star_out";
		d_id.title = "赛事收藏";
		d_id.style.display = "none";
		var nid = id.replace("_off","");
		d_id.id =  nid;
		document.getElementById(id+'_none').id = nid+"_none";
		$("#"+nid).click(function(){
			addShowLoveI(nid,_id);
		});
		top.myLove[top.w_type][gtype] = love;
	}
	chkOKshowLoveI();
}



function chkOKshowLoveI(){
	var love = top.myLove[top.w_type][gtype];
	if(typeof(love)=='undefined'){
		love = new Array();
	}

	if(love.length>0){
		$("#showNull").css('display','none');//无收藏
		if(lives=='N'){
			$("#showMy").css('display','');//我的收藏
			$("#showshowAll").css('display','none');//全部收藏
		}else{
			$("#showMy").css('display','none');//我的收藏
			$("#showshowAll").css('display','');//全部收藏
		}
		
		$("#live_num").html(love.length);
		$("#live_num_all").html(love.length);
	}else{
		lives = 'N';
		$("#showNull").css('display','');//无收藏
		$("#showMy").css('display','none');//我的收藏
		$("#showAll").css('display','none');//全部收藏
		$("#live_num").html('');
		$("#live_num_all").html('');
	}


}


function showAllGame(){
	lives = 'N';
	$("#showMy").css('display','');//我的收藏
	$("#showAll").css('display','none');//全部收藏
	loaded(document.getElementById('league').value,0);
}

function showMyLove(){
	lives = 'Y';
	$("#showMy").css('display','none');//我的收藏
	$("#showAll").css('display','');//全部收藏
	loaded(document.getElementById('league').value,0);
}
/*----------------赛事收藏结束--------------*/

//背景色
var bg_game_class=" bet_game_bg";
var bg_game_more_class=" bet_game_bg_more";//多類別背景色
var bg_text_class=" bet_game_rbg";
var bg_newtext_class=" bet_game_rbg_l";


function mouseEnter_pointer(tmp){
	if(!tmp) return;

	try{
		//背景色
		var classset=bg_game_class;

		if(ptype_arr.indexOf(tmp.split("_")[1])!=-1) classset=bg_game_more_class;

		document.getElementById("TR_"+tmp.split("_")[1]).className+=classset;

		document.getElementById("TR1_"+tmp.split("_")[1]).className+=classset;
		document.getElementById("TR2_"+tmp.split("_")[1]).className+=classset;
		document.getElementById("TR_"+tmp.split("_")[1]+"_text_1").className+=bg_newtext_class;
		document.getElementById("TR_"+tmp.split("_")[1]+"_text_2").className+=bg_text_class;

		document.getElementById("TR_"+tmp.split("_")[1]+"_text_3").className+=bg_text_class;
		document.getElementById("TR1_"+tmp.split("_")[1]+"_text_1").className+=bg_newtext_class;
		document.getElementById("TR1_"+tmp.split("_")[1]+"_text_2").className+=bg_text_class;
		document.getElementById("TR1_"+tmp.split("_")[1]+"_text_3").className+=bg_text_class;
		document.getElementById("TR2_"+tmp.split("_")[1]+"_text_1").className+=bg_newtext_class;
		document.getElementById("TR2_"+tmp.split("_")[1]+"_text_2").className+=bg_text_class;
		document.getElementById("TR2_"+tmp.split("_")[1]+"_text_3").className+=bg_text_class;
		
	  //我的最愛
		if(top.t_type!="parlay"){
		  var love_id=document.getElementById("love"+tmp.split("_")[1]);
		  var love_none=document.getElementById("love"+tmp.split("_")[1]+"_none");
		  if(love_id.tagName!=null)love_id.style.display ="";
		  if(love_none.tagName!=null)love_none.style.display ="none";
		}
	}catch(E){}
}

function mouseOut_pointer(tmp){
	if(!tmp) return;
	try{
		//背景色
		document.getElementById("TR_"+tmp.split("_")[1]).className=document.getElementById("TR_"+tmp.split("_")[1]).className.split(" ")[0];
		document.getElementById("TR1_"+tmp.split("_")[1]).className=document.getElementById("TR1_"+tmp.split("_")[1]).className.split(" ")[0];
		document.getElementById("TR2_"+tmp.split("_")[1]).className=document.getElementById("TR2_"+tmp.split("_")[1]).className.split(" ")[0];


		document.getElementById("TR_"+tmp.split("_")[1]+"_text_1").className=document.getElementById("TR_"+tmp.split("_")[1]+"_text_1").className.split(" ")[0];
		document.getElementById("TR_"+tmp.split("_")[1]+"_text_2").className=document.getElementById("TR_"+tmp.split("_")[1]+"_text_2").className.split(" ")[0];
		document.getElementById("TR_"+tmp.split("_")[1]+"_text_3").className=document.getElementById("TR_"+tmp.split("_")[1]+"_text_3").className.split(" ")[0];
		document.getElementById("TR1_"+tmp.split("_")[1]+"_text_1").className=document.getElementById("TR1_"+tmp.split("_")[1]+"_text_1").className.split(" ")[0];
		document.getElementById("TR1_"+tmp.split("_")[1]+"_text_2").className=document.getElementById("TR1_"+tmp.split("_")[1]+"_text_2").className.split(" ")[0];
		document.getElementById("TR1_"+tmp.split("_")[1]+"_text_3").className=document.getElementById("TR1_"+tmp.split("_")[1]+"_text_3").className.split(" ")[0];
		document.getElementById("TR2_"+tmp.split("_")[1]+"_text_1").className=document.getElementById("TR2_"+tmp.split("_")[1]+"_text_1").className.split(" ")[0];
		document.getElementById("TR2_"+tmp.split("_")[1]+"_text_2").className=document.getElementById("TR2_"+tmp.split("_")[1]+"_text_2").className.split(" ")[0];
		document.getElementById("TR2_"+tmp.split("_")[1]+"_text_3").className=document.getElementById("TR2_"+tmp.split("_")[1]+"_text_3").className.split(" ")[0];

		//我的最愛
		if(top.t_type!="parlay"){
			var love_out_id=document.getElementById("love"+tmp.split("_")[1]);
		  	var love_out_none=document.getElementById("love"+tmp.split("_")[1]+"_none");

			if(love_out_id!=null)love_out_id.style.display ="none";
			if(love_out_none!=null)love_out_none.style.display ="";
		}
	}catch(E){}
}

function mouseEnter_pointer_op(tmp){
	try{
		//背景色
		document.getElementById("TR_"+tmp.split("_")[1]).className+=bg_game_class;
		document.getElementById("TR1_"+tmp.split("_")[1]).className+=bg_game_class;
		document.getElementById("TR2_"+tmp.split("_")[1]).className+=bg_game_class;


  		//我的最愛
		if(top.t_type!="parlay"){
		  var love_id=document.getElementById("love"+tmp.split("_")[1]);
		  var love_none=document.getElementById("love"+tmp.split("_")[1]+"_none");
		  if(love_id.tagName!=null)love_id.style.display ="";
		  if(love_none.tagName!=null)love_none.style.display ="none";
		}
	}catch(E){}
}

function mouseOut_pointer_op(tmp){
	try{
		//背景色
		document.getElementById("TR_"+tmp.split("_")[1]).className=document.getElementById("TR_"+tmp.split("_")[1]).className.split(" ")[0];
		document.getElementById("TR1_"+tmp.split("_")[1]).className=document.getElementById("TR1_"+tmp.split("_")[1]).className.split(" ")[0];
		 document.getElementById("TR2_"+tmp.split("_")[1]).className=document.getElementById("TR2_"+tmp.split("_")[1]).className.split(" ")[0];

		//我的最愛
		if(top.t_type!="parlay"){
			var love_out_id=document.getElementById("love"+tmp.split("_")[1]);
		  	var love_out_none=document.getElementById("love"+tmp.split("_")[1]+"_none");

			if(love_out_id!=null)love_out_id.style.display ="none";
			if(love_out_none!=null)love_out_none.style.display ="";
		}
	}catch(E){}
}


function mouseEnter_pointer_bk(tmp){
	try{
		//背景色
		document.getElementById("TR_"+tmp.split("_")[1]).className+=bg_game_class;
		document.getElementById("TR1_"+tmp.split("_")[1]).className+=bg_game_class;

		document.getElementById("TR_"+tmp.split("_")[1]+"_text_1").className+=bg_text_class;
		document.getElementById("TR_"+tmp.split("_")[1]+"_text_2").className+=bg_text_class;
		document.getElementById("TR1_"+tmp.split("_")[1]+"_text_1").className+=bg_text_class;
		document.getElementById("TR1_"+tmp.split("_")[1]+"_text_2").className+=bg_text_class;

	    //我的最愛
		if(top.t_type!="parlay") {
			var love_id=document.getElementById("love"+tmp.split("_")[1]);
		 	var love_none=document.getElementById("love"+tmp.split("_")[1]+"_none");

			if(love_id!=null)love_id.style.display ="";
			if(love_none!=null)love_none.style.display ="none";
			
		}
	}catch(E){}
}

function mouseOut_pointer_bk(tmp){
	try{
		//背景色
		document.getElementById("TR_"+tmp.split("_")[1]).className=document.getElementById("TR_"+tmp.split("_")[1]).className.split(" ")[0];
		document.getElementById("TR1_"+tmp.split("_")[1]).className=document.getElementById("TR1_"+tmp.split("_")[1]).className.split(" ")[0];

		document.getElementById("TR_"+tmp.split("_")[1]+"_text_1").className=document.getElementById("TR_"+tmp.split("_")[1]+"_text_1").className.split(" ")[0];
		document.getElementById("TR_"+tmp.split("_")[1]+"_text_2").className=document.getElementById("TR_"+tmp.split("_")[1]+"_text_2").className.split(" ")[0];
		document.getElementById("TR1_"+tmp.split("_")[1]+"_text_1").className=document.getElementById("TR1_"+tmp.split("_")[1]+"_text_1").className.split(" ")[0];
		document.getElementById("TR1_"+tmp.split("_")[1]+"_text_2").className=document.getElementById("TR1_"+tmp.split("_")[1]+"_text_2").className.split(" ")[0];

		//我的最愛
		if(top.t_type!="parlay") {
			var love_out_id=document.getElementById("love"+tmp.split("_")[1]);
		 	var love_out_none=document.getElementById("love"+tmp.split("_")[1]+"_none");
			if(love_out_id!=null)love_out_id.style.display ="none";
			if(love_out_none!=null)love_out_none.style.display ="";
		}
	}catch(E){}
}

//选择排序
function chgSortValue(v){
	sort = v;
	loaded(document.getElementById('league').value,0);
}


//======================选择联盟==========================
function chg_league(gtype){
	if(time) clearTimeout(time);
	closediv();
	var w_type = top.w_type;
	var legview =document.getElementById('legView');
	if(top.t_type=='early'){
		switch(w_type){
			case 'FT':
				w_type = 'FU';
				break;
			case 'BK':
				w_type = 'BU';
				break;
			default:
				w_type = 'FU';
				break;
		}
	}

	try{
		legFrame.location.href="./body_var_lid.php?gtype="+gtype+"&w_type="+w_type;
	}catch(e){
	   legFrame.src="./body_var_lid.php?gtype="+gtype+"&w_type="+w_type;
	}
}

function closediv(){
	var div_id= Array("page","sort","odd");
		for(i=0;i<div_id.length;i++){
			if(document.getElementById("show_"+div_id[i]!=null)){
				document.getElementById("show_"+div_id[i]).style.display ="none";
			}
		}
}

function show_legview(SW,h){
	var hh = document.body.clientHeight;
	if(hh<h){
		document.body.style.height =h + 'px';
	}
	document.getElementById('legView').style.display=SW;
}

function LegBack(){
	var legview =document.getElementById('legView');
	legview.style.display='none';
	loaded(document.getElementById('league').value,0);
	document.body.style.height = '100%';
}
//====================================================
//
//--------------判斷聯盟顯示或隱藏----------------
function showLeg(leg){

	for (var i=0;i<myLeg[leg].length;i++){
		if (document.getElementById("TR_"+myLeg[leg][i]).style.display!="none"){
				showLegIcon(leg,"LegClose",myLeg[leg][i],"none");

		}else{
			showLegIcon(leg,"LegOpen",myLeg[leg][i],"");
		}
	}
	if ((""+NoshowLeg[leg])=="undefined"){
		NoshowLeg[leg]=-1;
	}else{
		NoshowLeg[leg]=NoshowLeg[leg]*-1;
	}
	
	document.body.onscroll = function (){}
	setTimeout(function(){
				getback_top();
				setshowfixhead();	
			},50);
}

function showLegIcon(leg,state,gnumH,display){
	var  ary=document.getElementsByName(leg);


	var tmp=gnumH.split(":");
	var gnumH=tmp[0];
	var isMaster=tmp[1];
	
	for (var j=0;j<ary.length;j++){
		ary[j].innerHTML="<span id='"+state+"'></span>";
	}
	//console.log("TR2_"+gnumH+"display  "+display);
	try{//聯盟前面加箭頭 william 2016-03-14
		document.getElementById("LEG_"+gnumH).className=(display != "none")? "bet_game_league":"bet_game_league_down";
	}catch(E){}
	try{
		if(isMaster=="N" && NotMasterDarw){
			document.getElementById("TR3_"+gnumH).style.display="";
		}else{
			document.getElementById("TR3_"+gnumH).style.display=display;
		}
	}catch(E){}
	try{
		document.getElementById("TR2_"+gnumH).style.display=display;
	}catch(E){}
	try{
		document.getElementById("TR1_"+gnumH).style.display=display;
	}catch(E){}
	try{
		document.getElementById("TR_"+gnumH).style.display=display;
	}catch(E){}
	try{
		document.getElementById("BASE_"+gnumH).style.display=display;
	}catch(E){}
	try{
		document.getElementById("OBT_"+gnumH).style.display=display;
	}catch(E){}
	try{
		document.getElementById("GOAL_"+gnumH).style.display=display;
	}catch(E){}
	
}

function getback_top(){
	try{
				var scrollTop = document.documentElement.scrollTop || document.body.scrollTop || 0;
				var scrollmax=getScrollMax();
				//回到頂部======== joe 160122
				var bodyheight = document.documentElement.clientHeight || document.body.clientHeight ||0;
   			var tab_bak=document.getElementById("tab_bak").clientHeight;
   			var back_value="";
   			//back_value= scrollTop+bodyheight-tab_bak;
   			back_value = scrollTop+bodyheight-tab_bak+9;//多一行白色+9 160309 joe

				//console.log("back_value==> "+back_value+"scrollmax==> "+scrollmax );
   			if(back_value>scrollmax) back_value=scrollmax;

			if(scrollTop>0){
					 //console.log("backTOP display");
   				document.getElementById("backTOP").style.display="";
   				document.getElementById("backTOP").style.top= back_value+"px";
   				document.getElementById("backTOP").style["z-index"] = 1;
   				
   				document.getElementById("show_page_txt").className="bet_page_bot_rt";
   			}else{
   				document.getElementById("backTOP").style.display="none";
   				document.getElementById("show_page_txt").className="bet_page_bot";
   			}
   			//===============
  	}catch(e){
  			systemMsg(e.toString());
  	}
}

function setshowfixhead(){
	//on scroll
	 document.body.onscroll = function (){
			//if(isFixed) return; //2016.0216 Leslie
		 
	  	try{
	   			var scrollTop = document.documentElement.scrollTop || document.body.scrollTop || 0;
	   			if(!isFixed){
			   			document.getElementById("fixhead_layer").style.top= scrollTop+"px";
							document.getElementById("div_bak").style.top = (scrollTop)+"px";
					}
					//回到頂部======== joe 160122
					var bodyheight = document.documentElement.clientHeight || document.body.clientHeight ||0;
	   			var tab_bak=document.getElementById("tab_bak").clientHeight;
	   			var back_value="";
	   			//back_value= scrollTop+bodyheight-tab_bak;
	   			back_value = scrollTop+bodyheight-tab_bak+9;//多一行白色+9 160309 joe

	   			if(back_value>scrollmax) back_value=scrollmax;

					if(scrollTop>0){
	   				document.getElementById("backTOP").style.display="";
	   				document.getElementById("backTOP").style.top= back_value+"px";
	   				document.getElementById("backTOP").style["z-index"] = 1;
	   				document.getElementById("show_page_txt").className="bet_page_bot_rt";
	   			}else{
	   				document.getElementById("backTOP").style.display="none";
	   				document.getElementById("show_page_txt").className="bet_page_bot";

	   			}
	   			//===============
	  	}catch(e){
	  			systemMsg(e.toString());
	  	}
	}


}
//-------------------------------

function chg_wtype(url,wtype,gtypeid){
	top.w_type = wtype;
	top.select = gtypeid;
	location.href=url;
}


//早盘  日期
function showDateSel_FT(){
	
	var showDateSel = document.getElementById("showDateSel");
	var dateSel = document.getElementById("dateSel").innerHTML;

	var tmpShow = "";
	var tempDate = new Array();
	tempDate=getnowek(DateAry);//去掉星期
	
	for(var i=0; i<=8; i++){
		var tmp = dateSel;
		var sel_class = "&nbsp;";
		var sel_value = "";
		var sel_str = "";
		var sel_id = "";
		if(i == 0){
			tmp = tmp.replace("*DATE_SHOWTYPE*","FU");
			sel_value = tempDate[i];
			sel_str = '明日';
		}else if(i+1 == 8){
			tmp = tmp.replace("*DATE_SHOWTYPE*","FU");
			sel_value = tempDate[7]+"|"+tempDate[8]+"|"+tempDate[9]+"|"+tempDate[10]+"|"+tempDate[11]+"|"+tempDate[12]+"|"+tempDate[13];
			sel_str = '未来';
		}else if(i == 8){
			tmp = tmp.replace("*DATE_SHOWTYPE*","FU");
			sel_value = 'ALL';
			sel_str = '所有日期';
			sel_id = "sel_all";
		}else{
			tmp = tmp.replace("*DATE_SHOWTYPE*","FU");
			sel_value = tempDate[i];
			sel_str = chgDateStr(DateAry[i]);
		}

		
		var tAry = sel_gd.split("|");
		if((tAry.length > 1) && ((i+1) == DateAry.length)){
			sel_class = "bet_date_color";
		}else if(sel_value == sel_gd){
			sel_class = "bet_date_color";
		}
		
		
		tmp = tmp.replace("*DATE_ID*",sel_id);
		tmp = tmp.replace("*DATE_CLASS*",sel_class);
		tmp = tmp.replace("*DATE_VALUE*",sel_value);
		tmp = tmp.replace("*DATE_SEL*",sel_str);

		tmpShow += tmp;
	}

	showDateSel.innerHTML = tmpShow;
	
}

//综合过关  日期
function showDateSel_FT_zhgg(){
	
	var showDateSel = document.getElementById("showDateSel");
	var dateSel = document.getElementById("dateSel").innerHTML;

	var tmpShow = "";
	var tempDate = new Array();
	tempDate=getnowek(DateAry);//去掉星期
	
	for(var i=0; i<=8; i++){
		var tmp = dateSel;
		var sel_class = "&nbsp;";
		var sel_value = "";
		var sel_str = "";
		var sel_id = "";
		if(i == 0){
			tmp = tmp.replace("*DATE_SHOWTYPE*","FU");
			sel_value = tempDate[i];
			sel_str = '今日';
		}else if(i == 1){
			tmp = tmp.replace("*DATE_SHOWTYPE*","FU");
			sel_value = tempDate[i];
			sel_str = '明日';
		}else if(i+1 == 8){
			tmp = tmp.replace("*DATE_SHOWTYPE*","FU");
			sel_value = tempDate[7]+"|"+tempDate[8]+"|"+tempDate[9]+"|"+tempDate[10]+"|"+tempDate[11]+"|"+tempDate[12]+"|"+tempDate[13];
			sel_str = '未来';
		}else if(i == 8){
			tmp = tmp.replace("*DATE_SHOWTYPE*","FU");
			sel_value = 'ALL';
			sel_str = '所有日期';
			sel_id = "sel_all";
		}else{
			tmp = tmp.replace("*DATE_SHOWTYPE*","FU");
			sel_value = tempDate[i];
			sel_str = chgDateStr(DateAry[i]);
		}

		
		var tAry = sel_gd.split("|");
		if((tAry.length > 1) && ((i+1) == DateAry.length)){
			sel_class = "bet_date_color";
		}else if(sel_value == sel_gd){
			sel_class = "bet_date_color";
		}
		
		
		tmp = tmp.replace("*DATE_ID*",sel_id);
		tmp = tmp.replace("*DATE_CLASS*",sel_class);
		tmp = tmp.replace("*DATE_VALUE*",sel_value);
		tmp = tmp.replace("*DATE_SEL*",sel_str);

		tmpShow += tmp;
	}

	showDateSel.innerHTML = tmpShow;
	
}

function getnowek(DateAry)//去掉星期
{
	var temp=new Array;
	var tempDateAry = new Array();
	for(var i=0; i<DateAry.length; i++)
	{
		temp = DateAry[i].split("-");
		tempDateAry[i] = temp[0] +"-"+ temp[1]+"-"+temp[2];
	}
	return tempDateAry;
}

function chgDateStr(date){
	var showgdate = date.split("-");
	var tmpsdate="";

	if((showgdate[1]*1)< 10)	showgdate[1] = showgdate[1]*1;
	if((showgdate[2]*1)< 10)	showgdate[2] = showgdate[2]*1;
	tmpsdate = top._date[showgdate[3]]+" "+showgdate[1]+"月"+showgdate[2]+"日";
	
	return tmpsdate;
}

function new_chg_gdate(obj,stype,date){
	g_date = date;
	sel_gd=date;
	pg = 0;

	if(obj=="sel_all") obj=document.getElementById("sel_all");
	
	var tmpObj = document.getElementById("showDateSel");
	for(var i=0; i<tmpObj.children.length; i++){
		tmpObj.children[i].className = "";
	}
	obj.className = "bet_date_color";

	sel_gd = date;

	loaded(document.getElementById('league').value,0);
}