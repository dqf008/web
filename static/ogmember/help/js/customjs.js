(function(n, t) {
	function o(n) {
		return e === "" ? n: (n = n.charAt(0).toUpperCase() + n.substr(1), e + n)
	}
	var i = Math,
	y = t.createElement("div").style,
	e = function() {
		for (var t = "t,webkitT,MozT,msT,OT".split(","), i, n = 0, r = t.length; n < r; n++) if (i = t[n] + "ransform", i in y) return t[n].substr(0, t[n].length - 1);
		return ! 1
	} (),
	u = e ? "-" + e.toLowerCase() + "-": "",
	f = o("transform"),
	ft = o("transitionProperty"),
	h = o("transitionDuration"),
	ot = o("transformOrigin"),
	et = o("transitionTimingFunction"),
	d = o("transitionDelay"),
	b = /android/gi.test(navigator.appVersion),
	g = /iphone|ipad/gi.test(navigator.appVersion),
	rt = /hp-tablet/gi.test(navigator.appVersion),
	it = o("perspective") in y,
	r = "ontouchstart" in n && !rt,
	nt = e !== !1,
	st = o("transition") in y,
	p = "onorientationchange" in n ? "orientationchange": "resize",
	w = r ? "touchstart": "mousedown",
	l = r ? "touchmove": "mousemove",
	a = r ? "touchend": "mouseup",
	v = r ? "touchcancel": "mouseup",
	c = function() {
		if (e === !1) return ! 1;
		var n = {
			"": "transitionend",
			webkit: "webkitTransitionEnd",
			Moz: "transitionend",
			O: "otransitionend",
			ms: "MSTransitionEnd"
		};
		return n[e]
	} (),
	ut = function() {
		return n.requestAnimationFrame || n.webkitRequestAnimationFrame || n.mozRequestAnimationFrame || n.oRequestAnimationFrame || n.msRequestAnimationFrame ||
		function(n) {
			return setTimeout(n, 1)
		}
	} (),
	tt = function() {
		return n.cancelRequestAnimationFrame || n.webkitCancelAnimationFrame || n.webkitCancelRequestAnimationFrame || n.mozCancelRequestAnimationFrame || n.oCancelRequestAnimationFrame || n.msCancelRequestAnimationFrame || clearTimeout
	} (),
	s = it ? " translateZ(0)": "",
	k = function(i, e) {
		var o = this,
		c;
		o.wrapper = typeof i == "object" ? i: t.getElementById(i),
		o.wrapper.style.overflow = "hidden",
		o.scroller = o.wrapper.children[0],
		o.options = {
			hScroll: !0,
			vScroll: !0,
			x: 0,
			y: 0,
			bounce: !0,
			bounceLock: !1,
			momentum: !0,
			lockDirection: !0,
			useTransform: !0,
			useTransition: !1,
			topOffset: 0,
			checkDOMChanges: !1,
			handleClick: !0,
			hScrollbar: !0,
			vScrollbar: !0,
			fixedScrollbar: b,
			hideScrollbar: g,
			fadeScrollbar: g && it,
			scrollbarClass: "",
			zoom: !1,
			zoomMin: 1,
			zoomMax: 4,
			doubleTapZoom: 2,
			wheelAction: "scroll",
			snap: !1,
			snapThreshold: 1,
			onRefresh: null,
			onBeforeScrollStart: function(n) {
				n.preventDefault()
			},
			onScrollStart: null,
			onBeforeScrollMove: null,
			onScrollMove: null,
			onBeforeScrollEnd: null,
			onScrollEnd: null,
			onTouchEnd: null,
			onDestroy: null,
			onZoomStart: null,
			onZoom: null,
			onZoomEnd: null
		};
		for (c in e) o.options[c] = e[c];
		o.x = o.options.x,
		o.y = o.options.y,
		o.options.useTransform = nt && o.options.useTransform,
		o.options.hScrollbar = o.options.hScroll && o.options.hScrollbar,
		o.options.vScrollbar = o.options.vScroll && o.options.vScrollbar,
		o.options.zoom = o.options.useTransform && o.options.zoom,
		o.options.useTransition = st && o.options.useTransition,
		o.options.zoom && b && (s = ""),
		o.scroller.style[ft] = o.options.useTransform ? u + "transform": "top left",
		o.scroller.style[h] = "0",
		o.scroller.style[ot] = "0 0",
		o.options.useTransition && (o.scroller.style[et] = "cubic-bezier(0.33,0.66,0.66,1)"),
		o.options.useTransform ? o.scroller.style[f] = "translate(" + o.x + "px," + o.y + "px)" + s: o.scroller.style.cssText += ";position:absolute;top:" + o.y + "px;left:" + o.x + "px",
		o.options.useTransition && (o.options.fixedScrollbar = !0),
		o.refresh(),
		o._bind(p, n),
		o._bind(w),
		r || o.options.wheelAction != "none" && (o._bind("DOMMouseScroll"), o._bind("mousewheel")),
		o.options.checkDOMChanges && (o.checkDOMTime = setInterval(function() {
			o._checkDOMChanges()
		},
		500))
	};
	k.prototype = {
		enabled: !0,
		x: 0,
		y: 0,
		steps: [],
		scale: 1,
		currPageX: 0,
		currPageY: 0,
		pagesX: [],
		pagesY: [],
		aniTime: null,
		wheelZoomCount: 0,
		handleEvent: function(n) {
			var t = this;
			switch (n.type) {
			case w:
				if (!r && n.button !== 0) return;
				t._start(n);
				break;
			case l:
				t._move(n);
				break;
			case a:
			case v:
				t._end(n);
				break;
			case p:
				t._resize();
				break;
			case "DOMMouseScroll":
			case "mousewheel":
				t._wheel(n);
				break;
			case c:
				t._transitionEnd(n)
			}
		},
		_checkDOMChanges: function() {
			this.moved || this.zoomed || this.animating || this.scrollerW == this.scroller.offsetWidth * this.scale && this.scrollerH == this.scroller.offsetHeight * this.scale || this.refresh()
		},
		_scrollbar: function(n) {
			var r = this,
			e;
			if (!r[n + "Scrollbar"]) {
				r[n + "ScrollbarWrapper"] && (nt && (r[n + "ScrollbarIndicator"].style[f] = ""), r[n + "ScrollbarWrapper"].parentNode.removeChild(r[n + "ScrollbarWrapper"]), r[n + "ScrollbarWrapper"] = null, r[n + "ScrollbarIndicator"] = null);
				return
			}
			r[n + "ScrollbarWrapper"] || (e = t.createElement("div"), r.options.scrollbarClass ? e.className = r.options.scrollbarClass + n.toUpperCase() : e.style.cssText = "position:absolute;z-index:100;" + (n == "h" ? "height:7px;bottom:1px;left:2px;right:" + (r.vScrollbar ? "7": "2") + "px": "width:7px;bottom:" + (r.hScrollbar ? "7": "2") + "px;top:2px;right:1px"), e.style.cssText += ";pointer-events:none;" + u + "transition-property:opacity;" + u + "transition-duration:" + (r.options.fadeScrollbar ? "350ms": "0") + ";overflow:hidden;opacity:" + (r.options.hideScrollbar ? "0": "1"), r.wrapper.appendChild(e), r[n + "ScrollbarWrapper"] = e, e = t.createElement("div"), r.options.scrollbarClass || (e.style.cssText = "position:absolute;z-index:100;background:rgba(0,0,0,0.5);border:1px solid rgba(255,255,255,0.9);" + u + "background-clip:padding-box;" + u + "box-sizing:border-box;" + (n == "h" ? "height:100%": "width:100%") + ";" + u + "border-radius:3px;border-radius:3px"), e.style.cssText += ";pointer-events:none;" + u + "transition-property:" + u + "transform;" + u + "transition-timing-function:cubic-bezier(0.33,0.66,0.66,1);" + u + "transition-duration:0;" + u + "transform: translate(0,0)" + s, r.options.useTransition && (e.style.cssText += ";" + u + "transition-timing-function:cubic-bezier(0.33,0.66,0.66,1)"), r[n + "ScrollbarWrapper"].appendChild(e), r[n + "ScrollbarIndicator"] = e),
			n == "h" ? (r.hScrollbarSize = r.hScrollbarWrapper.clientWidth, r.hScrollbarIndicatorSize = i.max(i.round(r.hScrollbarSize * r.hScrollbarSize / r.scrollerW), 8), r.hScrollbarIndicator.style.width = r.hScrollbarIndicatorSize + "px", r.hScrollbarMaxScroll = r.hScrollbarSize - r.hScrollbarIndicatorSize, r.hScrollbarProp = r.hScrollbarMaxScroll / r.maxScrollX) : (r.vScrollbarSize = r.vScrollbarWrapper.clientHeight, r.vScrollbarIndicatorSize = i.max(i.round(r.vScrollbarSize * r.vScrollbarSize / r.scrollerH), 8), r.vScrollbarIndicator.style.height = r.vScrollbarIndicatorSize + "px", r.vScrollbarMaxScroll = r.vScrollbarSize - r.vScrollbarIndicatorSize, r.vScrollbarProp = r.vScrollbarMaxScroll / r.maxScrollY),
			r._scrollbarPos(n, !0)
		},
		_resize: function() {
			var n = this;
			setTimeout(function() {
				n.refresh()
			},
			b ? 200 : 0)
		},
		_pos: function(n, t) {
			this.zoomed || (n = this.hScroll ? n: 0, t = this.vScroll ? t: 0, this.options.useTransform ? this.scroller.style[f] = "translate(" + n + "px," + t + "px) scale(" + this.scale + ")" + s: (n = i.round(n), t = i.round(t), this.scroller.style.left = n + "px", this.scroller.style.top = t + "px"), this.x = n, this.y = t, this._scrollbarPos("h"), this._scrollbarPos("v"))
		},
		_scrollbarPos: function(n, t) {
			var r = this,
			u = n == "h" ? r.x: r.y,
			e;
			r[n + "Scrollbar"] && (u = r[n + "ScrollbarProp"] * u, u < 0 ? (r.options.fixedScrollbar || (e = r[n + "ScrollbarIndicatorSize"] + i.round(u * 3), e < 8 && (e = 8), r[n + "ScrollbarIndicator"].style[n == "h" ? "width": "height"] = e + "px"), u = 0) : u > r[n + "ScrollbarMaxScroll"] && (r.options.fixedScrollbar ? u = r[n + "ScrollbarMaxScroll"] : (e = r[n + "ScrollbarIndicatorSize"] - i.round((u - r[n + "ScrollbarMaxScroll"]) * 3), e < 8 && (e = 8), r[n + "ScrollbarIndicator"].style[n == "h" ? "width": "height"] = e + "px", u = r[n + "ScrollbarMaxScroll"] + (r[n + "ScrollbarIndicatorSize"] - e))), r[n + "ScrollbarWrapper"].style[d] = "0", r[n + "ScrollbarWrapper"].style.opacity = t && r.options.hideScrollbar ? "0": "1", r[n + "ScrollbarIndicator"].style[f] = "translate(" + (n == "h" ? u + "px,0)": "0," + u + "px)") + s)
		},
		_start: function(t) {
			var u = this,
			p = r ? t.touches[0] : t,
			e,
			o,
			s,
			h,
			y;
			u.enabled && (u.options.onBeforeScrollStart && u.options.onBeforeScrollStart.call(u, t), (u.options.useTransition || u.options.zoom) && u._transitionTime(0), u.moved = !1, u.animating = !1, u.zoomed = !1, u.distX = 0, u.distY = 0, u.absDistX = 0, u.absDistY = 0, u.dirX = 0, u.dirY = 0, u.options.zoom && r && t.touches.length > 1 && (h = i.abs(t.touches[0].pageX - t.touches[1].pageX), y = i.abs(t.touches[0].pageY - t.touches[1].pageY), u.touchesDistStart = i.sqrt(h * h + y * y), u.originX = i.abs(t.touches[0].pageX + t.touches[1].pageX - u.wrapperOffsetLeft * 2) / 2 - u.x, u.originY = i.abs(t.touches[0].pageY + t.touches[1].pageY - u.wrapperOffsetTop * 2) / 2 - u.y, u.options.onZoomStart && u.options.onZoomStart.call(u, t)), u.options.momentum && (u.options.useTransform ? (e = getComputedStyle(u.scroller, null)[f].replace(/[^0-9\-.,]/g, "").split(","), o = +(e[12] || e[4]), s = +(e[13] || e[5])) : (o = +getComputedStyle(u.scroller, null).left.replace(/[^0-9-]/g, ""), s = +getComputedStyle(u.scroller, null).top.replace(/[^0-9-]/g, "")), (o != u.x || s != u.y) && (u.options.useTransition ? u._unbind(c) : tt(u.aniTime), u.steps = [], u._pos(o, s), u.options.onScrollEnd && u.options.onScrollEnd.call(u))), u.absStartX = u.x, u.absStartY = u.y, u.startX = u.x, u.startY = u.y, u.pointX = p.pageX, u.pointY = p.pageY, u.startTime = t.timeStamp || Date.now(), u.options.onScrollStart && u.options.onScrollStart.call(u, t), u._bind(l, n), u._bind(a, n), u._bind(v, n))
		},
		_move: function(n) {
			var t = this,
			l = r ? n.touches[0] : n,
			h = l.pageX - t.pointX,
			c = l.pageY - t.pointY,
			e = t.x + h,
			o = t.y + c,
			v,
			a,
			u,
			y = n.timeStamp || Date.now();
			if (t.options.onBeforeScrollMove && t.options.onBeforeScrollMove.call(t, n), t.options.zoom && r && n.touches.length > 1) {
				v = i.abs(n.touches[0].pageX - n.touches[1].pageX),
				a = i.abs(n.touches[0].pageY - n.touches[1].pageY),
				t.touchesDist = i.sqrt(v * v + a * a),
				t.zoomed = !0,
				u = 1 / t.touchesDistStart * t.touchesDist * this.scale,
				u < t.options.zoomMin ? u = .5 * t.options.zoomMin * Math.pow(2, u / t.options.zoomMin) : u > t.options.zoomMax && (u = 2 * t.options.zoomMax * Math.pow(.5, t.options.zoomMax / u)),
				t.lastScale = u / this.scale,
				e = this.originX - this.originX * t.lastScale + this.x,
				o = this.originY - this.originY * t.lastScale + this.y,
				this.scroller.style[f] = "translate(" + e + "px," + o + "px) scale(" + u + ")" + s,
				t.options.onZoom && t.options.onZoom.call(t, n);
				return
			} (t.pointX = l.pageX, t.pointY = l.pageY, (e > 0 || e < t.maxScrollX) && (e = t.options.bounce ? t.x + h / 2 : e >= 0 || t.maxScrollX >= 0 ? 0 : t.maxScrollX), (o > t.minScrollY || o < t.maxScrollY) && (o = t.options.bounce ? t.y + c / 2 : o >= t.minScrollY || t.maxScrollY >= 0 ? t.minScrollY: t.maxScrollY), t.distX += h, t.distY += c, t.absDistX = i.abs(t.distX), t.absDistY = i.abs(t.distY), t.absDistX < 6 && t.absDistY < 6) || (t.options.lockDirection && (t.absDistX > t.absDistY + 5 ? (o = t.y, c = 0) : t.absDistY > t.absDistX + 5 && (e = t.x, h = 0)), t.moved = !0, t._pos(e, o), t.dirX = h > 0 ? -1 : h < 0 ? 1 : 0, t.dirY = c > 0 ? -1 : c < 0 ? 1 : 0, y - t.startTime > 300 && (t.startTime = y, t.startX = t.x, t.startY = t.y), t.options.onScrollMove && t.options.onScrollMove.call(t, n))
		},
		_end: function(u) {
			if (!r || u.touches.length === 0) {
				var e = this,
				d = r ? u.changedTouches[0] : u,
				p,
				tt,
				b = {
					dist: 0,
					time: 0
				},
				k = {
					dist: 0,
					time: 0
				},
				rt = (u.timeStamp || Date.now()) - e.startTime,
				c = e.x,
				o = e.y,
				it,
				nt,
				g,
				y,
				w;
				if (e._unbind(l, n), e._unbind(a, n), e._unbind(v, n), e.options.onBeforeScrollEnd && e.options.onBeforeScrollEnd.call(e, u), e.zoomed) {
					w = e.scale * e.lastScale,
					w = Math.max(e.options.zoomMin, w),
					w = Math.min(e.options.zoomMax, w),
					e.lastScale = w / e.scale,
					e.scale = w,
					e.x = e.originX - e.originX * e.lastScale + e.x,
					e.y = e.originY - e.originY * e.lastScale + e.y,
					e.scroller.style[h] = "200ms",
					e.scroller.style[f] = "translate(" + e.x + "px," + e.y + "px) scale(" + e.scale + ")" + s,
					e.zoomed = !1,
					e.refresh(),
					e.options.onZoomEnd && e.options.onZoomEnd.call(e, u);
					return
				}
				if (!e.moved) {
					r && (e.doubleTapTimer && e.options.zoom ? (clearTimeout(e.doubleTapTimer), e.doubleTapTimer = null, e.options.onZoomStart && e.options.onZoomStart.call(e, u), e.zoom(e.pointX, e.pointY, e.scale == 1 ? e.options.doubleTapZoom: 1), e.options.onZoomEnd && setTimeout(function() {
						e.options.onZoomEnd.call(e, u)
					},
					200)) : this.options.handleClick && (e.doubleTapTimer = setTimeout(function() {
						for (e.doubleTapTimer = null, p = d.target; p.nodeType != 1;) p = p.parentNode;
						p.tagName != "SELECT" && p.tagName != "INPUT" && p.tagName != "TEXTAREA" && (tt = t.createEvent("MouseEvents"), tt.initMouseEvent("click", !0, !0, u.view, 1, d.screenX, d.screenY, d.clientX, d.clientY, u.ctrlKey, u.altKey, u.shiftKey, u.metaKey, 0, null), tt._fake = !0, p.dispatchEvent(tt))
					},
					e.options.zoom ? 250 : 0))),
					e._resetPos(400),
					e.options.onTouchEnd && e.options.onTouchEnd.call(e, u);
					return
				}
				if (rt < 300 && e.options.momentum && (b = c ? e._momentum(c - e.startX, rt, -e.x, e.scrollerW - e.wrapperW + e.x, e.options.bounce ? e.wrapperW: 0) : b, k = o ? e._momentum(o - e.startY, rt, -e.y, e.maxScrollY < 0 ? e.scrollerH - e.wrapperH + e.y - e.minScrollY: 0, e.options.bounce ? e.wrapperH: 0) : k, c = e.x + b.dist, o = e.y + k.dist, (e.x > 0 && c > 0 || e.x < e.maxScrollX && c < e.maxScrollX) && (b = {
					dist: 0,
					time: 0
				}), (e.y > e.minScrollY && o > e.minScrollY || e.y < e.maxScrollY && o < e.maxScrollY) && (k = {
					dist: 0,
					time: 0
				})), b.dist || k.dist) {
					g = i.max(i.max(b.time, k.time), 10),
					e.options.snap && (it = c - e.absStartX, nt = o - e.absStartY, i.abs(it) < e.options.snapThreshold && i.abs(nt) < e.options.snapThreshold ? e.scrollTo(e.absStartX, e.absStartY, 200) : (y = e._snap(c, o), c = y.x, o = y.y, g = i.max(y.time, g))),
					e.scrollTo(i.round(c), i.round(o), g),
					e.options.onTouchEnd && e.options.onTouchEnd.call(e, u);
					return
				}
				if (e.options.snap) {
					it = c - e.absStartX,
					nt = o - e.absStartY,
					i.abs(it) < e.options.snapThreshold && i.abs(nt) < e.options.snapThreshold ? e.scrollTo(e.absStartX, e.absStartY, 200) : (y = e._snap(e.x, e.y), (y.x != e.x || y.y != e.y) && e.scrollTo(y.x, y.y, y.time)),
					e.options.onTouchEnd && e.options.onTouchEnd.call(e, u);
					return
				}
				e._resetPos(200),
				e.options.onTouchEnd && e.options.onTouchEnd.call(e, u)
			}
		},
		_resetPos: function(n) {
			var t = this,
			r = t.x >= 0 ? 0 : t.x < t.maxScrollX ? t.maxScrollX: t.x,
			i = t.y >= t.minScrollY || t.maxScrollY > 0 ? t.minScrollY: t.y < t.maxScrollY ? t.maxScrollY: t.y;
			if (r == t.x && i == t.y) {
				t.moved && (t.moved = !1, t.options.onScrollEnd && t.options.onScrollEnd.call(t)),
				t.hScrollbar && t.options.hideScrollbar && (e == "webkit" && (t.hScrollbarWrapper.style[d] = "300ms"), t.hScrollbarWrapper.style.opacity = "0"),
				t.vScrollbar && t.options.hideScrollbar && (e == "webkit" && (t.vScrollbarWrapper.style[d] = "300ms"), t.vScrollbarWrapper.style.opacity = "0");
				return
			}
			t.scrollTo(r, i, n || 0)
		},
		_wheel: function(n) {
			var t = this,
			e, r, f, u, i;
			if ("wheelDeltaX" in n) e = n.wheelDeltaX / 12,
			r = n.wheelDeltaY / 12;
			else if ("wheelDelta" in n) e = r = n.wheelDelta / 12;
			else if ("detail" in n) e = r = -n.detail * 3;
			else return;
			if (t.options.wheelAction == "zoom") {
				i = t.scale * Math.pow(2, 1 / 3 * (r ? r / Math.abs(r) : 0)),
				i < t.options.zoomMin && (i = t.options.zoomMin),
				i > t.options.zoomMax && (i = t.options.zoomMax),
				i != t.scale && (!t.wheelZoomCount && t.options.onZoomStart && t.options.onZoomStart.call(t, n), t.wheelZoomCount++, t.zoom(n.pageX, n.pageY, i, 400), setTimeout(function() {
					t.wheelZoomCount--,
					!t.wheelZoomCount && t.options.onZoomEnd && t.options.onZoomEnd.call(t, n)
				},
				400));
				return
			}
			f = t.x + e,
			u = t.y + r,
			f > 0 ? f = 0 : f < t.maxScrollX && (f = t.maxScrollX),
			u > t.minScrollY ? u = t.minScrollY: u < t.maxScrollY && (u = t.maxScrollY),
			t.maxScrollY < 0 && t.scrollTo(f, u, 0)
		},
		_transitionEnd: function(n) {
			var t = this;
			n.target == t.scroller && (t._unbind(c), t._startAni())
		},
		_startAni: function() {
			var n = this,
			f = n.x,
			e = n.y,
			o = Date.now(),
			t,
			r,
			u;
			if (!n.animating) {
				if (!n.steps.length) {
					n._resetPos(400);
					return
				}
				if (t = n.steps.shift(), t.x == f && t.y == e && (t.time = 0), n.animating = !0, n.moved = !0, n.options.useTransition) {
					n._transitionTime(t.time),
					n._pos(t.x, t.y),
					n.animating = !1,
					t.time ? n._bind(c) : n._resetPos(0);
					return
				}
				u = function() {
					var s = Date.now(),
					c,
					h;
					if (s >= o + t.time) {
						n._pos(t.x, t.y),
						n.animating = !1,
						n.options.onAnimationEnd && n.options.onAnimationEnd.call(n),
						n._startAni();
						return
					}
					s = (s - o) / t.time - 1,
					r = i.sqrt(1 - s * s),
					c = (t.x - f) * r + f,
					h = (t.y - e) * r + e,
					n._pos(c, h),
					n.animating && (n.aniTime = ut(u))
				},
				u()
			}
		},
		_transitionTime: function(n) {
			n += "ms",
			this.scroller.style[h] = n,
			this.hScrollbar && (this.hScrollbarIndicator.style[h] = n),
			this.vScrollbar && (this.vScrollbarIndicator.style[h] = n)
		},
		_momentum: function(n, t, r, u, f) {
			var h = .0006,
			o = i.abs(n) / t,
			e = o * o / (2 * h),
			c = 0,
			s = 0;
			return n > 0 && e > r ? (s = f / (6 / (e / o * h)), r = r + s, o = o * r / e, e = r) : n < 0 && e > u && (s = f / (6 / (e / o * h)), u = u + s, o = o * u / e, e = u),
			e = e * (n < 0 ? -1 : 1),
			c = o / h,
			{
				dist: e,
				time: i.round(c)
			}
		},
		_offset: function(n) {
			for (var i = -n.offsetLeft,
			t = -n.offsetTop; n = n.offsetParent;) i -= n.offsetLeft,
			t -= n.offsetTop;
			return n != this.wrapper && (i *= this.scale, t *= this.scale),
			{
				left: i,
				top: t
			}
		},
		_snap: function(n, t) {
			for (var r = this,
			h, e, o, u = r.pagesX.length - 1,
			f = 0,
			s = r.pagesX.length; f < s; f++) if (n >= r.pagesX[f]) {
				u = f;
				break
			}
			for (u == r.currPageX && u > 0 && r.dirX < 0 && u--, n = r.pagesX[u], e = i.abs(n - r.pagesX[r.currPageX]), e = e ? i.abs(r.x - n) / e * 500 : 0, r.currPageX = u, u = r.pagesY.length - 1, f = 0; f < u; f++) if (t >= r.pagesY[f]) {
				u = f;
				break
			}
			return u == r.currPageY && u > 0 && r.dirY < 0 && u--,
			t = r.pagesY[u],
			o = i.abs(t - r.pagesY[r.currPageY]),
			o = o ? i.abs(r.y - t) / o * 500 : 0,
			r.currPageY = u,
			h = i.round(i.max(e, o)) || 200,
			{
				x: n,
				y: t,
				time: h
			}
		},
		_bind: function(n, t, i) { (t || this.scroller).addEventListener(n, this, !!i)
		},
		_unbind: function(n, t, i) { (t || this.scroller).removeEventListener(n, this, !!i)
		},
		destroy: function() {
			var t = this;
			t.scroller.style[f] = "",
			t.hScrollbar = !1,
			t.vScrollbar = !1,
			t._scrollbar("h"),
			t._scrollbar("v"),
			t._unbind(p, n),
			t._unbind(w),
			t._unbind(l, n),
			t._unbind(a, n),
			t._unbind(v, n),
			t.options.hasTouch || (t._unbind("DOMMouseScroll"), t._unbind("mousewheel")),
			t.options.useTransition && t._unbind(c),
			t.options.checkDOMChanges && clearInterval(t.checkDOMTime),
			t.options.onDestroy && t.options.onDestroy.call(t)
		},
		refresh: function() {
			var n = this,
			f, r, o, e, t = 0,
			u = 0;
			if (n.scale < n.options.zoomMin && (n.scale = n.options.zoomMin), n.wrapperW = n.wrapper.clientWidth || 1, n.wrapperH = n.wrapper.clientHeight || 1, n.minScrollY = -n.options.topOffset || 0, n.scrollerW = i.round(n.scroller.offsetWidth * n.scale), n.scrollerH = i.round((n.scroller.offsetHeight + n.minScrollY) * n.scale), n.maxScrollX = n.wrapperW - n.scrollerW, n.maxScrollY = n.wrapperH - n.scrollerH + n.minScrollY, n.dirX = 0, n.dirY = 0, n.options.onRefresh && n.options.onRefresh.call(n), n.hScroll = n.options.hScroll && n.maxScrollX < 0, n.vScroll = n.options.vScroll && (!n.options.bounceLock && !n.hScroll || n.scrollerH > n.wrapperH), n.hScrollbar = n.hScroll && n.options.hScrollbar, n.vScrollbar = n.vScroll && n.options.vScrollbar && n.scrollerH > n.wrapperH, f = n._offset(n.wrapper), n.wrapperOffsetLeft = -f.left, n.wrapperOffsetTop = -f.top, typeof n.options.snap == "string") for (n.pagesX = [], n.pagesY = [], e = n.scroller.querySelectorAll(n.options.snap), r = 0, o = e.length; r < o; r++) t = n._offset(e[r]),
			t.left += n.wrapperOffsetLeft,
			t.top += n.wrapperOffsetTop,
			n.pagesX[r] = t.left < n.maxScrollX ? n.maxScrollX: t.left * n.scale,
			n.pagesY[r] = t.top < n.maxScrollY ? n.maxScrollY: t.top * n.scale;
			else if (n.options.snap) {
				for (n.pagesX = []; t >= n.maxScrollX;) n.pagesX[u] = t,
				t = t - n.wrapperW,
				u++;
				for (n.maxScrollX % n.wrapperW && (n.pagesX[n.pagesX.length] = n.maxScrollX - n.pagesX[n.pagesX.length - 1] + n.pagesX[n.pagesX.length - 1]), t = 0, u = 0, n.pagesY = []; t >= n.maxScrollY;) n.pagesY[u] = t,
				t = t - n.wrapperH,
				u++;
				n.maxScrollY % n.wrapperH && (n.pagesY[n.pagesY.length] = n.maxScrollY - n.pagesY[n.pagesY.length - 1] + n.pagesY[n.pagesY.length - 1])
			}
			n._scrollbar("h"),
			n._scrollbar("v"),
			n.zoomed || (n.scroller.style[h] = "0", n._resetPos(400))
		},
		scrollTo: function(n, t, i, r) {
			var e = this,
			f = n,
			u, o;
			for (e.stop(), f.length || (f = [{
				x: n,
				y: t,
				time: i,
				relative: r
			}]), u = 0, o = f.length; u < o; u++) f[u].relative && (f[u].x = e.x - f[u].x, f[u].y = e.y - f[u].y),
			e.steps.push({
				x: f[u].x,
				y: f[u].y,
				time: f[u].time || 0
			});
			e._startAni()
		},
		scrollToElement: function(n, t) {
			var u = this,
			r; (n = n.nodeType ? n:u.scroller.querySelector(n), n) && (r = u._offset(n), r.left += u.wrapperOffsetLeft, r.top += u.wrapperOffsetTop, r.left = r.left > 0 ? 0 : r.left < u.maxScrollX ? u.maxScrollX:r.left, r.top = r.top > u.minScrollY ? u.minScrollY: r.top < u.maxScrollY ? u.maxScrollY: r.top, t = t === undefined ? i.max(i.abs(r.left) * 2, i.abs(r.top) * 2) : t, u.scrollTo(r.left, r.top, t))
		},
		scrollToPage: function(n, t, i) {
			var r = this,
			f, u;
			i = i === undefined ? 400 : i,
			r.options.onScrollStart && r.options.onScrollStart.call(r),
			r.options.snap ? (n = n == "next" ? r.currPageX + 1 : n == "prev" ? r.currPageX - 1 : n, t = t == "next" ? r.currPageY + 1 : t == "prev" ? r.currPageY - 1 : t, n = n < 0 ? 0 : n > r.pagesX.length - 1 ? r.pagesX.length - 1 : n, t = t < 0 ? 0 : t > r.pagesY.length - 1 ? r.pagesY.length - 1 : t, r.currPageX = n, r.currPageY = t, f = r.pagesX[n], u = r.pagesY[t]) : (f = -r.wrapperW * n, u = -r.wrapperH * t, f < r.maxScrollX && (f = r.maxScrollX), u < r.maxScrollY && (u = r.maxScrollY)),
			r.scrollTo(f, u, i)
		},
		disable: function() {
			this.stop(),
			this._resetPos(0),
			this.enabled = !1,
			this._unbind(l, n),
			this._unbind(a, n),
			this._unbind(v, n)
		},
		enable: function() {
			this.enabled = !0
		},
		stop: function() {
			this.options.useTransition ? this._unbind(c) : tt(this.aniTime),
			this.steps = [],
			this.moved = !1,
			this.animating = !1
		},
		zoom: function(n, t, i, r) {
			var u = this,
			e = i / u.scale;
			u.options.useTransform && (u.zoomed = !0, r = r === undefined ? 200 : r, n = n - u.wrapperOffsetLeft - u.x, t = t - u.wrapperOffsetTop - u.y, u.x = n - n * e + u.x, u.y = t - t * e + u.y, u.scale = i, u.refresh(), u.x = u.x > 0 ? 0 : u.x < u.maxScrollX ? u.maxScrollX:u.x, u.y = u.y > u.minScrollY ? u.minScrollY: u.y < u.maxScrollY ? u.maxScrollY: u.y, u.scroller.style[h] = r + "ms", u.scroller.style[f] = "translate(" + u.x + "px," + u.y + "px) scale(" + i + ")" + s, u.zoomed = !1)
		},
		isReady: function() {
			return ! this.moved && !this.zoomed && !this.animating
		}
	},
	y = null,
	typeof exports != "undefined" ? exports.iScroll = k: n.iScroll = k
})(window, document),
$.fn.exists = function() {
	return this.length > 0
},
$.fn.outerHTML = function() {
	return this.length ? this[0].outerHTML ||
	function(n) {
		var t = document.createElement("div"),
		i;
		return t.appendChild(n.cloneNode(!0)),
		i = t.innerHTML,
		t = null,
		i
	} (this[0]) : this
},
$.fn.isVisible = function() {
	var i = this.offset();
	if (i == null) return ! 0;
	var t = i.top,
	n = $(window).scrollTop(),
	r = $(window).height();
	return t > n && t < n + r
},
$(function() {
	if (typeof _bet365_regionData != "undefined") {
		var n = $("#bet365_region");
		n.length > 0 && bet365.help.regionSelector.initialise(_bet365_regionData, n, "#bet365_change_region")
	}
	bet365.help.responsive.initialise(),
	bet365.help.main.initialise()
}),
function() {
	var n = n || {},
	t = 0,
	i = !1;
	n.util = {
		getAdjustedScreenSize: function() {
			return {
				width: Math.round(screen.width - screen.width * .9),
				height: Math.round(screen.height - screen.height * .88)
			}
		}
	},
	n.nav = {
		go: function(n) {
			return window.location.href = n,
			!1
		},
		window: function(t, i, r, u, f) {
			var o = n.util.getAdjustedScreenSize(),
			e = [];
			return e.push("width="),
			e.push(i),
			e.push(",height="),
			e.push(r),
			e.push(",left="),
			e.push(o.width),
			e.push(",top="),
			e.push(o.height),
			e.push(",status=yes,scrollbars=yes,resizable=yes"),
			u ? e.push(",toolbar=yes,menubar=yes,location=yes") : e.push(",toolbar=no,menubar=no,location=no"),
			window.open(t, f, e.join("")),
			!1
		},
		parentWindow: function(n) {
			var r = window.opener,
			t = !0,
			i = !0;
			if (r != null) try {
				t = !this._setTopFrameLocation(n)
			} catch(u) {
				t = !0
			}
			return t ? window.location = n: i && (window.close != undefined ? (window.close(), window != undefined && (window.open(n, "_parent", ""), window.close())) : self.close()),
			!1
		},
		_setTopFrameLocation: function(n) {
			var t = !1;
			try {
				window.opener && (window.opener.frames.top ? (window.opener.frames.top.location = n, t = !0) : window.opener.frames.length > 0 && window.opener.frames.top != null && (window.opener.frames.top.document.location = n, t = !0))
			} catch(i) {
				t = !1
			}
			return t
		}
	},
	n.help = {
		responsive: {
			initialise: function() {
				var n = this._getScreenWidth();
				n > 640 ? this._greaterThan640() : this._lessThanOrEqualTo640(),
				$("#bet365_change_language").click(function() {
					$("#bet365_language").slideToggle()
				}),
				$("#search").val(""),
				$(".bet365_touch .cancel-button").click(function() {
					$(".bet365_touch #searchInput").removeClass("searchExpanded"),
					$(".bannerLogoImage").removeClass("searchMoveOver"),
					$(".title.tabletOnly").removeClass("searchMoveOver"),
					$(".bet365_touch .cancel-button").css("display", "none"),
					$(".bet365_touch #searchInput").attr("placeholder", "Search"),
					$(".bet365_touch #searchInput").val("")
				}),
				this._searchPagesFixes(),
				this._searchBoxFixes()
			},
			_searchPagesFixes: function() {
				this._isTablet() && ($(".divPaginationWrapper").addClass("bet365_tabletdivPaginationWrapper"), $(".divPaginationWrapper .aArrowRight").addClass("bet365_tabletRightArrow"), $(".divPaginationWrapper .aArrowRightDisabled").addClass("bet365_tabletRightArrowDisabled"), $(".divPaginationWrapper .aArrowLeft").addClass("bet365_tabletLeftArrow"), $(".divPaginationWrapper .aArrowLeftDisabled").addClass("bet365_tabletLeftArrowDisabled"), $(".bet365_touch .ui-icon.ui-icon-triangle-1-e").addClass("showArrorwsOnTablet"), $(".searchResultsHeaderRow.searchedForResults").removeClass("mobileSearchHeader"), $(".depositsTab").addClass("depositsTabWidth"), $(".withdrawalsTab").addClass("withdrawalTabWidth")),
				this._isMobile() && ($(".searchResultsHeaderRow.searchedForResults").addClass("mobileSearchHeader"), $(".searchResultsHeaderRow .searchResultsPages").addClass("mobileSearchResults"), $(".searchResultsHeaderRow  .searchResultsCount").addClass("mobileSearchCount"), $(".searchResultsHeaderRow").addClass("mobilesearchResultsHeaderRow"), $(".bet365_touch .ui-icon.ui-icon-triangle-1-e").removeClass("showArrorwsOnTablet"), $(".depositsTab").removeClass("depositsTabWidth"), $(".withdrawalsTab").removeClass("withdrawalTabWidth")),
				this._isMobile() || ($(".searchResultsHeaderRow .searchResultsPages").removeClass("mobileSearchResults"), $(".searchResultsHeaderRow  .searchResultsCount").removeClass("mobileSearchCount"), $(".searchResultsHeaderRow").removeClass("mobilesearchResultsHeaderRow"))
			},
			_searchBoxFixes: function() {
				$(".searchInputHomePageContainer #submit").on("click",
				function() {
					var n = $(".searchInputHomePageContainer #searchInput").val().trim(),
					t = $(".searchInputHomePageContainer #searchInput").attr("placeholder");
					return n != "" && n != t ? !0 : !1
				});
				$(".searchInputContainer #submit").on("click",
				function() {
					var n = $.trim($(".searchInputContainer #searchInput3").val()),
					t = $(".searchInputContainer #searchInput3").attr("placeholder");
					return n != "" && n != t ? !0 : !1
				})
			},
			_isTablet: function() {
				return Modernizr.touch && this._getScreenWidth() > 640
			},
			_isMobile: function() {
				return Modernizr.touch && this._getScreenWidth() <= 640
			},
			_getScreenWidth: function() {
				var n;
				return n = window.innerWidth ? window.innerWidth: window.width ? window.width: $(window).width()
			},
			_ie6fix: function() {
				document.execCommand("BackgroundImageCache", !1, !0)
			},
			_greaterThan640: function() {
				$(".bet365_touch #searchInput").attr("value") && ($(".bet365_touch #searchInput").addClass("searchExpanded"), $(".bet365_touch .cancel-button").css("display", "block"), $(this).attr("placeholder", ""));
				$(".bet365_touch #searchInput").on("click",
				function() {
					var t = $(this).attr("class");
					t != "searchInputHomePage" && ($(this).addClass("searchExpanded"), $(".bet365_touch .cancel-button").css("display", "block"), $(this).attr("placeholder", ""), $(".bannerLogoImage").addClass("searchMoveOver"), $(".title.tabletOnly").addClass("searchMoveOver"))
				})
			},
			_lessThanOrEqualTo640: function() {
				var r, t, n, f, u;
				$("#secondaryNavScroller").exists() && (r = new iScroll("secondaryNavScroller", {
					snap: !0,
					hScrollbar: !1,
					vScrollbar: !1,
					vScroll: !1
				}), r.scrollToElement("#selectednav"));
				$(".textAaaButton").on("click",
				function() {
					$(".textSizerBox").toggle()
				});
				$(".overlay").on("click",
				function(n) { ! $(n.target).is("a") && $(n.target).parent.css().contains("overlay") && n.preventDefault()
				});
				$(".overlayFaqTitle, .overlayFaqAnswer").on("touchstart",
				function() {
					$(".textSizerBox").css("display", "none")
				});
				$(".textSizerButtonDown").on("click",
				function() {
					var r = $(".overlayFaqTitle").css("font-size"),
					i = $(".overlayFaqAnswer").css("font-size");
					r = parseFloat(r),
					i = parseFloat(i),
					t = r - 2,
					n = i - 2,
					n >= 10 && ($(".overlayFaqTitle").css("font-size", t + "px"), $(".overlayFaqAnswer").css("font-size", n + "px"))
				});
				$(".textSizerButtonUp").on("click",
				function() {
					var r = $(".overlayFaqTitle").css("font-size"),
					i = $(".overlayFaqAnswer").css("font-size");
					r = parseFloat(r),
					i = parseFloat(i),
					t = r + 2,
					n = i + 2,
					n <= 22 && ($(".overlayFaqTitle").css("font-size", t + "px"), $(".overlayFaqAnswer").css("font-size", n + "px"))
				});
				f = $(".currencyBox").detach(),
				u = $(".countryBox").detach(),
				u.appendTo(".chooser.contactUsPhone"),
				f.appendTo(".chooser.contactUsPhone");
				var i = $(".paymentsHeader .headerRow"),
				h = i.children(".paymentFee").outerHTML(),
				c = i.children(".paymentTime").outerHTML(),
				s = i.children(".paymentMin").outerHTML(),
				e = i.children(".paymentMax").outerHTML(),
				o = $("#accordion h3 .paymentsRow .innerTableRow");
				o.each(function(n) {
					var t = "uniqueId_" + n;
					$(this).attr("id", t);
					var u = $("#" + t + " .paymentsCell.paymentFee").detach(),
					f = $("#" + t + " .paymentsCell.paymentTime").detach(),
					i = $("#" + t + " .paymentsCell.paymentMin").detach(),
					r = $("#" + t + " .paymentsCell.paymentMax").detach();
					$(this).parents("h3").next().prepend(r),
					$(this).parents("h3").next().prepend(i),
					$(this).parents("h3").next().prepend(e),
					$(this).parents("h3").next().prepend(s),
					$(this).parents("h3").next().prepend(f),
					$(this).parents("h3").next().prepend(u),
					$(this).parents("h3").next().prepend(c),
					$(this).parents("h3").next().prepend(h)
				}),
				$(".paymentsCell.paymentFee").css("display", "block"),
				$(".paymentsCell.paymentTime").css("display", "block"),
				$(".paymentsCell.paymentMin").css("display", "block"),
				$(".paymentsCell.paymentMax").css("display", "block"),
				$("table").each(function() {});
				$(".searchBoxCloseCircle").on("click",
				function() {
					var n = $(this).closest(".searchInputContainer").find(".searchInput");
					n.val("")
				});
				$("#searchInput").on("click",
				function() {
					$("#searchInput").attr("placeholder", "Search")
				})
			}
		},
		main: {
			initialise: function() {
				var u = this,
				o, c, s;
				this._setupSearchForm("#search-form", "#searchInput"),
				this._setupSearchForm("#search-form1", "#searchInput1"),
				this._setupSearchForm("#search-form2", "#searchInput2"),
				this._setupSearchForm("#search-form3", "#searchInput3"),
				this._setupPlaceHolders();
				$("#bet365_language select").on("change",
				function() {
					window.location = this.options[this.selectedIndex].value
				});
				n.help.responsive._isMobile() ? $(window).scrollTop(t) : (o = window.location.href, o.indexOf("#") > -1 && $(".leftMenuWrapper .leftNavItem").attr("id", "")),
				n.help.responsive._isMobile() && (c = /windows phone/i.test(navigator.userAgent.toLowerCase()), c && ($(".bet365_touch .paymentsCell.paymentMethod").addClass("windowsPhone"), $(".bet365_touch .paymentsCell.paymentName").addClass("windowsPhone"), $(".bet365_touch .paymentsCell.paymentMax").addClass("windowsPhone"), $(".bet365_touch .paymentsCell.paymentMin").addClass("windowsPhone"), $(".bet365_touch .paymentsCell.paymentTime").addClass("windowsPhone"), $(".bet365_touch .paymentsCell.paymentFee").addClass("windowsPhone")));
				$(".chooser select#country").on("change",
				function() {
					u._isValidPath(window.location.pathname) ? window.location.href = window.location.pathname + "@countryId=" + $(this).val() : console.log("invalid path")
				});
				$(".chooser .countryBox select.country,.chooser .currencyBox select.currency").change(function() {
					u._refeshPaymentMethods(1)
				}),
				$(".tertiaryTabs .depositsTab, .tertiaryTabs .withdrawalsTab").click(function() {
					if ($(this).hasClass("selected")) return ! 1;
					var n = 1;
					typeof $(this).attr("role") != "undefined" && (n = $(this).attr("role")),
					u._refeshPaymentMethods(n)
				}),
				$("#doneBackButton").click(function() {
					var o;
					$(".overlay").hide(),
					$(".textSizerBox").css("display", "none"),
					$("body").removeClass("noscroll"),
					u._removeOverlay();
					var r = window.location.href,
					e = "",
					s = !1,
					f = 0;
					return r.indexOf("#") > -1 && (e = r.substring(r.indexOf("#") + 1), s = !0, f = $("#" + e).offset().top, o = r.substring(0, r.lastIndexOf("/")) + "#" + e, window.location.href = o),
					i ? window.history.go( - 1) : s && $(window).height() < f ? window.scrollTo(0, f) : $(window).scrollTop(t),
					!1
				}),
				n.help.responsive._isMobile() && ($(".footerLogoLink").each(function() {
					u._setupPopupLink(this, u, !1)
				}), $(".searchResultsRow").each(function() {
					u._setupPopupLink(this, u, !1)
				})),
				n.help.responsive._isMobile() & $(".faqWrapper").length > 0 ? $(".faqQuestion").each(function() {
					$(this).click(function() {
						return $(".overlayFaqTitle").text($(this).find(".faqQuestionInner").text()),
						$(".overlayFaqAnswer").html($(this).next().html()),
						t = $(window).scrollTop(),
						u._showOverlay(),
						!1
					})
				}) : ($("#accordion").accordion({
					collapsible: !0,
					active: !1,
					alwaysOpen: !1,
					iconsRight: !0,
					deepLinking: !0,
					autoHeight: !1
				}), $("#accordion").bind("accordionchange",
				function(n, t) {
					if (!t.newHeader.isVisible()) {
						var i = t.newHeader.offset().top;
						$("body").animate({
							scrollTop: i
						},
						200,
						function() {
							t.newHeader.isVisible() || window.scrollTo(0, i)
						})
					}
				}));
				var e = 6,
				h = window.location.href,
				f = h.split("/"),
				r = f[6];
				r != null && r.length > 0 || (r = f[5], e = 5),
				r != null && r.length > 0 || (r = f[4], e = 4),
				h.indexOf("?") != -1 && r != undefined && (s = r.split("?"), r = s[0]),
				r != undefined && this._openSelectedTab(r, e)
			},
			_setupPopupLink: function(n, i, r) {
				$(n).click(function(n) {
					return r ? $(".overlayFaqTitle").text($(this).text()) : $(".overlayFaqTitle").text(""),
					$(this).attr("href").split(/\//).length <= 5 ? ($.ajax({
						url: $(this).attr("href"),
						type: "GET",
						success: function(n) {
							$(".overlayFaqAnswer").html($($.parseHTML(n)).find(".singleDocumentPage").clone().wrap("<div>").parent().html()),
							$(".overlayFaqAnswer").find(".singleDocumentPage").removeClass(),
							t = $(window).scrollTop(),
							i._showOverlay()
						}
					}), n.preventDefault(), !1) : !0
				})
			},
			_showOverlay: function() {
				$("body").addClass("noscroll"),
				$(".siteAdminControls,.siteAdmin,.divLanguageDropDown,.noSearch,.navWrapperWrapper,.pageWrapper.noSecondaryNav,.newFooter").addClass("readDocument"),
				$(".overlay").show()
			},
			_removeOverlay: function() {
				$(".siteAdminControls,.siteAdmin,.divLanguageDropDown,.noSearch,.navWrapperWrapper,.pageWrapper.noSecondaryNav,.newFooter").removeClass("readDocument")
			},
			_preventScroll: function(n) {
				n.preventDefault()
			},
			_setupPlaceHolders: function() {
				$("[placeholder]").focus(function() {
					var n = $(this);
					n.val() == n.attr("placeholder") && (n.val(""), n.removeClass("placeholder"))
				}).blur(function() {
					var n = $(this); (n.val() == "" || n.val() == n.attr("placeholder")) && (n.addClass("placeholder"), n.val(n.attr("placeholder")))
				}).blur()
			},
			_setupSearchForm: function(n, t) {
				$(n).submit(function(n) {
					$(t).val().length == 0 && n.preventDefault()
				})
			},
			_isValidPath: function(n) {
				var t = new RegExp("^/{1}[a-zA-Z]{2}(-[a-zA-Z]{2,3})?/{1}");
				return t.test(n)
			},
			_refeshPaymentMethods: function(n) {
				$("#selectedTab").val(n),
				$("#paymentForm").submit()
			},
			_openSelectedTab: function(t, r) {
				for (var s = this,
				e = 0,
				o = $("div#accordion a#accumulator"), h, f, u = 0; u < o.length; u++) if (h = $.trim(o[u].href).split("/"), f = h[6], f != null && f.length > 0 || (f = h[5]), f == t) {
					e = u,
					n.help.responsive._isMobile() ? ($(".overlayFaqTitle").text($(o[e]).find(".faqQuestionInner").text()), $(".overlayFaqAnswer").html($(o[e]).next().html()), s._showOverlay()) : $("#accordion").accordion("activate", e);
					return
				}
				n.help.responsive._isMobile() & $(".rightContentWrapper").length > 0 & r > 5 && ($(".overlayFaqTitle").text($(".rightContentWrapper").find(".rulesTitle").text()), $(".overlayFaqAnswer").html($(".rightContentWrapper").find(".rulesContentWrapper").html()), s._showOverlay()),
				n.help.responsive._isMobile() & $(".singleDocumentPage").length > 0 && ($(".overlayFaqAnswer").html($(".singleDocumentPage").html()), $(".overlayFaqAnswer>div>p:first-child:empty").remove(), $(".overlayFaqAnswer").find(".singleDocumentPage").removeClass(), i = !0, s._showOverlay())
			},
			_updateHeights: function() {
				$(".faqQuestion") && $(".faqQuestion").each(function() {
					$(this).height() > 40 && $(this).children("span:first").css("margin-top", "23px")
				})
			}
		},
		regionSelector: {
			_regionData: null,
			_container: null,
			_anchor: null,
			_groupSelect: null,
			_countrySelect: null,
			_stateSelect: null,
			_update: null,
			_defaultTimeout: 8e3,
			_timerEnabled: !0,
			_selectedGroup: null,
			_selectedCountry: null,
			_selectedState: null,
			initialise: function(n, t, i) {
				this._regionData = n,
				this._container = t;
				var r = t[0].id;
				this._groupSelect = this._createSelect(r + "_group"),
				this._countrySelect = this._createSelect(r + "_country"),
				this._stateSelect = this._createSelect(r + "_state"),
				this._container.append(this._groupSelect, this._countrySelect, this._stateSelect),
				this._groupSelect.change($.proxy(this._updateGroupSelect, this)),
				this._countrySelect.change($.proxy(this._updateCountrySelect, this)),
				this._stateSelect.change($.proxy(this._updateStateSelect, this)),
				this._populateSelect(this._groupSelect, n.data ? n.data: null, n.groupId),
				this._updateGroupSelect(),
				this._countrySelect.val(n.countryId),
				this._updateCountrySelect(),
				this._stateSelect.val(n.stateId),
				this._updateStateSelect(),
				this._update = $('<input id="' + r + '_update" type="button" value="Update" />'),
				this._container.append(this._update),
				this._update.click($.proxy(this._ev_updateClick, this)),
				this._anchor = $(i),
				this._anchor.click($.proxy(this._ev_anchorClick, this)),
				this._initHideShow()
			},
			_initHideShow: function() {
				$(".show_hide").show(),
				$(".siteAdmin").slideDown(),
				$(".show_hide").toggle(function() {
					$(".siteAdmin").slideUp(function() {
						$("#plus").text("S")
					})
				},
				function() {
					$(".siteAdmin").slideDown(function() {
						$("#plus").text("H")
					})
				})
			},
			_createSelect: function(n) {
				return $("<select></select>", {
					id: n
				})
			},
			_populateSelect: function(n, t, i) {
				var r, f, o, e, u;
				if (n.empty(), r = [], r.push('<option value="">(Not Set)</option>'), t) for (e = t.length, u = 0; u < e; u++) f = t[u],
				r.push('<option value="'),
				r.push(f.value),
				r.push('"'),
				f.value === i && r.push(" selected"),
				r.push(">"),
				r.push(f.text),
				r.push("</option>");
				n.append(r.join(""))
			},
			_find: function(n, t) {
				for (var r, u = n.length,
				i = 0; i < u; i++) if (r = n[i], r.value === t) return r;
				return null
			},
			_updateGroupSelect: function() {
				this._selectedGroup = this._find(this._regionData.data, parseInt(this._groupSelect.val())),
				this._populateSelect(this._countrySelect, this._selectedGroup ? this._selectedGroup.children: null, null),
				this._populateSelect(this._stateSelect, null, null)
			},
			_updateCountrySelect: function() {
				this._selectedCountry = this._find(this._selectedGroup.children, parseInt(this._countrySelect.val())),
				this._populateSelect(this._stateSelect, this._selectedCountry ? this._selectedCountry.children: null, null)
			},
			_updateStateSelect: function() {
				this._selectedState = this._find(this._selectedCountry.children, parseInt(this._stateSelect.val()))
			},
			isVisible: function() {
				return this._container.is(":visible")
			},
			show: function() {
				this._container.slideDown(100)
			},
			hide: function() {
				this._container.slideUp(100)
			},
			_beginHide: function() {
				var n = this;
				this._beginTimer(300,
				function() {
					n.hide()
				})
			},
			_enableTimer: function(n) {
				n || this._cancelTimer(),
				this._timerEnabled = n
			},
			_beginTimer: function(n, t) {
				this._timerEnabled && (this._timerId = setTimeout(t, n))
			},
			_cancelTimer: function() {
				this._timerId && (clearTimeout(this._timerId), this._timerId = null)
			},
			_ev_updateClick: function() {
				var i = parseInt(this._countrySelect.val()),
				n,
				r,
				t;
				isNaN(i) && (i = ""),
				n = parseInt(this._stateSelect.val()),
				isNaN(n) && (n = ""),
				r = {
					ct: i,
					cs: n
				},
				this._enableTimer(!1),
				this._update.attr("disabled", "disabled").val("Updating"),
				t = this,
				$.ajax(this._regionData.serviceUrl, {
					type: "POST",
					dataType: "text",
					cache: !1,
					data: r,
					timeout: this._defaultTimeout
				}).done(function() {
					document.location.reload(!0)
				}).fail(function(n, t) {
					console.log("Failed to update: " + t)
				}).always(function() {
					t._update.removeAttr("disabled").val("Update"),
					t._enableTimer(!0)
				}),
				this.hide()
			},
			_ev_anchorClick: function(n) {
				return this.isVisible() ? this.hide() : this.show(),
				n.preventDefault(),
				!1
			},
			_ev_mouseout: function() {
				this.isVisible() && this._beginHide()
			},
			_ev_mouseover: function() {
				this._cancelTimer()
			}
		}
	},
	window.bet365 = n
} ()