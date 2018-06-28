angular.module('ionicz.lottery')

    .controller('BaseCtrl', ['$scope', '$rootScope', '$state', '$interval', 'Tools', function($scope, $rootScope, $state, $interval, Tools) {
        $scope.timer = {};

        $scope.$on('$ionicView.afterEnter', function() {
            var timer = (new Date()).getTime();
            $rootScope.appData.lottery = $rootScope.appData.lottery || {};
            if(!$rootScope.appData.lottery.gameList||$rootScope.appData.lottery.cacheTime<timer){
                $scope.gameList = {};
                Tools.ajax({
                    method: 'POST',
                    url: 'ajax.php',
                    params: {
                        action: "lottery",
                        type: "list"
                    },
                    success: function(data) {
                        if(data.status&&data.status==1){
                            var url;
                            for(var prop in data.msg){
                                if(prop=="pk10" || prop=="jssc" || prop=="xyft"){
                                    url = "#/lottery/index/"+prop+"";
                                    $("ul.ion_menu li.pk10 .ion_box").append("<ion-item nav-clear menu-close href='"+url+"'><a class='item-content ng-binding' ng-href='"+url+"' href='"+url+"'>"+data.msg[prop].name+"</a></ion-item>")
                                }else if(prop.length>3 && prop.substr(-3)=="ssc"){
                                    url = "#/lottery/index/"+prop+"";
                                    $("ul.ion_menu li.ssc .ion_box").append("<ion-item nav-clear menu-close href='"+url+"'><a class='item-content ng-binding' ng-href='"+url+"' href='"+url+"'>"+data.msg[prop].name+"</a></ion-item>")
                                }else if(prop=="marksix" || prop=="jslh"){
                                    url = "#/lottery/index/"+prop+"";
                                    $("ul.ion_menu li.lhc .ion_box").append("<ion-item nav-clear menu-close href='"+url+"'><a class='item-content ng-binding' ng-href='"+url+"' href='"+url+"'>"+data.msg[prop].name+"</a></ion-item>")
                                }else if(prop.substr(-2) == "k3"){
                                    url = "#/lottery/index/"+prop+"";
                                    $("ul.ion_menu li.k3 .ion_box").append("<ion-item nav-clear menu-close href='"+url+"'><a class='item-content ng-binding' ng-href='"+url+"' href='"+url+"'>"+data.msg[prop].name+"</a></ion-item>")
                                }else if(prop.substr(-4) == "kl10"){
                                    url = "#/lottery/index/"+prop+"";
                                    $("ul.ion_menu li.klsf .ion_box").append("<ion-item nav-clear menu-close href='"+url+"'><a class='item-content ng-binding' ng-href='"+url+"' href='"+url+"'>"+data.msg[prop].name+"</a></ion-item>")
                                }else if(prop.substr(-7) == "choose5"){
                                    url = "#/lottery/index/"+prop+"";
                                    $("ul.ion_menu li.choose5 .ion_box").append("<ion-item nav-clear menu-close href='"+url+"'><a class='item-content ng-binding' ng-href='"+url+"' href='"+url+"'>"+data.msg[prop].name+"</a></ion-item>")
                                }else if(prop=="kl8" || prop.substr(-4)=="pcdd"){
                                    url = "#/lottery/index/"+prop+"";
                                    $("ul.ion_menu li.pcdd .ion_box").append("<ion-item nav-clear menu-close href='"+url+"'><a class='item-content ng-binding' ng-href='"+url+"' href='"+url+"'>"+data.msg[prop].name+"</a></ion-item>")
                                }else if(prop.substr(-3) == "qxc"){
                                    url = "#/lottery/index/"+prop+"";
                                    $("ul.ion_menu li.qxc .ion_box").append("<ion-item nav-clear menu-close href='"+url+"'><a class='item-content ng-binding' ng-href='"+url+"' href='"+url+"'>"+data.msg[prop].name+"</a></ion-item>")
                                }else{
                                    url = "#/lottery/index/"+prop+"";
                                    $("ul.ion_menu li.other .ion_box").append("<ion-item nav-clear menu-close href='"+url+"'><a class='item-content ng-binding' ng-href='"+url+"' href='"+url+"'>"+data.msg[prop].name+"</a></ion-item>")
                                }
                            }
                            $scope.gameList = data.msg;
                            $rootScope.appData.lottery.gameList = data.msg;
                            $rootScope.appData.lottery.cacheTime = timer+300000;
                            if ($state.current.url != '/list') {
                                $scope.$broadcast('lotteryGameListLoaded', $state);
                            }
                        }
                    }
                });
            }else{
                var url,gameList=$rootScope.appData.lottery.gameList;
                for(var prop in gameList){
                    if(prop=="pk10" || prop=="jssc" || prop=="xyft"){
                        url = "#/lottery/index/"+prop+"";
                        $("ul.ion_menu li.pk10 .ion_box").append("<ion-item nav-clear menu-close href='"+url+"'><a class='item-content ng-binding' ng-href='"+url+"' href='"+url+"'>"+gameList[prop].name+"</a></ion-item>")
                    }else if(prop.length>3 && prop.substr(-3)=="ssc"){
                        url = "#/lottery/index/"+prop+"";
                        $("ul.ion_menu li.ssc .ion_box").append("<ion-item nav-clear menu-close href='"+url+"'><a class='item-content ng-binding' ng-href='"+url+"' href='"+url+"'>"+gameList[prop].name+"</a></ion-item>")
                    }else if(prop=="marksix" || prop=="jslh"){
                        url = "#/lottery/index/"+prop+"";
                        $("ul.ion_menu li.lhc .ion_box").append("<ion-item nav-clear menu-close href='"+url+"'><a class='item-content ng-binding' ng-href='"+url+"' href='"+url+"'>"+gameList[prop].name+"</a></ion-item>")
                    }else if(prop.substr(-2) == "k3"){
                        url = "#/lottery/index/"+prop+"";
                        $("ul.ion_menu li.k3 .ion_box").append("<ion-item nav-clear menu-close href='"+url+"'><a class='item-content ng-binding' ng-href='"+url+"' href='"+url+"'>"+gameList[prop].name+"</a></ion-item>")
                    }else if(prop.substr(-4) == "kl10"){
                        url = "#/lottery/index/"+prop+"";
                        $("ul.ion_menu li.klsf .ion_box").append("<ion-item nav-clear menu-close href='"+url+"'><a class='item-content ng-binding' ng-href='"+url+"' href='"+url+"'>"+gameList[prop].name+"</a></ion-item>")
                    }else if(prop.substr(-7) == "choose5"){
                        url = "#/lottery/index/"+prop+"";
                        $("ul.ion_menu li.choose5 .ion_box").append("<ion-item nav-clear menu-close href='"+url+"'><a class='item-content ng-binding' ng-href='"+url+"' href='"+url+"'>"+gameList[prop].name+"</a></ion-item>")
                    }else if(prop=="kl8" || prop.substr(-4)=="pcdd"){
                        url = "#/lottery/index/"+prop+"";
                        $("ul.ion_menu li.pcdd .ion_box").append("<ion-item nav-clear menu-close href='"+url+"'><a class='item-content ng-binding' ng-href='"+url+"' href='"+url+"'>"+gameList[prop].name+"</a></ion-item>")
                    }else if(prop.substr(-3) == "qxc"){
                        url = "#/lottery/index/"+prop+"";
                        $("ul.ion_menu li.qxc .ion_box").append("<ion-item nav-clear menu-close href='"+url+"'><a class='item-content ng-binding' ng-href='"+url+"' href='"+url+"'>"+gameList[prop].name+"</a></ion-item>")
                    }else{
                        url = "#/lottery/index/"+prop+"";
                        $("ul.ion_menu li.other .ion_box").append("<ion-item nav-clear menu-close href='"+url+"'><a class='item-content ng-binding' ng-href='"+url+"' href='"+url+"'>"+gameList[prop].name+"</a></ion-item>")
                    }
                }
                $scope.gameList = $rootScope.appData.lottery.gameList;
                if ($state.current.url != '/list') {
                    $scope.$broadcast('lotteryGameListLoaded', $state);
                }
            }
        });

        $scope.$on('lotteryUpdate', function(event, type){
            $scope.$broadcast('lotteryUpdate'+type, $state);
        });
        // Lottery.init();

        // $scope.gameList = Lottery.getGameList();
        $scope.back = Tools.back('/lottery/list');

        $scope.startTimer = function(names, fun, duration, checkName, prefix) {
            var scopeName = (prefix || '')+(checkName || 'default');
            $scope.timer[scopeName] = $scope.timer[scopeName] || {};
            return $scope.stopTimer(checkName, prefix, names), !checkName||checkName==$state.current.name?(fun(), $scope.timer[scopeName][names.toString()] = $interval(function(){!checkName||checkName==$state.current.name?fun():$scope.stopTimer(checkName, prefix, names)}, duration)):$scope.stopTimer(checkName, prefix, names);
        };

        $scope.stopTimer = function(scopeName, prefix, names) {
            scopeName = (prefix || '')+(scopeName || 'default');
            $scope.timer[scopeName] = $scope.timer[scopeName] || {};
            !names ? angular.forEach($scope.timer[scopeName], function(timer){
                $interval.cancel(timer);
            }) : $interval.cancel($scope.timer[scopeName][names.toString()]);;
        };

        $scope.$on('$destroy', function(event) {
            angular.forEach($scope.timer, function(timer){
                angular.forEach(timer, function(e){
                    $interval.cancel(e);
                });
            });
        });
    }])

    .controller('ListCtrl', ['$scope', '$window', '$log', '$filter', '$ionicPopover', '$ionicScrollDelegate', '$state', 'Tools', function($scope, $window, $log, $filter, $ionicPopover, $ionicScrollDelegate, $state, Tools) {
        var curName = angular.copy($state.current.name);

        $log.debug("ListCtrl...");

        $scope.texts = {};
        $scope.NotCountSum = {};

        $ionicPopover.fromTemplateUrl('views/lottery/templates/list-poper.html?v=' + window.templateVersion, {
            scope: $scope
        }).then(function(popover) {
            $scope.popover = popover;
        });

        $scope.showPoper = function($event) {
            $scope.countMoneyState = 1;
            $scope.unbalancedMoney = 0;
            angular.forEach($scope.NotCountSum, function(money){
                $scope.unbalancedMoney+= money;
            });
            $scope.popover.show($event);
        };

        $scope.isSscChange = false;
        $scope.sscCurrentType = 'down';
        $scope.sscIsShow = true;
        $scope.isPkChange = false;
        $scope.pkCurrentType = 'down';
        $scope.pkIsShow = true;
        $scope.isK3Change = false;
        $scope.k3CurrentType = 'down';
        $scope.k3IsShow = true;
        $scope.isChoose5Change = false;
        $scope.choose5CurrentType = 'down';
        $scope.choose5IsShow = true;
        $scope.isKlChange = false;
        $scope.klCurrentType = 'down';
        $scope.klIsShow = true;
        $scope.isKl8Change = false;
        $scope.kl8CurrentType = 'down';
        $scope.kl8IsShow = true;
        $scope.isQxcChange = false;
        $scope.qxcCurrentType = 'down';
        $scope.qxcIsShow = true;
        $scope.isLhcChange = false;
        $scope.lhcCurrentType = 'down';
        $scope.lhcIsShow = true;
        $scope.isOtherChange = false;
        $scope.otherCurrentType = 'down';
        $scope.otherIsShow = true;
        $scope.isExtend = function (type) {
            switch (type) {
                case 'ssc':
                    $scope.isSscChange = !$scope.isSscChange;
                    $scope.sscCurrentType = $scope.isSscChange ? 'left' : 'down';
                    $scope.sscIsShow = $scope.sscIsShow ? false : true;
                    break;
                case 'pk':
                    $scope.isPkChange = !$scope.isPkChange;
                    $scope.pkCurrentType = $scope.isPkChange ? 'left' : 'down';
                    $scope.pkIsShow = $scope.pkIsShow ? false : true;
                    break;
                case 'k3':
                    $scope.isK3Change = !$scope.isK3Change;
                    $scope.k3CurrentType = $scope.isK3Change ? 'left' : 'down';
                    $scope.k3IsShow = $scope.k3IsShow ? false : true;
                    break;
                case 'choose5':
                    $scope.isChoose5Change = !$scope.isChoose5Change;
                    $scope.choose5CurrentType = $scope.isChoose5Change ? 'left' : 'down';
                    $scope.choose5IsShow = $scope.choose5IsShow ? false : true;
                    break;
                case 'kl':
                    $scope.isKlChange = !$scope.isKlChange;
                    $scope.klCurrentType = $scope.isKlChange ? 'left' : 'down';
                    $scope.klIsShow = $scope.klIsShow ? false : true;
                    break;
                case 'kl8':
                    $scope.isKl8Change = !$scope.isKl8Change;
                    $scope.kl8CurrentType = $scope.isKl8Change ? 'left' : 'down';
                    $scope.kl8IsShow = $scope.kl8IsShow ? false : true;
                    break;
                case 'qxc':
                    $scope.isQxcChange = !$scope.isQxcChange;
                    $scope.qxcCurrentType = $scope.isQxcChange ? 'left' : 'down';
                    $scope.qxcIsShow = $scope.qxcIsShow ? false : true;
                    break;

                case 'lhc':
                    $scope.isLhcChange = !$scope.isLhcChange;
                    $scope.lhcCurrentType = $scope.isLhcChange ? 'left' : 'down';
                    $scope.lhcIsShow = $scope.lhcIsShow ? false : true;
                    break;
                case 'other':
                    $scope.isOtherChange = !$scope.isOtherChange;
                    $scope.otherCurrentType = $scope.isOtherChange ? 'left' : 'down';
                    $scope.otherIsShow = $scope.otherIsShow ? false : true;
                    break;
                default:
                    break;
            }
            $ionicScrollDelegate.resize();
        };

        $scope.$on('lotteryGameListLoaded', function($event, state){
            var getGameInfo = function(gameId){
                $scope.stopTimer(curName, undefined, ['countDown', gameId]);
                Tools.ajax({
                    method: 'POST',
                    url: '../lot/ajax.php',
                    params: {
                        action: "info",
                        type: "balance",
                        lotteryId: gameId
                    },
                    dataType: "json",
                    success: function(data) {
                        if(data.Success&&data.Success==1){
                            $scope.NotCountSum[gameId] = parseFloat(data.Obj.NotCountSum);
                            data.Obj.OpenCount>0 ? (data.Obj.OpenCount = data.Obj.OpenCount+5, $scope.startTimer(['countDown', gameId], function(){
                                $scope.texts[gameId] = $filter('tick')(data.Obj.OpenCount, '00:00');
                                if(data.Obj.OpenCount<=0){
                                    $scope.stopTimer(curName, undefined, ['timer', gameId]);
                                    $scope.startTimer(['timer', gameId], function(){
                                        getGameInfo(gameId)
                                    }, 10000, curName);
                                }
                                data.Obj.OpenCount--;
                            }, 1000, curName)) : ($scope.texts[gameId] = '已封盘');
                        }
                    }
                });
            };
            state.current.name==curName&&angular.forEach($scope.gameList, function(game, gameId){
                if(game.open==1){
                    $scope.startTimer(['timer', gameId], function(){
                        getGameInfo(gameId)
                    }, 10000, curName);
                }else{
                    $scope.texts[gameId] = '维护中';
                }
            });
        });

        /*var mainTimer = $interval(function() {
            $scope.$broadcast('lotteryListTimer');
        }, 10000);*/

        $scope.$on('$destroy', function() {
            $log.debug('游戏大厅Ctrl销毁，发送广播消息，用于触发销毁定时器');
            // 游戏Ctrl销毁，发送广播消息，用于触发销毁定时器
            $scope.$broadcast('lotteryListDestroy');
            $scope.popover.remove();
            $scope.stopTimer(curName);
        });

    }])

    .controller('LotteryCtrl', ['$scope', '$timeout', '$log', '$filter', '$stateParams', '$ionicPopover', '$location', '$interpolate', '$ionicScrollDelegate', '$document', '$state', 'Tools', 'My', 'PATH', function($scope, $timeout, $log, $filter, $stateParams, $ionicPopover, $location, $interpolate, $ionicScrollDelegate, $document, $state, Tools, My, PATH) {
        var curName = angular.copy($state.current.name);
        $log.debug("LotteryCtrl...");

        $scope.shareData = {
            betCount: 0, // 当前下注总数
            lotteryState: 1
        };

        $scope.betData = {};
        $scope.betContent = {};
        $scope.curGame = {};
        $scope.gameId = $stateParams.gameId;
        $scope.$on('$destroy', function() {
            $log.debug('游戏Ctrl销毁，发送广播消息，用于触发销毁定时器');
            // 游戏Ctrl销毁，发送广播消息，用于触发销毁定时器
            $scope.popover.remove();
            $scope.stopTimer(curName, $scope.gameId);
            $scope.$broadcast('lotteryDestroy');
        });

        $scope.$on('lotteryGameListLoaded', function($event, state){
            if(!$scope.gameList[$scope.gameId]){
                Tools.alert('请从有效地址进入');
                $location.path('/lottery/list');
            }else if(state.params.gameId==$scope.gameId){
                var getCurrGameInfo = function(){
                    $scope.stopTimer(curName, $scope.gameId, 'countDown');
                    Tools.ajax({
                        method: 'POST',
                        url: '../lot/ajax.php',
                        params: {
                            action: "info",
                            type: "balance",
                            lotteryId: $scope.gameId
                        },
                        dataType: "json",
                        success: function(data) {
                            if(data.Success&&data.Success==1){
                                data.Obj.Lines&&($scope.curGame.odds = data.Obj.Lines);
                                $scope.preIssue = data.Obj.PrePeriodNumber || data.Obj.LotterNo;
                                if ($scope.preIssue) {
                                    $scope.preIssue = $scope.preIssue.toString();
                                    $scope.isJscp()&&($scope.preIssue = '***'+$scope.preIssue.substring($scope.preIssue.length-6));
                                }
                                if(data.Obj.LotterNo&&angular.isArray(data.Obj.PreResult)){
                                    data.Obj.PreResultData = [];
                                    angular.forEach(data.Obj.PreResult, function(result){
                                        data.Obj.PreResultData.push(result.sx);
                                    });
                                    $scope.codeHtml = $filter('formatMarkSix')(data.Obj.PreResult, $scope.curGame.class);
                                    $scope.codeHtml+= $filter('formatMarkSix')(data.Obj.PreResultData, $scope.curGame.subClass);
                                    $scope.curGame.panType&&$scope.$emit('lotteryUpdate', 'GetLines');
                                }else{
                                    $scope.codeHtml = $filter('formatResult')(data.Obj.PreResult, $scope.curGame.class);
                                    if(data.Obj.PreResultData){
                                        $scope.codeHtml+= $filter('formatResult')(data.Obj.PreResultData, $scope.curGame.subClass);
                                    }
                                }
                                $scope.curIssue = data.Obj.CurrentPeriod;
                                $scope.unbalancedMoney = parseFloat(data.Obj.NotCountSum);
                                $scope.totalTotalMoney = parseFloat(data.Obj.WinLoss);
                                data.Obj.OpenCount>0 ? (data.Obj.OpenCount = data.Obj.OpenCount+5, $scope.startTimer('countDown', function(){
                                    $scope.shareData.lotteryState = data.Obj.CloseCount>0 ? 1 : 0;
                                    $scope.shareData.lotteryState ? ($scope.curGame.issue = $scope.curIssue) : ($scope.curGame.issue = null, $scope.reset());
                                    $scope.endTimeHtml = $filter('tick')(data.Obj.CloseCount, '已封盘');
                                    $scope.lotteryTimeHtml = $filter('tick')(data.Obj.OpenCount, '00:00');
                                    $scope.$emit('lotteryUpdate', 'Odds');
                                    if(data.Obj.OpenCount<=0){
                                        $scope.stopTimer(curName, $scope.gameId, 'timer');
                                        $scope.startTimer('timer', getCurrGameInfo, 10000, curName, $scope.gameId);
                                    }
                                    data.Obj.CloseCount--;
                                    data.Obj.OpenCount--;
                                }, 1000, curName, $scope.gameId)) : ($scope.endTimeHtml = '已封盘', $scope.lotteryTimeHtml = '已封盘', $scope.shareData.lotteryState = 0, $scope.reset(), $scope.$emit('lotteryUpdate', 'Odds'));
                            }
                        }
                    });
                };
                $scope.curGame = $scope.gameList[$scope.gameId];
                $scope.curGame.panType = 0;
                $scope.curGame.panLimit = {};
                $scope.curGame.panNumber = [
                    undefined,
                    [10, 20, 30, 40],
                    [1, 11, 21, 31, 41],
                    [2, 12, 22, 32, 42],
                    [3, 13, 23, 33, 43],
                    [4, 14, 24, 34, 44],
                    [5, 15, 25, 35, 45],
                    [6, 16, 26, 36, 46],
                    [7, 17, 27, 37, 47],
                    [8, 18, 28, 38, 48],
                    [9, 19, 29, 39, 49]
                ];
                $scope.shareData.lotteryState = $scope.curGame.open==1 ? 1 : -1;
                $scope.panes = $scope.curGame.panes;
                angular.forEach($scope.panes, function(pane, paneId){
                    $scope.currPane || ($scope.currPane = paneId);
                });

                var k3Lottery = ['jsk3', 'fjk3', 'gxk3', 'ynk3', 'ahk3', 'shk3', 'hbk3', 'hebk3', 'jxk3','bjk3', 'jlk3', 'gzk3', 'gsk3', 'nmgk3', 'hnk3', 'qhk3'];
                var kl10Lottery = ['gdkl10', 'cqkl10', 'tjkl10', 'hnkl10', 'sxkl10', 'ynkl10'];
                var choose5Lottery = ['gdchoose5', 'sdchoose5', 'fjchoose5', 'bjchoose5', 'ahchoose5'];
                var qxcLottery = ['qxc', 'ffqxc', 'wfqxc'];
                var ftLottery = ['xyft', 'jsft'];
                if (k3Lottery.indexOf($scope.gameId) >= 0) {
                    $scope.contentTpl = "views/lottery/templates/k3/" + $scope.currPane + '.html';
                } else if (kl10Lottery.indexOf($scope.gameId) >= 0) {
                    $scope.contentTpl = "views/lottery/templates/kl10/" + $scope.currPane + '.html';
                } else if (choose5Lottery.indexOf($scope.gameId) >= 0) {
                    $scope.contentTpl = "views/lottery/templates/choose5/" + $scope.currPane + '.html';
                } else if (qxcLottery.indexOf($scope.gameId) >= 0) {
                    $scope.contentTpl = "views/lottery/templates/qxc/" + $scope.currPane + '.html';
                } else if (ftLottery.indexOf($scope.gameId) >= 0) {
                    $scope.contentTpl = "views/lottery/templates/xyft/" + $scope.currPane + '.html';
                } else {
                    $scope.contentTpl = "views/lottery/templates/" + $scope.gameId + "/" + $scope.currPane + '.html';
                }
                $scope.contentTpl += '?v=' + window.templateVersion;
                $scope.startTimer('timer', getCurrGameInfo, 10000, curName, $scope.gameId);
                $document[0].title = $scope.curGame.name;
            }
        });

        $scope.$on('lotteryUpdateGetLines', function($event){
            $scope.curGame.panOdds = $scope.curGame.panOdds || [];
            Tools.ajax({
                method: 'POST',
                url: '../lot/ajax.php',
                params: {
                    action: "info",
                    type: "lines",
                    lotteryId: $scope.gameId,
                    lotteryPan: $scope.currPane,
                    panType: $scope.curGame.panType
                },
                dataType: "json",
                success: function(data) {
                    if(data.Success&&data.Success==1){
                        $scope.curGame.panOdds[$scope.curGame.panType] = data.Obj.Lines;
                        $scope.curGame.superOdds = data.Obj.Lines['j'+$scope.curGame.panType+'00'];
                        $scope.curGame.odds = {};
                        angular.forEach($scope.curGame.panOdds, function(lines){
                            angular.forEach(lines, function(odds, oddsId){
                                $scope.curGame.odds[oddsId] = odds;
                            });
                        });
                        $scope.currPane=="lianma"&&Tools.ajax({
                            method: 'POST',
                            url: 'ajax.php',
                            params: {
                                action: "lottery",
                                type: "animal",
                                gameType: $scope.gameId
                            },
                            success: function(data) {
                                if(data.status&&data.status==1){
                                    $scope.curGame.panAnimal = data.msg;
                                }
                            }
                        });
                    }
                }
            });
        });

        $scope.selectCate = function(pane) {
            var reset = $scope.curGame.reset&&($scope.curGame.reset.indexOf(pane)>=0||$scope.curGame.reset.indexOf($scope.currPane)>=0), fun = function(){
                $scope.shareData.elements = !1;
                reset&&$scope.reset();
                var k3Lottery = ['jsk3', 'fjk3', 'gxk3', 'ynk3', 'ahk3', 'shk3', 'hbk3', 'jxk3', 'hebk3', 'bjk3', 'jlk3', 'gzk3', 'gsk3', 'nmgk3', 'hnk3', 'qhk3'];
                var kl10Lottery = ['gdkl10', 'cqkl10', 'tjkl10', 'hnkl10', 'sxkl10', 'ynkl10'];
                var choose5Lottery = ['gdchoose5', 'sdchoose5', 'fjchoose5', 'bjchoose5', 'ahchoose5'];
                var qxcLottery = ['qxc', 'ffqxc', 'wfqxc'];
                var ftLottery = ['xyft', 'jsft'];
                if (k3Lottery.indexOf($scope.gameId) >= 0) {
                    $scope.contentTpl = "views/lottery/templates/k3/" + pane + '.html';
                } else if (kl10Lottery.indexOf($scope.gameId) >= 0) {
                    $scope.contentTpl = "views/lottery/templates/kl10/" + pane + '.html';
                } else if (choose5Lottery.indexOf($scope.gameId) >= 0) {
                    $scope.contentTpl = "views/lottery/templates/choose5/" + pane + '.html';
                } else if (qxcLottery.indexOf($scope.gameId) >= 0) {
                    $scope.contentTpl = "views/lottery/templates/qxc/" + pane + '.html';
                } else if (ftLottery.indexOf($scope.gameId) >= 0) {
                    $scope.contentTpl = "views/lottery/templates/xyft/" + pane + '.html';
                } else {
                    $scope.contentTpl = "views/lottery/templates/" + $scope.gameId + "/" + pane + '.html';
                }
                $scope.contentTpl += '?v=' + window.templateVersion;
                $scope.curGame.panLimit = {};
                $scope.currPane = pane;
            }
            $scope.currPane!=pane&&(reset&&(($scope.betData.betContent&&$scope.betData.betContent.length>0)||($scope.betData[$scope.currPane]&&$scope.betData[$scope.currPane].length>0))?Tools.confirm("需要重置未投注项目才能切换，是否继续？", fun):fun());
        };

        $ionicPopover.fromTemplateUrl('views/lottery/templates/lottery-poper.html?v=' + window.templateVersion, {
            scope: $scope
        }).then(function(popover) {
            $scope.popover = popover;
        });

        $scope.showPoper = function($event) {
            $scope.countMoneyState = 1;
            $scope.popover.show($event);
        };

        $scope.showRole = function() {
            $scope.popover.hide();
            var templateUrl = '';
            var k3Lottery = ['jsk3', 'ahk3', 'gxk3', 'shk3', 'hbk3', 'hebk3', 'fjk3', 'jxk3', 'ynk3', 'bjk3', 'jlk3', 'gzk3', 'gsk3', 'nmgk3', 'hnk3', 'qhk3'];
            var kl10Lottery = ['gdkl10', 'cqkl10', 'tjkl10', 'hnkl10', 'sxkl10', 'ynkl10'];
            var choose5Lottery = ['gdchoose5', 'sdchoose5', 'fjchoose5', 'bjchoose5', 'ahchoose5'];
            var ftLottery = ['xyft', 'jsft'];
            var qxcLottery = ['qxc', 'ffqxc', 'wfqxc'];
            if (k3Lottery.indexOf($scope.gameId) >= 0) {
                templateUrl = "views/lottery/templates/k3/role.html";
            } else if (kl10Lottery.indexOf($scope.gameId) >= 0) {
                templateUrl = "views/lottery/templates/kl10/role.html";
            } else if (choose5Lottery.indexOf($scope.gameId) >= 0) {
                templateUrl = "views/lottery/templates/choose5/role.html";
            } else if (qxcLottery.indexOf($scope.gameId) >= 0) {
                templateUrl = "views/lottery/templates/qxc/role.html";
            } else if (ftLottery.indexOf($scope.gameId) >= 0) {
                if ($scope.gameId == 'jsft') {
                    templateUrl = "views/lottery/templates/xyft/jsft_role.html";
                } else {
                    templateUrl = "views/lottery/templates/xyft/role.html";
                }
            } else {
                templateUrl = "views/lottery/templates/" + $scope.gameId + "/" + 'role.html';
            }
            Tools.modal({
                title: '游戏规则',
                templateUrl: templateUrl+"?v=" + window.templateVersion,
                css: 'role-poput'
            });
        };

        $scope.isJscp = function() {
            return $scope.gameId.substring(0, 2).toLocaleUpperCase()=='JS';
        };

        $scope.isExist = function(dataId) {
            var dataList = $scope.betData[$scope.currPane] || [];
            return dataList.indexOf(dataId)>=0;
        };

        $scope.hasFixed = function() {
            var dataList = $scope.betData.betFixed || [];
            return $scope.curGame.panMode==2&&$scope.curGame.panLimit.min>1&&dataList.length<($scope.curGame.panLimit.min>2?2:1);
        };

        $scope.toggleSelect = function(dataId, panes) {
            var index;
            panes = !panes ? [] : panes.split(',');
            panes.indexOf($scope.currPane)<0&&panes.push($scope.currPane);
            panes.push('betContent');
            $scope.hasFixed()&&panes.push('betFixed');
            $scope.curGame.panType&&panes.push('panContent-'+$scope.curGame.panType);
            angular.forEach(panes, function(pane){
                $scope.betData[pane] = $scope.betData[pane] || [];
                index = $scope.betData[pane].indexOf(dataId);
                if(index>=0){
                    $scope.betData[pane].splice(index, 1);
                }else{
                    $scope.betData[pane].push(dataId);
                }
            });
            switch($scope.currPane){
                case 'guoguan':
                    $scope.betData[$scope.currPane] = [];
                    if($scope.betData.betContent.length>=$scope.curGame.panLimit.min){
                        $scope.shareData.betOdds = 1;
                        $scope.shareData.betCount = 1;
                        $scope.betData[$scope.currPane] = $scope.betData.betContent.concat();
                        angular.forEach($scope.betData.betContent, function(oddsId){
                            $scope.shareData.betOdds*= $scope.curGame.odds[oddsId];
                        });
                        $scope.shareData.betOdds = $scope.shareData.betOdds.toFixed(2);
                        $scope.curTips = $scope.betData.betContent.length+' 串 1 @ '+$scope.shareData.betOdds;
                    }else{
                        $scope.shareData.betCount = 0;
                        $scope.curTips = '请选择过关项目';
                    }
                    break;
                case 'hexiao':
                case 'shengxiaolian':
                case 'weishulian':
                case 'quanbuzhong':
                case 'lianma':
                case 'erzi':
                case 'sanzi':
                case 'ebth':
                case 'sbth':
                    index = 'panContent-'+($scope.curGame.panType || 'default');
                    switch($scope.curGame.panMode){
                        case 5:
                            var temp = [];
                            $scope.betData[index] = [];
                            if($scope.betData.betContent.length==$scope.curGame.panLimit.min){
                                temp.push($scope.betData.betContent[0].substring(1).split(','));
                                temp.push($scope.betData.betContent[1].substring(1).split(','));
                                temp[0] = parseInt(temp[0][1]);
                                temp[1] = parseInt(temp[1][1]);
                                if(temp[0]>12){
                                    temp[2] = temp[0];
                                    temp[0] = temp[1];
                                    temp[1] = temp[2];
                                }
                                temp[1]-= 12;
                                temp[0] = $scope.curGame.panAnimal[temp[0]];
                                temp[1] = $scope.curGame.panNumber[temp[1]];
                                angular.forEach(temp[0], function(id1){
                                    id1 = id1.toString();
                                    id1 = 'j'+$scope.curGame.panType+('00'+id1).substring(id1.length, id1.length+2);
                                    angular.forEach(temp[1], function(id2){
                                        id2 = id2.toString();
                                        id2 = 'j'+$scope.curGame.panType+('00'+id2).substring(id2.length, id2.length+2);
                                        id1!=id2&&$scope.betData[index].push([id1, id2]);
                                    });
                                });
                            }
                            break;
                        case 4:
                            var temp = [];
                            $scope.betData[index] = [];
                            if($scope.betData.betContent.length==$scope.curGame.panLimit.min){
                                temp.push($scope.betData.betContent[0].substring(1).split(','));
                                temp.push($scope.betData.betContent[1].substring(1).split(','));
                                temp[0] = parseInt(temp[0][1]);
                                temp[1] = parseInt(temp[1][1]);
                                temp[0] = temp[0]>10 ? temp[0]-10 : temp[0];
                                temp[1] = temp[1]>10 ? temp[1]-10 : temp[1];
                                if(temp[0]!=temp[1]){
                                    temp[0] = $scope.curGame.panNumber[temp[0]];
                                    temp[1] = $scope.curGame.panNumber[temp[1]];
                                    angular.forEach(temp[0], function(id1){
                                        id1 = id1.toString();
                                        id1 = 'j'+$scope.curGame.panType+('00'+id1).substring(id1.length, id1.length+2);
                                        angular.forEach(temp[1], function(id2){
                                            id2 = id2.toString();
                                            id2 = 'j'+$scope.curGame.panType+('00'+id2).substring(id2.length, id2.length+2);
                                            $scope.betData[index].push([id1, id2]);
                                        });
                                    });
                                }
                            }
                            break;
                        case 3:
                            var temp = [];
                            $scope.betData[index] = [];
                            if($scope.betData.betContent.length==$scope.curGame.panLimit.min){
                                temp.push($scope.betData.betContent[0].substring(1).split(','));
                                temp.push($scope.betData.betContent[1].substring(1).split(','));
                                temp[0] = parseInt(temp[0][1]);
                                temp[1] = parseInt(temp[1][1]);
                                temp[0] = temp[0]>12 ? temp[0]-12 : temp[0];
                                temp[1] = temp[1]>12 ? temp[1]-12 : temp[1];
                                if(temp[0]!=temp[1]){
                                    temp[0] = $scope.curGame.panAnimal[temp[0]];
                                    temp[1] = $scope.curGame.panAnimal[temp[1]];
                                    angular.forEach(temp[0], function(id1){
                                        id1 = id1.toString();
                                        id1 = 'j'+$scope.curGame.panType+('00'+id1).substring(id1.length, id1.length+2);
                                        angular.forEach(temp[1], function(id2){
                                            id2 = id2.toString();
                                            id2 = 'j'+$scope.curGame.panType+('00'+id2).substring(id2.length, id2.length+2);
                                            $scope.betData[index].push([id1, id2]);
                                        });
                                    });
                                }
                            }
                            break;
                        case 2:
                            $scope.betData[index] = [];
                            angular.forEach($scope.betData.betContent, function(oddsId){
                                $scope.betData.betFixed.indexOf(oddsId)>=0||$scope.betData[index].push(oddsId)
                            });
                            $scope.betData[index] = $scope.betData[index].perm($scope.curGame.panLimit.min-$scope.betData.betFixed.length);
                            break;
                        default:
                            $scope.betData[index] = $scope.betData.betContent.perm($scope.curGame.panLimit.min);
                            break;
                    }
                    $scope.betData[$scope.currPane] = $scope.betData[index].length>0 ? $scope.betData.betContent.concat() : [];
                    $scope.shareData.betCount = $scope.betData[index] ? $scope.betData[index].length : 0;
                    break;
                default:
                    $scope.shareData.betCount = $scope.betData.betContent.length;
                    break;
            }
        };

        $scope.reset = function() {
            $scope.betData = {};
            $scope.shareData.odds = [];
            $scope.shareData.betCount = 0;
            $scope.shareData.elements&&(angular.isFunction($scope.shareData.elements.removeClass)?$scope.shareData.elements.removeClass('bet-choose bet-circled bet-disabled'):angular.forEach($scope.shareData.elements, function(e){angular.isFunction(e.removeClass)&&e.removeClass('bet-choose bet-circled bet-disabled')}))
        };

        $scope.bet = function(){
            var confirmHtml, betParams = [], curIssue = $scope.curIssue;
            switch(!0){
                case !$scope.shareData.betCount&&!($scope.betData.betContent&&$scope.betData.betContent.length):
                    Tools.tip('请选择玩法');
                    break;
                case $scope.curGame.panLimit.min&&$scope.betData.betContent.length<$scope.curGame.panLimit.min:
                case $scope.curGame.panLimit.max&&$scope.betData.betContent.length>$scope.curGame.panLimit.max:
                    Tools.tip('只能选择'+($scope.curGame.panLimit.min&&$scope.curGame.panLimit.min<$scope.curGame.panLimit.max?$scope.curGame.panLimit.min+'-':'')+$scope.curGame.panLimit.max+'个号码');
                    break;
                case !$scope.shareData.betMoney||!$scope.shareData.betMoney.match(/^0*[1-9]\d*$/):
                    Tools.tip('请输入投注金额');
                    break;
                default:
                    var betMoney = parseFloat($scope.shareData.betMoney);
                    betParams = {
                        action: "bet",
                        qiHao:$scope.curIssue,
                        lotteryId: $scope.gameId,
                        betParameters:[]
                    };
                    confirmHtml = '<ion-scroll direction="y">';
                    switch($scope.currPane){
                        case 'guoguan':
                            var BetContext = [];
                            confirmHtml+= '<div class="t-blue">' + $scope.curTips + ' X ' + betMoney.toFixed(2) + '</div>';
                            confirmHtml+= '<div class="split-line"></div>';
                            angular.forEach($scope.betData.betContent, function(dataId){
                                var data = $scope.betContent[dataId] || {type: "未知", content: "未知"};
                                $scope.curGame.odds[dataId] = $scope.curGame.odds[dataId] || 0;
                                confirmHtml+= '<div>'+data.type+'【' + data.content + '】@' + $scope.curGame.odds[dataId] + '</div>';
                                BetContext.push({
                                    Id: dataId.substring(1),
                                    Lines: $scope.curGame.odds[dataId],
                                    BetContext: data.type+'【' + data.content + '】@'+$scope.curGame.odds[dataId]
                                });
                            });
                            betParams.betParameters.push({
                                Id: BetContext[0].Id,
                                BetContext: BetContext,
                                Lines: $scope.shareData.betOdds,
                                Money: betMoney
                            });
                            break;
                        case 'hexiao':
                        case 'shengxiaolian':
                        case 'weishulian':
                        case 'quanbuzhong':
                        case 'lianma':
                            var BetContext = [];
                            switch($scope.curGame.panMode){
                                case 5:
                                case 4:
                                case 3:
                                    var index = 'panContent-'+$scope.curGame.panType;
                                    confirmHtml+= '<div>'+$scope.shareData.panTitleText+'【<span class="t-blue">' + $scope.shareData.panFirstText + '</span> 碰 <span class="t-blue">' + $scope.shareData.panEndText + '</span>】</div>';
                                    confirmHtml+= '<div class="split-line"></div>';
                                    angular.forEach($scope.betData[index], function(list){
                                        var data = [];
                                        angular.forEach(list, function(dataId){
                                            var odds, superId = dataId.substring(0, dataId.length-2)+'00';
                                            odds = ($scope.curGame.odds[dataId] || $scope.curGame.odds[superId] || '0').toString().split('/');
                                            odds.length>1||odds.unshift(undefined);
                                            data.push({
                                                Id: dataId.substring(1),
                                                BetContext: ($scope.betContent[dataId] || {content: "未知"}).content,
                                                Lines: odds[1],
                                                SubLines: odds[0]
                                            });
                                        });
                                        BetContext.push(data);
                                    });
                                    break;
                                case 2:
                                    var BetFixed = [], NewContext = [];
                                    angular.forEach($scope.betData.betContent, function(dataId){
                                        var data = $scope.betContent[dataId] || {content: "未知"}, odds, superId = dataId.substring(0, dataId.length-2)+'00';
                                        odds = ($scope.curGame.odds[dataId] || $scope.curGame.odds[superId] || '0').toString().split('/');
                                        odds.length>1||odds.unshift(undefined);
                                        data = {
                                            Id: dataId.substring(1),
                                            BetContext: data.content,
                                            Lines: odds[1],
                                            SubLines: odds[0]
                                        };
                                        $scope.betData.betFixed.indexOf(dataId)>=0 ? BetFixed.push(data) : NewContext.push(data);
                                    });
                                    BetContext = NewContext.perm($scope.curGame.panLimit.min-$scope.betData.betFixed.length);
                                    angular.forEach(BetContext, function(data, index){
                                        BetContext[index] = BetFixed.concat(data);
                                    });
                                    break;
                                default:
                                    angular.forEach($scope.betData.betContent, function(dataId){
                                        var data = $scope.betContent[dataId] || {content: "未知"}, odds, superId = dataId.substring(0, dataId.length-2)+'00';
                                        odds = ($scope.curGame.odds[dataId] || $scope.curGame.odds[superId] || '0').toString().split('/');
                                        odds.length>1||odds.unshift(undefined);
                                        BetContext.push({
                                            Id: dataId.substring(1),
                                            BetContext: data.content,
                                            Lines: odds[1],
                                            SubLines: odds[0]
                                        });
                                    });
                                    BetContext = BetContext.perm($scope.curGame.panLimit.min);
                                    break;
                            }
                            angular.forEach(BetContext, function(data){
                                var type = ($scope.betContent['j'+data[0].Id] || {type: "未知"}).type, content = [], odds = [];
                                angular.forEach(data, function(temp){
                                    content.push(temp.BetContext);
                                    odds.push(temp.Lines);
                                });
                                odds = odds.min();
                                confirmHtml+= '<div>'+type+'【' + content.join(',') + '】@' + odds + ' X ' + betMoney.toFixed(2) + '</div>';
                                betParams.betParameters.push({
                                    Id: data[0].Id,
                                    BetContext: data,
                                    Lines: odds,
                                    Money: betMoney
                                });
                            });
                            break;
                        case 'erzi':
                        case 'sanzi':
                        case 'ebth':
                        case 'sbth':
                            var BetContext = [], superId = 'j'+$scope.curGame.superId, type;
                            angular.forEach($scope.betData.betContent, function(dataId){
                                type = type || ($scope.betContent[dataId] || {type: "未知"}).type;
                                dataId = dataId.split(',')[1].toString();
                                BetContext.indexOf(dataId)>=0||BetContext.push(dataId);
                            });
                            BetContext = BetContext.perm($scope.curGame.panLimit.min);
                            angular.forEach(BetContext, function(data){
                                confirmHtml+= '<div>'+type+'【' + data.join('') + '】@' + $scope.curGame.odds[superId] + ' X ' + betMoney.toFixed(2) + '</div>';
                                betParams.betParameters.push({
                                    Id: $scope.curGame.superId,
                                    BetContext: data.join(''),
                                    Lines: $scope.curGame.odds[superId],
                                    Money: betMoney
                                });
                            });
                            break;
                        case 'yiding':
                        case 'erding':
                        case 'sanding':
                        case 'siding':
                            var BetContext = angular.copy($scope.betData.betContent), superId = 'j'+$scope.curGame.superId, type = ($scope.betContent[superId+',1,0'] || {type: "未知"}).type;
                            angular.forEach(BetContext, function(data){
                                data.splice(4);
                                angular.forEach(data, function(d, i){
                                    data[i] = d.length>0?d.join(''):'*';
                                })
                                confirmHtml+= '<div>'+type+'【' + data.join(',') + '】@' + $scope.curGame.odds[superId] + ' X ' + betMoney.toFixed(2) + '</div>';
                                betParams.betParameters.push({
                                    Id: $scope.curGame.superId,
                                    BetContext: data.join(','),
                                    Lines: $scope.curGame.odds[superId],
                                    Money: betMoney
                                });
                            });
                            break;
                        default:
                            angular.forEach($scope.betData.betContent, function(dataId){
                                var data = $scope.betContent[dataId] || {type: "未知", content: "未知"};
                                $scope.curGame.odds[dataId] = $scope.curGame.odds[dataId] || 0;
                                confirmHtml+= '<div>'+data.type+'【' + data.content + '】@' + $scope.curGame.odds[dataId] + ' X ' + betMoney.toFixed(2) + '</div>';
                                betParams.betParameters.push({
                                    Id: dataId.substring(1),
                                    BetContext: data.content,
                                    Lines: $scope.curGame.odds[dataId],
                                    Money: betMoney,
                                    BetType: 1,
                                    IsTeMa: !1,
                                    IsForNumber: !1
                                });
                            });
                            break;
                    }
                    confirmHtml+= '<div class="split-line"></div>';
                    confirmHtml+= '<div>【合计】总注数：<span class="t-blue" style="margin-right:15px">' + $scope.shareData.betCount + '</span>总金额：<span class="t-blue">' + ($scope.shareData.betCount*betMoney).toFixed(2) + '</span></div>';
                    confirmHtml+= '</ion-scroll>';
                    betParams.betParameters.length>0 ? Tools.modal({
                        title: '下注清单',
                        template: confirmHtml,
                        css: 'lotter-popup',
                        callback: function(scope, popup) {
                            popup.close();
                            curIssue==$scope.curGame.issue ? Tools.ajax({
                                url: '../lot/ajax.php',
                                params: betParams,
                                backdrop: true,
                                dataType: "json",
                                success: function(data) {
                                    if(data.result==1){
                                        $scope.reset();
                                        My.refreshMoney(!1);
                                        Tools.tip(data.msg);
                                    }else if(data.result==9){
                                        var info = $scope.betContent['j'+data.errId] || {type: "未知", content: "未知"};
                                        data.msg = data.msg.replace('{0}', info.type+'【'+info.content+'】');
                                        Tools.alert(['赔率发生变化', data.msg]);
                                    }else{
                                        Tools.tip(data.msg);
                                    }
                                }
                            }) : Tools.tip('已封盘，禁止投注');
                        }
                    }) : Tools.tip('请选择玩法');
                    break;
            }
        };
        $scope.login = function () {
            $location.path(PATH.loginPath);
        }

        !Array.prototype.perm&&(Array.prototype.perm=function(a){var b,c,d=this,e=new Array(a),f=function(a,b,c){var d,e=[],g=[];for("undefined"==typeof c&&(c=0),"undefined"==typeof b&&(b=0);c<a[b].length;c++)if(g="undefined"==typeof a[b+1]?[]:f(a,b+1,c),g.length>0)for(d=0;d<g.length;d++)g[d].unshift(a[b][c]),e.push(g[d]);else e.push([a[b][c]]);return e};for(b=0;a>b;b++)for(e[b]=new Array(d.length>=a?d.length-a+1:0),c=0;c<e[b].length;c++)e[b][c]=d[b+c];return d.length>=a?f(e):!1});
        !Array.prototype.min&&(Array.prototype.min=function(){var c,a=parseFloat(this[0]),b=this.length;for(c=1;b>c;c++)(this[a]=parseFloat(this[a]),this[a]<b)&&(a=this[c]);return a});
    }])

    .controller('NotcountCtrl', ['$scope', '$rootScope', '$location', '$timeout', '$stateParams', 'Tools',  function($scope, $rootScope, $location, $timeout, $stateParams, Tools) {
        var lastId = 0, page = 1, rows = 15;
        $scope.ansycLoaded = !1;
        $scope.loadMore = !1;
        $scope.isRefresh = !1;
        $scope.isLoading = !0;
        $scope.betListData = [];
        $scope.allData = {
            totalBetNums: 0,
            winLoseMoney: 0
        };
        $scope.gameId = $stateParams.gameId;
        $scope.$on('lotteryGameListLoaded', function($event, state){
            if(!$scope.gameList[$scope.gameId]){
                Tools.alert('请从有效地址进入');
                $location.path('/lottery/list');
            }else if(state.params.gameId==$scope.gameId){
                $scope.load();
            }
        });
        $scope.refresh = function(){
            $scope.loadMore = !1;
            $scope.isRefresh = !0;
            $scope.betListData = [];
            lastId = 0;
            page = 1;
            $scope.load();
        };
        $scope.load = function(){
            $scope.isLoading = !0;
            Tools.ajax({
                method: 'POST',
                url: 'ajax.php',
                params: {
                    action: 'report',
                    type: 'NotCount',
                    gameType: $scope.gameId,
                    page: page,
                    rows: rows,
                    lastId: lastId
                },
                success: function(data) {
                    $scope.isRefresh&&$scope.$broadcast('scroll.refreshComplete');
                    $scope.ansycLoaded = !0;
                    $scope.isRefresh = !1;
                    if(data&&data.status==1){
                        $scope.betListData = $scope.betListData.concat(data.msg);
                        $scope.allData.totalBetNums = data.totalCount;
                        $scope.allData.winLoseMoney = data.totalMoney;
                        lastId = data.lastId;
                        if(rows*page<data.totalCount){
                            $scope.loadMore = !0;
                            page++;
                            $timeout(function(){
                                $scope.isLoading = !1;
                            }, 1000);
                        }else{
                            $scope.loadMore = !1;
                            $scope.isLoading = !1;
                        }
                    }else{
                        $scope.betListData = [];
                        $scope.isLoading = !1;
                        lastId = 0;
                    }
                    $scope.$broadcast('scroll.infiniteScrollComplete');
                }
            });
            $scope.isRefresh||$scope.$broadcast('scroll.infiniteScrollComplete');
        };
        $scope.showDetail = function(index) {
            $scope.detail = $scope.betListData[index];
            $scope.detail.mdTime = $scope.detail.date+" "+$scope.detail.time;
            $scope.detail.bjTime = moment($scope.detail.mdTime).add(12, 'hours').format('YYYY-MM-DD HH:mm:ss');
            Tools.modal({
                scope: $scope,
                title: '注单详情',
                templateUrl: 'detail-template'
            });
        };
    }])

    .controller('HistoryCtrl', ['$scope', '$log', '$stateParams', '$state', '$location', '$timeout', 'Tools', 'ionicDatePicker', function($scope, $log, $stateParams, $state, $location, $timeout, Tools, ionicDatePicker) {
        var lastId = 0, rows = 10, curName = angular.copy($state.current.name);
        $scope.gameId = $stateParams.gameId;
        $scope.queryData = {};
        $scope.hideDate = !1;
        $scope.ansycLoaded = !1;
        $scope.loadMore = !1;
        $scope.isRefresh = !1;
        $scope.isLoading = !0;
        $scope.listData = [];
        $scope.$on('lotteryGameListLoaded', function($event, state){
            state.current.name==curName&&(angular.forEach($scope.gameList, function(game, gameId){
                if(!$scope.gameId||!$scope.gameList[$scope.gameId]){
                    $scope.gameId = gameId;
                }
            }),
                $scope.queryData.gameId = $scope.gameId,
                $scope.hideDate = $scope.gameList[$scope.gameId].hideDate,
                $scope.queryData.date = moment().format('YYYY-MM-DD'),
                $scope.load())
        });
        $scope.openDatePicker = function() {
            ionicDatePicker.openDatePicker({
                callback: function(time){
                    $scope.queryData.date = moment(time).format('YYYY-MM-DD');
                    $scope.onChange();
                },
                closeOnSelect: !0,
                showTodayButton: !1,
                from: moment().subtract(5, 'years').add(1, 'day')._d,
                to: moment()._d,
                inputDate: !$scope.queryData.date ? moment()._d : moment($scope.queryData.date)._d
            })
        }
        $scope.onChange = function(){
            $scope.ansycLoaded = !1;
            $scope.loadMore = !1;
            $scope.isRefresh = !1;
            $scope.isLoading = !0;
            $scope.listData = [];
            lastId = 0;
            $scope.gameId = $scope.queryData.gameId;
            $scope.hideDate = $scope.gameList[$scope.gameId].hideDate;
            $scope.load();
        };
        $scope.refresh = function(){
            $scope.loadMore = !1;
            $scope.isRefresh = !0;
            $scope.listData = [];
            lastId = 0;
            $scope.load();
        };
        $scope.load = function(){
            $scope.isLoading = !0;
            Tools.ajax({
                method: 'POST',
                url: 'ajax.php',
                params: {
                    action: 'lottery',
                    type: 'history',
                    gameType: $scope.gameId,
                    date: $scope.queryData.date,
                    rows: rows,
                    lastId: lastId
                },
                success: function(data) {
                    $scope.isRefresh&&$scope.$broadcast('scroll.refreshComplete');
                    $scope.ansycLoaded = !0;
                    $scope.isRefresh = !1;
                    if(data&&data.status==1){
                        $scope.listData = $scope.listData.concat(data.msg);
                        lastId = data.lastId;
                        if(data.hasMore){
                            $scope.loadMore = !0;
                            $timeout(function(){
                                $scope.isLoading = !1;
                            }, 1000);
                        }else{
                            $scope.loadMore = !1;
                            $scope.isLoading = !1;
                        }
                    }else{
                        $scope.listData = [];
                        $scope.isLoading = !1;
                        lastId = 0;
                    }
                    $scope.$broadcast('scroll.infiniteScrollComplete');
                }
            });
            $scope.isRefresh||$scope.$broadcast('scroll.infiniteScrollComplete');
        };
    }])


    .controller('ChangLongCtrl', ['$scope', '$log', '$stateParams', '$location', '$state', 'Tools', function($scope, $log, $stateParams, $location, $state, Tools) {
        var curName = angular.copy($state.current.name);
        $scope.gameId = $stateParams.gameId;
        $scope.$on('lotteryGameListLoaded', function($event, state){
            if(!$scope.gameId||!$scope.gameList[$scope.gameId]){
                Tools.alert('请从有效地址进入');
                $location.path('/lottery/list');
            }else if(!$scope.gameList[$scope.gameId].hasChangLong){
                Tools.alert('游戏无两面长龙数据');
                $location.path('/lottery/index/'+$scope.gameId);
            }else if(curName==state.current.name){
                $scope.refresh();
            }
        });
        $scope.ansycLoaded = !1;
        $scope.curStatList = [];
        $scope.refresh = function() {
            $scope.curStatList = [];
            Tools.ajax({
                method: 'POST',
                url: '../lot/ajax.php',
                params: {
                    action: "info",
                    type: "balance",
                    numberPostion: "0",
                    lotteryId: $scope.gameId
                },
                dataType: "json",
                success: function(data) {
                    $scope.$broadcast('scroll.refreshComplete');
                    $scope.ansycLoaded = !0;
                    if(data.Success&&data.Success==1){
                        $scope.curStatList = data.Obj.ChangLong;
                    }
                }
            });
        }
    }])

    .controller('LuZhuCtrl', ['$scope', '$log', '$stateParams', '$location', '$state', 'Tools', function($scope, $log, $stateParams, $location, $state, Tools) {
        var curName = angular.copy($state.current.name);
        $scope.gameId = $stateParams.gameId;
        $scope.$on('lotteryGameListLoaded', function($event, state){
            if(!$scope.gameId||!$scope.gameList[$scope.gameId]){
                Tools.alert('请从有效地址进入');
                $location.path('/lottery/list');
            }else if(!$scope.gameList[$scope.gameId].hasLuZhu){
                Tools.alert('游戏无路珠数据');
                $location.path('/lottery/index/'+$scope.gameId);
            }else if(curName==state.current.name){
                $scope.refresh();
            }
        });
        $scope.ansycLoaded = !1;
        $scope.topMenu = [];
        $scope.topStatList = [];
        $scope.topIndex = 0;
        $scope.subMenu = [];
        $scope.subStatList = [];
        $scope.subIndex = 0;
        $scope.curDataList = [[], []];
        $scope.refresh = function() {
            $scope.topMenu = [];
            $scope.topStatList = [];
            $scope.topIndex = 0;
            $scope.subMenu = [];
            $scope.subStatList = [];
            $scope.subIndex = 0;
            $scope.curDataList = [[], []];
            Tools.ajax({
                method: 'POST',
                url: '../lot/ajax.php',
                params: {
                    action: "info",
                    type: "balance",
                    numberPostion: "0",
                    lotteryId: $scope.gameId
                },
                dataType: "json",
                success: function(data) {
                    $scope.$broadcast('scroll.refreshComplete');
                    $scope.ansycLoaded = !0;
                    if(data.Success&&data.Success==1){
                        angular.forEach(data.Obj.LuZhu, function(data){
                            var index = data.p;
                            !$scope.curDataList[0][index]&&($scope.curDataList[0][index] = {name: data.n, data: []});
                            $scope.curDataList[0][index].data.push({name: data.n, data: data.c});
                        });
                        angular.forEach(data.Obj.ZongchuYilou.hit, function(data, index){
                            index = parseInt(index.substring(1));
                            $scope.curDataList[1].push({index: index, data: data});
                            $scope.topMenu.push($scope.curDataList[0][index].name);
                        });
                        $scope.toggleSelect(0, !0);
                    }
                }
            });
        }
        $scope.toggleSelect = function(index, isTop) {
            if(!angular.isUndefined(isTop)){
                var forIndex = [0];
                $scope.subStatList = [];
                $scope.topStatList = [];
                $scope.topIndex = index;
                $scope.subMenu = [];
                if($scope.topMenu.length>0){
                    angular.forEach($scope.curDataList[1][index].data, function(data, name){
                        $scope.topStatList.push([name, data]);
                    });
                    forIndex = [$scope.curDataList[1][index].index, 0];
                }
                angular.forEach(forIndex, function(index){
                    angular.forEach($scope.curDataList[0][index].data, function(list){
                        $scope.subMenu.push(list.name);
                        var temp = [];
                        angular.forEach(list.data.split(','), function(data){
                            data = data.split(':');
                            data[0] = [data[0]];
                            for(var i=1;i<data[1];i++){
                                data[0].push(data[0][0]);
                            }
                            this.unshift(data[0]);
                        }, temp);
                        $scope.subStatList.push(temp);
                    });
                });
            }else{
                $scope.subIndex = index;
            }
        }
    }])