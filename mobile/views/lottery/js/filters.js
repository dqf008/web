angular.module("ionicz.lottery").filter("tick",function(){return function(a,b){var c;return 0>=a?b:(b=moment("00:00:00","HH:mm:ss").add(a,"s").format("mm:ss"),a>=3600&&(c=Math.floor(a/3600),10>c&&(c="0"+c),b=c+":"+b),b)}}).filter("lotteryPcddNum",["$interpolate",function(a){return function(b){var c,d,e,f;if(3==b.length){for(c=a('<span class="round">{{num}}</span>'),d=0,e='<div class="nums-wrap">',f=0;f<b.length;f++)e+=c({num:b[f]}),d+=parseInt(b[f]);return e+='<span class="equal icon icon-dengyu"></span>',e+=c({num:d}),e+="</div>"}}}]).filter("formatResult",["$interpolate",function(a){return function(b,c){var d="";return!angular.isArray(b)&&(b=b.split(",")),c?(d+='<div class="nums-wrap">',angular.forEach(b,function(b){d+=a('<span class="{{class}} data-{{result}}">{{result}}</span>')({result:b,"class":c})}),d+="</div>"):(d+='<div class="result-wrap">',angular.forEach(b,function(b){d+=a('<span class="resultData">{{result}}</span>')({result:b})}),d+="</div>"),d}}]).filter("formatMarkSix",["$interpolate",function(a){return function(b,c){var e,d="";return!angular.isArray(b)&&(b=b.split(",")),b=angular.copy(b),e=b.splice(b.length-1),c?(d+='<div class="nums-wrap">',angular.forEach(b,function(b){d+=a('<span class="{{class}} data-{{result.number}} {{result.color}}">{{result.number}}</span>')({result:b,"class":c})}),d+='<span class="'+c+' transparent icon icon-jiahao"></span>',d+=a('<span class="{{class}} data-{{result.number}} {{result.color}}">{{result.number}}</span>')({result:e[0],"class":c}),d+="</div>"):(d+='<div class="result-wrap">',angular.forEach(b,function(b){d+=a('<span class="resultData">{{result}}</span>')({result:b})}),d+='<span class="transparent icon icon-jiahao"></span>',d+=a('<span class="resultData">{{result}}</span>')({result:e[0]}),d+="</div>"),d}}]);