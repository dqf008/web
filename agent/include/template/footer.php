<?php defined('IN_AGENT')||exit('Access denied'); ?>
	</div>
	<div class="footer">
		<div class="wrapper">
			<div class="partner">
				<span>合作伙伴：</span>
				<a class="logos maya" href="javascript:;"></a>
				<a class="logos ag" href="javascript:;"></a>
				<a class="logos mg" href="javascript:;"></a>
				<a class="logos oneworks" href="javascript:;"></a>
				<a class="logos alipay" href="javascript:;"></a>
				<a class="logos mc" href="javascript:;"></a>
				<a class="logos upay" href="javascript:;"></a>
				<a class="logos pay" href="javascript:;"></a>
				<a class="logos a18" href="javascript:;"></a>
			</div>
		</div>
		<p>Copyright &copy; <?php echo date('Y').' '.$web_site['web_name']; ?> Reserved</p>
	</div>
	<div id="j-login-main" class="d-login hide">
		<form id="j-login-form" onsubmit="return false;">
			<p class="d-title">马上登录</p>
			<p>马上开启您的财富之旅</p>
			<hr />
			<p class="warn j-warn hide"><i class="icon d-warn"></i></p>
			<div class="account-box">
				<i class="icon d-account"></i>
				<input class="account" name="MemberName" type="text" placeholder="帐号" disable-placeholder>
			</div>
			<div class="pwd-box" style="position:relative;">
				<i class="icon d-pwd"></i>
				<input class="pwd" name="Pwd" type="password" placeholder="密码" disable-placeholder>
				<a class="forgetpwd" href="javascript:;" onclick="alert('请联系我们的在线客服')">忘记密码？</a>
			</div>
			<div class="code-box hide">
				<i class="icon code-icon"></i>
				<input type="text" class="checkcode" maxlength="4" name="checkCode" placeholder="验证码" disable-placeholder>
				<span class=" img-bg"><img id="vCodeImg" src="../yzm.php" width="72" height="42" alt=""></span>
				<span class="change fr">看不清楚换一张</span>
			</div>
			<input class="btn-login" type="submit" value="登录" />
			<p>如登录遇到任何疑问，请联系我们的<a href="javascript:;" onclick="ChatWithService()">在线客服</a></p>
			<div class="ok-login hide" id="j-success"><i class="icon d-ok"></i>登录成功！</div>
		</form>
	</div>
	<div class="modal j-about-d  hide about-modal">
		<div class="modal-wrapper">
			<div class="modal-border"></div>
			<div class="modal-bg"></div>
			<a href="javascript:;" class="modal-close j-close"></a>
			<div class="modal-header">
				<div class="pic">
					<div>关于我们</div>
					<p>ABOUT US</p>
				</div>
			</div>
			<div id="j-about-main" class="modal-content">
				<div class="box scrollbar-inner"><?php $rows = get_webinfo_bycode('agent-aboutus');echo isset($rows['content'])?$rows['content']:''; ?></div>
			</div>
		</div>
	</div>
	<div class="modal j-join-d hide join-modal">
		<div class="modal-wrapper">
			<div class="modal-border"></div>
			<div class="modal-bg"></div>
			<a href="javascript:;" class="modal-close j-close"></a>
			<div class="modal-header">
				<div class="pic">
					<div>马上加入</div>
					<p>JOIN NOW</p>
				</div>
			</div>
			<div id="j-join-main" class="modal-content">
				<div class="box scrollbar-inner">
					<div class="mt-10">【注意】欢迎加入<?php echo $web_site['web_name']; ?>推广代理行列，请您（以下简称用户）仔细阅读以下全部内容，如用户使用推广代理服务，即表示用户与公司已达成协议， 自愿接受本服务条款所有内容。此后，用户不得以未阅读本服务条款内容作任何形式的抗辩。以下条款和条件适用于本网站。</div>
					<div class="mt-10">请务必使用您的个人会员账号开启推广代理功能，账号要求请根据会员《开户协议》执行</div>
					<h3>服务条款：</h3>
					<hr />
<?php if(isset($AGENT['config']['ServiceRule'])){foreach($AGENT['config']['ServiceRule'] as $k=>$v){ ?>					<p><?php echo '<span>'.substr('00'.($k+1), -2).'.</span>'.$v; ?></p>
<?php }} ?>					<p class="statement">若有疑问请联系在线客服，<?php echo $web_site['web_name']; ?>拥有最终解释权</p>
					<hr />
				</div>
			</div>
			<div class="modal-handle"><button class="modal-ok j-ok">同意</button></div>
		</div>
	</div>
	<div id="j-okjoin-main" class="okjoin hide">
		<div>
			<i class="icon d-tick fl"></i>
			<span class="fr text-l">
				<p class="p1 j-p1">成功加入！</p>
				<p>分享推广链接，缔造财富之路</p>
			</span>
		</div>
	</div>
	<div id="j-warn-main" class="warn-main hide">
		<div>
			<i class="icon d-warn-m fl"></i>
			<span class="fr text-l"><p class="p1 j-warn-p">请先登录！</p></span>
		</div>
	</div>
	<div class="online-service">
		<i class="icon icon-chat"></i>
		<p class="service-title">在线客服</p>
		<div class="service-main">
			<p class="title">在线为您服务!</p>
<?php if(isset($AGENT['config']['HotLine'])&&!empty($AGENT['config']['HotLine'])){ ?>			<p class="phone-num"><?php echo $AGENT['config']['HotLine']; ?></p>
<?php } ?>			<button onclick="ChatWithService(); return false;"><i class="icon service-icon"></i>点击进行对话</button>
<?php if(isset($AGENT['config']['ServiceQQ'])&&!empty($AGENT['config']['ServiceQQ'])){ ?>			<div class="qq-list">
<?php foreach($AGENT['config']['ServiceQQ'] as $qq){ ?>				<a href="tencent://message/?exe=qq&menu=yes&Uin=<?php echo $qq; ?>" data-qq="<?php echo $qq; ?>">
					<i class="icon icon-qq-on"></i>
					<p>官方QQ</p>
					<p><?php echo $qq; ?></p>
				</a>
<?php } ?>			</div>
<?php } ?>			<div class="wechat">
<?php if(isset($AGENT['config']['WeChatQrCode'])&&!empty($AGENT['config']['WeChatQrCode'])){ ?>				<p class="wechat-no"><i class="icon wechat-icon"></i>微信</p>
				<img src="<?php echo $AGENT['config']['WeChatQrCode']; ?>" style="max-width:108px">
				<p class="wechat-tip">扫一扫，发现更多优惠</p>
<?php } ?>			</div>
		</div>
	</div>
	<script>
		var official_cfg = {
			'common_url': '',
			'static_url': '',
			'app_url': '',
			'loadImgUrl': 'static/style/images/loading.gif',
			'currencyImgUrl': 'static/style/images/currency.png',
			'clientLang': 'zh_cn',
			'isPoorSite': 'False'
		}, ChatWithService = function(){
<?php if(isset($AGENT['config']['ServiceUrl'])&&!empty($AGENT['config']['ServiceUrl'])){ ?>			window.open("<?php echo $AGENT['config']['ServiceUrl']; ?>");
<?php }else{ ?>		alert('暂无可用在线客服！');
<?php } ?>		};
	</script>
	<script src="static/script/main.js"></script>
	<script>
		require(['agency'], function (Agency) {
			new Agency({
				isLogin: <?php echo $AGENT['user']['login']?1:0; ?>,
				testState: 0,
				memberState: 0
			});
		});
	</script>
</body>
</html>
