angular.module("lobbyNav", []).factory("LobbyNavService", ["$window", "$location",
    function(n, t) {
        return {
            name:'game',
            islogin: false,
			checkLogin: function(){
                $.ajaxSettings.async = false;
                var _self = this;
				$.getJSON("/top_money_data.php?callback=?", function(json){
                    if(json.status!=1){
                        var param = {type: 2,title: false,shadeClose: true,scrollbar: false,resize: false,shade: 0.8,area: ['400px', '560px'],content: '/login2.php'};
                        if(parent.location == top.location){
                            layer.open(param);
                        }else if(parent.parent.location == top.location){
                            parent.layer.open(param);
                        }else if(parent.parent.parent.location == top.location){
                            parent.parent.layer.open(param);
                        }else{
                            layer.open(param);
                        }
                    }else{
                        _self.islogin = true;
                    }
                });
			},
            open: function(url,w,h){
                if(url.search(/cj\/live\//i) >= 0 && url.search(/try=true/i) == -1){
                    this.checkLogin();
                    if(!this.islogin) return false;
                }        
                var iWidth= w || 1300;
                var iHeight= h || 960;
                var iTop = (window.screen.availHeight - 30 - iHeight) / 2; 
                var iLeft = (window.screen.availWidth - 10 - iWidth) / 2; 
                window.open(url,this.name,'height=' + iHeight + ',,innerHeight=' + iHeight + ',width=' + iWidth + ',innerWidth=' + iWidth + ',top=' + iTop + ',left=' + iLeft + ',status=no,toolbar=no,menubar=no,location=no,resizable=no,scrollbars=0,titlebar=no');
                
            },
            iopen: function(url) {
                if(url.search(/cj\/live\//i) >= 0 && url.search(/try=true/i) == -1){
                    this.checkLogin();
                    if(!this.islogin) return false;
                }
                window.open(url, "_blank");
            }
        }
    }
]);
angular.module("reviewGame",[]).factory('ReviewGameService', function(){
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