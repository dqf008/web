// JavaScript Document
var dbs  = null;
var data = null;
var window_hight	=	0; //窗口高度
var window_lsm		=	0; //窗口联赛名
function choose_time(time){
	window.location.href='?ymd='+time;
}


function for_choose_time(){
	var time = document.getElementById("time").value;
	choose_time(time);
}