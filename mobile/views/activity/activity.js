angular.module("ionicz.controllers").controller("ActivityBaseCtrl",["$scope","$rootScope","Tools",function(a,b,c){a.back=c.back("/activity/index"),!b.appData.activity&&(b.appData.activity={})}]).controller("ActivityCtrl",["$scope","$rootScope","$location","Tools",function(a,b,c,d){a.$on("$ionicView.beforeEnter",function(){b.appData.activity.cache?(a.activityData=b.appData.activity.cache,a.ansycLoaded=!0):d.ajax({method:"POST",url:"ajax.php",params:{action:"activity"},success:function(c){c&&1==c.status&&(a.activityData=c.msg,b.appData.activity.cache=c.msg,b.appData.activity.list=c.list,a.ansycLoaded=!0)}})}),a.ansycLoaded=!1,a.activityData=[]}]).controller("ActivityDetailCtrl",["$scope","$rootScope","$location","$stateParams",function(a,b,c,d){a.$on("$ionicView.afterEnter",function(){var d;!a.detailId||!b.appData.activity||!b.appData.activity.list||(d=b.appData.activity.list.indexOf("j"+a.detailId),0>d)?c.path("/activity/index"):(a.detail=b.appData.activity.cache[d],a.ansycLoaded=!0)}),a.ansycLoaded=!1,a.detailId=d.detailId,a.detail={}}]);