define(["six/index"],function(t){var i=t.extend({initialize:function(t){var n=this;i.superclass.initialize.call(this,_.extend(t,{hln:!0,useCategoryAsName:!0,})),this.isQuickMode=!0,n.$checkbox=n.$doc.find(":checkbox"),n.$radio=n.$doc.find(":radio"),n.listenAmount(),$(function(){n.$doc.on("change",":checkbox",function(){var t=n.records.length+1;t<=8?n.getData():(this.checked&&($(this).prop("checked",!1),n.ui.msg(n.utils.format(n.lang.msg.limit,n.options.min+"-8"))),n.getData())}),n.$doc.on("click",".j-content tbody td",function(){var t=$(this),h=t.hasClass("table-current");!t.hasClass("table-odd")&&(t=t.prevAll(".table-odd").slice(0,1)),t=t.nextAll().andSelf().slice(0,4).find(":checkbox"),t.prop("checked")==h&&t.prop("checked",!h).trigger("change")}),n.$radio.on("change",function(){var t=$(this),s=t.closest("td").index();n.options.category=t.closest(".table").find("thead th").eq(s).text()+t.parent("label").text(),n.options.min=t.attr("data-min"),n.options.panType=t.attr("data-pan"),t.prop("checked",!0),$(".j-content").find("[data-i]").map(function(){var e=$(this),p="00"+n.options.panType,p=p.substr(p.length-2,2),k="00"+e.attr("data-i"),k=parseInt(p+k.substr(k.length-2,2));e.attr("data-id",k),e.attr("data-oid",k),e.attr("data-key",k),e.attr("data-odds")!=undefined?e.attr("data-odds",0):e.text("-"),n.reset()}),n.refresh()}),n.isOpen&&n.$radio.eq(0).trigger("change")})},valid:function(){var t=this.records.length;return t<this.options.min||t>8?(this.ui.msg(this.utils.format(this.lang.msg.limit,this.options.min+"-8")),!1):!!this.amount||(this.ui.msg(this.lang.msg.emptyAmount),!1)},reset:function(){this.$doc.find("td").removeClass("table-current"),this.$checkbox.prop("checked",!1),i.superclass.reset.call(this)},getData:function(){var t,e=this.amount,a=this.options.category;this.$doc.find("td").removeClass("table-current"),this.records=this.$checkbox.filter(":checked").map(function(){var t=$(this),i=t.attr("data-id"),n=parseInt(t.attr("data-oid"),10),o=parseFloat(t.attr("data-odds")),s=t.attr("data-key"),c=$.trim(t.parent("td").prevAll(".table-odd").eq(0).text());t.parents("td").next().prevAll().andSelf().slice(-4).addClass("table-current");if(c){return{category:a,name:c,id:i,oddsId:n,key:s,odds:o,amount:e.toFixed(2)}}}).get()},getRecordsHtml:function(){var t=this.records,e=this.utils.combination(t,this.options.min),n=[];this.records=_.map(e,function(t){var e=_.first(t),a=_.pluck(t,"name").join("，"),i=_.min(_.pluck(t,"odds"));n.push({Id:e.id,BetContext:_.map(t,function(e){return{BetContext:e.name+"@"+e.odds,Id:e.id}},this),Lines:i,BetType:e.category,IsForNumber:!0,IsTeMa:!1,Money:e.amount});return{category:e.category,name:a,id:e.id,odds:i,amount:e.amount}}),this.data=n;return i.superclass.getRecordsHtml.call(this)}});return i});