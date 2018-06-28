define(["jquery", "app/common/lottery"],
    function (t, e) {
        var i, n = "button-current",
            s = "table-current";
        return i = e.extend({
            initialize: function (e) {
                var n = this,
                    s = _.extend({
                            hln: !0,
                            lotteryId: 2
                        },
                        e);
                i.superclass.initialize.call(this, s),
                    this.isOpen = !0,
                    this._np = 0,
                    8 == n.lotteryId || 11 == n.lotteryId ? this.refreshTimer = new this.CountDown(10) : this.refreshTimer = new this.CountDown(this.refreshDuration),
                    this.cache = {
                        lz: null,
                        ranking: null
                    },
                    t(function () {
                        n.setLiveUrl(s.lotteryId),
                            n.ballTpl = t("#tpl-prev-balls").html(),
                            n.resultDataTpl = t("#tpl-prev-data").html(),
                            n.$selectedCount = t("#j-selected-count"),
                            n._events()
                    })
            },
            close: function () {
                i.superclass.close.call(this),
                    this.$play.find(".input").val(""),
                    this._setSelectedCount(0),
                this.isLianMa && (this.$ctn.find(":checked").prop("checked", !1), this._LianMaConfig && this._LianMaConfig.balls && (this._LianMaConfig.balls.length = 0))
            },
            open: function (t) {
                if (this.isLianMa) {
                    if (t) {
                        var e = this.$play.find(":checkbox");
                        e.length == e.filter(":disabled").length ? i.superclass.open.call(this) : this.$play.find("input:not(:checkbox),button").prop("disabled", !1)
                    } else {
                        i.superclass.open.call(this)
                    }
                } else {
                    i.superclass.open.call(this)
                }
                !t && this.refresh()
            },
            getCategory: function (t) {
                var e = t.closest(".j-betting");
                return this.$ctn.find(".h-category").val() || e.find("th").eq(0).text() || e.closest("tr").prevAll(".thead").eq(0).find("th").text()
            },
            reset: function () {
                i.superclass.reset.call(this),
                    this._setSelectedCount(0),
                    this.$ctn.find("." + s).removeClass(s),
                    this.$ctn.find(".input").val(""),
                this.isLianMa && (t("#j-normal-form").show(), this._resetLianMa())
            },
            getData: function () {
                var e, i = this;
                return this.isLianMa ? ("0" === this._LianMaConfig.lines && (this._LianMaConfig.lines = t(".j-current-odds").find("span").text()), void i.$doc.find(".lm-total").text(0)) : (e = this.isQuickMode ? this.$ctn.find(".j-betting tr." + s) : this.$ctn.find(".j-betting .fb"), this.records = e.map(function (e, n) {
                    var s, a, r = t(this);
                    if (i.isQuickMode ? a = i.amount : (r = t(this).closest("tr"), a = parseInt(t.trim(r.find("input").val()), 10)), i.isQuickMode || a) {
                        return s = i.getCategory(r),
                        a > 0 && (a = a.toFixed(2)),
                            {
                                category: s,
                                id: parseInt(r.attr("data-id"), 10),
                                name: r.find(".table-odd").text(),
                                odds: r.attr("data-odds"),
                                amount: a
                            }
                    }
                }).get(), this.isQuickMode && i._setSelectedCount(), void this.getPostData())
            },
            afterBet: function () {
                this.reset(),
                this.isLianMa && this._resetLianMa(),
                    this.refresh()
            },
            afterGetBet: function (t) {
                if (this.isLianMa) {
                    var e = this.$play.find(":radio");
                    e.filter(":checked").length || e.eq(0).prop("checked", !0).trigger("change")
                }
            },
            beforeConfirm: function () {
                var t = this;
                return !(this.isLianMa && !t.amount) || (t.ui.msg(t.lang.msg.emptyAmount), !1)
            },
            valid: function () {
                var t = this;
                if (this.isLianMa) {
                    var e = this._LianMaConfig;
                    return e.id ? !(e.balls.length < e.min) || (t.ui.msg(t.utils.format(t.lang.msg.minNumbers, e.min)), !1) : (t.ui.msg(t.lang.msg.empty), !1)
                }
                return i.superclass.valid.call(t)
            },
            afterRefresh: function (t) {
                var e = this;
                this._updateRanking(t.ChangLong),
                    this._updateSummary(t),
                    this._updateLuZhu(),
                    this._updateHitBalls(t.ZongchuYilou),
                    this._renderBall(t),
                this.isOpen && this._updateLines(t.Lines),
                    this.refreshTimer.update = function (t) {
                    },
                    this.refreshTimer.done = function () {
                        e.refresh()
                    },
                    e.refreshTimer.restart()
            },
            getRecordsHtml: function () {
                var e, n, s, a = this;
                return this.isLianMa ? (s = t("#j-lm-tpl").html(), e = a._LianMaConfig, e.group = a.utils.combination(e.balls, e.min).length, e.total = 0, e.money = 0, n = a._.template(s)(e), 0 == e.total && t(n).find(".lm-total").text(0), n) : i.superclass.getRecordsHtml.call(this)
            },
            beforeBet: function (t) {
                var e, i = this;
                this.isLianMa && (e = i._LianMaConfig, i.data = [{
                    BetContext: e.balls.join(","),
                    Money: i.amount,
                    Lines: e.lines,
                    Id: e.id,
                    BetType: 5
                }])
            },
            setLiveUrl: function (e) {
                var i = t(".j-live"),
                    j = i.parent().data("id"),
                    n = t(".j-count"),
                    s = "http://www.1392c.com/" + (typeof j == "undefined" ? e : j) + "/";
                i.attr("href", s + "shipin/"),
                    n.attr("href", s)
            },
            _setSelectedCount: function (t) {
                void 0 == t && (t = this.records.length),
                    this.$selectedCount.find(".j-selected-count").text(t)
            },
            _afterTabChange: function (t) {
                this._luzCurrentTab = 0
            },
            _tabs: function () {
                var e = this,
                    i = t("#play-tab");
                i.on("click", "li",
                    function (i) {
                        i.preventDefault();
                        var n = t(this),
                            s = t(n.data("target"));
                        if (e.isLianMa = "lm" === n.data("type"), e.disabledHits = "yes" === n.data("hits"), e.disabledTrends = "yes" === n.data("trends"), s.length) {
                            e.$ctn = s;
                            var a = e.isQuickMode ? 0 : 1;
                            e.$doc.find(".button-secondary-group button").eq(a).trigger("click"),
                                n.addClass("active").siblings("li").removeClass("active"),
                                e.NumberPostion = n.data("np"),
                                e._np = n.index(),
                                s.show().siblings().hide(),
                                e._afterTabChange.call(e, n),
                                e.refresh(),
                            e.isLianMa && e._LianMa()
                        }
                    }),
                    i.find("li").eq(e._np).trigger("click")
            },
            _events: function () {
                var e = this;
                this.$doc.on("click", ".button-secondary-group button",
                    function (i) {
                        i.preventDefault();
                        var s = t(this),
                            a = t(this).data("mode");
                        s.addClass(n).siblings().removeClass(n),
                            e.reset(),
                        a && (e.setQuickMode("quick" === a), e._toggleElements())
                    }),
                    this._tabs()
            },
            _toggleElements: function () {
                var t = this.$ctn.find(".j-odds"),
                    e = this.$doc.find(".quick-form"),
                    i = this.$doc.find(".normal-form"),
                    n = "is-quick-mode",
                    s = "is-normal-mode";
                this.isQuickMode ? (e.show(), i.hide(), t.hide(), this.$selectedCount.show(), this.$play.removeClass(s).addClass(n)) : (e.hide(), t.show(), i.show(), this.$play.removeClass(n).addClass(s), this.$selectedCount.hide())
            },
            _updateLines: function (e) {
                var i = this;
                this._updateOtherLines(e,i);
                return this.isLianMa ? void t('label[for^="j"]').each(function () {
                    var n = t(this),
                        s = n.attr("for"),
                        a = e[s],
                        r = i.$ctn.find("#" + s);
                    a ? (r.prop("disabled", !1), t(this).find("span").text(a)) : r.prop("disabled", !0)
                }) : void this.$play.find("li[data-id]").each(function () {
                    var i = t(this),
                        n = "j" + i.attr("data-id"),
                        s = e[n];
                    s = s > 0 ? s : 0,
                        i.attr({
                            "data-odds": s
                        }).find(".ball_aid").text('赔率' + s),
                        i.find('.ball_number').attr({peilv: s})
                })
            },
            _updateOtherLines: function (e,i) {
                switch (i._np){
                    case 0:
                        this.$play.find('.choice_cound').css({'display':'none'});
                        this.$play.find(".play_select_prompt span").text('投注说明：至少选择1个和值投注，选号与开奖的三个号码相加的数值一致即中奖。奖金1.90-180倍');
                    break;
                    case 1:
                        this.$play.find('.choice_cound').css({'display':'none'});
                        this.$play.find(".play_select_prompt span").text('10元购买6个三同号(111,222,333,444,555,666)投注，选号与开奖号码一致即中奖' + e['j501'] + '倍。');
                    break;
                    case 2:
                        this.$play.find('.choice_cound').css({'display':'block'});
                        this.$play.find(".play_select_prompt span").text('至少选择1个三同号投注，选号与开奖号码一致即中奖' + e['j502'] + '倍。');
                        break;
                    case 3:
                        this.$play.find('.choice_cound').css({'display':'block'});
                        this.$play.find(".play_select_prompt span").text('至少选择3个号码投注，选号与开奖号码一致即中奖' + e['j401'] + '倍。');
                        break;
                    case 4:
                        this.$play.find('.choice_cound').css({'display':'block'});
                        this.$play.find(".play_select_prompt span").text('10元购买4个三连号（123、234、345、456）投注，选号与开奖号码一致即中奖' + e['j402'] + '倍。');
                        break;
                    case 5:
                        this.$play.find('.choice_cound').css({'display':'none'});
                        this.$play.find(".play_select_prompt span").text('10元购买1个三连号（123、234、345、456）投注，选号与开奖号码一致即中奖' + e['j403'] + '倍。');
                        break;
                    case 6:
                        this.$play.find('.choice_cound').css({'display':'block'});
                        this.$play.find(".play_select_prompt span").text('10元购买1个二同号(11*,22*,33*,44*,55*,66*)投注，选号与开奖号码一致即中奖' + e['j301'] + '倍。');
                        break;
                    case 7:
                        this.$play.find('.choice_cound').css({'display':'block'});
                        this.$play.find(".play_select_prompt span").text('选择1个相同号码和1个不同号码投注，选号与开奖号码一致即中奖' + e['j302'] + '倍。');
                        break;
                    case 8:
                        this.$play.find('.choice_cound').css({'display':'block'});
                        this.$play.find(".play_select_prompt span").text('至少选择2个号码投注，选号与开奖号码一致即中奖' + e['j201'] + '倍。');
                        break;
                    default:

                }
                this.$play.find("#3THTX").attr({peilv: e["j501"]});
                this.$play.find("#3THDX").attr({peilv: e["j502"]});
                this.$play.find("#3BTH").attr({peilv: e["j401"]});
                this.$play.find("#3LHDX").attr({peilv: e["j402"]});
                this.$play.find("#3LHTX").attr({peilv: e["j403"]});
                this.$play.find("#2THFX").attr({peilv: e["j301"]});
                this.$play.find("#2THDX").attr({peilv: e["j302"]});
                this.$play.find("#2BTH").attr({peilv: e["j201"]});
            },
            _updateRanking: function (e) {
                var i, n, s = _.map(e,
                    function (t, e) {
                        var i = "";
                        return e % 2 == 0 && (i = "table-odd"),
                            {
                                name: t[0],
                                issue: t[1],
                                odds: i
                            }
                    });
                _.isEqual(s, this.cache.ranking) || (this.cache.ranking = s, i = '{{#items}}<tr><td class="{{odds}} tal">{{name}}</td><td class="{{odds}} td-issue number">{{issue}}' + this.lang.msg.issue + "</td></tr>{{/items}}", n = this.tpl.to_html(i, {
                    items: s
                }), t("#changelong").find("tbody").html(n))
            },
            _updateSummary: function (e) {
                var i = this,
                    n = e.CloseCount;
                n > 0 && i.open(!0),
                null != i.closeTimer && i.closeTimer.stop(),
                    i.closeTimer = new this.CountDown(n),
                    i.closeTimer.update = function (e) {
                        t("#close-timer").text(i.utils.secondsFormat(e, !0))
                    },
                    i.closeTimer.done = function () {
                        i.close(),
                            t("#close-timer").text(i.lang.msg.closedGate)
                    },
                    i.closeTimer.start(),
                null != i.awarTimer && i.awarTimer.stop(),
                    i.awarTimer = new this.CountDown(Math.abs(e.OpenCount) + 5),
                    i.awarTimer.update = function (e) {
                        t("#award-timer").text(i.utils.secondsFormat(e, !0))
                    },
                    i.awarTimer.done = function () {
                        i.open()
                    },
                    i.awarTimer.start(),
                    t("#current-issue").text(e.CurrentPeriod + i.lang.msg.issue),
                    t("#win-lose").text(e.WinLoss),
                    t("#prev-issue").text(e.PrePeriodNumber)
            },
            _updateHitBalls: function (e) {
                var i = this,
                    n = t("#trends"),
                    s = t("#tpl-hit-miss").html();
                return n.show(),
                    i.disabledHits ? void n.hide() : (e.hit = e.hit["n" + i.NumberPostion], void n.html(this.tpl.to_html(s, e)))
            },
            _updateLuZhu: function (e) {
                var i = t("#luzhu"),
                    n = t("#tpl-luzhu").html(),
                    s = this,
                    a = s._luzCurrentTab || 0;
                i.show();
                var r = e || _.where(this.betInfo.LuZhu, {
                    p: s.NumberPostion
                });
                if (!r.length || s.disabledTrends) {
                    return void i.hide()
                }
                if (!_.isEqual(r, this.cache.lz)) {
                    this.cache.lz = r;
                    var l = _.map(r,
                        function (t) {
                            var e = _.map(t.c.split(","),
                                function (t) {
                                    var e = t.split(":"),
                                        i = e[0],
                                        n = e[1],
                                        s = n > 1 ? _.times(n,
                                            function () {
                                                return i
                                            }) : [i];
                                    return {
                                        item: s
                                    }
                                }),
                                i = 30 - e.length;
                            return i > 0 && _.times(i,
                                function () {
                                    e.push({
                                        item: []
                                    })
                                }),
                                {
                                    hd: t.n,
                                    bd: {
                                        items: e.reverse()
                                    }
                                }
                        }),
                        o = {
                            hd: _.pluck(l, "hd"),
                            bd: _.pluck(l, "bd")
                        };
                    i.html(this.tpl.to_html(n, o)).tab({
                        mouseover: !0,
                        current: a,
                        selected: function (t, e, i) {
                            s._luzCurrentTab = i
                        }
                    })
                }
            },
            _renderBall: function (e) {
                var i = this.ballTpl;
                ball = e.PreResult.split(",");
                var n = this.tpl.to_html(i, {
                    balls: ball
                });
                n && t("#prev-bs").html(n);
                var s = this.resultDataTpl;
                rdata = e.PreResultData.split(",");
                var a = this.tpl.to_html(s, {
                    prevdata: rdata
                });
                a && t("#prev-data").html(a)
            },
            _resetLianMa: function () {
                this._genderedLianMaBalls(!0).filter(":checked").prop("checked", !1).trigger("change"),
                    this.$ctn.find(":radio:checked").prop("checked", !1),
                    this.amount = 0
            },
            _genderedLianMaBalls: function (e) {
                var i = this.$ctn.find(":checkbox");
                return e ? i : i.filter(":checked").map(function () {
                    return t(this).attr("id").replace("b-", "")
                }).get()
            },
            _LianMa: function () {
                var e = this;
                this._LianMaConfig = {
                    max: 6,
                    total: 0,
                    min: 2,
                    money: 0,
                    lines: 0,
                    title: "",
                    balls: [],
                    _balls: [],
                    id: 0,
                    group: 0
                };
                var i = this._LianMaConfig,
                    n = "j-current-odds";
                e.$ctn.off("change", 'input[name="lm"]').on("change", 'input[name="lm"]',
                    function () {
                        var s = t(this),
                            a = s.data("min"),
                            r = t('label[for="' + this.id + '"]');
                        t("." + n).removeClass(n),
                            r.addClass(n);
                        var l = r.find("span").text();
                        i.title = r.find("b").text(),
                            i.id = s.val(),
                        l && (i.lines = l),
                            i.min = a,
                            e.$ctn.find(":checkbox:checked:first").trigger("change")
                    }),
                    e.$ctn.off("change", ":checkbox").on("change", ":checkbox",
                        function () {
                            e._genderedLianMaBalls().length >= i.max ? e._genderedLianMaBalls(!0).not(":checked").prop("disabled", !0) : e._genderedLianMaBalls(!0).filter(":disabled").prop("disabled", !1),
                                i.balls = e._genderedLianMaBalls(),
                                i._balls = [{
                                    id: parseInt(i.id, 10),
                                    category: i.title
                                }],
                                e.records = {
                                    category: i.title,
                                    id: i.id
                                }
                        }),
                    e.$doc.off("keyup blur", ".single-bet").on("keyup blur", ".single-bet",
                        function () {
                            var n = t(this),
                                s = n.val();
                            s ? (i.money = (s * i.group).toFixed(2), i.total = i.money, e.amount = s) : e.amount = 0,
                                e.$doc.find(".lm-total").text(i.total)
                        }),
                    e.$doc.off("click", ".j-highlights-tb tr").on({
                            mouseenter: function () {
                                t(this).addClass(s)
                            },
                            mouseleave: function () {
                                t(this).removeClass(s)
                            },
                            click: function (e) {
                                var i, n;
                                return i = t(this).find("input"),
                                !i.prop("disabled") && void(t(e.target).is(i) || (e.preventDefault(), n = i.prop("checked"), i.prop("checked", !n).trigger("change")))
                            }
                        },
                        ".j-highlights-tb tr")
            }
        })
    });