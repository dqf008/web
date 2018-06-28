$(document).ready(function() {
    var browser=navigator.appName;
    var b_version=navigator.appVersion;
    var version=b_version.split(";"); 
    if(version&&version.length>1){
        var trim_Version=version[1].replace(/[ ]/g,""); 
        if(browser=="Microsoft Internet Explorer"&&(trim_Version=="MSIE6.0"||trim_Version=="MSIE7.0")){
            $("#iealert").show();
            $("#iealertX").click(function(){
                $("#iealert").hide();
            });
        }
    }
/*    var ua = navigator.userAgent || " "; 
    var pageType= $.cookie('pageType'); 
    if ((ua.match(/(iPhone|iPod|Android|ios)/i))
        && ! ((ua.indexOf("iPad") > 0   //ipad
        || (ua.indexOf("Android") > 0 && ua.indexOf("Mobile") == -1) //android pad
        ) && !pageType)) { 
        $("#mobileToPcAlert").show();
        $("#mobileAlertX").click(function(){$("#mobileToPcAlert").hide()});
    }*/ 
});
/*(function(){
    var ua = navigator.userAgent  || " "; 
    var pageType=$.cookie('pageType'); 
    if ( (ua.indexOf("iPad") > 0    //ipad
        || (ua.indexOf("Android") > 0 && ua.indexOf("Mobile") == -1) //android pad
        ) && !pageType
        ){
        $("#popDiv").show();
        $("#popIframe").show();
        $("#popBg").show();
    } 
})();
function padJumpToPage(type){
    $.cookie('pageType', type);
    top.window.location.href = "PageChange@type=" + type;
}*/