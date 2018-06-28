// JavaScript Document
var dbs  = null;
var data = null;
var window_hight	=	0; //窗口高度
var window_lsm		=	0; //窗口联赛名
function loaded(league,thispage,p){
	var league = encodeURI(league);
	$.getJSON("/show/ftz_ruqiushu_data.php?leaguename="+league+"&CurrPage="+thispage+"&wap=wap&callback=?",function(json){
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
				if(dbs[i]["Match_Bd10"] !="0" || dbs[i]["Match_Total01Pl"] !="0" || dbs[i]["Match_Total23Pl"] !="0" || dbs[i]["Match_Total46Pl"] !="0" || dbs[i]["Match_Total7upPl"] !="0"){
					if(lsm != dbs[i]["Match_Name"]){
						lsm = dbs[i]["Match_Name"];
						htmls += "<tr class=\"liansai\">";
						htmls += "<td colspan=\"4\" >";
						htmls += "<a href=\"javascript:void(0)\" title=\"选择 >> "+lsm+"\" onclick=\"javascript:choose_lsm('"+lsm+"');\">"+lsm+"</a>";
						htmls += "</td>";
						htmls += "</tr>";
					}
					
					
					htmls +="<tr class=\"wzjz eachmatch\">";
					htmls +="	<td width=\"20%\">"+dbs[i]["Match_Date"]+"</td>";
					htmls +="	<td width=\"35%\"><span>主队</span><br><span>"+dbs[i]["Match_Master"]+"</span></td>";
					htmls +="	<td width=\"35%\"><span>客队</span><br><span>"+dbs[i]["Match_Guest"]+"</span></td>";
					htmls +="	<td width=\"10%\"><span>和局</span></td>";
					htmls +="</tr>";
					htmls +="<tr class=\"wzjz\">";
					htmls +="	<td class=\"wzjz\"><span>全场-独赢</span></td>";
					htmls +="	<td>";
					htmls +="		<span class=\"odds\">";
					htmls +=			(dbs[i]["Match_BzM"] !=null && dbs[i]["Match_BzM"] !="0")?"<a href=\"javascript:void(0)\" title=\""+dbs[i]["Match_Master"]+"\" onclick=\"setbet('足球单式','独赢-"+ dbs[i]["Match_Master"] +"-独赢','" + dbs[i]["Match_ID"] + "','Match_BzM','0',0,'"+dbs[i]["Match_Master"]+"');\" style='"+(dbs[i]["Match_BzM"]!=data[i]["Match_BzM"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+formatNumber(dbs[i]["Match_BzM"],2)+"</a>":"";
					htmls +="		</span>";
					htmls +="	</td>";
					htmls +="	<td>";
					htmls +="		<span class=\"odds\">";
					htmls +=			(dbs[i]["Match_BzG"] !=null && dbs[i]["Match_BzG"] !="0")?"<a href=\"javascript:void(0)\" title=\""+dbs[i]["Match_Guest"]+"\" onclick=\"setbet('足球单式','独赢-"+ dbs[i]["Match_Guest"] +"-独赢','" + dbs[i]["Match_ID"] + "','Match_BzG','0',0,'"+dbs[i]["Match_Guest"]+"');\" style='"+(dbs[i]["Match_BzG"]!=data[i]["Match_BzG"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+formatNumber(dbs[i]["Match_BzG"],2)+"</a>":"";
					htmls +="		</span>";
					htmls +="	</td>";
					htmls +="	<td>";
					htmls +="		<span class=\"odds\">";
					htmls +=			(dbs[i]["Match_BzH"] !=null && dbs[i]["Match_BzH"] !="0")?"<a href=\"javascript:void(0)\" title=\"和局\" onclick=\"setbet('足球单式','独赢-和局','" + dbs[i]["Match_ID"] + "','Match_BzH','0',0,'和局');\" style='"+(dbs[i]["Match_BzH"]!=data[i]["Match_BzH"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+formatNumber(dbs[i]["Match_BzH"],2)+"</a>":"";
					htmls +="		</span>";
					htmls +="	</td>";
					htmls +="</tr>";
					htmls +="<tr class=\"wzjz\">";
					htmls +="	<td class=\"wzjz\"><span>0-1</span></td>";
					htmls +="	<td colspan=\"3\">";
					htmls +="		<span class=\"odds\">";
					htmls +=			(dbs[i]["Match_Total01Pl"] !=null && dbs[i]["Match_Total01Pl"] !="0")?"<a href=\"javascript:void(0)\" title=\"0~1\" onclick=\"setbet('足球单式','入球数-0~1','" + dbs[i]["Match_ID"] + "','Match_Total01Pl','0',0,'0~1');\" style='"+(dbs[i]["Match_Total01Pl"]!=data[i]["Match_Total01Pl"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFFF00":"")+"'>"+formatNumber(dbs[i]["Match_Total01Pl"],2)+"</a>":"";
					htmls +="		</span>";
					htmls +="	</td>";
					htmls +="</tr>";
					htmls +="<tr class=\"wzjz\">";
					htmls +="	<td class=\"wzjz\"><span>2-3</span></td>";
					htmls +="	<td colspan=\"3\">";
					htmls +="		<span class=\"odds\">";
					htmls +=			(dbs[i]["Match_Total23Pl"] !=null && dbs[i]["Match_Total23Pl"] !="0")?"<a href=\"javascript:void(0)\" title=\"2~3\" onclick=\"setbet('足球单式','入球数-2~3','" + dbs[i]["Match_ID"] + "','Match_Total23Pl','0',0,'2~3');\" style='"+(dbs[i]["Match_Total23Pl"]!=data[i]["Match_Total23Pl"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFFF00":"")+"'>"+formatNumber(dbs[i]["Match_Total23Pl"],2)+"</a>":"";
					htmls +="		</span>";
					htmls +="	</td>";
					htmls +="</tr>";
					htmls +="<tr class=\"wzjz\">";
					htmls +="	<td class=\"wzjz\"><span>4-6</span></td>";
					htmls +="	<td colspan=\"3\">";
					htmls +="		<span class=\"odds\">";
					htmls +=			(dbs[i]["Match_Total46Pl"] !=null && dbs[i]["Match_Total46Pl"] !="0")?"<a href=\"javascript:void(0)\" title=\"4~6\" onclick=\"setbet('足球单式','入球数-4~6','" + dbs[i]["Match_ID"] + "','Match_Total46Pl','0',0,'4~6');\" style='"+(dbs[i]["Match_Total46Pl"]!=data[i]["Match_Total46Pl"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFFF00":"")+"'>"+formatNumber(dbs[i]["Match_Total46Pl"],2)+"</a>":"";
					htmls +="		</span>";
					htmls +="	</td>";
					htmls +="</tr>";
					htmls +="<tr class=\"wzjz\">";
					htmls +="	<td class=\"wzjz\"><span>7或以上</span></td>";
					htmls +="	<td colspan=\"3\">";
					htmls +="		<span class=\"odds\">";
					htmls +=			(dbs[i]["Match_Total7upPl"] !=null && dbs[i]["Match_Total7upPl"] !="0")?"<a href=\"javascript:void(0)\" title=\"7以上\" onclick=\"setbet('足球单式','入球数-7UP','" + dbs[i]["Match_ID"] + "','Match_Total7upPl','0',0,'7UP');\" style='"+(dbs[i]["Match_Total7upPl"]!=data[i]["Match_Total7upPl"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFFF00":"")+"'>"+formatNumber(dbs[i]["Match_Total7upPl"],2)+"</a>":"";
					htmls +="		</span>";
					htmls +="	</td>";
					htmls +="</tr>";					
				}
			}

			htmls+="</tbody></table>";
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
