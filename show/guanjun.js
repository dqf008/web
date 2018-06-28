// JavaScript Document
// JavaScript Document
var dbs  = null;
var data = null;
var window_hight	=	0; //窗口高度
var window_lsm		=	0; //窗口联赛名
var blurHash = new Object();
var ptype_arr=new Array();

function loaded(league,thispage,p){
	var league = encodeURI(league);

	$.getJSON("guanjun_data.php?leaguename="+league+"&CurrPage="+thispage+"&callback=?",function(json){
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
		
		

		var showtableData = document.getElementById('showlayers').textContent;
		
		if(dbs == null){
			var NoDataTR = document.getElementById('NoDataTR').textContent;
			showtableData = showtableData.replace("*ShowGame*",NoDataTR);
		}else{
			var lsm = '';
			var dataAll = "";
			for(var i=0; i<dbs.length; i++){
				var onelayer = document.getElementById('glist').textContent;
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

				layers=layers.replace("*TEAM*",teamdata);

		layers=layers.replace(/\*GID\*/g,GameFT[gno][0]);/*gid*/
		layers=layers.replace("*TIME*",(GameFT[gno][1]));/*時間*/
		layers=layers.replace(/\*LEG\*/g,GameFT[gno][2]);/*聯盟*/


			}

			showtableData = showtableData.replace("*ShowGame*",onelayer);
		}


		//匹配已选赔率底色
		showtableData = pl_bg_color(showtableData);

		$("#showtable").html(showtableData);

		//取消背景颜色
		setTimeout(function(){
			pl_color_off();	
		},3000);
	})
}

