/**
 * platforms.js
 * 
 */
//绑定点击事件
$(document).ready(function(){
	selMenu("menu_03");
});
// 切换HG EA
function nTabs(thisObj, Num){
	if (thisObj.className == "activey") 
		return;
	var tabObj = thisObj.parentNode.id;
	var tabList = document.getElementById(tabObj).getElementsByTagName("li");
	for (var i = 0; i < tabList.length; i++) {
		if (i == Num) {
			thisObj.className = "activey";
			document.getElementById(tabObj + "_Content" + i).style.display = "block";
		}
		else {
			tabList[i].className = "normal";
			document.getElementById(tabObj + "_Content" + i).style.display = "none";
		}
	}
}
/**
 * function jumpgame
 * @param {Object} id
 * @param {Object} type
 */
function jumpgame(id, type){
	var url = ctx + "/member/flex";
	var issuccess = false;
	$.ajax({
		url: url,
		data: {
			"deskTag": id,
			'type': 'isConnected'
		},
		success: function(result){
			if (result.isOk) {
				//document.getElementById("joinGame_"+id).style.display="";
				issuccess = true;
			}
			else 
				if (result && !result.success && result.msg) {
					alert(result.msg);
					window.location.reload();
				}
				else 
					if (result.isOk == 0) {
						//document.getElementById("joinGame_"+id).style.display="none";
						alert("游戏未启动");
						window.location.reload();
					}
					else {
						alert("请求超时");
					}
		},
		dataType: 'json',
		async: false
	});
	if (issuccess) {
		if ("baccarat" == type) {
			var url2 = ctx + "/jsp/ogmember/flex/gameList/baccarat.jsp?id=" + id;
			openWin3(url2, "百家乐", 'no');
		}
		else 
			if ("dragonTiger" == type) {
				var url2 = ctx + "/jsp/ogmember/flex/gameList/dragonTiger.jsp?id=" + id;
				openWin3(url2, "龙虎斗", 'no');
			}
			else 
				if ("paigu" == type) {
					var url2 = ctx + "/jsp/ogmember/flex/gameList/paigu.jsp?id=" + id;
					openWin3(url2, "温州牌九", 'no');
				}
				else 
					if ("mj28" == type) {
						var url2 = ctx + "/jsp/ogmember/flex/gameList/mj28.jsp?id=" + id;
						openWin3(url2, "二八扛", 'no');
					}
	}
}

function rule(gameName){
    var url = ctx+"/jsp/ogmember/flex/game/rule/" + gameName+"Rule.html";
    openWin3(url, gameName, 'yes');
    return false;
}