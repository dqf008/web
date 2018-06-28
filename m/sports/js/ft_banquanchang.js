// JavaScript Document
var dbs  = null;
var data = null;
var window_hight	=	0; //窗口高度
var window_lsm		=	0; //窗口联赛名
function loaded(league,thispage,p){
	var league = encodeURI(league);
	$.getJSON("/show/ft_banquanchang_data.php?leaguename="+league+"&CurrPage="+thispage+"&wap=wap&callback=?",function(json){
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
				if(dbs[i]["Match_BqMM"]!="0" || dbs[i]["Match_BqMH"]!="0" || dbs[i]["Match_BqMG"]!="0" || dbs[i]["Match_BqHM"]!="0" || dbs[i]["Match_BqHH"]!="0" || dbs[i]["Match_BqHG"]!="0" || dbs[i]["Match_BqGM"]!="0" || dbs[i]["Match_BqGH"]!="0" || dbs[i]["Match_BqGG"]!="0"){
					if(lsm != dbs[i]["Match_Name"]){
						lsm = dbs[i]["Match_Name"];
						htmls += "<tr class=\"liansai\">";
						htmls += "<td colspan=\"5\" >";
						htmls += "<a href=\"javascript:void(0)\" title=\"选择 >> "+lsm+"\" onclick=\"javascript:choose_lsm('"+lsm+"');\">"+lsm+"</a>";
						htmls += "</td>";
						htmls += "</tr>";
					}
					
					htmls +="<tr class=\"wzjz eachmatch\">";
					htmls +="	<td width=\"20%\">"+dbs[i]["Match_Date"]+"</td>";
					htmls +="	<td width=\"40%\"><span>主队</span><br><span>"+dbs[i]["Match_Master"]+"</span></td>";
					htmls +="	<td width=\"40%\"><span>客队</span><br><span>"+dbs[i]["Match_Guest"]+"</span></td>";
					htmls +="</tr>";
					htmls +="<tr class=\"wzjz\">";
					htmls +="	<td class=\"wzjz\"><span>主/主</span></td>";
					htmls +="	<td colspan=\"2\">";
					htmls +="		<span class=\"odds\">";
					htmls +=			dbs[i]["Match_BqMM"] !=null?"<a href=\"javascript:void(0)\" title=\"主/主\" onclick=\"setbet('足球单式','半全场-主/主','" + dbs[i]["Match_ID"] + "','Match_BqMM','0','0','主/主');\" style='"+(dbs[i]["Match_BqMM"]!=data[i]["Match_BqMM"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFFF00":"")+"'>"+(dbs[i]["Match_BqMM"]!="0"?dbs[i]["Match_BqMM"]:"")+"</a>":"";
					htmls +="		</span>";
					htmls +="	</td>";
					htmls +="</tr>";
					htmls +="<tr class=\"wzjz\">";
					htmls +="	<td class=\"wzjz\"><span>主/和</span></td>";
					htmls +="	<td colspan=\"2\">";
					htmls +="		<span class=\"odds\">";
					htmls +=			dbs[i]["Match_BqMH"] !=null?"<a href=\"javascript:void(0)\" title=\"主/和\" onclick=\"setbet('足球单式','半全场-主/和','" + dbs[i]["Match_ID"] + "','Match_BqMH','0','0','主/和');\" style='"+(dbs[i]["Match_BqMH"]!=data[i]["Match_BqMH"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFFF00":"")+"'>"+(dbs[i]["Match_BqMH"]!="0"?dbs[i]["Match_BqMH"]:"")+"</a>":"";
					htmls +="		</span>";
					htmls +="	</td>";
					htmls +="</tr>";
					htmls +="<tr class=\"wzjz\">";
					htmls +="	<td class=\"wzjz\"><span>主/客</span></td>";
					htmls +="	<td colspan=\"2\">";
					htmls +="		<span class=\"odds\">";
					htmls +=			dbs[i]["Match_BqMG"] !=null?"<a href=\"javascript:void(0)\" title=\"主/客\" onclick=\"setbet('足球单式','半全场-主/客','" + dbs[i]["Match_ID"] + "','Match_BqMG','0','0','主/客');\" style='"+(dbs[i]["Match_BqMG"]!=data[i]["Match_BqMG"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFFF00":"")+"'>"+(dbs[i]["Match_BqMG"]!="0"?dbs[i]["Match_BqMG"]:"")+"</a>":"";
					htmls +="		</span>";
					htmls +="	</td>";
					htmls +="</tr>";
					htmls +="<tr class=\"wzjz\">";
					htmls +="	<td class=\"wzjz\"><span>和/主</span></td>";
					htmls +="	<td colspan=\"2\">";
					htmls +="		<span class=\"odds\">";
					htmls +=			dbs[i]["Match_BqHM"] !=null?"<a href=\"javascript:void(0)\" title=\"和/主\" onclick=\"setbet('足球单式','半全场-和/主','" + dbs[i]["Match_ID"] + "','Match_BqHM','0','0','和/主');\" style='"+(dbs[i]["Match_BqHM"]!=data[i]["Match_BqHM"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFFF00":"")+"'>"+(dbs[i]["Match_BqHM"]!="0"?dbs[i]["Match_BqHM"]:"")+"</a>":"";
					htmls +="		</span>";
					htmls +="	</td>";
					htmls +="</tr>";
					htmls +="<tr class=\"wzjz\">";
					htmls +="	<td class=\"wzjz\"><span>和/和</span></td>";
					htmls +="	<td colspan=\"2\">";
					htmls +="		<span class=\"odds\">";
					htmls +=			dbs[i]["Match_BqHH"] !=null?"<a href=\"javascript:void(0)\" title=\"和/和\" onclick=\"setbet('足球单式','半全场-和/和','" + dbs[i]["Match_ID"] + "','Match_BqHH','0','0','和/和');\" style='"+(dbs[i]["Match_BqHH"]!=data[i]["Match_BqHH"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFFF00":"")+"'>"+(dbs[i]["Match_BqHH"]!="0"?dbs[i]["Match_BqHH"]:"")+"</a>":"";
					htmls +="		</span>";
					htmls +="	</td>";
					htmls +="</tr>";
					htmls +="<tr class=\"wzjz\">";
					htmls +="	<td class=\"wzjz\"><span>和/客</span></td>";
					htmls +="	<td colspan=\"2\">";
					htmls +="		<span class=\"odds\">";
					htmls +=			dbs[i]["Match_BqHG"] !=null?"<a href=\"javascript:void(0)\" title=\"和/客\" onclick=\"setbet('足球单式','半全场-和/客','" + dbs[i]["Match_ID"] + "','Match_BqHG','0','0','和/客');\" style='"+(dbs[i]["Match_BqHG"]!=data[i]["Match_BqHG"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFFF00":"")+"'>"+(dbs[i]["Match_BqHG"]!="0"?dbs[i]["Match_BqHG"]:"")+"</a>":"";
					htmls +="		</span>";
					htmls +="	</td>";
					htmls +="</tr>";
					htmls +="<tr class=\"wzjz\">";
					htmls +="	<td class=\"wzjz\"><span>客/主</span></td>";
					htmls +="	<td colspan=\"2\">";
					htmls +="		<span class=\"odds\">";
					htmls +=			dbs[i]["Match_BqGM"] !=null?"<a href=\"javascript:void(0)\" title=\"客/主\" onclick=\"setbet('足球单式','半全场-客/主','" + dbs[i]["Match_ID"] + "','Match_BqGM','0','0','客/主');\" style='"+(dbs[i]["Match_BqGM"]!=data[i]["Match_BqGM"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFFF00":"")+"'>"+(dbs[i]["Match_BqGM"]!="0"?dbs[i]["Match_BqGM"]:"")+"</a>":"";
					htmls +="		</span>";
					htmls +="	</td>";
					htmls +="</tr>";
					htmls +="<tr class=\"wzjz\">";
					htmls +="	<td class=\"wzjz\"><span>客/和</span></td>";
					htmls +="	<td colspan=\"2\">";
					htmls +="		<span class=\"odds\">";
					htmls +=			dbs[i]["Match_BqGH"] !=null?"<a href=\"javascript:void(0)\" title=\"客/和\" onclick=\"setbet('足球单式','半全场-客/和','" + dbs[i]["Match_ID"] + "','Match_BqGH','0','0','客/和');\" style='"+(dbs[i]["Match_BqGH"]!=data[i]["Match_BqGH"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFFF00":"")+"'>"+(dbs[i]["Match_BqGH"]!="0"?dbs[i]["Match_BqGH"]:"")+"</a>":"";
					htmls +="		</span>";
					htmls +="	</td>";
					htmls +="</tr>";
					htmls +="<tr class=\"wzjz\">";
					htmls +="	<td class=\"wzjz\"><span>客/客</span></td>";
					htmls +="	<td colspan=\"2\">";
					htmls +="		<span class=\"odds\">";
					htmls +=			dbs[i]["Match_BqGG"] !=null?"<a href=\"javascript:void(0)\" title=\"客/客\" onclick=\"setbet('足球单式','半全场-客/客','" + dbs[i]["Match_ID"] + "','Match_BqGG','0','0','客/客');\" style='"+(dbs[i]["Match_BqGG"]!=data[i]["Match_BqGG"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFFF00":"")+"'>"+(dbs[i]["Match_BqGG"]!="0"?dbs[i]["Match_BqGG"]:"")+"</a>":"";
					htmls +="		</span>";
					htmls +="	</td>";
					htmls +="</tr>	";				
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
