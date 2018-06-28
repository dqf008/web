// JavaScript Document
var dbs  = null;
var data = null;
var window_hight	=	0; //窗口高度
var window_lsm		=	0; //窗口联赛名
var blurHash = new Object();
var ptype_arr=new Array();
blurHash["pg_txt"] = "N";
var gtype = "bd";
var sort = 'T';//默认排序方式 T 时间  C联盟
var sel_gd = 'ALL';

var DateAry = new Array();
DateAry = top.DateAry;

function loaded(league,thispage,p){
	var league = encodeURI(league);
	$("#sel_sort").click(function(){
		divOnBlur(document.getElementById("show_sort"),document.getElementById("sel_sort"));
	});

	initDivBlur_PFunction(document.getElementById("show_sort"),document.getElementById("sel_sort"));
	showDateSel_FT();
	
	$.getJSON("ftz_shangbanbodan_data.php?leaguename="+league+"&CurrPage="+thispage+"&sort="+sort+"&sel_gd="+sel_gd+"&callback=?",function(json){
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
				
				onelayer=onelayer.replace("*TEAM_H*",TeamName(dbs[i]["Match_Master"]));
				onelayer=onelayer.replace("*TEAM_C*",TeamName(dbs[i]["Match_Guest"]));

				//全場
				//波膽
				//1:0
				if(dbs[i]["Match_Bd10"] !=null && dbs[i]["Match_Bd10"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Bd10"],data[i]["Match_Bd10"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="PDH1C0'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="1:0" onclick="javascript:setbet(\'足球早盘上半场\',\'波胆-1:0\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Hr_Bd10\',0,0,\''+dbs[i]["Match_Master"]+'\');">'+dbs[i]["Match_Bd10"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_H1C0*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_H1C0*","");
				}

				//0:1
				if(dbs[i]["Match_Bdg10"] !=null && dbs[i]["Match_Bdg10"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Bdg10"],data[i]["Match_Bdg10"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="PDH0C1'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="0:1" onclick="javascript:setbet(\'足球早盘上半场\',\'波胆-0:1\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Hr_Bdg10\',0,0,\''+dbs[i]["Match_Guest"]+'\');">'+dbs[i]["Match_Bdg10"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_H0C1*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_H0C1*","");
				}

				//2:0
				if(dbs[i]["Match_Bd20"] !=null && dbs[i]["Match_Bd20"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Bd20"],data[i]["Match_Bd20"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="PDH2C0'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="2:0" onclick="javascript:setbet(\'足球早盘上半场\',\'波胆-2:0\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Hr_Bd20\',0,0,\''+dbs[i]["Match_Master"]+'\');">'+dbs[i]["Match_Bd20"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_H2C0*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_H2C0*","");
				}

				//0:2
				if(dbs[i]["Match_Bdg20"] !=null && dbs[i]["Match_Bdg20"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Bdg20"],data[i]["Match_Bdg20"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="PDH0C2'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="0:2" onclick="javascript:setbet(\'足球早盘上半场\',\'波胆-0:2\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Hr_Bdg20\',0,0,\''+dbs[i]["Match_Guest"]+'\');">'+dbs[i]["Match_Bdg20"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_H0C2*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_H0C2*","");
				}


				//2:1
				if(dbs[i]["Match_Bd21"] !=null && dbs[i]["Match_Bd21"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Bd21"],data[i]["Match_Bd21"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="PDH2C1'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="2:1" onclick="javascript:setbet(\'足球早盘上半场\',\'波胆-2:1\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Hr_Bd21\',0,0,\''+dbs[i]["Match_Master"]+'\');">'+dbs[i]["Match_Bd21"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_H2C1*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_H2C1*","");
				}

				//1:2
				if(dbs[i]["Match_Bdg21"] !=null && dbs[i]["Match_Bdg21"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Bdg21"],data[i]["Match_Bdg21"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="PDH1C2'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="1:2" onclick="javascript:setbet(\'足球早盘上半场\',\'波胆-1:2\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Hr_Bdg21\',0,0,\''+dbs[i]["Match_Guest"]+'\');">'+dbs[i]["Match_Bdg21"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_H1C2*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_H1C2*","");
				}


				//3:0
				if(dbs[i]["Match_Bd30"] !=null && dbs[i]["Match_Bd30"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Bd21"],data[i]["Match_Bd21"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="PDH3C0'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="3:0" onclick="javascript:setbet(\'足球早盘上半场\',\'波胆-3:0\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Hr_Bd30\',0,0,\''+dbs[i]["Match_Master"]+'\');">'+dbs[i]["Match_Bd30"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_H3C0*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_H3C0*","");
				}

				//0:3
				if(dbs[i]["Match_Bdg30"] !=null && dbs[i]["Match_Bdg30"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Bdg30"],data[i]["Match_Bdg30"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="PDH0C3'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="0:3" onclick="javascript:setbet(\'足球早盘上半场\',\'波胆-0:3\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Hr_Bdg30\',0,0,\''+dbs[i]["Match_Guest"]+'\');">'+dbs[i]["Match_Bdg30"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_H0C3*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_H0C3*","");
				}

				//3:1
				if(dbs[i]["Match_Bd31"] !=null && dbs[i]["Match_Bd31"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Bd31"],data[i]["Match_Bd31"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="PDH3C1'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="3:1" onclick="javascript:setbet(\'足球早盘上半场\',\'波胆-3:1\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Hr_Bd31\',0,0,\''+dbs[i]["Match_Master"]+'\');">'+dbs[i]["Match_Bd31"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_H3C1*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_H3C1*","");
				}

				//1:3
				if(dbs[i]["Match_Bdg31"] !=null && dbs[i]["Match_Bdg31"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Bdg31"],data[i]["Match_Bdg31"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="PDH1C3'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="1:3" onclick="javascript:setbet(\'足球早盘上半场\',\'波胆-1:3\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Hr_Bdg31\',0,0,\''+dbs[i]["Match_Guest"]+'\');">'+dbs[i]["Match_Bdg31"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_H1C3*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_H1C3*","");
				}

				//3:2
				if(dbs[i]["Match_Bd32"] !=null && dbs[i]["Match_Bd32"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Bd32"],data[i]["Match_Bd32"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="PDH3C2'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="3:2" onclick="javascript:setbet(\'足球早盘上半场\',\'波胆-3:2\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Hr_Bd32\',0,0,\''+dbs[i]["Match_Master"]+'\');">'+dbs[i]["Match_Bd32"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_H3C2*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_H3C2*","");
				}

				//2:3
				if(dbs[i]["Match_Bdg32"] !=null && dbs[i]["Match_Bdg32"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Bdg32"],data[i]["Match_Bdg32"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="PDH2C3'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="2:3" onclick="javascript:setbet(\'足球早盘上半场\',\'波胆-2:3\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Hr_Bdg32\',0,0,\''+dbs[i]["Match_Guest"]+'\');">'+dbs[i]["Match_Bdg32"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_H2C3*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_H2C3*","");
				}


				


				//0:0
				if(dbs[i]["Match_Bd00"] !=null && dbs[i]["Match_Bd00"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Bd00"],data[i]["Match_Bd00"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="PDH0C0'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="0:0" onclick="javascript:setbet(\'足球早盘上半场\',\'波胆-0:0\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Hr_Bd00\',0,0,\'0:0\');">'+dbs[i]["Match_Bd00"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_H0C0*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_H0C0*","");
				}

				//1:1
				if(dbs[i]["Match_Bd11"] !=null && dbs[i]["Match_Bd11"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Bd11"],data[i]["Match_Bd11"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="PDH1C1'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="1:1" onclick="javascript:setbet(\'足球早盘上半场\',\'波胆-1:1\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Hr_Bd11\',0,0,\'1:1\');">'+dbs[i]["Match_Bd11"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_H1C1*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_H1C1*","");
				}

				//2:2
				if(dbs[i]["Match_Bd22"] !=null && dbs[i]["Match_Bd22"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Bd22"],data[i]["Match_Bd22"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="PDH2C2'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="2:2" onclick="javascript:setbet(\'足球早盘上半场\',\'波胆-2:2\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Hr_Bd22\',0,0,\'2:2\');">'+dbs[i]["Match_Bd22"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_H2C2*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_H2C2*","");
				}

				//3:3
				if(dbs[i]["Match_Bd33"] !=null && dbs[i]["Match_Bd33"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Bd33"],data[i]["Match_Bd33"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="PDH3C3'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="3:3" onclick="javascript:setbet(\'足球早盘上半场\',\'波胆-3:3\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Hr_Bd33\',0,0,\'3:3\');">'+dbs[i]["Match_Bd33"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_H3C3*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_H3C3*","");
				}

				
				//其他
				if(dbs[i]["Match_Bdup5"] !=null && dbs[i]["Match_Bdup5"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Bdup5"],data[i]["Match_Bdup5"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="PDOVH'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="其它比分" onclick="javascript:setbet(\'足球早盘上半场\',\'波胆-UP5\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Hr_Bdup5\',0,0,\'UP5\');">'+dbs[i]["Match_Bdup5"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_OVH*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_OVH*","");
				}


				dataAll = dataAll+onelayer;
			}

			showtableData = showtableData.replace("*showDataTR*",dataAll);
		}

		//匹配已选赔率底色
		showtableData = pl_bg_color(showtableData);
		
		$("#showtable").html(showtableData);

		//取消背景颜色
		setTimeout(function(){
			pl_color_off();	
		},3000);
	});
}
