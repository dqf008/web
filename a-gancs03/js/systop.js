// JavaScript Document
$(window).load(function() {
	action();
});

function action(){
    $.getJSON("systopDao.php?callback=?",function(json){
			var sum = json.sum;
			if(sum > 0){
				var html = "您有：";
				
				if(json.tknum > 0){
					html += "<a href=\"cwgl/tixian.php?status=2\" target=\"mainFrame\"><span class=\"num\">"+json.tknum+"</span>条<strong>提款</strong></a> ";
					mp3_play('/date/tk.mp3','tk_mp3');
				}
				if(json.hknum > 0){
					html += "<a href=\"cwgl/huikuan.php?status=0\" target=\"mainFrame\"><span class=\"num\">"+json.hknum+"</span>条<strong>汇款</strong></a> ";
					mp3_play('/date/hk.mp3','hk_mp3');
				}
				if(json.ssnum > 0){
					html += "<span class=\"num\">"+json.ssnum+"</span> 条<strong>申诉</strong> ";
				}
				if(json.dlsqnum > 0){
					html += "<a href=\"dlgl/daili.php?status=0\" target=\"mainFrame\"><span class=\"num\">"+json.dlsqnum+"</span>条<strong>代理申请</strong></a> ";
				}
				if(json.tsjynum > 0){
					html += "<span class=\"num\">"+json.tsjynum+"</span> 条<strong>投诉建议</strong> ";
				}
				if(json.ychynum > 0){
					html += "<a href=\"hygl/list.php?money=1&amp;is_stop=0\" target=\"mainFrame\"><span class=\"num\">"+json.ychynum+"</span>个<strong>异常会员</strong></a> ";
				}
				if(json.cgnum > 0){
					html += "<a href=\"zdgl/cg_kjs.php\" target=\"mainFrame\"><span class=\"num\">"+json.cgnum+"</span> 条<strong>串关可结算</strong></a> ";
				}
				if(json.xtggnum > 0) {
					html += "  <a href=\"xxgl/add.php\" target=\"mainFrame\"><span class=\"num\">"+json.xtggnum+"</span>条<strong>系统消息</strong></a> ";
					mp3_play('/date/sysmsg.mp3','msg_mp3');
				}
							
				html += "信息未处理！";
				$("#m_xx").html(html);
				$("#tisi").css("display","block");
			}else{
				$("#m_xx").html("");
				$("#tisi").css("display","none");
			}
		}
	);
	
	setTimeout("action()",10000); //30秒检测一次
}

function mp3_play(mp3_url,div_id) {
	var x = document.getElementById(div_id);
	x.play();
	// var flashvars = {};
	// var params = {};
	// params.wmode = 'transparent';
	// params.quality = 'high';
	// var attributes = {};
	//swfobject.embedSWF(mp3_url, div_id, '1', '1', '8.0.35.0', '', flashvars, params, attributes);
	//$('#'+div_id).html('<audio src="'+mp3_url+'">您的浏览器不支持 audio 标签。</audio>');
}