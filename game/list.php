<?php 
session_start();
$game = strtolower($_GET['g']);
$cdn_url = '//cdn.fox008.cc/';
$version = '20180614';
$list = ['mg', 'cq9', 'kg', 'mw','xin', 'pt', 'yoplay', 'bg', 'pt2', 'ky', 'bbin'];
$configs = [
	'mg'=>[
		'logo'=> $cdn_url . 'Common/SlotCasino/MG2/logo.png',
		'name'=>'MG',
		'title'=>'MG电子',
		'css'=> $cdn_url . '/Common/SlotCasino/MgHtml.css'
	],
	'cq9'=>[
		'logo'=>$cdn_url . 'Common/SlotCasino/CQ9/logo.png',
		'name'=>'CQ9',
		'title'=>'CQ9电子',
		'css'=> $cdn_url . '/Common/SlotCasino/Cq9Html.css'
	],
	'kg'=>[
		'logo'=>$cdn_url . 'Common/SlotCasino/KG/logo.png',
		'name'=>'KG',
		'title'=>'AV电子',
		'css'=>$cdn_url . '/Common/SlotCasino/KgHtml.css'
	],
	'mw'=>[
		'logo'=>$cdn_url . 'Common/SlotCasino/MW/logo.png',
		'name'=>'MW',
		'title'=>'MW电子',
		'css'=>$cdn_url . '/Common/SlotCasino/MwHtml.css'
	],
	'xin'=>[
		'logo'=>$cdn_url . 'Common/SlotCasino/XIN/logo.png',
		'name'=>'XIN',
		'title'=>'XIN电子',
		'css'=>$cdn_url . '/Common/SlotCasino/MwHtml.css'
	],
	'pt'=>[
		'logo'=>$cdn_url . 'Common/SlotCasino/PT/logo.png',
		'name'=>'PT',
		'title'=>'PT电子',
		'css'=>$cdn_url . '/Common/SlotCasino/PtHtml.css'
	],
	'yoplay'=>[
		'logo'=>$cdn_url . 'Common/SlotCasino/YOPLAY/logo.png',
		'name'=>'YOPLAY',
		'title'=>'街机电子',
		'css'=>$cdn_url . '/Common/SlotCasino/YoplayHtml.css'
	],
	'bg'=>[
		'logo'=>$cdn_url . 'Common/SlotCasino/BG/logo.png',
		'name'=>'BG',
		'title'=>'BG电子',
		'css'=>$cdn_url . '/Common/SlotCasino/BgHtml.css'
	],
	'pt2'=>[
		'logo'=>$cdn_url . 'Common/SlotCasino/PT2/logo.png',
		'name'=>'PT2',
		'title'=>'新PT电子',
		'css'=>$cdn_url . '/Common/SlotCasino/PtHtml.css'
	],
	'ky'=>[
		'logo'=>$cdn_url . 'Common/SlotCasino/KY/logo.png',
		'name'=>'KY',
		'title'=>'开元棋牌',
		'css'=>$cdn_url . '/Common/SlotCasino/KyHtml.css'
	],
	'bbin'=>[
		'logo'=>$cdn_url . 'Common/SlotCasino/BBIN/logo.png',
		'name'=>'BBIN2',
		'title'=>'BBIN电子',
		'css'=>$cdn_url . '/Common/SlotCasino/BbinHtml.css'
	],
];

if(!in_array($game ,$list)) die('GAME TYPE ERROR!!!');
$config = $configs[$game];
?><!DOCTYPE html>
<html ng-app="gameApp">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
	    <title><?=$config['title']?></title>
	    <link href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" href="<?=$cdn_url?>Common/SlotCasino/Common.css?v=<?=$version?>">
		<link rel="stylesheet" href="<?=$config['css']?>?v=<?=$version?>">
	</head>
	<body  ng-init="GameGroupName='<?=$config['name']?>'; GameCount=15; Mobile=false; IsLogin=<?=$_SESSION['uid']?'true':'false'?>">
	<div ng-controller="SlotGame">
		<header id="header">
	        <div class="wrapper">
	            <div id="logo"><a href=""><img src="<?=$configs[$game]['logo']?>" /></a></div>
	            <div id="search">
	                <form ng-submit="gamelist(0,0)">
	                    <input type="text" ng-model="gamesearch" placeholder="请输入游戏名称..." />
	                    <button id="search-btn" type="submit" title="搜寻"><i class="fa fa-search"></i></button>
	                </form>
	            </div>
	        </div>
	    </header>
	    <nav>
	        <div class="wrapper">
	            <ul id="game-nav">
	                <li ng-repeat="sort in sorts" ng-cloak ng-class="{ 'active' : navActive(sort.ChildList) == true || sort.CategoryKey === searchItem.CategoryKey }">
	                    <span ng-click="gamelist(0,sort.CategoryKey)">
	                        {{sort.DisplayName}}
	                        <i class="fa fa-caret-down" ng-if="sort.ChildList.length > 0"></i>
	                    </span>
	                    <ol class="subnav" ng-if="sort.ChildList.length > 0">
	                        <li ng-repeat="cate in sort.ChildList" ng-click="gamelist(0,cate.CategoryKey)">
	                            {{cate.DisplayName}}
	                        </li>
	                    </ol>
	                </li>
	            </ul>
	        </div>
	    </nav>
	    <div id="content" class="wrapper mg">
            <a id="banner" ng-href="{{slotBanner.Link}}" target="_blank">
                <img ng-src="{{slotBanner.ImgPath}}" ng-show="slotBanner.ImgPath" onerror="this.style.display = 'none'" />
            </a>
            <ul id="game-list" ng-class="{true:'',false:'try'}[IsLogin]">
                <li ng-repeat="game in games" ng-cloak>
                    <img ng-repeat="icon in game.ImagePlus" ng-src="{{icon.ImageFilePath}}" class="icon icon0{{icon.Position}}" />
                    <div class="game-logo" ng-click="toSlotGame(game.id)">
                        <img ng-src="{{game.ButtonImagePath}}" onerror="this.src =  '<?=$cdn_url?>Common/SlotCasino/<?=$configs[$game]['name']?>/default.png';" />
                        <div class="game-text" title="{{game.DisplayName}}">{{game.name}}</div>
                    </div>
                </li>
            </ul>
            <ul id="pager" ng-cloak>
                <li ng-click="startPage()">&lt;&lt;</li>
                <li ng-click="prevPage()">&lt;</li>
                <li><span ng-bind="currentPage+1"></span>/<span ng-bind="pageCount()"></span></li>
                <li ng-click="nextPage()">&gt;</li>
                <li ng-click="endPage()">&gt;&gt;</li>
            </ul>
        </div>
    </div>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.2.1/dist/jquery.min.js"></script>
		<script type="text/javascript" src="/skin/layer/layer.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/angular@1.6.9/angular.min.js" type="text/javascript"></script>
		<script src="https://cdn.jsdelivr.net/npm/angular-animate@1.6.9/angular-animate.min.js" type="text/javascript"></script>
		<script type="text/javascript">var cdn_url = '<?=$cdn_url?>';var app = angular.module("gameApp",['reviewGame','lobbyNav']);</script>
		<script src="/Common/Script/services.min.js?v=<?=$version?>" type="text/javascript"></script>
		<script src="/Common/Script/controllers.min.js?v=<?=$version?>" type="text/javascript"></script>
	</body>
 </html>