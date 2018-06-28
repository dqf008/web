var Sign = {
    div:$("<div></div>"),
    init:function(){
        if($.cookie("Sign")=="open"){
            Sign.html();
        }else if($.cookie("Sign")!="close"){
            Sign.check();
        }
    },
    check:function(){
        $.ajax({
            url: "static/sign/sign.php?type=check&callback=?",
            type: "GET",
            dataType: "json",
            success: function(data){
                if(data['status']=="success"){
                    Sign.html();
                    $.cookie("Sign", "open");
                }else if(data['message']=="IS_SIGN"||data['message']=="SIGN_NOT_OPEN"){
                    //已签到或未开启签到系统，则暂时关闭签到功能
                    $.cookie("Sign", "close");
                }
            }
        });
    },
    html:function(){
        Sign.div.css({
            "overflow": "hidden",
            "background": "url(static/sign/images/sign.png) no-repeat right top",
            "z-index": "1000",
            "width": "0px",
            "height": "0px",
            "position": "fixed",
            "top": "0px",
            "right": "0px"
        });
        Sign.div.append("<a></a>").children().attr("href", "javascript:;").on("click", Sign.sign).append("<img/>").children().attr({"width": "100%", "height": "100%", "src": "static/sign/page_flip.png"});
        Sign.div.animate({width: "50px", height: "52px"}, 1000, Sign.animate);
        Sign.div.hover(function(){
            $(this).stop().animate({width: "307px", height: "319px"}, 500); 
        }, function(){
            $(this).stop().animate({width: "50px", height: "52px"}, 200, Sign.animate);
        });
        $(document.body).prepend(Sign.div);
    },
    sign:function(){
        art.dialog.open("static/sign/index.html", {width: 700, height: 250, title: '会员签到'});
        Sign.div.unbind("mouseenter").unbind("mouseleave").stop().animate({width: "0px", height: "0px"}, "fast"); 
        $.cookie("Sign", "close");
    },
    animate:function(){
        Sign.div.animate({width: "40px", height: "42px"}, 500, function(){
            $(this).animate({width: "50px", height: "52px"}, 500, Sign.animate);
        });
    }
};
$(document).ready(function(){
    Sign.init();
});