<?php isset($C_Patch) or exit('Access Denied'); ?>
<?php include __DIR__ . '/../sign/sign_include.php'; ?>
<?php if($uid):?>      
<link type="text/css" rel="stylesheet" href="/popmessage/pop.css"/>
<script type="text/javascript" src="/popmessage/yanue.pop.js"></script>  
<div id="pop" style="display:none;z-index:9999;">
	<div id="popHead"><a id="popClose" title="关闭">关闭</a><h2>温馨提醒</h2></div>
	<div id="popContent">
		<dl>
			<dt id="popTitle"><a href="javascript:;" onclick="menu_url(9);return false">标题</a></dt>
			<dd id="popIntro"><a href="javascript:;" onclick="menu_url(9);return false">内容</a></dd>
		</dl>
		<p id="popMore"><a href="javascript:;" onclick="menu_url(9);return false">查看 &raquo;</a></p>
	</div>
</div>
<script type="text/javascript" >
	function PopMessage(msg_num) {
		var pop = new Pop("<?php echo $_SESSION['username']; ?>，您好！","","您有 <font color='#ff0000'>[" + msg_num + "]</font> 条新消息，请注意查收！");
		var flashvars = {};
		var params = {};
		params.wmode = 'transparent';
		params.quality = 'high';
		var attributes = {};
	}
</script>
<?php endif;?>