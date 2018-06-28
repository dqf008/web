var touzhutype ="0";//单式0，串关1
function setbet(typename_in,touzhuxiang_in,match_id_in,point_column_in,ben_add_in,xx_in){
	
	if($("#uid").val()=="" || $("#uid").val()=="0"){ //没有登录
		alert("登录后才能进行此操作");
		return ;
	}
	
	if($("#user_money").html()=="" || $("#user_money").html()=="0"){ //金额不足
		alert("金额不足，请先充值");
		return ;
	}
    
	if(!arguments[5]) is_lose = 0;
    $.post("/ajaxleft/baseball_match.php",{ball_sort:typename_in,match_id:match_id_in,touzhuxiang:touzhuxiang_in,point_column:point_column_in,ben_add:ben_add_in,xx:xx_in,rand:Math.random()},
    		function (data){  
    	bet(data);
    	});  
}
