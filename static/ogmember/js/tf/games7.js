// JScript File

$().ready(function () {
    SetupLanguageSelector();
    SetupServicesSelector();
    SetupBalanceSelector();
    SetupLogOut();
});

function SetupLanguageSelector() {
    $(".LanguageSelector dt").click(function () {
        if ($(".LanguageSelector dt").hasClass("active"))
            $(".LanguageSelector dt").removeClass("active");
        else
            $(".LanguageSelector dt").addClass("active");

        $(".LanguageSelector dd ul").toggle();
    });

    $(document).bind('click', function (e) {
        var $clicked = $(e.target);
        if (!$clicked.parents().hasClass("LanguageSelector")) {
            $(".LanguageSelector dt").removeClass("active");
            $(".LanguageSelector dd ul").hide();
            $(".LanguageSelector .LanguageSelectorTitle").removeClass("Hover");
            $(".LanguageSelector .LanguageSelectorHeaderIcon").removeClass("Hover");
        }

        if ($(".DownloadPopupContainer[style*='display: block']").length !== 0) {
            if (!$clicked.hasClass("DownloadPopupContainer") && !$clicked.parents().hasClass("DownloadPopupContainer")) {
                bet365.popups.hideDialog('.DownloadPopupContainer');
            }
        }
    });

    $(".LanguageSelector").hover
    (
        function () {
            $(this).find(".LanguageSelectorTitle").addClass("Hover");
            $(this).find(".LanguageSelectorHeaderIcon").addClass("Hover");
        },
        function () {
            if (!$("dt", this).hasClass("active")) {
                $(this).find(".LanguageSelectorTitle").removeClass("Hover");
                $(this).find(".LanguageSelectorHeaderIcon").removeClass("Hover");
            }
        }
    );

    $(".firstRowendOfRow", ".LanguageSelector").hover(function () {
        $(this).parents(".LanguageSelector").find(".LanguageSelectorListIcon").removeClass("LanguageSelectorListIconInactive").addClass("LanguageSelectorListIconActive");
    },
        function () {
            $(this).parents(".LanguageSelector").find(".LanguageSelectorListIcon").removeClass("LanguageSelectorListIconActive").addClass("LanguageSelectorListIcon");
        }
    );
    }

    function SetupBalanceSelector() {
        $(".BalanceSelector dt").click(function () {
			
            if ($(".BalanceSelector dt").hasClass("active")) {
                $(".BalanceSelector dt").removeClass("active");
            }
            else {
                $(".BalanceSelector dt").addClass("active");
                
            }

            $(".BalanceSelector dd ul").toggle();
        });

        $(document).bind('click', function (e) {
            var $clicked = $(e.target);
            if (!$clicked.parents().hasClass("BalanceSelector") && !$clicked.parents().hasClass("welcome")) {
                $(".BalanceSelector dt").removeClass("active");
                $(".BalanceSelector ul").hide();
                $(".BalanceSelector .BalanceSelectorTitle").removeClass("Hover");
                $(".BalanceSelector .BalanceSelectorHeaderIcon").removeClass("Hover");
            }

            if ($(".DownloadPopupContainer[style*='display: block']").length !== 0) {
                if (!$clicked.hasClass("DownloadPopupContainer") && !$clicked.parents().hasClass("DownloadPopupContainer")) {
                    bet365.popups.hideDialog('.DownloadPopupContainer');
                }
            }
        });

        $(".BalanceSelector").hover
    (
        function () {
            $(this).find(".BalanceSelectorTitle").addClass("Hover");
            $(this).find(".BalanceSelectorHeaderIcon").addClass("Hover");
        },
        function () {
            if (!$("dt", this).hasClass("active")) {
                $(this).find(".BalanceSelectorTitle").removeClass("Hover");
                $(this).find(".BalanceSelectorHeaderIcon").removeClass("Hover");
            }
        }
    );

        $(".firstRow", ".BalanceSelector").hover(function () {
            $(this).parents(".BalanceSelector").find(".BalanceSelectorListIcon").removeClass("BalanceSelectorListIconInactive").addClass("BalanceSelectorListIconActive");
        },
        function () {
            $(this).parents(".BalanceSelector").find(".BalanceSelectorListIcon").removeClass("BalanceSelectorListIconActive").addClass("BalanceSelectorListIcon");
        }
    );
    }

    function SetupLogOut() {
        $("div.HeaderWrapper a.LogOut").click(function (e) {
            e.preventDefault();
            bet365.Header.sessonLogOut();
            return false;
        });
    }

function SetupServicesSelector() {
    $(".ServicesSelector dt").click(function () {
        if ($(".ServicesSelector dt").hasClass("active"))
            $(".ServicesSelector dt").removeClass("active");
        else
            $(".ServicesSelector dt").addClass("active");

        $(".ServicesSelector dd ul").toggle();
        $(".ServicesSelectorTitle", $(this)).addClass("Hover");
        $(".ServicesSelectorHeaderIcon", $(this)).addClass("Hover");
    });

    $(document).bind('click', function (e) {
        var $clicked = $(e.target);
        if (!$clicked.parents().hasClass("ServicesSelector")) {
            $(".ServicesSelector dt").removeClass("active");
            $(".ServicesSelector dd ul").hide();
            $(".ServicesSelector .ServicesSelectorTitle").removeClass("Hover");
            $(".ServicesSelector .ServicesSelectorHeaderIcon").removeClass("Hover");
        }

        if ($(".DownloadPopupContainer[style*='display: block']").length !== 0) {
            if (!$clicked.hasClass("DownloadPopupContainer") && !$clicked.parents().hasClass("DownloadPopupContainer")) {
                bet365.popups.hideDialog('.DownloadPopupContainer');
            }
        }
    });

    $(".ServicesSelector ul li a").click(function () {
        $(".ServicesSelector dt").removeClass("active");
        $(".ServicesSelector dd ul").hide();
    });

    var listWidth = $(".ServicesSelector ul").width() - 20;

    $(".ServicesSelector ul li a").css("width", listWidth + "px");

    $(".ServicesSelector").hover
    (
        function () {
            $(this).find(".ServicesSelectorTitle").addClass("Hover");
            $(this).find(".ServicesSelectorHeaderIcon").addClass("Hover");
        },
        function () {
            if (!$("dt", this).hasClass("active")) {
                $(this).find(".ServicesSelectorTitle").removeClass("Hover");
                $(this).find(".ServicesSelectorHeaderIcon").removeClass("Hover");
            }
        }
    );

    $(".firstRow", ".ServicesSelector").hover(function () {
        $(this).parents(".ServicesSelector").find(".ServicesSelectorListIcon").removeClass("ServicesSelectorListIconInactive").addClass("ServicesSelectorListIconActive");
    },
        function () {
            $(this).parents(".ServicesSelector").find(".ServicesSelectorListIcon").removeClass("ServicesSelectorListIconActive").addClass("ServicesSelectorListIcon");
        }
    );

    }



var timerID = null;
var clock = null;
var clockSpan;
var offset=0;

function fav(sURL, title) 
{ 
    if (window.sidebar) 
    {        
        window.sidebar.addPanel(title, sURL, '');
    } 
    else if (window.external) 
    {        
        window.external.AddFavorite(sURL , title);    
    } 
    else if (window.opera && window.print) 
    {
     
        var e = document.createElement('a');
         e.setAttribute('href',sURL);
         e.setAttribute('title',title);
         e.setAttribute('rel','sidebar');
         e.click();  
    }
};

function addbet365tofav(sURL, title)
{ 		 			 										
    window.external.AddFavorite( sURL, title ); 
};

function Start(yy,mo,da,hh,mm,ss)
{    
    
/*

    Removed old version and added one that checks load state (for very slow machines that seem to try to start the js before the page is rendered
             
	clock=new Date(yy,mo,da,hh,mm,ss);
	clockSpan=document.getElementById('clock');
	if(typeof clockSpan!='undefined'){UpdateTimer(1000);}
 
*/ 	
   
    var oDoc = document;
    if(IsDocLoaded(oDoc))
    {
        clock=new Date(yy,mo,da,hh,mm,ss);

        if (clock.getHours() == 0 && hh > 0)
        {
            offset = 1;
        }

	    clockSpan=document.getElementById('clock');
	    if(typeof clockSpan!='undefined'){UpdateTimer(1000);}
    }
    else
    {
        setTimeout("Start(" + yy + "," + mo + "," + da + "," + hh + "," + mm + "," + ss + ");", 1000);
    }

};

function UpdateTimer(increase)
{
    var h;
    var m;
    var s;

	if(timerID)
	{
		clearTimeout(timerID);
	};

	clock.setTime(clock.getTime()+increase);
	
	if(clock.getHours()<10)
	{
		h='0'+(clock.getHours()+offset);
	}
	else
	{
		h=(clock.getHours() + offset);
	};
	
	if(clock.getMinutes()<10)
	{
		m='0'+clock.getMinutes();
	}
	else
	{
		m=clock.getMinutes();
	};
	
	if(clock.getSeconds()<10)
	{
		s='0'+clock.getSeconds();
	}
	else
	{
		s=clock.getSeconds();
	};
	
	clockSpan.innerHTML=""+h+":"+m+":"+s;
	
	timerID=setTimeout("UpdateTimer(1000)",1000);
	
};


function closeWindows ()
{
	for (var i in windows) {
		if (windows[i]) {
			windows[i].close();
		}
	}
}


function showMoreInfo(targetName, topPos, Persist, persistName)
{
    var targetControl;
    var persistControl;
	targetControl=document.getElementById(targetName);
	persistControl=document.getElementById(persistName);

    if (Persist == "True") 
    {
        persistControl.value = "True";
    }
    targetControl.style.display = "block";
    targetControl.style.top = topPos + "px";

}

function findTop(htmlElementId) {
    var obj;
	obj=document.getElementById(htmlElementId);	
    var curtop = 0;
    
	if (obj.offsetParent) {
		do {
			curtop += obj.offsetTop;
		} while (obj = obj.offsetParent);
	}
	return curtop;
}

function findLeft(htmlElementId) {
    var obj;
	obj=document.getElementById(htmlElementId);	
    var curleft = 0;
    
	if (obj.offsetParent) {
		do {
			curleft += obj.offsetLeft;
		} while (obj = obj.offsetParent);
	}
	return curleft;
}

function showMoreInfoDynamicPos(targetName, parentButtonName, columnNumber, totalColumns, Persist, persistName)
{
    var targetControl;
    var parentControl;
    var persistControl;
	targetControl=document.getElementById(targetName);
	parentControl=document.getElementById(parentButtonName);
	persistControl=document.getElementById(persistName);
   
    if (Persist == "True") 
    {
        persistControl.value = "True";
    }
      
    targetControl.style.display = "block";
    
    var newTopPos = 0;
    var newLeftPos = 0;
    
    if (totalColumns == 3 && columnNumber != 3)
    {
        newTopPos = findTop(parentButtonName) - 110 - targetControl.offsetHeight;
        newLeftPos = findLeft(parentButtonName) + 1;
    }
    else if (totalColumns == 3 && columnNumber == 3)
    {
        newTopPos = findTop(parentButtonName) - 110 - targetControl.offsetHeight;
        newLeftPos = findLeft(parentButtonName) - targetControl.offsetWidth + parentControl.offsetWidth;
    }
    else if (totalColumns == 2 && columnNumber == 1)
    {
        newTopPos = findTop(parentButtonName) - 111 - targetControl.offsetHeight;
        newLeftPos = findLeft(parentButtonName) + 1;
    }
    else if (totalColumns == 2 && columnNumber == 2)
    {
        newTopPos = findTop(parentButtonName) - 111 - targetControl.offsetHeight;
        newLeftPos = findLeft(parentButtonName) + 1 - targetControl.offsetWidth + parentControl.offsetWidth;
    }
   
    targetControl.style.top = newTopPos + "px";      
    targetControl.style.left = newLeftPos + "px";      
}

function showMoreInfoDynamicPos(targetName, parentButtonName, columnNumber, totalColumns, imageURL, imageClientId, Persist, persistName)
{
    var targetControl;
    var parentControl;
    var persistControl;
	var imageControl;
	
	targetControl=document.getElementById(targetName);
	parentControl=document.getElementById(parentButtonName);
	persistControl=document.getElementById(persistName);
    imageControl=document.getElementById(imageClientId);
    
    if (imageControl.src == null || imageControl.src != imageURL)
    {
        imageControl.src = imageURL
    }
   
    if (Persist == "True") 
    {
        persistControl.value = "True";
    }
      
    targetControl.style.display = "block";
    
    var newTopPos = 0;
    var newLeftPos = 0;
    
    if (totalColumns == 3 && columnNumber != 3)
    {
        newTopPos = findTop(parentButtonName) - 110 - targetControl.offsetHeight;
        newLeftPos = findLeft(parentButtonName) + 1;
    }
    else if (totalColumns == 3 && columnNumber == 3)
    {
        newTopPos = findTop(parentButtonName) - 110 - targetControl.offsetHeight;
        newLeftPos = findLeft(parentButtonName) - targetControl.offsetWidth + parentControl.offsetWidth;
    }
    else if (totalColumns == 2 && columnNumber == 1)
    {
        newTopPos = findTop(parentButtonName) - 111 - targetControl.offsetHeight;
        newLeftPos = findLeft(parentButtonName) + 1;
    }
    else if (totalColumns == 2 && columnNumber == 2)
    {
        newTopPos = findTop(parentButtonName) - 111 - targetControl.offsetHeight;
        newLeftPos = findLeft(parentButtonName) + 1 - targetControl.offsetWidth + parentControl.offsetWidth;
    }
   
    targetControl.style.top = newTopPos + "px";      
    targetControl.style.left = newLeftPos + "px";      
}

function hideMoreInfo(targetName, persistName, overridePersist)
{
    var targetControl;
    var persistControl;
	targetControl=document.getElementById(targetName);
	persistControl=document.getElementById(persistName);

    if (persistControl.value == "False" || overridePersist == "True")
    {
        targetControl.style.display = "none";
        persistControl.value = "False";
    }
}

//window.onresize= resizeIE6;

//function resizeIE6() {
//    if (navigator.userAgent.toLowerCase().indexOf('msie 6') != -1)
//    {
//        location.reload(true);
//    }
//}


var sessionMonitor = {
    cookieName: 'bet365_OpenAccount_Session',
    interval: null,
    cookiePattern: null,
    start: function (expireMins) {
        var d = new Date();
        if (typeof (expireMins) == 'undefined') { expireMins = 180; }
        d = new Date(d.getTime() + (expireMins * 60000));
        var cookie = (this.cookieName + '=True;');
        cookie += ('path=/');
        document.cookie = cookie;
        this.cookiePattern = new RegExp('(^|; )' + this.cookieName + '=True');
        var self = this;
        this.interval = setInterval(function () { self.check() }, 1000);
    },
    check: function () {
        var c = document.cookie;
        if (!this.cookiePattern.test(c)) {
            clearInterval(this.interval);
            document.cookie = this.cookieName + '=;expires=' + new Date().toGMTString() + ";path=/";
            window.location = window.location;
        } 
    }


}


var cookieHasNotYetBeenChecked = true;
var cookieHasExisted = false;

function setCookie(expiryMins)
{
    var exdate=new Date();

    if((expiryMins != null) && 
    (expiryMins > 0))
    {
        exdate.setTime(exdate.getTime() + (expiryMins * 60 * 1000));
    }
    else
    {
        var currenthours = exdate.getHours();      
        currenthours += 3;            
        if(currenthours > 23)
        {
            currenthours = currenthours - 24;     
            exdate.setDate(exdate.getDate() + 1);  
        }                      
        exdate.setHours(currenthours);
    }
    
    document.cookie= "bet365_OpenAccount_Session=True;expires="+exdate.toGMTString() + ";path=/";
    
};

function checkCookie()
{
    
};

function getCookie(c_name)
{
if (document.cookie.length>0)
  {
  c_start=document.cookie.indexOf(c_name + "=")
    if (c_start!=-1)
    { 
    c_start=c_start + c_name.length+1 
    c_end=document.cookie.indexOf(";",c_start)
    if (c_end==-1) c_end=document.cookie.length
    return unescape(document.cookie.substring(c_start,c_end))
    } 
  }
  return "";
};

function IsDocLoaded(oDoc)
{
    var sBsr = bet365.GetBrowser();
    var sState = false;

    if (sBsr =='FIREFOX')
    {
          sState = true;
    }
    else if (sBsr =='SAFARI')
    {
          if (/loaded|complete/.test(document.readyState))
          {
                sState = true;
          }
    }
    else
    {
          if(oDoc.readyState=="complete" || oDoc.readyState=="interactive")
          {
                sState = true;
          }
    }

    return sState;

};

function setElementPositionWithinMultiBanner(targetName, parentName, XPos, YPos) 
{
    var targetControl;
    var parentControl;
    
    targetControl=document.getElementById(targetName);
	parentControl=document.getElementById(parentName);
	
    var newTopPos = 0;
    var newLeftPos = 0;
   
    newTopPos = findTop(parentName) + YPos - 111;
    newLeftPos = findLeft(parentName) + XPos;
    
    targetControl.style.top = newTopPos + "px";      
    targetControl.style.left = newLeftPos + "px";    
}

function setElementPositionWithinMultiBannerOnHomePage(targetName, parentName, XPos, YPos, headerOffset) 
{      
    var newTopPos = 0;
    var newLeftPos = 0;    
    var leftMargin = 0;
    
    var targetControl=document.getElementById(targetName);
    var parentControl=document.getElementById(parentName);
               
    targetControl.style.top = YPos + "px";      
    targetControl.style.left = XPos + "px";    
}

function setElementPositionWithinMultiBannerOnLandingPage(targetName, parentName, XPos, YPos, headerOffset) 
{

    var within2003 = false;
    if(navigator.userAgent.toLowerCase().indexOf("windows nt 5.2") > -1)
    {
        within2003 = true;
    }
    
    var targetControl;
    var parentControl;
    
    targetControl=document.getElementById(targetName);
	parentControl=document.getElementById(parentName);
	
    var newTopPos = 0;
    var newLeftPos = 0;

    var browser = bet365.GetBrowser();    
    
    var myWidth = 0, myHeight = 0;
    if( typeof( window.innerWidth ) == 'number' ) 
    {
        //Non-IE        
        if(browser == 'OPERA')
        {
            myWidth = window.innerWidth - 17;
            myHeight = window.innerHeight - 17; 
        }
        else
        {
            myWidth = window.innerWidth;
            myHeight = window.innerHeight;     
        }
    } 
    else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
    //IE 6+ in 'standards compliant mode'
    myWidth = document.documentElement.clientWidth;
    myHeight = document.documentElement.clientHeight;    
    } 
    else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
    //IE 4 compatible
    myWidth = document.body.clientWidth;
    myHeight = document.body.clientHeight;
    }
    
    var leftMargin = 0;
    var mainDiv=document.getElementById("ctl00_MainPageContainer");
	
    if(myWidth > 960)
    {         
        if(myWidth % 2 != 0)
        {                    
            if(browser == 'SAFARI' || browser == 'CHROME')
            {                    
                if(document.height <= window.innerHeight)
                {                    
                    myWidth -= 1;
                }                    
            }    
            if(browser == 'OPERA')
            {                    
                if((mainDiv.offsetHeight + headerOffset) > window.innerHeight)
                {        
                    myWidth -= 1;  
                }                    
            }      
            if(browser == 'FIREFOX')
            {                    
                if((mainDiv.offsetHeight + headerOffset) > window.innerHeight)
                {        
                    myWidth -= 1;  
                }                    
            }      
            if(browser == 'IE' || browser == 'IE6')
            {      
                myWidth -= 1;               
            }
            if(browser == 'IE8' && !within2003)
            {
                myWidth -= 1;
            }
        }       
        leftMargin = Math.round((myWidth - 960) / 2);
    }    
   
    if(browser == 'SAFARI' && document.height > window.innerHeight)
    {
        leftMargin -= 8;
    }    
    
    if(browser == 'CHROME' && document.height > window.innerHeight)
    {
        leftMargin -= 9;
    }    
        
    if(browser == 'OPERA' && (mainDiv.offsetHeight + headerOffset) <= window.innerHeight)
    {        
        leftMargin += 8;
    }
    
    if(browser == 'FIREFOX' && (mainDiv.offsetHeight + headerOffset) > window.innerHeight)
    {        
        leftMargin -= 8;
    }   
           
    //Dont need to use header offset on landing page as whole page is in 1 main absolute div
    
    newTopPos = findTop(parentName) + YPos;
    newLeftPos = findLeft(parentName) + XPos - leftMargin;
    
    targetControl.style.top = newTopPos + "px";      
    targetControl.style.left = newLeftPos + "px";    
}

function setElementPositionWithinMultiBannerOnLandingPageVersion2(targetName, parentName, XPos, YPos, headerOffset) 
{

    var within2003 = false;
    if(navigator.userAgent.toLowerCase().indexOf("windows nt 5.2") > -1)
    {
        within2003 = true;
    }
    
    var targetControl;
    var parentControl;
   
    targetControl=document.getElementById(targetName);
	parentControl=document.getElementById(parentName);
	
    var newTopPos = 0;
    var newLeftPos = 0;
            
    //Dont need to use header offset on landing page as whole page is in 1 main absolute div
    
    var outerTopPos = findTop("ctl00_SectionAPlaceHolder_SectionAControl_SectionAOuterContainer");
    var outerLeftPos = findLeft("ctl00_SectionAPlaceHolder_SectionAControl_SectionAOuterContainer");
    newTopPos = findTop(parentName) + YPos - outerTopPos;
    newLeftPos = findLeft(parentName) + XPos - outerLeftPos;

    var browser = bet365.GetBrowser();    
    if(browser == 'OPERA')
    {        
        newLeftPos -= 3;
        newTopPos -= 3;
    }
    else if(browser == 'IE8' && !within2003)
    {
        newLeftPos -= 3;
        newTopPos -= 3;
    }
               
    targetControl.style.top = newTopPos + "px";      
    targetControl.style.left = newLeftPos + "px";    
}

function verticalCentreModalPopup(modalPopupBehaviour, panelDivClientId, safariWidth)
{
    var modalPopupObj = $find(modalPopupBehaviour);
    if(modalPopupObj != null)
    {
        modalPopupObj.show();

        var browser = bet365.GetBrowser();
        if(browser == 'OPERA')
        {         
            var sheight = window.innerHeight / 2;
            var panelDiv = document.getElementById(panelDivClientId);
            sheight = sheight - (panelDiv.offsetHeight / 2);        
            panelDiv.style.top = sheight + 'px';
        }  
        if(browser == 'SAFARI')
        {  
            var panelDiv = document.getElementById(panelDivClientId);
            panelDiv.style.width = safariWidth + 'px';
            
            var sWidth = window.innerWidth / 2;
            sWidth = sWidth - (panelDiv.offsetWidth / 2);        
            panelDiv.style.left = sWidth + 'px';             
        }
        if(navigator.userAgent.toLowerCase().indexOf("msie 6.") != -1)
        {
            var headerDiv = document.getElementById("ctl00_HeaderPlaceHolder_HeaderControl_HeaderContainer");
            if(headerDiv != null)
            {
            
                //home page header found so offset Div in IE 6
                var sheight = document.documentElement.clientHeight / 2;
                var panelDiv = document.getElementById(panelDivClientId);
                if(panelDiv != null)
                {
                    sheight = sheight - (panelDiv.offsetHeight / 2);
                    sheight = sheight - headerDiv.offsetHeight;
                                                    
                    var scrollTop = document.body.parentElement.scrollTop;
                    if(scrollTop > 0)
                    {
                        sheight += scrollTop;
                    }
     
                    panelDiv.style.top = sheight + 'px';                
                   
                    window.onscroll = function ()
                    {                    
                        var sheight = document.documentElement.clientHeight / 2;
                        var panelDiv = document.getElementById(panelDivClientId);
                        if(panelDiv != null)
                        {
                            sheight = sheight - (panelDiv.offsetHeight / 2);
                            sheight = sheight - headerDiv.offsetHeight;
                            
                            var scrollTop = document.body.parentElement.scrollTop;
                            if(scrollTop > 0)
                            {
                                sheight += scrollTop;
                            }
             
                            panelDiv.style.top = sheight + 'px'; 
                        }       
                    }
                }
            }
        } 
    }     
}

function is_child_of(parent, child) {
	if( child != null ) {			
		while( child.parentNode ) {
			if( (child = child.parentNode) == parent ) {
				return true;
			}
		}
	}
	return false;
}

function fixOnMouseOut(element, event, JavaScript_code) {
	var current_mouse_target = null;
	if( event.toElement ) {				
		current_mouse_target 			 = event.toElement;
	} else if( event.relatedTarget ) {				
		current_mouse_target 			 = event.relatedTarget;
	}
	if( !is_child_of(element, current_mouse_target) && element != current_mouse_target ) {
		eval(JavaScript_code);
	}
}

function CountDown(year1, month1, day1, hour1, minute1, second1, year2, month2, day2, hour2, minute2, second2, clientid)
{
    var Today = new Date();
    var Target_Date = new Date(year1, month1-1, day1, hour1, minute1, second1);
    var Current_Date = new Date(year2, month2-1, day2, hour2, minute2, second2);
    var Time_Left = (Target_Date.getTime() - Current_Date.getTime())
    //Get 1 hour in milliseconds
    var one_hour=1000*60*60;
    //Get 1 minute in milliseconds
    var one_minute=1000*60;
    //Get 1 second in milliseconds
    var one_second=1000;
    
    var hours = Math.floor(Time_Left / one_hour);
    Time_Left -= (hours * one_hour);
    var minutes = Math.floor(Time_Left / one_minute)
    Time_Left -= (minutes * one_minute);
    var seconds = Math.floor(Time_Left/one_second);
    
   if (second2 > 58)
   {
        if (minute2 > 58)
        {
            minute2 = 0;
            hour2 = hour2 + 1;
        }
        else
        {
            second2 = 0;
            minute2 = minute2+1;
        }
   }
   else
   {
        second2 = second2 + 1;
   }
   
    var timerControl = document.getElementById(clientid);
    
    if(typeof(timerControl) !== "undefined" && timerControl !== null)
	{
        if(hours < 10)
        {
            if (hours < 1)
            {
                timerControl.innerHTML = '00:';
            }
            else
            {
                timerControl.innerHTML = '0' + hours + ':';
            }
        }
        else
        {
            timerControl.innerHTML = hours + ':';
        }
        
        if(minutes < 10)
        {
            timerControl.innerHTML += '0';
        }
        timerControl.innerHTML += minutes  + ':';
        
        if(seconds < 10)
        {
            timerControl.innerHTML += '0';
        }
        timerControl.innerHTML += seconds  + 'hrs';
    }
    
    setTimeout("CountDown(" + year1 + "," + month1 + "," + day1 + "," + hour1 + "," + minute1 +  "," + second1 + "," + year2 + "," + month2 + "," + day2 + "," + hour2 + "," + minute2 +  "," + second2 + ",'" + clientid + "');", 1000);
}

function HighlightGamesPod(headerImageWrapperId, playNowContainerId, categoryAndNameCellId)
{
    var headerImageWrapper = document.getElementById(headerImageWrapperId);
    var playNowContainer = document.getElementById(playNowContainerId);
    var categoryAndNameCell = document.getElementById(categoryAndNameCellId);
    
    headerImageWrapper.style.borderColor = '#FFDF1B';
    playNowContainer.style.borderBottomColor = '#FFDF1B';
    categoryAndNameCell.style.borderBottomColor = '#FFDF1B';
    
    return false;
}

function UnHighlightGamesPod(headerImageWrapperId, playNowContainerId, categoryAndNameCellId)
{
    var headerImageWrapper = document.getElementById(headerImageWrapperId);
    var playNowContainer = document.getElementById(playNowContainerId);
    var categoryAndNameCell = document.getElementById(categoryAndNameCellId);
    
    headerImageWrapper.style.borderColor = '#585858';
    playNowContainer.style.borderBottomColor = '#747474';
    categoryAndNameCell.style.borderBottomColor = '#747474';
    
    return false;
}

function HighlightGamesPodForGames(headerImageWrapperId, playNowContainerId, categoryAndNameCellId)
{
    var headerImageWrapper = document.getElementById(headerImageWrapperId);
    var playNowContainer = document.getElementById(playNowContainerId);
    var categoryAndNameCell = document.getElementById(categoryAndNameCellId);
        
    if(typeof(headerImageWrapper) !== "undefined" && headerImageWrapper !== null)
	{
        headerImageWrapper.style.borderColor = '#FFDF1B';
    }
    
    if(typeof(categoryAndNameCell) !== "undefined" && categoryAndNameCell !== null)
	{
        categoryAndNameCell.style.textDecoration = 'underline';
    }
    
    if(typeof(playNowContainer) !== "undefined" && playNowContainer !== null)
	{
        playNowContainer.style.backgroundPosition = 'bottom';
    }
    
    return false;
}

function HighlightGamesPodForGamesV2(headerImageWrapperId, playNowContainerId, topOffset, categoryAndNameCellId)
{
    var headerImageWrapper = document.getElementById(headerImageWrapperId);
    var playNowContainer = document.getElementById(playNowContainerId);
    var categoryAndNameCell = document.getElementById(categoryAndNameCellId);
        
    if(typeof(headerImageWrapper) !== "undefined" && headerImageWrapper !== null)
	{
        headerImageWrapper.style.borderColor = '#FFDF1B';
    }
    
    if(typeof(categoryAndNameCell) !== "undefined" && categoryAndNameCell !== null)
	{
        categoryAndNameCell.style.textDecoration = 'underline';
    }
    
    if(typeof(playNowContainer) !== "undefined" && playNowContainer !== null)
	{
        playNowContainer.style.marginTop = '-' + topOffset + 'px';
    }
    
    return false;
}

function UnHighlightGamesPodForGames(headerImageWrapperId, playNowContainerId, categoryAndNameCellId)
{
    var headerImageWrapper = document.getElementById(headerImageWrapperId);
    var playNowContainer = document.getElementById(playNowContainerId);
    var categoryAndNameCell = document.getElementById(categoryAndNameCellId);
    
    if(typeof(headerImageWrapper) !== "undefined" && headerImageWrapper !== null)
	{
        headerImageWrapper.style.borderColor = '#064532';
    }
    
    if(typeof(categoryAndNameCell) !== "undefined" && categoryAndNameCell !== null)
	{
        categoryAndNameCell.style.textDecoration = 'none';
    }
    
    if(typeof(playNowContainer) !== "undefined" && playNowContainer !== null)
	{
        playNowContainer.style.backgroundPosition = 'top';
    }
    
    return false;
}

function UnHighlightGamesPodForGamesV2(headerImageWrapperId, playNowContainerId, categoryAndNameCellId)
{
    var headerImageWrapper = document.getElementById(headerImageWrapperId);
    var playNowContainer = document.getElementById(playNowContainerId);
    var categoryAndNameCell = document.getElementById(categoryAndNameCellId);
    
    if(typeof(headerImageWrapper) !== "undefined" && headerImageWrapper !== null)
	{
        headerImageWrapper.style.borderColor = '#064532';
    }
    
    if(typeof(categoryAndNameCell) !== "undefined" && categoryAndNameCell !== null)
	{
        categoryAndNameCell.style.textDecoration = 'none';
    }
    
    if(typeof(playNowContainer) !== "undefined" && playNowContainer !== null)
	{
        playNowContainer.style.marginTop = '0px';
    }
    
    return false;
}
    
function DisableControl(clientId)
{
    var controlToDisable = document.getElementById(clientId);
    if(controlToDisable != null)
    {
        controlToDisable.onclick = function ()
        {
            return false;
        }
    }
}

function GamesHelpConfigureOuterPadding(leftContainerId, rightContainerId, outerContainerId)
{
    var leftContainer = document.getElementById(leftContainerId);
    var rightContainer = document.getElementById(rightContainerId);
    var outerContainer = document.getElementById(outerContainerId);
       
    if(leftContainer != null && rightContainer != null && outerContainer != null)
    {
        if(leftContainer.offsetHeight > rightContainer.offsetHeight)
        {
            outerContainer.style.paddingBottom = "17px";
        }
        else
        {
            outerContainer.style.paddingBottom = "6px";
        }
    }
}

function ResizeContentTableCell(mainCellId, finalCellId)
{
    var mainCell = document.getElementById(mainCellId);
    var finalCell = document.getElementById(finalCellId);
    ApplyContentTableCellSizes(mainCell, finalCell);
}

function ApplyContentTableCellSizes(mainCell, finalCell)
{
    var browser = bet365.GetBrowser();
    if(browser == "SAFARI")
    {
        if(mainCell.offsetHeight > finalCell.offsetHeight + 2)
        {
            var initialMainCellHeight = mainCell.offsetHeight;  
            finalCell.style.height = initialMainCellHeight + "px";   
            var difference = mainCell.offsetHeight - initialMainCellHeight;           
            finalCell.style.height = (finalCell.clientHeight - difference) + "px"; 
        }
    }
    else
    {   
        if(mainCell.clientHeight > finalCell.clientHeight + 2)
        { 
            var initialMainCellHeight = mainCell.clientHeight;  
            finalCell.style.height = initialMainCellHeight + "px";   
            var difference = mainCell.clientHeight - initialMainCellHeight;           
            finalCell.style.height = (finalCell.clientHeight - difference) + "px";
        }       
    }
}

function ajaxRequest()
{
    if (window.XMLHttpRequest)
    {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        return new XMLHttpRequest();
    }
    else if (window.ActiveXObject)
    { 
        // code for IE6, IE5
        return  new ActiveXObject("Microsoft.XMLHTTP");
    }
    else
    {
        return null;
    }
}

function LogTrackingEvent(appPath, linkType, originatingLinkPath) {
    $.get(appPath + "/Tracker/Tracker.ashx", "LinkType=" + linkType + "&OriginatingLinkPath=" + originatingLinkPath);
}

function LaunchGame(requiredFlashVersion, gameID, playForReal)
{
    var hasRequestedVersion = swfobject.hasFlashPlayerVersion(requiredFlashVersion);

    if(!hasRequestedVersion)
    {
        //flash not available so trigger modal popup

        bet365.flash.showNoFlashLauncherPrompt();

    }
    else
    {
        if(!playForReal)
        {
            launchCasinoFreePlay(gameID);
        }
        else
        {
            launchCasino(gameID);
        }
    }
}

function LaunchGameLive(requiredFlashVersion, gameID, playForReal, livenetworkid) {
    var hasRequestedVersion = swfobject.hasFlashPlayerVersion(requiredFlashVersion);

    if (!hasRequestedVersion) {
        //flash not available so trigger modal popup

        bet365.flash.showNoFlashLauncherPrompt();
    }
    else {
        if (!playForReal) {
            launchCasinoFreePlayLive(gameID, livenetworkid);
        }
        else {
            launchCasinoLive(gameID, livenetworkid);
        }
    }
}

function OpenLogin(requiredFlashVersion, path)
{
    var hasRequestedVersion = swfobject.hasFlashPlayerVersion(requiredFlashVersion);

    if(!hasRequestedVersion)
    {
        //flash not available so trigger modal popup

        bet365.flash.showNoFlashLauncherPrompt();
    }
    else
    {        
        var sLeft = bet365.Screen.GetScreenWidth();
        var sTop = bet365.Screen.GetScreenTop();
        var loginWindow = window.open(path, 'casino', 'height=600,width=800,status=yes,toolbar=no,menubar=no,location=no,left=' + sLeft + ',top=' + sTop + ',scrollbars=yes,resizable=yes');
        
        persistantGameWindow=loginWindow; 
             
        if(persistantGameWindow != null)
        {
            var browser = bet365.GetBrowser();
        
            if(browser == "IE8" || browser == "FIREFOX")
            {
                setTimeout('persistantGameWindow.focus();', 500);
            }
            else
            {
                setTimeout('persistantGameWindow.blur(); persistantGameWindow.focus();', 500);
            }
        }
    }
}

function ReloadME()
{
    window.location = window.location;
}

function getIFObj(obj)
{
      var objRef; 
      
//      objRef = $find(obj);

      if(document.all)
      {
            objRef = eval("document.all." + obj);
      }
      
      if(document.getElementById)
      {
            objRef = document.getElementById(obj);
      }

      return objRef;
}



// Device Game Table

function UpdateDeviceGamesTable(deviceDropDownID, categoryDropDownID, gameTableID, emptyGameTableID) {

    var selectedDevice = GetStylableDropDownSelectedValue(deviceDropDownID);
    var selectedCategory = GetStylableDropDownSelectedValue(categoryDropDownID);

    if (selectedDevice == null) {
        selectedDevice = '0';
    }

    if (selectedCategory == null) {
        selectedCategory = '0';
    }

    if (selectedDevice == '0' && selectedCategory == '0') {
        $('#' + gameTableID + ' > .DeviceGameTableSingle').show();
    } else {

        var allInvisible = true;

        $('#' + gameTableID + ' > .DeviceGameTableSingle').each(function () {

            var shouldShow = false;

            if (selectedDevice != '0') {

                if ($(this).find('.DevicePodIcon[rel=\"' + selectedDevice + '\"]').length > 0) {
                    shouldShow = true;
                }
            }

            if (selectedCategory != '0' && (selectedDevice == '0' || (selectedDevice != '0' && shouldShow))) {
                if ($(this).find('.DevicePodCategory[rel=\"' + selectedCategory + '\"]').length > 0) {
                    shouldShow = true;
                } else {
                    shouldShow = false;
                }
            }

            if (shouldShow) {
                $(this).show();
                allInvisible = false;
            }
            else {
                $(this).hide();
            }

        });

        if (allInvisible) {
            $('.DeviceGameTable').hide();
            $('#' + emptyGameTableID).show();
        } else {
            $('.DeviceGameTable').show();
            $('#' + emptyGameTableID).hide();
        }
    }
}

function GetStylableDropDownSelectedValue(id) {
    return $("#" + id).find("dt a span.value").html();
}

function GetStylableDropDownSelectedText(id) {
    return $("#" + id).find("dt a span.displayValue").html();
}