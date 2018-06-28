window.Modernizr = function(n, t, i) {
	function l(n) {
		h.cssText = n
	}
	function yt(n, t) {
		return l(y.join(n + ";") + (t || ""))
	}
	function s(n, t) {
		return typeof n === t
	}
	function v(n, t) {
		return !! ~ ("" + n).indexOf(t)
	}
	function ft(n, t) {
		var u, r;
		for (u in n) if (r = n[u], !v(r, "-") && h[r] !== i) return t == "pfx" ? r: !0;
		return ! 1
	}
	function vt(n, t, r) {
		var f, u;
		for (f in n) if (u = t[n[f]], u !== i) return r === !1 ? n[f] : s(u, "function") ? u.bind(r || t) : u;
		return ! 1
	}
	function f(n, t, i) {
		var r = n.charAt(0).toUpperCase() + n.slice(1),
		u = (n + " " + ct.join(r + " ") + r).split(" ");
		return s(t, "string") || s(t, "undefined") ? ft(u, t) : (u = (n + " " + ht.join(r + " ") + r).split(" "), vt(u, t, i))
	}
	function at() {
		u.input = function(i) {
			for (var r = 0,
			u = i.length; r < u; r++) p[i[r]] = i[r] in e;
			return p.list && (p.list = !!t.createElement("datalist") && !!n.HTMLDataListElement),
			p
		} ("autocomplete autofocus list placeholder max min multiple pattern required step".split(" ")),
		u.inputtypes = function(n) {
			for (var f = 0,
			r, u, s, h = n.length; f < h; f++) e.setAttribute("type", u = n[f]),
			r = e.type !== "text",
			r && (e.value = it, e.style.cssText = "position:absolute;visibility:hidden;", /^range$/.test(u) && e.style.WebkitAppearance !== i ? (o.appendChild(e), s = t.defaultView, r = s.getComputedStyle && s.getComputedStyle(e, null).WebkitAppearance !== "textfield" && e.offsetHeight !== 0, o.removeChild(e)) : /^(search|tel)$/.test(u) || (r = /^(url|email)$/.test(u) ? e.checkValidity && e.checkValidity() === !1 : e.value != it)),
			ut[n[f]] = !!r;
			return ut
		} ("search tel url email datetime date month week time datetime-local number range color".split(" "))
	}
	var lt = "2.6.2",
	u = {},
	tt = !0,
	o = t.documentElement,
	c = "modernizr",
	ot = t.createElement(c),
	h = ot.style,
	e = t.createElement("input"),
	it = ":)",
	et = {}.toString,
	y = " -webkit- -moz- -o- -ms- ".split(" "),
	st = "Webkit Moz O ms",
	ct = st.split(" "),
	ht = st.toLowerCase().split(" "),
	d = {
		svg: "http://www.w3.org/2000/svg"
	},
	r = {},
	ut = {},
	p = {},
	nt = [],
	rt = nt.slice,
	w,
	a = function(n, i, r, u) {
		var v, l, h, a, f = t.createElement("div"),
		s = t.body,
		e = s || t.createElement("body");
		if (parseInt(r, 10)) while (r--) h = t.createElement("div"),
		h.id = u ? u[r] : c + (r + 1),
		f.appendChild(h);
		return v = ["&#173;", '<style id="s', c, '">', n, "</style>"].join(""),
		f.id = c,
		(s ? f: e).innerHTML += v,
		e.appendChild(f),
		s || (e.style.background = "", e.style.overflow = "hidden", a = o.style.overflow, o.style.overflow = "hidden", o.appendChild(e)),
		l = i(f, n),
		s ? f.parentNode.removeChild(f) : (e.parentNode.removeChild(e), o.style.overflow = a),
		!!l
	},
	pt = function(t) {
		var r = n.matchMedia || n.msMatchMedia,
		i;
		return r ? r(t).matches: (a("@media " + t + " { #" + c + " { position: absolute; } }",
		function(t) {
			i = (n.getComputedStyle ? getComputedStyle(t, null) : t.currentStyle).position == "absolute"
		}), i)
	},
	wt = function() {
		function r(r, u) {
			u = u || t.createElement(n[r] || "div"),
			r = "on" + r;
			var f = r in u;
			return f || (u.setAttribute || (u = t.createElement("div")), u.setAttribute && u.removeAttribute && (u.setAttribute(r, ""), f = s(u[r], "function"), s(u[r], "undefined") || (u[r] = i), u.removeAttribute(r))),
			u = null,
			f
		}
		var n = {
			select: "input",
			change: "input",
			submit: "form",
			reset: "form",
			error: "img",
			load: "img",
			abort: "img"
		};
		return r
	} (),
	g = {}.hasOwnProperty,
	k,
	b;
	k = !s(g, "undefined") && !s(g.call, "undefined") ?
	function(n, t) {
		return g.call(n, t)
	}: function(n, t) {
		return t in n && s(n.constructor.prototype[t], "undefined")
	},
	Function.prototype.bind || (Function.prototype.bind = function(n) {
		var t = this,
		r, i;
		if (typeof t != "function") throw new TypeError;
		return r = rt.call(arguments, 1),
		i = function() {
			var f, e, u;
			return this instanceof i ? (f = function() {},
			f.prototype = t.prototype, e = new f, u = t.apply(e, r.concat(rt.call(arguments))), Object(u) === u ? u: e) : t.apply(n, r.concat(rt.call(arguments)))
		},
		i
	}),
	r.flexbox = function() {
		return f("flexWrap")
	},
	r.flexboxlegacy = function() {
		return f("boxDirection")
	},
	r.canvas = function() {
		var n = t.createElement("canvas");
		return !! n.getContext && !!n.getContext("2d")
	},
	r.canvastext = function() {
		return !! u.canvas && !!s(t.createElement("canvas").getContext("2d").fillText, "function")
	},
	r.webgl = function() {
		return !! n.WebGLRenderingContext
	},
	r.getScreenWidth = function() {
		var t;
		return t = n.innerWidth ? n.innerWidth: n.width ? n.width: n.width
	},
	r.touch = function() {
		var i, u = /windows phone/i.test(navigator.userAgent.toLowerCase());
		return u ? !0 : ("ontouchstart" in n || "onmsgesturechange" in n && r.getScreenWidth() <= 640 || n.DocumentTouch && t instanceof DocumentTouch ? i = !0 : a(["@media (", y.join("touch-enabled),("), c, ")", "{#modernizr{top:9px;position:absolute}}"].join(""),
		function(n) {
			i = n.offsetTop === 9
		}), i)
	},
	r.geolocation = function() {
		return "geolocation" in navigator
	},
	r.indexedDB = function() {
		return !! f("indexedDB", n)
	},
	r.history = function() {
		return !! n.history && !!history.pushState
	},
	r.draganddrop = function() {
		var n = t.createElement("div");
		return "draggable" in n || "ondragstart" in n && "ondrop" in n
	},
	r.rgba = function() {
		return l("background-color:rgba(150,255,150,.5)"),
		v(h.backgroundColor, "rgba")
	},
	r.hsla = function() {
		return l("background-color:hsla(120,40%,100%,.5)"),
		v(h.backgroundColor, "rgba") || v(h.backgroundColor, "hsla")
	},
	r.multiplebgs = function() {
		return l("background:url(../https@),url(https://),red url(https://)"),
		/(url\s*\(.*?){3}/.test(h.background)
	},
	r.backgroundsize = function() {
		return f("backgroundSize")
	},
	r.borderimage = function() {
		return f("borderImage")
	},
	r.borderradius = function() {
		return f("borderRadius")
	},
	r.boxshadow = function() {
		return f("boxShadow")
	},
	r.textshadow = function() {
		return t.createElement("div").style.textShadow === ""
	},
	r.opacity = function() {
		return yt("opacity:.55"),
		/^0.55$/.test(h.opacity)
	},
	r.cssanimations = function() {
		return f("animationName")
	},
	r.csscolumns = function() {
		return f("columnCount")
	},
	r.cssgradients = function() {
		var n = "background-image:",
		i = "gradient(linear,left top,right bottom,from(#9f9),to(white));",
		t = "linear-gradient(left top,#9f9, white);";
		return l((n + "-webkit- ".split(" ").join(i + n) + y.join(t + n)).slice(0, -n.length)),
		v(h.backgroundImage, "gradient")
	},
	r.cssreflections = function() {
		return f("boxReflect")
	},
	r.csstransforms = function() {
		return !! f("transform")
	},
	r.csstransforms3d = function() {
		var n = !!f("perspective");
		return n && "webkitPerspective" in o.style && a("@media (transform-3d),(-webkit-transform-3d){#modernizr{left:9px;position:absolute;height:3px;}}",
		function(t) {
			n = t.offsetLeft === 9 && t.offsetHeight === 3
		}),
		n
	},
	r.csstransitions = function() {
		return f("transition")
	},
	r.fontface = function() {
		var n;
		return a('@font-face {font-family:"font";src:url("../https@")}',
		function(i, r) {
			var e = t.getElementById("smodernizr"),
			u = e.sheet || e.styleSheet,
			f = u ? u.cssRules && u.cssRules[0] ? u.cssRules[0].cssText: u.cssText || "": "";
			n = /src/i.test(f) && f.indexOf(r.split(" ")[0]) === 0
		}),
		n
	},
	r.generatedcontent = function() {
		var n;
		return a(["#", c, "{font:0/0 a}#", c, ':after{content:"', it, '";visibility:hidden;font:3px/1 a}'].join(""),
		function(t) {
			n = t.offsetHeight >= 3
		}),
		n
	},
	r.video = function() {
		var i = t.createElement("video"),
		n = !1;
		try { (n = !!i.canPlayType) && (n = new Boolean(n), n.ogg = i.canPlayType('video/ogg; codecs="theora"').replace(/^no$/, ""), n.h264 = i.canPlayType('video/mp4; codecs="avc1.42E01E"').replace(/^no$/, ""), n.webm = i.canPlayType('video/webm; codecs="vp8, vorbis"').replace(/^no$/, ""))
		} catch(r) {}
		return n
	},
	r.audio = function() {
		var i = t.createElement("audio"),
		n = !1;
		try { (n = !!i.canPlayType) && (n = new Boolean(n), n.ogg = i.canPlayType('audio/ogg; codecs="vorbis"').replace(/^no$/, ""), n.mp3 = i.canPlayType("audio/mpeg;").replace(/^no$/, ""), n.wav = i.canPlayType('audio/wav; codecs="1"').replace(/^no$/, ""), n.m4a = (i.canPlayType("audio/x-m4a;") || i.canPlayType("audio/aac;")).replace(/^no$/, ""))
		} catch(r) {}
		return n
	},
	r.svg = function() {
		return !! t.createElementNS && !!t.createElementNS(d.svg, "svg").createSVGRect
	},
	r.inlinesvg = function() {
		var n = t.createElement("div");
		return n.innerHTML = "<svg/>",
		(n.firstChild && n.firstChild.namespaceURI) == d.svg
	},
	r.smil = function() {
		return !! t.createElementNS && /SVGAnimate/.test(et.call(t.createElementNS(d.svg, "animate")))
	},
	r.svgclippaths = function() {
		return !! t.createElementNS && /SVGClipPath/.test(et.call(t.createElementNS(d.svg, "clipPath")))
	};
	for (b in r) k(r, b) && (w = b.toLowerCase(), u[w] = r[b](), nt.push((u[w] ? "": "no-") + w));
	return u.input || at(),
	u.addTest = function(n, t) {
		if (typeof n == "object") for (var r in n) k(n, r) && u.addTest(r, n[r]);
		else {
			if (n = n.toLowerCase(), u[n] !== i) return u;
			t = typeof t == "function" ? t() : t,
			typeof tt != "undefined" && tt && (o.className += " bet365_" + (t ? "": "no-") + n),
			u[n] = t
		}
		return u
	},
	l(""),
	ot = e = null,
	function(n, t) {
		function y(n, t) {
			var r = n.createElement("p"),
			i = n.getElementsByTagName("head")[0] || n.documentElement;
			return r.innerHTML = "x<style>" + t + "</style>",
			i.insertBefore(r.lastChild, i.firstChild)
		}
		function a() {
			var n = i.elements;
			return typeof n == "string" ? n.split(" ") : n
		}
		function o(n) {
			var t = h[n[s]];
			return t || (t = {},
			e++, n[s] = e, h[e] = t),
			t
		}
		function l(n, i, u) {
			if (i || (i = t), r) return i.createElement(n);
			u || (u = o(i));
			var f;
			return f = u.cache[n] ? u.cache[n].cloneNode() : p.test(n) ? (u.cache[n] = u.createElem(n)).cloneNode() : u.createElem(n),
			f.canHaveChildren && !v.test(n) ? u.frag.appendChild(f) : f
		}
		function b(n, i) {
			if (n || (n = t), r) return n.createDocumentFragment();
			i = i || o(n);
			for (var e = i.frag.cloneNode(), u = 0, f = a(), s = f.length; u < s; u++) e.createElement(f[u]);
			return e
		}
		function w(n, t) {
			t.cache || (t.cache = {},
			t.createElem = n.createElement, t.createFrag = n.createDocumentFragment, t.frag = t.createFrag()),
			n.createElement = function(r) {
				return i.shivMethods ? l(r, n, t) : t.createElem(r)
			},
			n.createDocumentFragment = Function("h,f", "return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&(" + a().join().replace(/\w+/g,
			function(n) {
				return t.createElem(n),
				t.frag.createElement(n),
				'c("' + n + '")'
			}) + ");return n}")(i, t.frag)
		}
		function c(n) {
			n || (n = t);
			var f = o(n);
			return i.shivCSS && !u && !f.hasCSS && (f.hasCSS = !!y(n, "article,aside,figcaption,figure,footer,header,hgroup,nav,section{display:block}mark{background:#FF0;color:#000}")),
			r || w(n, f),
			n
		}
		var f = n.html5 || {},
		v = /^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,
		p = /^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,
		u, s = "_html5shiv",
		e = 0,
		h = {},
		r, i; (function() {
			try {
				var n = t.createElement("a");
				n.innerHTML = "<xyz></xyz>",
				u = "hidden" in n,
				r = n.childNodes.length == 1 ||
				function() {
					t.createElement("a");
					var n = t.createDocumentFragment();
					return typeof n.cloneNode == "undefined" || typeof n.createDocumentFragment == "undefined" || typeof n.createElement == "undefined"
				} ()
			} catch(i) {
				u = !0,
				r = !0
			}
		})(),
		i = {
			elements: f.elements || "abbr article aside audio bdi canvas data datalist details figcaption figure footer header hgroup mark meter nav output progress section summary time video",
			shivCSS: f.shivCSS !== !1,
			supportsUnknownElements: r,
			shivMethods: f.shivMethods !== !1,
			type: "default",
			shivDocument: c,
			createElement: l,
			createDocumentFragment: b
		},
		n.html5 = i,
		c(t)
	} (this, t),
	u._version = lt,
	u._prefixes = y,
	u._domPrefixes = ht,
	u._cssomPrefixes = ct,
	u.mq = pt,
	u.hasEvent = wt,
	u.testProp = function(n) {
		return ft([n])
	},
	u.testAllProps = f,
	u.testStyles = a,
	u.prefixed = function(n, t, i) {
		return t ? f(n, t, i) : f(n, "pfx")
	},
	o.className = o.className.replace(/(^|\s)no-js(\s|$)/, "$1$2") + (tt ? " bet365_js bet365_" + nt.join(" bet365_") : ""),
	u
} (this, this.document),
function(n, t, i) {
	function c(n) {
		return "[object Function]" == p.call(n)
	}
	function v(n) {
		return "string" == typeof n
	}
	function h() {}
	function k(n) {
		return ! n || "loaded" == n || "complete" == n || "uninitialized" == n
	}
	function f() {
		var n = a.shift();
		l = 1,
		n ? n.t ? s(function() { ("c" == n.t ? r.injectCss: r.injectJs)(n.s, 0, n.a, n.x, n.e, 1)
		},
		0) : (n(), f()) : l = 0
	}
	function et(n, i, o, h, c, v, y) {
		function d(t) {
			if (!g && k(p.readyState) && (b.r = g = 1, !l && f(), p.onload = p.onreadystatechange = null, t)) {
				"img" != n && s(function() {
					rt.removeChild(p)
				},
				50);
				for (var r in u[i]) u[i].hasOwnProperty(r) && u[i][r].onload()
			}
		}
		var y = y || r.errorTimeout,
		p = t.createElement(n),
		g = 0,
		w = 0,
		b = {
			t: o,
			s: i,
			e: c,
			a: v,
			x: y
		};
		1 === u[i] && (w = 1, u[i] = []),
		"object" == n ? p.data = i: (p.src = i, p.type = n),
		p.width = p.height = "0",
		p.onerror = p.onload = p.onreadystatechange = function() {
			d.call(this, w)
		},
		a.splice(h, 0, b),
		"img" != n && (w || 2 === u[i] ? (rt.insertBefore(p, nt ? null: e), s(d, y)) : u[i].push(p))
	}
	function ft(n, t, i, r, u) {
		return l = 0,
		t = t || "j",
		v(n) ? et("c" == t ? ut: g, n, t, this.i++, i, r, u) : (a.splice(this.i++, 0, n), 1 == a.length && f()),
		this
	}
	function it() {
		var n = r;
		return n.loader = {
			load: ft,
			i: 0
		},
		n
	}
	var o = t.documentElement,
	s = n.setTimeout,
	e = t.getElementsByTagName("script")[0],
	p = {}.toString,
	a = [],
	l = 0,
	tt = "MozAppearance" in o.style,
	nt = tt && !!t.createRange().compareNode,
	rt = nt ? o: e.parentNode,
	o = n.opera && "[object Opera]" == p.call(n.opera),
	o = !!t.attachEvent && !o,
	g = tt ? "object": o ? "script": "img",
	ut = o ? "script": g,
	w = Array.isArray ||
	function(n) {
		return "[object Array]" == p.call(n)
	},
	y = [],
	u = {},
	b = {
		timeout: function(n, t) {
			return t.length && (n.timeout = t[0]),
			n
		}
	},
	d,
	r;
	r = function(n) {
		function l(n) {
			for (var n = n.split("!"), e = y.length, i = n.pop(), f = n.length, i = {
				url: i,
				origUrl: i,
				prefixes: n
			},
			u, r, t = 0; t < f; t++) r = n[t].split("="),
			(u = b[r.shift()]) && (i = u(i, r));
			for (t = 0; t < e; t++) i = y[t](i);
			return i
		}
		function o(n, t, r, f, e) {
			var o = l(n),
			s = o.autoCallback;
			o.url.split(".").pop().split("?").shift(),
			o.bypass || (t && (t = c(t) ? t: t[n] || t[f] || t[n.split("/").pop().split("?")[0]]), o.instead ? o.instead(n, t, r, f, e) : (u[o.url] ? o.noexec = !0 : u[o.url] = 1, r.load(o.url, o.forceCSS || !o.forceJS && "css" == o.url.split(".").pop().split("?").shift() ? "c": i, o.noexec, o.attrs, o.timeout), (c(t) || c(s)) && r.load(function() {
				it(),
				t && t(o.origUrl, e, f),
				s && s(o.origUrl, e, f),
				u[o.url] = 2
			})))
		}
		function s(n, t) {
			function l(n, f) {
				if (n) {
					if (v(n)) f || (i = function() {
						var n = [].slice.call(arguments);
						e.apply(this, n),
						u()
					}),
					o(n, i, t, 0, s);
					else if (Object(n) === n) for (r in a = function() {
						var i = 0,
						t;
						for (t in n) n.hasOwnProperty(t) && i++;
						return i
					} (), n) n.hasOwnProperty(r) && (!f && !--a && (c(i) ? i = function() {
						var n = [].slice.call(arguments);
						e.apply(this, n),
						u()
					}: i[r] = function(n) {
						return function() {
							var t = [].slice.call(arguments);
							n && n.apply(this, t),
							u()
						}
					} (e[r])), o(n[r], i, t, r, s))
				} else ! f && u()
			}
			var s = !!n.test,
			f = n.load || n.both,
			i = n.callback || h,
			e = i,
			u = n.complete || h,
			a, r;
			l(s ? n.yep: n.nope, !!f),
			f && l(f)
		}
		var f, t, e = this.yepnope.loader;
		if (v(n)) o(n, 0, e, 0);
		else if (w(n)) for (f = 0; f < n.length; f++) t = n[f],
		v(t) ? o(t, 0, e, 0) : w(t) ? r(t) : Object(t) === t && s(t, e);
		else Object(n) === n && s(n, e)
	},
	r.addPrefix = function(n, t) {
		b[n] = t
	},
	r.addFilter = function(n) {
		y.push(n)
	},
	r.errorTimeout = 1e4,
	null == t.readyState && t.addEventListener && (t.readyState = "loading", t.addEventListener("DOMContentLoaded", d = function() {
		t.removeEventListener("DOMContentLoaded", d, 0),
		t.readyState = "complete"
	},
	0)),
	n.yepnope = it(),
	n.yepnope.executeStack = f,
	n.yepnope.injectJs = function(n, i, u, o, c, l) {
		var a = t.createElement("script"),
		v,
		y,
		o = o || r.errorTimeout;
		a.src = n;
		for (y in u) a.setAttribute(y, u[y]);
		i = l ? f: i || h,
		a.onreadystatechange = a.onload = function() { ! v && k(a.readyState) && (v = 1, i(), a.onload = a.onreadystatechange = null)
		},
		s(function() {
			v || (v = 1, i(1))
		},
		o),
		c ? a.onload() : e.parentNode.insertBefore(a, e)
	},
	n.yepnope.injectCss = function(n, i, r, u, o, c) {
		var u = t.createElement("link"),
		l,
		i = c ? f: i || h;
		u.href = n,
		u.rel = "stylesheet",
		u.type = "text/css";
		for (l in r) u.setAttribute(l, r[l]);
		o || (e.parentNode.insertBefore(u, e), s(i, 0))
	}
} (this, document),
Modernizr.load = function() {
	yepnope.apply(window, [].slice.call(arguments, 0))
},
Modernizr.addTest("boxsizing",
function() {
	return Modernizr.testAllProps("boxSizing") && (document.documentMode === undefined || document.documentMode > 7)
}),
Modernizr.addTest("subpixelfont",
function() {
	var n, t = "#modernizr{position: absolute; top: -10em; visibility:hidden; font: normal 10px arial;}#subpixel{float: left; font-size: 33.3333%;}";
	return Modernizr.testStyles(t,
	function(t) {
		var i = t.firstChild;
		i.innerHTML = "This is a text written in Arial",
		n = window.getComputedStyle ? window.getComputedStyle(i, null).getPropertyValue("width") !== "44px": !1
	},
	1, ["subpixel"]),
	n
}),
Modernizr.addTest("ie8compat",
function() {
	return ! window.addEventListener && document.documentMode && document.documentMode === 7
}),
Modernizr.addTest("mediaqueries", Modernizr.mq("only all")),
Modernizr.addTest("svgfilters",
function() {
	var n = !1;
	try {
		n = typeof SVGFEColorMatrixElement !== undefined && SVGFEColorMatrixElement.SVG_FECOLORMATRIX_TYPE_SATURATE == 2
	} catch(t) {}
	return n
}),
function(n, t) {
	function ku(n) {
		var t = dt[n] = {};
		return i.each(n.split(c),
		function(n, i) {
			t[i] = !0
		}),
		t
	}
	function dr(n, r, u) {
		if (u === t && n.nodeType === 1) {
			var f = "data-" + r.replace(su, "-$1").toLowerCase();
			if (u = n.getAttribute(f), typeof u == "string") {
				try {
					u = u === "true" ? !0 : u === "false" ? !1 : u === "null" ? null: +u + "" === u ? +u: fu.test(u) ? i.parseJSON(u) : u
				} catch(e) {}
				i.data(n, r, u)
			} else u = t
		}
		return u
	}
	function ii(n) {
		var t;
		for (t in n) if ((t !== "data" || !i.isEmptyObject(n[t])) && t !== "toJSON") return ! 1;
		return ! 0
	}
	function v() {
		return ! 1
	}
	function ct() {
		return ! 0
	}
	function k(n) {
		return ! n || !n.parentNode || n.parentNode.nodeType === 11
	}
	function kr(n, t) {
		do n = n[t];
		while (n && n.nodeType !== 1);
		return n
	}
	function yr(n, t, r) {
		if (t = t || 0, i.isFunction(t)) return i.grep(n,
		function(n, i) {
			var u = !!t.call(n, i, n);
			return u === r
		});
		if (t.nodeType) return i.grep(n,
		function(n) {
			return n === t === r
		});
		if (typeof t == "string") {
			var u = i.grep(n,
			function(n) {
				return n.nodeType === 1
			});
			if (yo.test(t)) return i.filter(t, u, !r);
			t = i.filter(t, u)
		}
		return i.grep(n,
		function(n) {
			return i.inArray(n, t) >= 0 === r
		})
	}
	function br(n) {
		var i = si.split("|"),
		t = n.createDocumentFragment();
		if (t.createElement) while (i.length) t.createElement(i.pop());
		return t
	}
	function uf(n, t) {
		return n.getElementsByTagName(t)[0] || n.appendChild(n.ownerDocument.createElement(t))
	}
	function wr(n, t) {
		if (t.nodeType === 1 && i.hasData(n)) {
			var e, f, o, s = i._data(n),
			r = i._data(t, s),
			u = s.events;
			if (u) {
				delete r.handle,
				r.events = {};
				for (e in u) for (f = 0, o = u[e].length; f < o; f++) i.event.add(t, e, u[e][f])
			}
			r.data && (r.data = i.extend({},
			r.data))
		}
	}
	function vi(n, t) {
		var r;
		t.nodeType === 1 && (t.clearAttributes && t.clearAttributes(), t.mergeAttributes && t.mergeAttributes(n), r = t.nodeName.toLowerCase(), r === "object" ? (t.parentNode && (t.outerHTML = n.outerHTML), i.support.html5Clone && n.innerHTML && !i.trim(t.innerHTML) && (t.innerHTML = n.innerHTML)) : r === "input" && nu.test(n.type) ? (t.defaultChecked = t.checked = n.checked, t.value !== n.value && (t.value = n.value)) : r === "option" ? t.selected = n.defaultSelected: r === "input" || r === "textarea" ? t.defaultValue = n.defaultValue: r === "script" && t.text !== n.text && (t.text = n.text), t.removeAttribute(i.expando))
	}
	function ft(n) {
		return typeof n.getElementsByTagName != "undefined" ? n.getElementsByTagName("*") : typeof n.querySelectorAll != "undefined" ? n.querySelectorAll("*") : []
	}
	function oi(n) {
		nu.test(n.type) && (n.defaultChecked = n.checked)
	}
	function hi(n, t) {
		if (t in n) return t;
		for (var r = t.charAt(0).toUpperCase() + t.slice(1), u = t, i = lr.length; i--;) if (t = lr[i] + r, t in n) return t;
		return u
	}
	function et(n, t) {
		return n = t || n,
		i.css(n, "display") === "none" || !i.contains(n.ownerDocument, n)
	}
	function cr(n, t) {
		for (var r, o, e = [], f = 0, s = n.length; f < s; f++)(r = n[f], r.style) && (e[f] = i._data(r, "olddisplay"), t ? (!e[f] && r.style.display === "none" && (r.style.display = ""), r.style.display === "" && et(r) && (e[f] = i._data(r, "olddisplay", tr(r.nodeName)))) : (o = u(r, "display"), !e[f] && o !== "none" && i._data(r, "olddisplay", o)));
		for (f = 0; f < s; f++)(r = n[f], r.style) && (t && r.style.display !== "none" && r.style.display !== "" || (r.style.display = t ? e[f] || "": "none"));
		return n
	}
	function rr(n, t, i) {
		var r = to.exec(t);
		return r ? Math.max(0, r[1] - (i || 0)) + (r[2] || "px") : t
	}
	function wi(n, t, r, f) {
		for (var e = r === (f ? "border": "content") ? 4 : t === "width" ? 1 : 0, o = 0; e < 4; e += 2) r === "margin" && (o += i.css(n, r + l[e], !0)),
		f ? (r === "content" && (o -= parseFloat(u(n, "padding" + l[e])) || 0), r !== "margin" && (o -= parseFloat(u(n, "border" + l[e] + "Width")) || 0)) : (o += parseFloat(u(n, "padding" + l[e])) || 0, r !== "padding" && (o += parseFloat(u(n, "border" + l[e] + "Width")) || 0));
		return o
	}
	function ur(n, t, r) {
		var f = t === "width" ? n.offsetWidth: n.offsetHeight,
		o = !0,
		e = i.support.boxSizing && i.css(n, "boxSizing") === "border-box";
		if (f <= 0 || f == null) {
			if (f = u(n, t), (f < 0 || f == null) && (f = n.style[t]), lt.test(f)) return f;
			o = e && (i.support.boxSizingReliable || f === n.style[t]),
			f = parseFloat(f) || 0
		}
		return f + wi(n, t, r || (e ? "border": "content"), o) + "px"
	}
	function tr(n) {
		if (gt[n]) return gt[n];
		var f = i("<" + n + ">").appendTo(r.body),
		t = f.css("display");
		return f.remove(),
		(t === "none" || t === "") && (p = r.body.appendChild(p || i.extend(r.createElement("iframe"), {
			frameBorder: 0,
			width: 0,
			height: 0
		})), w && p.createElement || (w = (p.contentWindow || p.contentDocument).document, w.write("<!doctype html><html><body>"), w.close()), f = w.body.appendChild(w.createElement(n)), t = u(f, "display"), r.body.removeChild(p)),
		gt[n] = t,
		t
	}
	function ri(n, t, r, u) {
		var f;
		if (i.isArray(t)) i.each(t,
		function(t, i) {
			r || hf.test(n) ? u(n, i) : ri(n + "[" + (typeof i == "object" ? t: "") + "]", i, r, u)
		});
		else if (r || i.type(t) !== "object") u(n, t);
		else for (f in t) ri(n + "[" + f + "]", t[f], r, u)
	}
	function di(n) {
		return function(t, r) {
			typeof t != "string" && (r = t, t = "*");
			var u, s, f, o = t.toLowerCase().split(c),
			e = 0,
			h = o.length;
			if (i.isFunction(r)) for (; e < h; e++) u = o[e],
			f = /^\+/.test(u),
			f && (u = u.substr(1) || "*"),
			s = n[u] = n[u] || [],
			s[f ? "unshift": "push"](r)
		}
	}
	function d(n, i, r, u, f, e) {
		f = f || i.dataTypes[0],
		e = e || {},
		e[f] = !0;
		for (var o, c = n[f], h = 0, l = c ? c.length: 0, s = n === ti; h < l && (s || !o); h++) o = c[h](i, r, u),
		typeof o == "string" && (!s || e[o] ? o = t: (i.dataTypes.unshift(o), o = d(n, i, r, u, o, e)));
		return (s || !o) && !e["*"] && (o = d(n, i, r, u, "*", e)),
		o
	}
	function gi(n, r) {
		var u, f, e = i.ajaxSettings.flatOptions || {};
		for (u in r) r[u] !== t && ((e[u] ? n: f || (f = {}))[u] = r[u]);
		f && i.extend(!0, n, f)
	}
	function ro(n, i, r) {
		var o, u, e, h, s = n.contents,
		f = n.dataTypes,
		c = n.responseFields;
		for (u in c) u in r && (i[c[u]] = r[u]);
		while (f[0] === "*") f.shift(),
		o === t && (o = n.mimeType || i.getResponseHeader("content-type"));
		if (o) for (u in s) if (s[u] && s[u].test(o)) {
			f.unshift(u);
			break
		}
		if (f[0] in r) e = f[0];
		else {
			for (u in r) {
				if (!f[0] || n.converters[u + " " + f[0]]) {
					e = u;
					break
				}
				h || (h = u)
			}
			e = e || h
		}
		if (e) return e !== f[0] && f.unshift(e),
		r[e]
	}
	function ge(n, t) {
		var i, o, r, e, s = n.dataTypes.slice(),
		f = s[0],
		u = {},
		h = 0;
		if (n.dataFilter && (t = n.dataFilter(t, n.dataType)), s[1]) for (i in n.converters) u[i.toLowerCase()] = n.converters[i];
		for (; r = s[++h];) if (r !== "*") {
			if (f !== "*" && f !== r) {
				if (i = u[f + " " + r] || u["* " + r], !i) for (o in u) if (e = o.split(" "), e[1] === r && (i = u[f + " " + e[0]] || u["* " + e[0]], i)) {
					i === !0 ? i = u[o] : u[o] !== !0 && (r = e[0], s.splice(h--, 0, r));
					break
				}
				if (i !== !0) if (i && n.throws) t = i(t);
				else try {
					t = i(t)
				} catch(c) {
					return {
						state: "parsererror",
						error: i ? c: "No conversion from " + f + " to " + r
					}
				}
			}
			f = r
		}
		return {
			state: "success",
			data: t
		}
	}
	function ki() {
		try {
			return new n.XMLHttpRequest
		} catch(t) {}
	}
	function pe() {
		try {
			return new n.ActiveXObject("Microsoft.XMLHTTP")
		} catch(t) {}
	}
	function uu() {
		return setTimeout(function() {
			st = t
		},
		0),
		st = i.now()
	}
	function ie(n, t) {
		i.each(t,
		function(t, i) {
			for (var u = (b[t] || []).concat(b["*"]), r = 0, f = u.length; r < f; r++) if (u[r].call(n, t, i)) return
		})
	}
	function au(n, t, r) {
		var o, s = 0,
		l = 0,
		c = g.length,
		f = i.Deferred().always(function() {
			delete h.elem
		}),
		h = function() {
			for (var o = st || uu(), i = Math.max(0, u.startTime + u.duration - o), r = 1 - (i / u.duration || 0), t = 0, e = u.tweens.length; t < e; t++) u.tweens[t].run(r);
			return f.notifyWith(n, [u, r, i]),
			r < 1 && e ? i: (f.resolveWith(n, [u]), !1)
		},
		u = f.promise({
			elem: n,
			props: i.extend({},
			t),
			opts: i.extend(!0, {
				specialEasing: {}
			},
			r),
			originalProperties: t,
			originalOptions: r,
			startTime: st || uu(),
			duration: r.duration,
			tweens: [],
			createTween: function(t, r) {
				var e = i.Tween(n, u.opts, t, r, u.opts.specialEasing[t] || u.opts.easing);
				return u.tweens.push(e),
				e
			},
			stop: function(t) {
				for (var i = 0,
				r = t ? u.tweens.length: 0; i < r; i++) u.tweens[i].run(1);
				return t ? f.resolveWith(n, [u, t]) : f.rejectWith(n, [u, t]),
				this
			}
		}),
		e = u.props;
		for (ye(e, u.opts.specialEasing); s < c; s++) if (o = g[s].call(u, n, e, u.opts), o) return o;
		return ie(u, e),
		i.isFunction(u.opts.start) && u.opts.start.call(n, u),
		i.fx.timer(i.extend(h, {
			anim: u,
			queue: u.opts.queue,
			elem: n
		})),
		u.progress(u.opts.progress).done(u.opts.done, u.opts.complete).fail(u.opts.fail).always(u.opts.always)
	}
	function ye(n, t) {
		var r, f, o, u, e;
		for (r in n) if (f = i.camelCase(r), o = t[f], u = n[r], i.isArray(u) && (o = u[1], u = n[r] = u[0]), r !== f && (n[f] = u, delete n[r]), e = i.cssHooks[f], e && "expand" in e) {
			u = e.expand(u),
			delete n[f];
			for (r in u) r in n || (n[r] = u[r], t[r] = o)
		} else t[f] = o
	}
	function ee(n, t, r) {
		var o, u, v, p, c, h, e, w, s = this,
		f = n.style,
		y = {},
		a = [],
		l = n.nodeType && et(n);
		r.queue || (e = i._queueHooks(n, "fx"), e.unqueued == null && (e.unqueued = 0, w = e.empty.fire, e.empty.fire = function() {
			e.unqueued || w()
		}), e.unqueued++, s.always(function() {
			s.always(function() {
				e.unqueued--,
				i.queue(n, "fx").length || e.empty.fire()
			})
		})),
		n.nodeType === 1 && ("height" in t || "width" in t) && (r.overflow = [f.overflow, f.overflowX, f.overflowY], i.css(n, "display") === "inline" && i.css(n, "float") === "none" && (!i.support.inlineBlockNeedsLayout || tr(n.nodeName) === "inline" ? f.display = "inline-block": f.zoom = 1)),
		r.overflow && (f.overflow = "hidden", i.support.shrinkWrapBlocks || s.done(function() {
			f.overflow = r.overflow[0],
			f.overflowX = r.overflow[1],
			f.overflowY = r.overflow[2]
		}));
		for (o in t) if (v = t[o], wu.exec(v)) {
			if (delete t[o], v === (l ? "hide": "show")) continue;
			a.push(o)
		}
		if (p = a.length, p) for (c = i._data(n, "fxshow") || i._data(n, "fxshow", {}), l ? i(n).show() : s.done(function() {
			i(n).hide()
		}), s.done(function() {
			var t;
			i.removeData(n, "fxshow", !0);
			for (t in y) i.style(n, t, y[t])
		}), o = 0; o < p; o++) u = a[o],
		h = s.createTween(u, l ? c[u] : 0),
		y[u] = c[u] || i.style(n, u),
		u in c || (c[u] = h.start, l && (h.end = h.start, h.start = u === "width" || u === "height" ? 1 : 0))
	}
	function f(n, t, i, r, u) {
		return new f.prototype.init(n, t, i, r, u)
	}
	function nt(n, t) {
		var u, i = {
			height: n
		},
		r = 0;
		for (t = t ? 1 : 0; r < 4; r += 2 - t) u = l[r],
		i["margin" + u] = i["padding" + u] = n;
		return t && (i.opacity = i.width = n),
		i
	}
	function tu(n) {
		return i.isWindow(n) ? n: n.nodeType === 9 ? n.defaultView || n.parentWindow: !1
	}
	var iu, rt, r = n.document,
	fe = n.location,
	he = n.navigator,
	ke = n.jQuery,
	se = n.$,
	gr = Array.prototype.push,
	o = Array.prototype.slice,
	ru = Array.prototype.indexOf,
	oe = Object.prototype.toString,
	pt = Object.prototype.hasOwnProperty,
	vt = String.prototype.trim,
	i = function(n, t) {
		return new i.fn.init(n, t, iu)
	},
	tt = /[\-+]?(?:\d*\.|)\d+(?:[eE][\-+]?\d+|)/.source,
	ve = /\S/,
	c = /\s+/,
	ae = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,
	ce = /^(?:[^#<]*(<[\w\W]+>)[^>]*$|#([\w\-]*)$)/,
	ar = /^<(\w+)\s*\/?>(?:<\/\1>|)$/,
	le = /^[\],:{}\s]*$/,
	ue = /(?:^|:|,)(?:\s*\[)+/g,
	kf = /\\(?:["\\\/bfnrt]|u[\da-fA-F]{4})/g,
	df = /"[^"\\\r\n]*"|true|false|null|-?(?:\d\d*\.|)\d+(?:[eE][\-+]?\d+|)/g,
	bf = /^-ms-/,
	pf = /-([\da-z])/gi,
	wf = function(n, t) {
		return (t + "").toUpperCase()
	},
	it = function() {
		r.addEventListener ? (r.removeEventListener("DOMContentLoaded", it, !1), i.ready()) : r.readyState === "complete" && (r.detachEvent("onreadystatechange", it), i.ready())
	},
	hu = {},
	dt,
	fu,
	su,
	y,
	ht,
	vr,
	wt;
	i.fn = i.prototype = {
		constructor: i,
		init: function(n, u, f) {
			var e, o, h, s;
			if (!n) return this;
			if (n.nodeType) return this.context = this[0] = n,
			this.length = 1,
			this;
			if (typeof n == "string") {
				if (e = n.charAt(0) === "<" && n.charAt(n.length - 1) === ">" && n.length >= 3 ? [null, n, null] : ce.exec(n), e && (e[1] || !u)) {
					if (e[1]) return u = u instanceof i ? u[0] : u,
					s = u && u.nodeType ? u.ownerDocument || u: r,
					n = i.parseHTML(e[1], s, !0),
					ar.test(e[1]) && i.isPlainObject(u) && this.attr.call(n, u, !0),
					i.merge(this, n);
					if (o = r.getElementById(e[2]), o && o.parentNode) {
						if (o.id !== e[2]) return f.find(n);
						this.length = 1,
						this[0] = o
					}
					return this.context = r,
					this.selector = n,
					this
				}
				return ! u || u.jquery ? (u || f).find(n) : this.constructor(u).find(n)
			}
			return i.isFunction(n) ? f.ready(n) : (n.selector !== t && (this.selector = n.selector, this.context = n.context), i.makeArray(n, this))
		},
		selector: "",
		jquery: "1.8.2",
		length: 0,
		size: function() {
			return this.length
		},
		toArray: function() {
			return o.call(this)
		},
		get: function(n) {
			return n == null ? this.toArray() : n < 0 ? this[this.length + n] : this[n]
		},
		pushStack: function(n, t, r) {
			var u = i.merge(this.constructor(), n);
			return u.prevObject = this,
			u.context = this.context,
			t === "find" ? u.selector = this.selector + (this.selector ? " ": "") + r: t && (u.selector = this.selector + "." + t + "(" + r + ")"),
			u
		},
		each: function(n, t) {
			return i.each(this, n, t)
		},
		ready: function(n) {
			return i.ready.promise().done(n),
			this
		},
		eq: function(n) {
			return n = +n,
			n === -1 ? this.slice(n) : this.slice(n, n + 1)
		},
		first: function() {
			return this.eq(0)
		},
		last: function() {
			return this.eq( - 1)
		},
		slice: function() {
			return this.pushStack(o.apply(this, arguments), "slice", o.call(arguments).join(","))
		},
		map: function(n) {
			return this.pushStack(i.map(this,
			function(t, i) {
				return n.call(t, i, t)
			}))
		},
		end: function() {
			return this.prevObject || this.constructor(null)
		},
		push: gr,
		sort: [].sort,
		splice: [].splice
	},
	i.fn.init.prototype = i.fn,
	i.extend = i.fn.extend = function() {
		var s, e, u, r, h, c, n = arguments[0] || {},
		f = 1,
		l = arguments.length,
		o = !1;
		for (typeof n == "boolean" && (o = n, n = arguments[1] || {},
		f = 2), typeof n != "object" && !i.isFunction(n) && (n = {}), l === f && (n = this, --f); f < l; f++) if ((s = arguments[f]) != null) for (e in s)(u = n[e], r = s[e], n !== r) && (o && r && (i.isPlainObject(r) || (h = i.isArray(r))) ? (h ? (h = !1, c = u && i.isArray(u) ? u: []) : c = u && i.isPlainObject(u) ? u: {},
		n[e] = i.extend(o, c, r)) : r !== t && (n[e] = r));
		return n
	},
	i.extend({
		noConflict: function(t) {
			return n.$ === i && (n.$ = se),
			t && n.jQuery === i && (n.jQuery = ke),
			i
		},
		isReady: !1,
		readyWait: 1,
		holdReady: function(n) {
			n ? i.readyWait++:i.ready(!0)
		},
		ready: function(n) {
			if (n === !0 ? !--i.readyWait: !i.isReady) {
				if (!r.body) return setTimeout(i.ready, 1); (i.isReady = !0, n !== !0 && --i.readyWait > 0) || (rt.resolveWith(r, [i]), i.fn.trigger && i(r).trigger("ready").off("ready"))
			}
		},
		isFunction: function(n) {
			return i.type(n) === "function"
		},
		isArray: Array.isArray ||
		function(n) {
			return i.type(n) === "array"
		},
		isWindow: function(n) {
			return n != null && n == n.window
		},
		isNumeric: function(n) {
			return ! isNaN(parseFloat(n)) && isFinite(n)
		},
		type: function(n) {
			return n == null ? String(n) : hu[oe.call(n)] || "object"
		},
		isPlainObject: function(n) {
			if (!n || i.type(n) !== "object" || n.nodeType || i.isWindow(n)) return ! 1;
			try {
				if (n.constructor && !pt.call(n, "constructor") && !pt.call(n.constructor.prototype, "isPrototypeOf")) return ! 1
			} catch(u) {
				return ! 1
			}
			var r;
			for (r in n);
			return r === t || pt.call(n, r)
		},
		isEmptyObject: function(n) {
			var t;
			for (t in n) return ! 1;
			return ! 0
		},
		error: function(n) {
			throw new Error(n);
		},
		parseHTML: function(n, t, u) {
			var f;
			return ! n || typeof n != "string" ? null: (typeof t == "boolean" && (u = t, t = 0), t = t || r, (f = ar.exec(n)) ? [t.createElement(f[1])] : (f = i.buildFragment([n], t, u ? null: []), i.merge([], (f.cacheable ? i.clone(f.fragment) : f.fragment).childNodes)))
		},
		parseJSON: function(t) {
			if (!t || typeof t != "string") return null;
			if (t = i.trim(t), n.JSON && n.JSON.parse) return n.JSON.parse(t);
			if (le.test(t.replace(kf, "@").replace(df, "]").replace(ue, ""))) return new Function("return " + t)();
			i.error("Invalid JSON: " + t)
		},
		parseXML: function(r) {
			var u, f;
			if (!r || typeof r != "string") return null;
			try {
				n.DOMParser ? (f = new DOMParser, u = f.parseFromString(r, "text/xml")) : (u = new ActiveXObject("Microsoft.XMLDOM"), u.async = "false", u.loadXML(r))
			} catch(e) {
				u = t
			}
			return (!u || !u.documentElement || u.getElementsByTagName("parsererror").length) && i.error("Invalid XML: " + r),
			u
		},
		noop: function() {},
		globalEval: function(t) {
			t && ve.test(t) && (n.execScript ||
			function(t) {
				n.eval.call(n, t)
			})(t)
		},
		camelCase: function(n) {
			return n.replace(bf, "ms-").replace(pf, wf)
		},
		nodeName: function(n, t) {
			return n.nodeName && n.nodeName.toLowerCase() === t.toLowerCase()
		},
		each: function(n, r, u) {
			var e, f = 0,
			o = n.length,
			s = o === t || i.isFunction(n);
			if (u) {
				if (s) {
					for (e in n) if (r.apply(n[e], u) === !1) break
				} else for (; f < o;) if (r.apply(n[f++], u) === !1) break
			} else if (s) {
				for (e in n) if (r.call(n[e], e, n[e]) === !1) break
			} else for (; f < o;) if (r.call(n[f], f, n[f++]) === !1) break;
			return n
		},
		trim: vt && !vt.call("﻿ ") ?
		function(n) {
			return n == null ? "": vt.call(n)
		}: function(n) {
			return n == null ? "": (n + "").replace(ae, "")
		},
		makeArray: function(n, t) {
			var r, u = t || [];
			return n != null && (r = i.type(n), n.length == null || r === "string" || r === "function" || r === "regexp" || i.isWindow(n) ? gr.call(u, n) : i.merge(u, n)),
			u
		},
		inArray: function(n, t, i) {
			var r;
			if (t) {
				if (ru) return ru.call(t, n, i);
				for (r = t.length, i = i ? i < 0 ? Math.max(0, r + i) : i: 0; i < r; i++) if (i in t && t[i] === n) return i
			}
			return - 1
		},
		merge: function(n, i) {
			var f = i.length,
			u = n.length,
			r = 0;
			if (typeof f == "number") for (; r < f; r++) n[u++] = i[r];
			else while (i[r] !== t) n[u++] = i[r++];
			return n.length = u,
			n
		},
		grep: function(n, t, i) {
			var f, u = [],
			r = 0,
			e = n.length;
			for (i = !!i; r < e; r++) f = !!t(n[r], r),
			i !== f && u.push(n[r]);
			return u
		},
		map: function(n, r, u) {
			var o, h, f = [],
			s = 0,
			e = n.length,
			c = n instanceof i || e !== t && typeof e == "number" && (e > 0 && n[0] && n[e - 1] || e === 0 || i.isArray(n));
			if (c) for (; s < e; s++) o = r(n[s], s, u),
			o != null && (f[f.length] = o);
			else for (h in n) o = r(n[h], h, u),
			o != null && (f[f.length] = o);
			return f.concat.apply([], f)
		},
		guid: 1,
		proxy: function(n, r) {
			var f, e, u;
			return typeof r == "string" && (f = n[r], r = n, n = f),
			i.isFunction(n) ? (e = o.call(arguments, 2), u = function() {
				return n.apply(r, e.concat(o.call(arguments)))
			},
			u.guid = n.guid = n.guid || i.guid++, u) : t
		},
		access: function(n, r, u, f, e, o, s) {
			var c, a = u == null,
			h = 0,
			l = n.length;
			if (u && typeof u == "object") {
				for (h in u) i.access(n, r, h, u[h], 1, o, f);
				e = 1
			} else if (f !== t) {
				if (c = s === t && i.isFunction(f), a && (c ? (c = r, r = function(n, t, r) {
					return c.call(i(n), r)
				}) : (r.call(n, f), r = null)), r) for (; h < l; h++) r(n[h], u, c ? f.call(n[h], h, r(n[h], u)) : f, s);
				e = 1
			}
			return e ? n: a ? r.call(n) : l ? r(n[0], u) : o
		},
		now: function() {
			return + new Date
		}
	}),
	i.ready.promise = function(t) {
		if (!rt) if (rt = i.Deferred(), r.readyState === "complete") setTimeout(i.ready, 1);
		else if (r.addEventListener) r.addEventListener("DOMContentLoaded", it, !1),
		n.addEventListener("load", i.ready, !1);
		else {
			r.attachEvent("onreadystatechange", it),
			n.attachEvent("onload", i.ready);
			var u = !1;
			try {
				u = n.frameElement == null && r.documentElement
			} catch(e) {}
			u && u.doScroll &&
			function f() {
				if (!i.isReady) {
					try {
						u.doScroll("left")
					} catch(n) {
						return setTimeout(f, 50)
					}
					i.ready()
				}
			} ()
		}
		return rt.promise(t)
	},
	i.each("Boolean Number String Function Array Date RegExp Object".split(" "),
	function(n, t) {
		hu["[object " + t + "]"] = t.toLowerCase()
	}),
	iu = i(r),
	dt = {},
	i.Callbacks = function(n) {
		n = typeof n == "string" ? dt[n] || ku(n) : i.extend({},
		n);
		var f, c, s, a, h, e, r = [],
		u = !n.once && [],
		l = function(t) {
			for (f = n.memory && t, c = !0, e = a || 0, a = 0, h = r.length, s = !0; r && e < h; e++) if (r[e].apply(t[0], t[1]) === !1 && n.stopOnFalse) {
				f = !1;
				break
			}
			s = !1,
			r && (u ? u.length && l(u.shift()) : f ? r = [] : o.disable())
		},
		o = {
			add: function() {
				if (r) {
					var u = r.length; (function t(u) {
						i.each(u,
						function(u, f) {
							var e = i.type(f);
							e === "function" && (!n.unique || !o.has(f)) ? r.push(f) : f && f.length && e !== "string" && t(f)
						})
					})(arguments),
					s ? h = r.length: f && (a = u, l(f))
				}
				return this
			},
			remove: function() {
				return r && i.each(arguments,
				function(n, t) {
					for (var u; (u = i.inArray(t, r, u)) > -1;) r.splice(u, 1),
					s && (u <= h && h--, u <= e && e--)
				}),
				this
			},
			has: function(n) {
				return i.inArray(n, r) > -1
			},
			empty: function() {
				return r = [],
				this
			},
			disable: function() {
				return r = u = f = t,
				this
			},
			disabled: function() {
				return ! r
			},
			lock: function() {
				return u = t,
				f || o.disable(),
				this
			},
			locked: function() {
				return ! u
			},
			fireWith: function(n, t) {
				return t = t || [],
				t = [n, t.slice ? t.slice() : t],
				r && (!c || u) && (s ? u.push(t) : l(t)),
				this
			},
			fire: function() {
				return o.fireWith(this, arguments),
				this
			},
			fired: function() {
				return !! c
			}
		};
		return o
	},
	i.extend({
		Deferred: function(n) {
			var u = [["resolve", "done", i.Callbacks("once memory"), "resolved"], ["reject", "fail", i.Callbacks("once memory"), "rejected"], ["notify", "progress", i.Callbacks("memory")]],
			f = "pending",
			r = {
				state: function() {
					return f
				},
				always: function() {
					return t.done(arguments).fail(arguments),
					this
				},
				then: function() {
					var n = arguments;
					return i.Deferred(function(r) {
						i.each(u,
						function(u, f) {
							var o = f[0],
							e = n[u];
							t[f[1]](i.isFunction(e) ?
							function() {
								var n = e.apply(this, arguments);
								n && i.isFunction(n.promise) ? n.promise().done(r.resolve).fail(r.reject).progress(r.notify) : r[o + "With"](this === t ? r: this, [n])
							}: r[o])
						}),
						n = null
					}).promise()
				},
				promise: function(n) {
					return n != null ? i.extend(n, r) : r
				}
			},
			t = {};
			return r.pipe = r.then,
			i.each(u,
			function(n, i) {
				var e = i[2],
				o = i[3];
				r[i[1]] = e.add,
				o && e.add(function() {
					f = o
				},
				u[n ^ 1][2].disable, u[2][2].lock),
				t[i[0]] = e.fire,
				t[i[0] + "With"] = e.fireWith
			}),
			r.promise(t),
			n && n.call(t, t),
			t
		},
		when: function(n) {
			var r = 0,
			u = o.call(arguments),
			t = u.length,
			e = t !== 1 || n && i.isFunction(n.promise) ? t: 0,
			f = e === 1 ? n: i.Deferred(),
			c = function(n, t, i) {
				return function(r) {
					t[n] = this,
					i[n] = arguments.length > 1 ? o.call(arguments) : r,
					i === h ? f.notifyWith(t, i) : --e || f.resolveWith(t, i)
				}
			},
			h,
			l,
			s;
			if (t > 1) for (h = new Array(t), l = new Array(t), s = new Array(t); r < t; r++) u[r] && i.isFunction(u[r].promise) ? u[r].promise().done(c(r, s, u)).fail(f.reject).progress(c(r, l, h)) : --e;
			return e || f.resolveWith(s, u),
			f.promise()
		}
	}),
	i.support = function() {
		var u, h, o, l, c, f, e, a, v, s, y, t = r.createElement("div");
		if (t.setAttribute("className", "t"), t.innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>", h = t.getElementsByTagName("*"), o = t.getElementsByTagName("a")[0], o.style.cssText = "top:1px;float:left;opacity:.5", !h || !h.length) return {};
		l = r.createElement("select"),
		c = l.appendChild(r.createElement("option")),
		f = t.getElementsByTagName("input")[0],
		u = {
			leadingWhitespace: t.firstChild.nodeType === 3,
			tbody: !t.getElementsByTagName("tbody").length,
			htmlSerialize: !!t.getElementsByTagName("link").length,
			style: /top/.test(o.getAttribute("style")),
			hrefNormalized: o.getAttribute("href") === "a",
			opacity: /^0.5/.test(o.style.opacity),
			cssFloat: !!o.style.cssFloat,
			checkOn: f.value === "on",
			optSelected: c.selected,
			getSetAttribute: t.className !== "t",
			enctype: !!r.createElement("form").enctype,
			html5Clone: r.createElement("nav").cloneNode(!0).outerHTML !== "<:nav><:nav>",
			boxModel: r.compatMode === "CSS1Compat",
			submitBubbles: !0,
			changeBubbles: !0,
			focusinBubbles: !1,
			deleteExpando: !0,
			noCloneEvent: !0,
			inlineBlockNeedsLayout: !1,
			shrinkWrapBlocks: !1,
			reliableMarginRight: !0,
			boxSizingReliable: !0,
			pixelPosition: !1
		},
		f.checked = !0,
		u.noCloneChecked = f.cloneNode(!0).checked,
		l.disabled = !0,
		u.optDisabled = !c.disabled;
		try {
			delete t.test
		} catch(p) {
			u.deleteExpando = !1
		}
		if (!t.addEventListener && t.attachEvent && t.fireEvent && (t.attachEvent("onclick", y = function() {
			u.noCloneEvent = !1
		}), t.cloneNode(!0).fireEvent("onclick"), t.detachEvent("onclick", y)), f = r.createElement("input"), f.value = "t", f.setAttribute("type", "radio"), u.radioValue = f.value === "t", f.setAttribute("checked", "checked"), f.setAttribute("name", "t"), t.appendChild(f), e = r.createDocumentFragment(), e.appendChild(t.lastChild), u.checkClone = e.cloneNode(!0).cloneNode(!0).lastChild.checked, u.appendChecked = f.checked, e.removeChild(f), e.appendChild(t), t.attachEvent) for (v in {
			submit: !0,
			change: !0,
			focusin: !0
		}) a = "on" + v,
		s = a in t,
		s || (t.setAttribute(a, "return;"), s = typeof t[a] == "function"),
		u[v + "Bubbles"] = s;
		return i(function() {
			var e, t, f, i, h = "padding:0;margin:0;border:0;display:block;overflow:hidden;",
			o = r.getElementsByTagName("body")[0];
			o && (e = r.createElement("div"), e.style.cssText = "visibility:hidden;border:0;width:0;height:0;position:static;top:0;margin-top:1px", o.insertBefore(e, o.firstChild), t = r.createElement("div"), e.appendChild(t), t.innerHTML = "<table><tr><td></td><td>t</td></tr></table>", f = t.getElementsByTagName("td"), f[0].style.cssText = "padding:0;margin:0;border:0;display:none", s = f[0].offsetHeight === 0, f[0].style.display = "", f[1].style.display = "none", u.reliableHiddenOffsets = s && f[0].offsetHeight === 0, t.innerHTML = "", t.style.cssText = "box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;padding:1px;border:1px;display:block;width:4px;margin-top:1%;position:absolute;top:1%;", u.boxSizing = t.offsetWidth === 4, u.doesNotIncludeMarginInBodyOffset = o.offsetTop !== 1, n.getComputedStyle && (u.pixelPosition = (n.getComputedStyle(t, null) || {}).top !== "1%", u.boxSizingReliable = (n.getComputedStyle(t, null) || {
				width: "4px"
			}).width === "4px", i = r.createElement("div"), i.style.cssText = t.style.cssText = h, i.style.marginRight = i.style.width = "0", t.style.width = "1px", t.appendChild(i), u.reliableMarginRight = !parseFloat((n.getComputedStyle(i, null) || {}).marginRight)), typeof t.style.zoom != "undefined" && (t.innerHTML = "", t.style.cssText = h + "width:1px;padding:1px;display:inline;zoom:1", u.inlineBlockNeedsLayout = t.offsetWidth === 3, t.style.display = "block", t.style.overflow = "visible", t.innerHTML = "<div></div>", t.firstChild.style.width = "5px", u.shrinkWrapBlocks = t.offsetWidth !== 3, e.style.zoom = 1), o.removeChild(e), e = t = f = i = null)
		}),
		e.removeChild(t),
		h = o = l = c = f = e = t = null,
		u
	} (),
	fu = /(?:\{[\s\S]*\}|\[[\s\S]*\])$/,
	su = /([A-Z])/g,
	i.extend({
		cache: {},
		deletedIds: [],
		uuid: 0,
		expando: "jQuery" + (i.fn.jquery + Math.random()).replace(/\D/g, ""),
		noData: {
			embed: !0,
			object: "clsid:D27CDB6E-AE6D-11cf-96B8-444553540000",
			applet: !0
		},
		hasData: function(n) {
			return n = n.nodeType ? i.cache[n[i.expando]] : n[i.expando],
			!!n && !ii(n)
		},
		data: function(n, r, u, f) {
			if (i.acceptData(n)) {
				var s, h, c = i.expando,
				a = typeof r == "string",
				l = n.nodeType,
				o = l ? i.cache: n,
				e = l ? n[c] : n[c] && c;
				if (e && o[e] && (f || o[e].data) || !a || u !== t) return e || (l ? n[c] = e = i.deletedIds.pop() || i.guid++:e = c),
				o[e] || (o[e] = {},
				l || (o[e].toJSON = i.noop)),
				(typeof r == "object" || typeof r == "function") && (f ? o[e] = i.extend(o[e], r) : o[e].data = i.extend(o[e].data, r)),
				s = o[e],
				f || (s.data || (s.data = {}), s = s.data),
				u !== t && (s[i.camelCase(r)] = u),
				a ? (h = s[r], h == null && (h = s[i.camelCase(r)])) : h = s,
				h
			}
		},
		removeData: function(n, t, r) {
			if (i.acceptData(n)) {
				var e, o, h, s = n.nodeType,
				u = s ? i.cache: n,
				f = s ? n[i.expando] : i.expando;
				if (u[f]) {
					if (t && (e = r ? u[f] : u[f].data, e)) {
						for (i.isArray(t) || (t in e ? t = [t] : (t = i.camelCase(t), t = t in e ? [t] : t.split(" "))), o = 0, h = t.length; o < h; o++) delete e[t[o]];
						if (! (r ? ii: i.isEmptyObject)(e)) return
					} (r || (delete u[f].data, ii(u[f]))) && (s ? i.cleanData([n], !0) : i.support.deleteExpando || u != u.window ? delete u[f] : u[f] = null)
				}
			}
		},
		_data: function(n, t, r) {
			return i.data(n, t, r, !0)
		},
		acceptData: function(n) {
			var t = n.nodeName && i.noData[n.nodeName.toLowerCase()];
			return ! t || t !== !0 && n.getAttribute("classid") === t
		}
	}),
	i.fn.extend({
		data: function(n, r) {
			var u, s, c, o, l, e = this[0],
			h = 0,
			f = null;
			if (n === t) {
				if (this.length && (f = i.data(e), e.nodeType === 1 && !i._data(e, "parsedAttrs"))) {
					for (c = e.attributes, l = c.length; h < l; h++) o = c[h].name,
					o.indexOf("data-") || (o = i.camelCase(o.substring(5)), dr(e, o, f[o]));
					i._data(e, "parsedAttrs", !0)
				}
				return f
			}
			return typeof n == "object" ? this.each(function() {
				i.data(this, n)
			}) : (u = n.split(".", 2), u[1] = u[1] ? "." + u[1] : "", s = u[1] + "!", i.access(this,
			function(r) {
				if (r === t) return f = this.triggerHandler("getData" + s, [u[0]]),
				f === t && e && (f = i.data(e, n), f = dr(e, n, f)),
				f === t && u[1] ? this.data(u[0]) : f;
				u[1] = r,
				this.each(function() {
					var t = i(this);
					t.triggerHandler("setData" + s, u),
					i.data(this, n, r),
					t.triggerHandler("changeData" + s, u)
				})
			},
			null, r, arguments.length > 1, null, !1))
		},
		removeData: function(n) {
			return this.each(function() {
				i.removeData(this, n)
			})
		}
	}),
	i.extend({
		queue: function(n, t, r) {
			var u;
			if (n) return t = (t || "fx") + "queue",
			u = i._data(n, t),
			r && (!u || i.isArray(r) ? u = i._data(n, t, i.makeArray(r)) : u.push(r)),
			u || []
		},
		dequeue: function(n, t) {
			t = t || "fx";
			var f = i.queue(n, t),
			e = f.length,
			r = f.shift(),
			u = i._queueHooks(n, t),
			o = function() {
				i.dequeue(n, t)
			};
			r === "inprogress" && (r = f.shift(), e--),
			r && (t === "fx" && f.unshift("inprogress"), delete u.stop, r.call(n, o, u)),
			!e && u && u.empty.fire()
		},
		_queueHooks: function(n, t) {
			var r = t + "queueHooks";
			return i._data(n, r) || i._data(n, r, {
				empty: i.Callbacks("once memory").add(function() {
					i.removeData(n, t + "queue", !0),
					i.removeData(n, r, !0)
				})
			})
		}
	}),
	i.fn.extend({
		queue: function(n, r) {
			var u = 2;
			return typeof n != "string" && (r = n, n = "fx", u--),
			arguments.length < u ? i.queue(this[0], n) : r === t ? this: this.each(function() {
				var t = i.queue(this, n, r);
				i._queueHooks(this, n),
				n === "fx" && t[0] !== "inprogress" && i.dequeue(this, n)
			})
		},
		dequeue: function(n) {
			return this.each(function() {
				i.dequeue(this, n)
			})
		},
		delay: function(n, t) {
			return n = i.fx ? i.fx.speeds[n] || n: n,
			t = t || "fx",
			this.queue(t,
			function(t, i) {
				var r = setTimeout(t, n);
				i.stop = function() {
					clearTimeout(r)
				}
			})
		},
		clearQueue: function(n) {
			return this.queue(n || "fx", [])
		},
		promise: function(n, r) {
			var u, s = 1,
			h = i.Deferred(),
			f = this,
			o = this.length,
			e = function() {--s || h.resolveWith(f, [f])
			};
			for (typeof n != "string" && (r = n, n = t), n = n || "fx"; o--;) u = i._data(f[o], n + "queueHooks"),
			u && u.empty && (s++, u.empty.add(e));
			return e(),
			h.promise(r)
		}
	});
	var s, cu, eu, lu = /[\t\r\n]/g,
	re = /\r/g,
	te = /^(?:button|input)$/i,
	gf = /^(?:button|input|object|select|textarea)$/i,
	ne = /^a(?:rea|)$/i,
	yi = /^(?:autofocus|autoplay|async|checked|controls|defer|disabled|hidden|loop|multiple|open|readonly|required|scoped|selected)$/i,
	bi = i.support.getSetAttribute;
	i.fn.extend({
		attr: function(n, t) {
			return i.access(this, i.attr, n, t, arguments.length > 1)
		},
		removeAttr: function(n) {
			return this.each(function() {
				i.removeAttr(this, n)
			})
		},
		prop: function(n, t) {
			return i.access(this, i.prop, n, t, arguments.length > 1)
		},
		removeProp: function(n) {
			return n = i.propFix[n] || n,
			this.each(function() {
				try {
					this[n] = t,
					delete this[n]
				} catch(i) {}
			})
		},
		addClass: function(n) {
			var u, e, s, t, f, r, o;
			if (i.isFunction(n)) return this.each(function(t) {
				i(this).addClass(n.call(this, t, this.className))
			});
			if (n && typeof n == "string") for (u = n.split(c), e = 0, s = this.length; e < s; e++) if (t = this[e], t.nodeType === 1) if (t.className || u.length !== 1) {
				for (f = " " + t.className + " ", r = 0, o = u.length; r < o; r++) f.indexOf(" " + u[r] + " ") < 0 && (f += u[r] + " ");
				t.className = i.trim(f)
			} else t.className = n;
			return this
		},
		removeClass: function(n) {
			var o, f, r, u, h, e, s;
			if (i.isFunction(n)) return this.each(function(t) {
				i(this).removeClass(n.call(this, t, this.className))
			});
			if (n && typeof n == "string" || n === t) for (o = (n || "").split(c), e = 0, s = this.length; e < s; e++) if (r = this[e], r.nodeType === 1 && r.className) {
				for (f = (" " + r.className + " ").replace(lu, " "), u = 0, h = o.length; u < h; u++) while (f.indexOf(" " + o[u] + " ") >= 0) f = f.replace(" " + o[u] + " ", " ");
				r.className = n ? i.trim(f) : ""
			}
			return this
		},
		toggleClass: function(n, t) {
			var r = typeof n,
			u = typeof t == "boolean";
			return i.isFunction(n) ? this.each(function(r) {
				i(this).toggleClass(n.call(this, r, this.className, t), t)
			}) : this.each(function() {
				if (r === "string") for (var e, h = 0,
				o = i(this), f = t, s = n.split(c); e = s[h++];) f = u ? f: !o.hasClass(e),
				o[f ? "addClass": "removeClass"](e);
				else(r === "undefined" || r === "boolean") && (this.className && i._data(this, "__className__", this.className), this.className = this.className || n === !1 ? "": i._data(this, "__className__") || "")
			})
		},
		hasClass: function(n) {
			for (var r = " " + n + " ",
			t = 0,
			i = this.length; t < i; t++) if (this[t].nodeType === 1 && (" " + this[t].className + " ").replace(lu, " ").indexOf(r) >= 0) return ! 0;
			return ! 1
		},
		val: function(n) {
			var r, u, e, f = this[0];
			return arguments.length ? (e = i.isFunction(n), this.each(function(u) {
				var f, o = i(this);
				this.nodeType === 1 && (f = e ? n.call(this, u, o.val()) : n, f == null ? f = "": typeof f == "number" ? f += "": i.isArray(f) && (f = i.map(f,
				function(n) {
					return n == null ? "": n + ""
				})), r = i.valHooks[this.type] || i.valHooks[this.nodeName.toLowerCase()], r && "set" in r && r.set(this, f, "value") !== t || (this.value = f))
			})) : f ? (r = i.valHooks[f.type] || i.valHooks[f.nodeName.toLowerCase()], r && "get" in r && (u = r.get(f, "value")) !== t ? u: (u = f.value, typeof u == "string" ? u.replace(re, "") : u == null ? "": u)) : void 0
		}
	}),
	i.extend({
		valHooks: {
			option: {
				get: function(n) {
					var t = n.attributes.value;
					return ! t || t.specified ? n.value: n.text
				}
			},
			select: {
				get: function(n) {
					var o, e, h, t, r = n.selectedIndex,
					s = [],
					u = n.options,
					f = n.type === "select-one";
					if (r < 0) return null;
					for (e = f ? r: 0, h = f ? r + 1 : u.length; e < h; e++) if (t = u[e], t.selected && (i.support.optDisabled ? !t.disabled: t.getAttribute("disabled") === null) && (!t.parentNode.disabled || !i.nodeName(t.parentNode, "optgroup"))) {
						if (o = i(t).val(), f) return o;
						s.push(o)
					}
					return f && !s.length && u.length ? i(u[r]).val() : s
				},
				set: function(n, t) {
					var r = i.makeArray(t);
					return i(n).find("option").each(function() {
						this.selected = i.inArray(i(this).val(), r) >= 0
					}),
					r.length || (n.selectedIndex = -1),
					r
				}
			}
		},
		attrFn: {},
		attr: function(n, r, u, f) {
			var o, e, c, h = n.nodeType;
			if (n && h !== 3 && h !== 8 && h !== 2) {
				if (f && i.isFunction(i.fn[r])) return i(n)[r](u);
				if (typeof n.getAttribute == "undefined") return i.prop(n, r, u);
				if (c = h !== 1 || !i.isXMLDoc(n), c && (r = r.toLowerCase(), e = i.attrHooks[r] || (yi.test(r) ? cu: s)), u !== t) {
					if (u === null) {
						i.removeAttr(n, r);
						return
					}
					return e && "set" in e && c && (o = e.set(n, u, r)) !== t ? o: (n.setAttribute(r, u + ""), u)
				}
				return e && "get" in e && c && (o = e.get(n, r)) !== null ? o: (o = n.getAttribute(r), o === null ? t: o)
			}
		},
		removeAttr: function(n, t) {
			var u, o, r, e, f = 0;
			if (t && n.nodeType === 1) for (o = t.split(c); f < o.length; f++) r = o[f],
			r && (u = i.propFix[r] || r, e = yi.test(r), e || i.attr(n, r, ""), n.removeAttribute(bi ? r: u), e && u in n && (n[u] = !1))
		},
		attrHooks: {
			type: {
				set: function(n, t) {
					if (te.test(n.nodeName) && n.parentNode) i.error("type property can't be changed");
					else if (!i.support.radioValue && t === "radio" && i.nodeName(n, "input")) {
						var r = n.value;
						return n.setAttribute("type", t),
						r && (n.value = r),
						t
					}
				}
			},
			value: {
				get: function(n, t) {
					return s && i.nodeName(n, "button") ? s.get(n, t) : t in n ? n.value: null
				},
				set: function(n, t, r) {
					if (s && i.nodeName(n, "button")) return s.set(n, t, r);
					n.value = t
				}
			}
		},
		propFix: {
			tabindex: "tabIndex",
			readonly: "readOnly",
			"for": "htmlFor",
			"class": "className",
			maxlength: "maxLength",
			cellspacing: "cellSpacing",
			cellpadding: "cellPadding",
			rowspan: "rowSpan",
			colspan: "colSpan",
			usemap: "useMap",
			frameborder: "frameBorder",
			contenteditable: "contentEditable"
		},
		prop: function(n, r, u) {
			var o, f, s, e = n.nodeType;
			if (n && e !== 3 && e !== 8 && e !== 2) return s = e !== 1 || !i.isXMLDoc(n),
			s && (r = i.propFix[r] || r, f = i.propHooks[r]),
			u !== t ? f && "set" in f && (o = f.set(n, u, r)) !== t ? o: n[r] = u: f && "get" in f && (o = f.get(n, r)) !== null ? o: n[r]
		},
		propHooks: {
			tabIndex: {
				get: function(n) {
					var i = n.getAttributeNode("tabindex");
					return i && i.specified ? parseInt(i.value, 10) : gf.test(n.nodeName) || ne.test(n.nodeName) && n.href ? 0 : t
				}
			}
		}
	}),
	cu = {
		get: function(n, r) {
			var f, u = i.prop(n, r);
			return u === !0 || typeof u != "boolean" && (f = n.getAttributeNode(r)) && f.nodeValue !== !1 ? r.toLowerCase() : t
		},
		set: function(n, t, r) {
			var u;
			return t === !1 ? i.removeAttr(n, r) : (u = i.propFix[r] || r, u in n && (n[u] = !0), n.setAttribute(r, r.toLowerCase())),
			r
		}
	},
	bi || (eu = {
		name: !0,
		id: !0,
		coords: !0
	},
	s = i.valHooks.button = {
		get: function(n, i) {
			var r;
			return r = n.getAttributeNode(i),
			r && (eu[i] ? r.value !== "": r.specified) ? r.value: t
		},
		set: function(n, t, i) {
			var u = n.getAttributeNode(i);
			return u || (u = r.createAttribute(i), n.setAttributeNode(u)),
			u.value = t + ""
		}
	},
	i.each(["width", "height"],
	function(n, t) {
		i.attrHooks[t] = i.extend(i.attrHooks[t], {
			set: function(n, i) {
				if (i === "") return n.setAttribute(t, "auto"),
				i
			}
		})
	}), i.attrHooks.contenteditable = {
		get: s.get,
		set: function(n, t, i) {
			t === "" && (t = "false"),
			s.set(n, t, i)
		}
	}),
	i.support.hrefNormalized || i.each(["href", "src", "width", "height"],
	function(n, r) {
		i.attrHooks[r] = i.extend(i.attrHooks[r], {
			get: function(n) {
				var i = n.getAttribute(r, 2);
				return i === null ? t: i
			}
		})
	}),
	i.support.style || (i.attrHooks.style = {
		get: function(n) {
			return n.style.cssText.toLowerCase() || t
		},
		set: function(n, t) {
			return n.style.cssText = t + ""
		}
	}),
	i.support.optSelected || (i.propHooks.selected = i.extend(i.propHooks.selected, {
		get: function(n) {
			var t = n.parentNode;
			return t && (t.selectedIndex, t.parentNode && t.parentNode.selectedIndex),
			null
		}
	})),
	i.support.enctype || (i.propFix.enctype = "encoding"),
	i.support.checkOn || i.each(["radio", "checkbox"],
	function() {
		i.valHooks[this] = {
			get: function(n) {
				return n.getAttribute("value") === null ? "on": n.value
			}
		}
	}),
	i.each(["radio", "checkbox"],
	function() {
		i.valHooks[this] = i.extend(i.valHooks[this], {
			set: function(n, t) {
				if (i.isArray(t)) return n.checked = i.inArray(i(n).val(), t) >= 0
			}
		})
	});
	var kt = /^(?:textarea|input|select)$/i,
	pi = /^([^\.]*|)(?:\.(.+)|)$/,
	ho = /(?:^|\s)hover(\.\S+|)\b/,
	co = /^key/,
	so = /^(?:mouse|contextmenu)|click/,
	ui = /^(?:focusinfocus|focusoutblur)$/,
	fi = function(n) {
		return i.event.special.hover ? n: n.replace(ho, "mouseenter$1 mouseleave$1")
	};
	i.event = {
		add: function(n, r, u, f, e) {
			var v, h, a, y, w, o, b, l, p, c, s;
			if (n.nodeType !== 3 && n.nodeType !== 8 && r && u && (v = i._data(n))) {
				for (u.handler && (p = u, u = p.handler, e = p.selector), u.guid || (u.guid = i.guid++), a = v.events, a || (v.events = a = {}), h = v.handle, h || (v.handle = h = function(n) {
					return typeof i != "undefined" && (!n || i.event.triggered !== n.type) ? i.event.dispatch.apply(h.elem, arguments) : t
				},
				h.elem = n), r = i.trim(fi(r)).split(" "), y = 0; y < r.length; y++) w = pi.exec(r[y]) || [],
				o = w[1],
				b = (w[2] || "").split(".").sort(),
				s = i.event.special[o] || {},
				o = (e ? s.delegateType: s.bindType) || o,
				s = i.event.special[o] || {},
				l = i.extend({
					type: o,
					origType: w[1],
					data: f,
					handler: u,
					guid: u.guid,
					selector: e,
					needsContext: e && i.expr.match.needsContext.test(e),
					namespace: b.join(".")
				},
				p),
				c = a[o],
				c || (c = a[o] = [], c.delegateCount = 0, s.setup && s.setup.call(n, f, b, h) !== !1 || (n.addEventListener ? n.addEventListener(o, h, !1) : n.attachEvent && n.attachEvent("on" + o, h))),
				s.add && (s.add.call(n, l), l.handler.guid || (l.handler.guid = u.guid)),
				e ? c.splice(c.delegateCount++, 0, l) : c.push(l),
				i.event.global[o] = !0;
				n = null
			}
		},
		global: {},
		remove: function(n, t, r, u, f) {
			var v, p, e, w, h, b, a, l, c, o, s, y = i.hasData(n) && i._data(n);
			if (y && (l = y.events)) {
				for (t = i.trim(fi(t || "")).split(" "), v = 0; v < t.length; v++) {
					if (p = pi.exec(t[v]) || [], e = w = p[1], h = p[2], !e) {
						for (e in l) i.event.remove(n, e + t[v], r, u, !0);
						continue
					}
					for (c = i.event.special[e] || {},
					e = (u ? c.delegateType: c.bindType) || e, o = l[e] || [], b = o.length, h = h ? new RegExp("(^|\\.)" + h.split(".").sort().join("\\.(?:.*\\.|)") + "(\\.|$)") : null, a = 0; a < o.length; a++) s = o[a],
					(f || w === s.origType) && (!r || r.guid === s.guid) && (!h || h.test(s.namespace)) && (!u || u === s.selector || u === "**" && s.selector) && (o.splice(a--, 1), s.selector && o.delegateCount--, c.remove && c.remove.call(n, s));
					o.length === 0 && b !== o.length && ((!c.teardown || c.teardown.call(n, h, y.handle) === !1) && i.removeEvent(n, e, y.handle), delete l[e])
				}
				i.isEmptyObject(l) && (delete y.handle, i.removeData(n, "events", !0))
			}
		},
		customEvent: {
			getData: !0,
			setData: !0,
			changeData: !0
		},
		trigger: function(u, f, e, o) {
			if (!e || e.nodeType !== 3 && e.nodeType !== 8) {
				var w, d, l, h, c, y, a, v, p, k, s = u.type || u,
				b = [];
				if (ui.test(s + i.event.triggered)) return;
				if (s.indexOf("!") >= 0 && (s = s.slice(0, -1), d = !0), s.indexOf(".") >= 0 && (b = s.split("."), s = b.shift(), b.sort()), (!e || i.event.customEvent[s]) && !i.event.global[s]) return;
				if (u = typeof u == "object" ? u[i.expando] ? u: new i.Event(s, u) : new i.Event(s), u.type = s, u.isTrigger = !0, u.exclusive = d, u.namespace = b.join("."), u.namespace_re = u.namespace ? new RegExp("(^|\\.)" + b.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, y = s.indexOf(":") < 0 ? "on" + s: "", !e) {
					w = i.cache;
					for (l in w) w[l].events && w[l].events[s] && i.event.trigger(u, f, w[l].handle.elem, !0);
					return
				}
				if (u.result = t, u.target || (u.target = e), f = f != null ? i.makeArray(f) : [], f.unshift(u), a = i.event.special[s] || {},
				a.trigger && a.trigger.apply(e, f) === !1) return;
				if (p = [[e, a.bindType || s]], !o && !a.noBubble && !i.isWindow(e)) {
					for (k = a.delegateType || s, h = ui.test(k + s) ? e: e.parentNode, c = e; h; h = h.parentNode) p.push([h, k]),
					c = h;
					c === (e.ownerDocument || r) && p.push([c.defaultView || c.parentWindow || n, k])
				}
				for (l = 0; l < p.length && !u.isPropagationStopped(); l++) h = p[l][0],
				u.type = p[l][1],
				v = (i._data(h, "events") || {})[u.type] && i._data(h, "handle"),
				v && v.apply(h, f),
				v = y && h[y],
				v && i.acceptData(h) && v.apply && v.apply(h, f) === !1 && u.preventDefault();
				return u.type = s,
				!o && !u.isDefaultPrevented() && (!a._default || a._default.apply(e.ownerDocument, f) === !1) && (s !== "click" || !i.nodeName(e, "a")) && i.acceptData(e) && y && e[s] && (s !== "focus" && s !== "blur" || u.target.offsetWidth !== 0) && !i.isWindow(e) && (c = e[y], c && (e[y] = null), i.event.triggered = s, e[s](), i.event.triggered = t, c && (e[y] = c)),
				u.result
			}
			return
		},
		dispatch: function(r) {
			r = i.event.fix(r || n.event);
			var f, b, e, w, p, h, y, u, s, g, c = (i._data(this, "events") || {})[r.type] || [],
			l = c.delegateCount,
			k = o.call(arguments),
			d = !r.exclusive && !r.namespace,
			v = i.event.special[r.type] || {},
			a = [];
			if (k[0] = r, r.delegateTarget = this, !v.preDispatch || v.preDispatch.call(this, r) !== !1) {
				if (l && (!r.button || r.type !== "click")) for (e = r.target; e != this; e = e.parentNode || this) if (e.disabled !== !0 || r.type !== "click") {
					for (p = {},
					y = [], f = 0; f < l; f++) u = c[f],
					s = u.selector,
					p[s] === t && (p[s] = u.needsContext ? i(s, this).index(e) >= 0 : i.find(s, this, null, [e]).length),
					p[s] && y.push(u);
					y.length && a.push({
						elem: e,
						matches: y
					})
				}
				for (c.length > l && a.push({
					elem: this,
					matches: c.slice(l)
				}), f = 0; f < a.length && !r.isPropagationStopped(); f++) for (h = a[f], r.currentTarget = h.elem, b = 0; b < h.matches.length && !r.isImmediatePropagationStopped(); b++) u = h.matches[b],
				(d || !r.namespace && !u.namespace || r.namespace_re && r.namespace_re.test(u.namespace)) && (r.data = u.data, r.handleObj = u, w = ((i.event.special[u.origType] || {}).handle || u.handler).apply(h.elem, k), w !== t && (r.result = w, w === !1 && (r.preventDefault(), r.stopPropagation())));
				return v.postDispatch && v.postDispatch.call(this, r),
				r.result
			}
		},
		props: "attrChange attrName relatedNode srcElement altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),
		fixHooks: {},
		keyHooks: {
			props: "char charCode key keyCode".split(" "),
			filter: function(n, t) {
				return n.which == null && (n.which = t.charCode != null ? t.charCode: t.keyCode),
				n
			}
		},
		mouseHooks: {
			props: "button buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement".split(" "),
			filter: function(n, i) {
				var s, f, u, e = i.button,
				o = i.fromElement;
				return n.pageX == null && i.clientX != null && (s = n.target.ownerDocument || r, f = s.documentElement, u = s.body, n.pageX = i.clientX + (f && f.scrollLeft || u && u.scrollLeft || 0) - (f && f.clientLeft || u && u.clientLeft || 0), n.pageY = i.clientY + (f && f.scrollTop || u && u.scrollTop || 0) - (f && f.clientTop || u && u.clientTop || 0)),
				!n.relatedTarget && o && (n.relatedTarget = o === n.target ? i.toElement: o),
				!n.which && e !== t && (n.which = e & 1 ? 1 : e & 2 ? 3 : e & 4 ? 2 : 0),
				n
			}
		},
		fix: function(n) {
			if (n[i.expando]) return n;
			var f, e, t = n,
			u = i.event.fixHooks[n.type] || {},
			o = u.props ? this.props.concat(u.props) : this.props;
			for (n = i.Event(t), f = o.length; f;) e = o[--f],
			n[e] = t[e];
			return n.target || (n.target = t.srcElement || r),
			n.target.nodeType === 3 && (n.target = n.target.parentNode),
			n.metaKey = !!n.metaKey,
			u.filter ? u.filter(n, t) : n
		},
		special: {
			load: {
				noBubble: !0
			},
			focus: {
				delegateType: "focusin"
			},
			blur: {
				delegateType: "focusout"
			},
			beforeunload: {
				setup: function(n, t, r) {
					i.isWindow(this) && (this.onbeforeunload = r)
				},
				teardown: function(n, t) {
					this.onbeforeunload === t && (this.onbeforeunload = null)
				}
			}
		},
		simulate: function(n, t, r, u) {
			var f = i.extend(new i.Event, r, {
				type: n,
				isSimulated: !0,
				originalEvent: {}
			});
			u ? i.event.trigger(f, null, t) : i.event.dispatch.call(t, f),
			f.isDefaultPrevented() && r.preventDefault()
		}
	},
	i.event.handle = i.event.dispatch,
	i.removeEvent = r.removeEventListener ?
	function(n, t, i) {
		n.removeEventListener && n.removeEventListener(t, i, !1)
	}: function(n, t, i) {
		var r = "on" + t;
		n.detachEvent && (typeof n[r] == "undefined" && (n[r] = null), n.detachEvent(r, i))
	},
	i.Event = function(n, t) {
		if (this instanceof i.Event) n && n.type ? (this.originalEvent = n, this.type = n.type, this.isDefaultPrevented = n.defaultPrevented || n.returnValue === !1 || n.getPreventDefault && n.getPreventDefault() ? ct: v) : this.type = n,
		t && i.extend(this, t),
		this.timeStamp = n && n.timeStamp || i.now(),
		this[i.expando] = !0;
		else return new i.Event(n, t)
	},
	i.Event.prototype = {
		preventDefault: function() {
			this.isDefaultPrevented = ct;
			var n = this.originalEvent;
			n && (n.preventDefault ? n.preventDefault() : n.returnValue = !1)
		},
		stopPropagation: function() {
			this.isPropagationStopped = ct;
			var n = this.originalEvent;
			n && (n.stopPropagation && n.stopPropagation(), n.cancelBubble = !0)
		},
		stopImmediatePropagation: function() {
			this.isImmediatePropagationStopped = ct,
			this.stopPropagation()
		},
		isDefaultPrevented: v,
		isPropagationStopped: v,
		isImmediatePropagationStopped: v
	},
	i.each({
		mouseenter: "mouseover",
		mouseleave: "mouseout"
	},
	function(n, t) {
		i.event.special[n] = {
			delegateType: t,
			bindType: t,
			handle: function(n) {
				var f, e = this,
				r = n.relatedTarget,
				u = n.handleObj,
				o = u.selector;
				return r && (r === e || i.contains(e, r)) || (n.type = u.origType, f = u.handler.apply(this, arguments), n.type = t),
				f
			}
		}
	}),
	i.support.submitBubbles || (i.event.special.submit = {
		setup: function() {
			if (i.nodeName(this, "form")) return ! 1;
			i.event.add(this, "click._submit keypress._submit",
			function(n) {
				var u = n.target,
				r = i.nodeName(u, "input") || i.nodeName(u, "button") ? u.form: t;
				r && !i._data(r, "_submit_attached") && (i.event.add(r, "submit._submit",
				function(n) {
					n._submit_bubble = !0
				}), i._data(r, "_submit_attached", !0))
			})
		},
		postDispatch: function(n) {
			n._submit_bubble && (delete n._submit_bubble, this.parentNode && !n.isTrigger && i.event.simulate("submit", this.parentNode, n, !0))
		},
		teardown: function() {
			if (i.nodeName(this, "form")) return ! 1;
			i.event.remove(this, "._submit")
		}
	}),
	i.support.changeBubbles || (i.event.special.change = {
		setup: function() {
			if (kt.test(this.nodeName)) return (this.type === "checkbox" || this.type === "radio") && (i.event.add(this, "propertychange._change",
			function(n) {
				n.originalEvent.propertyName === "checked" && (this._just_changed = !0)
			}), i.event.add(this, "click._change",
			function(n) {
				this._just_changed && !n.isTrigger && (this._just_changed = !1),
				i.event.simulate("change", this, n, !0)
			})),
			!1;
			i.event.add(this, "beforeactivate._change",
			function(n) {
				var t = n.target;
				kt.test(t.nodeName) && !i._data(t, "_change_attached") && (i.event.add(t, "change._change",
				function(n) {
					this.parentNode && !n.isSimulated && !n.isTrigger && i.event.simulate("change", this.parentNode, n, !0)
				}), i._data(t, "_change_attached", !0))
			})
		},
		handle: function(n) {
			var t = n.target;
			if (this !== t || n.isSimulated || n.isTrigger || t.type !== "radio" && t.type !== "checkbox") return n.handleObj.handler.apply(this, arguments)
		},
		teardown: function() {
			return i.event.remove(this, "._change"),
			!kt.test(this.nodeName)
		}
	}),
	i.support.focusinBubbles || i.each({
		focus: "focusin",
		blur: "focusout"
	},
	function(n, t) {
		var f = 0,
		u = function(n) {
			i.event.simulate(t, n.target, i.event.fix(n), !0)
		};
		i.event.special[t] = {
			setup: function() {
				f++==0 && r.addEventListener(n, u, !0)
			},
			teardown: function() {--f == 0 && r.removeEventListener(n, u, !0)
			}
		}
	}),
	i.fn.extend({
		on: function(n, r, u, f, e) {
			var o, s;
			if (typeof n == "object") {
				typeof r != "string" && (u = u || r, r = t);
				for (s in n) this.on(s, r, u, n[s], e);
				return this
			}
			if (u == null && f == null ? (f = r, u = r = t) : f == null && (typeof r == "string" ? (f = u, u = t) : (f = u, u = r, r = t)), f === !1) f = v;
			else if (!f) return this;
			return e === 1 && (o = f, f = function(n) {
				return i().off(n),
				o.apply(this, arguments)
			},
			f.guid = o.guid || (o.guid = i.guid++)),
			this.each(function() {
				i.event.add(this, n, f, u, r)
			})
		},
		one: function(n, t, i, r) {
			return this.on(n, t, i, r, 1)
		},
		off: function(n, r, u) {
			var f, e;
			if (n && n.preventDefault && n.handleObj) return f = n.handleObj,
			i(n.delegateTarget).off(f.namespace ? f.origType + "." + f.namespace: f.origType, f.selector, f.handler),
			this;
			if (typeof n == "object") {
				for (e in n) this.off(e, r, n[e]);
				return this
			}
			return (r === !1 || typeof r == "function") && (u = r, r = t),
			u === !1 && (u = v),
			this.each(function() {
				i.event.remove(this, n, u, r)
			})
		},
		bind: function(n, t, i) {
			return this.on(n, null, t, i)
		},
		unbind: function(n, t) {
			return this.off(n, null, t)
		},
		live: function(n, t, r) {
			return i(this.context).on(n, this.selector, t, r),
			this
		},
		die: function(n, t) {
			return i(this.context).off(n, this.selector || "**", t),
			this
		},
		delegate: function(n, t, i, r) {
			return this.on(t, n, i, r)
		},
		undelegate: function(n, t, i) {
			return arguments.length === 1 ? this.off(n, "**") : this.off(t, n || "**", i)
		},
		trigger: function(n, t) {
			return this.each(function() {
				i.event.trigger(n, t, this)
			})
		},
		triggerHandler: function(n, t) {
			if (this[0]) return i.event.trigger(n, t, this[0], !0)
		},
		toggle: function(n) {
			var r = arguments,
			f = n.guid || i.guid++,
			t = 0,
			u = function(u) {
				var f = (i._data(this, "lastToggle" + n.guid) || 0) % t;
				return i._data(this, "lastToggle" + n.guid, f + 1),
				u.preventDefault(),
				r[f].apply(this, arguments) || !1
			};
			for (u.guid = f; t < r.length;) r[t++].guid = f;
			return this.click(u)
		},
		hover: function(n, t) {
			return this.mouseenter(n).mouseleave(t || n)
		}
	}),
	i.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "),
	function(n, t) {
		i.fn[t] = function(n, i) {
			return i == null && (i = n, n = null),
			arguments.length > 0 ? this.on(t, null, n, i) : this.trigger(t)
		},
		co.test(t) && (i.event.fixHooks[t] = i.event.keyHooks),
		so.test(t) && (i.event.fixHooks[t] = i.event.mouseHooks)
	}),
	function(n, t) {
		function r(n, t, i, r) {
			i = i || [],
			t = t || h;
			var e, u, s, f, o = t.nodeType;
			if (!n || typeof n != "string") return i;
			if (o !== 1 && o !== 9) return [];
			if (s = et(t), !s && !r && (e = tr.exec(n))) if (f = e[1]) {
				if (o === 9) {
					if (u = t.getElementById(f), !u || !u.parentNode) return i;
					if (u.id === f) return i.push(u),
					i
				} else if (t.ownerDocument && (u = t.ownerDocument.getElementById(f)) && ni(t, u) && u.id === f) return i.push(u),
				i
			} else {
				if (e[2]) return w.apply(i, p.call(t.getElementsByTagName(n), 0)),
				i;
				if ((f = e[3]) && dt && t.getElementsByClassName) return w.apply(i, p.call(t.getElementsByClassName(f), 0)),
				i
			}
			return st(n.replace(tt, "$1"), t, i, r, s)
		}
		function k(n) {
			return function(t) {
				var i = t.nodeName.toLowerCase();
				return i === "input" && t.type === n
			}
		}
		function ui(n) {
			return function(t) {
				var i = t.nodeName.toLowerCase();
				return (i === "input" || i === "button") && t.type === n
			}
		}
		function y(n) {
			return s(function(t) {
				return t = +t,
				s(function(i, r) {
					for (var u, e = n([], i.length, t), f = e.length; f--;) i[u = e[f]] && (i[u] = !(r[u] = i[u]))
				})
			})
		}
		function rt(n, t, i) {
			if (n === t) return i;
			for (var r = n.nextSibling; r;) {
				if (r === t) return - 1;
				r = r.nextSibling
			}
			return 1
		}
		function d(n, t) {
			var o, f, a, s, i, l, c, v = hi[e][n];
			if (v) return t ? 0 : v.slice(0);
			for (i = n, l = [], c = u.preFilter; i;) { (!o || (f = nr.exec(i))) && (f && (i = i.slice(f[0].length)), l.push(a = [])),
				o = !1,
				(f = rr.exec(i)) && (a.push(o = new ri(f.shift())), i = i.slice(o.length), o.type = f[0].replace(tt, " "));
				for (s in u.filter)(f = g[s].exec(i)) && (!c[s] || (f = c[s](f, h, !0))) && (a.push(o = new ri(f.shift())), i = i.slice(o.length), o.type = s, o.matches = f);
				if (!o) break
			}
			return t ? i.length: i ? r.error(n) : hi(n, l).slice(0)
		}
		function pt(n, t, i) {
			var u = t.dir,
			r = i && t.dir === "parentNode",
			f = gi++;
			return t.first ?
			function(t, i, f) {
				while (t = t[u]) if (r || t.nodeType === 1) return n(t, i, f)
			}: function(t, i, o) {
				if (o) {
					while (t = t[u]) if ((r || t.nodeType === 1) && n(t, i, o)) return t
				} else for (var s, c = it + " " + f + " ",
				h = c + ot; t = t[u];) if (r || t.nodeType === 1) {
					if ((s = t[e]) === h) return t.sizset;
					if (typeof s == "string" && s.indexOf(c) === 0) {
						if (t.sizset) return t
					} else {
						if (t[e] = h, n(t, i, o)) return t.sizset = !0,
						t;
						t.sizset = !1
					}
				}
			}
		}
		function yt(n) {
			return n.length > 1 ?
			function(t, i, r) {
				for (var u = n.length; u--;) if (!n[u](t, i, r)) return ! 1;
				return ! 0
			}: n[0]
		}
		function ft(n, t, i, r, u) {
			for (var e, o = [], f = 0, h = n.length, s = t != null; f < h; f++)(e = n[f]) && (!i || i(e, r, u)) && (o.push(e), s && t.push(f));
			return o
		}
		function ct(n, t, i, r, u, f) {
			return r && !r[e] && (r = ct(r)),
			u && !u[e] && (u = ct(u, f)),
			s(function(f, e, o, s) {
				if (!f || !u) {
					var c, a, l, p = [],
					y = [],
					b = e.length,
					k = f || di(t || "*", o.nodeType ? [o] : o, [], f),
					v = n && (f || !t) ? ft(k, p, n, o, s) : k,
					h = i ? u || (f ? n: b || r) ? [] : e: v;
					if (i && i(v, h, o, s), r) for (l = ft(h, y), r(l, [], o, s), c = l.length; c--;)(a = l[c]) && (h[y[c]] = !(v[y[c]] = a));
					if (f) for (c = n && h.length; c--;)(a = h[c]) && (f[p[c]] = !(e[p[c]] = a));
					else h = ft(h === e ? h.splice(b, h.length) : h),
					u ? u(null, e, h, s) : w.apply(e, h)
				}
			})
		}
		function vt(n) {
			for (var h, r, i, o = n.length,
			s = u.relative[n[0].type], c = s || u.relative[" "], t = s ? 1 : 0, l = pt(function(n) {
				return n === h
			},
			c, !0), a = pt(function(n) {
				return oi.call(h, n) > -1
			},
			c, !0), f = [function(n, t, i) {
				return ! s && (i || t !== nt) || ((h = t).nodeType ? l(n, t, i) : a(n, t, i))
			}]; t < o; t++) if (r = u.relative[n[t].type]) f = [pt(yt(f), r)];
			else {
				if (r = u.filter[n[t].type].apply(null, n[t].matches), r[e]) {
					for (i = ++t; i < o; i++) if (u.relative[n[i].type]) break;
					return ct(t > 1 && yt(f), t > 1 && n.slice(0, t - 1).join("").replace(tt, "$1"), r, t < i && vt(n.slice(t, i)), i < o && vt(n = n.slice(i)), i < o && n.join(""))
				}
				f.push(r)
			}
			return yt(f)
		}
		function bi(n, t) {
			var f = t.length > 0,
			e = n.length > 0,
			i = function(o, s, c, l, a) {
				var p, b, d, y = [],
				k = 0,
				v = "0",
				tt = o && [],
				g = a != null,
				ut = nt,
				et = o || e && u.find.TAG("*", a && s.parentNode || s),
				rt = it += ut == null ? 1 : Math.E;
				for (g && (nt = s !== h && s, ot = i.el); (p = et[v]) != null; v++) {
					if (e && p) {
						for (b = 0; d = n[b]; b++) if (d(p, s, c)) {
							l.push(p);
							break
						}
						g && (it = rt, ot = ++i.el)
					}
					f && ((p = !d && p) && k--, o && tt.push(p))
				}
				if (k += v, f && v !== k) {
					for (b = 0; d = t[b]; b++) d(tt, y, s, c);
					if (o) {
						if (k > 0) while (v--) ! tt[v] && !y[v] && (y[v] = ki.call(l));
						y = ft(y)
					}
					w.apply(l, y),
					g && !o && y.length > 0 && k + t.length > 1 && r.uniqueSort(l)
				}
				return g && (it = rt, nt = ut),
				tt
			};
			return i.el = 0,
			f ? s(i) : i
		}
		function di(n, t, i, u) {
			for (var f = 0,
			e = t.length; f < e; f++) r(n, t[f], i, u);
			return i
		}
		function st(n, t, i, r, f) {
			var h, e, s, l, c, o = d(n),
			a = o.length;
			if (!r && o.length === 1) {
				if (e = o[0] = o[0].slice(0), e.length > 2 && (s = e[0]).type === "ID" && t.nodeType === 9 && !f && u.relative[e[1].type]) {
					if (t = u.find.ID(s.matches[0].replace(v, ""), t, f)[0], !t) return i;
					n = n.slice(e.shift().length)
				}
				for (h = g.POS.test(n) ? -1 : e.length - 1; h >= 0; h--) {
					if (s = e[h], u.relative[l = s.type]) break;
					if ((c = u.find[l]) && (r = c(s.matches[0].replace(v, ""), lt.test(e[0].type) && t.parentNode || t, f))) {
						if (e.splice(h, 1), n = r.length && e.join(""), !n) return w.apply(i, p.call(r, 0)),
						i;
						break
					}
				}
			}
			return kt(n, o)(r, t, f, i, lt.test(n)),
			i
		}
		function ei() {}
		var ot, wt, u, ut, et, ni, kt, bt, b, nt, ti = !0,
		c = "undefined",
		e = ("sizcache" + Math.random()).replace(".", ""),
		ri = String,
		h = n.document,
		o = h.documentElement,
		it = 0,
		gi = 0,
		ki = [].pop,
		w = [].push,
		p = [].slice,
		oi = [].indexOf ||
		function(n) {
			for (var t = 0,
			i = this.length; t < i; t++) if (this[t] === n) return t;
			return - 1
		},
		s = function(n, t) {
			return n[e] = t == null || t,
			n
		},
		ht = function() {
			var n = {},
			t = [];
			return s(function(i, r) {
				return t.push(i) > u.cacheLength && delete n[t.shift()],
				n[i] = r
			},
			n)
		},
		fi = ht(),
		hi = ht(),
		si = ht(),
		f = "[\\x20\\t\\r\\n\\f]",
		a = "(?:\\\\.|[-\\w]|[^\\x00-\\xa0])+",
		wi = a.replace("w", "w#"),
		ir = "([*^$|!~]?=)",
		gt = "\\[" + f + "*(" + a + ")" + f + "*(?:" + ir + f + "*(?:(['\"])((?:\\\\.|[^\\\\])*?)\\3|(" + wi + ")|)|)" + f + "*\\]",
		at = ":(" + a + ")(?:\\((?:(['\"])((?:\\\\.|[^\\\\])*?)\\2|([^()[\\]]*|(?:(?:" + gt + ")|[^:]|\\\\.)*|.*))\\)|)",
		ii = ":(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + f + "*((?:-\\d)?\\d*)" + f + "*\\)|)(?=[^-]|$)",
		tt = new RegExp("^" + f + "+|((?:^|[^\\\\])(?:\\\\.)*)" + f + "+$", "g"),
		nr = new RegExp("^" + f + "*," + f + "*"),
		rr = new RegExp("^" + f + "*([\\x20\\t\\r\\n\\f>+~])" + f + "*"),
		ur = new RegExp(at),
		tr = /^(?:#([\w\-]+)|(\w+)|\.([\w\-]+))$/,
		or = /^:not/,
		lt = /[\x20\t\r\n\f]*[+~]/,
		er = /:not\($/,
		ai = /h\d/i,
		ci = /input|select|textarea|button/i,
		v = /\\(?!\\)/g,
		g = {
			ID: new RegExp("^#(" + a + ")"),
			CLASS: new RegExp("^\\.(" + a + ")"),
			NAME: new RegExp("^\\[name=['\"]?(" + a + ")['\"]?\\]"),
			TAG: new RegExp("^(" + a.replace("w", "w*") + ")"),
			ATTR: new RegExp("^" + gt),
			PSEUDO: new RegExp("^" + at),
			POS: new RegExp(ii, "i"),
			CHILD: new RegExp("^:(only|nth|first|last)-child(?:\\(" + f + "*(even|odd|(([+-]|)(\\d*)n|)" + f + "*(?:([+-]|)" + f + "*(\\d+)|))" + f + "*\\)|)", "i"),
			needsContext: new RegExp("^" + f + "*[>+~]|" + ii, "i")
		},
		l = function(n) {
			var t = h.createElement("div");
			try {
				return n(t)
			} catch(i) {
				return ! 1
			} finally {
				t = null
			}
		},
		yi = l(function(n) {
			return n.appendChild(h.createComment("")),
			!n.getElementsByTagName("*").length
		}),
		pi = l(function(n) {
			return n.innerHTML = "<a href='#'></a>",
			n.firstChild && typeof n.firstChild.getAttribute !== c && n.firstChild.getAttribute("href") === "#"
		}),
		li = l(function(n) {
			n.innerHTML = "<select></select>";
			var t = typeof n.lastChild.getAttribute("multiple");
			return t !== "boolean" && t !== "string"
		}),
		dt = l(function(n) {
			return n.innerHTML = "<div class='hidden e'></div><div class='hidden'></div>",
			!n.getElementsByClassName || !n.getElementsByClassName("e").length ? !1 : (n.lastChild.className = "e", n.getElementsByClassName("e").length === 2)
		}),
		vi = l(function(n) {
			n.id = e + 0,
			n.innerHTML = "<a name='" + e + "'></a><div name='" + e + "'></div>",
			o.insertBefore(n, o.firstChild);
			var t = h.getElementsByName && h.getElementsByName(e).length === 2 + h.getElementsByName(e + 0).length;
			return wt = !h.getElementById(e),
			o.removeChild(n),
			t
		});
		try {
			p.call(o.childNodes, 0)[0].nodeType
		} catch(fr) {
			p = function(n) {
				for (var i, t = []; i = this[n]; n++) t.push(i);
				return t
			}
		}
		r.matches = function(n, t) {
			return r(n, null, null, t)
		},
		r.matchesSelector = function(n, t) {
			return r(t, null, null, [n]).length > 0
		},
		ut = r.getText = function(n) {
			var r, i = "",
			u = 0,
			t = n.nodeType;
			if (t) {
				if (t === 1 || t === 9 || t === 11) {
					if (typeof n.textContent == "string") return n.textContent;
					for (n = n.firstChild; n; n = n.nextSibling) i += ut(n)
				} else if (t === 3 || t === 4) return n.nodeValue
			} else for (; r = n[u]; u++) i += ut(r);
			return i
		},
		et = r.isXML = function(n) {
			var t = n && (n.ownerDocument || n).documentElement;
			return t ? t.nodeName !== "HTML": !1
		},
		ni = r.contains = o.contains ?
		function(n, t) {
			var r = n.nodeType === 9 ? n.documentElement: n,
			i = t && t.parentNode;
			return n === i || !!(i && i.nodeType === 1 && r.contains && r.contains(i))
		}: o.compareDocumentPosition ?
		function(n, t) {
			return t && !!(n.compareDocumentPosition(t) & 16)
		}: function(n, t) {
			while (t = t.parentNode) if (t === n) return ! 0;
			return ! 1
		},
		r.attr = function(n, t) {
			var i, r = et(n);
			return r || (t = t.toLowerCase()),
			(i = u.attrHandle[t]) ? i(n) : r || li ? n.getAttribute(t) : (i = n.getAttributeNode(t), i ? typeof n[t] == "boolean" ? n[t] ? t: null: i.specified ? i.value: null: null)
		},
		u = r.selectors = {
			cacheLength: 50,
			createPseudo: s,
			match: g,
			attrHandle: pi ? {}: {
				href: function(n) {
					return n.getAttribute("href", 2)
				},
				type: function(n) {
					return n.getAttribute("type")
				}
			},
			find: {
				ID: wt ?
				function(n, t, i) {
					if (typeof t.getElementById !== c && !i) {
						var r = t.getElementById(n);
						return r && r.parentNode ? [r] : []
					}
				}: function(n, i, r) {
					if (typeof i.getElementById !== c && !r) {
						var u = i.getElementById(n);
						return u ? u.id === n || typeof u.getAttributeNode !== c && u.getAttributeNode("id").value === n ? [u] : t: []
					}
				},
				TAG: yi ?
				function(n, t) {
					if (typeof t.getElementsByTagName !== c) return t.getElementsByTagName(n)
				}: function(n, t) {
					var f = t.getElementsByTagName(n),
					r,
					i,
					u;
					if (n === "*") {
						for (i = [], u = 0; r = f[u]; u++) r.nodeType === 1 && i.push(r);
						return i
					}
					return f
				},
				NAME: vi &&
				function(n, t) {
					if (typeof t.getElementsByName !== c) return t.getElementsByName(name)
				},
				CLASS: dt &&
				function(n, t, i) {
					if (typeof t.getElementsByClassName !== c && !i) return t.getElementsByClassName(n)
				}
			},
			relative: {
				">": {
					dir: "parentNode",
					first: !0
				},
				" ": {
					dir: "parentNode"
				},
				"+": {
					dir: "previousSibling",
					first: !0
				},
				"~": {
					dir: "previousSibling"
				}
			},
			preFilter: {
				ATTR: function(n) {
					return n[1] = n[1].replace(v, ""),
					n[3] = (n[4] || n[5] || "").replace(v, ""),
					n[2] === "~=" && (n[3] = " " + n[3] + " "),
					n.slice(0, 4)
				},
				CHILD: function(n) {
					return n[1] = n[1].toLowerCase(),
					n[1] === "nth" ? (n[2] || r.error(n[0]), n[3] = +(n[3] ? n[4] + (n[5] || 1) : 2 * (n[2] === "even" || n[2] === "odd")), n[4] = +(n[6] + n[7] || n[2] === "odd")) : n[2] && r.error(n[0]),
					n
				},
				PSEUDO: function(n) {
					var t, i;
					return g.CHILD.test(n[0]) ? null: (n[3] ? n[2] = n[3] : (t = n[4]) && (ur.test(t) && (i = d(t, !0)) && (i = t.indexOf(")", t.length - i) - t.length) && (t = t.slice(0, i), n[0] = n[0].slice(0, i)), n[2] = t), n.slice(0, 3))
				}
			},
			filter: {
				ID: wt ?
				function(n) {
					return n = n.replace(v, ""),
					function(t) {
						return t.getAttribute("id") === n
					}
				}: function(n) {
					return n = n.replace(v, ""),
					function(t) {
						var i = typeof t.getAttributeNode !== c && t.getAttributeNode("id");
						return i && i.value === n
					}
				},
				TAG: function(n) {
					return n === "*" ?
					function() {
						return ! 0
					}: (n = n.replace(v, "").toLowerCase(),
					function(t) {
						return t.nodeName && t.nodeName.toLowerCase() === n
					})
				},
				CLASS: function(n) {
					var t = fi[e][n];
					return t || (t = fi(n, new RegExp("(^|" + f + ")" + n + "(" + f + "|$)"))),
					function(n) {
						return t.test(n.className || typeof n.getAttribute !== c && n.getAttribute("class") || "")
					}
				},
				ATTR: function(n, t, i) {
					return function(u) {
						var e = r.attr(u, n);
						return e == null ? t === "!=": t ? (e += "", t === "=" ? e === i: t === "!=" ? e !== i: t === "^=" ? i && e.indexOf(i) === 0 : t === "*=" ? i && e.indexOf(i) > -1 : t === "$=" ? i && e.substr(e.length - i.length) === i: t === "~=" ? (" " + e + " ").indexOf(i) > -1 : t === "|=" ? e === i || e.substr(0, i.length + 1) === i + "-": !1) : !0
					}
				},
				CHILD: function(n, t, i, r) {
					return n === "nth" ?
					function(n) {
						var u, t, f = n.parentNode;
						if (i === 1 && r === 0) return ! 0;
						if (f) for (t = 0, u = f.firstChild; u; u = u.nextSibling) if (u.nodeType === 1 && (t++, n === u)) break;
						return t -= r,
						t === i || t % i == 0 && t / i >= 0
					}: function(t) {
						var i = t;
						switch (n) {
						case "only":
						case "first":
							while (i = i.previousSibling) if (i.nodeType === 1) return ! 1;
							if (n === "first") return ! 0;
							i = t;
						case "last":
							while (i = i.nextSibling) if (i.nodeType === 1) return ! 1;
							return ! 0
						}
					}
				},
				PSEUDO: function(n, t) {
					var f, i = u.pseudos[n] || u.setFilters[n.toLowerCase()] || r.error("unsupported pseudo: " + n);
					return i[e] ? i(t) : i.length > 1 ? (f = [n, n, "", t], u.setFilters.hasOwnProperty(n.toLowerCase()) ? s(function(n, r) {
						for (var e, f = i(n, t), u = f.length; u--;) e = oi.call(n, f[u]),
						n[e] = !(r[e] = f[u])
					}) : function(n) {
						return i(n, 0, f)
					}) : i
				}
			},
			pseudos: {
				not: s(function(n) {
					var i = [],
					r = [],
					t = kt(n.replace(tt, "$1"));
					return t[e] ? s(function(n, i, r, u) {
						for (var e, o = t(n, null, u, []), f = n.length; f--;)(e = o[f]) && (n[f] = !(i[f] = e))
					}) : function(n, u, f) {
						return i[0] = n,
						t(i, null, f, r),
						!r.pop()
					}
				}),
				has: s(function(n) {
					return function(t) {
						return r(n, t).length > 0
					}
				}),
				contains: s(function(n) {
					return function(t) {
						return (t.textContent || t.innerText || ut(t)).indexOf(n) > -1
					}
				}),
				enabled: function(n) {
					return n.disabled === !1
				},
				disabled: function(n) {
					return n.disabled === !0
				},
				checked: function(n) {
					var t = n.nodeName.toLowerCase();
					return t === "input" && !!n.checked || t === "option" && !!n.selected
				},
				selected: function(n) {
					return n.parentNode && n.parentNode.selectedIndex,
					n.selected === !0
				},
				parent: function(n) {
					return ! u.pseudos.empty(n)
				},
				empty: function(n) {
					var t;
					for (n = n.firstChild; n;) {
						if (n.nodeName > "@" || (t = n.nodeType) === 3 || t === 4) return ! 1;
						n = n.nextSibling
					}
					return ! 0
				},
				header: function(n) {
					return ai.test(n.nodeName)
				},
				text: function(n) {
					var i, t;
					return n.nodeName.toLowerCase() === "input" && (i = n.type) === "text" && ((t = n.getAttribute("type")) == null || t.toLowerCase() === i)
				},
				radio: k("radio"),
				checkbox: k("checkbox"),
				file: k("file"),
				password: k("password"),
				image: k("image"),
				submit: ui("submit"),
				reset: ui("reset"),
				button: function(n) {
					var t = n.nodeName.toLowerCase();
					return t === "input" && n.type === "button" || t === "button"
				},
				input: function(n) {
					return ci.test(n.nodeName)
				},
				focus: function(n) {
					var t = n.ownerDocument;
					return n === t.activeElement && (!t.hasFocus || t.hasFocus()) && ( !! n.type || !!n.href)
				},
				active: function(n) {
					return n === n.ownerDocument.activeElement
				},
				first: y(function() {
					return [0]
				}),
				last: y(function(n, t) {
					return [t - 1]
				}),
				eq: y(function(n, t, i) {
					return [i < 0 ? i + t: i]
				}),
				even: y(function(n, t) {
					for (var r = 0; r < t; r += 2) n.push(r);
					return n
				}),
				odd: y(function(n, t) {
					for (var r = 1; r < t; r += 2) n.push(r);
					return n
				}),
				lt: y(function(n, t, i) {
					for (var r = i < 0 ? i + t: i; --r >= 0;) n.push(r);
					return n
				}),
				gt: y(function(n, t, i) {
					for (var r = i < 0 ? i + t: i; ++r < t;) n.push(r);
					return n
				})
			}
		},
		bt = o.compareDocumentPosition ?
		function(n, t) {
			return n === t ? (b = !0, 0) : (!n.compareDocumentPosition || !t.compareDocumentPosition ? n.compareDocumentPosition: n.compareDocumentPosition(t) & 4) ? -1 : 1
		}: function(n, t) {
			var i;
			if (n === t) return b = !0,
			0;
			if (n.sourceIndex && t.sourceIndex) return n.sourceIndex - t.sourceIndex;
			var o, h, f = [],
			u = [],
			s = n.parentNode,
			e = t.parentNode,
			r = s;
			if (s === e) return rt(n, t);
			if (!s) return - 1;
			if (!e) return 1;
			while (r) f.unshift(r),
			r = r.parentNode;
			for (r = e; r;) u.unshift(r),
			r = r.parentNode;
			for (o = f.length, h = u.length, i = 0; i < o && i < h; i++) if (f[i] !== u[i]) return rt(f[i], u[i]);
			return i === o ? rt(n, u[i], -1) : rt(f[i], t, 1)
		},
		[0, 0].sort(bt),
		ti = !b,
		r.uniqueSort = function(n) {
			var i, t = 1;
			if (b = ti, n.sort(bt), b) for (; i = n[t]; t++) i === n[t - 1] && n.splice(t--, 1);
			return n
		},
		r.error = function(n) {
			throw new Error("Syntax error, unrecognized expression: " + n);
		},
		kt = r.compile = function(n, t) {
			var r, u = [],
			f = [],
			i = si[e][n];
			if (!i) {
				for (t || (t = d(n)), r = t.length; r--;) i = vt(t[r]),
				i[e] ? u.push(i) : f.push(i);
				i = si(n, bi(f, u))
			}
			return i
		},
		h.querySelectorAll &&
		function() {
			var u, h = st,
			c = /'|\\/g,
			s = /\=[\x20\t\r\n\f]*([^'"\]]*)[\x20\t\r\n\f]*\]/g,
			n = [":focus"],
			i = [":active", ":focus"],
			t = o.matchesSelector || o.mozMatchesSelector || o.webkitMatchesSelector || o.oMatchesSelector || o.msMatchesSelector;
			l(function(t) {
				t.innerHTML = "<select><option selected=''></option></select>",
				t.querySelectorAll("[selected]").length || n.push("\\[" + f + "*(?:checked|disabled|ismap|multiple|readonly|selected|value)"),
				t.querySelectorAll(":checked").length || n.push(":checked")
			}),
			l(function(t) {
				t.innerHTML = "<p test=''></p>",
				t.querySelectorAll("[test^='']").length && n.push("[*^$]=" + f + "*(?:\"\"|'')"),
				t.innerHTML = "<input type='hidden'/>",
				t.querySelectorAll(":enabled").length || n.push(":enabled", ":disabled")
			}),
			n = new RegExp(n.join("|")),
			st = function(t, i, r, u, f) {
				if (!u && !f && (!n || !n.test(t))) {
					var s, l, v = !0,
					o = e,
					y = i,
					a = i.nodeType === 9 && t;
					if (i.nodeType === 1 && i.nodeName.toLowerCase() !== "object") {
						for (s = d(t), (v = i.getAttribute("id")) ? o = v.replace(c, "\\$&") : i.setAttribute("id", o), o = "[id='" + o + "'] ", l = s.length; l--;) s[l] = o + s[l].join("");
						y = lt.test(t) && i.parentNode || i,
						a = s.join(",")
					}
					if (a) try {
						return w.apply(r, p.call(y.querySelectorAll(a), 0)),
						r
					} catch(b) {} finally {
						v || i.removeAttribute("id")
					}
				}
				return h(t, i, r, u, f)
			},
			t && (l(function(n) {
				u = t.call(n, "div");
				try {
					t.call(n, "[test!='']:sizzle"),
					i.push("!=", at)
				} catch(r) {}
			}), i = new RegExp(i.join("|")), r.matchesSelector = function(f, e) {
				if (e = e.replace(s, "='$1']"), !et(f) && !i.test(e) && (!n || !n.test(e))) try {
					var o = t.call(f, e);
					if (o || u || f.document && f.document.nodeType !== 11) return o
				} catch(h) {}
				return r(e, null, null, [f]).length > 0
			})
		} (),
		u.pseudos.nth = u.pseudos.eq,
		u.filters = ei.prototype = u.pseudos,
		u.setFilters = new ei,
		r.attr = i.attr,
		i.find = r,
		i.expr = r.selectors,
		i.expr[":"] = i.expr.pseudos,
		i.unique = r.uniqueSort,
		i.text = r.getText,
		i.isXMLDoc = r.isXML,
		i.contains = r.contains
	} (n);
	var eo = /Until$/,
	oo = /^(?:parents|prev(?:Until|All))/,
	yo = /^.[^:#\[\.,]*$/,
	ci = i.expr.match.needsContext,
	po = {
		children: !0,
		contents: !0,
		next: !0,
		prev: !0
	};
	i.fn.extend({
		find: function(n) {
			var t, e, o, u, f, r, s = this;
			if (typeof n != "string") return i(n).filter(function() {
				for (t = 0, e = s.length; t < e; t++) if (i.contains(s[t], this)) return ! 0
			});
			for (r = this.pushStack("", "find", n), t = 0, e = this.length; t < e; t++) if (o = r.length, i.find(n, this[t], r), t > 0) for (u = o; u < r.length; u++) for (f = 0; f < o; f++) if (r[f] === r[u]) {
				r.splice(u--, 1);
				break
			}
			return r
		},
		has: function(n) {
			var t, r = i(n, this),
			u = r.length;
			return this.filter(function() {
				for (t = 0; t < u; t++) if (i.contains(this, r[t])) return ! 0
			})
		},
		not: function(n) {
			return this.pushStack(yr(this, n, !1), "not", n)
		},
		filter: function(n) {
			return this.pushStack(yr(this, n, !0), "filter", n)
		},
		is: function(n) {
			return !! n && (typeof n == "string" ? ci.test(n) ? i(n, this.context).index(this[0]) >= 0 : i.filter(n, this).length > 0 : this.filter(n).length > 0)
		},
		closest: function(n, t) {
			for (var r, f = 0,
			o = this.length,
			u = [], e = ci.test(n) || typeof n != "string" ? i(n, t || this.context) : 0; f < o; f++) for (r = this[f]; r && r.ownerDocument && r !== t && r.nodeType !== 11;) {
				if (e ? e.index(r) > -1 : i.find.matchesSelector(r, n)) {
					u.push(r);
					break
				}
				r = r.parentNode
			}
			return u = u.length > 1 ? i.unique(u) : u,
			this.pushStack(u, "closest", n)
		},
		index: function(n) {
			return n ? typeof n == "string" ? i.inArray(this[0], i(n)) : i.inArray(n.jquery ? n[0] : n, this) : this[0] && this[0].parentNode ? this.prevAll().length: -1
		},
		add: function(n, t) {
			var u = typeof n == "string" ? i(n, t) : i.makeArray(n && n.nodeType ? [n] : n),
			r = i.merge(this.get(), u);
			return this.pushStack(k(u[0]) || k(r[0]) ? r: i.unique(r))
		},
		addBack: function(n) {
			return this.add(n == null ? this.prevObject: this.prevObject.filter(n))
		}
	}),
	i.fn.andSelf = i.fn.addBack,
	i.each({
		parent: function(n) {
			var t = n.parentNode;
			return t && t.nodeType !== 11 ? t: null
		},
		parents: function(n) {
			return i.dir(n, "parentNode")
		},
		parentsUntil: function(n, t, r) {
			return i.dir(n, "parentNode", r)
		},
		next: function(n) {
			return kr(n, "nextSibling")
		},
		prev: function(n) {
			return kr(n, "previousSibling")
		},
		nextAll: function(n) {
			return i.dir(n, "nextSibling")
		},
		prevAll: function(n) {
			return i.dir(n, "previousSibling")
		},
		nextUntil: function(n, t, r) {
			return i.dir(n, "nextSibling", r)
		},
		prevUntil: function(n, t, r) {
			return i.dir(n, "previousSibling", r)
		},
		siblings: function(n) {
			return i.sibling((n.parentNode || {}).firstChild, n)
		},
		children: function(n) {
			return i.sibling(n.firstChild)
		},
		contents: function(n) {
			return i.nodeName(n, "iframe") ? n.contentDocument || n.contentWindow.document: i.merge([], n.childNodes)
		}
	},
	function(n, t) {
		i.fn[n] = function(r, u) {
			var f = i.map(this, t, r);
			return eo.test(n) || (u = r),
			u && typeof u == "string" && (f = i.filter(u, f)),
			f = this.length > 1 && !po[n] ? i.unique(f) : f,
			this.length > 1 && oo.test(n) && (f = f.reverse()),
			this.pushStack(f, n, o.call(arguments).join(","))
		}
	}),
	i.extend({
		filter: function(n, t, r) {
			return r && (n = ":not(" + n + ")"),
			t.length === 1 ? i.find.matchesSelector(t[0], n) ? [t[0]] : [] : i.find.matches(n, t)
		},
		dir: function(n, r, u) {
			for (var e = [], f = n[r]; f && f.nodeType !== 9 && (u === t || f.nodeType !== 1 || !i(f).is(u));) f.nodeType === 1 && e.push(f),
			f = f[r];
			return e
		},
		sibling: function(n, t) {
			for (var i = []; n; n = n.nextSibling) n.nodeType === 1 && n !== t && i.push(n);
			return i
		}
	});
	var si = "abbr|article|aside|audio|bdi|canvas|data|datalist|details|figcaption|figure|footer|header|hgroup|mark|meter|nav|output|progress|section|summary|time|video",
	vo = / jQuery\d+="(?:null|\d+)"/g,
	bt = /^\s+/,
	or = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi,
	er = /<([\w:]+)/,
	lo = /<tbody/i,
	ao = /<|&#?\w+;/,
	fo = /<(?:script|style|link)/i,
	de = /<(?:script|object|embed|option|style)/i,
	ni = new RegExp("<(?:" + si + ")[\\s/>]", "i"),
	nu = /^(?:checkbox|radio)$/,
	sr = /checked\s*(?:[^=]|=\s*.checked.)/i,
	we = /\/(java|ecma)script/i,
	be = /^\s*<!(?:\[CDATA\[|\-\-)|[\]\-]{2}>\s*$/g,
	e = {
		option: [1, "<select multiple='multiple'>", "</select>"],
		legend: [1, "<fieldset>", "</fieldset>"],
		thead: [1, "<table>", "</table>"],
		tr: [2, "<table><tbody>", "</tbody></table>"],
		td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
		col: [2, "<table><tbody></tbody><colgroup>", "</colgroup></table>"],
		area: [1, "<map>", "</map>"],
		_default: [0, "", ""]
	},
	nr = br(r),
	at = nr.appendChild(r.createElement("div"));
	e.optgroup = e.option,
	e.tbody = e.tfoot = e.colgroup = e.caption = e.thead,
	e.th = e.td,
	i.support.htmlSerialize || (e._default = [1, "X<div>", "</div>"]),
	i.fn.extend({
		text: function(n) {
			return i.access(this,
			function(n) {
				return n === t ? i.text(this) : this.empty().append((this[0] && this[0].ownerDocument || r).createTextNode(n))
			},
			null, n, arguments.length)
		},
		wrapAll: function(n) {
			if (i.isFunction(n)) return this.each(function(t) {
				i(this).wrapAll(n.call(this, t))
			});
			if (this[0]) {
				var t = i(n, this[0].ownerDocument).eq(0).clone(!0);
				this[0].parentNode && t.insertBefore(this[0]),
				t.map(function() {
					for (var n = this; n.firstChild && n.firstChild.nodeType === 1;) n = n.firstChild;
					return n
				}).append(this)
			}
			return this
		},
		wrapInner: function(n) {
			return i.isFunction(n) ? this.each(function(t) {
				i(this).wrapInner(n.call(this, t))
			}) : this.each(function() {
				var r = i(this),
				t = r.contents();
				t.length ? t.wrapAll(n) : r.append(n)
			})
		},
		wrap: function(n) {
			var t = i.isFunction(n);
			return this.each(function(r) {
				i(this).wrapAll(t ? n.call(this, r) : n)
			})
		},
		unwrap: function() {
			return this.parent().each(function() {
				i.nodeName(this, "body") || i(this).replaceWith(this.childNodes)
			}).end()
		},
		append: function() {
			return this.domManip(arguments, !0,
			function(n) { (this.nodeType === 1 || this.nodeType === 11) && this.appendChild(n)
			})
		},
		prepend: function() {
			return this.domManip(arguments, !0,
			function(n) { (this.nodeType === 1 || this.nodeType === 11) && this.insertBefore(n, this.firstChild)
			})
		},
		before: function() {
			if (!k(this[0])) return this.domManip(arguments, !1,
			function(n) {
				this.parentNode.insertBefore(n, this)
			});
			if (arguments.length) {
				var n = i.clean(arguments);
				return this.pushStack(i.merge(n, this), "before", this.selector)
			}
		},
		after: function() {
			if (!k(this[0])) return this.domManip(arguments, !1,
			function(n) {
				this.parentNode.insertBefore(n, this.nextSibling)
			});
			if (arguments.length) {
				var n = i.clean(arguments);
				return this.pushStack(i.merge(this, n), "after", this.selector)
			}
		},
		remove: function(n, t) {
			for (var r, u = 0; (r = this[u]) != null; u++)(!n || i.filter(n, [r]).length) && (!t && r.nodeType === 1 && (i.cleanData(r.getElementsByTagName("*")), i.cleanData([r])), r.parentNode && r.parentNode.removeChild(r));
			return this
		},
		empty: function() {
			for (var n, t = 0; (n = this[t]) != null; t++) for (n.nodeType === 1 && i.cleanData(n.getElementsByTagName("*")); n.firstChild;) n.removeChild(n.firstChild);
			return this
		},
		clone: function(n, t) {
			return n = n == null ? !1 : n,
			t = t == null ? n: t,
			this.map(function() {
				return i.clone(this, n, t)
			})
		},
		html: function(n) {
			return i.access(this,
			function(n) {
				var r = this[0] || {},
				u = 0,
				f = this.length;
				if (n === t) return r.nodeType === 1 ? r.innerHTML.replace(vo, "") : t;
				if (typeof n == "string" && !fo.test(n) && (i.support.htmlSerialize || !ni.test(n)) && (i.support.leadingWhitespace || !bt.test(n)) && !e[(er.exec(n) || ["", ""])[1].toLowerCase()]) {
					n = n.replace(or, "<$1></$2>");
					try {
						for (; u < f; u++) r = this[u] || {},
						r.nodeType === 1 && (i.cleanData(r.getElementsByTagName("*")), r.innerHTML = n);
						r = 0
					} catch(o) {}
				}
				r && this.empty().append(n)
			},
			null, n, arguments.length)
		},
		replaceWith: function(n) {
			return k(this[0]) ? this.length ? this.pushStack(i(i.isFunction(n) ? n() : n), "replaceWith", n) : this: i.isFunction(n) ? this.each(function(t) {
				var r = i(this),
				u = r.html();
				r.replaceWith(n.call(this, t, u))
			}) : (typeof n != "string" && (n = i(n).detach()), this.each(function() {
				var t = this.nextSibling,
				r = this.parentNode;
				i(this).remove(),
				t ? i(t).before(n) : i(r).append(n)
			}))
		},
		detach: function(n) {
			return this.remove(n, !0)
		},
		domManip: function(n, r, u) {
			n = [].concat.apply([], n);
			var l, o, f, a, e = 0,
			s = n[0],
			h = [],
			c = this.length;
			if (!i.support.checkClone && c > 1 && typeof s == "string" && sr.test(s)) return this.each(function() {
				i(this).domManip(n, r, u)
			});
			if (i.isFunction(s)) return this.each(function(f) {
				var e = i(this);
				n[0] = s.call(this, f, r ? e.html() : t),
				e.domManip(n, r, u)
			});
			if (this[0]) {
				if (l = i.buildFragment(n, this, h), f = l.fragment, o = f.firstChild, f.childNodes.length === 1 && (f = o), o) for (r = r && i.nodeName(o, "tr"), a = l.cacheable || c - 1; e < c; e++) u.call(r && i.nodeName(this[e], "table") ? uf(this[e], "tbody") : this[e], e === a ? f: i.clone(f, !0, !0));
				f = o = null,
				h.length && i.each(h,
				function(n, t) {
					t.src ? i.ajax ? i.ajax({
						url: t.src,
						type: "GET",
						dataType: "script",
						async: !1,
						global: !1,
						throws: !0
					}) : i.error("no ajax") : i.globalEval((t.text || t.textContent || t.innerHTML || "").replace(be, "")),
					t.parentNode && t.parentNode.removeChild(t)
				})
			}
			return this
		}
	}),
	i.buildFragment = function(n, u, f) {
		var o, s, h, e = n[0];
		return u = u || r,
		u = !u.nodeType && u[0] || u,
		u = u.ownerDocument || u,
		n.length === 1 && typeof e == "string" && e.length < 512 && u === r && e.charAt(0) === "<" && !de.test(e) && (i.support.checkClone || !sr.test(e)) && (i.support.html5Clone || !ni.test(e)) && (s = !0, o = i.fragments[e], h = o !== t),
		o || (o = u.createDocumentFragment(), i.clean(n, u, o, f), s && (i.fragments[e] = h && o)),
		{
			fragment: o,
			cacheable: s
		}
	},
	i.fragments = {},
	i.each({
		appendTo: "append",
		prependTo: "prepend",
		insertBefore: "before",
		insertAfter: "after",
		replaceAll: "replaceWith"
	},
	function(n, t) {
		i.fn[n] = function(r) {
			var s, e = 0,
			o = [],
			f = i(r),
			h = f.length,
			u = this.length === 1 && this[0].parentNode;
			if ((u == null || u && u.nodeType === 11 && u.childNodes.length === 1) && h === 1) return f[t](this[0]),
			this;
			for (; e < h; e++) s = (e > 0 ? this.clone(!0) : this).get(),
			i(f[e])[t](s),
			o = o.concat(s);
			return this.pushStack(o, n, f.selector)
		}
	}),
	i.extend({
		clone: function(n, t, r) {
			var e, o, u, f;
			if (i.support.html5Clone || i.isXMLDoc(n) || !ni.test("<" + n.nodeName + ">") ? f = n.cloneNode(!0) : (at.innerHTML = n.outerHTML, at.removeChild(f = at.firstChild)), (!i.support.noCloneEvent || !i.support.noCloneChecked) && (n.nodeType === 1 || n.nodeType === 11) && !i.isXMLDoc(n)) for (vi(n, f), e = ft(n), o = ft(f), u = 0; e[u]; ++u) o[u] && vi(e[u], o[u]);
			if (t && (wr(n, f), r)) for (e = ft(n), o = ft(f), u = 0; e[u]; ++u) wr(e[u], o[u]);
			return e = o = null,
			f
		},
		clean: function(n, t, u, f) {
			var h, l, o, w, v, d, s, k, a, g, b, p, y = t === r && nr,
			c = [];
			for (t && typeof t.createDocumentFragment != "undefined" || (t = r), h = 0; (o = n[h]) != null; h++) if (typeof o == "number" && (o += ""), o) {
				if (typeof o == "string") if (ao.test(o)) {
					for (y = y || br(t), s = t.createElement("div"), y.appendChild(s), o = o.replace(or, "<$1></$2>"), w = (er.exec(o) || ["", ""])[1].toLowerCase(), v = e[w] || e._default, d = v[0], s.innerHTML = v[1] + o + v[2]; d--;) s = s.lastChild;
					if (!i.support.tbody) for (k = lo.test(o), a = w === "table" && !k ? s.firstChild && s.firstChild.childNodes: v[1] === "<table>" && !k ? s.childNodes: [], l = a.length - 1; l >= 0; --l) i.nodeName(a[l], "tbody") && !a[l].childNodes.length && a[l].parentNode.removeChild(a[l]); ! i.support.leadingWhitespace && bt.test(o) && s.insertBefore(t.createTextNode(bt.exec(o)[0]), s.firstChild),
					o = s.childNodes,
					s.parentNode.removeChild(s)
				} else o = t.createTextNode(o);
				o.nodeType ? c.push(o) : i.merge(c, o)
			}
			if (s && (o = s = y = null), !i.support.appendChecked) for (h = 0; (o = c[h]) != null; h++) i.nodeName(o, "input") ? oi(o) : typeof o.getElementsByTagName != "undefined" && i.grep(o.getElementsByTagName("input"), oi);
			if (u) for (b = function(n) {
				if (!n.type || we.test(n.type)) return f ? f.push(n.parentNode ? n.parentNode.removeChild(n) : n) : u.appendChild(n)
			},
			h = 0; (o = c[h]) != null; h++) i.nodeName(o, "script") && b(o) || (u.appendChild(o), typeof o.getElementsByTagName != "undefined" && (p = i.grep(i.merge([], o.getElementsByTagName("script")), b), c.splice.apply(c, [h + 1, 0].concat(p)), h += p.length));
			return c
		},
		cleanData: function(n, t) {
			for (var f, u, r, o, h = 0,
			e = i.expando,
			s = i.cache,
			l = i.support.deleteExpando,
			c = i.event.special; (r = n[h]) != null; h++) if ((t || i.acceptData(r)) && (u = r[e], f = u && s[u], f)) {
				if (f.events) for (o in f.events) c[o] ? i.event.remove(r, o) : i.removeEvent(r, o, f.handle);
				s[u] && (delete s[u], l ? delete r[e] : r.removeAttribute ? r.removeAttribute(e) : r[e] = null, i.deletedIds.push(u))
			}
		}
	}),
	function() {
		var t, n;
		i.uaMatch = function(n) {
			n = n.toLowerCase();
			var t = /(chrome)[ \/]([\w.]+)/.exec(n) || /(webkit)[ \/]([\w.]+)/.exec(n) || /(opera)(?:.*version|)[ \/]([\w.]+)/.exec(n) || /(msie) ([\w.]+)/.exec(n) || n.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec(n) || [];
			return {
				browser: t[1] || "",
				version: t[2] || "0"
			}
		},
		t = i.uaMatch(he.userAgent),
		n = {},
		t.browser && (n[t.browser] = !0, n.version = t.version),
		n.chrome ? n.webkit = !0 : n.webkit && (n.safari = !0),
		i.browser = n,
		i.sub = function() {
			function n(t, i) {
				return new n.fn.init(t, i)
			}
			i.extend(!0, n, this),
			n.superclass = this,
			n.fn = n.prototype = this(),
			n.fn.constructor = n,
			n.sub = this.sub,
			n.fn.init = function u(c, r) {
				return r && r instanceof i && !(r instanceof n) && (r = n(r)),
				i.fn.init.call(this, u, r, t)
			},
			n.fn.init.prototype = n.fn;
			var t = n(r);
			return n
		}
	} ();
	var u, p, w, yt = /alpha\([^)]*\)/i,
	uo = /opacity=([^)]*)/,
	io = /^(top|right|bottom|left)$/,
	no = /^(none|table(?!-c[ea]).+)/,
	ir = /^margin/,
	to = new RegExp("^(" + tt + ")(.*)$", "i"),
	lt = new RegExp("^(" + tt + ")(?!px)[a-z%]+$", "i"),
	gu = new RegExp("^([-+])=(" + tt + ")", "i"),
	gt = {},
	nf = {
		position: "absolute",
		visibility: "hidden",
		display: "block"
	},
	hr = {
		letterSpacing: 0,
		fontWeight: 400
	},
	l = ["Top", "Right", "Bottom", "Left"],
	lr = ["Webkit", "O", "Moz", "ms"],
	lf = i.fn.toggle;
	i.fn.extend({
		css: function(n, r) {
			return i.access(this,
			function(n, r, u) {
				return u !== t ? i.style(n, r, u) : i.css(n, r)
			},
			n, r, arguments.length > 1)
		},
		show: function() {
			return cr(this, !0)
		},
		hide: function() {
			return cr(this)
		},
		toggle: function(n, t) {
			var r = typeof n == "boolean";
			return i.isFunction(n) && i.isFunction(t) ? lf.apply(this, arguments) : this.each(function() { (r ? n: et(this)) ? i(this).show() : i(this).hide()
			})
		}
	}),
	i.extend({
		cssHooks: {
			opacity: {
				get: function(n, t) {
					if (t) {
						var i = u(n, "opacity");
						return i === "" ? "1": i
					}
				}
			}
		},
		cssNumber: {
			fillOpacity: !0,
			fontWeight: !0,
			lineHeight: !0,
			opacity: !0,
			orphans: !0,
			widows: !0,
			zIndex: !0,
			zoom: !0
		},
		cssProps: {
			float: i.support.cssFloat ? "cssFloat": "styleFloat"
		},
		style: function(n, r, u, f) {
			if (n && n.nodeType !== 3 && n.nodeType !== 8 && n.style) {
				var s, h, e, o = i.camelCase(r),
				c = n.style;
				if (r = i.cssProps[o] || (i.cssProps[o] = hi(c, o)), e = i.cssHooks[r] || i.cssHooks[o], u === t) return e && "get" in e && (s = e.get(n, !1, f)) !== t ? s: c[r];
				if ((h = typeof u, h === "string" && (s = gu.exec(u)) && (u = (s[1] + 1) * s[2] + parseFloat(i.css(n, r)), h = "number"), u != null && (h !== "number" || !isNaN(u))) && (h === "number" && !i.cssNumber[o] && (u += "px"), !e || !("set" in e) || (u = e.set(n, u, f)) !== t)) try {
					c[r] = u
				} catch(l) {}
			}
		},
		css: function(n, r, f, e) {
			var o, c, s, h = i.camelCase(r);
			return r = i.cssProps[h] || (i.cssProps[h] = hi(n.style, h)),
			s = i.cssHooks[r] || i.cssHooks[h],
			s && "get" in s && (o = s.get(n, !0, e)),
			o === t && (o = u(n, r)),
			o === "normal" && r in hr && (o = hr[r]),
			f || e !== t ? (c = parseFloat(o), f || i.isNumeric(c) ? c || 0 : o) : o
		},
		swap: function(n, t, i) {
			var f, r, u = {};
			for (r in t) u[r] = n.style[r],
			n.style[r] = t[r];
			f = i.call(n);
			for (r in t) n.style[r] = u[r];
			return f
		}
	}),
	n.getComputedStyle ? u = function(t, r) {
		var f, o, s, h, e = n.getComputedStyle(t, null),
		u = t.style;
		return e && (f = e[r], f === "" && !i.contains(t.ownerDocument, t) && (f = i.style(t, r)), lt.test(f) && ir.test(r) && (o = u.width, s = u.minWidth, h = u.maxWidth, u.minWidth = u.maxWidth = u.width = f, f = e.width, u.width = o, u.minWidth = s, u.maxWidth = h)),
		f
	}: r.documentElement.currentStyle && (u = function(n, t) {
		var f, u, i = n.currentStyle && n.currentStyle[t],
		r = n.style;
		return i == null && r && r[t] && (i = r[t]),
		lt.test(i) && !io.test(t) && (f = r.left, u = n.runtimeStyle && n.runtimeStyle.left, u && (n.runtimeStyle.left = n.currentStyle.left), r.left = t === "fontSize" ? "1em": i, i = r.pixelLeft + "px", r.left = f, u && (n.runtimeStyle.left = u)),
		i === "" ? "auto": i
	}),
	i.each(["height", "width"],
	function(n, t) {
		i.cssHooks[t] = {
			get: function(n, r, f) {
				if (r) return n.offsetWidth === 0 && no.test(u(n, "display")) ? i.swap(n, nf,
				function() {
					return ur(n, t, f)
				}) : ur(n, t, f)
			},
			set: function(n, r, u) {
				return rr(n, r, u ? wi(n, t, u, i.support.boxSizing && i.css(n, "boxSizing") === "border-box") : 0)
			}
		}
	}),
	i.support.opacity || (i.cssHooks.opacity = {
		get: function(n, t) {
			return uo.test((t && n.currentStyle ? n.currentStyle.filter: n.style.filter) || "") ? .01 * parseFloat(RegExp.$1) + "": t ? "1": ""
		},
		set: function(n, t) {
			var r = n.style,
			f = n.currentStyle,
			e = i.isNumeric(t) ? "alpha(opacity=" + t * 100 + ")": "",
			u = f && f.filter || r.filter || ""; (r.zoom = 1, t >= 1 && i.trim(u.replace(yt, "")) === "" && r.removeAttribute && (r.removeAttribute("filter"), f && !f.filter)) || (r.filter = yt.test(u) ? u.replace(yt, e) : u + " " + e)
		}
	}),
	i(function() {
		i.support.reliableMarginRight || (i.cssHooks.marginRight = {
			get: function(n, t) {
				return i.swap(n, {
					display: "inline-block"
				},
				function() {
					if (t) return u(n, "marginRight")
				})
			}
		}),
		!i.support.pixelPosition && i.fn.position && i.each(["top", "left"],
		function(n, t) {
			i.cssHooks[t] = {
				get: function(n, r) {
					if (r) {
						var f = u(n, t);
						return lt.test(f) ? i(n).position()[t] + "px": f
					}
				}
			}
		})
	}),
	i.expr && i.expr.filters && (i.expr.filters.hidden = function(n) {
		return n.offsetWidth === 0 && n.offsetHeight === 0 || !i.support.reliableHiddenOffsets && (n.style && n.style.display || u(n, "display")) === "none"
	},
	i.expr.filters.visible = function(n) {
		return ! i.expr.filters.hidden(n)
	}),
	i.each({
		margin: "",
		padding: "",
		border: "Width"
	},
	function(n, t) {
		i.cssHooks[n + t] = {
			expand: function(i) {
				for (var u = typeof i == "string" ? i.split(" ") : [i], f = {},
				r = 0; r < 4; r++) f[n + l[r] + t] = u[r] || u[r - 2] || u[0];
				return f
			}
		},
		ir.test(n) || (i.cssHooks[n + t].set = rr)
	});
	var cf = /%20/g,
	hf = /\[\]$/,
	fr = /\r?\n/g,
	yf = /^(?:color|date|datetime|datetime-local|email|hidden|month|number|password|range|search|tel|text|time|url|week)$/i,
	vf = /^(?:select|textarea)/i;
	i.fn.extend({
		serialize: function() {
			return i.param(this.serializeArray())
		},
		serializeArray: function() {
			return this.map(function() {
				return this.elements ? i.makeArray(this.elements) : this
			}).filter(function() {
				return this.name && !this.disabled && (this.checked || vf.test(this.nodeName) || yf.test(this.type))
			}).map(function(n, t) {
				var r = i(this).val();
				return r == null ? null: i.isArray(r) ? i.map(r,
				function(n) {
					return {
						name: t.name,
						value: n.replace(fr, "\r\n")
					}
				}) : {
					name: t.name,
					value: r.replace(fr, "\r\n")
				}
			}).get()
		}
	}),
	i.param = function(n, r) {
		var f, u = [],
		e = function(n, t) {
			t = i.isFunction(t) ? t() : t == null ? "": t,
			u[u.length] = encodeURIComponent(n) + "=" + encodeURIComponent(t)
		};
		if (r === t && (r = i.ajaxSettings && i.ajaxSettings.traditional), i.isArray(n) || n.jquery && !i.isPlainObject(n)) i.each(n,
		function() {
			e(this.name, this.value)
		});
		else for (f in n) ri(f, n[f], r, e);
		return u.join("&").replace(cf, "+")
	};
	var a, h, of = /#.*$/,
	ef = /^(.*?):[ \t]*([^\r\n]*)\r?$/mg,
	ff = /^(?:about|app|app\-storage|.+\-extension|file|res|widget):$/,
	sf = /^(?:GET|HEAD)$/,
	af = /^\/\//,
	ei = /\?/,
	yu = /<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi,
	bu = /([?&])_=[^&]*/,
	li = /^([\w\+\.\-]+:)(?:\/\/([^\/?#:]*)(?::(\d+)|)|)/,
	ai = i.fn.load,
	ti = {},
	ou = {},
	vu = ["*/"] + ["*"];
	try {
		h = fe.href
	} catch(wo) {
		h = r.createElement("a"),
		h.href = "",
		h = h.href
	}
	a = li.exec(h.toLowerCase()) || [],
	i.fn.load = function(n, r, u) {
		if (typeof n != "string" && ai) return ai.apply(this, arguments);
		if (!this.length) return this;
		var e, o, h, s = this,
		f = n.indexOf(" ");
		return f >= 0 && (e = n.slice(f, n.length), n = n.slice(0, f)),
		i.isFunction(r) ? (u = r, r = t) : r && typeof r == "object" && (o = "POST"),
		i.ajax({
			url: n,
			type: o,
			dataType: "html",
			data: r,
			complete: function(n, t) {
				u && s.each(u, h || [n.responseText, t, n])
			}
		}).done(function(n) {
			h = arguments,
			s.html(e ? i("<div>").append(n.replace(yu, "")).find(e) : n)
		}),
		this
	},
	i.each("ajaxStart ajaxStop ajaxComplete ajaxError ajaxSuccess ajaxSend".split(" "),
	function(n, t) {
		i.fn[t] = function(n) {
			return this.on(t, n)
		}
	}),
	i.each(["get", "post"],
	function(n, r) {
		i[r] = function(n, u, f, e) {
			return i.isFunction(u) && (e = e || f, f = u, u = t),
			i.ajax({
				type: r,
				url: n,
				data: u,
				success: f,
				dataType: e
			})
		}
	}),
	i.extend({
		getScript: function(n, r) {
			return i.get(n, t, r, "script")
		},
		getJSON: function(n, t, r) {
			return i.get(n, t, r, "json")
		},
		ajaxSetup: function(n, t) {
			return t ? gi(n, i.ajaxSettings) : (t = n, n = i.ajaxSettings),
			gi(n, t),
			n
		},
		ajaxSettings: {
			url: h,
			isLocal: ff.test(a[1]),
			global: !0,
			type: "GET",
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			processData: !0,
			async: !0,
			accepts: {
				xml: "application/xml, text/xml",
				html: "text/html",
				text: "text/plain",
				json: "application/json, text/javascript",
				"*": vu
			},
			contents: {
				xml: /xml/,
				html: /html/,
				json: /json/
			},
			responseFields: {
				xml: "responseXML",
				text: "responseText"
			},
			converters: {
				"* text": n.String,
				"text html": !0,
				"text json": i.parseJSON,
				"text xml": i.parseXML
			},
			flatOptions: {
				context: !0,
				url: !0
			}
		},
		ajaxPrefilter: di(ti),
		ajaxTransport: di(ou),
		ajax: function(n, r) {
			function p(n, r, h, c) {
				var y, d, w, g, p, a = r;
				e !== 2 && (e = 2, tt && clearTimeout(tt), l = t, k = c || "", f.readyState = n > 0 ? 4 : 0, h && (g = ro(u, f, h)), n >= 200 && n < 300 || n === 304 ? (u.ifModified && (p = f.getResponseHeader("Last-Modified"), p && (i.lastModified[o] = p), p = f.getResponseHeader("Etag"), p && (i.etag[o] = p)), n === 304 ? (a = "notmodified", y = !0) : (y = ge(u, g), a = y.state, d = y.data, w = y.error, y = !w)) : (w = a, (!a || n) && (a = "error", n < 0 && (n = 0))), f.status = n, f.statusText = (r || a) + "", y ? rt.resolveWith(s, [d, a, f]) : rt.rejectWith(s, [f, a, w]), f.statusCode(b), b = t, v && nt.trigger("ajax" + (y ? "Success": "Error"), [f, u, y ? d: w]), ft.fireWith(s, [f, a]), v && (nt.trigger("ajaxComplete", [f, u]), --i.active || i.event.trigger("ajaxStop")))
			}
			var g, it;
			typeof n == "object" && (r = n, n = t),
			r = r || {};
			var o, k, w, l, tt, y, v, h, u = i.ajaxSetup({},
			r),
			s = u.context || u,
			nt = s !== u && (s.nodeType || s instanceof i) ? i(s) : i.event,
			rt = i.Deferred(),
			ft = i.Callbacks("once memory"),
			b = u.statusCode || {},
			et = {},
			ot = {},
			e = 0,
			ut = "canceled",
			f = {
				readyState: 0,
				setRequestHeader: function(n, t) {
					if (!e) {
						var i = n.toLowerCase();
						n = ot[i] = ot[i] || n,
						et[n] = t
					}
					return this
				},
				getAllResponseHeaders: function() {
					return e === 2 ? k: null
				},
				getResponseHeader: function(n) {
					var i;
					if (e === 2) {
						if (!w) for (w = {}; i = ef.exec(k);) w[i[1].toLowerCase()] = i[2];
						i = w[n.toLowerCase()]
					}
					return i === t ? null: i
				},
				overrideMimeType: function(n) {
					return e || (u.mimeType = n),
					this
				},
				abort: function(n) {
					return n = n || ut,
					l && l.abort(n),
					p(0, n),
					this
				}
			};
			if (rt.promise(f), f.success = f.done, f.error = f.fail, f.complete = ft.add, f.statusCode = function(n) {
				if (n) {
					var t;
					if (e < 2) for (t in n) b[t] = [b[t], n[t]];
					else t = n[f.status],
					f.always(t)
				}
				return this
			},
			u.url = ((n || u.url) + "").replace(of, "").replace(af, a[1] + "//"), u.dataTypes = i.trim(u.dataType || "*").toLowerCase().split(c), u.crossDomain == null && (y = li.exec(u.url.toLowerCase()) || !1, u.crossDomain = y && y.join(":") + (y[3] ? "": y[1] === "http:" ? 80 : 443) !== a.join(":") + (a[3] ? "": a[1] === "http:" ? 80 : 443)), u.data && u.processData && typeof u.data != "string" && (u.data = i.param(u.data, u.traditional)), d(ti, u, r, f), e === 2) return f;
			v = u.global,
			u.type = u.type.toUpperCase(),
			u.hasContent = !sf.test(u.type),
			v && i.active++==0 && i.event.trigger("ajaxStart"),
			u.hasContent || (u.data && (u.url += (ei.test(u.url) ? "&": "?") + u.data, delete u.data), o = u.url, u.cache === !1 && (g = i.now(), it = u.url.replace(bu, "$1_=" + g), u.url = it + (it === u.url ? (ei.test(u.url) ? "&": "?") + "_=" + g: ""))),
			(u.data && u.hasContent && u.contentType !== !1 || r.contentType) && f.setRequestHeader("Content-Type", u.contentType),
			u.ifModified && (o = o || u.url, i.lastModified[o] && f.setRequestHeader("If-Modified-Since", i.lastModified[o]), i.etag[o] && f.setRequestHeader("If-None-Match", i.etag[o])),
			f.setRequestHeader("Accept", u.dataTypes[0] && u.accepts[u.dataTypes[0]] ? u.accepts[u.dataTypes[0]] + (u.dataTypes[0] !== "*" ? ", " + vu + "; q=0.01": "") : u.accepts["*"]);
			for (h in u.headers) f.setRequestHeader(h, u.headers[h]);
			if (!u.beforeSend || u.beforeSend.call(s, f, u) !== !1 && e !== 2) {
				ut = "abort";
				for (h in {
					success: 1,
					error: 1,
					complete: 1
				}) f[h](u[h]);
				if (l = d(ou, u, r, f), l) {
					f.readyState = 1,
					v && nt.trigger("ajaxSend", [f, u]),
					u.async && u.timeout > 0 && (tt = setTimeout(function() {
						f.abort("timeout")
					},
					u.timeout));
					try {
						e = 1,
						l.send(et, p)
					} catch(st) {
						if (e < 2) p( - 1, st);
						else throw st;
					}
				} else p( - 1, "No Transport");
				return f
			}
			return f.abort()
		},
		active: 0,
		lastModified: {},
		etag: {}
	});
	var pr = [],
	tf = /\?/,
	ut = /(=)\?(?=&|$)|\?\?/,
	rf = i.now();
	i.ajaxSetup({
		jsonp: "callback",
		jsonpCallback: function() {
			var n = pr.pop() || i.expando + "_" + rf++;
			return this[n] = !0,
			n
		}
	}),
	i.ajaxPrefilter("json jsonp",
	function(r, u, f) {
		var e, s, o, l = r.data,
		a = r.url,
		h = r.jsonp !== !1,
		c = h && ut.test(a),
		v = h && !c && typeof l == "string" && !(r.contentType || "").indexOf("application/x-www-form-urlencoded") && ut.test(l);
		if (r.dataTypes[0] === "jsonp" || c || v) return e = r.jsonpCallback = i.isFunction(r.jsonpCallback) ? r.jsonpCallback() : r.jsonpCallback,
		s = n[e],
		c ? r.url = a.replace(ut, "$1" + e) : v ? r.data = l.replace(ut, "$1" + e) : h && (r.url += (tf.test(a) ? "&": "?") + r.jsonp + "=" + e),
		r.converters["script json"] = function() {
			return o || i.error(e + " was not called"),
			o[0]
		},
		r.dataTypes[0] = "json",
		n[e] = function() {
			o = arguments
		},
		f.always(function() {
			n[e] = s,
			r[e] && (r.jsonpCallback = u.jsonpCallback, pr.push(e)),
			o && i.isFunction(s) && s(o[0]),
			o = s = t
		}),
		"script"
	}),
	i.ajaxSetup({
		accepts: {
			script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
		},
		contents: {
			script: /javascript|ecmascript/
		},
		converters: {
			"text script": function(n) {
				return i.globalEval(n),
				n
			}
		}
	}),
	i.ajaxPrefilter("script",
	function(n) {
		n.cache === t && (n.cache = !1),
		n.crossDomain && (n.type = "GET", n.global = !1)
	}),
	i.ajaxTransport("script",
	function(n) {
		if (n.crossDomain) {
			var i, u = r.head || r.getElementsByTagName("head")[0] || r.documentElement;
			return {
				send: function(f, e) {
					i = r.createElement("script"),
					i.async = "async",
					n.scriptCharset && (i.charset = n.scriptCharset),
					i.src = n.url,
					i.onload = i.onreadystatechange = function(n, r) { (r || !i.readyState || /loaded|complete/.test(i.readyState)) && (i.onload = i.onreadystatechange = null, u && i.parentNode && u.removeChild(i), i = t, r || e(200, "success"))
					},
					u.insertBefore(i, u.firstChild)
				},
				abort: function() {
					i && i.onload(0, 1)
				}
			}
		}
	}),
	ht = n.ActiveXObject ?
	function() {
		for (var n in y) y[n](0, 1)
	}: !1,
	vr = 0,
	i.ajaxSettings.xhr = n.ActiveXObject ?
	function() {
		return ! this.isLocal && ki() || pe()
	}: ki,
	function(n) {
		i.extend(i.support, {
			ajax: !!n,
			cors: !!n && "withCredentials" in n
		})
	} (i.ajaxSettings.xhr()),
	i.support.ajax && i.ajaxTransport(function(r) {
		if (!r.crossDomain || i.support.cors) {
			var u;
			return {
				send: function(f, e) {
					var h, s, o = r.xhr();
					if (r.username ? o.open(r.type, r.url, r.async, r.username, r.password) : o.open(r.type, r.url, r.async), r.xhrFields) for (s in r.xhrFields) o[s] = r.xhrFields[s];
					r.mimeType && o.overrideMimeType && o.overrideMimeType(r.mimeType),
					!r.crossDomain && !f["X-Requested-With"] && (f["X-Requested-With"] = "XMLHttpRequest");
					try {
						for (s in f) o.setRequestHeader(s, f[s])
					} catch(c) {}
					o.send(r.hasContent && r.data || null),
					u = function(n, f) {
						var c, a, v, s, l;
						try {
							if (u && (f || o.readyState === 4)) if (u = t, h && (o.onreadystatechange = i.noop, ht && delete y[h]), f) o.readyState !== 4 && o.abort();
							else {
								c = o.status,
								v = o.getAllResponseHeaders(),
								s = {},
								l = o.responseXML,
								l && l.documentElement && (s.xml = l);
								try {
									s.text = o.responseText
								} catch(n) {}
								try {
									a = o.statusText
								} catch(w) {
									a = ""
								} ! c && r.isLocal && !r.crossDomain ? c = s.text ? 200 : 404 : c === 1223 && (c = 204)
							}
						} catch(p) {
							f || e( - 1, p)
						}
						s && e(c, a, s, v)
					},
					r.async ? o.readyState === 4 ? setTimeout(u, 0) : (h = ++vr, ht && (y || (y = {},
					i(n).unload(ht)), y[h] = u), o.onreadystatechange = u) : u()
				},
				abort: function() {
					u && u(0, 1)
				}
			}
		}
	});
	var st, ot, wu = /^(?:toggle|show|hide)$/,
	pu = new RegExp("^(?:([-+])=|)(" + tt + ")([a-z%]*)$", "i"),
	du = /queueHooks$/,
	g = [ee],
	b = {
		"*": [function(n, t) {
			var s, o, r = this.createTween(n, t),
			e = pu.exec(t),
			h = r.cur(),
			u = +h || 0,
			f = 1,
			c = 20;
			if (e) {
				if (s = +e[2], o = e[3] || (i.cssNumber[n] ? "": "px"), o !== "px" && u) {
					u = i.css(r.elem, n, !0) || s || 1;
					do f = f || ".5",
					u = u / f,
					i.style(r.elem, n, u + o);
					while (f !== (f = r.cur() / h) && f !== 1 && --c)
				}
				r.unit = o,
				r.start = u,
				r.end = e[1] ? u + (e[1] + 1) * s: s
			}
			return r
		}]
	};
	i.Animation = i.extend(au, {
		tweener: function(n, t) {
			i.isFunction(n) ? (t = n, n = ["*"]) : n = n.split(" ");
			for (var r, u = 0,
			f = n.length; u < f; u++) r = n[u],
			b[r] = b[r] || [],
			b[r].unshift(t)
		},
		prefilter: function(n, t) {
			t ? g.unshift(n) : g.push(n)
		}
	}),
	i.Tween = f,
	f.prototype = {
		constructor: f,
		init: function(n, t, r, u, f, e) {
			this.elem = n,
			this.prop = r,
			this.easing = f || "swing",
			this.options = t,
			this.start = this.now = this.cur(),
			this.end = u,
			this.unit = e || (i.cssNumber[r] ? "": "px")
		},
		cur: function() {
			var n = f.propHooks[this.prop];
			return n && n.get ? n.get(this) : f.propHooks._default.get(this)
		},
		run: function(n) {
			var r, t = f.propHooks[this.prop];
			return this.pos = this.options.duration ? r = i.easing[this.easing](n, this.options.duration * n, 0, 1, this.options.duration) : r = n,
			this.now = (this.end - this.start) * r + this.start,
			this.options.step && this.options.step.call(this.elem, this.now, this),
			t && t.set ? t.set(this) : f.propHooks._default.set(this),
			this
		}
	},
	f.prototype.init.prototype = f.prototype,
	f.propHooks = {
		_default: {
			get: function(n) {
				var t;
				return n.elem[n.prop] == null || !!n.elem.style && n.elem.style[n.prop] != null ? (t = i.css(n.elem, n.prop, !1, ""), !t || t === "auto" ? 0 : t) : n.elem[n.prop]
			},
			set: function(n) {
				i.fx.step[n.prop] ? i.fx.step[n.prop](n) : n.elem.style && (n.elem.style[i.cssProps[n.prop]] != null || i.cssHooks[n.prop]) ? i.style(n.elem, n.prop, n.now + n.unit) : n.elem[n.prop] = n.now
			}
		}
	},
	f.propHooks.scrollTop = f.propHooks.scrollLeft = {
		set: function(n) {
			n.elem.nodeType && n.elem.parentNode && (n.elem[n.prop] = n.now)
		}
	},
	i.each(["toggle", "show", "hide"],
	function(n, t) {
		var r = i.fn[t];
		i.fn[t] = function(u, f, e) {
			return u == null || typeof u == "boolean" || !n && i.isFunction(u) && i.isFunction(f) ? r.apply(this, arguments) : this.animate(nt(t, !0), u, f, e)
		}
	}),
	i.fn.extend({
		fadeTo: function(n, t, i, r) {
			return this.filter(et).css("opacity", 0).show().end().animate({
				opacity: t
			},
			n, i, r)
		},
		animate: function(n, t, r, u) {
			var o = i.isEmptyObject(n),
			f = i.speed(t, r, u),
			e = function() {
				var t = au(this, i.extend({},
				n), f);
				o && t.stop(!0)
			};
			return o || f.queue === !1 ? this.each(e) : this.queue(f.queue, e)
		},
		stop: function(n, r, u) {
			var f = function(n) {
				var t = n.stop;
				delete n.stop,
				t(u)
			};
			return typeof n != "string" && (u = r, r = n, n = t),
			r && n !== !1 && this.queue(n || "fx", []),
			this.each(function() {
				var o = !0,
				t = n != null && n + "queueHooks",
				e = i.timers,
				r = i._data(this);
				if (t) r[t] && r[t].stop && f(r[t]);
				else for (t in r) r[t] && r[t].stop && du.test(t) && f(r[t]);
				for (t = e.length; t--;) e[t].elem === this && (n == null || e[t].queue === n) && (e[t].anim.stop(u), o = !1, e.splice(t, 1)); (o || !u) && i.dequeue(this, n)
			})
		}
	}),
	i.each({
		slideDown: nt("show"),
		slideUp: nt("hide"),
		slideToggle: nt("toggle"),
		fadeIn: {
			opacity: "show"
		},
		fadeOut: {
			opacity: "hide"
		},
		fadeToggle: {
			opacity: "toggle"
		}
	},
	function(n, t) {
		i.fn[n] = function(n, i, r) {
			return this.animate(t, n, i, r)
		}
	}),
	i.speed = function(n, t, r) {
		var u = n && typeof n == "object" ? i.extend({},
		n) : {
			complete: r || !r && t || i.isFunction(n) && n,
			duration: n,
			easing: r && t || t && !i.isFunction(t) && t
		};
		return u.duration = i.fx.off ? 0 : typeof u.duration == "number" ? u.duration: u.duration in i.fx.speeds ? i.fx.speeds[u.duration] : i.fx.speeds._default,
		(u.queue == null || u.queue === !0) && (u.queue = "fx"),
		u.old = u.complete,
		u.complete = function() {
			i.isFunction(u.old) && u.old.call(this),
			u.queue && i.dequeue(this, u.queue)
		},
		u
	},
	i.easing = {
		linear: function(n) {
			return n
		},
		swing: function(n) {
			return.5 - Math.cos(n * Math.PI) / 2
		}
	},
	i.timers = [],
	i.fx = f.prototype.init,
	i.fx.tick = function() {
		for (var r, t = i.timers,
		n = 0; n < t.length; n++) r = t[n],
		!r() && t[n] === r && t.splice(n--, 1);
		t.length || i.fx.stop()
	},
	i.fx.timer = function(n) {
		n() && i.timers.push(n) && !ot && (ot = setInterval(i.fx.tick, i.fx.interval))
	},
	i.fx.interval = 13,
	i.fx.stop = function() {
		clearInterval(ot),
		ot = null
	},
	i.fx.speeds = {
		slow: 600,
		fast: 200,
		_default: 400
	},
	i.fx.step = {},
	i.expr && i.expr.filters && (i.expr.filters.animated = function(n) {
		return i.grep(i.timers,
		function(t) {
			return n === t.elem
		}).length
	}),
	wt = /^(?:body|html)$/i,
	i.fn.offset = function(n) {
		if (arguments.length) return n === t ? this: this.each(function(t) {
			i.offset.setOffset(this, n, t)
		});
		var u, s, o, c, h, l, a, e = {
			top: 0,
			left: 0
		},
		r = this[0],
		f = r && r.ownerDocument;
		if (f) return (s = f.body) === r ? i.offset.bodyOffset(r) : (u = f.documentElement, i.contains(u, r) ? (typeof r.getBoundingClientRect != "undefined" && (e = r.getBoundingClientRect()), o = tu(f), c = u.clientTop || s.clientTop || 0, h = u.clientLeft || s.clientLeft || 0, l = o.pageYOffset || u.scrollTop, a = o.pageXOffset || u.scrollLeft, {
			top: e.top + l - c,
			left: e.left + a - h
		}) : e)
	},
	i.offset = {
		bodyOffset: function(n) {
			var r = n.offsetTop,
			t = n.offsetLeft;
			return i.support.doesNotIncludeMarginInBodyOffset && (r += parseFloat(i.css(n, "marginTop")) || 0, t += parseFloat(i.css(n, "marginLeft")) || 0),
			{
				top: r,
				left: t
			}
		},
		setOffset: function(n, t, r) {
			var s = i.css(n, "position");
			s === "static" && (n.style.position = "relative");
			var h = i(n),
			c = h.offset(),
			l = i.css(n, "top"),
			a = i.css(n, "left"),
			v = (s === "absolute" || s === "fixed") && i.inArray("auto", [l, a]) > -1,
			u = {},
			e = {},
			f,
			o;
			v ? (e = h.position(), f = e.top, o = e.left) : (f = parseFloat(l) || 0, o = parseFloat(a) || 0),
			i.isFunction(t) && (t = t.call(n, r, c)),
			t.top != null && (u.top = t.top - c.top + f),
			t.left != null && (u.left = t.left - c.left + o),
			"using" in t ? t.using.call(n, u) : h.css(u)
		}
	},
	i.fn.extend({
		position: function() {
			if (this[0]) {
				var u = this[0],
				r = this.offsetParent(),
				n = this.offset(),
				t = wt.test(r[0].nodeName) ? {
					top: 0,
					left: 0
				}: r.offset();
				return n.top -= parseFloat(i.css(u, "marginTop")) || 0,
				n.left -= parseFloat(i.css(u, "marginLeft")) || 0,
				t.top += parseFloat(i.css(r[0], "borderTopWidth")) || 0,
				t.left += parseFloat(i.css(r[0], "borderLeftWidth")) || 0,
				{
					top: n.top - t.top,
					left: n.left - t.left
				}
			}
		},
		offsetParent: function() {
			return this.map(function() {
				for (var n = this.offsetParent || r.body; n && !wt.test(n.nodeName) && i.css(n, "position") === "static";) n = n.offsetParent;
				return n || r.body
			})
		}
	}),
	i.each({
		scrollLeft: "pageXOffset",
		scrollTop: "pageYOffset"
	},
	function(n, r) {
		var u = /Y/.test(r);
		i.fn[n] = function(f) {
			return i.access(this,
			function(n, f, e) {
				var o = tu(n);
				if (e === t) return o ? r in o ? o[r] : o.document.documentElement[f] : n[f];
				o ? o.scrollTo(u ? i(o).scrollLeft() : e, u ? e: i(o).scrollTop()) : n[f] = e
			},
			n, f, arguments.length, null)
		}
	}),
	i.each({
		Height: "height",
		Width: "width"
	},
	function(n, r) {
		i.each({
			padding: "inner" + n,
			content: r,
			"": "outer" + n
		},
		function(u, f) {
			i.fn[f] = function(f, e) {
				var s = arguments.length && (u || typeof f != "boolean"),
				o = u || (f === !0 || e === !0 ? "margin": "border");
				return i.access(this,
				function(r, u, f) {
					var e;
					return i.isWindow(r) ? r.document.documentElement["client" + n] : r.nodeType === 9 ? (e = r.documentElement, Math.max(r.body["scroll" + n], e["scroll" + n], r.body["offset" + n], e["offset" + n], e["client" + n])) : f === t ? i.css(r, u, f, o) : i.style(r, u, f, o)
				},
				r, s ? f: t, s, null)
			}
		})
	}),
	n.jQuery = n.$ = i,
	typeof define == "function" && define.amd && define.amd.jQuery && define("jquery", [],
	function() {
		return i
	})
} (window),
function(n, t) {
	function r(t, r) {
		var e = t.nodeName.toLowerCase(),
		o,
		u,
		f;
		return "area" === e ? (o = t.parentNode, u = o.name, !t.href || !u || o.nodeName.toLowerCase() !== "map") ? !1 : (f = n("img[usemap=#" + u + "]")[0], !!f && i(f)) : (/input|select|textarea|button|object/.test(e) ? !t.disabled: "a" == e ? t.href || r: r) && i(t)
	}
	function i(t) {
		return ! n(t).parents().andSelf().filter(function() {
			return n.curCSS(this, "visibility") === "hidden" || n.expr.filters.hidden(this)
		}).length
	} (n.ui = n.ui || {},
	n.ui.version) || (n.extend(n.ui, {
		version: "1.8.24",
		keyCode: {
			ALT: 18,
			BACKSPACE: 8,
			CAPS_LOCK: 20,
			COMMA: 188,
			COMMAND: 91,
			COMMAND_LEFT: 91,
			COMMAND_RIGHT: 93,
			CONTROL: 17,
			DELETE: 46,
			DOWN: 40,
			END: 35,
			ENTER: 13,
			ESCAPE: 27,
			HOME: 36,
			INSERT: 45,
			LEFT: 37,
			MENU: 93,
			NUMPAD_ADD: 107,
			NUMPAD_DECIMAL: 110,
			NUMPAD_DIVIDE: 111,
			NUMPAD_ENTER: 108,
			NUMPAD_MULTIPLY: 106,
			NUMPAD_SUBTRACT: 109,
			PAGE_DOWN: 34,
			PAGE_UP: 33,
			PERIOD: 190,
			RIGHT: 39,
			SHIFT: 16,
			SPACE: 32,
			TAB: 9,
			UP: 38,
			WINDOWS: 91
		}
	}), n.fn.extend({
		propAttr: n.fn.prop || n.fn.attr,
		_focus: n.fn.focus,
		focus: function(t, i) {
			return typeof t == "number" ? this.each(function() {
				var r = this;
				setTimeout(function() {
					n(r).focus(),
					i && i.call(r)
				},
				t)
			}) : this._focus.apply(this, arguments)
		},
		scrollParent: function() {
			var t;
			return t = n.browser.msie && /(static|relative)/.test(this.css("position")) || /absolute/.test(this.css("position")) ? this.parents().filter(function() {
				return /(relative|absolute|fixed)/.test(n.curCSS(this, "position", 1)) && /(auto|scroll)/.test(n.curCSS(this, "overflow", 1) + n.curCSS(this, "overflow-y", 1) + n.curCSS(this, "overflow-x", 1))
			}).eq(0) : this.parents().filter(function() {
				return /(auto|scroll)/.test(n.curCSS(this, "overflow", 1) + n.curCSS(this, "overflow-y", 1) + n.curCSS(this, "overflow-x", 1))
			}).eq(0),
			/fixed/.test(this.css("position")) || !t.length ? n(document) : t
		},
		zIndex: function(i) {
			if (i !== t) return this.css("zIndex", i);
			if (this.length) for (var r = n(this[0]), f, u; r.length && r[0] !== document;) {
				if (f = r.css("position"), (f === "absolute" || f === "relative" || f === "fixed") && (u = parseInt(r.css("zIndex"), 10), !isNaN(u) && u !== 0)) return u;
				r = r.parent()
			}
			return 0
		},
		disableSelection: function() {
			return this.bind((n.support.selectstart ? "selectstart": "mousedown") + ".ui-disableSelection",
			function(n) {
				n.preventDefault()
			})
		},
		enableSelection: function() {
			return this.unbind(".ui-disableSelection")
		}
	}), n("<a>").outerWidth(1).jquery || n.each(["Width", "Height"],
	function(i, r) {
		function e(t, i, r, u) {
			return n.each(o,
			function() {
				i -= parseFloat(n.curCSS(t, "padding" + this, !0)) || 0,
				r && (i -= parseFloat(n.curCSS(t, "border" + this + "Width", !0)) || 0),
				u && (i -= parseFloat(n.curCSS(t, "margin" + this, !0)) || 0)
			}),
			i
		}
		var o = r === "Width" ? ["Left", "Right"] : ["Top", "Bottom"],
		f = r.toLowerCase(),
		u = {
			innerWidth: n.fn.innerWidth,
			innerHeight: n.fn.innerHeight,
			outerWidth: n.fn.outerWidth,
			outerHeight: n.fn.outerHeight
		};
		n.fn["inner" + r] = function(i) {
			return i === t ? u["inner" + r].call(this) : this.each(function() {
				n(this).css(f, e(this, i) + "px")
			})
		},
		n.fn["outer" + r] = function(t, i) {
			return typeof t != "number" ? u["outer" + r].call(this, t) : this.each(function() {
				n(this).css(f, e(this, t, !0, i) + "px")
			})
		}
	}), n.extend(n.expr[":"], {
		data: n.expr.createPseudo ? n.expr.createPseudo(function(t) {
			return function(i) {
				return !! n.data(i, t)
			}
		}) : function(t, i, r) {
			return !! n.data(t, r[3])
		},
		focusable: function(t) {
			return r(t, !isNaN(n.attr(t, "tabindex")))
		},
		tabbable: function(t) {
			var u = n.attr(t, "tabindex"),
			i = isNaN(u);
			return (i || u >= 0) && r(t, !i)
		}
	}), n(function() {
		var i = document.body,
		t = i.appendChild(t = document.createElement("div"));
		t.offsetHeight,
		n.extend(t.style, {
			minHeight: "100px",
			height: "auto",
			padding: 0,
			borderWidth: 0
		}),
		n.support.minHeight = t.offsetHeight === 100,
		n.support.selectstart = "onselectstart" in t,
		i.removeChild(t).style.display = "none"
	}), n.curCSS || (n.curCSS = n.css), n.extend(n.ui, {
		plugin: {
			add: function(t, i, r) {
				var f = n.ui[t].prototype,
				u;
				for (u in r) f.plugins[u] = f.plugins[u] || [],
				f.plugins[u].push([i, r[u]])
			},
			call: function(n, t, i) {
				var u = n.plugins[t],
				r;
				if (u && n.element[0].parentNode) for (r = 0; r < u.length; r++) n.options[u[r][0]] && u[r][1].apply(n.element, i)
			}
		},
		contains: function(n, t) {
			return document.compareDocumentPosition ? n.compareDocumentPosition(t) & 16 : n !== t && n.contains(t)
		},
		hasScroll: function(t, i) {
			if (n(t).css("overflow") === "hidden") return ! 1;
			var r = i && i === "left" ? "scrollLeft": "scrollTop",
			u = !1;
			return t[r] > 0 ? !0 : (t[r] = 1, u = t[r] > 0, t[r] = 0, u)
		},
		isOverAxis: function(n, t, i) {
			return n > t && n < t + i
		},
		isOver: function(t, i, r, u, f, e) {
			return n.ui.isOverAxis(t, r, f) && n.ui.isOverAxis(i, u, e)
		}
	}))
} (jQuery),
function(n, t) {
	var r, i;
	n.cleanData ? (r = n.cleanData, n.cleanData = function(t) {
		for (var u = 0,
		i; (i = t[u]) != null; u++) try {
			n(i).triggerHandler("remove")
		} catch(f) {}
		r(t)
	}) : (i = n.fn.remove, n.fn.remove = function(t, r) {
		return this.each(function() {
			return r || (!t || n.filter(t, [this]).length) && n("*", this).add([this]).each(function() {
				try {
					n(this).triggerHandler("remove")
				} catch(t) {}
			}),
			i.call(n(this), t, r)
		})
	}),
	n.widget = function(t, i, r) {
		var u = t.split(".")[0],
		e,
		f;
		t = t.split(".")[1],
		e = u + "-" + t,
		r || (r = i, i = n.Widget),
		n.expr[":"][e] = function(i) {
			return !! n.data(i, t)
		},
		n[u] = n[u] || {},
		n[u][t] = function(n, t) {
			arguments.length && this._createWidget(n, t)
		},
		f = new i,
		f.options = n.extend(!0, {},
		f.options),
		n[u][t].prototype = n.extend(!0, f, {
			namespace: u,
			widgetName: t,
			widgetEventPrefix: n[u][t].prototype.widgetEventPrefix || t,
			widgetBaseClass: e
		},
		r),
		n.widget.bridge(t, n[u][t])
	},
	n.widget.bridge = function(i, r) {
		n.fn[i] = function(u) {
			var o = typeof u == "string",
			e = Array.prototype.slice.call(arguments, 1),
			f = this;
			return (u = !o && e.length ? n.extend.apply(null, [!0, u].concat(e)) : u, o && u.charAt(0) === "_") ? f: (o ? this.each(function() {
				var r = n.data(this, i),
				o = r && n.isFunction(r[u]) ? r[u].apply(r, e) : r;
				if (o !== r && o !== t) return f = o,
				!1
			}) : this.each(function() {
				var t = n.data(this, i);
				t ? t.option(u || {})._init() : n.data(this, i, new r(u, this))
			}), f)
		}
	},
	n.Widget = function(n, t) {
		arguments.length && this._createWidget(n, t)
	},
	n.Widget.prototype = {
		widgetName: "widget",
		widgetEventPrefix: "",
		options: {
			disabled: !1
		},
		_createWidget: function(t, i) {
			n.data(i, this.widgetName, this),
			this.element = n(i),
			this.options = n.extend(!0, {},
			this.options, this._getCreateOptions(), t);
			var r = this;
			this.element.bind("remove." + this.widgetName,
			function() {
				r.destroy()
			}),
			this._create(),
			this._trigger("create"),
			this._init()
		},
		_getCreateOptions: function() {
			return n.metadata && n.metadata.get(this.element[0])[this.widgetName]
		},
		_create: function() {},
		_init: function() {},
		destroy: function() {
			this.element.unbind("." + this.widgetName).removeData(this.widgetName),
			this.widget().unbind("." + this.widgetName).removeAttr("aria-disabled").removeClass(this.widgetBaseClass + "-disabled ui-state-disabled")
		},
		widget: function() {
			return this.element
		},
		option: function(i, r) {
			var u = i;
			if (arguments.length === 0) return n.extend({},
			this.options);
			if (typeof i == "string") {
				if (r === t) return this.options[i];
				u = {},
				u[i] = r
			}
			return this._setOptions(u),
			this
		},
		_setOptions: function(t) {
			var i = this;
			return n.each(t,
			function(n, t) {
				i._setOption(n, t)
			}),
			this
		},
		_setOption: function(n, t) {
			return this.options[n] = t,
			n === "disabled" && this.widget()[t ? "addClass": "removeClass"](this.widgetBaseClass + "-disabled ui-state-disabled").attr("aria-disabled", t),
			this
		},
		enable: function() {
			return this._setOption("disabled", !1)
		},
		disable: function() {
			return this._setOption("disabled", !0)
		},
		_trigger: function(t, i, r) {
			var f, u, e = this.options[t];
			if (r = r || {},
			i = n.Event(i), i.type = (t === this.widgetEventPrefix ? t: this.widgetEventPrefix + t).toLowerCase(), i.target = this.element[0], u = i.originalEvent, u) for (f in u) f in i || (i[f] = u[f]);
			return this.element.trigger(i, r),
			!(n.isFunction(e) && e.call(this.element[0], i, r) === !1 || i.isDefaultPrevented())
		}
	}
} (jQuery),
function(n) {
	n.widget("ui.accordion", {
		options: {
			active: 1,
			animated: "slide",
			autoHeight: !0,
			clearStyle: !1,
			collapsible: !1,
			event: "click",
			fillSpace: !1,
			header: "> li > :first-child,> :not(li):even",
			icons: {
				header: "ui-icon-triangle-1-e",
				headerSelected: "ui-icon-triangle-1-s"
			},
			navigation: !1,
			navigationFilter: function() {
				return this.href.toLowerCase() === location.href.toLowerCase()
			}
		},
		_create: function() {
			var t = this,
			i = t.options,
			r, u;
			t.running = 0,
			t.element.addClass("ui-accordion ui-widget ui-helper-reset").children("li").addClass("ui-accordion-li-fix"),
			t.headers = t.element.find(i.header).addClass("ui-accordion-header ui-helper-reset ui-state-default ui-corner-all").bind("mouseenter.accordion",
			function() {
				i.disabled || n(this).addClass("ui-state-hover")
			}).bind("mouseleave.accordion",
			function() {
				i.disabled || n(this).removeClass("ui-state-hover")
			}).bind("focus.accordion",
			function() {
				i.disabled || n(this).addClass("ui-state-focus")
			}).bind("blur.accordion",
			function() {
				i.disabled || n(this).removeClass("ui-state-focus")
			}),
			t.headers.next().addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom"),
			i.navigation && (r = t.element.find("a").filter(i.navigationFilter).eq(0), r.length && (u = r.closest(".ui-accordion-header"), t.active = u.length ? u: r.closest(".ui-accordion-content").prev())),
			t.active = t._findActive(t.active || i.active).addClass("ui-state-default ui-state-active").toggleClass("ui-corner-all").toggleClass("ui-corner-top"),
			t.active.next().addClass("ui-accordion-content-active"),
			t._createIcons(),
			t.resize(),
			t.element.attr("role", "tablist"),
			t.headers.attr("role", "tab").bind("keydown.accordion",
			function(n) {
				return t._keydown(n)
			}).next().attr("role", "tabpanel"),
			t.headers.not(t.active || "").attr({
				"aria-expanded": "false",
				"aria-selected": "false",
				tabIndex: -1
			}).next().hide(),
			t.active.length ? t.active.attr({
				"aria-expanded": "true",
				"aria-selected": "true",
				tabIndex: 0
			}) : t.headers.eq(0).attr("tabIndex", 0),
			n.browser.safari || t.headers.find("a").attr("tabIndex", -1),
			i.event && t.headers.bind(i.event.split(" ").join(".accordion ") + ".accordion",
			function(n) {
				t._clickHandler.call(t, n, this),
				n.preventDefault()
			})
		},
		_createIcons: function() {
			var n = this.options;
			n.icons && (this.active.toggleClass(n.icons.header).toggleClass(n.icons.headerSelected), this.element.addClass("ui-accordion-icons"))
		},
		_destroyIcons: function() {
			this.headers.children(".ui-icon").remove(),
			this.element.removeClass("ui-accordion-icons")
		},
		destroy: function() {
			var i = this.options,
			t;
			return this.element.removeClass("ui-accordion ui-widget ui-helper-reset").removeAttr("role"),
			this.headers.unbind(".accordion").removeClass("ui-accordion-header ui-accordion-disabled ui-helper-reset ui-state-default ui-corner-all ui-state-active ui-state-disabled ui-corner-top").removeAttr("role").removeAttr("aria-expanded").removeAttr("aria-selected").removeAttr("tabIndex"),
			this.headers.find("a").removeAttr("tabIndex"),
			this._destroyIcons(),
			t = this.headers.next().css("display", "").removeAttr("role").removeClass("ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content ui-accordion-content-active ui-accordion-disabled ui-state-disabled"),
			(i.autoHeight || i.fillHeight) && t.css("height", ""),
			n.Widget.prototype.destroy.call(this)
		},
		_setOption: function(t, i) {
			n.Widget.prototype._setOption.apply(this, arguments),
			t == "active" && this.activate(i),
			t == "icons" && (this._destroyIcons(), i && this._createIcons()),
			t == "disabled" && this.headers.add(this.headers.next())[i ? "addClass": "removeClass"]("ui-accordion-disabled ui-state-disabled")
		},
		_keydown: function(t) {
			if (!this.options.disabled && !t.altKey && !t.ctrlKey) {
				var i = n.ui.keyCode,
				u = this.headers.length,
				f = this.headers.index(t.target),
				r = !1;
				switch (t.keyCode) {
				case i.RIGHT:
				case i.DOWN:
					r = this.headers[(f + 1) % u];
					break;
				case i.LEFT:
				case i.UP:
					r = this.headers[(f - 1 + u) % u];
					break;
				case i.SPACE:
				case i.ENTER:
					this._clickHandler({
						target:
						t.target
					},
					t.target),
					t.preventDefault()
				}
				return r ? (n(t.target).attr("tabIndex", -1), n(r).attr("tabIndex", 0), r.focus(), !1) : !0
			}
		},
		resize: function() {
			var r = this.options,
			t, i;
			return r.fillSpace ? (n.browser.msie && (i = this.element.parent().css("overflow"), this.element.parent().css("overflow", "hidden")), t = this.element.parent().height(), n.browser.msie && this.element.parent().css("overflow", i), this.headers.each(function() {
				t -= n(this).outerHeight(!0)
			}), this.headers.next().each(function() {
				n(this).height(Math.max(0, t - n(this).innerHeight() + n(this).height()))
			}).css("overflow", "auto")) : r.autoHeight && (t = 0, this.headers.next().each(function() {
				t = Math.max(t, n(this).height("").height())
			}).height(t)),
			this
		},
		activate: function(n) {
			this.options.active = n;
			var t = this._findActive(n)[0];
			return this._clickHandler({
				target: t
			},
			t),
			this
		},
		_findActive: function(t) {
			return t ? typeof t == "number" ? this.headers.filter(":eq(" + t + ")") : this.headers.not(this.headers.not(t)) : t === !1 ? n([]) : this.headers.filter(":eq(0)")
		},
		_clickHandler: function(t, i) {
			var r = this.options,
			u, f;
			if (!r.disabled) {
				if (!t.target) {
					if (!r.collapsible) return;
					this.active.removeClass("ui-state-active ui-corner-top").addClass("ui-state-default ui-corner-all").children(".ui-icon").removeClass(r.icons.headerSelected).addClass(r.icons.header),
					this.active.next().addClass("ui-accordion-content-active");
					var e = this.active.next(),
					h = {
						options: r,
						newHeader: n([]),
						oldHeader: r.active,
						newContent: n([]),
						oldContent: e
					},
					o = this.active = n([]);
					this._toggle(o, e, h);
					return
				}
				if (u = n(t.currentTarget || i), f = u[0] === this.active[0], r.active = r.collapsible && f ? !1 : this.headers.index(u), !this.running && (r.collapsible || !f)) {
					var s = this.active,
					o = u.next(),
					e = this.active.next(),
					h = {
						options: r,
						newHeader: f && r.collapsible ? n([]) : u,
						oldHeader: this.active,
						newContent: f && r.collapsible ? n([]) : o,
						oldContent: e
					},
					c = this.headers.index(this.active[0]) > this.headers.index(u[0]);
					this.active = f ? n([]) : u,
					this._toggle(o, e, h, f, c),
					s.removeClass("ui-state-active ui-corner-top").addClass("ui-state-default ui-corner-all").children(".ui-icon").removeClass(r.icons.headerSelected).addClass(r.icons.header),
					r.deepLinking && s.children().children().children(".ui-icon").removeClass(r.icons.headerSelected).addClass(r.icons.header),
					f || (u.removeClass("ui-state-default ui-corner-all").addClass("ui-state-active ui-corner-top").children(".ui-icon").removeClass(r.icons.header).addClass(r.icons.headerSelected), r.deepLinking && u.children().children().children(".ui-icon").removeClass(r.icons.header).addClass(r.icons.headerSelected), u.next().addClass("ui-accordion-content-active"));
					return
				}
			}
		},
		_toggle: function(t, i, r, u, f) {
			var o = this,
			e = o.options,
			c, h;
			if (o.toShow = t, o.toHide = i, o.data = r, c = function() {
				if (o) return o._completed.apply(o, arguments)
			},
			o._trigger("changestart", null, o.data), o.running = i.size() === 0 ? t.size() : i.size(), e.animated) {
				h = {},
				h = e.collapsible && u ? {
					toShow: n([]),
					toHide: i,
					complete: c,
					down: f,
					autoHeight: e.autoHeight || e.fillSpace
				}: {
					toShow: t,
					toHide: i,
					complete: c,
					down: f,
					autoHeight: e.autoHeight || e.fillSpace
				},
				e.proxied || (e.proxied = e.animated),
				e.proxiedDuration || (e.proxiedDuration = e.duration),
				e.animated = n.isFunction(e.proxied) ? e.proxied(h) : e.proxied,
				e.duration = n.isFunction(e.proxiedDuration) ? e.proxiedDuration(h) : e.proxiedDuration;
				var l = n.ui.accordion.animations,
				a = e.duration,
				s = e.animated; ! s || l[s] || n.easing[s] || (s = "slide"),
				l[s] || (l[s] = function(n) {
					this.slide(n, {
						easing: s,
						duration: a || 700
					})
				}),
				l[s](h)
			} else e.collapsible && u ? t.toggle() : (i.hide(), t.show()),
			c(!0);
			i.prev().attr({
				"aria-expanded": "false",
				"aria-selected": "false",
				tabIndex: -1
			}).blur(),
			t.prev().attr({
				"aria-expanded": "true",
				"aria-selected": "true",
				tabIndex: 0
			}).focus()
		},
		_completed: function(n) { (this.running = n ? 0 : --this.running, this.running) || (this.options.clearStyle && this.toShow.add(this.toHide).css({
				height: "",
				overflow: ""
			}), this.toHide.removeClass("ui-accordion-content-active"), this.toHide.length && (this.toHide.parent()[0].className = this.toHide.parent()[0].className), this._trigger("change", null, this.data))
		}
	}),
	n.extend(n.ui.accordion, {
		version: "1.8.24",
		animations: {
			slide: function(t, i) {
				if (t = n.extend({
					easing: "swing",
					duration: 300
				},
				t, i), !t.toHide.size()) {
					t.toShow.animate({
						height: "show",
						paddingTop: "show",
						paddingBottom: "show"
					},
					t);
					return
				}
				if (!t.toShow.size()) {
					t.toHide.animate({
						height: "hide",
						paddingTop: "hide",
						paddingBottom: "hide"
					},
					t);
					return
				}
				var s = t.toShow.css("overflow"),
				e = 0,
				u = {},
				o = {},
				h = ["height", "paddingTop", "paddingBottom"],
				f,
				r = t.toShow;
				f = r[0].style.width,
				r.width(r.parent().width() - parseFloat(r.css("paddingLeft")) - parseFloat(r.css("paddingRight")) - (parseFloat(r.css("borderLeftWidth")) || 0) - (parseFloat(r.css("borderRightWidth")) || 0)),
				n.each(h,
				function(i, r) {
					o[r] = "hide";
					var f = ("" + n.css(t.toShow[0], r)).match(/^([\d+-.]+)(.*)$/);
					u[r] = {
						value: f[1],
						unit: f[2] || "px"
					}
				}),
				t.toShow.css({
					height: 0,
					overflow: "hidden"
				}).show(),
				t.toHide.filter(":hidden").each(t.complete).end().filter(":visible").animate(o, {
					step: function(n, i) {
						i.prop == "height" && (e = i.end - i.start == 0 ? 0 : (i.now - i.start) / (i.end - i.start)),
						t.toShow[0].style[i.prop] = e * u[i.prop].value + u[i.prop].unit
					},
					duration: t.duration,
					easing: t.easing,
					complete: function() {
						t.autoHeight || t.toShow.css("height", ""),
						t.toShow.css({
							width: f,
							overflow: s
						}),
						t.complete()
					}
				})
			},
			bounceslide: function(n) {
				this.slide(n, {
					easing: n.down ? "easeOutBounce": "swing",
					duration: n.down ? 1e3: 200
				})
			}
		}
	})
} (jQuery)