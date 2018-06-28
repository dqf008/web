<?php
    $cdn_url = '//cdn.fox008.cc/';
    $version = '20180607';
?>
<html id="ng-app" ng-app="portalApp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>真人视讯</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/modern-normalize@0.4.0/modern-normalize.min.css">
    <link rel="stylesheet" href="<?=$cdn_url?>Common/Live/main.css?v=<?=$version?>">
</head>
<body>
<div class="live" ng-controller="LobbiesCtrl" >
    <ul>
        <li class="AGIN">
            <div class="header"></div>
            <div class="main" ng-click="toLive('AGIN')"></div>
            <div class="bottom">全网唯一日本AV女郎发牌</div>
        </li>
        <li class="AGQ">
            <div class="header"></div>
            <div class="main" ng-click="toLive('AG')"></div>
            <div class="bottom">更加刺激快速的游戏体验</div>
        </li>
        <li class="BG">
            <div class="header"></div>
            <div class="main" ng-click="toLive('BGLIVE')"></div>
            <div class="bottom">线上与线下的完美结合</div>
        </li>
        <li class="SB">
            <div class="header"></div>
            <div class="main" ng-click="toLive('SB')"></div>
            <div class="bottom">最专业完善的娱乐平台</div>
        </li>        
        <li class="OG">
            <div class="header"></div>
            <div class="main" ng-click="toLive('OG2')"></div>
            <div class="bottom">东南亚最大赌场舒适体验</div>
        </li>
        <li class="DG">
            <div class="header"></div>
            <div class="main" ng-click="toLive('DG')"></div>
            <div class="bottom">美女荷官感官刺激</div>
        </li>
        <li class="MAYA">
            <div class="header"></div>
            <div class="main" ng-click="toLive('MAYA')"></div>
            <div class="bottom">如亲临澳门般享受</div>
        </li>
        <li class="BBIN">
            <div class="header"></div>
            <div class="main" ng-click="toLive('BBIN2&gameType=live')"></div>
            <div class="bottom">亚洲最大的娱乐博彩集团</div>
        </li>
        <li class="upcoming"></li>
        <!--li class="upcoming"></li-->
    </ul>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.js"></script>
    <script type="text/javascript" src="/skin/layer/layer.js"></script>
<script src="https://cdn.jsdelivr.net/npm/angular@1.6.9/angular.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/angular-animate@1.6.9/angular-animate.min.js" type="text/javascript"></script>
<script src="/Common/Script/site.js?v=<?=$version?>" type="text/javascript"></script>
<script src="/Common/Script/services.min.js?v=<?=$version?>" type="text/javascript"></script>
<script src="/Common/Script/controllers.min.js?v=<?=$version?>" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/pym.js@1.3.2/dist/pym.v1.min.js"></script>
<script>var pymChild = new pym.Child();</script>
</body>
</html>



