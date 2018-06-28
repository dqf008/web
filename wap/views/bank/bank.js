angular.module('ionicz.bank')

.controller('BankBaseCtrl', function($rootScope, $scope, $log, Tools, My, $ionicHistory, $location, PATH) {
	!$rootScope.appData.bank && ($rootScope.appData.bank = {});
	$log.debug("BankBaseCtrl...");
	$scope.back = Tools.back('/ucenter/index');
})

.controller('BankController', function($scope, $log, $location, Tools, My) {
	$log.debug("银行账号: BankController..." );
	$scope.bankData = [];
	$scope.isAdd = !1;
	$scope.$on('$ionicView.beforeEnter', function(event, viewData) {
		Tools.ajax({
			method: 'POST',
			url: 'ajax.php',
			params: {
				action: 'bank',
				type: 'get'
			},
			backdrop: true,
			success: function(data) {
				if(data&&data.status==1){
					$scope.bankData = data.msg;
				}
			}
		});
	});
	$scope.addBank = function(check){
		if(!My.getFullName()){
			Tools.alert('请您先添加真实名字');
			$location.path('/ucenter/myinfo');
		}else if(!My.hasFundPwd()){
			Tools.alert('请您先设置取款密码');
			$location.path('/ucenter/mypwd').search({fund: 'true'});
		}else if($scope.bankData.length){
			Tools.alert('您已经添加了银行账户信息');
		}else if(!check){
			$scope.isAdd = !0;
			$scope.mdfBankData = {};
		}else{
			return true;
		}
	};
	$scope.bindBank = function(){
		!$scope.addBank(true) || Tools.confirm('绑定后将不能进行修改，确认绑定？', function(){
			Tools.ajax({
				method: 'POST',
				url: 'ajax.php',
				params: {
					action: 'bank',
					type: 'save',
					bankName: $scope.mdfBankData.bankId=='Other' ? $scope.mdfBankData.bankName : $scope.mdfBankData.bankId,
					address: $scope.mdfBankData.address,
					cardNo: $scope.mdfBankData.cardNo
				},
				backdrop: true,
				success: function(data) {
					if(data&&data.status==1){
						$scope.isAdd = !1;
						$scope.mdfBankData = {};
						$scope.bankData = data.msg;
						Tools.tip('添加成功');
					}else{
						Tools.alert(data.msg);
					}
				}
			});
		})
	};
})

.controller('MoneyController', function($rootScope, $scope, $log, $state, $filter, $location, My, Tools, md5, ionicDatePicker) {
	var types = ['deposit', 'withdraw', 'trans'];
	$scope.withdrawData = {};
	$scope.withdrawStep = 0;
	$scope.transList = {
		deposit: '在线存款',
		transfer: '在线转账',
		withdraw: '取款记录',
		bank: '人工转账',
		activity: '彩金派送',
		point: '反水派送',
		other: '其它情况'
	};
	$scope.transData = {
		type: 'deposit',
		StartDate: moment().subtract(6, 'days').format('YYYY-MM-DD'),
		EndDate: moment().format('YYYY-MM-DD')
	};
	$scope.active = (function(type){
		for(var i=0;i<types.length;i++){
			if(types[i]==type){
				return i;
			}
		}
		return 0;
	})($location.search().type || types[0]);
	$scope.$on('$ionicView.beforeEnter', function(event, viewData) {
		Tools.ajax({
			method: 'POST',
			url: 'ajax.php',
			params: {
				action: 'bank',
				type: 'config'
			},
			backdrop: true,
			success: function(data) {
				if(data&&data.status==1){
					!My.loaded&&My.refreshMoney(!1);
					$scope.bankData = data;
					$rootScope.appData.bank.config = data;
					if(!My.getFullName()){
						$scope.withdrawStep = 1;
					}else if(!My.hasFundPwd()){
						$scope.withdrawStep = 2;
					}else if(!data.allowed){
						$scope.withdrawStep = 3;
					}else{
						$scope.withdrawStep = data.list&&data.list.length>0?5:4;
					}
				}
			}
		});
	});
	$scope.openDatePicker = function(scope) {
		!scope || ionicDatePicker.openDatePicker({
			callback: function(time){
				$scope.transData[scope] = moment(time).format('YYYY-MM-DD');
			},
			closeOnSelect: !0,
			showTodayButton: !1,
			from: scope=="StartDate"||!$scope.transData.StartDate ? moment().subtract(5, 'years').add(1, 'day')._d : moment($scope.transData.StartDate)._d,
			to: scope=="EndDate"||!$scope.transData.EndDate ? moment()._d : moment($scope.transData.EndDate)._d,
			inputDate: !$scope.transData[scope] ? moment()._d : moment($scope.transData[scope])._d
		})
	}
	$scope.showDetail = function(index) {
		$scope.curIndex = index;
		Tools.modal({
			scope: $scope,
			title: '收款账户信息',
			templateUrl: 'detail-template'
		});
	};
	$scope.withdrawSubmit = function() {
		var amount = $scope.withdrawData.applyMoney;
		if(!amount.match(/^\d+(\.\d{1,2})?$/)) {
			Tools.tip("请输入有效取款金额");
		}else if(amount = parseFloat(amount), amount<parseFloat($scope.bankData.limit)) {
			Tools.tip('取款金额不能小于 '+$filter('money')($scope.bankData.limit)+' 元');
		}else if(!$scope.withdrawData.withdrawPwd){
			Tools.tip("请输入取款密码");
		}else if(amount>parseFloat(My.getMoney())){
			Tools.tip("账户余额不足");
		}else{
			Tools.ajax({
				method: 'POST',
				url: 'ajax.php',
				params: {
					action: 'bank',
					type: 'withdraw',
					amount: amount,
					password: md5.createHash($scope.withdrawData.withdrawPwd)
				},
				backdrop: true,
				success: function(data) {
					if(data&&data.status==1){
						$scope.withdrawData = {};
						My.refreshMoney(!1);
						Tools.tip('取款申请已经提交，等待财务人员为您出款');
					}else{
						Tools.tip(data.msg);
					}
				}
			});
		}
	};
	$scope.transSubmit = function(){
		$rootScope.appData.bank.trans = {
			Start: $scope.transData.StartDate,
			End: $scope.transData.EndDate,
			Type: $scope.transData.type,
			TypeName: $scope.transList[$scope.transData.type]
		};
		$location.path('/bank/trans');
	}
})

.controller('TransController', function($rootScope, $scope, $location, $timeout, Tools) {
	var lastId = 0, page = 1, rows = 10;
	$scope.ansycLoaded = !1;
	$scope.loadMore = !1;
	$scope.isRefresh = !1;
	$scope.isLoading = !0;
	$scope.appData = {};
	$scope.listData = [];
	$scope.allData = {
		totalNums: 0,
		totalMoney: 0
	};
	$scope.refresh = function(){
		$scope.loadMore = !1;
		$scope.isRefresh = !0;
		$scope.listData = [];
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
				action: 'bank',
				type: 'trans',
				transType: $scope.appData.Type,
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
					$scope.listData = $scope.listData.concat(data.msg);
					$scope.allData.totalNums = data.totalCount;
					$scope.allData.totalMoney = data.totalMoney;
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
					$scope.listData = [];
					$scope.isLoading = !1;
					lastId = 0;
				}
				$scope.$broadcast('scroll.infiniteScrollComplete');
			}
		});
		$scope.isRefresh||$scope.$broadcast('scroll.infiniteScrollComplete');
	};
	$scope.showDetail = function(index) {
		$scope.detail = $scope.listData[index];
		$scope.detail.mdTime = $scope.detail.date+" "+$scope.detail.time;
		$scope.detail.bjTime = moment($scope.detail.mdTime).add(12, 'hours').format('YYYY-MM-DD HH:mm:ss');
		Tools.modal({
			scope: $scope,
			title: '订单详情',
			templateUrl: $scope.appData.Type=='transfer'?'transfer-detail-template':'detail-template'
		});
	};
	$scope.$on('$ionicView.afterEnter', function() {
		if(!$rootScope.appData.bank.trans||!$rootScope.appData.bank.trans.Type){
			$location.path('/bank/money').search({type: "trans"});
		}else{
			$scope.appData = $rootScope.appData.bank.trans;
			$scope.load();
		}
	});
})

.controller('QRCodeController', function($rootScope, $scope, $location, $filter, Tools, ionicDatePicker) {
	$scope.$on('$ionicView.afterEnter', function() {
		if(!$rootScope.appData.bank.config||!$rootScope.appData.bank.config.qrcode){
			$location.path('/bank/money').search({type: "deposit"});
		}else{
			$scope.appData = $rootScope.appData.bank.config.qrcode;
			$scope.min = $rootScope.appData.bank.config.min;
		}
	});
	$scope.min = 0;
	$scope.max = 2000;
	$scope.bankStep = 1;
	$scope.transferData = {
		time: moment().format('YYYY-MM-DD HH:mm:ss')
	};
	$scope.openDatePicker = function() {
		ionicDatePicker.openDatePicker({
			callback: function(time){
				$scope.transferData.time = moment(time).format('YYYY-MM-DD HH:mm:ss');
			},
			closeOnSelect: !1,
			showTodayButton: !0,
			from: moment(moment().format('YYYY-MM-DD 00:00:00')).subtract(5, 'years').add(1, 'day')._d,
			to: moment(moment().format('YYYY-MM-DD 23:59:59'))._d,
			inputDate: moment($scope.transferData.time)._d,
			disableTime: !1
		})
	};
	$scope.checkStep = function() {
		switch(!0){
			case $scope.bankStep==1:
			!$scope.transferData.info?Tools.tip("请选择转账账号"):($scope.bankStep = 2);
			break;
			case !$scope.transferData.money:
			case !$scope.transferData.money.match(/^[\d\.]+$/):
			case parseFloat($scope.transferData.money)<=0:
			Tools.tip('请输入有效转账金额');
			break;
			case parseFloat($scope.transferData.money)<parseFloat($scope.min):
			Tools.tip('转账金额不能小于 '+$filter('money')($scope.min)+' 元');
			break;
			case parseFloat($scope.transferData.money)>parseFloat($scope.max):
			Tools.tip('转账金额不能大于 '+$filter('money')($scope.max)+' 元');
			break;
			case !$scope.transferData.username:
			Tools.tip('请填写转账人昵称、姓名或ID');
			break;
			case !$scope.transferData.time:
			Tools.tip('请选择转账时间');
			break;
			case $scope.bankStep==2:
			$scope.bankStep = 3;
			break;
			case $scope.bankStep==3:
			$scope.transferSubmit();
			break;
		}
	}
	$scope.transferSubmit = function() {
		Tools.ajax({
			method: 'POST',
			url: 'ajax.php',
			params: {
				action: 'bank',
				type: 'transfer',
				qrcode: !0,
				code: $scope.transferData.info.code,
				amount: parseFloat($scope.transferData.money),
				username: $scope.transferData.username,
				time: $scope.transferData.time
			},
			backdrop: true,
			success: function(data) {
				if(data&&data.status==1){
					$location.path('/bank/money').search({type: "deposit"});
					Tools.tip('转账申请已经提交，等待财务人员为您确认');
				}else{
					$scope.bankStep = 2;
					Tools.tip(data.msg);
				}
			}
		});
	}
})

.controller('TransferController', function($rootScope, $scope, $location, $filter, Tools, ionicDatePicker) {
	$scope.$on('$ionicView.afterEnter', function() {
		if(!$rootScope.appData.bank.config||!$rootScope.appData.bank.config.transfer){
			$location.path('/bank/money').search({type: "deposit"});
		}else{
			$scope.appData = $rootScope.appData.bank.config.transfer;
			$scope.min = $rootScope.appData.bank.config.min;
		}
	});
	$scope.types = [
		{
			name: '银行柜台',
			address: !0
		},
		{
			name: 'ATM现金',
			address: !0
		},
		{
			name: 'ATM卡转',
			username: !0
		},
		{
			name: '网银转账',
			username: !0
		},
		{
			name: '支付宝转账',
			username: !0
		},
		{
			name: '微信转账',
			username: !0
		},
		{
			name: '其它方式[手动输入]',
			address: !0,
			username: !0,
			other: !0
		}
	];
	$scope.min = 0;
	$scope.bankStep = 1;
	$scope.transferData = {
		time: moment().format('YYYY-MM-DD HH:mm:ss')
	};
	$scope.openDatePicker = function() {
		ionicDatePicker.openDatePicker({
			callback: function(time){
				$scope.transferData.time = moment(time).format('YYYY-MM-DD HH:mm:ss');
			},
			closeOnSelect: !1,
			showTodayButton: !0,
			from: moment(moment().format('YYYY-MM-DD 00:00:00')).subtract(5, 'years').add(1, 'day')._d,
			to: moment(moment().format('YYYY-MM-DD 23:59:59'))._d,
			inputDate: moment($scope.transferData.time)._d,
			disableTime: !1
		})
	};
	$scope.checkStep = function() {
		switch(!0){
			case $scope.bankStep==1:
			!$scope.transferData.info?Tools.tip("请选择转账账号"):($scope.bankStep = 2);
			break;
			case !$scope.transferData.money:
			case !$scope.transferData.money.match(/^[\d\.]+$/):
			case parseFloat($scope.transferData.money)<=0:
			Tools.tip('请输入有效转账金额');
			break;
			case parseFloat($scope.transferData.money)<parseFloat($scope.min):
			Tools.tip('转账金额不能小于 '+$filter('money')($scope.min)+' 元');
			break;
			case !(!$scope.transferData.type.other||$scope.transferData.otherType):
			Tools.tip('请填写转账方式');
			break;
			case !(!$scope.transferData.type.username||$scope.transferData.username):
			Tools.tip('请填写转账人姓名');
			break;
			case !(!$scope.transferData.type.address||$scope.transferData.address):
			Tools.tip('请填写转账地址');
			break;
			case !$scope.transferData.time:
			Tools.tip('请选择转账时间');
			break;
			case $scope.bankStep==2:
			$scope.bankStep = 3;
			break;
			case $scope.bankStep==3:
			$scope.transferSubmit();
			break;
		}
	}
	$scope.transferSubmit = function() {
		Tools.ajax({
			method: 'POST',
			url: 'ajax.php',
			params: {
				action: 'bank',
				type: 'transfer',
				code: $scope.transferData.info.code,
				amount: parseFloat($scope.transferData.money),
				transfer: $scope.transferData.type.other?'[其它方式]'+$scope.transferData.otherType:$scope.transferData.type.name,
				username: $scope.transferData.username,
				address: $scope.transferData.address,
				time: $scope.transferData.time
			},
			backdrop: true,
			success: function(data) {
				if(data&&data.status==1){
					$location.path('/bank/money').search({type: "deposit"});
					Tools.tip('转账申请已经提交，等待财务人员为您确认');
				}else{
					$scope.bankStep = 2;
					Tools.tip(data.msg);
				}
			}
		});
	}
})

.controller('DepositController', function($rootScope, $scope, $location, $filter, Tools) {
	$scope.$on('$ionicView.afterEnter', function() {
		if(!$rootScope.appData.bank.config||!$rootScope.appData.bank.config.deposit){
			$location.path('/bank/money').search({type: "deposit"});
		}else{
			$scope.appData = $rootScope.appData.bank.config.deposit;
			$scope.min = $rootScope.appData.bank.config.min;
		}
	});
	$scope.min = 0;
	$scope.depositData = {};
	$scope.depositSubmit = function(){
		switch(!0){
			case !$scope.depositData.type:
			Tools.tip('请选择存款方式');
			break;
			case !$scope.depositData.money:
			case !$scope.depositData.money.match(/^[\d\.]+$/):
			case parseFloat($scope.depositData.money)<=0:
			Tools.tip('请输入有效存款金额');
			break;
			case parseFloat($scope.depositData.money)<parseFloat($scope.min):
			Tools.tip('存款金额不能小于 '+$filter('money')($scope.min)+' 元');
			break;
			default:
			Tools.ajax({
				method: 'POST',
				url: 'ajax.php',
				params: {
					action: 'bank',
					type: 'online',
					code: $scope.depositData.type.code,
					amount: parseFloat($scope.depositData.money)
				},
				backdrop: true,
				success: function(data) {
					if(data&&data.status==1){
						var deposit = Tools.openWindow(data.msg);
						if(!deposit||deposit.closed){
							Tools.confirm('无法在新窗口打开支付链接，是否离开当前页面继续支付？', function(){
								window.location.href = data.msg;
							});
						}else{
							Tools.tip('请在弹出的新窗口中完成在线存款');
							$location.path('/bank/money').search({type: "deposit"});
						}
					}else{
						Tools.tip(data.msg);
					}
				}
			});
			break;
		}
	};
})
;