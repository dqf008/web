angular.module('ionicz.controllers')

.controller('ActivityBaseCtrl', ['$scope', '$rootScope', 'Tools', function($scope, $rootScope, Tools) {
    $scope.back = Tools.back('/activity/index');
    !$rootScope.appData.activity && ($rootScope.appData.activity = {});
}])

.controller('ActivityCtrl', ['$scope', '$rootScope', '$location', 'Tools', function($scope, $rootScope, $location, Tools) {
    $scope.$on('$ionicView.beforeEnter', function() {
        !$rootScope.appData.activity.cache ? Tools.ajax({
            method: 'POST',
            url: 'ajax.php',
            params: {action: 'activity'},
            success: function(data) {
                if(data&&data.status==1){
                    $scope.activityData = data.msg;
                    $rootScope.appData.activity.cache = data.msg;
                    $rootScope.appData.activity.list = data.list;
                    $scope.ansycLoaded = !0;
                }
            }
        }) : ($scope.activityData = $rootScope.appData.activity.cache, $scope.ansycLoaded = !0);
    });
    $scope.ansycLoaded = !1;
    $scope.activityData = [];
}])

.controller('ActivityDetailCtrl', ['$scope', '$rootScope', '$location', '$stateParams', function($scope, $rootScope, $location, $stateParams) {
    $scope.$on('$ionicView.afterEnter', function() {
        var index;
        if(!$scope.detailId||!$rootScope.appData.activity||!$rootScope.appData.activity.list||(index = $rootScope.appData.activity.list.indexOf('j'+$scope.detailId), index<0)){
            $location.path('/activity/index');
        }else{
            $scope.detail = $rootScope.appData.activity.cache[index];
            $scope.ansycLoaded = !0;
        }
    });
    $scope.ansycLoaded = !1;
    $scope.detailId = $stateParams.detailId;
    $scope.detail = {};
}]);

