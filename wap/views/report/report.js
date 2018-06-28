angular.module('ionicz.controllers')

.controller('ReportBaseCtrl', ['$scope', '$rootScope', 'ionicDatePicker', 'Tools', function($scope, $rootScope, ionicDatePicker, Tools) {
    $scope.baseDatePicker = function(opt, callback) {
        angular.isUndefined(opt)&&(opt = {});
        ionicDatePicker.openDatePicker({
            callback: function(time){
                angular.isFunction(callback) && callback(moment(time).format('YYYY-MM-DD'));
            },
            closeOnSelect: !0,
            showTodayButton: !1,
            from: !opt.fromDate ? moment().subtract(5, 'years').add(1, 'day')._d : moment(opt.fromDate)._d,
            to: !opt.toDate ? moment()._d : moment(opt.toDate)._d,
            inputDate: !opt.inputDate ? moment()._d : moment(opt.inputDate)._d
        })
    }
    !$rootScope.appData.report && ($rootScope.appData.report = {});
}])

.controller('ReportCtrl', ['$scope', '$rootScope', '$location', 'Tools',  function($scope, $rootScope, $location, Tools) {
    var types = ['Sports', 'Lottery'];
    $scope.back = Tools.back('/ucenter/index');
    $scope.GameType = {};
    $scope.type = (function(type){
        for(var i=0;i<types.length;i++){
            if(types[i]==type){
                return i;
            }
        }
        return 0;
    })($location.search().type || types[0]);
    $scope.GameList = {};
    $scope.StartDate = moment().subtract(6, 'days').format('YYYY-MM-DD');
    $scope.EndDate = moment().format('YYYY-MM-DD');
    $scope.$on('$ionicView.beforeEnter', function() {
        !$rootScope.appData.report.list ? Tools.ajax({
            method: 'POST',
            url: 'ajax.php',
            params: {
                action: 'report',
                type: 'list'
            },
            success: function(data) {
                if(data&&data.status==1){
                    $scope.GameList = data.msg;
                    $rootScope.appData.report.list = data.msg;
                }
            }
        }) : ($scope.GameList = $rootScope.appData.report.list);
    });
    $scope.openDatePicker = function(scope){
        !scope || $scope.baseDatePicker({
            fromDate: scope=="EndDate" ? $scope['StartDate'] : false,
            toDate: scope=="StartDate" ? $scope['EndDate'] : false,
            inputDate: $scope[scope]
        }, function(date){
            $scope[scope] = date;
        })
    }
    $scope.onChange = function(index){
        // if(index==3){
        //     $scope.GameType.MarkSix = 'MARKSIX';
        // }else{
        //     $scope.GameType = {};
        // }
        // $scope.StartDate = null;
        // $scope.EndDate = null;
        $scope.type = index;
    }
    $scope.report = function(){
        $rootScope.appData.report.cache = {
            Start: $scope.StartDate,
            End: $scope.EndDate,
            Type: types[$scope.type],
            GameType: $scope.GameType[types[$scope.type]],
            GameName: $scope.GameList[types[$scope.type]][$scope.GameType[types[$scope.type]]]
        }
        $location.path('/report/list');
    }
}])

.controller('ReportListCtrl', ['$scope', '$rootScope', '$location', '$timeout', 'Tools',  function($scope, $rootScope, $location, $timeout, Tools) {
    var lastId = 0, page = 1, rows = 10;
    $scope.back = Tools.back('/report/index');
    $scope.ansycLoaded = !1;
    $scope.sports = !1;
    $scope.loadMore = !1;
    $scope.isRefresh = !1;
    $scope.isLoading = !0;
    $scope.appData = $rootScope.appData.report.cache;
    $scope.betListData = [];
    $scope.allData = {
        totalBetNums: 0,
        winLoseMoney: 0
    };
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
                type: $scope.appData.Type,
                gameType: $scope.appData.GameType,
                start: $scope.appData.Start,
                end: $scope.appData.End,
                page: page,
                rows: rows,
                lastId: lastId
            },
            success: function(data) {
                $scope.isRefresh&&$scope.$broadcast('scroll.refreshComplete');
                $scope.ansycLoaded = !0;
                $scope.isRefresh = !1;
                if(data&&data.status==1){
                    $scope.sports = data.sports;
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
        $scope.detail.color = '';
        if($scope.detail.status==0){
            $scope.detail.show = '未结算';
        }else{
            $scope.detail.show = '已结算-';
            if($scope.detail.winLoseMoney==0){
                $scope.detail.show+= '和局';
            }else if($scope.detail.winLoseMoney>0){
                $scope.detail.color = '#00b939';
                $scope.detail.show+= '赢';
            }else{
                $scope.detail.color = '#e00013';
                $scope.detail.show+= '输';
            }
        }
        Tools.modal({
            scope: $scope,
            title: '注单详情',
            templateUrl: !$scope.sports?'detail-template':'sports-detail-template'
        });
    };
    $scope.$on('$ionicView.afterEnter', function() {
        if(!$scope.appData||!$scope.appData.Type||!$scope.appData.GameType){
            $location.path('/report/index');
        }else{
            $scope.load();
        }
    });
}]);

