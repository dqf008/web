angular.module('ionicz.lottery')

.directive('myPopover', function() {
	return {
		restrict: 'C',
		scope: true,
		link: function(scope, element, attrs) {
			element.find('a').bind('click', function() {
				scope.popover.hide();
			});
		}
	}
})

.directive('scrollbarX', function() {
	return {
		restrict: 'A',
		link: function(scope, element, attrs) {
			if(element.attr('scrollbar-x') == 'false') {
				element.removeClass('scroll-x');
			}
		}
	}
})

.directive('bet', ['Tools', function(Tools) {
	return {
		restrict: 'C',
		scope: true,
		link: function(scope, element, attrs) {
			var dataId = 'j'+(element.attr('data-id') || '00'), superId;
			var oddsElement = angular.element(element[0].querySelector('.bet-item'));
			var odds;
			scope.shareData.elements = scope.shareData.elements || angular.element(),
			scope.shareData.elements.push(element[0]),
			element.attr('data-id')&&(scope.$on('lotteryUpdateOdds', function(){
				superId = 'j'+(scope.curGame.superId || scope.curGame.panType+'00');
				if(scope.shareData.lotteryState==1&&scope.curGame.odds&&(scope.curGame.odds[dataId]||scope.curGame.odds[superId])){
					odds = scope.curGame.odds[dataId];
					odds ? oddsElement.data('odds')!=odds&&oddsElement.html(odds).data('odds', odds) : (odds = scope.curGame.odds[superId]);
				}else{
					odds = undefined;
					oddsElement.data('odds')&&oddsElement.html('--').removeData('odds');
				}
			}),
			scope.isExist(dataId)&&element.addClass('bet-choose'),
			element.bind('click', function() {
				var className;
				scope.curGame.panMode==2&&scope.hasFixed()&&(className = 'bet-circled');
				odds&&!element.hasClass('bet-circled')&&!element.hasClass('bet-disabled')&&(element.attr('data-once') && angular.forEach(scope.shareData.elements, function(e){e = angular.element(e),e.attr('data-once')&&e.attr('data-once')==element.attr('data-once')&&'j'+e.attr('data-id')!=dataId&&e.hasClass('bet-choose')&&(e.toggleClass('bet-choose'), scope.toggleSelect('j'+e.attr('data-id'), e.attr('data-pane')))}), scope.curGame.panLimit.max&&!element.hasClass('bet-choose')&&scope.betData[scope.currPane]&&scope.betData[scope.currPane].length+1>scope.curGame.panLimit.max? Tools.tip('只能选择'+(scope.curGame.panLimit.min&&scope.curGame.panLimit.min<scope.curGame.panLimit.max?scope.curGame.panLimit.min+'-':'')+scope.curGame.panLimit.max+'个号码') : (element.toggleClass(className || 'bet-choose'), scope.toggleSelect(dataId, element.attr('data-pane')), element.attr('data-once')=='a1'&&(scope.shareData.panFirstText = element.find('div').text()), element.attr('data-once')=='a2'&&(scope.shareData.panEndText = element.find('div').text())));
			}));
		}
	}
}])

.directive('subCol', function() {
	return {
		restrict: 'C',
		scope: true,
		link: function(scope, element, attrs) {
			!element.parent().hasClass('tips')&&element.bind('click', function() {
				scope.curGame.panMode = parseInt(element.attr('data-mode') || element.attr("data-show") || 1);
				element.attr('data-mode') ? (scope.shareData.panTitleText = element.find('a').text()) : (scope.curGame.panType = element.attr('data-pan') || element.attr('data-subPan'),
				element.attr('data-subPan')||(scope.curGame.panLimit = {
					min: parseInt(element.attr("data-min") || 0),
					max: parseInt(element.attr("data-max") || 0)
				}));
				scope.curGame.panType&&scope.$emit('lotteryUpdate', 'GetLines');
				// $ionicScrollDelegate.$getByHandle('sub-navs').scrollTo(45 * (index - 1) * 1.3, 0, true);
				if(!element.attr("data-show")&&scope.curGame.reset&&scope.curGame.reset.indexOf(scope.currPane)>=0) {
					scope.reset();
				}
			});
		}
	};
})

.directive('betView', function() {
	return {
		restrict: 'C',
		scope: true,
		link: function(scope, element, attrs) {
			var type, dataId;
			scope.curGame.superId = element.attr("data-sid");
			scope.curGame.superLimit = (element.attr("data-limit") || '').split(',');
			scope.curGame.panType = element.attr("data-pan");
			scope.curGame.panMode = parseInt(element.attr("data-mode") || element.attr("data-show") || 1);
			scope.curGame.panLimit = {
				min: parseInt(element.attr("data-min") || 0),
				max: parseInt(element.attr("data-max") || 0)
			};
			scope.curGame.panType&&scope.$emit('lotteryUpdate', 'GetLines');
			angular.forEach(element.find("*"), function(subElement){
				subElement = angular.element(subElement);
				if(subElement.hasClass("title-no")||subElement.hasClass("title")){
					type = subElement.text();
				}else if(subElement.hasClass("col")&&subElement.attr("data-id")){
					dataId = subElement.attr("data-id");
				}else if(subElement.hasClass("bet-content")){
					type&&dataId&&(scope.betContent['j'+dataId] = {
						type: type,
						content: subElement.text()
					});
				}
			});
		}
	};
})

.directive('qxcBet', function(Tools) {
	return {
		restrict: 'C',
		scope: true,
		link: function(scope, element, attrs) {
			var dataId = element.attr('data-id'), superId, odds;
			dataId&&(scope.$on('lotteryUpdateOdds', function(){
				superId = 'j'+scope.curGame.superId;
				odds = scope.shareData.lotteryState==1&&scope.curGame.odds&&scope.curGame.odds[superId] ? scope.curGame.odds[superId] : undefined;
			}),
			dataId = dataId.split(','),
			dataId[1] = parseInt(dataId[1]),
			dataId[2] = parseInt(dataId[2]),
			scope.shareData.elements = scope.shareData.elements || [],
			scope.shareData.elements[dataId[1]] = scope.shareData.elements[dataId[1]] || angular.element(),
			scope.shareData.elements[dataId[1]].push(element[0]),
			element.bind('click', function() {
				var temp, index, limit, count = [], disabled = [];
				!element.hasClass('bet-disabled')&&scope.curGame.superLimit&&odds&&(limit = parseInt(scope.curGame.superLimit[0]),
				scope.betData['qxc-temp'] = scope.betData['qxc-temp'] || [[], [], [], [], 0],
				temp = scope.betData['qxc-temp'][dataId[1]],
				element.toggleClass('bet-choose'),
				index = temp.indexOf(dataId[2]),
				index>=0?temp.splice(index, 1):(temp.push(dataId[2]),temp.sort()),
				scope.betData['qxc-temp'][4] = 0,
				scope.betData['qxc-temp'][dataId[1]] = temp,
				angular.forEach(scope.betData['qxc-temp'], function(d, i){
					i<4&&(limit==1?(scope.betData['qxc-temp'][4]+= d.length):(d.length>0?count.push(d.length):disabled.push(i)))
				}),
				limit>1&&(count.length==limit&&angular.forEach(count, function(d){
					scope.betData['qxc-temp'][4] = (scope.betData['qxc-temp'][4] || 1)*d
				}),
				angular.forEach(disabled, function(i){
					count.length==limit?scope.shareData.elements[i].addClass('bet-disabled'):scope.shareData.elements[i].removeClass('bet-disabled')
				})))
			}));
		}
	}
})

.directive('qxcQuickSelect', ['Tools', function(Tools) {
	return {
		restrict: 'C',
		scope: true,
		link: function(scope, element, attrs) {
			var sId = element.attr('data-sid');
			sId&&(sId = sId.split(','),
			scope.shareData.elements = scope.shareData.elements || [],
			scope.shareData.elements[sId[1]] = scope.shareData.elements[sId[1]] || angular.element(),
			scope.shareData.elements[sId[1]].push(element[0]),
			element.bind('click', function() {
				var popup = Tools.modal({
					title: element.text()+'位',
					scope: scope,
					template: '<div class="row"><div class="col col-33"><button class="button button-block button-positive" ng-click="onClick(1)" ng-disabled="disabled">全选</button></div><div class="col col-33"><button class="button button-block button-positive" ng-click="onClick(2)" ng-disabled="disabled">大数</button></div><div class="col col-33"><button class="button button-block button-positive" ng-click="onClick(3)" ng-disabled="disabled">小数</button></div></div><div class="row"><div class="col col-33"><button class="button button-block button-positive" ng-click="onClick(4)" ng-disabled="disabled">奇数</button></div><div class="col col-33"><button class="button button-block button-positive" ng-click="onClick(5)" ng-disabled="disabled">偶数</button></div><div class="col col-33"><button class="button button-block button-positive" ng-click="onClick(6)" ng-disabled="disabled">清空</button></div></div>',
					css: 'quick-select',
					cancelText: '关闭',
					okText: '全清',
					callback: function(){
						popup.close(),
						scope.betData['qxc-temp'] = [[], [], [], [], 0],
						angular.forEach(scope.shareData.elements, function(e){
							e.removeClass('bet-choose bet-disabled')
						})
					}
				});
				scope.disabled = element.hasClass('bet-disabled');
				scope.onClick = function(action){
					angular.forEach(scope.shareData.elements[sId[1]], function(e){
						e = angular.element(e);
						var dataId = e.attr('data-id');
						action>=6&&e.hasClass('bet-disabled')&&e.toggleClass('bet-disabled');
						if(dataId){
							dataId = dataId.split(',');
							dataId[2] = parseInt(dataId[2]);
							switch(!0){
								case action==1:
								case action==2&&dataId[2]>=5:
								case action==3&&dataId[2]<5:
								case action==4&&dataId[2]%2==1:
								case action==5&&dataId[2]%2!=1:
								dataId[0] = !e.hasClass('bet-choose');
								break;
								default:
								dataId[0] = e.hasClass('bet-choose');
								break;
							}
							dataId[0]&&e.triggerHandler('click')
						}
					});
					popup.close();
				}
			}))
		}
	};
}])

.directive('qxcAddButton', ['Tools', function(Tools) {
	return {
		restrict: 'C',
		scope: true,
		link: function(scope, element, attrs) {
			element.bind('click', function() {
				var temp = scope.betData['qxc-temp'] || [[], [], [], [], 0];
				scope.betData.betContent = scope.betData.betContent || [];
				scope.curGame.superLimit&&(temp[4]>0?(temp = angular.copy(temp),
				scope.betData.betContent.push(temp),
				scope.shareData.betCount+= temp[4],
				scope.betData[scope.currPane] = [true],
				scope.betData['qxc-temp'] = [[], [], [], [], 0],
				angular.forEach(scope.shareData.elements, function(e){
					e.removeClass('bet-choose bet-disabled')
				})):Tools.tip('您至少需要选择'+scope.curGame.superLimit[0]+'个位置的号码'))
			});
		}
	};
}])

.directive('qxcList', ['Tools', function(Tools) {
	return {
		restrict: 'EC',
		scope: true,
		template: '<div><div class="item" ng-repeat="data in betData.betContent" ng-click="showDetail($index)"><h3>{{data[0].length>0?data[0].join(""):"*"}}, {{data[1].length>0?data[1].join(""):"*"}}, {{data[2].length>0?data[2].join(""):"*"}}, {{data[3].length>0?data[3].join(""):"*"}}</h3><p class="ng-binding">共 {{data[4]}} 注，点击查看详情</p></div></div>',
		replace: true,
		link: function(scope, element, attrs) {
			scope.showDetail = function(index){
				scope.detail = angular.copy(scope.betData.betContent[index]);
				scope.detail[0] = scope.detail[0].length>0?scope.detail[0].join(", "):"* (任意数字)";
				scope.detail[1] = scope.detail[1].length>0?scope.detail[1].join(", "):"* (任意数字)";
				scope.detail[2] = scope.detail[2].length>0?scope.detail[2].join(", "):"* (任意数字)";
				scope.detail[3] = scope.detail[3].length>0?scope.detail[3].join(", "):"* (任意数字)";
				Tools.modal({
					scope: scope,
					title: '详情',
					template: '<div class="row"><div class="col ng-binding">仟位：{{detail[0]}}</div></div><div class="row"><div class="col ng-binding">佰位：{{detail[1]}}</div></div><div class="row"><div class="col ng-binding">拾位：{{detail[2]}}</div></div><div class="row"><div class="col ng-binding">个位：{{detail[3]}}</div></div><div class="row"><div class="col ng-binding">注数：{{detail[4]}}</div></div>',
					cancelText: '关闭',
					okText: '删除',
					callback: function(scope, popup){
						scope.betData.betContent.splice(index, 1);
						scope.shareData.betCount-= scope.detail[4];
						scope.betData[scope.currPane] = scope.shareData.betCount>0 ? [true] : [];
						popup.close();
					}
				});
			}
		}
	};
}]);