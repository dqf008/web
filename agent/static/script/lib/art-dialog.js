define(["jquery","lang"],function(t,e){function i(e,i,o,n){i=i||3e3,"string"===t.type(i)&&(o=i,i=3e3);var s=a({id:"d-msg",skin:"art-msg "+o,content:e,backdropOpacity:0});setTimeout(function(){s.remove()},i);return s.showModal(),s}var o=function(t){function e(){this.destroyed=!1,this.__popup=t("<div />").css({display:"none",position:"absolute",outline:0}).attr("tabindex","-1").html(this.innerHTML).appendTo("body"),this.__backdrop=this.__mask=t("<div />").css({opacity:.7,background:"#000"}),this.node=this.__popup[0],this.backdrop=this.__backdrop[0],i++}var i=0,o=!("minWidth"in t("html")[0].style),n=!o;return t.extend(e.prototype,{node:null,backdrop:null,fixed:!1,destroyed:!0,open:!1,returnValue:"",autofocus:!0,align:"bottom left",innerHTML:"",className:"art-popup",show:function(i){if(this.destroyed)return this;var s=this.__popup,r=this.__backdrop;if(this.__activeElement=this.__getActive(),this.open=!0,this.follow=i||this.follow,!this.__ready){if(s.addClass(this.className).attr("role",this.modal?"alertdialog":"dialog").css("position",this.fixed?"fixed":"absolute"),o||t(window).on("resize",t.proxy(this.reset,this)),this.modal){var a={position:"fixed",left:0,top:0,width:"100%",height:"100%",overflow:"hidden",userSelect:"none",zIndex:this.zIndex||e.zIndex};s.addClass(this.className+"-modal"),n||t.extend(a,{position:"absolute",width:t(window).width()+"px",height:t(document).height()+"px"}),r.css(a).attr({tabindex:"0"}).on("focus",t.proxy(this.focus,this)),this.__mask=r.clone(!0).attr("style","").insertAfter(s),r.addClass(this.className+"-backdrop").insertBefore(s),this.__ready=!0}s.html()||s.html(this.innerHTML)}return s.addClass(this.className+"-show").show(),r.show(),this.reset().focus(),this.__dispatchEvent("show"),this},showModal:function(){return this.modal=!0,this.show.apply(this,arguments)},close:function(t){return!this.destroyed&&this.open&&(void 0!==t&&(this.returnValue=t),this.__popup.hide().removeClass(this.className+"-show"),this.__backdrop.hide(),this.open=!1,this.blur(),this.__dispatchEvent("close")),this},remove:function(){if(this.destroyed)return this;this.__dispatchEvent("beforeremove"),e.current===this&&(e.current=null),this.__popup.remove(),this.__backdrop.remove(),this.__mask.remove(),o||t(window).off("resize",this.reset),this.__dispatchEvent("remove");for(var i in this)delete this[i];return this},reset:function(){var t=this.follow;return t?this.__follow(t):this.__center(),this.__dispatchEvent("reset"),this},focus:function(){var i=this.node,o=this.__popup,n=e.current,s=this.zIndex=e.zIndex++;if(n&&n!==this&&n.blur(!1),!t.contains(i,this.__getActive())){var r=o.find("[autofocus]")[0];!this._autofocus&&r?this._autofocus=!0:r=i,this.__focus(r)}return o.css("zIndex",s),e.current=this,o.addClass(this.className+"-focus"),this.__dispatchEvent("focus"),this},blur:function(){var t=this.__activeElement,e=arguments[0];return e!==!1&&this.__focus(t),this._autofocus=!1,this.__popup.removeClass(this.className+"-focus"),this.__dispatchEvent("blur"),this},addEventListener:function(t,e){return this.__getEventListener(t).push(e),this},removeEventListener:function(t,e){for(var i=this.__getEventListener(t),o=0;o<i.length;o++)e===i[o]&&i.splice(o--,1);return this},__getEventListener:function(t){var e=this.__listener;return e||(e=this.__listener={}),e[t]||(e[t]=[]),e[t]},__dispatchEvent:function(t){var e=this.__getEventListener(t);this["on"+t]&&this["on"+t]();for(var i=0;i<e.length;i++)e[i].call(this)},__focus:function(t){try{this.autofocus&&!/^iframe$/i.test(t.nodeName)&&t.focus()}catch(t){}},__getActive:function(){try{var t=document.activeElement,e=t.contentDocument,i=e&&e.activeElement||t;return i}catch(t){}},__center:function(){var e=this.__popup,i=t(window),o=t(document),n=this.fixed,s=n?0:o.scrollLeft(),r=n?0:o.scrollTop(),a=i.width(),c=i.height(),h=e.width(),l=e.height(),d=(a-h)/2+s,u=382*(c-l)/1e3+r,f=e[0].style;f.left=Math.max(parseInt(d),s)+"px",f.top=Math.max(parseInt(u),r)+"px"},__follow:function(e){var i=e.parentNode&&t(e),o=this.__popup;if(this.__followSkin&&o.removeClass(this.__followSkin),i){var n=i.offset();if(n.left*n.top<0)return this.__center()}var s=this,r=this.fixed,a=t(window),c=t(document),h=a.width(),l=a.height(),d=c.scrollLeft(),u=c.scrollTop(),f=o.width(),p=o.height(),v=i?i.outerWidth():0,_=i?i.outerHeight():0,m=this.__offset(e),g=m.left,b=m.top,w=r?g-d:g,y=r?b-u:b,k=r?0:d,x=r?0:u,E=k+h-f,L=x+l-p,C={},N=this.align.split(" "),T=this.className+"-",$={top:"bottom",bottom:"top",left:"right",right:"left"},I={top:"top",bottom:"top",left:"left",right:"left"},M=[{top:y-p,bottom:y+_,left:w-f,right:w+v},{top:y,bottom:y-p+_,left:w,right:w-f+v}],z={left:w+v/2-f/2,top:y+_/2-p/2},V={left:[k,E],top:[x,L]};t.each(N,function(t,e){M[t][e]>V[I[e]][1]&&(e=N[t]=$[e]),M[t][e]<V[I[e]][0]&&(N[t]=$[e])}),N[1]||(I[N[1]]="left"===I[N[0]]?"top":"left",M[1][N[1]]=z[I[N[1]]]),T+=N.join("-")+" "+this.className+"-follow",s.__followSkin=T,i&&o.addClass(T),C[I[N[0]]]=parseInt(M[0][N[0]]),C[I[N[1]]]=parseInt(M[1][N[1]]),o.css(C)},__offset:function(e){var i=e.parentNode,o=i?t(e).offset():{left:e.pageX,top:e.pageY};e=i?e:e.target;var n=e.ownerDocument,s=n.defaultView||n.parentWindow;if(s==window)return o;var r=s.frameElement,a=t(n),c=a.scrollLeft(),h=a.scrollTop(),l=t(r).offset(),d=l.left,u=l.top;return{left:o.left+d-c,top:o.top+u-h}}}),e.zIndex=1024,e.current=null,e}(t),n=function(t){return{backdropBackground:"#000",backdropOpacity:.7,content:'<span class="art-dialog-loading">Loading..</span>',title:"",statusbar:"",button:null,ok:null,cancel:null,okValue:"ok",cancelValue:e.cancelValue,cancelDisplay:!0,width:"",height:"",padding:"",skin:"",quickClose:!1,cssUri:"../css/ui-dialog.css",innerHTML:'<div i="dialog" class="art-dialog"><div class="art-dialog-arrow-a"></div><div class="art-dialog-arrow-b"></div><table class="art-dialog-grid"><tr><td i="header" class="art-dialog-header"><button i="close" class="art-dialog-close">&#215;</button><div i="title" class="art-dialog-title"></div></td></tr><tr><td i="body" class="art-dialog-body"><div i="content" class="art-dialog-content"></div></td></tr><tr><td i="footer" class="art-dialog-footer"><div i="statusbar" class="art-dialog-statusbar"></div><div i="button" class="art-dialog-button"></div></td></tr></table></div>'}}(t),s=function(t){var e=0,i=new Date-0,s=!("minWidth"in t("html")[0].style),r="createTouch"in document&&!("onmousemove"in document)||/(iPhone|iPad|iPod)/i.test(navigator.userAgent),a=!s&&!r,c=function(o,n,s){var h=o=o||{};"string"!=typeof o&&1!==o.nodeType||(o={content:o,fixed:!r}),o=t.extend(!0,{},c.defaults,o),o.original=h;var l=o.id=o.id||i+e,d=c.get(l);return d?d.focus():(a||(o.fixed=!1),o.quickClose&&(o.modal=!0,o.backdropOpacity=0),t.isArray(o.button)||(o.button=[]),void 0!==n&&(o.ok=n),o.ok&&o.button.push({id:"ok",value:o.okValue,callback:o.ok,autofocus:!0}),void 0!==s&&(o.cancel=s),o.cancel&&o.button.push({id:"cancel",value:o.cancelValue,callback:o.cancel,display:o.cancelDisplay}),c.list[l]=new c.create(o))},h=function(){};h.prototype=o.prototype;var l=c.prototype=new h;return c.create=function(i){var n=this;t.extend(this,new o);var s=(i.original,t(this.node).html(i.innerHTML)),r=t(this.backdrop);return this.options=i,this._popup=s,t.each(i,function(t,e){"function"==typeof n[t]?n[t](e):n[t]=e}),i.zIndex&&(o.zIndex=i.zIndex),s.attr({"aria-labelledby":this._$("title").attr("id","title:"+this.id).attr("id"),"aria-describedby":this._$("content").attr("id","content:"+this.id).attr("id")}),this._$("close").css("display",this.cancel===!1?"none":"").attr("title",this.cancelValue).on("click",function(t){n._trigger("cancel"),t.preventDefault()}),this._$("dialog").addClass(this.skin),this._$("body").css("padding",this.padding),i.quickClose&&r.on("onmousedown"in document?"mousedown":"click",function(){return n._trigger("cancel"),!1}),this.addEventListener("show",function(){r.css({opacity:0,background:i.backdropBackground}).animate({opacity:i.backdropOpacity},150)}),this._esc=function(t){var e=t.target,i=e.nodeName,s=/^input|textarea$/i,r=o.current===n,a=t.keyCode;!r||s.test(i)&&"button"!==e.type||27===a&&n._trigger("cancel")},t(document).on("keydown",this._esc),this.addEventListener("remove",function(){t(document).off("keydown",this._esc),delete c.list[this.id]}),e++,c.oncreate(this),this},c.create.prototype=l,t.extend(l,{content:function(e){var i=this._$("content");return"object"==typeof e?(e=t(e),i.empty("").append(e.show()),this.addEventListener("remove",function(){t("body").append(e.hide())})):i.html(e),this.reset()},title:function(t){return this._$("title").text(t),this._$("header")[t?"show":"hide"](),this},width:function(t){return this._$("content").css("width",t),this.reset()},height:function(t){return this._$("content").css("height",t),this.reset()},button:function(e){e=e||[];var i=this,o="",n=0;return this.callbacks={},"string"==typeof e?(o=e,n++):t.each(e,function(e,s){var r=s.id=s.id||s.value,a="";i.callbacks[r]=s.callback,s.display===!1?a=' style="display:none"':n++,o+='<button type="button" i-id="'+r+'"'+a+(s.disabled?" disabled":"")+(s.autofocus?' autofocus class="art-dialog-autofocus"':"")+">"+s.value+"</button>",i._$("button").on("click","[i-id="+r+"]",function(e){var o=t(this);o.attr("disabled")||i._trigger(r),e.preventDefault()})}),this._$("button").html(o),this._$("footer")[n?"show":"hide"](),this},statusbar:function(t){return this._$("statusbar").html(t)[t?"show":"hide"](),this},_$:function(t){return this._popup.find("[i="+t+"]")},_trigger:function(t){var e=this.callbacks[t];return"function"!=typeof e||e.call(this)!==!1?this.close().remove():this}}),c.oncreate=t.noop,c.getCurrent=function(){return o.current},c.get=function(t){return void 0===t?c.list:c.list[t]},c.list={},c.defaults=n,c}(t),r=function(t){var e=t(window),i=t(document),o="createTouch"in document,n=document.documentElement,s=!("minWidth"in n.style),r=!s&&"onlosecapture"in n,a="setCapture"in n,c={start:o?"touchstart":"mousedown",over:o?"touchmove":"mousemove",end:o?"touchend":"mouseup"},h=o?function(t){return t.touches||(t=t.originalEvent.touches.item(0)),t}:function(t){return t},l=function(){this.start=t.proxy(this.start,this),this.over=t.proxy(this.over,this),this.end=t.proxy(this.end,this),this.onstart=this.onover=this.onend=t.noop};return l.types=c,l.prototype={start:function(t){return t=this.startFix(t),i.on(c.over,this.over).on(c.end,this.end),this.onstart(t),!1},over:function(t){return t=this.overFix(t),this.onover(t),!1},end:function(t){return t=this.endFix(t),i.off(c.over,this.over).off(c.end,this.end),this.onend(t),!1},startFix:function(o){return o=h(o),this.target=t(o.target),this.selectstart=function(){return!1},i.on("selectstart",this.selectstart).on("dblclick",this.end),r?this.target.on("losecapture",this.end):e.on("blur",this.end),a&&this.target[0].setCapture(),o},overFix:function(t){return t=h(t)},endFix:function(t){return t=h(t),i.off("selectstart",this.selectstart).off("dblclick",this.end),r?this.target.off("losecapture",this.end):e.off("blur",this.end),a&&this.target[0].releaseCapture(),t}},l.create=function(o,n){var s,r,a,c,h=t(o),d=new l,u=l.types.start,f=function(){},p=o.className.replace(/^\s|\s.*/g,"")+"-drag-start",v={onstart:f,onover:f,onend:f,off:function(){h.off(u,d.start)}};return d.onstart=function(t){var n="fixed"===h.css("position"),l=i.scrollLeft(),d=i.scrollTop(),u=h.width(),f=h.height();s=0,r=0,a=n?e.width()-u+s:i.width()-u,c=n?e.height()-f+r:i.height()-f;var _=h.offset(),m=this.startLeft=n?_.left-l:_.left,g=this.startTop=n?_.top-d:_.top;this.clientX=t.clientX,this.clientY=t.clientY,h.addClass(p),v.onstart.call(o,t,m,g)},d.onover=function(t){var e=t.clientX-this.clientX+this.startLeft,i=t.clientY-this.clientY+this.startTop,n=h[0].style;e=Math.max(s,Math.min(a,e)),i=Math.max(r,Math.min(c,i)),n.left=e+"px",n.top=i+"px",v.onover.call(o,t,e,i)},d.onend=function(t){var e=h.position(),i=e.left,n=e.top;h.removeClass(p),v.onend.call(o,t,i,n)},d.off=function(){h.off(u,d.start)},n?d.start(n):h.on(u,d.start),v},l}(t);s.oncreate=function(e){var i,o=e.options,n=o._,s=o.url,a=o.oniframeload;if(s&&(this.padding=o.padding=0,i=t("<iframe />"),i.attr({src:s,name:e.id,width:"100%",height:"100%",allowtransparency:"yes",frameborder:"no",scrolling:"no"}).on("load",function(){var t;try{t=i[0].contentWindow.frameElement}catch(t){}t&&(o.width||e.width(i.contents().width()),o.height||e.height(i.contents().height())),a&&a.call(e)}),e.addEventListener("beforeremove",function(){i.attr("src","about:blank").remove()},!1),e.content(i[0]),e.iframeNode=i[0]),!(n instanceof Object))for(var c=function(){e.close().remove()},h=0;h<frames.length;h++)try{if(n instanceof frames[h].Object){t(frames[h]).one("unload",c);break}}catch(t){}t(e.node).on(r.types.start,"[i=title]",function(t){e.follow||(e.focus(),r.create(e.node,t))})},s.get=function(t){if(t&&t.frameElement){var e,i=t.frameElement,o=s.list;for(var n in o)if(e=o[n],e.node.getElementsByTagName("iframe")[0]===i)return e}else if(t)return s.list[t]},window.ry_dialog=s;var a=s,c="d-loading-bar";try{a=top.ry_dialog}catch(t){}return{dialog:a,msg:function(t,e){i(t,e,"msg-info")},success:function(t,e){i(t,e,"msg-success")},error:function(t,e){i(t,e,"msg-error")},loading:{show:function(t){var e=a({skin:"art-loading",id:c,content:t});return e.showModal(),e},hide:function(){a.get(c).remove()}}}});