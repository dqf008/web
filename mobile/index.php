<?php
session_start();
$_DIR = dirname(__FILE__);
$_DIR = str_replace('\\', '/', $_DIR);
substr($_DIR, -1)!='/'&&$_DIR.='/';
define('IN_MOBILE', $_DIR);

$_SERVER['DOCUMENT_ROOT'] = realpath(IN_MOBILE.'../');
include IN_MOBILE.'../include/config.php';
include IN_MOBILE.'../database/mysql.config.php';
website_close();

$templateVersion = '201806191';
/*
if(!$_SESSION['uid']){
    $agent = ['uid' => 0, 'username' => null];
    if(isset($_GET['f'])&&!empty($_GET['f'])){
        $stmt = $mydata1_db->prepare('SELECT `uid`, `username` FROM `k_user` WHERE `username`=:username LIMIT 1');
        $stmt->execute([':username' => $_GET['f']]);
        if($rows = $stmt->fetch()){
            $agent['uid'] = $rows['uid'];
            $agent['username'] = $rows['username'];
        }
    }
    if(!$agent['uid']){
        $hostname = strtolower(trim($_SERVER['HTTP_HOST']));
        $stmt = $mydata1_db->prepare('SELECT * FROM `dlurl` WHERE `isok`=1');
        $stmt->execute();
        while ($rows = $stmt->fetch()) {
            $rows['url'] = strtolower(trim($rows['url']));
            if(substr($hostname, -1*strlen($rows['url']))==$rows['url']){
                $stmt1 = $mydata1_db->prepare('SELECT `uid`, `username` FROM `k_user` WHERE `username`=:username LIMIT 1');
                $stmt1->execute([':username' => $rows['dl_username']]);
                if($user = $stmt1->fetch()){
                    $agent['uid'] = $user['uid'];
                    $agent['username'] = $user['username'];
                    break;
                }
            }
        }
    }
    if($agent['uid']){
        setcookie('f', $agent['uid']);
        setcookie('tum', $agent['username']);
    }
}
*/
?><!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, width=device-width"><meta name="format-detection" content="telephone=no"><link id="appTouchIcon" href="#" sizes="114x114" rel="apple-touch-icon-precomposed"><meta id="appTitle" name="apple-mobile-web-app-title"><title>欢迎使用手机版</title><style type="text/css">body {background-color: #88a6b1}#spinner {width: 100%; height: 100%; background-color: rgba(0,0,0,.4);opacity: 1;position: absolute; z-index: 11;}</style><link href="lib/ionic/css/ionic.min.css" rel="stylesheet" /><link href="css/main.pack.min.css?v=<?php echo $templateVersion; ?>" rel="stylesheet" /><link href="css/menu.css" rel="stylesheet" /><script type="text/javascript" src="js/jquery.min.js" ></script><script type="text/javascript">window.templateVersion="<?php echo $templateVersion; ?>"</script></head><body class="{{'skin_' + appConfig.skin}}" ng-app="ionicz" ng-controller="AppCtrl"><script type="text/javascript" src="lib/spin.min.js"></script><ion-nav-bar class="bar-header bar-positive"><!-- <ion-nav-back-button></ion-nav-back-button> --></ion-nav-bar><!-- <div ng-if="inited"><ion-nav-view></ion-nav-view></div> --><ion-nav-view></ion-nav-view><script id="test-template" type="text/ng-template"><div class="row"><div class="col"><div class="item item-input" ng-repeat="item in debugMsgList">{{item.time + ': ' + item.msg + ' - '+ item.count}}</div></div></div></script></body><script type="text/javascript" src="lib/ionic/js/ionic.bundle.min.js"></script><script type="text/javascript" src="js/lib.pack.js" ></script><script type="text/javascript" src="js/app.pack.js?v=<?php echo $templateVersion; ?>" ></script><script type="text/javascript" src="js/selectlottery.js" ></script>
</html>