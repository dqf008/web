// JavaScript Document
var dbs =null;
var data =null;
function loaded(league,thispage){
	var league = encodeURI(league);
	$.getJSON("../../../show/guanjun_result_data.php?leaguename="+league+"&CurrPage="+thispage+"&wap=wap&callback=?",function(json){
		
		
		console.log(json);
		var pagecount = json.fy.p_page;
		var messagecount = json.fy.count_num;
		var page = json.fy.page;
		var fenye = "";
		var opt = json.dh;
		if(dbs !=null)
        {
			data = dbs;
			dbs  = json.db;         
		}else{
			dbs  = json.db;
			data = dbs;
		}
		var league = json.leaguename;
		var timename = json.timename;
		if(league != ""){
			$("#league").val(timename);
		}
		if(pagecount == 0){
			$("#nomatch").css("display","");
			$("#loading").css("display","none");
			$("#showsaishi").css("display","none");
		}else{
			var tem_arr = new Array();
			tem_arr = opt.split("|");
			var tem_arr2 = new Array();
			var htmls = "<table cellspacing='1' cellpadding='0' bgcolor='#ACACAC' class='box'><tr><th width='20%'>比赛时间</th><th width='35%'>联盟玩法</th><th width='35%'>比赛队伍</th><th width='10%'>胜出</th></tr>";
			for(var i=0; i<dbs.length; i++){
				htmls+="<tr>";
				htmls+="<td class='zhong line'>"+dbs[i]["Match_Date"]+"</td>";
				htmls+="<td class='zhong line'>冠军<br>"+dbs[i]["x_title"]+"<br>"+dbs[i]["Match_Name"]+"</td>";
				htmls+="<td class='line'>";
				var team_name = dbs[i]["team_name"].split(",");
				for(var ss=0; ss<team_name.length-1; ss++){
					htmls+=team_name[ss]+'<br>';
				}
				htmls+=team_name[team_name.length-1];
				htmls+="</td>";
				htmls+="<td class='zhong line red'>"+dbs[i]["x_result"]+"</td>"
				htmls+="</tr>"
			}
			htmls+="</table>";
			if(dbs.length<=0){
				$("#nomatch").css("display","");
				$("#loading").css("display","none");
				$("#matchpage").css("display","none");
				$("#datashow").css("display","none");
			}else{
				$("#nomatch").css("display","none");
				$("#loading").css("display","none");
				$("#showsaishi").css("display","");
				$("#datashow").html(htmls);
			}
		}
	})
}


function choose_time(time){
	window.location.href='?ymd='+time;
}


function for_choose_time(){
	var time = document.getElementById("time").value;
	choose_time(time);
}