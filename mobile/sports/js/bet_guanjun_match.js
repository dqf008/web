var touzhutype ="";//单式0，串关1
function setbet(match_id, tid) {
	if ($("#uid").val() == "" || $("#uid").val() == "0") { // 没有登录
		alert("登录后才能进行此操作");
		return;
	}

    touzhutype = $("#touzhutype").val();
	$.post("/m/sports/common/guanjun.php", {
		match_id : match_id,
		tid : tid,
		rand : Math.random(),
		touzhutype:touzhutype
	}, function(data) {
		bet(data);
	});
}
