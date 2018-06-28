<?php $C_Patch = $_SERVER['DOCUMENT_ROOT'];
@(include_once $C_Patch . '/cache/website.php');
@(include_once $C_Patch . '/cache/conf.php');
if ($web_site['close'] != 1) {
    header('Location: /');
    exit;
}
$web_site['why'];
header('Content-type: text/html;charset=utf-8');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>系统维护中...</title>

    <!-- Bootstrap -->
    <link href="/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="/static/bootstrap/js/html5shiv.min.js"></script>
    <script src="/static/bootstrap/js/respond.min.js"></script>
    <![endif]-->
    <style>
        .container > div {
            background: url('/images/fix_line.gif') no-repeat right top;
            width: 345px;
            height: 219px;
            padding: 0 10px;
            float: left;
            color: #FFF;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }
        p {
            line-height: 24px;
            font-weight: bold;
            margin: 8px 0 0;
    </style>
</head>
<body style="padding-bottom: 200px;">
<img src="/images/maintenance.jpg" class="center-block" style="margin-top: 100px">
<nav class="navbar-fixed-bottom" style="background: url('/images/fix_bg.gif');height: 219px;">
    <div class="container" style="width: 1045px">
        <div style="width: 325px;">
            <img src="/images/fix_3.gif">
            <p>
                服务器维护时间: <em><?=$web_site['close_time']?></em>(北京时间)
                <br>
                网站维护中，请稍后再试，给您带来不便，敬请谅解</p>
        </div>
        <div>
            <img src="/images/fix_4.gif">
            <p>
                Service Disruption Period: <em><?=$web_site['close_time']?></em>(GMT +08:00)
                <br>
                Website maintenance, please try again later, bring you inconvenience, please understand
            </p>
        </div>
        <div style="background: none">
            <img src="/images/fix_5.gif">
            <p>
                ระยะเวลาที่ไม่สามารถให้บริการ: <em><?=$web_site['close_time']?></em>(GMT +08:00)
                <br>
                การบำรุงรักษาเว็บไซต์โปรดลองอีกครั้งในภายหลังเพื่อทำให้คุณไม่สะดวกโปรดเข้าใจ
            </p>
        </div>
    </div>
</nav>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/static/bootstrap/js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/static/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>