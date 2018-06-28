angular.module('ionicz.controllers')

.controller('UCenterBaseCtrl', function($scope, Tools) {
	$scope.back = Tools.back('/ucenter/index');
})
.controller('UCenterCtrl', function($scope, $rootScope, $timeout, $state, $ionicPopup, $location, Tools, md5, My) {
	$scope.$on('$ionicView.beforeEnter', function(event, viewData) {
		// 强制显示后退按钮
		// viewData.enableBack = true;
		My.refreshMoney(!1);
	});
	$scope.goPageCheckFundPwd = function(pageModel) {
		//console.log($scope.checkFundPwd());
		if ($scope.checkFundPwd()) {
			$state.go(pageModel);
		}
	};
	$scope.checkFundPwd = function() {
		return UCenter.checkFundPwd()
	};
	
	// 个人资料
	$scope.addFullName = function() {
		!My.getFullName() ? Tools.modal({
			templateUrl: 'fullname-template',
	        title: '添加真实名字',
	        callback: function(scope, popup) {
	        	var fullname = scope.modalData.fullname;
	        	switch(true){
	        	 	case !fullname:
        	 		Tools.tip('请输入真实姓名');
        	 		break;
        	 		case !(/^[a-zA-Z ]{1,20}$/.test(fullname) || /^[\u4e00-\u9fa5]{1,10}$/.test(fullname)):
        	 		Tools.tip('真实姓名格式不正确');
        	 		break;
        	 		default:
		        	Tools.ajax({
		     			method: 'POST',
		     			params: {
		     				action: "setFullName",
		     				fullName: fullname
		     			},
		     			url: 'ajax.php',
		     			success: function(data) {
		     				if(data&&data.status==1){
		     					Tools.tip("保存成功");
		     					My.setFullName(fullname);
		     					popup.close();
		     				}else{
		     					Tools.tip(data.msg);
		     				}
		     			}
		        	});
        	 		break;
	        	}
        	 	return false;
	        }
		}) : Tools.alert('您已经添加了真实姓名');
	};
	
	$scope.showEmailModel = function() {
		UCenter.addEmail();
	};
})
.controller('PwdCtroller', function($scope, $timeout, $ionicModal, $state, $location, Tools, My) {
	$scope.type = !$location.search().fund ? 0 : 1;
	$scope.mdfLoginPwdData = {};
	$scope.updatePwd = function() {
		if($scope.mdfLoginPwdData.OldLoginPwd == $scope.mdfLoginPwdData.NewLoginPwdRpt) {
			Tools.tip("新密码与旧密码不能相同");
			return;
		}
		Tools.ajax({
			method: 'POST',
			params:{
				action: "loginPwd",
				oldPwd: $scope.mdfLoginPwdData.OldLoginPwd,
				newPwd: $scope.mdfLoginPwdData.NewLoginPwdRpt
			},
			url: 'ajax.php',
			success: function(data) {
				if(data.status==1) {
					Tools.tip('修改登录密码成功');
					$state.go("ucenter.index");
				}else{
					Tools.tip(data.msg);
					return false;
				}
			}
		});
	};
	// 取款密码
	$scope.mdfFundPwdData = {};
	$scope.updateFundPwd = function() {
		if(My.hasFundPwd()&&$scope.mdfFundPwdData.OldFundPwd == $scope.mdfFundPwdData.NewFundPwdRpt) {
			Tools.tip("新密码与旧密码不能相同");
			return;
		}
		Tools.ajax({
			method: 'POST',
			params:{
				action: "fundPwd",
				oldPwd: $scope.mdfFundPwdData.OldFundPwd,
				newPwd: $scope.mdfFundPwdData.NewFundPwd
				//oldFundPwd : md5.createHash($scope.mdfFundPwdData.OldFundPwd),
				//newFundPwd : md5.createHash($scope.mdfFundPwdData.NewFundPwd)
			},
			url: 'ajax.php',
			success: function(data) {
				if(data.status==1) {
					Tools.tip(My.hasFundPwd()?'修改取款密码成功':'设置取款密码成功');
					My.setHasFundPwd(!0);
					$state.go("ucenter.index");
				}else{
					Tools.tip(data.msg);
					return false;
				}
			}
		});
	};
	$scope.onChange = function(index){};
})
.controller('NoticeCtroller', function($rootScope, $scope, $timeout, $ionicModal, $location, Tools, My) {
	var rows = 10, types = ['web', 'sports', 'sms'];
	// 消息中心
	$scope.page = $scope.page || [];
	$scope.noticeList = $scope.noticeList || [];
	$scope.canLoadMore = $scope.canLoadMore || [];
	$scope.loadingMore = $scope.loadingMore || [];
	$scope.type = (function(type){
		for(var i=0;i<types.length;i++){
			if(types[i]==type){
				return i;
			}
		}
		return 0;
	})($location.search().type || 'web');
	$scope.noticeRefresh = function() {
		$scope.noticeList[$scope.type] = null;
		$scope.canLoadMore[$scope.type] = true;
		$scope.page[$scope.type] = 1;
		$scope.loadMore(true);
	};
	$scope.loadMore = function(refresh) {
		if($scope.canLoadMore[$scope.type]){
			$scope.canLoadMore[$scope.type] = false;
			angular.isUndefined($scope.loadingMore[$scope.type])||($scope.loadingMore[$scope.type] = true);
			Tools.ajax({
				method: 'POST',
				params: {
					action: 'notice',
					type: types[$scope.type],
					page: $scope.page[$scope.type],
					rows: rows
				},
				url: 'ajax.php',
				success: function(data) {
					if(data&&data.status==1&&data.totalCount>0){
						$scope.noticeList[$scope.type] = $scope.noticeList[$scope.type] || [];
						$scope.noticeList[$scope.type] = $scope.noticeList[$scope.type].concat(data.msg);
						if(rows*$scope.page[$scope.type]<data.totalCount){
							$scope.page[$scope.type]++;
							$timeout(function(){
								$scope.canLoadMore[$scope.type] = true;
							}, 1000);
						}
					}else{
						$scope.noticeList[$scope.type] = [];
					}
					$scope.loadingMore[$scope.type] = false;
					$scope.$broadcast('scroll.infiniteScrollComplete');
					refresh&&$scope.$broadcast('scroll.refreshComplete');
				}
			});
		}
		refresh||$scope.$broadcast('scroll.infiniteScrollComplete');
	};
	// 消息详情页
	$scope.showDetail = function(index) {
		Tools.modal({
			scope: $scope,
			title: $scope.noticeList[$scope.type][index].title,
			template: $scope.noticeList[$scope.type][index].content
		});
	};
	$scope.showSMSDetail = function(index) {
		var detail = function(){
			Tools.modal({
				scope: $scope,
				title: $scope.noticeList[$scope.type][index].title,
				template: $scope.noticeList[$scope.type][index].content,
				cancelText: '已读',
				okText: '删除',
				callback: function(scope, popup) {
					Tools.ajax({
						method: 'POST',
						params: {
							action: 'sms',
							type: 'delete',
							id: $scope.noticeList[$scope.type][index].id
						},
						backdrop: true,
						url: 'ajax.php',
						success: function(data) {
							if(data&&data.status==1){
								$scope.noticeList[$scope.type].splice(index, 1);
							}else{
								Tools.tip('删除失败');
							}
						}
					});
					popup.close();
				}
			});
		}
		if($scope.noticeList[$scope.type][index].read){
			detail();
		}else{
			Tools.ajax({
				method: 'POST',
				params: {
					action: 'sms',
					type: 'read',
					id: $scope.noticeList[$scope.type][index].id
				},
				url: 'ajax.php',
				backdrop: true,
				success: function(data) {
					if(data&&data.status==1){
						My.userMsg--;
						$scope.noticeList[$scope.type][index].read = 1;
						detail();
					}
				}
			});
		}
	};
	$scope.deleteSMS = function(){
		Tools.confirm("确定要删除全部站内消息？", function(){
			Tools.ajax({
				method: 'POST',
				params: {
					action: 'sms',
					type: 'clear'
				},
				url: 'ajax.php',
				backdrop: true,
				success: function(data) {
					if(data&&data.status==1){
						My.userMsg = 0;
						Tools.tip('已删除全部站内消息');
						$scope.noticeRefresh();
					}else{
						Tools.tip(data.msg);
					}
				}
			});
		});
	};
	$scope.onChange = function(index){
		$scope.type = index;
		angular.isUndefined($scope.noticeList[$scope.type])&&$scope.noticeRefresh();
	};
	$scope.onChange($scope.type);
})
.controller('TransferCtroller', ["$scope", "$timeout", "$ionicModal", "$state", "$location", "$filter", "Tools", "My", function($scope, $timeout, $ionicModal, $state, $location, $filter, Tools, My) {
	$scope.allowed = !1;
	$scope.watchCount = 0;
	$scope.allCount = -1;
	$scope.mainIndex = -1;
	$scope.amountList = ['全部', 100, 500, 1000, 5000, 10000];
	$scope.walletList = {};
	$scope.errorMessage = [];
	$scope.transerModel = {
		classLoading: 0,
		colSpan:0,
		haveMoney:0,
	};
	$scope.$on('$ionicView.beforeEnter', function(event, viewData) {
		Tools.ajax({
			method: 'POST',
			params: {
				action: 'transfer',
				type: 'check'
			},
			url: 'ajax.php',
			backdrop: true,
			success: function(data) {
				if(data&&data.status==1){
					var i;
					$scope.allowed = data.msg.allowed;
					$scope.walletList = data.msg.list;
					angular.forEach(data.msg.list, function(item){
						$scope.transerModel.colSpan+= item.colSpan;
					});
					$scope.transerModel.colSpan = $scope.transerModel.colSpan%3;
					$scope.refresh(!0);
				}else{
					Tools.tip(data.msg);
				}
			}
		});
	});
	// $scope.$on('$ionicView.afterEnter', function(event, viewData) {
	// 	$scope.refresh(!0);
	// });
	$scope.refresh = function(init, walletId){
		$scope.transerModel.classLoading = 1;
		$scope.clearSelect();
		angular.forEach($scope.walletList, function(wallet){
			var fun = function(){
				Tools.ajax({
					method: 'GET',
					params: {
						type: wallet.GameClassID
					},
					url: wallet.LiveMoneyUrl ? wallet.LiveMoneyUrl : '../cj/live/live_money.php',
					success: function(data) {
						data = data.match(/\((.+)\)/);
						data = angular.fromJson(data[1]);
						if(data&&data.info=='ok'){
							wallet.LoadingState = wallet.State-1;
							wallet.walletBalance = data.msg;
						}else{
							wallet.LoadingState = 2;
							wallet.walletBalance = 0;
						}
					}
				})
			};
			if(init||wallet.LoadingState!=1&&(!walletId||walletId.indexOf(wallet.GameClassID)>=0)){
				wallet.LoadingState = 1;
				if(init||wallet.GameClassID=='SYSTEM'||wallet.State==0){
					wallet.State = 1;
					Tools.ajax({
						method: 'POST',
						params: {
							action: 'transfer',
							type: 'refresh',
							id: wallet.GameClassID
						},
						url: 'ajax.php',
						success: function(data) {
							if(data&&data.status==1){
								wallet.State = data.msg.State;
								wallet.IsOnline = data.msg.IsOnline;
								wallet.OpenState = data.msg.OpenState;
								if(!init&&wallet.GameClassID!='SYSTEM'&&data.msg.State==1){
									fun();
								}else{
									wallet.LoadingState = data.msg.State-1;
									wallet.walletBalance = data.msg.walletBalance;
								}
							}else{
								wallet.LoadingState = 2;
								wallet.walletBalance = 0;
							}
						}
					});
				}else{
					fun();
				}
			}
		});
        $scope.transerModel.classLoading = 0;
	}
	$scope.chooseWalletFun = function(index){
		var wallet = $scope.walletList[index];
		$scope.transerModel.moneyIndex = null;
		$scope.transerModel.actualMoney = null;
		if($scope.transerModel.walletType==wallet.GameClassID){
			$scope.transerModel.walletType = null;
			$scope.transerModel.haveMoney = 0;
		}else if($scope.transerModel.rollInWallet!=wallet.GameClassID&&wallet.walletBalance>0&&wallet.State==1&&wallet.LoadingState==0){
			$scope.transerModel.walletType = wallet.GameClassID;
			$scope.transerModel.haveMoney = wallet.walletBalance;
		}
	}
	$scope.rollInFun = function(index){
		var wallet = $scope.walletList[index];
		if($scope.transerModel.rollInWallet==wallet.GameClassID){
			$scope.transerModel.rollInWallet = null;
		}else if($scope.transerModel.walletType!=wallet.GameClassID&&wallet.State==1&&wallet.LoadingState==0){
			$scope.transerModel.rollInWallet = wallet.GameClassID;
		}
	}
	$scope.chooseMoneyFun = function(index){
		if($scope.transerModel.moneyIndex==index){
			$scope.transerModel.moneyIndex = null;
			$scope.transerModel.actualMoney = null;
		}else if(index==0||$scope.transerModel.haveMoney>=$scope.amountList[index]){
			$scope.transerModel.moneyIndex = index;
			$scope.transerModel.actualMoney = $filter("number")(index==0 ? $scope.transerModel.haveMoney : $scope.amountList[index]);
		}
	}
	$scope.clearSelect = function(index){
		$scope.transerModel.haveMoney = 0;
		$scope.transerModel.walletType = null;
		$scope.transerModel.rollInWallet = null;
		$scope.transerModel.moneyIndex = null;
		$scope.transerModel.actualMoney = null;
	}
	$scope.parseIntMoney = function(event){
		$scope.transerModel.moneyIndex = null;
		$scope.transerModel.actualMoney = $filter("number")($scope.transerModel.actualMoney);
		$scope.transerModel.actualMoney>$scope.transerModel.haveMoney&&($scope.transerModel.actualMoney = $filter("number")($scope.transerModel.haveMoney));
	}
	$scope.transferSubmit = function(){
		switch(true){
			case !$scope.transerModel.walletType:
			Tools.tip("请选择转出钱包");
			break;
			case !$scope.transerModel.rollInWallet:
			Tools.tip("请选择转入钱包");
			break;
			case $scope.transerModel.walletType==$scope.transerModel.rollInWallet:
			Tools.tip("不能选择相同的钱包进行转账");
			break;
			case !$scope.transerModel.actualMoney:
			Tools.tip("请填写转账金额");
			break;
			case $scope.transerModel.actualMoney>$scope.transerModel.haveMoney:
			Tools.tip("转出钱包额度不足");
			break;
			default:
			Tools.ajax({
				method: 'POST',
				params: {
					action: 'transfer',
					type: 'start',
					out: $scope.transerModel.walletType,
					in: $scope.transerModel.rollInWallet,
					money: $scope.transerModel.actualMoney
				},
				url: 'ajax.php',
				backdrop: true,
				success: function(data) {
					if(data&&data.status==1){
						Tools.alert('转账完成');
						$scope.refresh(0, [$scope.transerModel.walletType, $scope.transerModel.rollInWallet]);
					}else{
						Tools.alert(['转账失败', data.msg]);
					}
				}
			});
			break;
		}
	}
	$scope.allIn = function(id){
		if($scope.watchCount==0&&$scope.allCount==-1){
			Tools.confirm('确定全部转入'+$scope.walletList[id].GameClassName+'？', function(){
				$scope.allCount+= $scope.walletList.length;
				$scope.mainIndex = id;
				angular.forEach($scope.walletList, function(wallet, index){
					wallet.TransferLoading = 1, index>0 && index!=id && Tools.ajax({
						method: 'POST',
						params: {
							action: 'transfer',
							type: 'start',
							out: wallet.GameClassID,
							in: 'SYSTEM',
							money: 'all'
						},
						url: 'ajax.php',
						success: function(data) {
							$scope.watchCount++;
							if(data&&data.status==1){
								wallet.TransferLoading = 0;
							}else{
								$scope.errorMessage[index] = data.msg;
								wallet.TransferLoading = 2;
							}
						}
					});
				})
			});
		}else if($scope.watchCount==$scope.allCount){
			$scope.walletList[id].TransferLoading==0 ? Tools.alert('操作成功') : $scope.showError(id);
		}
	}
	$scope.showError = function(index){
		Tools.alert(['转账失败', angular.isUndefined($scope.errorMessage[index]) ? '发生未知错误' : $scope.errorMessage[index]]);
	}
	$scope.$watch("watchCount", function(count) {
        if($scope.mainIndex==0&&count==$scope.allCount){
            $scope.walletList[0].TransferLoading = 0;
            $scope.refresh();
        }else if($scope.mainIndex>0&&count==$scope.allCount-1){
			Tools.ajax({
				method: 'POST',
				params: {
					action: 'transfer',
					type: 'start',
					out: 'SYSTEM',
					in: $scope.walletList[$scope.mainIndex].GameClassID,
					money: 'all'
				},
				url: 'ajax.php',
				success: function(data) {
					$scope.walletList[0].TransferLoading = 0;
					$scope.watchCount++;
					if(data&&data.status==1){
						$scope.walletList[$scope.mainIndex].TransferLoading = 0;
					}else{
						$scope.errorMessage[$scope.mainIndex] = data.msg;
						$scope.walletList[$scope.mainIndex].TransferLoading = 2;
					}
					$scope.refresh();
				}
			});
        }
    })
}])
;