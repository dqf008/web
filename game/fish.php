<?php 
session_start();
$cdn_url = "//cdn.fox008.cc/";
$version = '20180614';
?><!DOCTYPE html>
<html ng-app="gameApp">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
	    <title><?=$config['title']?></title>
	    <link href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" href="<?=$cdn_url?>Common/SlotCasino/Fish.css">
	</head>
	<body ng-controller="Fish" ng-init="GameGroupName='FISH'">
    <div class="fish-game">
        <div id="logo"></div>
        <ul id="game-list">
            <li ng-repeat="game in games">
                <div ng-click="toFishGame(game.url)">
                    <img ng-src="{{game.ButtonImagePath}}" />
                    <div class="game-text">{{game.name}}</div>
                </div>
            </li>
        </ul>
        
        <div ng-if="loading" class="loading">
            载入中
            <i class="fa fa-spinner fa-spin"></i>
        </div>
    </div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.js"></script>
	<script type="text/javascript" src="/skin/layer/layer.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.2.1/dist/jquery.min.js" type="text/javascript"></script>
	<script src="https://cdn.jsdelivr.net/npm/angular@1.6.9/angular.min.js" type="text/javascript"></script>
	<script src="https://cdn.jsdelivr.net/npm/angular-animate@1.6.9/angular-animate.min.js" type="text/javascript"></script>
	<script src="/Common/Script/services.min.js?v=<?=$version?>" type="text/javascript"></script>
	<script type="text/javascript">
	angular.module("gameApp",['reviewGame','lobbyNav']);
	angular.module("reviewGame",[]);
	angular.module("gameApp").controller("Fish", ["$scope", "$http", 'LobbyNavService',
	    function (n, t, i) {
	       	n.cdn_url = '<?=$cdn_url?>';
	        n.games = [];
	        n.loading = !0;
	        t.get("<?=$cdn_url?>Common/SlotCasinoData/FISH2.json?v=<?=$version?>",{GameType:'FISH'}).then(function(t){
	        	for(var i in t.data){
	        		t.data[i].ButtonImagePath = n.cdn_url + t.data[i].ButtonImagePath;
	        		n.games.push(t.data[i])
	        	}
                //n.games = t.data;
                n.loading = !1;
	        });
	        n.toFishGame = function (u) {
	            i.open(u)
	        };
	    }
	]);
	
	angular.module("reviewGame").factory('ReviewGameService', function(){
		return {
			view: function (data, searchItem, currentPage, pageSize){
				var pattern = new RegExp(searchItem.NameKeyword);
				var items = [];
		        var count = 0;
		        for(var i in data){
		        	var game = data[i];
		        	if(searchItem.CategoryKey !== 0){
		        		var inArray = false;
		        		for(var f in game.CategoryKey){
		        			if(game.CategoryKey[f] === searchItem.CategoryKey) inArray = true;
		        		}
						if(!inArray) continue;
		        	} 
					if(searchItem.NameKeyword !== '' && !pattern.test(game.name)) continue;
					var s = (currentPage ) * pageSize;
					var e = s + pageSize;
					if(count>=s && count<e) items.push(game);	
					count++;
		    	} 
		    	var size = Math.ceil(count / pageSize);
		    	return {'allCount':count,'pageCount':size,'games':items};
			}
		};
		
	});
	</script>
	</body>
 </html>