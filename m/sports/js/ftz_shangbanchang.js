// JavaScript Document
var dbs  = null;
var data = null;
var window_hight	=	0; //窗口高度
var window_lsm		=	0; //窗口联赛名
function loaded(league,thispage,p){
	var league = encodeURI(league);
	$.getJSON("/show/ftz_shangbanchang_data.php?leaguename="+league+"&CurrPage="+thispage+"&wap=wap&callback=?",function(json){
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
				if(dbs[i]["Match_Bmdy"]!="0" || dbs[i]["Match_BHo"]!="0" || dbs[i]["Match_Bdpl"]!="0"){
					if(lsm != dbs[i]["Match_Name"]){
						lsm = dbs[i]["Match_Name"];
						htmls += "<tr class=\"liansai\">";
						htmls += "<td colspan=\"5\" >";
						htmls += "<a href=\"javascript:void(0)\" title=\"选择 >> "+lsm+"\" onclick=\"javascript:choose_lsm('"+lsm+"');\">"+lsm+"</a>";
						htmls += "</td>";
						htmls += "</tr>";
					}
					
					htmls+="<tr class=\"wzjz eachmatch\" >";
					htmls+="	<td colspan=\"2\" width=\"20%\">"+dbs[i]["Match_Date"]+"</td>";
					htmls+="	<td width=\"35%\"><span>主队</span><br/><span>"+dbs[i]["Match_Master"]+"-[上半]</span></td>";
					htmls+="	<td width=\"35%\"><span>客队</span><br/><span>"+dbs[i]["Match_Guest"]+"-[上半]</span></td>";
					htmls+="	<td width=\"10%\"><span>和局</span></td>";
					htmls+="</tr>";
					
					htmls+="<tr class=\"wzjz\" >";
					htmls+="	<td rowspan=\"3\" class=\"wzjz\">半场</td>";
					htmls+="	<td class=\"wzjz\" ><span>独赢</span></td>";
					htmls+="	<td>";
					htmls+="		<span class=\"odds\">";
					htmls+=				(dbs[i]["Match_Bmdy"] !=null?"<a href=\"javascript:void(0)\" title=\""+dbs[i]["Match_Master"]+"\" onclick=\"setbet('足球上半场','上半场独赢-"+ dbs[i]["Match_Master"] +"-独赢','" + dbs[i]["Match_ID"] + "','Match_Bmdy','0','0','"+dbs[i]["Match_Master"]+"-[上半]');\" style='"+(dbs[i]["Match_Bmdy"]!=data[i]["Match_Bmdy"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFFF00":"")+"'>"+(dbs[i]["Match_Bmdy"]!="0"?formatNumber(dbs[i]["Match_Bmdy"],2):"")+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="	<td>";
					htmls+="		<span class=\"odds\">";
					htmls+=				(dbs[i]["Match_Bgdy2"] !=null?"<a href=\"javascript:void(0)\" title=\""+dbs[i]["Match_Guest"]+"\" onclick=\"setbet('足球上半场','上半场独赢-"+ dbs[i]["Match_Guest"] +"-独赢','" + dbs[i]["Match_ID"] + "','Match_Bgdy','0','0','"+dbs[i]["Match_Guest"]+"-[上半]');\" style='"+(dbs[i]["Match_Bgdy2"]!=data[i]["Match_Bgdy2"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFFF00":"")+"'>"+(dbs[i]["Match_Bgdy2"]!="0"?formatNumber(dbs[i]["Match_Bgdy2"],2):"")+"</a>":"")
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="	<td>";
					htmls+="		<span class=\"odds\">";
					htmls+=				(dbs[i]["Match_Bhdy2"] !=null?((dbs[i]["Match_Bhdy2"]-0.05)>0 ?"<a href=\"javascript:void(0)\"  title=\"和局\" onclick=\"setbet('足球上半场','上半场独赢-和局','" + dbs[i]["Match_ID"] + "','Match_Bhdy','0','0','和局');\" style='"+(dbs[i]["Match_Bhdy2"]!=data[i]["Match_Bhdy2"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFFF00":"")+"'>"+(dbs[i]["Match_Bhdy2"]!="0"?formatNumber(dbs[i]["Match_Bhdy2"],2):"")+"</a>":""):"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="</tr>";
					
					htmls+="<tr  class=\"wzjz\" >";
					htmls+="	<td class=\"wzjz\" ><span>让球</span></td>";
					htmls+="	<td>";
					htmls+="		<span class=\"pankou\">"+((dbs[i]["Match_Hr_ShowType"] =="H" && dbs[i]["Match_BHo"] !=0)?dbs[i]["Match_BRpk"]:"")+"</span>";
					htmls+="		<span class=\"odds\">";
					htmls+=				(dbs[i]["Match_BHo"] !=null?"<a href=\"javascript:void(0)\" title=\""+dbs[i]["Match_Master"]+"\" onclick=\"setbet('足球上半场','上半场让球-"+(dbs[i]["Match_Hr_ShowType"] =="H"?"主让":"客让")+dbs[i]["Match_BRpk"]+"-"+dbs[i]["Match_Master"] + "','" + dbs[i]["Match_ID"] + "','Match_BHo','1','0','"+dbs[i]["Match_Master"]+"-[上半]'); \"style='"+(dbs[i]["Match_BHo"]!=data[i]["Match_BHo"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFFF00":"")+"'>"+(dbs[i]["Match_BHo"]!="0"?formatNumber(dbs[i]["Match_BHo"],2):"")+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="	<td>";
					htmls+="		<span class=\"pankou\">"+((dbs[i]["Match_Hr_ShowType"] =="C" && dbs[i]["Match_BAo"] !="0")?dbs[i]["Match_BRpk"]:"")+"</span>";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_BAo"] !=null?"<a href=\"javascript:void(0)\" title=\""+dbs[i]["Match_Guest"]+"\" onclick=\"setbet('足球上半场','上半场让球-"+(dbs[i]["Match_Hr_ShowType"] =="H"?"主让":"客让")+dbs[i]["Match_BRpk"]+"-"+dbs[i]["Match_Guest"] + "','" + dbs[i]["Match_ID"] + "','Match_BAo','1','0','"+dbs[i]["Match_Guest"]+"-[上半]');\" style='"+(dbs[i]["Match_BAo"]!=data[i]["Match_BAo"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFFF00":"")+"'>"+(dbs[i]["Match_BAo"]!="0"?formatNumber(dbs[i]["Match_BAo"],2):"")+"</a>":""));
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="	<td>";
					htmls+="		<span></span>";
					htmls+="	</td>";
					htmls+="</tr>";
					
					htmls+="<tr class=\"wzjz\" >";
					htmls+="	<td class=\"wzjz\" ><span>大小</span></td>";
					htmls+="	<td>";
					htmls+="		<span class=\"pankou\">"+((dbs[i]["Match_Bdxpk1"]!="O")?dbs[i]["Match_Bdxpk1"].replace("@",""):"")+"</span>";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bdpl"] !=null?"<a href=\"javascript:void(0)\" title=\"大\" onclick=\"setbet('足球上半场','上半场大小-"+dbs[i]["Match_Bdxpk1"]+"','" + dbs[i]["Match_ID"] + "','Match_Bdpl','1','0','"+dbs[i]["Match_Bdxpk1"].replace("@","")+"');\" style='"+(dbs[i]["Match_Bdpl"]!=data[i]["Match_Bdpl"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFFF00":"")+"'>"+(dbs[i]["Match_Bdpl"]!="0"?formatNumber(dbs[i]["Match_Bdpl"],2):"")+"</a>":""));
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="	<td>";
					htmls+="		<span class=\"pankou\">"+((dbs[i]["Match_Bdxpk2"]!="U")?dbs[i]["Match_Bdxpk2"].replace("@",""):"")+"</span>";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bxpl"] !=null?"<a href=\"javascript:void(0)\" title=\"小\" onclick=\"setbet('足球上半场','上半场大小-"+dbs[i]["Match_Bdxpk2"]+"','" + dbs[i]["Match_ID"] + "','Match_Bxpl','1','0','"+dbs[i]["Match_Bdxpk2"].replace("@","")+"');\" style='"+(dbs[i]["Match_Bxpl"]!=data[i]["Match_Bxpl"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFFF00":"")+"'>"+(dbs[i]["Match_Bxpl"]!="0"?formatNumber(dbs[i]["Match_Bxpl"],2):"")+"</a>":""));
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="	<td>";
					htmls+="		<span></span>";
					htmls+="	</td>";
					htmls+="</tr>";
					
					
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
