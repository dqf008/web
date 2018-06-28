// JavaScript Document
var dbs  = null;
var data = null;
var window_hight	=	0; //窗口高度
var window_lsm		=	0; //窗口联赛名
function loaded(league,thispage,p){
	var league = encodeURI(league);
	$.getJSON("/show/guanjun_data.php?leaguename="+league+"&CurrPage="+thispage+"&wap=wap&callback=?",function(json){
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
			$("#nomatch").css("display","");
			$("#loading").css("display","none");
			$("#matchpage").css("display","none");
			$("#showsaishi").css("display","none");
			
		}else{
			//构建分页按钮  <a href="javascript:NumPage(0);" class="ui-link">1</a>
			for(var i=0; i<pagecount; i++){
				if(i != page){
					fenye+="<a href='javascript:NumPage(" + i + ");' class=\"ui-link\">" + (i+1) + "</a>&nbsp;&nbsp;";
				}else{
					fenye+="<a href='javascript:NumPage(" + i + ");' class=\"ui-link\"><font color=#000>" + (i+1) + "</font></a>&nbsp;&nbsp;";
				}
			}
			$("#page_a").html(fenye);
			//联赛
			var lsmArray=window_lsm.split('|');
			$("#lsm").html("");
			lsmlist ="<option value=\"\">选择联赛</option>";
			for(var i=0; i<lsmArray.length; i++){	
				var lsm = decodeURI(lsmArray[i]);
				if(decodeURI(league)==lsm){
					lsmlist +="<option value=\""+lsm+"\" selected = \"selected\" >"+lsm+"</option>";
				}else{
					lsmlist +="<option value=\""+lsm+"\" >"+lsm+"</option>";
				}
			}
			$("#lsm").html(lsmlist);
			//赛事
			var htmls="<table border=\"0\" cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"#ACACAC\" class=\"box\"><tbody>";
			var lsm = "";
			for(var i=0; i<dbs.length; i++){
				if(lsm != dbs[i]["x_title"]){
					lsm = dbs[i]["x_title"];
					htmls+="<tr><th colspan='2' class='liansai_g'><span>"+dbs[i]["Match_Date"]+"</span><a href=\"javascript:void(0)\" title='选择 >> "+lsm+"' onclick=\"javascript:check_one('"+lsm+"');\">"+lsm+"</a></th></tr>";
				}
				htmls+="<tr><td colspan='2' class='saishi_g'>"+dbs[i]["Match_Name"]+"</td></tr>";
					var team_name	=	dbs[i]["team_name"].split(",");
					var point		=	dbs[i]["point"].split(",");
					var tid			=	dbs[i]["tid"].split(",");
					var point2		=	data[i]["point"].split(",");
					var tid2		=	data[i]["tid"].split(",");
					var css_bottom	=	'';
					for(var ss=0; ss<team_name.length-1; ss=ss+2){
						if(point[ss] != "0" && point[ss] != ""){
							htmls+="<tr>"
							htmls+="<td class='xiangmu_g'><span><a href=\"javascript:void(0);\" title=\""+team_name[ss]+"\" onclick=\"setbet('"+dbs[i]["Match_ID"]+"','"+tid[ss]+"')\" >"+formatNumber(point[ss],2)+"</a></span>"+team_name[ss]+"</td>"
							htmls+="<td class='xiangmu_g'><span><a href=\"javascript:void(0);\" title=\""+team_name[ss+1]+"\" onclick=\"setbet('"+dbs[i]["Match_ID"]+"','"+tid[ss+1]+"')\" >"+formatNumber(point[ss+1],2)+"</a></span>"+team_name[ss+1]+"</td>"
							htmls+="</tr>"
						}
					}
			}

			htmls +="</tbody></table>";
			if(dbs.length<=0){
				$("#nomatch").css("display","");
				$("#loading").css("display","none");
				$("#matchpage").css("display","none");
				$("#showsaishi").css("display","none");
			}else{
				$("#nomatch").css("display","none");
				$("#loading").css("display","none");
				$("#matchpage").css("display","");
				$("#showsaishi").css("display","");
				$("#showsaishi").html(htmls);
			}
		}
	})
}
