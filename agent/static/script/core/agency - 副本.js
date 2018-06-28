define([ "jquery", "mutual", "class", "popup", "clipboard", "lang", "cookie", "utils", "slick", "numerator", "waypoints", "jquery-scrollbar" ], function(t, e, a, o, n, l, s, r) {
	var c = new o(), d = {
		parse:function(e) {
			var a = t(e), i = a.data();
			return i.$el = a, i;
		},
		handleEvents:function(t, e) {
			var a = d[t.method];
			a && "function" == typeof a && a(t, e);
		},
		init:function(a, i) {
			function o() {
				new e.AjaxThread({
					url:"ajax.php",
					data:"action=getstatistics",
					callback:function(e) {
						for (var a in e) t(".j-detail").find('[data-name="' + a.toLowerCase() + '"]').text(e[a]);
					}
				});
			}
			function get_user_list(page){
				var obj = t(".j-member");
				obj.find(".j-loading").show(),
				// obj.find("[name=account]").attr("placeholder") == memberName && (memberName = ""),
				t.ajax({
					url:"ajax.php",
					data:{
						action: "getmymember",
						memberName: obj.find("[name=account]").val() || "",
						page: page || 1,
						agentId: getValue("__agent_ids__"),
						agentKey: getValue("__agent_key__"),
						type: obj.find(".j-memberTypeValue").data("value")
					},
					type:"post",
					success:function(e) {
						obj.find(".j-onLoad").hide(),
						obj.find(".j-table").find(".j-tbody").html(""),
						obj.find(".j-loading").hide();
						if (e.pageCount > 0) {
							var keys = ["username", "fullName", "regTime", "loginTime", "money", "online", "available"];
							$.each(e.list, function(index, data){
								var html = "<tr>";
								$.each(keys, function(index, key){
									html+= "<td>";
									if(key=="online"||key=="available"){
										html+= data[key]? '<i class="icon hook"></i>' :'<i class="icon cross"></i>';
									}else{
										key=="username"&&data['agent']&&(html+= '<span class="text-info">「代理」</span>');
										html+= data[key];
									}
									html+= "</td>";
								});
								obj.find(".j-table").find(".j-tbody").append(html + "</tr>");
							});
							if(e.agents){
								obj.find("[data-value=agent]").show();
							}else{
								obj.find("[data-value=agent]").hide();
							}
							if (e.rowCount > e.maxCount) {
								if (!page || 1 == page) {
									u({
										target:"j-member .j-pager",
										totalPages:e.pageCount,
										index:e.currentPage,
										callBack:function(page) {
											get_user_list(page);
										}
									});
								}
								obj.find(".j-pager").show();
							} else {
								obj.find(".j-pager").hide();
							}
							obj.find(".j-noData").hide();
						} else {
							obj.find(".j-noData").show(),
							obj.find(".j-pager").hide()
						};
					}
				});
			}
			function get_user_money(page){
				var obj = t(".j-money"), type = obj.find(".j-moneyTypeValue").data("value");
				obj.find(".j-loading").show(),
				// obj.find("[name=account]").attr("placeholder") == memberName && (memberName = ""),
				t.ajax({
					url:"ajax.php",
					data:{
						action: "getmembermoney",
						memberName: obj.find("[name=account]").val() || "",
						page: page || 1,
						days: obj.find(".j-daysValue").data("value") || "",
						type: (type&&parseInt(type)==4?obj.find(".j-otherTypeValue").data("value"):type) || 1,
						agentId: getValue("__agent_ids__"),
						agentKey: getValue("__agent_key__")
					},
					type:"post",
					success:function(e) {
						obj.find(".j-onLoad").hide(),
						obj.find(".j-table").find(".j-tbody").html(""),
						obj.find(".j-loading").hide();
						if (e.pageCount > 0) {
							var keys = ["username", "orderId", "orderTime", "money", "status"];
							$.each(e.list, function(index, data){
								var html = "<tr>";
								$.each(keys, function(i, key){
									html+= "<td>";
									if(key=="status"){
										html+= data[key]==1?'<i class="icon hook"></i>':data[key]==0?'<i class="icon cross"></i>':'<i class="icon reg-icon"></i>';
									}else if(key=="username"){
										html+= '<a class="team-valid-bet j-moneyDetails" data-name="' + data['username'] + '" href="javascript:;">' + data['username'] + "</a>";
									}else if(key=="orderId"){
										html+= '<a class="team-valid-bet j-orderDetails" data-index="' + index + '" href="javascript:;">' + data['orderId'] + "</a>";
									}else{
										html+= data[key];
									}
									html+= "</td>";
								});
								obj.find(".j-table").find(".j-tbody").append(html + "</tr>");
							});
							obj.find(".j-moneyDetails").on("click", function() {
								obj.find("[name=account]").val(t(this).data("name")),
								get_user_money()
							});
							obj.find(".j-orderDetails").on("click", function() {
								var i = t(this).data("index");
								if(typeof i!="undefined"){
									i = parseInt(i);
									c.dialog({
										width:700,
										title:"订单详细信息",
										content:t(".j-moneyDetailsDialog").get(0),
										fixed:!0,
										onshow:function() {
											t(".j-moneyDetailsDialog").find(".text-primary").each(function(){
												var obj2 = t(this), key = obj2.data("key");
												if(key&&e.list[i][key]){
													obj2.text((e.list[i][key]).replace(/<br[^>]*>/, " / ")).parents(".info").show();
												}else{
													obj2.parents(".info").hide()
												}
											});
										},
										onbeforeremove:function() {}
									});
								}
							});
							if (e.rowCount > e.maxCount) {
								if (!page || 1 == page) {
									u({
										target:"j-money .j-pager",
										totalPages:e.pageCount,
										index:e.currentPage,
										callBack:function(page) {
											get_user_money(page);
										}
									});
								}
								obj.find(".j-pager").show();
							} else {
								obj.find(".j-pager").hide();
							}
							obj.find(".j-totalCount").html(e.rowCount),
							obj.find(".j-totalMoney").html(e.totalMoney),
                            obj.find(".j-total").show(),
							obj.find(".j-noData").hide();
						} else {
							obj.find(".j-noData").show(),
							obj.find(".j-pager, .j-total").hide()
						};
					}
				});
			}
			function get_user_records(page){
				var obj = t(".j-records"), type = obj.find(".j-recordsValue").data("value");
				obj.find(".j-loading").show(),
				// obj.find("[name=account]").attr("placeholder") == memberName && (memberName = ""),
				t.ajax({
					url:"ajax.php",
					data:{
						action: "getmemberrecords",
						memberName: obj.find("[name=account]").val() || "",
						page: page || 1,
						days: obj.find(".j-daysValue").data("value") || "",
						type: obj.find(".j-records-"+type).find(".j-recordsTypeValue").data("value") || "",
						agentId: getValue("__agent_ids__"),
						agentKey: getValue("__agent_key__")
					},
					type:"post",
					success:function(e) {
						obj.find(".j-onLoad").hide(),
						obj.find(".j-table").find(".j-tbody").html(""),
						obj.find(".j-loading").hide();
						if (e.pageCount > 0) {
							var keys = ["username", "id", "betTime", "betAmount", "netAmount", "status"], createTime = true;
							$.each(e.list, function(index, data){
								var html = "<tr>";
								createTime = typeof data["betTime"]=="undefined";
								$.each(keys, function(i, key){
									html+= "<td>";
									if(key=="username"){
										html+= '<a class="team-valid-bet j-userDetails" data-name="' + data['username'] + '" href="javascript:;">' + data['username'] + "</a>";
									}else if(createTime&&key=="betTime"){
										html+= data["createTime"];
									}else if(key=="id"){
										html+= '<a class="team-valid-bet j-orderDetails" data-index="' + index + '" href="javascript:;">' + data['id'] + "</a>";
									}else{
										html+= data[key];
									}
									html+= "</td>";
								});
								obj.find(".j-table").find(".j-tbody").append(html + "</tr>");
							});
							obj.find(".j-table").find("th[data-key=betTime]").text(createTime?"投注时间(美东)":"投注时间(美东/北京)");
							obj.find(".j-userDetails").on("click", function() {
								obj.find("[name=account]").val(t(this).data("name")),
								get_user_records()
							});
							obj.find(".j-orderDetails").on("click", function() {
								var i = t(this).data("index");
								if(typeof i!="undefined"){
									i = parseInt(i);
									c.dialog({
										width:700,
										title:"投注详细信息",
										content:t(".j-recordsDetailsDialog").get(0),
										fixed:!0,
										onshow:function() {
											t(".j-recordsDetailsDialog").find(".text-primary").each(function(){
												var obj2 = t(this), key = obj2.data("key");
												if(key&&e.list[i][key]){
													key=="remark"?obj2.html(e.list[i][key]).parents(".info").show().prev().show():obj2.html((e.list[i][key]).toString().replace(/<br[^>]*>/, " / ")).parents(".info").show();
												}else{
													key=="remark"?obj2.parents(".info").hide().prev().hide():obj2.parents(".info").hide();
												}
											});
										},
										onbeforeremove:function() {}
									});
								}
							});
							if (e.rowCount > e.maxCount) {
								if (!page || 1 == page) {
									u({
										target:"j-records .j-pager",
										totalPages:e.pageCount,
										index:e.currentPage,
										callBack:function(page) {
											get_user_records(page);
										}
									});
								}
								obj.find(".j-pager").show();
							} else {
								obj.find(".j-pager").hide();
							}
							obj.find(".j-noData").hide();
						} else {
							obj.find(".j-noData").show(),
							obj.find(".j-pager").hide()
						};
					}
				});
			}
			function get_reports(page){
				var obj = t(".j-reports"), type = obj.find(".j-recordsValue").data("value");
				obj.find(".j-loading").show(),
				t.ajax({
					url:"ajax.php",
					data:{
						action: "getreports",
						memberName: obj.find("[name=account]").val() || "",
						page: page || 1,
						days: obj.find(".j-daysValue").data("value") || "",
						agentId: getValue("__agent_ids__"),
						agentKey: getValue("__agent_key__")
					},
					type:"post",
					success:function(e) {
						obj.find(".j-onLoad").hide(),
						obj.find(".j-table").find(".j-tbody").html(""),
						obj.find(".j-loading").hide(),
						obj.find(".j-formula").text(e.formula);
						if (e.pageCount > 0) {
							var keys = ["username", "reportTime", "betAmount", "netAmount", "validAmount", "rowCount", "money"], createTime = true;
							$.each(e.list, function(index, data){
								var html = "<tr>";
								createTime = typeof data["betTime"]=="undefined";
								$.each(keys, function(i, key){
									html+= "<td>";
									if(key=="username1"){
										html+= '<a class="team-valid-bet j-userDetails" data-name="' + data['username'] + '" href="javascript:;">' + data['username'] + "</a>";
									}else if(key=="reportTime"){
										html+= '<a class="team-valid-bet j-reportsDetails" data-index="' + index + '" href="javascript:;">' + data[key] + "</a>";
									}else{
										html+= data[key];
									}
									html+= "</td>";
								});
								obj.find(".j-table").find(".j-tbody").append(html + "</tr>");
							});
							obj.find(".j-total").show(),
							obj.find(".j-totalBet").text(e.total.bet),
							obj.find(".j-totalNet").text(e.total.net),
							obj.find(".j-totalValid").text(e.total.valid),
							obj.find(".j-totalCount").text(e.total.count),
							obj.find(".j-totalMoney").text(e.total.money),
							obj.find(".j-userDetails").on("click", function() {
								obj.find("[name=account]").val(t(this).data("name")),
								get_reports()
							});
							obj.find(".j-reportsDetails").on("click", function() {
								var i = t(this).data("index");
								if(typeof i!="undefined"){
									i = parseInt(i);
									c.dialog({
										width:700,
										title:e.list[i]["reportTime"]+" 统计详情",
										content:t(".j-reportsDetailsDialog").get(0),
										fixed:!0,
										onshow:function() {
											var keys = ["bet_amount", "net_amount", "valid_amount", "rows_num"], obj = t(".j-reportsDetailsDialog").find(".j-team-tbody");
											obj.empty();
											$.each(e.list[i]["data"], function($key, $val){
												var html = "<tr><td>"+$val["name"]+"</td>";
												$.each(keys, function(i, k){
													html+= "<td>"+$val["data"][k]+"</td>";
												});
												obj.append(html + "</tr>");
											})
										},
										onbeforeremove:function() {}
									});
								}
							});
							if (e.rowCount > e.maxCount) {
								if (!page || 1 == page) {
									u({
										target:"j-reports .j-pager",
										totalPages:e.pageCount,
										index:e.currentPage,
										callBack:function(page) {
											get_reports(page);
										}
									});
								}
								obj.find(".j-pager").show();
							} else {
								obj.find(".j-pager").hide();
							}
							obj.find(".j-noData").hide();
						} else {
							obj.find(".j-total").hide(),
							obj.find(".j-noData").show(),
							obj.find(".j-pager").hide()
						};
					}
				});
			}
			function get_agents_list(obj, page){
				obj.find(".j-loading").show(),
				// obj.find("[name=account]").attr("placeholder") == memberName && (memberName = ""),
				t.ajax({
					url:"ajax.php",
					data:{
						action: "getmyagent",
						memberName: obj.find("[name=account]").val() || "",
						page: page || 1,
						agentId: t(getValue("__agent_history__", [])).map(function($key, $val){
							return $val[0];
						}).get().join(",")
					},
					type:"post",
					success:function(e) {
						obj.find("[type=checkbox]").prop("checked", false),
						obj.find(".j-onLoad").hide(),
						obj.find(".j-table").find(".j-tbody").html(""),
						obj.find(".j-loading").hide();
						if (e.pageCount > 0) {
							var keys = ["checkbox", "username", "fullName"], count = 0, cid = (getValue("__child_agent__", {uid: []})).uid;
							$.each(e.list, function(index, data){
								var html = "<tr>";
								$.each(keys, function(index, key){
									html+= "<td>";
									if(key=="checkbox"){
										html+= '<input type="checkbox" data-id="'+data["uid"]+'" ';
										html+= 'data-level="'+data["level"]+'" ';
										if(cid.indexOf(data["uid"])>=0){
											html+= 'checked="true" ';
											count++;
										}
										html+= '/>';
									}else if(key=="username"){
										html+= e.agents?'<a class="team-valid-bet" data-id="' + data["uid"] + '" data-user="' + data["username"] + '" data-level="' + data["level"] + '" href="javascript:;">' + data["username"] + '</a>':data[key];
									}else{
										html+= data[key];
									}
									html+= "</td>";
								});
								obj.find(".j-table").find(".j-tbody").append(html + "</tr>");
							});
							count>0&&count==e.list.length&&obj.find("[type=checkbox]").eq(0).prop("checked", true);
							if (e.rowCount > e.maxCount) {
								if (!page || 1 == page) {
									u({
										target:"j-selectAgentDialog .j-pager",
										totalPages:e.pageCount,
										index:e.currentPage,
										callBack:function(page) {
											get_agents_list(obj, page);
										}
									});
								}
								obj.find(".j-pager").show();
							} else {
								obj.find(".j-pager").hide();
							}
							obj.find(".j-noData").hide();
						} else {
							obj.find(".j-noData").show(),
							obj.find(".j-pager").hide()
						};
					}
				});
			}
			function setValue($key, $val){
				return sessionStorage.setItem($key, JSON.stringify($val))
			}
			function getValue($key, $val){
				return JSON.parse(sessionStorage.getItem($key)) || $val
			}
			var d = a.init;
			switch (d) {
			  case "index":
				t("#slick").slick({
					arrows:!0,
					dots:!1,
					fade:!0,
					autoplay:!0,
					dots:!1,
					autoplaySpeed:6e3
				}), t(".j-infomation").slick({
					arrows:!1,
					vertical:!0,
					autoplay:!0,
					autoplaySpeed:3e3,
					infinite:!0,
					slidesToShow:3,
					slidesToScroll:3
				}), t(".numerator").each(function(e) {
					var a = t(this), i = a.data("num");
					a.numerator({
						toValue:i,
						onComplete:function() {
							a.text(i);
						}
					});
				}), t(window).scroll(function() {
					var e = t(window).scrollTop();
					e > 850 && (t(".j-img1").show(200), t(".j-img2").show(300), t(".j-img3").show(400), 
					t(".j-img4").show(500));
				}), t.fn.waypoint && t(".main").waypoint(function(e) {
					t(".multi-platform").addClass("move");
				}, {
					offset:"bottom-in-view"
				}), t("html").hasClass("lte-ie9") && t("#j-login-form").find('input[name="MemberName"],input[name="Pwd"], input[name="checkCode"]').placeholder({
					labelMode:!0,
					labelStyle:{
						margin:"18px 0 0 -2px",
						left:"52px"
					},
					labelAlpha:!0
				});
				var m = !1;
				t("#j-join").click(function() {
					i.isLogin ? 0 == i.testState && 0 == i.memberState ? (t(".j-join-d").show(), t(".modal-wrapper").animate({
						top:"40px"
					}, 500), t(".j-ok").on("click", function() {
						m || (m = !0, t.ajax({
							url:"ajax.php",
							data:"action=apply",
							type:"post",
							success:function(e) {
								t(".j-p1").text(e.errorMsg), 0 == e.errorCode ? (t(".j-p1").siblings().show(), t(".d-tick").show()) :(t(".j-p1").siblings().hide(), 
								t(".d-tick").hide()), c.dialog({
									width:2 == e.errorCode ? 450 :398,
									title:"系统提醒",
									content:t("#j-okjoin-main").get(0),
									fixed:!0,
									skin:"okjoin-dialog",
									okValue:"确定",
									ok:function() {},
									onbeforeremove:function() {
										t(".j-join-d").hide(), 0 == e.errorCode && location.reload();
									}
								}).showModal(), m = !1;
							}
						}));
					})) :2 == i.testState ? (t(".j-warn-p").text("试玩账号无法加入"), c.dialog({
						content:t("#j-warn-main").get(0),
						fixed:!0,
						skin:"warn-dialog",
						okValue:"确定",
						ok:function() {}
					}).showModal()) :(t(".j-warn-p").text("账号已被冻结，请联系客服"), c.dialog({
						width:398,
						content:t("#j-warn-main").get(0),
						fixed:!0,
						skin:"warn-dialog",
						okValue:"确定",
						ok:function() {}
					}).showModal()) :(t(".j-warn-p").text("请先登录!"), c.dialog({
						content:t("#j-warn-main").get(0),
						fixed:!0,
						skin:"warn-dialog",
						okValue:"确定",
						ok:function() {}
					}).showModal());
				});
				break;

			  case "mycommission":
				var f = new Date().getHours();
				if (f >= 6 && f < 12 ? t(".j-time").html("早上好").fadeIn(500) :f >= 12 && f < 18 ? t(".j-time").html("下午好").fadeIn(500) :f >= 18 && f < 23 && t(".j-time").html("晚上好").fadeIn(500), 
				setInterval(function() {
					r.heartbeat(e.cookieSetting.recommendStatistics, 60, function() {
						o();
					});
				}, 5e3), t(".tab").click(function() {
					t(this).addClass("active").siblings(".tab").removeClass("active"), t(this).siblings(".content").hide().eq(t(this).index()).show(), 
					"promoLink" === t(this).data("name") ? t("#j-promoLink").slideDown(500) :t("#j-promoLink").slideUp(500);
					t(".j-selectAgent").html(getValue("__agent_msg__", "点击选择下层代理"));
					switch(t(this).index()){
						case 1:
						get_user_list();
						break;
						case 2:
						get_user_money();
						break;
						case 3:
						get_user_records();
						break;
						case 4:
						get_reports();
						break;
					}
				}), t.support.opacity) {
					var h = new n(".j-copy");
					h.on("success", function(t) {
						c.msg("复制成功", 1500);
					}), h.on("error", function(t) {
						c.msg("您的浏览器不支持复制功能，请手动复制！", 1500);
					});
				} else t(".j-copy").on("click", function() {
					c.msg("您的浏览器不支持复制功能，请手动复制！", 1500);
				});
				t(".j-selectAgent").on("click", function() {
					var e = t(".j-selectAgentDialog"), data = getValue("__agent_backup__", []);
					if(data[0]){
						if(data[0].length>0){
							e.find(".j-agentLevel").text(data[0][data[0].length-1][2]),
							e.find(".j-agentName").text(data[0][data[0].length-1][1]),
							e.find(".j-total").parent().removeClass("hide")
						}else{
							e.find(".j-total").parent().addClass("hide")
						}
						setValue("__agent_history__", data[0]);
					}
					data[1]&&setValue("__child_agent__", data[1]);
					c.dialog({
						width:700,
						title:"选择下层代理",
						content:e.get(0),
						fixed:!0,
						onshow:function() {
							e.find("[type=button]").on("click", function(){
								var obj = t(this);
								if(obj.hasClass("j-confirm")){
									var ids = [], uids = getValue("__agent_history__", []), uid = t(uids).map(function($key, $val){
										return $val[0];
									}).get(), cid = getValue("__child_agent__", {uid:[]});
									uid.length>0&&ids.push(uid.join(","));
									cid.uid.length>0&&ids.push(cid.uid.join("|"));
									ids = ids.join(",");
									obj.hide().siblings("span").show();
									t.ajax({
										url:"ajax.php",
										data:{
											action: "getagentskey",
											agentId: ids
										},
										type:"post",
										success:function(data) {
											var e1 = t(".j-selectAgent"), msg;
											obj.show().siblings("span").hide();
											if(data.errorCode==0){
												msg = data.errorMsg==""?"点击选择下层代理":('当前位置：<span class="text-info">「第'+(cid.uid.length>0?cid.level:e.find(".j-total .j-agentLevel").text())+'层」</span><span class="text-primary">'+(cid.uid.length>0?"共"+cid.uid.length+"位代理":e.find(".j-total .j-agentName").text())+"</span>");
												e1.html(msg),
												setValue("__agent_backup__", [uids, cid]),
												setValue("__agent_key__", data.errorMsg),
												setValue("__agent_ids__", ids),
												setValue("__agent_msg__", msg),
												t(".tab.active").trigger("click"),
												e.parents(".art-dialog").find(".art-dialog-close").trigger("click")
											}else{
												c.msg(data.errorMsg, 1500);
											}
										}
									});
								}else{
									get_agents_list(e)
								}
							}),
							e.on("click", ".j-tbody .team-valid-bet", function(){
								var this1 = t(this), obj = e.find(".j-total").parent(), data = getValue("__agent_history__", []);
								setValue("__child_agent__", null);
								data.push([this1.data("id"), this1.data("user"), this1.data("level")]),
								obj.find(".j-agentLevel").text(this1.data("level")),
								obj.find(".j-agentName").text(this1.data("user")),
								setValue("__agent_history__", data);
								obj.removeClass("hide"),
								get_agents_list(e)
							}),
							e.on("click", ".j-total .team-valid-bet", function(){
								var obj = e.find(".j-total").parent(), data = getValue("__agent_history__", []);
								setValue("__child_agent__", null);
								if(data.length>0){
									data.length--;
									if(data.length>0){
										obj.find(".j-agentLevel").text(data[data.length-1][2]),
										obj.find(".j-agentName").text(data[data.length-1][1])
									}else{
										obj.addClass("hide")
									}
									setValue("__agent_history__", data);
								}
								get_agents_list(e)
							}),
							e.on("click", "[type=checkbox]", function(){
								var this1 = t(this), checkbox = e.find("[type=checkbox]"), data = getValue("__child_agent__", {
									uid: [],
									level: 0
								}), level = checkbox.filter("[data-id]").data("level");
								typeof this1.data("id")=="undefined"?checkbox.prop("checked", this1.is(":checked")):
								checkbox.eq(0).prop("checked", checkbox.filter("[data-id]").size()==checkbox.filter("[data-id]:checked").size()),
								data.level!=level&&(data.uid = []);
								data.level = level;
								checkbox.filter("[data-id]").each(function(){
									var e = t(this), i = parseInt(e.data("id")), index = data.uid.indexOf(i);
									if(e.is(":checked")){
										index<0&&data.uid.push(i);
									}else{
										index>=0&&data.uid.splice(index, 1);
									}
								}),
								setValue("__child_agent__", data);
							}),
							get_agents_list(e)
						},
						onbeforeremove:function() {}
					});
				}),
				t(".j-member .j-search").on("click", function() {
					get_user_list();
				}),
				t(".j-member .j-memberType").find(".item").on("click", function() {
					var e = t(this);
					t(".j-member .j-memberTypeValue").data("value", e.data("value")).text(e.text()),
					get_user_list();
				});
				t(".j-member .j-agentBack").on("click", function() {
					var e1 = t(this), e2 = t(".j-member .j-memberType").find(".item").eq(0);
					e1.parents("div.info").addClass("hide"),
					t(".j-member [name=account]").val(""),
					t(".j-member .j-memberTypeValue").data("value", e2.data("value")).removeData("ids").text(e2.text());
					get_user_list();
				});
				t(".j-money .j-search").on("click", function() {
					get_user_money();
				}),
				t(".j-money .dropdown").find(".list .item").on("click", function() {
					var e = t(this), o = t(".j-money .j-dropdown").filter(".ml15"), f = o.find(".item").eq(0);
					e.parent().siblings("[data-value]").data("value", e.data("value")).text(e.text());
					if(e.parents(".dropdown").hasClass("j-dropdown")){
						if(parseInt(e.data("value"))>=4){
							o.show();
						}else{
							o.hide();
							f.parent().siblings("[data-value]").data("value", f.data("value")).text(f.text());
						}
					}
					get_user_money();
				});
				t(".j-records .j-search").on("click", function() {
					get_user_records();
				}),
				t(".j-records .dropdown").find(".list .item").on("click", function() {
					var e = t(this), o = e.parents(".dropdown").siblings(".dropdown").not(".j-dropdown");
					e.parent().siblings("[data-value]").data("value", e.data("value")).text(e.text());
					if(e.parents(".dropdown").hasClass("j-dropdown")&&o.filter(".j-records-"+e.data("value")).is(":hidden")){
						o.each(function(){
							var e = t(this).find(".item").eq(0);
							e.parent().siblings("[data-value]").data("value", e.data("value")).text(e.text());
						});
						o.filter(".j-records-"+e.data("value")).show().siblings(".dropdown").not(".j-dropdown").hide();
					}
					get_user_records();
				});
				t(".j-reports .j-search").on("click", function() {
					get_reports();
				}),
				t(".j-reports .j-dropdown").find(".item").on("click", function() {
					var e = t(this);
					t(".j-reports .j-daysValue").data("value", e.data("value")).text(e.text()),
					get_reports();
				});
			}
		}
	}, m = a.create({
		initialize:function(e) {
			var a = this;
			this.options = t.extend(!0, {}, e), t(function() {
				t(document).on("click", "[data-click]", function(t) {
					t.preventDefault();
					var e = d.parse(this);
					e.method = e.click, d.handleEvents(e, t);
				}), t(document).on("hover", "[data-hover]", function(t) {
					t.preventDefault();
					var e = d.parse(this);
					e.method = e.hover, d.handleEvents(e);
				}), t(document).on("change", "[data-change]", function(t) {
					t.preventDefault();
					var e = d.parse(this);
					e.method = e.change, d.handleEvents(e);
				}), t(document).on("blur", "[data-blur]", function(t) {
					t.preventDefault();
					var e = d.parse(this);
					e.method = e.blur, d.handleEvents(e);
				}), t("[data-plugin]").each(function() {
					var t = d.parse(this);
					d.render(t);
				}), t("[data-init]").each(function() {
					var t = d.parse(this);
					d.init(t, a.options);
				}), a.registerEvents();
			});
		},
		fixIE:function() {
			if (t("html").hasClass("lte-ie9") && t.fn.placeholder) {
				var e = t("#account-form").find('input[name="pwd"]'), a = e.data("options");
				a && t("#account-form").find('input[name="pwd"]').placeholder({
					labelMode:!0,
					labelStyle:{
						margin:a.margin,
						left:a.left,
						color:a.color,
						"font-size":a.fontSize
					}
				});
			}
		},
		registerEvents:function() {
			t(".j-about").click(function() {
				t(".j-about-d").show(), t(".modal-wrapper").animate({
					top:"40px"
				}, 500);
			}), t.fn.scrollbar && t(".scrollbar-inner").scrollbar(), t(".j-close").click(function() {
				t(".modal-wrapper").css({
					top:"800px"
				}), t(".j-join-d").hide(), t(".j-about-d").hide();
			}), t("#j-login").click(function() {
				c.dialog({
					width:370,
					title:" ",
					content:t("#j-login-main").get(0),
					fixed:!0,
					skin:"login-dialog",
					onshow:function() {
						var e = !1;
						t("#j-login-form").off("submit").on("submit", function() {
							if (!e) {
								e = !0;
								var a = t(this), i = a.find(".j-warn"), o = "";
								if (0 == a.find(".account").val().length ? o = l.tipsInputAccount :0 == a.find(".pwd").val().length ? o = l.tipsInputPassword :a.find(".pwd").val().length < 6 && (o = l.tipsPswLengthError), 
								showCheckcode() && 0 == a.find(".checkcode").val().length && (o = l.tipsInputCheckCode), 
								o) return i.show().html('<i class="icon d-warn"></i>' + o), e = !1, !1;
								i.hide(), t.post("ajax.php", t("#j-login-form").serialize() + "&action=login&version=1.3", function(a) {
									e = !1, a && (a.errorCode ? 6 == a.errorCode && s("failCount") < 2 ? (t("#j-login-form").find(".code-box").show(), 
									o = "您输入的密码已连续错误3次，请输入验证码", s("failCount", 3)) :(new f("vCodeImg"), self.showCheckcode(), 
									o = a.errorMsg) :a.isForzen ? (t(".j-p1").text(a.errorMsg), t(".j-p1").siblings().hide(), 
									t(".d-tick").hide(), c.dialog({
										width:398,
										title:"系统提醒",
										content:t("#j-okjoin-main").get(0),
										fixed:!0,
										skin:"okjoin-dialog",
										okValue:"确定",
										ok:function() {
											location.reload();
										}
									}).showModal()) :(t("#j-success").show(), setTimeout(function() {
										location.reload();
									}, 500)), o && i.show().html('<i class="icon d-warn"></i>' + o));
								});
							}
						});
					}
				}).showModal();
			}), showCheckcode = function() {
				var e = s("failCount");
				return !!(e && e > 2) && (t("#j-login-form").find(".code-box").show(), !0);
			};
		}
	}), f = function(e) {
		function a(t) {
			i.options.img.attr("src", i.options.url + "?rand=" + Math.random()), t && t.val("");
		}
		if (!this instanceof f) return new f(e);
		if (this.options = {
			url:"../yzm.php",
			img:null,
			relation:null,
			loadImg:null,
			event:null
		}, !e) throw Error("验证码对象参不存在");
		if ("string" == typeof e ? this.options.img = e :t.extend(this.options, e), !this.options.img) throw Error("验证码图片对象不存在");
		this.options.img = r.jq(this.options.img);
		var i = this;
		if (this.options.relation) if (this.options.relation instanceof Array) for (var o, n = 0; n < this.options.relation.length; n++) o = r.jq(this.options.relation[n]), 
		o && (o.val(""), o.on("focus", function() {
			var e = t(this);
			"text" === e.attr("type") && "none" == i.options.img.css("display") && (e.attr("placeholder", "").val(""), 
			i.options.img.show(), a(e));
		})); else {
			var o = r.jq(this.options.relation);
			o.val(""), o.on("focus", function() {
				var e = t(this);
				"text" === e.attr("type") && "none" == i.options.img.css("display") && (e.attr("placeholder", "").val(""), 
				i.options.img.show(), a());
			});
		}
		return this.options.img.on("click", function() {
			if (i.options.loadImg && "string" == typeof i.options.loadImg) {
				var e = '<span id="chckloadingDiv" style="z-index: 1987;position: absolute;left: 0;top: -18px;width: 55px;height: 25px;line-height: 51px;text-align: center;background: #595959;opacity: 0.5;"><img style="bottom:4px;left:18px;" src="' + i.options.loadImg + '"></span>';
				t(this).before(e), a(), t(this).load(function() {
					t("#chckloadingDiv").remove();
				});
			} else a();
		}), this.options.img.is(":visible") && a(), this;
	};
	f.prototype.Refresh = function(t) {
		this.options.img.attr("src", this.options.url + "?rand=" + Math.random()), t && t.val("");
	};
	var u = function(e) {
		function a(t) {
			var e = l(m), a = t - (e / 2 - 1), o = "";
			for (i = 0; i < m; i++) o += '<li class="page">' + (a + i) + "</li>";
			c.find("ul").html(u.replace("{0}", o)), c.find("ul .page").eq(e / 2 - 1).addClass(f);
		}
		function o(t) {
			var e = "";
			if (d > m - 1) for (i = 0; i < m; i++) e += '<li class="page">' + (i + 1) + "</li>"; else for (i = 0; i < d; i++) e += '<li class="page">' + (i + 1) + "</li>";
			c.find("ul").html(u.replace("{0}", e)), c.find("ul .page").eq(t).addClass(f);
		}
		function n(t) {
			var e = "";
			if (d > m - 1) for (i = d - (m - 1); i < d + 1; i++) e += '<li class="page">' + i + "</li>"; else for (i = 0; i < d; i++) e += '<li class="page">' + (i + 1) + "</li>";
			c.find("ul").html(u.replace("{0}", e)), c.find("ul .page").eq(t).addClass(f);
		}
		function l(t) {
			var e = t % 2;
			return 0 == e ? t :1 == e ? t + 1 :void 0;
		}
		var s = {
			target:"",
			totalPages:10,
			liNums:5,
			activeClass:"active",
			firstPage:"首页",
			lastPage:"末页",
			prv:"«",
			next:"»",
			hasFirstPage:!0,
			hasLastPage:!0,
			hasPrv:!0,
			hasNext:!0,
			callBack:function(t) {}
		}, r = t.extend(s, e), c = t("." + r.target), d = r.totalPages, m = r.liNums, f = r.activeClass, u = "{0}", h = "", p = '<li class="page ' + f + '">1</li>';
		if (d > 1 && d < m + 1) for (i = 2; i < d + 1; i++) h += '<li class="page">' + i + "</li>"; else if (d > m) for (i = 2; i < m + 1; i++) h += '<li class="page">' + i + "</li>";
		var g = p + h;
		r.hasNext && (u = '<li class="prv">' + r.prv + "</li>" + u), r.hasPrv && (u += '<li class="next">' + r.next + "</li>"), 
		r.hasLastPage && (u += '<li class="last">' + r.lastPage + "</li>"), r.hasFirstPage && (u = '<li class="first">' + r.firstPage + "</li>" + u), 
		g = '<ul class="pager">' + u.replace("{0}", g) + "</ul>", c.html(g).off("click"), 
		c.on("click", ".next", function() {
			var t, e, i = parseInt(c.find("." + f).html()), o = m % 2;
			0 == o ? (t = m, e = !0) :1 == o && (t = m + 1, e = !1), i >= d || (i > 0 && i <= t / 2 ? c.find("." + f).removeClass(f).next().addClass(f) :i > d - t / 2 && i < d && 0 == e || i > d - t / 2 - 1 && i < d && 1 == e ? c.find("." + f).removeClass(f).next().addClass(f) :(c.find("." + f).removeClass(f).next().addClass(f), 
			a(i + 1)), r.callBack(i + 1));
		}), c.on("click", ".prv", function() {
			var t = parseInt(c.find("." + f).html()), e = l(m);
			t <= 1 || (t > 1 && t <= e / 2 || t > d - e / 2 && t < d + 1 ? c.find("." + f).removeClass(f).prev().addClass(f) :(c.find("." + f).removeClass(f).prev().addClass(f), 
			a(t - 1)), r.callBack(t - 1));
		}), c.on("click", ".first", function() {
			var t = parseInt(c.find("." + f).html());
			t <= 1 || (r.callBack(1), o(0));
		}), c.on("click", ".last", function() {
			var t = parseInt(c.find("." + f).html());
			t >= d || (r.callBack(d), n(d > m ? m - 1 :d - 1));
		}), c.on("click", ".page", function() {
			var e = t(this), i = parseInt(e.html()), s = l(m);
			r.callBack(i), d > m ? i > d - s / 2 && i < d + 1 ? n(m - 1 - (d - i)) :i > 0 && i < s / 2 ? o(i - 1) :a(i) :(c.find("." + f).removeClass(f), 
			e.addClass(f));
		});
	};
	return m;
});