define(["jquery","css!../styles/datepicker.css","datepicker","datepicker-zh-CN"],function(t){function e(e){this.options=e,"undefined"!=typeof e.hide&&t(".j-datepicker").hide(),this.init()}return e.prototype.init=function(){var e=this;t(function(){function i(t){var b=d.find('a[data-id="'+t+'"]');if(b.length){var i=b.text();d.find(".current").removeClass("current"),b.addClass("current"),"undefined"!=typeof e.options.hide?o.hide():o.show(),a.val(t),n.text(i)}}var o=t(".j-datepicker");o.datepicker({changeMonth:!0,maxDate:0,onSelect:function(){"undefined"!=typeof e.options.refresh?window.location.href="dialog.php?i=history&"+t("#q-form").serialize():e.getHistory()}}),t("#q").click(function(i){i.preventDefault(),"undefined"!=typeof e.options.refresh?window.location.href="dialog.php?i=history&"+t("#q-form").serialize():e.getHistory()});var r=t("#q-id"),n=r.find(".q-val"),a=t("#q-hidden-val"),d=r.find(".select-options");r.hover(function(){d.stop(!0,!0).fadeIn(300)},function(){d.fadeOut(300)}).on("click","a",function(e){e.preventDefault(),d.fadeOut(300),window.location.href="dialog.php?i=history&lotteryId="+t(this).data("id")+"&date="+t(".j-datepicker").val()}),i(e.options.lotteryId)})},e.prototype.getHistory=function(){var e=t("#q-form").serialize(),i=t("#loading"),o=t("#history_detail"),r=t("#hid-empty-data").val();i.show(),o.load("dialog.php?i=history&v="+(new Date).getTime()+" #history_detail>table",e,function(e){i.hide();var n=t(e).find(".table-bordered tbody > tr");n.length||o.html(r)})},e});