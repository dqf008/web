// JavaScript Document
var dbs  = null;
var data = null;
var window_hight	=	0; //窗口高度
var window_lsm		=	0; //窗口联赛名
var blurHash = new Object();
var ptype_arr=new Array();
blurHash["pg_txt"] = "N";
var gtype = "hbd";
var lives = 'N';//默认 我的收藏
var sort = 'T';//默认排序方式 T 时间  C联盟
var ids = "";
function loaded(league,thispage,p){
	var league = encodeURI(league);
	$("#sel_sort").click(function(){
		divOnBlur(document.getElementById("show_sort"),document.getElementById("sel_sort"));
	});

	initDivBlur_PFunction(document.getElementById("show_sort"),document.getElementById("sel_sort"));
	
	$.getJSON("ft_banquanchang_data.php?leaguename="+league+"&CurrPage="+thispage+"&sort="+sort+"&callback=?",function(json){
		var pagecount	=	json.fy.p_page;
		var page		=	json.fy.page;
		var fenye		=	"";
		window_hight	=	json.dh;
		window_lsm		=	json.lsm;
		if(dbs !=null){
			if(thispage==0 && p!='p'){	
				data = dbs;
				dbs  = json.db;  
			}else{
				dbs  = json.db;  
				data = dbs;
			}
		}else{
			dbs  = json.db;
			data = dbs;
		}	
		
		if(pagecount == 0){
			$('#pg_txt').css('display','none');
		}else{
			var page_str;
			var page_str_new;
			$('#pg_txt').css('display','');
			page_str=(page*1+1)+"/" +pagecount+"页";
			
			var pghtml="<tt class='bet_normal_text'>"+page_str+"</tt>";
		 	pghtml+="	<div id='show_page' onmouseleave='hideDiv(this.id);' tabindex='100' class='bet_page_bg' style='display:none;'>"
  	  		pghtml+="<span class='bet_arrow'></span><span class='bet_arrow_text'>页数</span>";
			pghtml+="<ui>";
			for(var i=0;i<pagecount;i++){
				if(i == page){
					pghtml+="<li id='page_"+i+"' class='bet_page_contant_choose' style='list-style-type:none;' onclick='NumPage("+i+");'>"+(i+1)+"</li>";
				}else{
					pghtml+="<li id='page_"+i+"' class='bet_page_contant' style='list-style-type:none;' onclick='NumPage("+i+");'>"+(i+1)+"</li>";
				}
			 	
			}
			pghtml+="</ui></div>";
			$('#pg_txt').html(pghtml);

			$('#pg_txt').click(function(){
				
				if(blurHash["pg_txt"]=="N"){
					$("#show_page").css('display','');
					$("#show_page").focus();
				}
				
			});
			initDivBlur_PFunction_new(document.getElementById("show_page"),document.getElementById("pg_txt"));
		}


		//表单
		var showtableData = document.getElementById('showtableData').textContent;

		if(dbs == null){
			var NoDataTR = document.getElementById('NoDataTR').textContent;
			showtableData = showtableData.replace("*showDataTR*",NoDataTR);
		}else{
			var lsm = '';
			var dataAll = "";

			for(var i=0; i<dbs.length; i++){
				var onelayer = document.getElementById('DataTR').textContent;
				onelayer=onelayer.replace(/\*ID_STR\*/g,dbs[i]["Match_Date"]+dbs[i]["Match_MasterID"]);
				onelayer=onelayer.replace(/\*TR_EVENT\*/g,"onMouseOver='mouseEnter_pointer(this.id);' onMouseOut='mouseOut_pointer(this.id);'");
				//--------------判斷聯盟名稱列顯示或隱藏----------------
				if (""+myLeg[dbs[i]["Match_Name"]]=="undefined"){
						myLeg[dbs[i]["Match_Name"]]=dbs[i]["Match_Name"];
						myLeg[dbs[i]["Match_Name"]]=new Array();
						myLeg[dbs[i]["Match_Name"]][0]=dbs[i]["Match_Date"]+dbs[i]["Match_MasterID"];
				}else{
						myLeg[dbs[i]["Match_Name"]][myLeg[dbs[i]["Match_Name"]].length]=dbs[i]["Match_Date"]+dbs[i]["Match_MasterID"];
				}

				if(lsm == dbs[i]["Match_Name"]){
					onelayer=onelayer.replace("*ST*"," style='display: none;'  id='LEG_"+dbs[i]["Match_Date"]+dbs[i]["Match_MasterID"]+"'");
				}else{
					lsm = dbs[i]["Match_Name"];
					onelayer=onelayer.replace("*ST*"," style='display: ;' title='选择 >> "+lsm+"' id='LEG_"+dbs[i]["Match_Date"]+dbs[i]["Match_MasterID"]+"'");
					//myLeg[dbs[i]["Match_Name"]][i] = dbs[i]["Match_Date"]+dbs[i]["Match_MasterID"];
				}
				//---------------------------------------------------------------------
				
				
				//--------------判斷聯盟底下的賽事顯示或隱藏----------------
				if (NoshowLeg[dbs[i]["Match_Name"]]==-1){
					onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: none;'");
					onelayer=onelayer.replace("*LegMark*","class='bet_game_league_down'"); //聯盟的小圖箭頭向下
				}else{
					onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: ;'");
					onelayer=onelayer.replace("*LegMark*","class='bet_game_league'");  //聯盟的小圖箭頭向上
				}
				//---------------------------------------------------------------------
				
				onelayer=onelayer.replace(/\*LEG\*/gi,lsm);


				 
				onelayer=onelayer.replace("*DATETIME*",change_time(dbs[i]["Match_Time"]));
				
				if(dbs[i]["Match_IsLose"]==1){
					onelayer=onelayer.replace("*DISPLAY_LIVE*", "style='display:'");
				}else{
					onelayer=onelayer.replace("*DISPLAY_LIVE*", "style='display:none'");
				}

				if(dbs[i]["Match_Master"].indexOf('[中]')>0){
					onelayer=onelayer.replace("*DISPLAY_MIDFIELD*", "style='display:'");
				}else{
					onelayer=onelayer.replace("*DISPLAY_MIDFIELD*", "style='display:none'");
				}
				
				onelayer=onelayer.replace("*TEAM_H*",TeamName(dbs[i]["Match_Master"]));
				onelayer=onelayer.replace("*TEAM_C*",TeamName(dbs[i]["Match_Guest"]));

				
				//主/主
				if(dbs[i]["Match_BqMM"] !=null && dbs[i]["Match_BqMM"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_BqMM"],data[i]["Match_BqMM"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="FFHH'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="主/主" onclick="javascript:setbet(\'足球单式\',\'半全场-主/主\',\'' + dbs[i]["Match_ID"] + '\',\'Match_BqMM\',0,0,\'主/主\');">'+dbs[i]["Match_BqMM"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_FHH*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_FHH*","");
				}

				//主/和
				if(dbs[i]["Match_BqMH"] !=null && dbs[i]["Match_BqMH"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_BqMH"],data[i]["Match_BqMH"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="FFHN'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="主/和" onclick="javascript:setbet(\'足球单式\',\'半全场-主/和\',\'' + dbs[i]["Match_ID"] + '\',\'Match_BqMH\',0,0,\'主/和\');">'+dbs[i]["Match_BqMH"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_FHN*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_FHN*","");
				}

				//主/客
				if(dbs[i]["Match_BqMG"] !=null && dbs[i]["Match_BqMG"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_BqMG"],data[i]["Match_BqMG"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="FFHC'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="主/客" onclick="javascript:setbet(\'足球单式\',\'半全场-主/客\',\'' + dbs[i]["Match_ID"] + '\',\'Match_BqMG\',0,0,\'主/客\');">'+dbs[i]["Match_BqMG"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_FHC*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_FHC*","");
				}

				//和/主
				if(dbs[i]["Match_BqHM"] !=null && dbs[i]["Match_BqHM"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_BqHM"],data[i]["Match_BqHM"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="FFNH'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="和/主" onclick="javascript:setbet(\'足球单式\',\'半全场-和/主\',\'' + dbs[i]["Match_ID"] + '\',\'Match_BqHM\',0,0,\'和/主\');">'+dbs[i]["Match_BqHM"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_FNH*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_FNH*","");
				}

				//和/和
				if(dbs[i]["Match_BqHH"] !=null && dbs[i]["Match_BqHH"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_BqHH"],data[i]["Match_BqHH"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="FFNN'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="和/和" onclick="javascript:setbet(\'足球单式\',\'半全场-和/和\',\'' + dbs[i]["Match_ID"] + '\',\'Match_BqHH\',0,0,\'和/和\');">'+dbs[i]["Match_BqHH"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_FNN*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_FNN*","");
				}

				//和/客
				if(dbs[i]["Match_BqHG"] !=null && dbs[i]["Match_BqHG"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_BqHG"],data[i]["Match_BqHG"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="FFNC'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="和/客" onclick="javascript:setbet(\'足球单式\',\'半全场-和/客\',\'' + dbs[i]["Match_ID"] + '\',\'Match_BqHG\',0,0,\'和/客\');">'+dbs[i]["Match_BqHG"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_FNC*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_FNC*","");
				}

				//客/主
				if(dbs[i]["Match_BqGM"] !=null && dbs[i]["Match_BqGM"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_BqGM"],data[i]["Match_BqGM"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="FFCH'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="客/主" onclick="javascript:setbet(\'足球单式\',\'半全场-客/主\',\'' + dbs[i]["Match_ID"] + '\',\'Match_BqGM\',0,0,\'客/主\');">'+dbs[i]["Match_BqGM"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_FCH*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_FCH*","");
				}

				//客/和
				if(dbs[i]["Match_BqGH"] !=null && dbs[i]["Match_BqGH"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_BqGH"],data[i]["Match_BqGH"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="FFCN'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="客/和" onclick="javascript:setbet(\'足球单式\',\'半全场-客/和\',\'' + dbs[i]["Match_ID"] + '\',\'Match_BqGH\',0,0,\'客/和\');">'+dbs[i]["Match_BqGH"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_FCN*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_FCN*","");
				}

				//客/客
				if(dbs[i]["Match_BqGG"] !=null && dbs[i]["Match_BqGG"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_BqGG"],data[i]["Match_BqGG"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="FFCC'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="客/客" onclick="javascript:setbet(\'足球单式\',\'半全场-客/客\',\'' + dbs[i]["Match_ID"] + '\',\'Match_BqGG\',0,0,\'客/客\');">'+dbs[i]["Match_BqGG"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_FCC*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_FCC*","");
				}

				dataAll = dataAll+onelayer;
			}

			showtableData = showtableData.replace("*showDataTR*",dataAll);
		}

		$("#showtable").html(showtableData);

		//匹配已选赔率底色
		showtableData = pl_bg_color(showtableData);

		//取消背景颜色
		setTimeout(function(){
			pl_color_off();	
		},3000);
		
	});
}

