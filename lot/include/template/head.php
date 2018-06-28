<?php !defined('IN_LOT') && die('Access Denied'); ?>
<!doctype html>
<!--[if lt IE 7 ]>
<html class="no-js ie6 ie"> <![endif]-->
<!--[if IE 7 ]>
<html class="no-js ie7 ie"> <![endif]-->
<!--[if IE 8 ]>
<html class="no-js ie8 ie"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <title><?php echo $LOT['title']; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="static/styles/<?php echo $LOT['skin']; ?>.css?v=20161011">
    <!--[if IE 6]>
    <script src="static/scripts/DD_belatedPNG_0.0.8a.js?v=20161011"></script>
    <script>
        /* EXAMPLE */
        DD_belatedPNG.fix('.icon');
        /* string argument can be any CSS selector */
        /* .png_bg example is unnecessary */
        /* change it to what suits you! */
    </script>
    <![endif]-->
    <script>
        var ry_lottery_config = {
            assets: 'static/{0}?v=20161011',
            currency: '¥',
            locale: 'zh_cn'
        };
    </script>
    <script>
        window.location ="#nav";//自动跳转到锚点处
    </script>
    <script src="static/scripts/requirejs.js"></script>
    <style>
        #nav{
            height: 35px;
            width: 1000px;
            background-image: url('../../../lot/static/styles/images/nav_bg.png');
            background-size: 100% 35px;
            background-repeat: no-repeat;
            position: relative;
        }
        .nav_case.nav_active {
            background-image: url('../../../lot/static/styles/images/red_bg.png');
            background-size: 100% 35px;
        }
        .nav_case{
            width: 126px;
            height: 35px;
            display: inline-block;
            line-height: 35px;
            text-align: center;
            color:#fff;
            font-weight: bold;
            position: absolute;
            font-size: 13px;
        }
        .button.help-button{
            padding:0 0;
            line-height: 28px;
            font-size: 10px;
        }
    </style>
</head>
<body>
<div class="container" style="position: relative">
    <div id="nav" class="nav clearfix">
        <div class="nav-icons" style="position: absolute;right: 0px;top: 35px">
            <a class="odfi need-auth" style="display:none" href="javascript:;" data-href="" title="个人资料"
               data-height="500"><i class="icon icon-account"></i></a>
            <a class="odfi need-auth" style="display:none" href="javascript:;" data-href="" title="结算报表"><i
                        class="icon icon-reports"></i></a>
            <a target="_blank" href="http://kj.igame007.net/html/public/home.html" class="openUrl"><button class="button help-button">开奖视频</button></a>
            <a class="odfi" href="javascript:;"
               data-href="dialog.php?i=history&amp;lotteryId=<?php echo $LOT['action']; ?>" title="历史开奖"
               data-height="400">
                <button class="button help-button">历史开奖</button>
            </a>            
            <a class="odfi need-auth" href="javascript:;" style="display:none"
               data-href="dialog.php?i=record&amp;lotteryId=<?php echo $LOT['action']; ?>" title="历史注单"
               data-height="410"><button class="button help-button">历史注单</button></a>
            <a class="odfi" href="javascript:;"
               data-href="dialog.php?i=rule&amp;lotteryId=<?php echo $LOT['action']; ?>" title="规则"><button class="button help-button">规则</button></a>
        </div>
            <a href="?i=pk10" name='t_pk10'><span class="nav_case" style="left: 0;">赛车</span></a>
            <a href="?i=cqssc" name='t_cqssc'><span class="nav_case" style="left: 110px;">时时彩</span></a>
            <a href="?i=k3" name='t_k3'><span class="nav_case" style="left: 220px;">全国快3</span></a>
            <a href="?i=pcdd" name='t_kl8'><span class="nav_case" style="left: 330px;">PC蛋蛋</span></a>
            <a href="?i=jslh" name='t_jslh'><span class="nav_case" style="left: 440px;">六合彩</span></a>
            <a href="?i=gdkl10" name='t_gdkl10'><span class="nav_case" style="left: 549px;">快乐10分</span></a>
            <a href="?i=choose5" name='t_choose5'><span class="nav_case" style="left: 658px;">11选5</span></a>
            <a href="?i=qxc" name='t_qxc'><span class="nav_case" style="left: 766px;">七星彩</span></a>
            <a href="?i=shssl" name='t_other'><span class="nav_case" style="left: 875px;">其他</span></a>
        </div>
<!--    </div>-->
<script type="text/javascript">

    var actiom_nav =<?php echo '"'.$LOT['action'].'"'?>;

    if(actiom_nav=='pk10' || actiom_nav=='jssc' || actiom_nav =='xyft' || actiom_nav=='jsft') {
        $("#nav a[name=t_pk10] span").addClass('nav_active');
    }else if(actiom_nav=='cqssc' || actiom_nav=='sfssc'|| actiom_nav=='jsssc'|| actiom_nav=='tjssc' || actiom_nav=='xjssc') {
        $("#nav a[name=t_cqssc] span").addClass('nav_active');
    }else if (actiom_nav=='gdkl10' || actiom_nav=='cqkl10'|| actiom_nav=='ffkl10' ||actiom_nav=='hnkl10'||actiom_nav=='sfkl10'||actiom_nav=='sxkl10'||actiom_nav=='tjkl10' || actiom_nav=='ynkl10') {
        $("#nav a[name=t_gdkl10] span").addClass('nav_active');
    }else if (actiom_nav=='choose5') {
        $("#nav a[name=t_choose5] span").addClass('nav_active');
    }else if (actiom_nav=='kl8' || actiom_nav=='pcdd' || actiom_nav=='ffpcdd') {
        $("#nav a[name=t_kl8] span").addClass('nav_active');
    }else if(actiom_nav =='jslh' || actiom_nav=='marksix'){
        $("#nav a[name=t_jslh] span").addClass('nav_active');
    }else if(actiom_nav.indexOf('k3')!=-1){
        $("#nav a[name=t_k3] span").addClass('nav_active');
    }else if(actiom_nav =='wfqxc' || actiom_nav=='qxc' || actiom_nav=='ffqxc'){
        $("#nav a[name=t_qxc] span").addClass('nav_active');
    }else if(actiom_nav=='3d' || actiom_nav=='pl3' || actiom_nav=='shssl'){
        $("#nav a[name=t_other] span").addClass('nav_active');
    }
</script>
