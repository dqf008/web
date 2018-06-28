// JavaScript Document
var dbs  = null;
var data = null;
var window_hight	=	0; //窗口高度
var window_lsm		=	0; //窗口联赛名
function loaded(league,thispage,p){
	var league = encodeURI(league);
	$.getJSON("/show/ftz_bodan_data.php?leaguename="+league+"&CurrPage="+thispage+"&wap=wap&callback=?",function(json){
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
				if(dbs[i]["Match_BzM"]!="0" || dbs[i]["Match_Ho"]!=0 || dbs[i]["Match_DxXpl"]!="0" || dbs[i]["Match_DsDpl"]!="0"){
					if(lsm != dbs[i]["Match_Name"]){
						lsm = dbs[i]["Match_Name"];
						htmls += "<tr class=\"liansai\">";
						htmls += "<td colspan=\"4\" >";
						htmls += "<a href=\"javascript:void(0)\" title=\"选择 >> "+lsm+"\" onclick=\"javascript:choose_lsm('"+lsm+"');\">"+lsm+"</a>";
						htmls += "</td>";
						htmls += "</tr>";
					}
					
					htmls+="<tr class=\"wzjz eachmatch\" >";
					htmls+="	<td colspan=\"2\" width=\"20%\">"+dbs[i]["Match_Date"]+"</td>";
					htmls+="	<td width=\"40%\"><span>主队</span><br/><span>"+dbs[i]["Match_Master"]+"</span></td>";
					htmls+="	<td width=\"40%\"><span>客队</span><br/><span>"+dbs[i]["Match_Guest"]+"</span></td>";
					htmls+="</tr>";
					
					htmls+="<tr class=\"wzjz\" >";
					htmls+="	<td rowspan=\"16\" class=\"wzjz\">全场</td>";
					htmls+="	<td class=\"wzjz\" ><span>1:0</span></td>";
					htmls+="	<td >";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bd10"] !=null && dbs[i]["Match_Bd10"]!="0") ? "<a onclick=\"javascript:setbet('足球单式','波胆-1:0','" + dbs[i]["Match_ID"] + "','Match_Bd10','0','0','"+dbs[i]["Match_Master"]+"');\" href=\"javascript:void(0)\" title=\"1:0\" style='"+(dbs[i]["Match_Bd10"]!=data[i]["Match_Bd10"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bd10"]+"</a>":"");
					htmls+=	"		</span>";
					htmls+="	</td>";
					htmls+="	<td>";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bdg10"] !=null && dbs[i]["Match_Bdg10"] !="0")?"<a href=\"javascript:void(0)\" title=\"0:1\" onclick=\"javascript:setbet('足球单式','波胆-0:1','" + dbs[i]["Match_ID"] + "','Match_Bdg10','0','0','"+dbs[i]["Match_Guest"]+"');\" style='"+(dbs[i]["Match_Bdg10"]!=data[i]["Match_Bdg10"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bdg10"]+"</a>":"");
					htmls+=	"		</span>";
					htmls+=	"	</td>";
					htmls+="</tr>";
					
					htmls+="<tr  class=\"wzjz\" >";
					htmls+="	<td class=\"wzjz\" ><span>2:0</span></td>";
					htmls+="	<td>";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bd20"] !=null && dbs[i]["Match_Bd20"] !="0") ? "<a href=\"javascript:void(0)\" title=\"2:0\" onclick=\"javascript:setbet('足球单式','波胆-2:0','" + dbs[i]["Match_ID"] + "','Match_Bd20','0','0','"+dbs[i]["Match_Master"]+"');\" style='"+(dbs[i]["Match_Bd20"]!=data[i]["Match_Bd20"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bd20"]+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="	<td>";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bdg20"] !=null && dbs[i]["Match_Bdg20"] !="0")?"<a href=\"javascript:void(0)\" title=\"0:2\" onclick=\"javascript:setbet('足球单式','波胆-0:2','" + dbs[i]["Match_ID"] + "','Match_Bdg20','0','0','"+dbs[i]["Match_Guest"]+"');\" style='"+(dbs[i]["Match_Bdg20"]!=data[i]["Match_Bdg20"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bdg20"]+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="</tr>";
					
					htmls+="<tr  class=\"wzjz\" >";
					htmls+="	<td class=\"wzjz\" ><span>2:1</span></td>";
					htmls+="	<td>";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bd21"] !=null && dbs[i]["Match_Bd21"] !="0")?"<a href=\"javascript:void(0)\" title=\"2:1\" onclick=\"javascript:setbet('足球单式','波胆-2:1','" + dbs[i]["Match_ID"] + "','Match_Bd21','0','0','"+dbs[i]["Match_Master"]+"');\" style='"+(dbs[i]["Match_Bd21"]!=data[i]["Match_Bd21"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+(dbs[i]["Match_Bd21"])+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="	<td>";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bdg21"] !=null && dbs[i]["Match_Bdg21"] !="0")?"<a href=\"javascript:void(0)\" title=\"1:2\" onclick=\"javascript:setbet('足球单式','波胆-1:2','" + dbs[i]["Match_ID"] + "','Match_Bdg21','0','0','"+dbs[i]["Match_Guest"]+"');\" style='"+(dbs[i]["Match_Bdg21"]!=data[i]["Match_Bdg21"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bdg21"]+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="</tr>";
					
					htmls+="<tr  class=\"wzjz\" >";
					htmls+="	<td class=\"wzjz\" ><span>3:0</span></td>";
					htmls+="	<td>";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bd30"] !=null && dbs[i]["Match_Bd30"] !="0")?"<a href=\"javascript:void(0)\" title=\"3:0\" onclick=\"javascript:setbet('足球单式','波胆-3:0','" + dbs[i]["Match_ID"] + "','Match_Bd30','0','0','"+dbs[i]["Match_Master"]+"');\" style='"+(dbs[i]["Match_Bd30"]!=data[i]["Match_Bd30"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+(dbs[i]["Match_Bd30"])+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="	<td>";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bdg30"] !=null && dbs[i]["Match_Bdg30"] !="0")?"<a href=\"javascript:void(0)\" title=\"0:3\" onclick=\"javascript:setbet('足球单式','波胆-0:3','" + dbs[i]["Match_ID"] + "','Match_Bdg30','0','0','"+dbs[i]["Match_Guest"]+"');\" style='"+(dbs[i]["Match_Bdg30"]!=data[i]["Match_Bdg30"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bdg30"]+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="</tr>";
					
					htmls+="<tr  class=\"wzjz\" >";
					htmls+="	<td class=\"wzjz\" ><span>3:1</span></td>";
					htmls+="	<td>";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bd31"] !=null && dbs[i]["Match_Bd31"] !="0")?"<a href=\"javascript:void(0)\" title=\"3:1\" onclick=\"javascript:setbet('足球单式','波胆-3:1','" + dbs[i]["Match_ID"] + "','Match_Bd31','0','0','"+dbs[i]["Match_Master"]+"');\" style='"+(dbs[i]["Match_Bd31"]!=data[i]["Match_Bd31"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bd31"]+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="	<td>";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bdg31"] !=null && dbs[i]["Match_Bdg31"] !="0")?"<a href=\"javascript:void(0)\" title=\"1:3\" onclick=\"javascript:setbet('足球单式','波胆-1:3','" + dbs[i]["Match_ID"] + "','Match_Bdg31','0','0','"+dbs[i]["Match_Guest"]+"');\" style='"+(dbs[i]["Match_Bdg31"]!=data[i]["Match_Bdg31"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bdg31"]+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="</tr>";
					
					htmls+="<tr  class=\"wzjz\" >";
					htmls+="	<td class=\"wzjz\" ><span>3:2</span></td>";
					htmls+="	<td>";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bd32"] !=null && dbs[i]["Match_Bd32"] !="0")?"<a href=\"javascript:void(0)\" title=\"3:2\" onclick=\"javascript:setbet('足球单式','波胆-3:2','" + dbs[i]["Match_ID"] + "','Match_Bd32','0','0','"+dbs[i]["Match_Master"]+"');\" style='"+(dbs[i]["Match_Bd32"]!=data[i]["Match_Bd32"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bd32"]+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="	<td>";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bdg32"] !=null && dbs[i]["Match_Bdg32"] !="0")?"<a href=\"javascript:void(0)\" title=\"2:3\" onclick=\"javascript:setbet('足球单式','波胆-2:3','" + dbs[i]["Match_ID"] + "','Match_Bdg32','0','0','"+dbs[i]["Match_Guest"]+"');\" style='"+(dbs[i]["Match_Bdg32"]!=data[i]["Match_Bdg32"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bdg32"]+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="</tr>";
					
					htmls+="<tr  class=\"wzjz\" >";
					htmls+="	<td class=\"wzjz\" ><span>4:0</span></td>";
					htmls+="	<td>";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bd40"] !=null && dbs[i]["Match_Bd40"] !="0")?"<a href=\"javascript:void(0)\" title=\"4:0\" onclick=\"javascript:setbet('足球单式','波胆-4:0','" + dbs[i]["Match_ID"] + "','Match_Bd40','0','0','"+dbs[i]["Match_Master"]+"');\" style='"+(dbs[i]["Match_Bd40"]!=data[i]["Match_Bd40"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bd40"]+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="	<td>";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bdg40"] !=null && dbs[i]["Match_Bdg40"] !="0")?"<a href=\"javascript:void(0)\" title=\"0:4\" onclick=\"javascript:setbet('足球单式','波胆-0:4','" + dbs[i]["Match_ID"] + "','Match_Bdg40','0','0','"+dbs[i]["Match_Guest"]+"');\" style='"+(dbs[i]["Match_Bdg40"]!=data[i]["Match_Bdg40"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bdg40"]+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="</tr>";
					
					htmls+="<tr  class=\"wzjz\" >";
					htmls+="	<td class=\"wzjz\" ><span>4:1</span></td>";
					htmls+="	<td>";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bd41"] !=null && dbs[i]["Match_Bd41"] !="0")?"<a href=\"javascript:void(0)\" title=\"4:1\" onclick=\"javascript:setbet('足球单式','波胆-4:1','" + dbs[i]["Match_ID"] + "','Match_Bd41','0','0','"+dbs[i]["Match_Master"]+"');\" style='"+(dbs[i]["Match_Bd41"]!=data[i]["Match_Bd41"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bd41"]+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="	<td>";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bdg41"] !=null && dbs[i]["Match_Bdg41"] !="0")?"<a href=\"javascript:void(0)\" title=\"1:4\" onclick=\"javascript:setbet('足球单式','波胆-1:4','" + dbs[i]["Match_ID"] + "','Match_Bdg41','0','0','"+dbs[i]["Match_Guest"]+"');\" style='"+(dbs[i]["Match_Bdg41"]!=data[i]["Match_Bdg41"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bdg41"]+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="</tr>";
					
					htmls+="<tr  class=\"wzjz\" >";
					htmls+="	<td class=\"wzjz\" ><span>4:2</span></td>";
					htmls+="	<td>";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bd42"] !=null && dbs[i]["Match_Bd42"] !="0")?"<a href=\"javascript:void(0)\" title=\"4:2\" onclick=\"javascript:setbet('足球单式','波胆-4:2','" + dbs[i]["Match_ID"] + "','Match_Bd42','0','0','"+dbs[i]["Match_Master"]+"');\" style='"+(dbs[i]["Match_Bd42"]!=data[i]["Match_Bd42"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bd42"]+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="	<td>";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bdg42"] !=null && dbs[i]["Match_Bdg42"] !="0")?"<a href=\"javascript:void(0)\" title=\"2:4\" onclick=\"javascript:setbet('足球单式','波胆-2:4','" + dbs[i]["Match_ID"] + "','Match_Bdg42','0','0','"+dbs[i]["Match_Guest"]+"');\" style='"+(dbs[i]["Match_Bdg42"]!=data[i]["Match_Bdg42"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bdg42"]+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="</tr>";
					
					htmls+="<tr  class=\"wzjz\" >";
					htmls+="	<td class=\"wzjz\" ><span>4:3</span></td>";
					htmls+="	<td>";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bd43"] !=null && dbs[i]["Match_Bd43"] !="0")?"<a href=\"javascript:void(0)\" title=\"4:3\" onclick=\"javascript:setbet('足球单式','波胆-4:3','" + dbs[i]["Match_ID"] + "','Match_Bd43','0','0','"+dbs[i]["Match_Master"]+"');\" style='"+(dbs[i]["Match_Bd43"]!=data[i]["Match_Bd43"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bd43"]+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="	<td>";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bdg43"] !=null && dbs[i]["Match_Bdg43"] !="0")?"<a href=\"javascript:void(0)\" title=\"3:4\" onclick=\"javascript:setbet('足球单式','波胆-3:4','" + dbs[i]["Match_ID"] + "','Match_Bdg43','0','0','"+dbs[i]["Match_Guest"]+"');\" style='"+(dbs[i]["Match_Bdg43"]!=data[i]["Match_Bdg43"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bdg43"]+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="</tr>";
					
					htmls+="<tr  class=\"wzjz\" >";
					htmls+="	<td class=\"wzjz\" ><span>0:0</span></td>";
					htmls+="	<td colspan=\"2\" style=\"text-align:center\">";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bd00"] !=null && dbs[i]["Match_Bd00"] !="0")?"<a href=\"javascript:void(0)\" title=\"0:0\" onclick=\"javascript:setbet('足球单式','波胆-0:0','" + dbs[i]["Match_ID"] + "','Match_Bd00','0','0','0:0');\" style='"+(dbs[i]["Match_Bd00"]!=data[i]["Match_Bd00"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bd00"]+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="</tr>";
					
					htmls+="<tr  class=\"wzjz\" >";
					htmls+="	<td class=\"wzjz\" ><span>1:1</span></td>";
					htmls+="	<td colspan=\"2\" style=\"text-align:center\">";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bd11"] !=null && dbs[i]["Match_Bd11"] !="0")?"<a href=\"javascript:void(0)\" title=\"1:1\" onclick=\"javascript:setbet('足球单式','波胆-1:1','" + dbs[i]["Match_ID"] + "','Match_Bd11','0','0','1:1');\" style='"+(dbs[i]["Match_Bd11"]!=data[i]["Match_Bd11"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bd11"]+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="</tr>";
										
					htmls+="<tr  class=\"wzjz\" >";
					htmls+="	<td class=\"wzjz\" ><span>2:2</span></td>";
					htmls+="	<td colspan=\"2\" style=\"text-align:center\">";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bd22"] !=null && dbs[i]["Match_Bd22"] !="0")?"<a href=\"javascript:void(0)\" title=\"2:2\" onclick=\"javascript:setbet('足球单式','波胆-2:2','" + dbs[i]["Match_ID"] + "','Match_Bd22','0','0','2:2');\" style='"+(dbs[i]["Match_Bd22"]!=data[i]["Match_Bd22"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bd22"]+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="</tr>";
					
					htmls+="<tr  class=\"wzjz\" >";
					htmls+="	<td class=\"wzjz\" ><span>3:3</span></td>";
					htmls+="	<td colspan=\"2\" style=\"text-align:center\">";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bd33"] !=null && dbs[i]["Match_Bd33"] !="0")?"<a href=\"javascript:void(0)\" title=\"3:3\" onclick=\"javascript:setbet('足球单式','波胆-3:3','" + dbs[i]["Match_ID"] + "','Match_Bd33','0','0','3:3');\" style='"+(dbs[i]["Match_Bd33"]!=data[i]["Match_Bd33"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bd33"]+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="</tr>";
					
					htmls+="<tr  class=\"wzjz\" >";
					htmls+="	<td class=\"wzjz\" ><span>4:4</span></td>";
					htmls+="	<td colspan=\"2\" style=\"text-align:center\">";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bd44"] !=null && dbs[i]["Match_Bd44"] !="0")?"<a href=\"javascript:void(0)\" title=\"4:4\" onclick=\"javascript:setbet('足球单式','波胆-4:4','" + dbs[i]["Match_ID"] + "','Match_Bd44','0','0','4:4');\" style='"+(dbs[i]["Match_Bd44"]!=data[i]["Match_Bd44"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bd44"]+"</a>":"");
					htmls+="		</span>";
					htmls+="	</td>";
					htmls+="</tr>";
					
					htmls+="<tr  class=\"wzjz\" >";
					htmls+="	<td class=\"wzjz\" ><span>UP5</span></td>";
					htmls+="	<td colspan=\"2\" style=\"text-align:center\">";
					htmls+="		<span class=\"odds\">";
					htmls+=				((dbs[i]["Match_Bdup5"] !=null && dbs[i]["Match_Bdup5"] !="0")?"<a href=\"javascript:void(0)\" title=\"其它比分\" onclick=\"javascript:setbet('足球单式','波胆-UP5','" + dbs[i]["Match_ID"] + "','Match_Bdup5','0','0','UP5');\" style='"+(dbs[i]["Match_Bdup5"]!=data[i]["Match_Bdup5"] && data[i]["Match_ID"]==dbs[i]["Match_ID"]?"background:#FFCC00":"")+"'>"+dbs[i]["Match_Bdup5"]+"</a>":"");
					htmls+="		</span>";
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
