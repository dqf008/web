// JavaScript Document
var dbs  = null;
var data = null;
var window_hight	=	0; //窗口高度
var window_lsm		=	0; //窗口联赛名
var blurHash = new Object();
var ptype_arr=new Array();
blurHash["pg_txt"] = "N";
var gtype = "r";
var lives = 'N';//默认 我的收藏
var sort = 'T';//默认排序方式 T 时间  C联盟
var ids = "";
var sel_gd = 'ALL';

var DateAry = new Array();
DateAry = top.DateAry_zh;

function loaded(league,thispage,p){
	var league = encodeURI(league);
	$("#sel_sort").click(function(){
		divOnBlur(document.getElementById("show_sort"),document.getElementById("sel_sort"));
	});

	initDivBlur_PFunction(document.getElementById("show_sort"),document.getElementById("sel_sort"));
	showDateSel_FT_zhgg();
	ids = "";
	if(lives == "Y"){
		var love = top.myLove[top.w_type][gtype];
		if(!love){
			love = new Array();
		}
		
		if(love.length>0){
			ids = love.join(",");
		}
	}

	$.getJSON("bk_zhgg_data.php?leaguename="+league+"&CurrPage="+thispage+"&ids="+ids+"&sort="+sort+"&sel_gd="+sel_gd+"&callback=?",function(json){	
		dbs  = null;
		var pagecount	=	json.fy.p_page;
		var page		=	json.fy.page;
		var fenye		=	"";
		window_hight	=	json.dh;
		window_lsm		=	json.lsm;
		
		var idss = json.ids;
		if(league==""){ //没有联盟选择情况下重置
			if(lives == "Y"){
					top.myLove[top.w_type][gtype] = new Array();
					if(idss != ""){
						top.myLove[top.w_type][gtype] = idss.split(',');
					}
				
			}else{
				var lm = new Array();
				lm = top.myLove[top.w_type][gtype];
				if(typeof(top.myLove[top.w_type][gtype])=='object'){
					top.myLove[top.w_type][gtype] = new Array();
					for(var j=0;j<lm.length;j++){
						if(idss.indexOf(lm[j])>=0){
							top.myLove[top.w_type][gtype].push(lm[j]);
						}

					}
				}

			}
		}

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
	

		//设置分页
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

		var showtableData = document.getElementById('showtableData').textContent;
		
		if(dbs == null){
			var NoDataTR = "";
			if(sel_gd == "ALL"){
				NoDataTR = document.getElementById('NoDataTR').textContent;
			}else{
				NoDataTR = document.getElementById('NoDataTR_new').textContent;
			}
			showtableData = showtableData.replace("*showDataTR*",NoDataTR);
		}else{

			var lsm = '';
			var dataAll = "";
			for(var i=0; i<dbs.length; i++){

				
				if(dbs[i]["Match_BzM"]!="0" || dbs[i]["Match_Ho"]!=0 || dbs[i]["Match_DxXpl"]!="0" || dbs[i]["Match_DsDpl"]!="0"){
					var onelayer = document.getElementById('DataTR').textContent;
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

					
					onelayer=onelayer.replace(/\*ID_STR\*/g,dbs[i]["Match_Date"]+dbs[i]["Match_MasterID"]);
					onelayer=onelayer.replace(/\*TR_EVENT\*/g,"onMouseOver='mouseEnter_pointer_bk(this.id);' onMouseOut='mouseOut_pointer_bk(this.id);'");
					onelayer=onelayer.replace("*TR_TOP*","class='bet_game_tr_top'");
					onelayer=onelayer.replace("*DIS_DARW*","");
					onelayer=onelayer.replace("*TR_NUM*","3");
					onelayer=onelayer.replace("*PTYPE_DIS_DARW*","");
					onelayer=onelayer.replace("*PTYPE_TR_NUM*","4");



					//子盤隱藏和局
					onelayer=onelayer.replace(/\*NODARW\*/g,"");

		  			if(dbs[i]["Match_isMaster"]=="Y"){
						var tmp_date_str="<div>"+dbs[i]["Match_Date"]+"</div>";
						tmp_date_str+="<div class='bet_early_time_live'>"+change_time(dbs[i]["Match_Time"])+"</div>";
						onelayer=onelayer.replace("*DATETIME*",tmp_date_str);

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
						onelayer=onelayer.replace("*TR_MASTER*","");
						onelayer=onelayer.replace("*TR_OTHERS*","style='display:none;'");
						onelayer=onelayer.replace("*TR_TOP*","class='bet_game_tr_top'");
					}else{
						if(dbs[i]["Match_MasterID"].length != 5){
							onelayer=onelayer.replace("*TR_MASTER*","style='display:none;'");
							onelayer=onelayer.replace("*TR_OTHERS*","");
							//代表非主場
				  			var tmp_Count = top._session["BKi"+dbs[i]["Match_MasterID"][0]].split(" ");

				  			var count1 = tmp_Count[0];
				  			var count2 = tmp_Count[1];
	  		
							onelayer=onelayer.replace("*COUNT1*",count1);
							onelayer=onelayer.replace("*COUNT2*",count2!=null?count2:"");
						}else{
							onelayer=onelayer.replace("*TR_MASTER*","");
							onelayer=onelayer.replace("*TR_OTHERS*","style='display:none;'");
						}

						onelayer=onelayer.replace("*DATETIME*","");
						onelayer=onelayer.replace("*DISPLAY_LIVE*", "style='display:none'");
						onelayer=onelayer.replace("*DISPLAY_MIDFIELD*", "style='display:none'");
						onelayer=onelayer.replace("*TR_TOP*","class='bet_game_tr_top_color'");
					}
			

					onelayer=onelayer.replace("*TEAM_H*",TeamName(dbs[i]["Match_Master"]));
					onelayer=onelayer.replace("*TEAM_C*",TeamName(dbs[i]["Match_Guest"]));

					//-------------------------独赢-----------------------------
					if(dbs[i]["Match_BzM"]>0 && dbs[i]["Match_BzG"]>0){
						var color_H = "bet_bg_color";
	                    var color_C = "bet_bg_color";
	                    var color_N = "bet_bg_color";
						if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
							color_H = pl_color(dbs[i]["Match_BzM"],data[i]["Match_BzM"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
							color_C = pl_color(dbs[i]["Match_BzG"],data[i]["Match_BzG"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
						}
						var BzM= '<span id="MH'+dbs[i]["Match_ID"]+'" class="'+color_H+'" onclick="Bright(this.id,\''+dbs[i]["Match_Master"]+'vs'+dbs[i]["Match_Guest"]+'\');"><span onclick="javascript:setbet(\'篮球单式\',\'独赢-'+dbs[i]["Match_Master"]+'\',\''+dbs[i]["Match_ID"]+'\',\'Match_BzM\',0,0,\''+dbs[i]["Match_Master"]+'\');" title="'+TeamName(dbs[i]["Match_Master"])+'">'+formatNumber(dbs[i]["Match_BzM"],2)+'</span></span>';
						var BzG= '<span id="MC'+dbs[i]["Match_ID"]+'" class="'+color_C+'" onclick="Bright(this.id,\''+dbs[i]["Match_Master"]+'vs'+dbs[i]["Match_Guest"]+'\');"><span onclick="javascript:setbet(\'篮球单式\',\'独赢-'+dbs[i]["Match_Guest"]+'\',\''+dbs[i]["Match_ID"]+'\',\'Match_BzG\',0,0,\''+dbs[i]["Match_Guest"]+'\');" title="'+TeamName(dbs[i]["Match_Guest"])+'">'+formatNumber(dbs[i]["Match_BzG"],2)+'</span></span>';
						onelayer=onelayer.replace("*RATIO_MH*",BzM);
						onelayer=onelayer.replace("*RATIO_MC*",BzG);

						
					}else{
						onelayer=onelayer.replace("*RATIO_MH*","&nbsp;");
						onelayer=onelayer.replace("*RATIO_MC*","&nbsp;");
					}
					//----------------------------------------------------------
					
					//-------------------------让球-----------------------------
					if(dbs[i]["Match_Ho"]>0 && dbs[i]["Match_Ao"]>0){
						if (dbs[i]["Match_ShowType"]=="H"){
							onelayer=onelayer.replace("*CON_RH*",dbs[i]["Match_RGG"]);	/*讓球球頭*/
							onelayer=onelayer.replace("*CON_RC*","");
						}else{
							onelayer=onelayer.replace("*CON_RH*","");
							onelayer=onelayer.replace("*CON_RC*",dbs[i]["Match_RGG"]);
						}

						/*讓球賠率*/
						var color_H = "bet_bg_color";
	                    var color_C = "bet_bg_color";
						if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
							color_H = pl_color(dbs[i]["Match_Ho"],data[i]["Match_Ho"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
							color_C = pl_color(dbs[i]["Match_Ao"],data[i]["Match_Ao"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
						}
						var Ho = '<span id="RH'+dbs[i]["Match_ID"]+'" class="'+color_H+'" onclick="Bright(this.id,\''+dbs[i]["Match_Master"]+'vs'+dbs[i]["Match_Guest"]+'\');"><span title="'+dbs[i]["Match_Master"]+'" onclick="javascript:setbet(\'篮球单式\',\'让球-'+(dbs[i]["Match_ShowType"]=="H" ? "主让" :"客让")+dbs[i]["Match_RGG"]+"-"+dbs[i]["Match_Master"]+'\',\''+dbs[i]["Match_ID"]+'\',\'Match_Ho\',1,0,\''+dbs[i]["Match_Master"]+'\');" >'+formatNumber(dbs[i]["Match_Ho"],2)+'</span></span>';
						var Ao = '<span id="RC'+dbs[i]["Match_ID"]+'" class="'+color_C+'" onclick="Bright(this.id,\''+dbs[i]["Match_Master"]+'vs'+dbs[i]["Match_Guest"]+'\');"><span title="'+dbs[i]["Match_Guest"]+'" onclick="javascript:setbet(\'篮球单式\',\'让球-'+(dbs[i]["Match_ShowType"]=="H" ? "主让" :"客让")+dbs[i]["Match_RGG"]+"-"+dbs[i]["Match_Guest"]+'\',\''+dbs[i]["Match_ID"]+'\',\'Match_Ao\',1,0,\''+dbs[i]["Match_Guest"]+'\');" >'+formatNumber(dbs[i]["Match_Ao"],2)+'</span></span>';
						
						onelayer=onelayer.replace("*RATIO_RH*",Ho);/*讓球賠率*/
						onelayer=onelayer.replace("*RATIO_RC*",Ao);
					}else{
						onelayer=onelayer.replace("*CON_RH*","");
						onelayer=onelayer.replace("*CON_RC*","");
						onelayer=onelayer.replace("*RATIO_RH*","");/*讓球賠率*/
						onelayer=onelayer.replace("*RATIO_RC*","");
					}
					//----------------------------------------------------------
					
					//-------------------------大小-----------------------------
					if(dbs[i]["Match_DxDpl"]>0 && dbs[i]["Match_DxXpl"]>0){
						var CON_OUH = dbs[i]["Match_DxGG1"].replace("O","");
						var CON_OUC = dbs[i]["Match_DxGG2"].replace("U","");
						onelayer=onelayer.replace("*CON_OUH*",CON_OUH);
						onelayer=onelayer.replace("*CON_OUC*",CON_OUC);
						onelayer=onelayer.replace("*TEXT_OUH*","大");
						onelayer=onelayer.replace("*TEXT_OUC*","小");
						var color_H = "bet_bg_color";
	                    var color_C = "bet_bg_color";
						if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
							color_H = pl_color(dbs[i]["Match_DxDpl"],data[i]["Match_DxDpl"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
							color_C = pl_color(dbs[i]["Match_DxXpl"],data[i]["Match_DxXpl"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
						}

						var DxDpl = '<span id="OUH'+dbs[i]["Match_ID"]+'" class="'+color_H+'" onclick="Bright(this.id,\''+dbs[i]["Match_Master"]+'vs'+dbs[i]["Match_Guest"]+'\');"><span title="大" onclick="javascript:setbet(\'篮球单式\',\'总分:大小-'+dbs[i]["Match_DxGG1"]+'\',\''+dbs[i]["Match_ID"]+'\',\'Match_DxDpl\',1,0,\''+dbs[i]["Match_DxGG1"]+'\');" >'+formatNumber(dbs[i]["Match_DxDpl"],2)+'</span></span>';
						var DxXpl = '<span id="OUC'+dbs[i]["Match_ID"]+'" class="'+color_C+'" onclick="Bright(this.id,\''+dbs[i]["Match_Master"]+'vs'+dbs[i]["Match_Guest"]+'\');"><span title="小" onclick="javascript:setbet(\'篮球单式\',\'总分:大小-'+dbs[i]["Match_DxGG2"]+'\',\''+dbs[i]["Match_ID"]+'\',\'Match_DxXpl\',1,0,\''+dbs[i]["Match_DxGG2"]+'\');">'+formatNumber(dbs[i]["Match_DxXpl"],2)+'</span></span>';
						onelayer=onelayer.replace("*RATIO_OUH*",DxDpl);/*大小賠率*/
						onelayer=onelayer.replace("*RATIO_OUC*",DxXpl);
					}else{
						onelayer=onelayer.replace("*CON_OUH*","");
						onelayer=onelayer.replace("*CON_OUC*","");
						onelayer=onelayer.replace("*TEXT_OUH*","");
						onelayer=onelayer.replace("*TEXT_OUC*","");

						onelayer=onelayer.replace("*RATIO_OUH*","");/*大小賠率*/
						onelayer=onelayer.replace("*RATIO_OUC*","");
					}
					//----------------------------------------------------------
					
					//-------------------------单双-----------------------------
					if(dbs[i]["Match_DsDpl"]>0 && dbs[i]["Match_DsSpl"]>0){
						onelayer=onelayer.replace("*TEXT_EOO*","单");
						onelayer=onelayer.replace("*TEXT_EOE*","双");
						var color_H = "bet_bg_color";
	                    var color_C = "bet_bg_color";
						if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
							color_H = pl_color(dbs[i]["Match_DsDpl"],data[i]["Match_DsDpl"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
							color_C = pl_color(dbs[i]["Match_DsSpl"],data[i]["Match_DsSpl"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
						}
						var EOO = '<span id="EOO'+dbs[i]["Match_ID"]+'" class="'+color_H+'" onclick="Bright(this.id,\''+dbs[i]["Match_Master"]+'vs'+dbs[i]["Match_Guest"]+'\');"><span title="单" onclick="javascript:setbet(\'篮球单式\',\'总分:单双-单\',\''+dbs[i]["Match_ID"]+'\',\'Match_DsDpl\',0,0,\'单\');">'+formatNumber(dbs[i]["Match_DsDpl"],2)+'</span></span>';
						var EOE = '<span id="EOE'+dbs[i]["Match_ID"]+'" class="'+color_C+'" onclick="Bright(this.id,\''+dbs[i]["Match_Master"]+'vs'+dbs[i]["Match_Guest"]+'\');"><span title="双" onclick="javascript:setbet(\'篮球单式\',\'总分:单双-双\',\''+dbs[i]["Match_ID"]+'\',\'Match_DsSpl\',0,0,\'双\');">'+formatNumber(dbs[i]["Match_DsSpl"],2)+'</span></span>';
						onelayer=onelayer.replace("*RATIO_EOO*",EOO);
  						onelayer=onelayer.replace("*RATIO_EOE*",EOE);
					}else{
						onelayer=onelayer.replace("*TEXT_EOO*","");
						onelayer=onelayer.replace("*TEXT_EOE*","");
						onelayer=onelayer.replace("*RATIO_EOO*","");
  						onelayer=onelayer.replace("*RATIO_EOE*","");
					}

					//----------------------------------------------------------
					//
					//-------------------------得分大小:主队-----------------------------
					if(dbs[i]["Match_DFzDpl"]>0 && dbs[i]["Match_DFzXpl"]>0){
						var CON_OUH = dbs[i]["Match_DFzDX"].replace("O","");
						var CON_OUC = dbs[i]["Match_DFzDX2"].replace("U","");
						onelayer=onelayer.replace("*CON_OUHO*",CON_OUH);
						onelayer=onelayer.replace("*CON_OUHU*",CON_OUC);
						onelayer=onelayer.replace("*TEXT_OUHO*","大");
						onelayer=onelayer.replace("*TEXT_OUHU*","小");
						var color_H = "bet_bg_color";
	                    var color_C = "bet_bg_color";
						if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
							color_H = pl_color(dbs[i]["Match_DFzDpl"],data[i]["Match_DFzDpl"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
							color_C = pl_color(dbs[i]["Match_DFzXpl"],data[i]["Match_DFzXpl"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
						}

						var DxDpl = '<span id="OUHO'+dbs[i]["Match_ID"]+'" class="'+color_H+'" onclick="Bright(this.id,\''+dbs[i]["Match_Master"]+'vs'+dbs[i]["Match_Guest"]+'\');"><span title="大" onclick="javascript:setbet(\'篮球单式\',\'球队得分:'+dbs[i]["Match_Master"]+'-大 / 小-'+dbs[i]["Match_DFzDpl"]+'\',\''+dbs[i]["Match_ID"]+'\',\'Match_DFzDpl\',1,0,\''+dbs[i]["Match_DFzDX"]+'\');" >'+formatNumber(dbs[i]["Match_DFzDpl"],2)+'</span></span>';
						var DxXpl = '<span id="OUHU'+dbs[i]["Match_ID"]+'" class="'+color_C+'" onclick="Bright(this.id,\''+dbs[i]["Match_Master"]+'vs'+dbs[i]["Match_Guest"]+'\');"><span title="小" onclick="javascript:setbet(\'篮球单式\',\'球队得分:'+dbs[i]["Match_Master"]+'-大 / 小-'+dbs[i]["Match_DFzXpl"]+'\',\''+dbs[i]["Match_ID"]+'\',\'Match_DFzXpl\',1,0,\''+dbs[i]["Match_DFzDX2"]+'\');">'+formatNumber(dbs[i]["Match_DFzXpl"],2)+'</span></span>';
						onelayer=onelayer.replace("*RATIO_OUHO*",DxDpl);/*大小賠率*/
						onelayer=onelayer.replace("*RATIO_OUHU*",DxXpl);
					}else{
						onelayer=onelayer.replace("*CON_OUHO*","");
						onelayer=onelayer.replace("*CON_OUHU*","");
						onelayer=onelayer.replace("*TEXT_OUHO*","");
						onelayer=onelayer.replace("*TEXT_OUHU*","");

						onelayer=onelayer.replace("*RATIO_OUHO*","");/*大小賠率*/
						onelayer=onelayer.replace("*RATIO_OUHU*","");
					}
					//----------------------------------------------------------
					
					
					//-------------------------得分大小:客队-----------------------------
					if(dbs[i]["Match_DFkDpl"]>0 && dbs[i]["Match_DFkXpl"]>0){
						var CON_OUH = dbs[i]["Match_DFkDX"].replace("O","");
						var CON_OUC = dbs[i]["Match_DFkDX2"].replace("U","");
						onelayer=onelayer.replace("*CON_OUCO*",CON_OUH);
						onelayer=onelayer.replace("*CON_OUCU*",CON_OUC);
						onelayer=onelayer.replace("*TEXT_OUCO*","大");
						onelayer=onelayer.replace("*TEXT_OUCU*","小");
						var color_H = "bet_bg_color";
	                    var color_C = "bet_bg_color";
						if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
							color_H = pl_color(dbs[i]["Match_DFkDpl"],data[i]["Match_DFkDpl"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
							color_C = pl_color(dbs[i]["Match_DFkXpl"],data[i]["Match_DFkXpl"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
						}

						var DxDpl = '<span id="OUHO'+dbs[i]["Match_ID"]+'" class="'+color_H+'" onclick="Bright(this.id,\''+dbs[i]["Match_Master"]+'vs'+dbs[i]["Match_Guest"]+'\');"><span title="大" onclick="javascript:setbet(\'篮球单式\',\'球队得分:'+dbs[i]["Match_Guest"]+'-大 / 小-'+dbs[i]["Match_DFkDpl"]+'\',\''+dbs[i]["Match_ID"]+'\',\'Match_DFkDpl\',1,0,\''+dbs[i]["Match_DFkDX"]+'\');" >'+formatNumber(dbs[i]["Match_DFkDpl"],2)+'</span></span>';
						var DxXpl = '<span id="OUHU'+dbs[i]["Match_ID"]+'" class="'+color_C+'" onclick="Bright(this.id,\''+dbs[i]["Match_Master"]+'vs'+dbs[i]["Match_Guest"]+'\');"><span title="小" onclick="javascript:setbet(\'篮球单式\',\'球队得分:'+dbs[i]["Match_Guest"]+'-大 / 小-'+dbs[i]["Match_DFkXpl"]+'\',\''+dbs[i]["Match_ID"]+'\',\'Match_DFkXpl\',1,0,\''+dbs[i]["Match_DFkDX2"]+'\');">'+formatNumber(dbs[i]["Match_DFkXpl"],2)+'</span></span>';
						onelayer=onelayer.replace("*RATIO_OUCO*",DxDpl);/*大小賠率*/
						onelayer=onelayer.replace("*RATIO_OUCU*",DxXpl);
					}else{
						onelayer=onelayer.replace("*CON_OUCO*","");
						onelayer=onelayer.replace("*CON_OUCU*","");
						onelayer=onelayer.replace("*TEXT_OUCO*","");
						onelayer=onelayer.replace("*TEXT_OUCU*","");

						onelayer=onelayer.replace("*RATIO_OUCO*","");/*大小賠率*/
						onelayer=onelayer.replace("*RATIO_OUCU*","");
					}
					//----------------------------------------------------------
					//我的最愛
					var css = '';
					var dates = dbs[i]["Match_Date"]
					var _id = dbs[i]["Match_Date"]+dbs[i]["Match_MasterID"];
					if($.inArray(dbs[i]["ID"].toString(), top.myLove[top.w_type][gtype])>=0){
						css = 'style="display:;" class="bet_game_star_on" title="删除收藏" onclick="chkDelshowLoveI(this.id,\''+dbs[i]["ID"]+'\')" ';
						_id = _id+'_off';
					}else{
						css = 'style="display: none;" class="bet_game_star_out" title="赛事收藏" onclick="addShowLoveI(this.id,\''+dbs[i]["ID"]+'\')" ';
					}
					onelayer=onelayer.replace(/\*MYLOVE_ID\*/gi,"love"+_id);
					onelayer=onelayer.replace(/\*MYLOVE_ID_none\*/gi,"love"+_id+"_none");
					onelayer=onelayer.replace(/\*MYLOVE_CSS\*/gi,css);
					var show_type=_id.split("_");
					onelayer=onelayer.replace(/\*MYLOVE_CSS_none\*/gi,show_type[1]=="off"?"style='display: none;'":"");

					dataAll = dataAll+onelayer;
				}

				
				
	         }
	         showtableData = showtableData.replace("*showDataTR*",dataAll);

		}
		chkOKshowLoveI();//赛事收藏

		//匹配已选赔率底色
		showtableData = pl_bg_color(showtableData);
		
		$("#showtable").html(showtableData);

		//取消背景颜色
		setTimeout(function(){
			pl_color_off();	
		},3000);
	})

}

