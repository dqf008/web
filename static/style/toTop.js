$(function(){
    // $(window).on("resize", function(){
    //     $(".toTop").css("top", $(this).scrollTop()+$(window).height()-66)
    // });
    $(window).on("scroll", function(){
        if($(this).scrollTop()>($(this).height()/2)){
            $(".toTop:hidden").stop().fadeIn("fast");
        }else{
            $(".toTop:visible").stop().fadeOut("fast");
        }
    });
    $(".toTop a").on("click", function(){
        $("html, body").animate({scrollTop:0}, "fast");
    });
});