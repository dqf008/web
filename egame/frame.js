// version: 1.0.0

// egame iframe
(function(){
	var egameUrl = '';
	var egameFrameId = 'egame';
	var gameWindowUrl = '/egame/eGameLobby.html';
	var minWidth = 900;
	var maxWidth = 1150;
	
	createRngIframe();
	
	// for eGame lobby menu control
	if (window.addEventListener) {
		window.addEventListener("message", getChildMessage, true);
		//window.addEventListener("scroll", sendScrollToChild, false);
	} else {
		window.attachEvent("onmessage", getChildMessage);
		//window.attachEvent("onscroll", sendScrollToChild);
	}
	
	//////////////////
	
	// create iframe for external rng game page
	function createRngIframe() {
		var iframe, ele, width, height, lang, u, k, st, cur, custom, platform, test_platform, customWidth, bgColor, theme, istry;
		
		ele = document.querySelector('[data-toggle="egame"]');
		ele.style.cssText += 'text-align:center';
		
	    if (ele) {
	    	width = 1007;
	    	height = 1680;
	    	url = ele.getAttribute('data-url');
	    	pid = ele.getAttribute('data-pid');
	    	bgColor = ele.getAttribute('data-bgcolor') || '';
	    	u = ele.getAttribute('data-user') || '';
	    	k = ele.getAttribute('data-key') || '';
	    	lang = ele.getAttribute('data-lang');
	    	st = ele.getAttribute('data-token') || '';
	    	cur = ele.getAttribute('data-cur') || '';
	    	custom = ele.getAttribute('data-custom') || '';
	    	platform = ele.getAttribute('data-platform') || '';
	    	test_platform = ele.getAttribute('data-test-game-platform') || '';
	    	customWidth  = parseInt(ele.getAttribute('data-width') || '');
	    	theme = ele.getAttribute('data-theme') || '';
	    	istry =  parseInt(ele.getAttribute('data-istry') || 0);
	    	
	    	// use custom width
	    	if (!isNaN(customWidth)) {
	    		if (customWidth >= minWidth && customWidth <= maxWidth) {
	    			width = customWidth;
	    		}
	    	}
	    	
	    	switch (lang) {
	    		case 'en':
	    		case 'zh':
	    		case 'tr':
	    			break;
	    		default :
	    			lang = 'zh';
	    			break;
	    	}
	    	
	    	egameUrl = url;

	    	// remove tailing slash
	    	if (egameUrl.slice(-1) == '/') { egameUrl = egameUrl.slice(0, egameUrl.length-1); }
	    	
	    	var d = new Date();
	    	url = egameUrl + '?pid=' + pid + '&u=' + encodeURIComponent(u) + '&k=' + encodeURIComponent(k) + '&lang=' + lang + '&st=' + encodeURIComponent(st) + '&cur=' + encodeURIComponent(cur) + '&custom=' + encodeURIComponent(custom)+ '&bgColor=' + encodeURIComponent(bgColor) + '&_t=' + d.getTime();
	    	
	    	if (theme.length > 0) {
	    		url += '&theme=' + encodeURIComponent(theme);
	    	}
	    	
	    	// only append to url when params is set
	    	if (platform.length > 0) {
	    		url += '&platform=' + encodeURIComponent(platform);
	    	} 
	    	if (test_platform.length > 0) {
	    		url += '&test-platform-id=' + encodeURIComponent(test_platform);
	    	}

	    	// determine user account is trial account
	    	if (istry === 1) {
	    		url += '&istry=1';
	    	}
	    	document.location = url;
	    	/*iframe = document.createElement("iframe");
	    	iframe.id = 'egame';
	    	iframe.src = url;
	    	iframe.width = width;
	    	iframe.height = height;
	    	iframe.scrolling = 'no';
	    	iframe.frameBorder = 0;
	    	ele.appendChild(iframe);*/
	    }
	}
	
	// tracking window scroll and tell egame for floating menu
	function sendScrollToChild() {
		var frame, obj;
		try {
			frame = document.getElementById(egameFrameId);
			obj = new Object();
			obj.method = 'updateScroll';
			obj.embed = true;
			obj.frameTop = frame.getBoundingClientRect().top;
			obj.frameLeft = frame.getBoundingClientRect().left;
			obj.frameBottom = frame.getBoundingClientRect().bottom;
			obj.frameRight = frame.getBoundingClientRect().right;
			obj.frameWidth = frame.offsetWidth;
			obj.frameHeight = frame.offsetHeight;
			sendChildMessage(obj);
		} catch(e) {}
		
		return;
	}

	// scroll back to egame menu position when user click in menu
	function topmenuOffset(data) {
		var frame, t, v;
		
		frame = document.getElementById(egameFrameId);
		t = (window.addEventListener) ? window.pageYOffset : document.documentElement.scrollTop;
		v = parseInt(data.topmenuOffset + frame.getBoundingClientRect().top + t);
		window.scroll(0, v);
		return;
	}
	
	// update frame height base on number of games in egame
	function updateFrameHeight(data) {
		var v, frame;
		v = parseInt(data.pageHeight);
		frame = document.getElementById(egameFrameId);
		frame.style.height = v + "px";
	}
	
	// open game in new window
	function openGameWindow(data) {
		var gameUrl;
		
		//console.log('website::openGameWindow - start');
		try {
			
			if (data.useForwardGame == true) {
				gameUrl = data.url;
			} else {
				gameUrl = gameWindowUrl + '#' + encodeURI(data.url);
			}
			//console.log('gameUrl: ' + gameUrl);
			
			var eGameLobby = window.open(gameUrl, '_blank');
			//eGameLobby.focus();
			//console.log('before popupBlockerChecker');
			
			// check popup is blocked, then tell iframe open message with game link
			popupBlockerChecker.check(eGameLobby, gameUrl, data.useForwardGame);
			
			//eGameLobby.focus();
		} catch(err) {console.log(err);}
		//console.log('website::openGameWindow - end');
	}
	
	function addStyle(data) {
		var css, obj;
		try{
			css = document.createElement("link");
			obj = document.getElementsByTagName("head")[0];
			obj.appendChild(css);
			css.outerHTML = data.css;
		} catch(e) {}
	}
	
	function showTopmenuClone(data) {
		var obj;
		try{
			obj = document.getElementById(data.id);
			if (!obj){
				obj = document.createElement("div");
				document.body.appendChild(obj);
				obj.outerHTML = data.html;
			}
		} catch(e) {}
	}
	
	function removeTopmenuClone(data) {
		var obj;
		try{
			obj = document.getElementById(data.id);
			if (obj) obj.parentNode.removeChild(obj);			
		} catch(e) {}
	}
	
	// send message to egame
	function sendChildMessage(obj){
		var frame;
		try {
			frame = document.getElementById(egameFrameId);
			frame.contentWindow.postMessage(JSON.stringify(obj), egameUrl);
		} catch(e) {}
	}

	// for click banner and scroll to search bar 
	function scrollToSearchBar(frameTop, iframeHeight){
		var y = $(window).scrollTop();

		$("html,body").animate({
			scrollTop: y + frameTop + iframeHeight },
			"slow");
	}

	// get egame message to run target function
	function getChildMessage(event){
		var data;
		//console.log('parent::getChildMessage');
		if (event.origin.indexOf(egameUrl) > -1){
			data = JSON.parse(event.data);
			//console.log('parent::getChildMessage - message switch');
			//console.log(data);
			switch(data.method){
				case 'startInit':
					//console.log('[LOG] startInit ------------');
					if (window.addEventListener) {
						window.addEventListener("scroll", sendScrollToChild, false);
					} else {
						window.attachEvent("onscroll", sendScrollToChild);
					}
					// return parent host
					frame = document.getElementById(egameFrameId);
					obj = new Object();
					obj.method = 'updateParentInfo';
					obj.href = window.location.protocol + '//' +  window.location.host;
					sendChildMessage(obj);
					break;
				case 'checkParent':
					sendScrollToChild();
					break;
				case "backToTop":
				case "updateFrameHeight":
				case "resetTopmenuOffset":
				case "addStyle":
				case "showTopmenuClone":
				case "removeTopmenuClone":
				case "sendKeydownEvent":
				case "sendKeyupEvent":
				case "sendKeyHomeEvent":
				case "sendKeyEndEvent":
				case "sendKeyPageUpEvent":
				case "sendKeyPageDownEvent":
				case "printMsg":
				case "addMobileVerCss":
					eval(data.func);
					break;
				case 'openGame':
					openGameWindow(data);
					break;
				case 'loginAndOpenGame':
					// open game in new window
					openGameWindow(data);
					// website defined by themself
					egameLoginWithToken(data.loginname, data.token);
					break;
				case 'scrollToSearchBar':
					scrollToSearchBar(data.frameTop, data.iframeHeight);
					break;
				case 'egameLoginWithToken':
					console.log('egameLoginWithToken');
					try {
						console.log(data);
						egameLoginWithToken(data.loginname, data.sessionToken);
					} catch (err) { console.log('[ERR]',err); }
					break;
			}
		}
	}

	// popup blocked checker
	var popupBlockerChecker = {
		check: function(popup_window, gameUrl, useForwardGame){
			var _scope = this;
			//console.log(gameUrl);
			if (popup_window) {
				if(/chrome/.test(navigator.userAgent.toLowerCase())){
					//console.log('check chrome popup blocked');
					setTimeout(function () {
						_scope._is_popup_blocked(_scope, popup_window, gameUrl, useForwardGame);
					 },200);
				}else{
					//console.log('check other browsers popup blocked');
					popup_window.onload = function () {
						_scope._is_popup_blocked(_scope, popup_window, gameUrl, useForwardGame);
					};
				}
			}else{
				//console.log('popup_window fail');
				_scope._displayError(gameUrl, useForwardGame);
			}
		},
		_is_popup_blocked: function(scope, popup_window, gameUrl, useForwardGame){
			//console.log('_is_popup_blocked');
			//console.log(scope);
			//console.log(popup_window);
			if ((popup_window.innerHeight > 0)==false){ scope._displayError(gameUrl, useForwardGame); }
		},
		_displayError: function(gameUrl, useForwardGame){
			//console.log('_displayError');
			//alert("Popup Blocker is enabled! Please add this site to your exception list." + gameUrl);
			try {
				var obj = new Object();
				obj.method = 'openGameLinkButton';
				if (useForwardGame) {
					obj.gameUrl = gameUrl;
				} else {
					obj.gameUrl = location.protocol + '//' + location.host + gameUrl;
				}
				sendChildMessage(obj);
			} catch(err) {console.log(err);}
		}
	};
})();