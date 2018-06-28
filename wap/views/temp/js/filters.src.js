angular.module('ionicz.lottery')

.filter('tick', function() {
	return function(value, text) {
		if(value <= 0) {
			return text;
		}
		
		var text = moment('00:00:00', 'HH:mm:ss').add(value, 's').format('mm:ss');
		if(value >= 3600) {
			var hh = Math.floor(value / 3600);
			if(hh < 10) {
				hh = '0' + hh;
			}
			text = hh + ':' + text;
		}
		return text;
	}
})

.filter('lotteryPcddNum', function($interpolate) {
	return function(nums) {
		if(nums.length != 3) {
			return;
		}
		
		var tmp = $interpolate('<span class="round">{{num}}</span>');

		var total = 0;
		var html = '<div class="nums-wrap">';
		for(var i=0; i<nums.length; i++) {
			html += tmp({num: nums[i]});
			total += parseInt(nums[i]);
		}
		
		html += '<span class="equal icon icon-dengyu"></span>';
		html += tmp({num: total});
		
		html += '</div>';
		return html;
	}
})

.filter('formatResult', function($interpolate) {
	return function(result, className){
		var $return = '', lastResult;
		!angular.isArray(result)&&(result = result.split(','));
		if(!className){
			$return+= '<div class="result-wrap">';
			angular.forEach(result, function(data){
				$return+= $interpolate('<span class="resultData">{{result}}</span>')({result: data});
			});
			$return+= '</div>';
		}else{
			$return+= '<div class="nums-wrap">';
			angular.forEach(result, function(data){
				$return+= $interpolate('<span class="{{class}} data-{{result}}">{{result}}</span>')({result: data, class: className});
			});
			$return+= '</div>';
		}
		return $return;
	}
})

.filter('formatMarkSix', function($interpolate) {
	return function(result, className){
		var $return = '', lastResult;
		!angular.isArray(result)&&(result = result.split(','));
		lastResult = result.splice(result.length-1);
		if(!className){
			$return+= '<div class="result-wrap">';
			angular.forEach(result, function(data){
				$return+= $interpolate('<span class="resultData">{{result}}</span>')({result: data});
			});
			$return+= '<span class="transparent icon icon-jiahao"></span>';
			$return+= $interpolate('<span class="resultData">{{result}}</span>')({result: lastResult[0]});
			$return+= '</div>';
		}else{
			$return+= '<div class="nums-wrap">';
			angular.forEach(result, function(data){
				$return+= $interpolate('<span class="{{class}} data-{{result.number}} {{result.color}}">{{result.number}}</span>')({result: data, class: className});
			});
			$return+= '<span class="'+className+' transparent icon icon-jiahao"></span>';
			$return+= $interpolate('<span class="{{class}} data-{{result.number}} {{result.color}}">{{result.number}}</span>')({result: lastResult[0], class: className});
			$return+= '</div>';
		}
		return $return;
	}
});