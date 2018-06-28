//共用方法
var CACHE_ID = {};

//＊需統一格式
var G_TMP = {};
var IMG = {};
var RoundSerial = '';
var RoundID = '';
var f_w = {};
var DispDetail = {};
var GameEndTime = {};
//var OddInfo = {};
var LimitInfo = {};
//賠率時間
var CATCH_ODD = {};
//common method object
var QSFUN = {};
/**
*  get object or array length
*  return @int
*/
QSFUN.count = function(o){
    var num = 0;
    if(typeof(o)=='object'){
        for(var i in o)
            num++;

        return num;
    }else{
        return o.length;
    }
};

//get odd,quota,time
//(method,data) array,string
//callback > success method;
QSFUN.Get = function(data , callback , errorCallback){
        $.ajax({
            type:'POST',
            url :ctx+'/member/JsonBetServlet',
            data:QSFUN.postArray(data),
            cache:false,
            async:false,
            dataType:'json',
            error:errorCallback||function(a,b,c){
                return;
            },
            success:callback
        });

};


// post array
QSFUN.postArray = function(o){
    var option = [];
    for(var key in o){
        if(typeof o[key] == 'array'||typeof o[key] =='object'){
            for(var i=0 ; i<o[key].length ; i++){
                option.push({
                    name:key+'[]',
                    value:o[key][i]
                    });
            }
        }else if(typeof o[key] == 'string'||typeof o[key] == 'number'){
            option.push({
                name:key,
                value:o[key]
                });
        }
    }
    return option;
};

// delete object last value
// example: pop({a:1,b:2})
// result : return b;
QSFUN.pop = function(o){
    var j = QSFUN.count(o);

    $.each(o,function(i,v){
        alert(k);
        if(j == k)delete v;

        k++;
    });
};


/* @example
* $.timer(1000, function (timer) {
* 	alert("hello");
* 	timer.stop();
* });
* @desc Show an alert box after 1 second and stop
*
* @example
* var second = false;
*	$.timer(1000, function (timer) {
*		if (!second) {
*			alert('First time!');
*			second = true;
*			timer.reset(3000);
*		}
*		else {
*			alert('Second time');
*			timer.stop();
*		}
*	 });
*/
QSFUN.Ti = function(interval,callback){
    interval = interval || 1000;

	if (!callback)return false;
    
    var _timer = function (interval, callback) {
        var self = this;
        if(self.id != null) clearInterval(self.id);

        this.stop = function () {
            clearInterval(self.id);
        };
        this.internalCallback = function () {
            callback(self);
        };
        this.reset = function (val) {
            if (self.id) clearInterval(self.id);
            self.id = setInterval(this.internalCallback, val || 1000);
            self.interval = val;
        };
        this.interval = interval;
        this.id = setInterval(this.internalCallback, this.interval);
    };
    return new _timer(interval, callback);
};

// getElementById() cache
// return jquery object or jquery[0] == getElementById();
QSFUN.cache = function(id){

    if (CACHE_ID[id] === void 0) CACHE_ID[id] = $('#'+id);

    return CACHE_ID[id];
};

QSFUN.setCookie = function(theName,theValue,theDay){
    if((theName != "")&&(theValue !="")){
        expDay = "Web,01 Jan 2020 18:56:35 GMT";
        if(theDay != null){
            theDay = eval(theDay);
            setDay = new Date();
            setDay.setTime(setDay.getTime()+(theDay*1000*60*60*24));
            expDay = setDay.toGMTString();
        }
        //document.cookie = theName+"="+escape(theValue)+";expires="+expDay;
        document.cookie = theName+"="+escape(theValue)+";path=/;expires="+expDay+";";
        return true;
    }
    return false;
};
QSFUN.delCookie = function(theName){
    document.cookie = theName+ "=;expires=Thu,01-Jan-70 00:00:01 GMT";
    return true;
};
QSFUN.getCookie = function(theName){
    theName += "=";
    theCookie = document.cookie+";";
    start = theCookie.indexOf(theName);
    if(start != -1){
        end = theCookie.indexOf(";",start);
        return unescape(theCookie.substring(start+theName.length,end));
    }
    return false;
};



// correct return true ,fail return false;
QSFUN.isGold = function(v){
    var RegExps = {};
    RegExps.isNumber = /^[-\+]?\d+$/;
    if (RegExps['isNumber'].test(v))
        return true;

    return false;
};

//電子遊藝專用
QSFUN.getGamePager = function(type, me, id, gameIndex){
	if("pt"==id){
		top.location.href = ctx+'/jsp/member/electronicGame/ptelgame.jsp?gameIndex='+gameIndex;
	} else if ("ogg"==id){
		top.location.href = ctx+'/jsp/member/electronicGame/oggelgame.jsp?gameIndex='+gameIndex;
	}else {
		top.location.href = ctx+'/jsp/member/electronicGame/elgame'+(gameIndex==1 ?'':gameIndex)+'.jsp?gameIndex='+gameIndex;
	}
	/*if(type.charAt(0) == '-'){
	    top.location.href = ctx+'/jsp/ogmember/elgame'+(gameIndex==1 ?'':gameIndex)+'.jsp?gameIndex='+gameIndex;
	}else{
	//	getGameList(gameIndex);  //改为动态显示游戏时使用,暂时不用
		$("div[id^='"+id+"-']").hide();
		$("div#"+id+"-"+gameIndex).show();
		if($("h3[id^='#"+id+"-']")){
			$("h3[id^='#"+id+"-']").next("ul").hide();
			$("h3[id^='#"+id+"-"+gameIndex+"']").next("ul").show();
		}
	}*/
};
QSFUN.bm = function(url , n , o){
    var conf = {
        width:'1024',
        height:'768',
        scrollbars:'yes',
        resizable:'no',
	status : 'no',
	location:'yes',
	toolbar:'no',
	menubar:'no'	
    },_tmp = [];
    if(o == undefined) o = {};
    
	// 特例:如為電子遊藝-玉蒲團的搶先看 則設定寬高
    if (/(PriorityWatch)/.test(url)) {
    	o = {
    		'width'  : '960',
    		'height' : '640',
			'scrollbars' : 'no'
    	};
    }
    
    // 特例:如為真人娛樂-BB3D開啟遊戲 則以location的方式連結
    if (/(LiveBB3D|LiveBBK8)/.test(url)) {
    	self.location = url;
    } else {
    	for (var k in conf) {
    		_tmp.push(k + '=' + ((o[k] == undefined) ? conf[k] : o[k]));
    	}
    	window.open(url, n, _tmp.join(','));
    }
};

/*會員中心換頁*/

QSFUN.__options = {
		type: "POST",
		dataType: "html",
		module:ctx+"/member/memberCentre",
		method: "memberdata",
		timeout: 120000,
		blockUI: true,
		blockId: "#page-container",
		blockStyle: "white",
		maskColor: "#000000"
}
QSFUN.SetOptions = function(key, value){
	QSFUN.__options[key] = value;
};

//免费试玩  by chopper 检查会员对此功能是否有权限操作
function checkFreeMember() {
	var conversionFlag = false;
	$.ajax({
		type: "post",
		async:false,//false代表只有在等待ajax执行完毕后才执行 也就是同步
		url: ctx+"/member/memberCentre?method=checkAccountType",
		contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
		dataType: "json",
		success: function(data){
			conversionFlag = data.success;
		}
	});
	return conversionFlag;
}

QSFUN.MGetPager = function(mo, me,oth,open) {
	var param = "";
	if(oth){
		if(typeof oth=="object"){
			param = jQuery.param(oth);
		}
		if(typeof oth=="string"){
			param = oth;
		}
		if(param.indexOf("&")==-1){
			param="&"+param;
		}
	}

	//免费试玩  by nissen 如果是试玩会员,提示不支持试玩会员取款
	if (me == "bankTake") {
		if (checkFreeMember()) {
			alert("试玩账号不支持此功能！");
			return;
		}
	}
	//window.open(ctx+"/member/" + mo + "@module=" + me+param, "MACENTER", "top=50,left=50,width=1020px,height=800px,status=no,scrollbars=yes,resizable=no").focus();
    if( open  == "ac"){
		window.open(ctx+"/member/" + mo + "@module=" + me+param, "_blank");
	}else{

		window.open(ctx+"/member/" + mo + "@module=" + me+param, "_self");
	}


};

QSFUN.MChgPager = function(options, otherData) {
	
	var conf = $.extend(QSFUN.__options, options);
	
	//免费试玩  by nissen 如果是试玩会员,提示不支持试玩会员取款
	if ("bankTake" == conf.method) {
		if (checkFreeMember()) {
			alert("试玩账号不支持此功能！");
			return;
		}
	}
	
	var data = {"method": conf.method};
	if(otherData) {
		$.extend(data, otherData);
	}
	if(conf.blockUI) {
	    $(conf.blockId).block({
	    	message: "<div id='MBlockImg'></div>",
	    	centerY: 0,
	    	css: {
	    		"background-color": "transparent",
	    		top: "300px",
	    		width: '0px',
	    		border: "none",
	    		cursor: "default"
	    	},
	    	overlayCSS: {
	    		cursor: "default",
	    		backgroundColor: conf.maskColor
	    	}
	    });
	   
	}
	$.ajax({
	    type: conf.type,
	    url: conf.module,
	    data: data,
	    dataType: conf.dataType,
	    timeout: conf.timeout,
	    cache:false,
	    error: function(XMLHttpRequest, textStatus, errorThrown) {
	        //alert(JsBook.S_MSG_TRAN_BUSY);
	        if(XMLHttpRequest.responseText.indexOf("您过于频繁操作，请稍等几秒钟后再访问，敬请见谅")>0){
	        	alert("您过于频繁操作，请稍等几秒钟后再访问，敬请见谅。");
	        	return;
	        } else if(XMLHttpRequest.status==403){
	        	//如果是系统判断成403返回，那么认为是频繁访问造成的。
	        	alert("您过于频繁操作，请等下一分钟再访问，敬请见谅。");
	        } else {
	        	alert(JsBook.S_MSG_TRAN_BUSY);
	        }
	    },
	    success: function(data) {
	    	try{
				var d = $.parseJSON(data);
				alert(d.msg);
				window.close();
			}catch(e){
			}

	    	/*if(data=='{"msg":"登录超时,请重新登录!","success":false}'){
	    		var mjson =$.parseJSON(data);
	    		alert(mjson.msg);
	    		window.close();
	    		return;
	    	}*/
	        $('#MACenter-content').html(data);
	        if($("#sowErrorMsg").size()>0){
	        	alert($("#sowErrorMsg").text());
	        }
	    },
	    complete: function() {
	    	
	    	if(conf.blockUI&&typeof $(conf.blockId).unblock=="function") {
	            $(conf.blockId).unblock();
	    	}
	    }
	});
}


function findObj(b,a){var e,c,d;if(!a){a=document}if((e=b.indexOf("?"))>0&&parent.frames.length){a=parent.frames[b.substring(e+1)].document;b=b.substring(0,e)}if(!(d=a[b])&&a.all){d=a.all[b]}for(c=0;!d&&c<a.forms.length;c++){d=a.forms[c][b]}for(c=0;!d&&a.layers&&c<a.layers.length;c++){d=findObj(b,a.layers[c].document)}if(!d&&document.getElementById){d=document.getElementById(b)}return d}function showHideLayers(){var b,d,c,a=showHideLayers.arguments;for(b=0;b<(a.length-2);b+=3){if((c=findObj(a[b]))!=null){d=a[b+2];if(c.style){c=c.style;if(d=="show"){d="visible"}else{if(d=="hide"){d="hidden"}}}c.visibility=d}}};

function SecondMenu(a,b){
	
	a.hover(function(){
		b.show();
	},function(){
		b.hide();
	});
	
	b.hover(function(){
		b.show();
	},function(){
		b.hide();
	});	
}


QSFUN.disableClick = function(href) {
	href.attr("href","javascript:void(0);")
}



//切换彩票方法
function targetLottery(name) {
	 var res=null;
	 $.ajax({  
          type:'get',      
          url:ctx+"/member/vender?method=isEabledToNewLottery&lotteryId="+(name.replace(/[a-zA-Z]+/,''))+"&rnd="+Math.random(),  
          cache:false,  
          async : false,
          dataType:'json',  
          success:function(data){  
        	  res=data;
          }  
    });
	if(true == res){
		toLotteryPage(name);
	}else if(false == res){
		alert("对不起,当前游戏尚未启动,请联系管理员！！");
	}else if(typeof res == "string"){
		alert(res);
	}else{
		alert(res.msg);
	}
}

function toLotteryPage(name){
	var url=ctx+'/jsp/member/lotteryV2/index.jsp';
	if(name=="LT2"){
		//重庆彩票		
		url+="#/app/cqssc";
	}else if(name=="LT3"){
		//天津
		url+="#/app/tjssc";
	}else if(name=="LT24"){
		//六合彩
		url+="#/app/lhc";
	}else if(name=="LT4"){
		//江西时时彩
		url+="#/app/jxssc";
	}else if(name=="LT7"){
		//江苏骰宝
		url+="#/app/jstb";
	}else if(name=="LT5"){
		//广东快乐十分
		url+="#/app/gdklsf";
	}else if(name=="LT6"){
		//北京赛车
		url+="#/app/bjsc";
	}else if(name=="LT9"){
		//幸运28
		url+="#/app/ddcp";
	}else if(name=="LT9"){
		//幸运28
		url+="#/app/ddcp";
	}else if(name=="LT10"){
		//湖南快乐十分
		url+="#/app/hnklshf";
	}else if(name=="LT11"){
		//新疆时时彩
		url+="#/app/xjssc";
	}else if(name=="LT13"){
		//重庆幸运农场
		url+="#/app/cqxync";
	}else if(name=="LT14"){
		//广西快三
		url+="#/app/gxk3";
	}else if(name=="LT15"){
		//北京快乐8
		url+="#/app/bjkl8";
	}else if(name=="LT16"){
		//广西快乐十分
		url+="#/app/gxklsf";
	}else if(name=="LT17"){
		//广东11选5
		url+="#/app/gd11x5";
	}
	
	
	window.open(url,'_blank')
}




