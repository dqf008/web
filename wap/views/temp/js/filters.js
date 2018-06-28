angular.module('ionicz.lottery')

.filter("tick",function(){return function(a,b){var c;return 0>=a?b:(b=moment("00:00:00","HH:mm:ss").add(a,"s").format("mm:ss"),a>=3600&&(c=Math.floor(a/3600),10>c&&(c="0"+c),b=c+":"+b),b)}})
.filter("formatResult",["$interpolate",function(a){return function(b,c){var d="";return!angular.isArray(b)&&(b=b.split(",")),c?(d+='<div class="nums-wrap">',angular.forEach(b,function(b){d+=a('<span class="{{class}} data-{{result}}">{{result}}</span>')({result:b,"class":c})}),d+="</div>"):(d+='<div class="result-wrap">',angular.forEach(b,function(b){d+=a('<span class="resultData">{{result}}</span>')({result:b})}),d+="</div>"),d}}])
.filter("formatMarkSix",["$interpolate",function(a){return function(b,c){var f,e="";return!angular.isArray(b)&&(b=b.split(",")),b=angular.copy(b),f=b.splice(b.length-1),c?(e+='<div class="nums-wrap">',angular.forEach(b,function(b){e+=a('<span class="{{class}} data-{{result.number}} {{result.color}}">{{result.number}}</span>')({result:b,"class":c})}),e+='<span class="'+c+' transparent icon icon-jiahao"></span>',e+=a('<span class="{{class}} data-{{result.number}} {{result.color}}">{{result.number}}</span>')({result:f[0],"class":c}),e+="</div>"):(e+='<div class="result-wrap">',angular.forEach(b,function(b){e+=a('<span class="resultData">{{result}}</span>')({result:b})}),e+='<span class="transparent icon icon-jiahao"></span>',e+=a('<span class="resultData">{{result}}</span>')({result:f[0]}),e+="</div>"),e}}])

.filter('lotteryPcddNum', function($interpolate) {
	return function(nums) {
		if(nums.length != 3) {
			return;
		}
		
		var tmp = $interpolate('<span class="round">{{num}}</span>');

		var total = 0;
		var html = '<div class="nums-wrap">';
		for(var i=0; i<nums.length; i++) {
			html += tmp({num: nums[i]});
			total += parseInt(nums[i]);
		}
		
		html += '<span class="equal icon icon-dengyu"></span>';
		html += tmp({num: total});
		
		html += '</div>';
		return html;
	}
})