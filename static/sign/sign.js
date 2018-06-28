var Sign = {
    div:null,
    timeout:null,
    cookieName:"",
    defaultSmall:null,
    init:function(){
        Sign.div = $(".sign-pageflip");
        if(Sign.cookieName=="Sign2-guest"){
            Sign.guest(Sign.defaultSmall||$.cookie(Sign.cookieName)?true:false);
        }else{
            if($.cookie(Sign.cookieName)=="open"){
                Sign.html();
            }else if($.cookie(Sign.cookieName)!="close"){
                Sign.check();
            }
        }
    },
    check:function(){
        $.ajax({
            url: "/static/sign/sign.php?type=check&callback=?",
            type: "GET",
            dataType: "json",
            success: function(data){
                var cookietime = new Date();
                if(data["status"]=="success"){
                    Sign.html();
                    $.cookie(Sign.cookieName, "open");
                }else if(data["message"]=="SIGN_NOT_OPEN"){
                    //未开启签到系统，则暂时关闭签到功能
                    //cookietime.setTime(cookietime.getTime()+(6*60*60*1000));
                    //$.cookie("Sign", "close", {expires:cookietime});
                    $.cookie(Sign.cookieName, "close");
                }else if(data["message"].substr(0, 7)=="IS_SIGN"){
                    cookietime.setTime(cookietime.getTime()+(parseInt(data["message"].substr(8))*1000-60000));
                    $.cookie(Sign.cookieName, "close", {expires:cookietime});
                }else if(data["message"].substr(0, 9)=="NEXT_TIME"){
                    Sign.html();
                    cookietime.setTime(cookietime.getTime()+(parseInt(data["message"].substr(10))*1000-60000));
                    $.cookie(Sign.cookieName, "open", {expires:cookietime});
                }
            }
        });
    },
    html:function(){
        Sign.div.find("img").stop().animate({width: "50px", height: "52px"}, 1000);
        Sign.div.find(".sign-block").stop().animate({width: "50px", height: "50px"}, 1000, function(){
            Sign.timeout = setTimeout(function(){
                Sign.div.find("img").stop().animate({width: "25px", height: "26px"}, "fast");
                Sign.div.find(".sign-block").stop().animate({width: "25px", height: "25px"}, "fast");
            }, 5000);
        });
        Sign.div.hover(function(){
            clearTimeout(Sign.timeout);
            $(this).find("img").stop().animate({width: "307px", height: "319px"}, 500); 
            $(this).find(".sign-block").stop().animate({width: "307px", height: "307px"}, 500); 
        }, function(){
            $(this).find("img").stop().animate({width: "50px", height: "52px"}, "fast");
            $(this).find(".sign-block").stop().animate({width: "50px", height: "50px"}, "fast", function(){
                Sign.timeout = setTimeout(function(){
                    Sign.div.find("img").stop().animate({width: "25px", height: "26px"}, "fast");
                    Sign.div.find(".sign-block").stop().animate({width: "25px", height: "25px"}, "fast");
                }, 5000);
            });
        });
    },
    guest:function(isSmall){
        if(isSmall){
            Sign.div.find("img").stop().animate({width: "50px", height: "52px"}, 1000);
            Sign.div.find(".sign-block").stop().animate({width: "50px", height: "50px"}, 1000);
        }else{
            Sign.div.find("img").stop().animate({width: "307px", height: "319px"}, 1000);
            Sign.div.find(".sign-block").stop().animate({width: "307px", height: "307px"}, 1000, function(){
                Sign.timeout = setTimeout(function(){
                    Sign.div.find("img").stop().animate({width: "50px", height: "52px"}, "fast");
                    Sign.div.find(".sign-block").stop().animate({width: "50px", height: "50px"}, "fast");
                    $.cookie(Sign.cookieName, true);
                }, 5000);
            });
        }
        Sign.div.hover(function(){
            clearTimeout(Sign.timeout);
            $(this).find("img").stop().animate({width: "307px", height: "319px"}, 500); 
            $(this).find(".sign-block").stop().animate({width: "307px", height: "307px"}, 500); 
        }, function(){
            $(this).find("img").stop().animate({width: "50px", height: "52px"}, "fast");
            $(this).find(".sign-block").stop().animate({width: "50px", height: "50px"}, "fast");
            Sign.defaultSmall||$.cookie(Sign.cookieName, true);
        });
    },
    sign:function(){
        var signLeft = ($(window).width()-716)/2;
        var signTop = $(window).height()/4;
        layer.open({
            type: 2,
            title: "会员签到",
            content: "static/sign/index.html",
            area: ["700px", "285px"]
        });
        if(Sign.cookieName!="Sign-guest"){
            Sign.div.unbind("mouseenter").unbind("mouseleave");
            Sign.div.find("img").stop().animate({width: "0px", height: "0px"}, "fast"); 
            Sign.div.find(".sign-block").stop().animate({width: "0px", height: "0px"}, "fast"); 
            $.cookie(Sign.cookieName, null);
        }
    }
};