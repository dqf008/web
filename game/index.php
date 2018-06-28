<?php
	session_start();
	$cdn_url = '//cdn.fox008.cc/';
	$version = '20180614';
?><!DOCTYPE html>
<html id="ng-app" ng-app="portalApp" >
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
	    <title><?=$config['title']?></title>
	    <link href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" rel="stylesheet">
	    <link href="<?=$cdn_url?>Common/SlotCasino/Game.css?v=<?=$version?>" rel="stylesheet">
</head>
<body>
	<div class="wrapper">
		<section id="lobby" ng-controller="LobbiesCtrl" ng-init="show='mg'">
		    <ul class="game-list">
		        <li game-box="mg" ng-click="toMg()" ng-mouseover="show='mg'">新MG电子<div>MG CASINO</div></li>
		    	<li game-box="pt" ng-click="toPt2()" ng-mouseover="show='pt'">新PT电子<div>PT CASINO</div></li>
		        <li game-box="cq9" ng-click="toCq9()" ng-mouseover="show='cq9'">传奇电子<div>CQ9 CASINO</div></li>
		        <li game-box="mw" ng-click="toMw()" ng-mouseover="show='mw'">MW电子<div>MW CASINO</div></li>
		        <li game-box="fish" ng-click="toFish()" ng-mouseover="show='fish'">捕鱼达人<div>FISH HUNTER</div></li>
		        <li game-box="xin" ng-click="toXin()" ng-mouseover="show='xin'">XIN电子<div>XIN CASINO</div></li>
		    </ul>
		    <ul class="game-list">
		        <li game-box="yoplay" ng-click="toYoplay()" ng-mouseover="show='yoplay'">街机电子<div>YOPLAY CASINO</div></li>
		        <li game-box="bg" ng-click="toBg()" ng-mouseover="show='bg'">BG电子<div>BG CASINO</div></li>
		        <li game-box="kg" ng-click="toKg()" ng-mouseover="show='kg'">女优电子<div>AV CASINO</div></li>
		        <li game-box="bb" ng-click="toBb2()" ng-mouseover="show='bb'">BBIN电子<div>BBIN CASINO</div></li>
				<li game-box="ky" ng-click="toKy()" ng-mouseover="show='ky'">开元棋牌<div>KY CASINO</div></li>
				<li game-box="mg" ng-click="toZh()">MG电子<div>MG CASINO</div></li>
		        <!--li game-box="more">敬请期待<div>COMING</div></li-->
		    </ul>
		    <!--ul class="game-list">
		        
		        <li game-box="more">敬请期待<div>COMING</div></li>
		        <li game-box="more">敬请期待<div>COMING</div></li>
		        <li game-box="more">敬请期待<div>COMING</div></li>
		        <li game-box="more">敬请期待<div>COMING</div></li>
		    </ul-->
		    <div data-pym-src="/game/list.php?g=bbin" ng-show="show=='bb'" ng-cloak></div>
		    <div data-pym-src="/game/list.php?g=mg" ng-show="show=='mg'" ng-cloak></div>
		    <div data-pym-src="/game/list.php?g=cq9" ng-show="show=='cq9'" ng-cloak></div>
		    <div data-pym-src="/game/list.php?g=mw" ng-show="show=='mw'" ng-cloak></div>
		    <div data-pym-src="/game/list.php?g=kg" ng-show="show=='kg'" ng-cloak></div>
		    <div data-pym-src="/game/list.php?g=pt2" ng-show="show=='pt'" ng-cloak></div>
		    <div data-pym-src="/game/fish.php" ng-show="show=='fish'" ng-cloak></div>
		    <div data-pym-src="/game/list.php?g=xin" ng-show="show=='xin'" ng-cloak></div>
		    <div data-pym-src="/game/list.php?g=yoplay" ng-show="show=='yoplay'" ng-cloak></div>
		    <div data-pym-src="/game/list.php?g=bg" ng-show="show=='bg'" ng-cloak></div>
		    <div data-pym-src="/game/list.php?g=ky" ng-show="show=='ky'" ng-cloak></div>
		</section>
	</div>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.2.1/dist/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/angular@1.6.9/angular.min.js" type="text/javascript"></script>
	<script src="https://cdn.jsdelivr.net/npm/angular-animate@1.6.9/angular-animate.min.js" type="text/javascript"></script>
	<script src="/Common/Script/site.js?v=<?=$version?>" type="text/javascript"></script>
	<script src="/Common/Script/services.min.js?v=<?=$version?>" type="text/javascript"></script>
	<script src="/Common/Script/controllers.min.js?v=<?=$version?>" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/pym.js@1.3.2/dist/pym-loader.v1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pym.js@1.3.2/dist/pym.v1.min.js"></script>
    <script>
        var pymChild = new pym.Child();$(function(){pymChild.sendHeight()})
    </script>
</body>
</html>