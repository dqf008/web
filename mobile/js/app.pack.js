window.onerror = function(errorMessage, scriptURI, lineNumber) {
    if (errorMessage.indexOf('srcEvent') > -1 || errorMessage == 'Script error.') {
        return true;
    }
};

// var domainConfig = getDomainConfig(appConfig.isLocal);

var ioniczApp = angular.module('ionicz', [
    'ionic',
    'oc.lazyLoad',
    'ngSanitize',
    'ionic-datepicker',
    'ionicz.config',
    'ionicz.providers',
    'ionicz.filters',
    'ionicz.directives',
    'ionicz.controllers',
    'ionicz.services',
    'ionicz.lottery',
    'ionicz.bank',
    'ionicz.agent',
    'angular-md5',
    'ngCookies'
])

    .run(['$ionicPlatform', '$rootScope', '$log', '$location', 'PATH', 'ROUTE_ACCESS', 'Tools', function($ionicPlatform, $rootScope, $log, $location, PATH, ROUTE_ACCESS, Tools) {
        $ionicPlatform.ready(function() {
            $log.debug("===================ready=======================");
            // Hide the accessory bar by default (remove this to show the accessory
            // bar above the keyboard for form inputs)
            if (window.cordova && window.cordova.plugins.Keyboard) {
                cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
                cordova.plugins.Keyboard.disableScroll(true);
                console.info("window.cordova.plugins.Keyboard");
            }
            if (window.StatusBar) {
                // org.apache.cordova.statusbar required
                StatusBar.styleDefault();
                console.info("StatusBar.styleDefault");
            }
        });

        // 路由切换监听，如果路由必须登陆才可以访问，则判断登陆状态，如果未登录则跳转到登陆页面
        $rootScope.$on('$stateChangeStart', function(event, toState, toParams, fromState, fromParams) {
            if (!$rootScope.inited) {
                return;
            }
            //Backdrop.show();
            var data = toState.data || {};
            if (data.access !== ROUTE_ACCESS.PUBLIC) {
                if (!$rootScope.isLogin) {
                    //console.info('未登录，跳转到登陆页');
                    Tools.tip('请先登录会员账号');
                    window.location.href = '#' + PATH.loginPath;
                    event.preventDefault();
                }

                // 不允许访客访问的路由需要验证是否是访客
                if (data.access == ROUTE_ACCESS.CHECK_TEST) {
                    if ($rootScope.isTestAccount) {
                        Tools.tip('试玩帐号无权访问，请先注册');
                        event.preventDefault();
                    }
                }
            }
        });
        $rootScope.$on('$stateChangeSuccess', function(event, toState, toParams, fromState, fromParams) {
            if (!$rootScope.inited) {
                return;
            }
            var data = toState.data || {};
            if (data.access !== ROUTE_ACCESS.PUBLIC && !$rootScope.isLogin) {
                window.location.href = '#' + PATH.loginPath;
                event.preventDefault();
                // $location.path(PATH.loginPath);
            }
            // if($rootScope.inited) {
            // 	Backdrop.hide(500);
            // }
        });

        Tools.ajax({
            method: 'POST',
            url: 'ajax.php',
            params: {
                action: "config"
            },
            success: function(data) {
                $rootScope.appConfig = data;
                $rootScope.$broadcast('appConfig.load');
            }
        });

        Backdrop.hide(500);
        if (!$rootScope.firstTime) {
            var ua = navigator.userAgent.toLocaleLowerCase();
            $rootScope.firstTime = true;
            if ("ucbrowser" == ua.match(/ucbrowser/i) && "ios" == Tools.userAgent() && $location.path() == PATH.loginPath) {
                window.location.href = "#" + e.homePath;
            }
        }
    }]);

angular.module('ionicz.lottery', []);
angular.module('ionicz.bank', []);
angular.module('ionicz.agent', []);
angular.module('ionicz.config', [])

    .constant('ENV', {
        'moduleName': 'ionicz',
        'version': '1.0.1'
    })

    .constant('PATH', {
        'loginPath': '/login',
        'regPath': '/reg',
        'homePath': '/home'
    })

    .constant('ROUTE_ACCESS', {
        'PUBLIC': 'public',
        'CHECK_TEST': 'check_test'
    })

    .constant('DOMAIN_CONFIG', {
        apiPath: '',
        staticPath: 'config/',
        webUrl: window.location.protocol + '//' + window.location.hostname + '/',
        mobileUrl: window.location.protocol + '//' + window.location.hostname + '/m/',
        agentUrl: ''
    })

    .config(['$logProvider', function($logProvider) {
        $logProvider.debugEnabled(false);
    }])

    .config(['$ionicConfigProvider', function($ionicConfigProvider) {
        var configProperties = {
            views: {
                maxCache: 5,
                forwardCache: true,
                transition: 'no'
            },

            navBar: {
                alignTitle: 'center'
            },

            backButton: {
                icon: 'ion-chevron-left',
                text: ' ',
                previousTitleText: false
            }
        };

        $ionicConfigProvider.setPlatformConfig('android', configProperties);
        $ionicConfigProvider.setPlatformConfig('ios', configProperties);
    }])

    .config(['$httpProvider', function httpProvider($httpProvider) {
        //$httpProvider.defaults.headers.put['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
        //$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';

        $httpProvider.defaults.headers.post['Accept'] = '*/*';

        $httpProvider.defaults.transformRequest = [function(data) {
            var param = function(obj) {
                var query = '';
                var name, value, fullSubName, subName, subValue, innerObj, i;

                for (name in obj) {
                    value = obj[name];

                    if (value instanceof Array) {
                        for (i = 0; i < value.length; ++i) {
                            subValue = value[i];
                            fullSubName = name + '[' + i + ']';
                            innerObj = {};
                            innerObj[fullSubName] = subValue;
                            query += param(innerObj) + '&';
                        }
                    } else if (value instanceof Object) {
                        for (subName in value) {
                            subValue = value[subName];
                            fullSubName = name + '[' + subName + ']';
                            innerObj = {};
                            innerObj[fullSubName] = subValue;
                            query += param(innerObj) + '&';
                        }
                    } else if (value !== undefined && value !== null) {
                        query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
                    }
                }

                return query.length ? query.substr(0, query.length - 1) : query;
            };

            return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
        }];

        $httpProvider.interceptors.push(['$rootScope', '$location', '$q', 'PATH', function($rootScope, $location, $q, PATH) {
            return {
                request: function(config) {
                    return config || $q.when(config);
                }
                /*,
                			responseError: function(response) {
                				console.info('responseError');
                				console.info(response);
                				if(response.status == 403) {
                					var My = $injector.get('My');
                					My.clearMsgTimer();
                					$location.path(PATH.loginPath);
                				}
                				if (response.status === 401 || response.status === 403) {
                					alert('登录超时，点击确定回到登录页面');
                					window.location.href = '/login.html';
                				} else if (response.status === 500) {
                					//$location.path('/error');
                				}

                				return $q.reject(response);
                			}*/
            };
        }]);
    }]);
angular.module('ionicz.controllers', [])

    .controller('AppCtrl', ['$scope', '$rootScope', '$location', '$ionicHistory', '$log', 'Tools', 'PATH', 'My', 'md5', 'DOMAIN_CONFIG', function($scope, $rootScope, $location, $ionicHistory, $log, Tools, PATH, My, md5, DOMAIN_CONFIG) {
        $scope.My = My;
        $rootScope.appConfig = {};
        $rootScope.appData = {};
        $rootScope.addHome = false;
        $log.debug('AppCtrl');

        /*Tools.lazyLoad([Tools.staticPath() + "static.js?_" + Math.random()], function() {
        	$rootScope.appConfig = angular.extend(CONFIG_MAP, appConfig);
        	My.init();

        	// Tools.lazyLoad([Tools.staticPath() + "messages.js"]);
        });*/

        $scope.$on('appConfig.load', function() {
            $rootScope.appConfig.tips.seconds > 0 && Tools.modal({
                title: $rootScope.appConfig.tips.title,
                template: $rootScope.appConfig.tips.content,
                cancelText: '我知道了'
            }, $rootScope.appConfig.tips.seconds * 1000);
            My.init();

            $rootScope.addHome = Tools.userAgent() == 'ios' && !Tools.getData("addedHome") && $scope.appConfig.addHome;
            $rootScope.desktopIcon = $scope.appConfig.appIconUrl;
            angular.element(document.getElementById("appTitle")).prop("content", $scope.appConfig.name);
            angular.element(document.getElementById("appTouchIcon")).prop("href", $scope.appConfig.appIconUrl);
            $scope.appConfig.color && angular.element(document.head).append("<style type='text/css'>body .bar.bar-positive{background-color:" + $scope.appConfig.color + "!important}</style>");
        });

        // Tools.ajax({
        // 	method: 'POST',
        // 	url: 'ajax.php',
        // 	params: {action: "config"},
        // 	success: function(data) {
        // 		$rootScope.appConfig = data;
        // 		$scope.$broadcast('appConfig.load');
        // 		data.tips.seconds>0&&Tools.modal({
        // 			title: data.tips.title,
        // 			template: data.tips.content,
        // 			cancelText: '我知道了'
        // 		}, data.tips.seconds*1000);
        // 		My.init();
        // 	}
        // });

        $scope.staticPath = Tools.staticPath();
        $scope.pcUrl = DOMAIN_CONFIG.webUrl;

        // 如果是在子页面刷新，跳转回顶级页面
        /*var paths = $location.path().split('/');
        if (paths.length > 3) {
        	$location.path('/' + paths[1] + '/' + paths[2]);
        }*/

        /*$scope.$on('$ionicView.afterEnter', function(event, viewData) {
        	$log.debug('AppCtrl afterEnter');
        	Backdrop.hide(500);
        });*/

        $scope.back = Tools.back();

        $scope.logout = function() {
            Tools.confirm('确认要退出该帐号？', function() {
                var token = My.getToken();
                if (!token) {
                    $location.path(PATH.loginPath);
                    return;
                }

                Tools.ajax({
                    method: 'POST',
                    url: 'ajax.php',
                    params: {
                        action: "logout",
                        token: token
                    },
                    backdrop: true,
                    success: function(data) {
                        $location.path(PATH.loginPath);
                        $rootScope.isLogin = false;
                    }
                });
                My.clear();
                // location.href='/user/login';
            });
        };

        $scope.guestLogin = function() {
            Tools.ajax({
                method: 'POST',
                url: 'ajax.php',
                backdrop: true,
                params: {
                    action: 'guest',
                    account: '!guest!',
                    password: md5.createHash('!guest!')
                },
                success: function(data) {
                    if (data && data.token) {
                        Tools.tip('登陆成功');
                        My.loginSuccess(data);
                        $location.path(PATH.homePath);
                    } else {
                        Tools.alert('登录失败');
                    }
                },
                error: function(data) {
                    Tools.alert(data.msg || '登录失败');
                }
            });
        };

        $scope.refreshMoney = function() {
            My.refreshMoney();
        };

        $rootScope.debugMsgList = [];
        $scope.addDebugMsg = function(msg) {
            var lastMsg = $rootScope.debugMsgList[$rootScope.debugMsgList.length - 1];
            if (lastMsg && msg == lastMsg.msg) {
                $rootScope.debugMsgList[$rootScope.debugMsgList.length - 1] = {
                    time: moment().format('HH:mm:ss SSS'),
                    msg: msg,
                    count: lastMsg.count + 1
                };
            } else {
                $rootScope.debugMsgList.push({
                    time: moment().format('HH:mm:ss SSS'),
                    msg: msg,
                    count: 1
                });
            }
        };
        $scope.showTestModal = function() {
            Tools.modal({
                templateUrl: 'test-template',
                title: '调试数据'
            });
        };
    }])

    .controller('HomeCtrl', ['$scope', '$rootScope', '$log', '$ionicSlideBoxDelegate', '$document', '$location', '$ionicScrollDelegate', 'Tools', function($scope, $rootScope, $log, $ionicSlideBoxDelegate, $document, $location, $ionicScrollDelegate, Tools) {
        var updateActivity = function() {
            $scope.activityData = angular.copy($rootScope.appData.activity.cache);
            $scope.activityData.splice(3);
        };

        $scope.$on('appConfig.load', function(event) {
            $ionicSlideBoxDelegate.update();
            $document[0].title = $scope.appConfig.name + ' - 手机版';
        });

        $log.debug("HomeCtrl...");
        $scope.activityData = [];
        $scope.type = 'hot';
        $scope.$on('$ionicView.afterEnter', function() {
            // $document[0].title = $scope.appConfig.name;
            $scope.appConfig.name && ($document[0].title = $scope.appConfig.name + ' - 手机版');
            $log.debug("HomeCtrl $ionicView.afterEnter");
            !$rootScope.appData.activity && ($rootScope.appData.activity = {});
            !$rootScope.appData.activity.cache ? Tools.ajax({
                method: 'POST',
                url: 'ajax.php',
                params: {
                    action: 'activity'
                },
                success: function(data) {
                    if (data && data.status == 1) {
                        $scope.activityData = data.msg;
                        $rootScope.appData.activity.cache = data.msg;
                        $rootScope.appData.activity.list = data.list;
                        updateActivity();
                    }
                }
            }) : updateActivity();
        });
        $scope.closeAddHome = function() {
            Tools.setData('addedHome', true);
            $rootScope.addHome = false;
        };
        $scope.changeType = function(type) {
            $scope.type = type;
            $ionicScrollDelegate.resize();
        };
        $scope.enterGame = function(gameId) {
            if ($rootScope.isLogin) {
                var url = '../cj/live/?mobile=true&type=' + gameId,
                    gameWindow = Tools.openWindow(url);
                if (!gameWindow || gameWindow.closed) {
                    Tools.confirm('无法在新窗口打开游戏，是否离开当前页面继续进入？', function() {
                        window.location.href = url;
                    });
                }
            } else {
                Tools.tip('请先登录会员账号');
            }
        };
        $scope.sign = function () {
            if ($rootScope.isLogin) {
                Tools.ajax({
                    method:"GET",
                    url:"../static/sign/sign.php",
                    backdrop:!0,
                    params:{
                        type:"sign"
                    },
                    success:function(data) {
                        data = data.match(/\(([^\)]+)\)/)
                        if (data[1] != undefined) {
                            data = angular.fromJson(data[1])
                            if ("success" == data.status) {
                                var msg = [];
                                if (data.data[0] > 0) {
                                    msg.push("本次签到获得 " + data.data[0] + " 彩金奖励");
                                } else {
                                    msg.push("手气不佳，本次没有到获得奖励");
                                }
                                if (data.data[4] > 0) {
                                    msg.push("已连续签到 " + data.data[3] + " 天");
                                    msg.push("下次签到可获得 " + data.data[4] + " 彩金奖励");
                                }
                                msg.push("累积签到 " + data.data[1] + " 天");
                                msg.push("总共获得 " + data.data[2] + " 彩金奖励");
                                Tools.alert([ "签到成功", msg.join("<br />") ]);
                            } else {
                                Tools.alert([ "签到失败", data.message ]);
                            }
                        } else {
                            Tools.tip("系统繁忙，请稍后再试试");
                        }
                    }
                });
            } else {
                Tools.tip("请先登录会员账号");
            }
        };
        $scope.go = function (url) {
            $location.path(url);
        };
        $scope.href = function (url) {
            window.location.href = url;
        };
        $scope.colClick = function(func, argv) {
            if (typeof $scope[func] != 'undefined') {
                $scope[func](argv);
            }
        };
    }])

    .controller('LoginCtrl', ['$scope', '$location', '$log', 'Tools', 'PATH', '$cookies', 'My', 'md5', function($scope, $location, $log, Tools, PATH, $cookies, My, md5) {
        $scope.$on('$ionicView.beforeEnter', function(event, viewData) {
            $scope.$broadcast('validateCodeChange');
            $scope.loginData.username = $cookies.get('username');
            //$scope.loginData.password = $cookies.get('password');
        });

        $scope.loginData = {};

        $scope.login = function() {
            $scope.msg = '';

            Tools.ajax({
                method: 'POST',
                url: 'ajax.php',
                backdrop: true,
                params: {
                    action: "login",
                    username: $scope.loginData.username,
                    password: $scope.loginData.password,
                    vlcodes: $scope.loginData.vcode
                },
                success: function(data) {
                    if (data.msg == "success") { //登陆成功
                        var expireDate = new Date();
                        expireDate.setDate(expireDate.getDate() + 30); //设置cookie保存30天
                        $cookies.put('username', $scope.loginData.username, {
                            'expires': expireDate
                        });
                        //$cookies.put('password', $scope.loginData.password, {'expires': expireDate});

                        $location.path(PATH.homePath);
                        My.loginSuccess(data);
                    } else {
                        $scope.msg = data.msg;
                        $scope.$broadcast('validateCodeChange');
                    }
                },
                error: function(data) {
                    $scope.msg = data.msg;
                    // 发送广播消息，刷新验证码
                    $scope.$broadcast('validateCodeChange');
                }
            });
        };

        $scope.checkUserName = function() {
            // 处理苹果手机中文输入状态下输入用户名可能带有空格而造成登录按钮禁用的问题
            $scope.loginData.username = $scope.loginData.username.replace(/\s+/g, "");
        };
    }])

    .controller('RegCtrl', ['$scope', '$rootScope', '$location', '$log', '$timeout', 'Tools', 'My', 'PATH', '$cookies', 'md5', '$ionicScrollDelegate', function($scope, $rootScope, $location, $log, $timeout, Tools, My, PATH, $cookies, md5, $ionicScrollDelegate) {
        $scope.config = {};
        $scope.isChecked = false;
        $scope.$on('$ionicView.beforeEnter', function(event, viewData) {
            $scope.$broadcast('validateCodeChange');
            $scope.regData = {};
            $scope.setStep(1);
        });
        $scope.checkUserName = function() {
            Tools.ajax({
                method: 'GET',
                url: '../check_username.php',
                params: {
                    username: $scope.regData.username
                },
                success: function(data) {
                    $scope.isChecked = true;
                    $scope.usernameExist = data != 'y';
                }
            });
        };
        $scope.resetCheck = function() {
            $scope.isChecked = false;
            $scope.usernameExist = false;
        };
        $scope.checkFullName = function() {
            if (!$scope.regData.fullName) {
                $scope.fullNameIsOk = false;
                return false;
            } else {
                //		$scope.fullNameIsOk = /^[a-zA-Z ]{1,20}$/.test(fullName) || /^[\u4e00-\u9fa5]{1,10}$/.test(fullName);
                $scope.fullNameIsOk = /^[\u4e00-\u9fa5]{2,5}$/.test($scope.regData.fullName);
                return $scope.fullNameIsOk;
            }
        };
        $scope.setStep = function(step) {
            $ionicScrollDelegate.$getByHandle('regScroll').scrollTop();
            $scope.step = step;
            $scope.config = $rootScope.appConfig.register;
        };
        $scope.reg = function() {
            switch (!0) {
                case !$scope.regData.username:
                case !$scope.regData.username.match(/^[A-Za-z0-9]{5,15}$/):
                    Tools.tip('账户格式不正确');
                    break;
                case !$scope.regData.fullName:
                case !$scope.checkFullName():
                    Tools.tip('真实姓名格式不正确');
                    break;
                case !$scope.regData.password:
                case $scope.regData.password.length < 6 || $scope.regData.password.length > 20:
                    Tools.tip('密码长度不正确');
                    break;
                case $scope.regData.password != $scope.regData.passwordRpt:
                    Tools.tip('确认密码不正确');
                    break;
                case $scope.regData.fundPwd.length != 6:
                case !$scope.regData.fundPwd.match(/^\d+$/):
                    Tools.tip('取款密码格式不正确');
                    break;
                case $scope.regData.fundPwd != $scope.regData.fundPwdRpt:
                    Tools.tip('确认取款密码不正确');
                    break;
                case $scope.config.qq && !$scope.regData.email.match(/^(([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?))|[1-9]\d{4,9}$/):
                    Tools.tip('邮箱地址或QQ号码不正确');
                    break;
                case $scope.config.tel && !$scope.regData.tel.match(/^\d{6,13}$/):
                    Tools.tip('手机号码不正确');
                    break;
                case $scope.config.question && !$scope.regData.ask:
                    Tools.tip('请选择安全问题');
                    break;
                case $scope.config.question && $scope.regData.ask == 'Other' && !$scope.regData.askOther:
                    Tools.tip('请填写安全问题');
                    break;
                case $scope.config.question && !$scope.regData.question:
                    Tools.tip('请填写安全问题答案');
                    break;
                case $scope.config.wechat && !$scope.regData.wechat.match(/^[A-Za-z0-9]+$/):
                    Tools.tip('微信账号不正确');
                    break;
                case !$scope.regData.vcode:
                    Tools.tip('请输入验证码');
                    break;
                default:
                    Tools.ajax({
                        method: 'POST',
                        url: '../reg.php',
                        params: {
                            key: 'add',
                            zcname: $scope.regData.username,
                            zcturename: $scope.regData.fullName,
                            zcpwd1: $scope.regData.password,
                            zcpwd2: $scope.regData.password,
                            qk_pwd: $scope.regData.fundPwd,
                            zcemail: $scope.regData.email,
                            zcweixin: $scope.regData.wechat,
                            zctel: !$scope.regData.tel ? '保密' : $scope.regData.tel,
                            ask: $scope.regData.ask == 'Other' ? $scope.regData.askOther : !$scope.regData.ask ? '无' : $scope.regData.ask,
                            answer: !$scope.regData.question ? '无' : $scope.regData.question,
                            zcyzm: $scope.regData.vcode,
                            jsr: $scope.config.agent ? void 0 : $scope.config.agent
                        },
                        backdrop: true,
                        success: function(data) {
                            data = data.match(/alert\("([^"]+)"\)/);
                            if (!data) {
                                Tools.tip('发生未知错误，请重试');
                                $scope.$broadcast('validateCodeChange');
                            } else if (data = data[1], data.indexOf('注册成功') >= 0) {
                                Tools.tip('注册成功');
                                $cookies.put('token', 'ok');
                                My.init();
                                $location.path(PATH.homePath);
                            } else {
                                Tools.tip(data);
                                $scope.$broadcast('validateCodeChange');
                                data.indexOf('验证码') < 0 && ($scope.step = 1);
                            }
                        }
                    });
                    break;
            }
        };
    }]);
angular.module('ionicz.directives', [])

    .directive('validcodeField', ['$compile', '$timeout', 'Tools', function($compile, $timeout, Tools) {
        return {
            restrict: 'C',
            require: 'ngModel',
            scope: true,
            link: function(scope, element, attrs, ngModel) {
                if ('INPUT' !== element[0].nodeName || attrs.type !== 'text') {
                    throw new Error('Invalid input type for resetField: ' + attrs.type);
                }

                function getUrl() {
                    return Tools.apiPath() + '../yzm.php?_=' + (new Date()).getTime();
                }

                var dom = $compile('<img class="valid-img" src="' + getUrl() + '">')(scope);
                element.addClass('reset-field');
                element.after(dom);

                dom.bind('click', function() {
                    dom.attr('src', getUrl());
                });

                scope.$on('validateCodeChange', function() {
                    dom.attr('src', getUrl());
                    ngModel.$setViewValue(null);
                    ngModel.$render();
                });
            }
        }
    }])

    .directive('passwordEye', ['$compile', function($compile) {
        return {
            restrict: 'C',
            scope: true,
            link: function(scope, element, attrs) {
                var types = ['password', 'text'];
                if ('INPUT' === element[0].nodeName && types.indexOf(attrs.type) == -1) {
                    throw new Error('Invalid input type for resetField: ' + attrs.type);
                }

                scope.enabled = false;
                var i = $compile('<i ng-click="showPwd()" class="icon icon-eye" ng-class="{\'icon-eyes\':enabled,\'icon-eye\':!enabled}"></i>')(scope);
                element.after(i);
                element.parent().addClass('input-icon');

                scope.showPwd = function() {
                    if (scope.enabled) {
                        scope.enabled = false;
                        element.attr('type', 'password');
                    } else {
                        scope.enabled = true;
                        element.attr('type', 'text');
                    }
                }
            }
        }
    }])

    .directive('resetField', ['$compile', '$timeout', function($compile, $timeout) {
        return {
            restrict: 'C',
            require: 'ngModel',
            scope: true,
            link: function(scope, element, attrs, ngModel) {
                var s = /text|search|tel|url|email|password|number/g;
                if ('INPUT' === element[0].nodeName) {
                    if (!s.test(attrs.type)) {
                        throw new Error('Invalid input type for resetField: ' + attrs.type)
                    }
                } else if ('TEXTAREA' !== element[0].nodeName) {
                    throw new Error('resetField is limited to input and textarea elements');
                }
                var dom = $compile('<i ng-show="enabled" ng-click="reset();" class="icon icon-close"></i>')(scope);
                element.addClass('reset-field');
                element.after(dom);

                scope.reset = function() {
                    ngModel.$setViewValue(null);
                    ngModel.$render();
                    scope.enabled = true;
                };

                element.bind('focus keyup', function() {
                    $timeout(function() {
                        scope.enabled = !ngModel.$isEmpty(element.val());
                        scope.$apply()
                    }, 0, false);
                }).bind('blur', function() {
                    $timeout(function() {
                        scope.enabled = false;
                        scope.$apply();
                    }, 0, false);
                });
            }
        }
    }])

    .directive('dateSelect', ['$compile', '$timeout', '$interpolate', function($compile, $timeout, $interpolate) {
        return {
            restrict: 'C',
            require: 'ngModel',
            template: function(element, attrs) {
                var tmp = $interpolate('<option value="{{value}}" label="{{text}}">{{text}}</option>');

                for (var i = 0; i < 7; i++) {
                    var m = moment().subtract(i, 'd');
                    element.append(tmp({
                        value: m.format('YYYYMMDD'),
                        text: m.format('YYYY-MM-DD')
                    }));
                }
            },
            link: function(scope, element, attrs, ngModel) {
                $timeout(function() {
                    // 如果没有设置默认值，则默认选中当天
                    if (!ngModel.$viewValue) {
                        ngModel.$setViewValue(moment().format('YYYYMMDD'));
                        ngModel.$render();
                    }
                }, 100, false);
            }
        }
    }])

    .directive('datetimeLocal', ['$compile', '$timeout', '$interpolate', function($compile, $timeout, $interpolate) {
        return {
            restrict: 'C',
            require: 'ngModel',
            link: function(scope, element, attrs, ngModel) {
                var nowTime = moment().format('YYYY-MM-DDTHH:mm:ss');
                ngModel.$setViewValue(nowTime);
                element.attr('value', nowTime);
                element.attr('type', 'datetime-local');
            }
        }
    }])
    .directive('zlNotice', ['Tools', function(Tools) {
        return {
            restrict: 'EC',
            scope: true,
            template: '<marquee scrollamount="3" style="height:35px"><span ng-repeat="msg in appConfig.notices" style="padding-right:20px" ng-click="showNoticeInfo();">{{msg}}</span></marquee>',
            replace: true,
            link: function(scope, element, attrs) {
                scope.showNoticeInfo = function(index) {
                    Tools.modal({
                        title: '网站公告',
                        template: "<p>" + scope.appConfig.notices.join("</p><hr/><p>") + "</p>"
                    });
                }
            }
        }
    }])
    .directive("curTabs", function() {
        return {
            restrict: "E",
            transclude: !0,
            scope: {
                tabIndex: "@",
                change: "&onChange"
            },
            controller: ["$scope", "$element", function(scope) {
                var pane = scope.panes = [];
                scope.select = function(element) {
                    var index = 0;
                    angular.forEach(pane, function(pane) {
                        pane.selected = !1,
                        pane == element && (scope.tabIndex = index),
                            index++
                    }),
                        element.selected = !0
                },
                    this.addPane = function(element) {
                        0 == pane.length && scope.select(element),
                            pane.push(element),
                        pane.length - 1 == scope.tabIndex && scope.select(element)
                    }
            }],
            compile: function(scope, element) {
                element.$set("class", element["class"] || "tab-bable", !0)
            },
            template: '<div><ul class="tab-nav"><li ng-repeat="pane in panes" class="{{pane.tabscale}}" ng-class="{active:pane.selected}"><a ng-click="select(pane);change({index:tabIndex});">{{pane.title}}</a></li></ul><div class="tab-content" ng-transclude></div></div>',
            replace: !0
        }
    })
    .directive("curTab", function() {
        return {
            require: "^curTabs",
            restrict: "E",
            transclude: !0,
            scope: {
                title: "@",
                tabscale: "@"
            },
            link: function(e, t, a, n) {
                n.addPane(e)
            },
            template: '<div class="tab-pane" ng-class="{active: selected}" ng-transclude></div>',
            replace: !0
        }
    })
    .directive('clipBoard', ['Tools', function(Tools) {
        return {
            restrict: 'C',
            scope: true,
            link: function(scope, element, attrs) {
                var clipboard = new Clipboard(element[0]);
                clipboard.on('success', function(e) {
                    Tools.tip('复制成功');
                    e.clearSelection();
                });
                clipboard.on('error', function(e) {
                    Tools.modal({
                        scope: scope,
                        title: '请复制',
                        template: '<div class="row"><div class="col"><div class="item item-input"><input type="text" class="txt-info input-select" value="' + element.attr('data-clipboard-text') + '"></div></div></div>'
                    });
                });
            }
        }
    }])
    .directive('inputSelect', function() {
        return {
            restrict: 'C',
            scope: true,
            link: function(scope, element, attrs) {
                element[0].focus();
                element[0].select();
            }
        }
    });
angular.module('ionicz.filters', [])

    .filter('money', function() {
        return function(value) {
            if (angular.isUndefined(value)) {
                return;
            }
            var num = new Number(value);
            return num.toFixed(2);
        }
    })

    .filter('number', function() {
        return function(input) {
            return parseInt(input, 10);
        };
    })

    .filter('stime', function() {
        return function(text, format) {
            if (!format) {
                format = 'MM-DD HH:mm';
            }
            return moment(text).format(format);
        };
    })

    .filter('short', function() {
        return function(value, len, prefix) {
            if (!angular.isUndefined(value)) {
                angular.isFunction(value.toString) && (value = value.toString());
                value.length > len && (value = prefix + value.substring(value.length - 10));
                return value;
            }
        }
    });
angular.module('ionicz.providers', [])

    .provider('Storage', function() {
        this.$get = function() {
            return {
                set: function(key, data) {
                    return window.localStorage.setItem(key, window.JSON.stringify(data));
                },
                get: function(key) {
                    return window.JSON.parse(window.localStorage.getItem(key));
                },
                remove: function(key) {
                    return window.localStorage.removeItem(key);
                },

                session: {
                    set: function(key, data) {
                        return window.sessionStorage.setItem(key, window.JSON.stringify(data));
                    },
                    get: function(key) {
                        return window.JSON.parse(window.sessionStorage.getItem(key));
                    },
                    remove: function(key) {
                        return window.sessionStorage.removeItem(key);
                    }
                }
            };
        }
    })

    .provider('Tools', ['DOMAIN_CONFIG', function(DOMAIN_CONFIG) {
        var staticPath = function() {
            return DOMAIN_CONFIG.staticPath;
        };

        var apiPath = function() {
            return DOMAIN_CONFIG.apiPath;
        };

        return {
            staticPath: staticPath,
            apiPath: apiPath,

            $get: ['$timeout', 'ENV', '$rootScope', '$http', '$state', '$injector', '$location', '$log', '$ionicPopup', '$ocLazyLoad', '$ionicLoading', '$cookies', '$ionicHistory', 'PATH', function($timeout, ENV, $rootScope, $http, $state, $injector, $location, $log, $ionicPopup, $ocLazyLoad, $ionicLoading, $cookies, $ionicHistory, PATH) {
                var self = this;
                var setData = function(name, value) {
                    return window.localStorage.setItem(name, window.JSON.stringify(value))
                };
                var getData = function(name) {
                    return window.JSON.parse(window.localStorage.getItem(name))
                };
                var ajax = function(opts) {
                    var params = opts.params || {};
                    var method = opts.method || 'POST';
                    var dataType = opts.dataType || 'QUERY';
                    var req = {
                        method: method,
                        url: apiPath() + opts.url,
                        headers: {}
                    };

                    var token = $cookies.get('token');
                    if (token) {
                        params['x-session-token'] = token;
                    }

                    if (method.toLocaleUpperCase() == 'POST') {
                        if (dataType.toLocaleUpperCase() == 'JSON') {
                            req['data'] = angular.toJson(params);
                            req.headers['Content-Type'] = 'application/json; charset=UTF-8';
                        } else {
                            req['data'] = params;
                            req.headers['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
                        }
                    } else {
                        req['params'] = params;
                    }

                    if (opts.backdrop === true) {
                        Backdrop.show();
                    }

                    $http(req).success(function(data) {
                        opts.success(data);
                        if (opts.backdrop === true) {
                            Backdrop.hide();
                        }
                    }).error(function(data, status, header, config) {
                        if (status == 403) {
                            var My = $injector.get('My');
                            My.clearMsgTimer();
                            $location.path(PATH.loginPath);
                        } else if (angular.isFunction(opts.error)) {
                            opts.error(data);
                        } else {
                            $ionicLoading.show({
                                template: data.msg || '系统繁忙，请稍候重试',
                                duration: 2000
                            });
                        }

                        if (opts.backdrop === true) {
                            Backdrop.hide(500);
                        }
                    });
                };

                var tip = function(content, duration) {
                    return $ionicLoading.show({
                        template: content,
                        duration: duration || 1000
                    });
                };

                var alert = function(msg, callback, duration) {
                    angular.isString(msg) && (msg = [msg]);
                    !angular.isUndefined(msg[1]) && (msg[1] = "<div style='text-align:center'>" + msg[1] + "</div>");
                    var alertPopup = $ionicPopup.alert({
                        title: msg[0],
                        template: msg[1],
                        okText: '确认'
                    });

                    if (angular.isFunction(callback)) {
                        alertPopup.then(function(res) {
                            callback();
                        });
                    }!duration || $timeout(function() {
                        alertPopup.close();
                    }, duration);
                    return alertPopup;
                };

                var confirm = function(msg, callback, duration) {
                    var confirmPopup = $ionicPopup.confirm({
                        title: msg,
                        cancelText: '取消',
                        okText: '确认'
                    });

                    var submitFlag = false;
                    confirmPopup.then(function(res) {
                        // 防止重复提交
                        if (submitFlag) {
                            return;
                        }
                        submitFlag = true;
                        if (res) {
                            callback();
                        }
                    });
                    !duration || $timeout(function() {
                        confirmPopup.close();
                    }, duration);
                    return confirmPopup;
                };

                var modal = function(opts, duration) {
                    if (!opts.templateUrl && !opts.template) {
                        return;
                    }

                    var scope = opts.scope;
                    if (!scope) {
                        scope = $rootScope.$new();
                    }

                    scope.modalData = {};
                    var submitFlag = false;

                    // 自定义弹窗
                    var popup = $ionicPopup.show({
                        templateUrl: opts.templateUrl,
                        template: opts.template,
                        title: opts.title || '消息',
                        scope: scope,
                        cssClass: opts.css || "info-mdf",
                        buttons: angular.isFunction(opts.callback) ? [{
                            text: opts.cancelText || '取消'
                        },
                            {
                                text: opts.okText || '确定',
                                type: 'button-positive',
                                onTap: function(e) {
                                    // 防止重复提交
                                    if (submitFlag) {
                                        return;
                                    }
                                    submitFlag = opts.callback(scope, popup);
                                    angular.isUndefined(submitFlag) && (submitFlag = !0);
                                    e.preventDefault();
                                }
                            }
                        ] : [{
                            text: '<b>' + (opts.cancelText || '确定') + '</b>',
                            type: 'button-positive'
                        }]
                    });
                    !duration || $timeout(function() {
                        popup.close();
                    }, duration);
                    return popup;
                };

                var lazyLoad = function(files, callback) {
                    $ocLazyLoad.load({
                        name: ENV.moduleName,
                        files: files
                    }).then(function() {
                        if (angular.isFunction(callback)) {
                            callback();
                        }
                    });
                };

                var isPublicPage = function() {
                    if ($state.current.name === "") {
                        return true;
                    } else if (!$state.current.data || $state.current.data.access != 'public') {
                        return false;
                    } else {
                        return true;
                    }
                };

                var isHomePage = function() {
                    if ($location.path() == PATH.homePath) {
                        return true;
                    } else {
                        return false;
                    }
                };

                var back = function(defaultUrl) {
                    return function() {
                        $ionicHistory.backView() ? $ionicHistory.goBack() : $location.path(angular.isUndefined(defaultUrl) ? PATH.homePath : defaultUrl);
                    }
                };

                var userAgent = function() {
                    var ua = navigator.userAgent.toLocaleLowerCase(),
                        isLinux = String(navigator.platform).indexOf("linux") > -1,
                        isAndroid = "android" == ua.match(/android/i),
                        isWP = "windows mobile" == ua.match(/windows mobile/i),
                        iPad = "ipad" == ua.match(/ipad/i),
                        iPhone = "iphone os" == ua.match(/iphone os/i),
                        isWindows = "windows nt" == ua.match(/windows nt/i);
                    return isLinux ? "linux" : iPad || iPhone ? "ios" : isWP ? "wp" : isWindows ? "pc" : isAndroid ? "android" : void 0
                };

                var openWindow = function(url) {
                    return "android" == userAgent() ? window.open(url) : window.open(url, "_blank", "resizable=yes");
                };

                return {
                    setData: setData,
                    getData: getData,
                    ajax: ajax,
                    tip: tip,
                    alert: alert,
                    confirm: confirm,
                    modal: modal,
                    lazyLoad: lazyLoad,
                    isPublicPage: isPublicPage,
                    isHomePage: isHomePage,
                    staticPath: staticPath,
                    apiPath: apiPath,
                    back: back,
                    openWindow: openWindow,
                    userAgent: userAgent,
                    rootDomain: getRootDomain
                };
            }]
        }
    }]);
angular.module('ionicz')

    .config(['$stateProvider', '$urlRouterProvider', 'ToolsProvider', 'ROUTE_ACCESS', 'ionicDatePickerProvider', function($stateProvider, $urlRouterProvider, ToolsProvider, ROUTE_ACCESS, ionicDatePickerProvider) {
        $stateProvider

            .state('login', {
                url: '/login',
                data: {
                    access: ROUTE_ACCESS.PUBLIC
                },
                templateUrl: 'views/login/login.html?v=' + window.templateVersion,
                controller: 'LoginCtrl'
            })

            .state('reg', {
                url: '/reg',
                data: {
                    access: ROUTE_ACCESS.PUBLIC
                },
                templateUrl: 'views/login/reg.html?v=' + window.templateVersion,
                controller: 'RegCtrl'
            })

            .state('home', {
                url: '/home',
                data: {
                    access: ROUTE_ACCESS.PUBLIC
                },
                templateUrl: 'views/index.html?v=' + window.templateVersion,
                controller: 'HomeCtrl'
            })

            .state('ucenter', {
                url: '/ucenter',
                abstract: true,
                template: '<ion-nav-view name="ucenter-view"></ion-nav-view>',
                controller: 'UCenterBaseCtrl',
                resolve: {
                    deps: ["$ocLazyLoad", function($ocLazyLoad) {
                        Backdrop.show();
                        return $ocLazyLoad.load({
                            name: "ionicz.controllers",
                            files: ['views/ucenter/ucenter.js']
                        }).then(function() {
                            Backdrop.hide();
                        });
                    }]
                }
            })

            .state('ucenter.index', {
                url: '/index',
                cache: false,
                views: {
                    'ucenter-view': {
                        templateUrl: 'views/ucenter/index.html?v=' + window.templateVersion,
                        controller: 'UCenterCtrl'
                    }
                }
            })

            .state('ucenter.myinfo', {
                url: '/myinfo',
                data: {
                    access: ROUTE_ACCESS.CHECK_TEST
                },
                views: {
                    'ucenter-view': {
                        templateUrl: 'views/ucenter/myinfo.html?v=' + window.templateVersion,
                        controller: 'UCenterCtrl'
                    }
                }
            })

            .state('ucenter.mypwd', {
                url: '/mypwd',
                data: {
                    access: ROUTE_ACCESS.CHECK_TEST
                },
                views: {
                    'ucenter-view': {
                        templateUrl: 'views/ucenter/mypwd.html?v=' + window.templateVersion,
                        controller: 'PwdCtroller'
                    }
                }
            })

            .state('ucenter.notice', {
                url: '/notice',
                views: {
                    'ucenter-view': {
                        templateUrl: 'views/ucenter/notice.html?v=' + window.templateVersion,
                        controller: 'NoticeCtroller'
                    }
                }
            })

            .state('ucenter.transfer', {
                url: '/transfer',
                views: {
                    'ucenter-view': {
                        templateUrl: 'views/ucenter/transfer.html?v=' + window.templateVersion,
                        controller: 'TransferCtroller'
                    }
                }
            })

            .state('ucenter.quickTransfer', {
                url: '/quickTransfer',
                views: {
                    'ucenter-view': {
                        templateUrl: 'views/ucenter/quickTransfer.html?v=' + window.templateVersion,
                        controller: 'TransferCtroller'
                    }
                }
            })

            // 游戏父级路由，子级路由都会加载父级路由
            .state('lottery', {
                url: '/lottery',
                abstract: true,
                cache: false,
                template: '<ion-nav-view name="lottery-view" class="lottery"></ion-nav-view>',
                data: {
                    access: ROUTE_ACCESS.PUBLIC
                },
                controller: 'BaseCtrl',
                resolve: {
                    deps: ["$ocLazyLoad", function($ocLazyLoad) {
                        Backdrop.show();
                        return $ocLazyLoad.load([{
                            name: "ionicz.lottery",
                            files: [
                                'views/lottery/js/controllers.js',
                                'views/lottery/js/filters.js',
                                'views/lottery/js/directives.js'
                            ]
                        }]).then(function() {
                            Backdrop.hide();
                        });
                    }]
                }
            })

            .state('lottery.list', {
                url: '/list',
                cache: false,
                views: {
                    'lottery-view': {
                        templateUrl: 'views/lottery/list.html?v=' + window.templateVersion,
                        controller: 'ListCtrl'
                    }
                }
            })

            .state('lottery.index', {
                url: '/index/:gameId',
                cache: false,
                views: {
                    'lottery-view': {
                        templateUrl: 'views/lottery/lottery.html?v=' + window.templateVersion,
                        controller: 'LotteryCtrl'
                    }
                }
            })

            .state('lottery.history', {
                url: '/history/:gameId',
                cache: false,
                views: {
                    'lottery-view': {
                        templateUrl: 'views/lottery/history.html?v=' + window.templateVersion,
                        controller: 'HistoryCtrl'
                    }
                }
            })

            .state('lottery.notcount', {
                url: '/notcount/:gameId',
                cache: false,
                views: {
                    'lottery-view': {
                        templateUrl: 'views/lottery/notcount.html?v=' + window.templateVersion,
                        controller: 'NotcountCtrl'
                    }
                }
            })

            .state('lottery.changLong', {
                url: '/changLong/:gameId',
                cache: false,
                views: {
                    'lottery-view': {
                        templateUrl: 'views/lottery/changLong.html?v=' + window.templateVersion,
                        controller: 'ChangLongCtrl'
                    }
                }
            })

            .state('lottery.luZhu', {
                url: '/luZhu/:gameId',
                cache: false,
                views: {
                    'lottery-view': {
                        templateUrl: 'views/lottery/luZhu.html?v=' + window.templateVersion,
                        controller: 'LuZhuCtrl'
                    }
                }
            })
            //   .state('lottery.detail', {
            //   	url: '/notcount/detail/:gameId/:gameName',
            //   	cache: false,
            // views: {
            // 	'lottery-view': {
            // 		templateUrl: 'views/lottery/notcount_detail.html?v=' + window.templateVersion,
            // 		controller: 'NotcountDetailCtrl'
            // 	}
            // }
            //   })

            //   .state('lottery.settled', {
            //   	url: '/settled',
            //   	cache: false,
            // views: {
            // 	'lottery-view': {
            // 		templateUrl: 'views/lottery/settled.html?v=' + window.templateVersion,
            // 		controller: 'SettledCtrl'
            // 	}
            // }
            //   })



            // .state('lottery.week', {
            // 	url: '/week',
            // 	data : {access : ROUTE_ACCESS.CHECK_TEST},
            // 	views: {
            // 		'lottery-view': {
            // 			templateUrl: 'views/lottery/week.html?v=' + window.templateVersion,
            // 			controller: 'WeekRecordCtrl'
            // 		}
            // 	}
            // })

            // .state('lottery.day', {
            // 	url: '/day/:statDate',
            // 	data : {access : ROUTE_ACCESS.CHECK_TEST},
            // 	views: {
            // 		'lottery-view': {
            // 			templateUrl: 'views/lottery/day.html?v=' + window.templateVersion,
            // 			controller: 'DayRecordCtrl'
            // 		}
            // 	}
            // })

            // .state('lottery.day_detail', {
            // 	url: '/day_detail/:gameId/:statDate',
            // 	data : {access : ROUTE_ACCESS.CHECK_TEST},
            // 	views: {
            // 		'lottery-view': {
            // 			templateUrl: 'views/lottery/day_detail.html?v=' + window.templateVersion,
            // 			controller: 'DayDetailCtrl'
            // 		}
            // 	}
            // })

            // 父级路由，子级路由都会加载父级路由
            .state('bank', {
                url: '/bank',
                abstract: true,
                template: '<ion-nav-view name="bank-view"></ion-nav-view>',
                controller: 'BankBaseCtrl',
                data: {
                    access: ROUTE_ACCESS.CHECK_TEST
                },
                resolve: {
                    deps: ["$ocLazyLoad", function($ocLazyLoad) {
                        return $ocLazyLoad.load([{
                            name: "ionicz.bank",
                            files: [
                                'views/bank/bank.js'
                            ]
                        }]);
                    }]
                }
            })

            .state('bank.list', {
                url: '/list',
                views: {
                    'bank-view': {
                        templateUrl: 'views/bank/bank.html?v=' + window.templateVersion,
                        controller: 'BankController'
                    }
                }
            })

            .state('bank.money', {
                url: '/money',
                cache: false,
                views: {
                    'bank-view': {
                        templateUrl: 'views/bank/money.html?v=' + window.templateVersion,
                        controller: 'MoneyController'
                    }
                }
            })
            .state('bank.trans', {
                url: '/trans',
                cache: false,
                views: {
                    'bank-view': {
                        templateUrl: 'views/bank/trans.html?v=' + window.templateVersion,
                        controller: 'TransController'
                    }
                }
            })
            .state('bank.qrcode', {
                url: '/qrcode',
                cache: false,
                views: {
                    'bank-view': {
                        templateUrl: 'views/bank/qrcode.html?v=' + window.templateVersion,
                        controller: 'QRCodeController'
                    }
                }
            })
            .state('bank.transfer', {
                url: '/transfer',
                cache: false,
                views: {
                    'bank-view': {
                        templateUrl: 'views/bank/transfer.html?v=' + window.templateVersion,
                        controller: 'TransferController'
                    }
                }
            })

            .state('bank.deposit', {
                url: '/deposit',
                cache: false,
                views: {
                    'bank-view': {
                        templateUrl: 'views/bank/deposit.html?v=' + window.templateVersion,
                        controller: 'DepositController'
                    }
                }
            })

            .state('bank.wechat', {
                url: '/wechat',
                cache: false,
                data: {
                    title: '微信',
                    type: 'wechat'
                },
                views: {
                    'bank-view': {
                        templateUrl: 'views/bank/2in1.html?v=' + window.templateVersion,
                        controller: 'TwoInOneController'
                    }
                }
            })

            .state('bank.alipay', {
                url: '/alipay',
                data: {
                    title: '支付宝',
                    type: 'alipay'
                },
                cache: false,
                views: {
                    'bank-view': {
                        templateUrl: 'views/bank/2in1.html?v=' + window.templateVersion,
                        controller: 'TwoInOneController'
                    }
                }
            })

            .state('bank.qq', {
                url: '/qq',
                data: {
                    title: 'QQ钱包',
                    type: 'qq'
                },
                cache: false,
                views: {
                    'bank-view': {
                        templateUrl: 'views/bank/2in1.html?v=' + window.templateVersion,
                        controller: 'TwoInOneController'
                    }
                }
            })

            .state('bank.jd', {
                url: '/jd',
                data: {
                    title: '京东',
                    type: 'jd'
                },
                cache: false,
                views: {
                    'bank-view': {
                        templateUrl: 'views/bank/2in1.html?v=' + window.templateVersion,
                        controller: 'TwoInOneController'
                    }
                }
            })
            //   .state('bank.bankpay', {
            //   	url: '/bankpay',
            //   	data: {rechType: 'bankTransfer'},
            // cache: false,
            //   	views: {
            //   		'bank-view': {
            //   			templateUrl: 'views/bank/bankpay.html?v=' + window.templateVersion,
            //   			controller:'OfflinePayController'
            //   		}
            //   	}
            //   })
            //   .state('bank.onlinepay', {
            //   	url: '/onlinepay',
            //   	data: {rechType: 'bankOnline'},
            // cache: false,
            //   	views: {
            //   		'bank-view': {
            //   			templateUrl: 'views/bank/onlinepay.html?v=' + window.templateVersion,
            //   			controller:'OnlinePayController'
            //   		}
            //   	}
            //   })
            //   .state('bank.cftpay', {
            //   	url: '/cftpay',
            //   	data: {rechType: 'cft'},
            // cache: false,
            //   	views: {
            //   		'bank-view': {
            //   			templateUrl: 'views/bank/cftpay.html?v=' + window.templateVersion,
            //   			controller:'OfflinePayController'
            //   		}
            //   	}
            //   })
            //   .state('bank.alipay', {
            //   	url: '/alipay',
            //   	data: {rechType: 'alipay'},
            // cache: false,
            //   	views: {
            //   		'bank-view': {
            //   			templateUrl: 'views/bank/alipay.html?v=' + window.templateVersion,
            //   			controller:'OfflinePayController'
            //   		}
            //   	}
            //   })
            //   .state('bank.weixinOnline', {
            //   	url: '/weixinOnline',
            //   	data: {rechType: 'weixinOnline'},
            // cache: false,
            //   	views: {
            //   		'bank-view': {
            //   			templateUrl: 'views/bank/wechatpayonline.html?v=' + window.templateVersion,
            //   			controller:'OnlinePayController'
            //   		}
            //   	}
            //   })
            //   .state('bank.wechatpay', {
            //   	url: '/wechatpay',
            //   	data: {rechType: 'weixin'},
            // cache: false,
            //   	views: {
            //   		'bank-view': {
            //   			templateUrl: 'views/bank/wechatpay.html?v=' + window.templateVersion,
            //   			controller:'OfflinePayController'
            //   		}
            //   	}
            //   })
            //   .state('bank.alipayOnline', {
            //   	url: '/alipayOnline',
            //   	data: {rechType: 'alipayOnline'},
            // cache: false,
            //   	views: {
            //   		'bank-view': {
            //   			templateUrl: 'views/bank/alipayonline.html?v=' + window.templateVersion,
            //   			controller:'OnlinePayController'
            //   		}
            //   	}
            //   })

            .state('report', {
                url: '/report',
                abstract: true,
                template: '<ion-nav-view name="report-view"></ion-nav-view>',
                controller: 'ReportBaseCtrl',
                resolve: {
                    deps: ["$ocLazyLoad", function($ocLazyLoad) {
                        Backdrop.show();
                        return $ocLazyLoad.load({
                            name: "ionicz.controllers",
                            files: ['views/report/report.js']
                        }).then(function() {
                            Backdrop.hide();
                        });
                    }]
                }
            })
            .state('report.index', {
                url: '/index',
                data: {
                    access: ROUTE_ACCESS.CHECK_TEST
                },
                views: {
                    'report-view': {
                        templateUrl: 'views/report/index.html?v=' + window.templateVersion,
                        controller: 'ReportCtrl'
                    }
                }
            })
            .state('report.list', {
                url: '/list',
                cache: false,
                data: {
                    access: ROUTE_ACCESS.CHECK_TEST
                },
                views: {
                    'report-view': {
                        templateUrl: 'views/report/list.html?v=' + window.templateVersion,
                        controller: 'ReportListCtrl'
                    }
                }
            })
            .state('activity', {
                url: '/activity',
                abstract: true,
                template: '<ion-nav-view name="activity-view"></ion-nav-view>',
                controller: 'ActivityBaseCtrl',
                data: {
                    access: ROUTE_ACCESS.PUBLIC
                },
                resolve: {
                    deps: ["$ocLazyLoad", function($ocLazyLoad) {
                        Backdrop.show();
                        return $ocLazyLoad.load({
                            name: "ionicz.controllers",
                            files: ['views/activity/activity.js']
                        }).then(function() {
                            Backdrop.hide();
                        });
                    }]
                }
            })
            .state('activity.index', {
                url: '/index',
                views: {
                    'activity-view': {
                        templateUrl: 'views/activity/index.html?v=' + window.templateVersion,
                        controller: 'ActivityCtrl'
                    }
                }
            })
            .state('activity.detail', {
                url: '/detail/:detailId',
                views: {
                    'activity-view': {
                        templateUrl: 'views/activity/detail.html?v=' + window.templateVersion,
                        controller: 'ActivityDetailCtrl'
                    }
                }
            })

            // 游戏父级路由，子级路由都会加载父级路由
            .state('agent', {
                url: '/agent',
                abstract: true,
                cache: false,
                template: '<ion-nav-view name="agent-view" class="agent"></ion-nav-view>',
                controller: 'AgentBaseCtrl',
                data: {
                    access: ROUTE_ACCESS.PUBLIC
                },
                resolve: {
                    deps: ["$ocLazyLoad", function($ocLazyLoad) {
                        Backdrop.show();
                        return $ocLazyLoad.load([{
                            name: "ionicz.agent",
                            files: [
                                'views/agent/controllers.js'
                            ]
                        }]).then(function() {
                            Backdrop.hide();
                        });
                    }]
                }
            })

            .state('agent.index', {
                url: '/index',
                views: {
                    'agent-view': {
                        templateUrl: 'views/agent/index.html?v=' + window.templateVersion,
                        controller: 'AgentCtrl'
                    }
                }
            })

            .state('agent.join', {
                url: '/join',
                cache: true,
                views: {
                    'agent-view': {
                        templateUrl: 'views/agent/join.html?v=' + window.templateVersion,
                        controller: 'AgentJoinCtrl'
                    }
                }
            })

            .state('agent.myrec', {
                url: '/myrec',
                views: {
                    'agent-view': {
                        templateUrl: 'views/agent/myrec.html?v=' + window.templateVersion,
                        controller: 'AgentMyrecCtrl'
                    }
                }
            })

            .state('agent.terms', {
                url: '/terms',
                cache: true,
                views: {
                    'agent-view': {
                        templateUrl: 'views/agent/terms.html?v=' + window.templateVersion,
                        controller: 'AgentTermsCtrl'
                    }
                }
            });

        ionicDatePickerProvider.configDatePicker({
            inputDate: new Date,
            titleLabel: "选择日期",
            setLabel: "确定",
            todayLabel: "今天",
            closeLabel: "关闭",
            mondayFirst: !1,
            weeksList: ["日", "一", "二", "三", "四", "五", "六"],
            monthsList: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
            templateType: "popup",
            from: new Date(2012, 8, 1),
            to: new Date(2028, 8, 1),
            showTodayButton: !0,
            dateFormat: "yyyy-MM-dd",
            closeOnSelect: !1,
            disableWeekdays: []
        });
        $urlRouterProvider.otherwise('/home');
    }]);

angular.module('ionicz.services', [])

    .service('My', ['$rootScope', '$location', '$interval', '$log', '$filter', '$cookies', 'Tools', 'PATH', function($rootScope, $location, $interval, $log, $filter, $cookies, Tools, PATH) {
        var self = this;

        this.info = {};
        var bank = {};
        var msgTimer = null;
        this.userMsg = -1;
        this.loaded = !1;

        var startMsgTimer = function() {
            (function(f) {
                msgTimer = $interval(f, 10000);
                return f;
            })(function() {
                Tools.ajax({
                    method: 'GET',
                    url: '../top_money_data.php',
                    // method: 'POST',
                    // url: 'ajax.php',
                    // params: {action: "userMsg"},
                    success: function(data) {
                        data = data.match(/\(([^\)]+)\)/);
                        data && data[1] && (data = JSON.parse(data[1]));
                        if (data.status && data.status == 1) {
                            if (self.userMsg >= 0 && data.user_num > self.userMsg) {
                                Tools.tip('收到' + (data.user_num - self.userMsg) + '条新消息');
                                // Tools.modal({template:data.message.message});
                            }
                            self.userMsg = data.user_num;
                            self.info.money = data.user_money;
                        } else {
                            $rootScope.isLogin = false;
                            self.clear();
                            Tools.alert(["系统提示", "您已经退出登录，请重新登录"]);
                            $location.path(PATH.loginPath);
                        }
                    },
                    error: function() {}
                });
            })();
        };

        var checkUpdatePw = function() {
            // 需要更新密码
            if (self.info.updatePw === 1) {
                $location.path('/ucenter/myfpwd').search({
                    t: 1
                });
            }
        };

        this.getInfo = function() {
            return this.info;
        };
        this.getUserId = function() {
            return this.info.userId;
        };
        this.getToken = function() {
            return self.info.token;
        };

        this.getUserName = function() {
            return self.info.username;
        };

        this.getFullName = function() {
            return self.info.fullName;
        };
        this.getRegTime = function() {
            return self.info.regTime;
        };
        this.getLoginTime = function() {
            return self.info.loginTime;
        };
        this.getAgent = function() {
            return self.info.agent;
        };
        this.getMobile = function() {
            return self.info.mobile;
        };
        this.setFullName = function(fullName) {
            self.info.fullName = fullName;
        };
        this.getMoney = function() {
            return $filter('money')(self.info.money);
        };
        this.getOriginalMoney = function() {
            return self.info.money;
        };
        this.addMoney = function(money) {
            self.info.money += money;
        };
        this.getEmail = function() {
            return self.info.email;
        };
        this.setEmail = function(email) {
            self.info.email = email;
        };
        this.setBank = function(data) {
            bank = data;
        };
        this.setBandDesc = function(bankName, subAddress, cardNo) {
            bank.bankName = bankName;
            bank.subAddress = subAddress;
            if (cardNo.length > 4) {
                bank.cardNo = "尾号" + cardNo.substring(cardNo.length - 4, cardNo.length);
            }
        };
        this.getBank = function() {
            return bank;
        };
        this.hasBankMsg = function() {
            if (bank.bankName && bank.cardNo) return true;
            return false;
        };
        this.hasFundPwd = function() {
            return self.info.hasFundPwd;
        };
        this.setHasFundPwd = function(hasFundPwd) {
            self.info.hasFundPwd = hasFundPwd;
        };
        this.init = function() {
            // var token = $cookies.get('token');
            // if(!token) {
            // 	self.loginFail();
            // 	return;
            // }

            Tools.ajax({
                method: 'POST',
                url: 'ajax.php',
                params: {
                    action: "init"
                },
                success: function(data) {
                    if (data.userId > 0) {
                        self.loginSuccess(data);
                    } else {
                        self.loginFail();
                    }

                    $rootScope.inited = true;
                }
            });
        };

        this.loginFail = function() {
            var GotoRegister = $cookies.get('firstTime');
            if (!$rootScope.GotoRegister) {
                $rootScope.GotoRegister = true;
                if (!GotoRegister && $rootScope.appConfig.register.agent) {
                    GotoRegister = true;
                    $cookies.put('firstTime', true);
                    $location.path(PATH.regPath);
                }
            }
            if (!GotoRegister && !Tools.isPublicPage()) {
                $location.path(PATH.loginPath);
            }
            $rootScope.inited = true;
        };

        this.loginSuccess = function(data) {
            $cookies.put('token', data.token);
            // 如果是试玩帐号，修改显示的用户名为“游客”
            if (data.testFlag == 1) {
                data['username'] = '游客';
                $rootScope.isTestAccount = true;
            } else {
                $rootScope.isTestAccount = false;
            }

            self.info = data;
            //console.log(self.info);
            $rootScope.diffTime = moment(data.serverTime).diff(moment(), 's');
            $rootScope.isLogin = true;
            startMsgTimer();
            checkUpdatePw();
        };

        this.clear = function() {
            $cookies.remove('token');
            self.info = {};
            self.clearMsgTimer();
        };

        this.clearMsgTimer = function() {
            $interval.cancel(msgTimer);
        };

        this.refreshMoney = function(backdrop) {
            backdrop = backdrop === false ? false : true;
            self.loaded = !1;
            Tools.ajax({
                method: 'POST',
                url: 'ajax.php',
                params: {
                    action: "money"
                },
                backdrop: backdrop,
                success: function(data) {
                    if (data.status == 1) {
                        self.info.money = data.msg;
                        self.loaded = !0;
                    }
                }
            });
        };
        this.sayhello = function() {
            now = new Date(), hour = now.getHours();
            if (hour < 6) {
                return "凌晨好！"
            } else if (hour < 9) {
                return "早上好！"
            } else if (hour < 12) {
                return "上午好！"
            } else if (hour < 14) {
                return "中午好！"
            } else if (hour < 17) {
                return "下午好！"
            } else if (hour < 19) {
                return "傍晚好！"
            } else if (hour < 22) {
                return "晚上好！"
            } else {
                return "夜里好！"
            }
        }
    }]);
