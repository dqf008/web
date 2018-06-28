(function($){
    $.fn.placeholder = function(options){
        var defaults = {
            attr: "placeholder"
        };
        options = $.extend(defaults, options);
        return $(this).map(function(){
            var text = $(this).attr(options.attr);
            if(text!=undefined){
                if($(this).attr("type")=="password"){
                    $(this).focusout(function(){
                        var on = $(this).val();
                        if(on==""){
                            $(this).hide().siblings("input").show();
                        }
                    }).hide().siblings("input").show().focusin(function(){
                        $(this).hide().siblings("input").show().focus();
                    });
                }else{
                    $(this).val(text);
                    $(this).focusin(function(){
                        var on = $(this).val();
                        if(on==text){
                            $(this).val("");
                        }
                    }).focusout(function(){
                        var on = $(this).val();
                        if(on==""){
                            $(this).val(text);
                        }
                    });
                }
            }
        });
    }
})(jQuery);
var code = { };
code.app ={};



$(function(){
    code.app.nav_light = function(){
        var activity_nav = $('.activity-nav');
        var flag1 = true;
        if(activity_nav.length>0){
            setInterval(function(){
                if(flag1){
                    flag1= false;
                    activity_nav.find('.cn').css('color','#f3e9b8');
                    activity_nav.find('.iconfont').css('color','#f3e9b8');
                }else{
                    flag1= true;
                    activity_nav.find('.cn').css('color','red');
                    activity_nav.find('.iconfont').css('color','red');
                }
            },300);
        }
        var red_link = $('.red-link');
        var flag2 = true;
        if(red_link.length>0){
            setInterval(function(){
                if(flag2){
                    flag2= false;
                    red_link.css('color','#a2b4ff');
                    red_link.find('.iconfont').css('color','#a2b4ff');
                }else{
                    flag2= true;
                    red_link.css('color','red');
                    red_link.find('.iconfont').css('color','red');
                }
            },300);
        }
    }

    var hasPlaceholderSupport = function(){
        var attr = "placeholder";
        var input = document.createElement("input");
        return attr in input;
    }

    !hasPlaceholderSupport() && $(".form-control").placeholder();

    $('.hover-down').hover(function () {
        $(this).find('.down-menu').stop().slideDown();
    }, function () {
        $(this).find('.down-menu').stop().slideUp();
    });
    var redNav = $('.red');
    var redNavFLag = true;
    var redFun = function(){
        if(redNavFLag ){
            redNav.css('color','#ff1e00');
            redNav.find('p').css('color','#ff1e00');
            redNav.find(".iconfont").css('color','#ff1e00');
            redNavFLag = false;
        }else{
            redNav.css('color','#');
            redNav.find('p').css('color','#fed139');
            redNav.find(".iconfont").css('color','#fed139');
            redNavFLag = true;
        }
    };
    var redNavFun = setInterval(redFun,300);
    $(".head-menu").find(".sub-game, .sub-live, .sub-sports, .sub-lottery").not(".hover-down").hover(function(){
        $(".sub-menu ."+$(this).attr("class")+" .down-wrap").stop().slideToggle();
    }, function(){
        var _obj = $(".sub-menu ."+$(this).attr("class")+" .down-wrap");
        _obj.is(":visible") && _obj.stop().slideToggle();
    });
    $(".sub-menu .down-wrap").on("hover", function(){
        $(this).stop().slideToggle();
    });
});

