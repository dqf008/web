(function(){function t(e,n){function c(t){if(c[t]!==d)return c[t];var e;if("bug-string-char-index"==t)e="a"!="a"[0];else if("json"==t)e=c("json-stringify")&&c("json-parse");else{var r,o='{"a":[1,true,false,null,"\\u0000\\b\\n\\f\\r\\t"]}';if("json-stringify"==t){var l=n.stringify,s="function"==typeof l&&C;if(s){(r=function(){return 1}).toJSON=r;try{s="0"===l(0)&&"0"===l(new i)&&'""'==l(new a)&&l(v)===d&&l(d)===d&&l()===d&&"1"===l(r)&&"[1]"==l([r])&&"[null]"==l([d])&&"null"==l(null)&&"[null,null,null]"==l([d,v,null])&&l({a:[r,!0,!1,null,"\0\b\n\f\r\t"]})==o&&"1"===l(null,r)&&"[\n 1,\n 2\n]"==l([1,2],null,1)&&'"-271821-04-20T00:00:00.000Z"'==l(new f(-864e13))&&'"+275760-09-13T00:00:00.000Z"'==l(new f(864e13))&&'"-000001-01-01T00:00:00.000Z"'==l(new f(-621987552e5))&&'"1969-12-31T23:59:59.999Z"'==l(new f(-1))}catch(t){s=!1}}e=s}if("json-parse"==t){var u=n.parse;if("function"==typeof u)try{if(0===u("0")&&!u(!1)){r=u(o);var h=5==r.a.length&&1===r.a[0];if(h){try{h=!u('"\t"')}catch(t){}if(h)try{h=1!==u("01")}catch(t){}if(h)try{h=1!==u("1.")}catch(t){}}}}catch(t){h=!1}e=h}}return c[t]=!!e}e||(e=o.Object()),n||(n=o.Object());var i=e.Number||o.Number,a=e.String||o.String,l=e.Object||o.Object,f=e.Date||o.Date,s=e.SyntaxError||o.SyntaxError,u=e.TypeError||o.TypeError,h=e.Math||o.Math,p=e.JSON||o.JSON;"object"==typeof p&&p&&(n.stringify=p.stringify,n.parse=p.parse);var g,y,d,b=l.prototype,v=b.toString,C=new f(-0xc782b5b800cec);try{C=C.getUTCFullYear()==-109252&&0===C.getUTCMonth()&&1===C.getUTCDate()&&10==C.getUTCHours()&&37==C.getUTCMinutes()&&6==C.getUTCSeconds()&&708==C.getUTCMilliseconds()}catch(t){}if(!c("json")){var j="[object Function]",S="[object Date]",O="[object Number]",w="[object String]",T="[object Array]",A="[object Boolean]",_=c("bug-string-char-index");if(!C)var N=h.floor,U=[0,31,59,90,120,151,181,212,243,273,304,334],J=function(t,e){return U[e]+365*(t-1970)+N((t-1969+(e=+(e>1)))/4)-N((t-1901+e)/100)+N((t-1601+e)/400)};if((g=b.hasOwnProperty)||(g=function(t){var e,r={};return(r.__proto__=null,r.__proto__={toString:1},r).toString!=v?g=function(t){var e=this.__proto__,r=t in(this.__proto__=null,this);return this.__proto__=e,r}:(e=r.constructor,g=function(t){var r=(this.constructor||e).prototype;return t in this&&!(t in r&&this[t]===r[t])}),r=null,g.call(this,t)}),y=function(t,e){var n,o,c,i=0;(n=function(){this.valueOf=0}).prototype.valueOf=0,o=new n;for(c in o)g.call(o,c)&&i++;return n=o=null,i?y=2==i?function(t,e){var r,n={},o=v.call(t)==j;for(r in t)o&&"prototype"==r||g.call(n,r)||!(n[r]=1)||!g.call(t,r)||e(r)}:function(t,e){var r,n,o=v.call(t)==j;for(r in t)o&&"prototype"==r||!g.call(t,r)||(n="constructor"===r)||e(r);(n||g.call(t,r="constructor"))&&e(r)}:(o=["valueOf","toString","toLocaleString","propertyIsEnumerable","isPrototypeOf","hasOwnProperty","constructor"],y=function(t,e){var n,c,i=v.call(t)==j,a=!i&&"function"!=typeof t.constructor&&r[typeof t.hasOwnProperty]&&t.hasOwnProperty||g;for(n in t)i&&"prototype"==n||!a.call(t,n)||e(n);for(c=o.length;n=o[--c];a.call(t,n)&&e(n));}),y(t,e)},!c("json-stringify")){var x={92:"\\\\",34:'\\"',8:"\\b",12:"\\f",10:"\\n",13:"\\r",9:"\\t"},m="000000",M=function(t,e){return(m+(e||0)).slice(-t)},k="\\u00",D=function(t){for(var e='"',r=0,n=t.length,o=!_||n>10,c=o&&(_?t.split(""):t);r<n;r++){var i=t.charCodeAt(r);switch(i){case 8:case 9:case 10:case 12:case 13:case 34:case 92:e+=x[i];break;default:if(i<32){e+=k+M(2,i.toString(16));break}e+=o?c[r]:t.charAt(r)}}return e+'"'},E=function(t,e,r,n,o,c,i){var a,l,f,s,h,p,b,C,j,_,U,x,m,k,P,Z;try{a=e[t]}catch(t){}if("object"==typeof a&&a)if(l=v.call(a),l!=S||g.call(a,"toJSON"))"function"==typeof a.toJSON&&(l!=O&&l!=w&&l!=T||g.call(a,"toJSON"))&&(a=a.toJSON(t));else if(a>-1/0&&a<1/0){if(J){for(h=N(a/864e5),f=N(h/365.2425)+1970-1;J(f+1,0)<=h;f++);for(s=N((h-J(f,0))/30.42);J(f,s+1)<=h;s++);h=1+h-J(f,s),p=(a%864e5+864e5)%864e5,b=N(p/36e5)%24,C=N(p/6e4)%60,j=N(p/1e3)%60,_=p%1e3}else f=a.getUTCFullYear(),s=a.getUTCMonth(),h=a.getUTCDate(),b=a.getUTCHours(),C=a.getUTCMinutes(),j=a.getUTCSeconds(),_=a.getUTCMilliseconds();a=(f<=0||f>=1e4?(f<0?"-":"+")+M(6,f<0?-f:f):M(4,f))+"-"+M(2,s+1)+"-"+M(2,h)+"T"+M(2,b)+":"+M(2,C)+":"+M(2,j)+"."+M(3,_)+"Z"}else a=null;if(r&&(a=r.call(e,t,a)),null===a)return"null";if(l=v.call(a),l==A)return""+a;if(l==O)return a>-1/0&&a<1/0?""+a:"null";if(l==w)return D(""+a);if("object"==typeof a){for(k=i.length;k--;)if(i[k]===a)throw u();if(i.push(a),U=[],P=c,c+=o,l==T){for(m=0,k=a.length;m<k;m++)x=E(m,a,r,n,o,c,i),U.push(x===d?"null":x);Z=U.length?o?"[\n"+c+U.join(",\n"+c)+"\n"+P+"]":"["+U.join(",")+"]":"[]"}else y(n||a,function(t){var e=E(t,a,r,n,o,c,i);e!==d&&U.push(D(t)+":"+(o?" ":"")+e)}),Z=U.length?o?"{\n"+c+U.join(",\n"+c)+"\n"+P+"}":"{"+U.join(",")+"}":"{}";return i.pop(),Z}};n.stringify=function(t,e,n){var o,c,i,a;if(r[typeof e]&&e)if((a=v.call(e))==j)c=e;else if(a==T){i={};for(var l,f=0,s=e.length;f<s;l=e[f++],a=v.call(l),(a==w||a==O)&&(i[l]=1));}if(n)if((a=v.call(n))==O){if((n-=n%1)>0)for(o="",n>10&&(n=10);o.length<n;o+=" ");}else a==w&&(o=n.length<=10?n:n.slice(0,10));return E("",(l={},l[""]=t,l),c,i,o,"",[])}}if(!c("json-parse")){var P,Z,F=a.fromCharCode,$={92:"\\",34:'"',47:"/",98:"\b",116:"\t",110:"\n",102:"\f",114:"\r"},H=function(){throw P=Z=null,s()},I=function(){for(var t,e,r,n,o,c=Z,i=c.length;P<i;)switch(o=c.charCodeAt(P)){case 9:case 10:case 13:case 32:P++;break;case 123:case 125:case 91:case 93:case 58:case 44:return t=_?c.charAt(P):c[P],P++,t;case 34:for(t="@",P++;P<i;)if(o=c.charCodeAt(P),o<32)H();else if(92==o)switch(o=c.charCodeAt(++P)){case 92:case 34:case 47:case 98:case 116:case 110:case 102:case 114:t+=$[o],P++;break;case 117:for(e=++P,r=P+4;P<r;P++)o=c.charCodeAt(P),o>=48&&o<=57||o>=97&&o<=102||o>=65&&o<=70||H();t+=F("0x"+c.slice(e,P));break;default:H()}else{if(34==o)break;for(o=c.charCodeAt(P),e=P;o>=32&&92!=o&&34!=o;)o=c.charCodeAt(++P);t+=c.slice(e,P)}if(34==c.charCodeAt(P))return P++,t;H();default:if(e=P,45==o&&(n=!0,o=c.charCodeAt(++P)),o>=48&&o<=57){for(48==o&&(o=c.charCodeAt(P+1),o>=48&&o<=57)&&H(),n=!1;P<i&&(o=c.charCodeAt(P),o>=48&&o<=57);P++);if(46==c.charCodeAt(P)){for(r=++P;r<i&&(o=c.charCodeAt(r),o>=48&&o<=57);r++);r==P&&H(),P=r}if(o=c.charCodeAt(P),101==o||69==o){for(o=c.charCodeAt(++P),43!=o&&45!=o||P++,r=P;r<i&&(o=c.charCodeAt(r),o>=48&&o<=57);r++);r==P&&H(),P=r}return+c.slice(e,P)}if(n&&H(),"true"==c.slice(P,P+4))return P+=4,!0;if("false"==c.slice(P,P+5))return P+=5,!1;if("null"==c.slice(P,P+4))return P+=4,null;H()}return"$"},Y=function(t){var e,r;if("$"==t&&H(),"string"==typeof t){if("@"==(_?t.charAt(0):t[0]))return t.slice(1);if("["==t){for(e=[];t=I(),"]"!=t;r||(r=!0))r&&(","==t?(t=I(),"]"==t&&H()):H()),","==t&&H(),e.push(Y(t));return e}if("{"==t){for(e={};t=I(),"}"!=t;r||(r=!0))r&&(","==t?(t=I(),"}"==t&&H()):H()),","!=t&&"string"==typeof t&&"@"==(_?t.charAt(0):t[0])&&":"==I()||H(),e[t.slice(1)]=Y(I());return e}H()}return t},B=function(t,e,r){var n=L(t,e,r);n===d?delete t[e]:t[e]=n},L=function(t,e,r){var n,o=t[e];if("object"==typeof o&&o)if(v.call(o)==T)for(n=o.length;n--;)B(o,n,r);else y(o,function(t){B(o,t,r)});return r.call(t,e,o)};n.parse=function(t,e){var r,n;return P=0,Z=""+t,r=Y(I()),"$"!=I()&&H(),P=Z=null,e&&v.call(e)==j?L((n={},n[""]=r,n),"",e):r}}}return n.runInContext=t,n}var e="function"==typeof define&&define.amd,r={function:!0,object:!0},n=r[typeof exports]&&exports&&!exports.nodeType&&exports,o=r[typeof window]&&window||this,c=n&&r[typeof module]&&module&&!module.nodeType&&"object"==typeof global&&global;if(!c||c.global!==c&&c.window!==c&&c.self!==c||(o=c),n&&!e)t(o,n);else{var i=o.JSON,a=o.JSON3,l=!1,f=t(o,o.JSON3={noConflict:function(){return l||(l=!0,o.JSON=i,o.JSON3=a,i=a=null),f}});o.JSON={parse:f.parse,stringify:f.stringify}}e&&define([],function(){return f})}).call(this);