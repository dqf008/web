define(["jquery"],function(e){return e.fn.extend({tab:function(t){var a={autoPlay:!0,current:0,mouseover:!1,className:{bd:".tab-bd",hd:".tab-hd",item:".tab-item",active:"active"},speed:0,delay:400,selected:function(e,t){}};return this.each(function(){function n(t,a){c.removeClass(i.className.active),e(t).addClass(i.className.active);var n=c.index(t);r.eq(n).show(i.speed).siblings(i.className.bd).hide(),i.selected.call(t,a,r.eq(n),n)}t&&(i=e.extend(a,t));var s=e(this),i=a,c=s.find(i.className.hd).find(i.className.item),r=s.find(i.className.bd);a.mouseover?(c.on("mouseenter",function(e){n(this,e)}),c.eq(a.current).trigger("mouseenter")):(c.on("click",function(e){return n(this,e),!1}),c.eq(a.current).trigger("click"))})}}),e});