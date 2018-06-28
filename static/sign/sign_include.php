<?php
/******************
 **
 **  请在模板的 <body></body> 标签内添加下面代码
 **  <?php include($C_Patch.'/static/sign/sign_include.php'); ?>
 **
 ******************/
isset($C_Patch) or exit('Access Denied');
is_file($C_Patch.'/cache/sign.php')&&include($C_Patch.'/cache/sign.php');
if(is_array($sign_config)&&$sign_config['open']==1): ?>

<div style="right:0px;position:fixed;top:0px;z-index:1000">
    <div class="sign-pageflip" style="float:right;position:relative">
        <a href="javascript:;" onclick="Sign.sign()">
            <img style="width:0;height:0;max-width:none;max-height:none;z-index:99;right:0px;width:0px;position:absolute;top:0px;height:0px;ms-interpolation-mode:bicubic" src="static/sign/images/page_flip.png">
        </a>
        <div class="sign-block" style="right:0px;background:url(/static/sign/images/sign.png) no-repeat right top;overflow:hidden;width:0px;position:absolute;top:0px;height:0px"></div>
    </div>
</div>
<script src="/static/sign/sign.js"></script>
<script type="text/javascript">
Sign.cookieName = "Sign2-<?=$uid?$uid:'guest'?>";
Sign.defaultSmall = <?=$sign_config['member']['guest']?'false':'true'?>;
$(document).ready(function(){Sign.init()});
</script>
<?php endif; ?>