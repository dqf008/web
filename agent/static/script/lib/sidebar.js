!function(e,n,t){"use strict";var i=t(n.body),u=t(n);t("html");t.site=t.site||{},t.extend(t.site,{_queue:{run:[]},run:function(){var e=this;this.dequeue("run",function(){e.dequeue("complete",function(){e.trigger("after.run",e)})})},dequeue:function(e,n){var i=this,u=this.getQueue(e),s=u.shift(),a=function(){i.dequeue(e,n)};s?s.call(this,a):t.isFunction(n)&&n.call(this)},getQueue:function(e){return t.isArray(this._queue[e])||(this._queue[e]=[]),this._queue[e]},extend:function(e){return t.each(this._queue,function(n,i){t.isFunction(e[n])&&(i.push(e[n]),delete e[n])}),t.extend(this,e),this},trigger:function(e,n,t){"undefined"!=typeof e&&("undefined"==typeof t&&(t=u),t.trigger(e+".site",n))},resize:function(){if(n.createEvent){var t=n.createEvent("Event");t.initEvent("resize",!0,!0),e.dispatchEvent(t)}else{element=n.documentElement;var i=n.createEventObject();element.fireEvent("onresize",i)}}}),t.configs=t.configs||{},t.extend(t.configs,{data:{},get:function(e){for(var n=function(e,n){return e[n]},t=this.data,i=0;i<arguments.length;i++)e=arguments[i],t=n(t,e);return t},set:function(e,n){this.data[e]=n},extend:function(e,n){var i=this.get(e);return t.extend(!0,i,n)}}),t.configs.set("site",{assets:"../assets"}),e.Site=t.site.extend({run:function(e){"undefined"!=typeof t.site.menu&&t.site.menu.init(),"undefined"!=typeof t.site.menubar&&(t(".sidebar-menu").on("changing.site.menubar",function(){t('[data-toggle="menubar"]').each(function(){}),t.site.menu.refresh()}),t(n).on("click",'[data-toggle="menubar"]',function(){return t.site.menubar.toggle(),!1}),t.site.menubar.init()),i.on("click",".dropdown-menu-media",function(e){e.stopPropagation()}),"undefined"!=typeof t.animsition?this.loadAnimate(function(){t(".animsition").css({"animation-duration":"0s"}),e()}):e()}}),t.site.menubar={opened:null,top:!1,$instance:null,auto:!0,init:function(){if(this.$instance=t(".sidebar-menu"),0!==this.$instance.length){var e=this;this.$instance.on("changed.site.menubar",function(){e.update()}),this.hoverscroll.enable()}},update:function(){this.hoverscroll.update()},hoverscroll:{api:null,init:function(){this.api=t.site.menubar.$instance.children(".sidebar-menu-body").asHoverScroll({namespace:"hoverscorll",direction:"vertical",list:".sidebar",fixed:!1,boundary:100,onEnter:function(){},onLeave:function(){}}).data("asHoverScroll")},update:function(){this.api&&this.api.update()},enable:function(){this.api||this.init(),this.api&&this.api.enable()},disable:function(){this.api&&this.api.disable()}}}}(window,document,jQuery);