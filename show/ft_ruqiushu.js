// JavaScript Document
var dbs  = null;
var data = null;
var window_hight	=	0; //窗口高度
var window_lsm		=	0; //窗口联赛名
var blurHash = new Object();
var ptype_arr=new Array();
blurHash["pg_txt"] = "N";
var gtype = "rqs";
var lives = 'N';//默认 我的收藏
var sort = 'T';//默认排序方式 T 时间  C联盟
var ids = "";

function loaded(league,thispage,p){
	var league = encodeURI(league);
	$("#sel_sort").click(function(){
		divOnBlur(document.getElementById("show_sort"),document.getElementById("sel_sort"));
	});

	initDivBlur_PFunction(document.getElementById("show_sort"),document.getElementById("sel_sort"));
	$.getJSON("ft_ruqiushu_data.php?leaguename="+league+"&CurrPage="+thispage+"&sort="+sort+"&callback=?",function(json){
		var pagecount	=	json.fy.p_page;
		var page		=	json.fy.page;
		var fenye		=	"";
		window_hight	=	json.dh;
		window_lsm		=	json.lsm;
		
		if(dbs !=null) {
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

				//單雙
				//0~1
				if(dbs[i]["Match_Total01Pl"] !=null && dbs[i]["Match_Total01Pl"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Total01Pl"],data[i]["Match_Total01Pl"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="TT01'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="0~1" onclick="javascript:setbet(\'足球单式\',\'入球数-0~1\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Total01Pl\',0,0,\'0~1\');">'+dbs[i]["Match_Total01Pl"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_T01*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_T01*","");
				}

				//2-3
				if(dbs[i]["Match_Total23Pl"] !=null && dbs[i]["Match_Total23Pl"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Total23Pl"],data[i]["Match_Total23Pl"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="TT23'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="2~3" onclick="javascript:setbet(\'足球单式\',\'入球数-2~3\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Total23Pl\',0,0,\'2~3\');">'+dbs[i]["Match_Total23Pl"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_T23*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_T23*","");
				}

				//4-6
				if(dbs[i]["Match_Total46Pl"] !=null && dbs[i]["Match_Total46Pl"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Total46Pl"],data[i]["Match_Total46Pl"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="TT46'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="4~6" onclick="javascript:setbet(\'足球单式\',\'入球数-4~6\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Total46Pl\',0,0,\'4~6\');">'+dbs[i]["Match_Total46Pl"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_T46*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_T46*","");
				}

				//7up
				if(dbs[i]["Match_Total7upPl"] !=null && dbs[i]["Match_Total7upPl"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Total7upPl"],data[i]["Match_Total7upPl"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="TOVER'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="7+" onclick="javascript:setbet(\'足球单式\',\'入球数-7UP\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Total7upPl\',0,0,\'7UP\');">'+dbs[i]["Match_Total7upPl"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_OVER*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_OVER*","");
				}

				//上半
				//0
				if(dbs[i]["Match_Total0Pl"] !=null && dbs[i]["Match_Total0Pl"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Total0Pl"],data[i]["Match_Total0Pl"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="HTHT0'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="0" onclick="javascript:setbet(\'足球上半场\',\'入球数-0\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Total0Pl\',0,0,\'0\');">'+dbs[i]["Match_Total0Pl"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_HT0*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_HT0*","");
				}

				//1
				if(dbs[i]["Match_Total1Pl"] !=null && dbs[i]["Match_Total1Pl"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Total1Pl"],data[i]["Match_Total1Pl"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="HTHT1'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="1" onclick="javascript:setbet(\'足球上半场\',\'入球数-1\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Total1Pl\',0,0,\'1\');">'+dbs[i]["Match_Total1Pl"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_HT1*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_HT1*","");
				}

				//2
				if(dbs[i]["Match_Total2Pl"] !=null && dbs[i]["Match_Total2Pl"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Total2Pl"],data[i]["Match_Total2Pl"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="HTHT2'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="2" onclick="javascript:setbet(\'足球上半场\',\'入球数-2\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Total2Pl\',0,0,\'2\');">'+dbs[i]["Match_Total2Pl"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_HT2*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_HT2*","");
				}

				//3up
				if(dbs[i]["Match_Total3upPl"] !=null && dbs[i]["Match_Total3upPl"]!="0"){
					var color = "bet_bg_color";
					if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
						color = pl_color(dbs[i]["Match_Total3upPl"],data[i]["Match_Total3upPl"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
					}
					var htm = '<span id="HTOV'+dbs[i]["Match_ID"]+'" class="'+color+'" onclick="Bright(this.id);"><span  title="3+" onclick="javascript:setbet(\'足球上半场\',\'入球数-3UP\',\'' + dbs[i]["Match_ID"] + '\',\'Match_Total3upPl\',0,0,\'3UP\');">'+dbs[i]["Match_Total3upPl"]+'</span></span>';
					onelayer=onelayer.replace("*RATIO_HTOV*",htm);
				}else{
					onelayer=onelayer.replace("*RATIO_HTOV*","");
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

