<?php
session_start();
include_once '../../include/config.php';
website_close();
website_deny();
include_once '../../database/mysql.config.php';
include_once '../../common/logintu.php';
include_once '../../common/function.php';
include_once '../../class/user.php';
include_once '../../include/lottery.inc.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($uid);
if (intval($web_site['qxc']) == 1)
{
    message('七星彩系统维护，暂停下注！');
    exit();
}
$l_time = strtotime($l_time);
$params = array(':kaipan' => $l_time, ':kaijiang' => $l_time);
$stmt = $mydata1_db->prepare('SELECT `qishu`, `kaipan`, `fengpan`, `kaijiang` FROM `lottery_k_qxc` WHERE `kaipan`<=:kaipan AND `kaijiang`>=:kaijiang AND `status`=0 ORDER BY `kaijiang` ASC LIMIT 1');
$stmt->execute($params);
$trow = $stmt->fetch();
$tcou = $stmt->rowCount();
$params = array(':class1' => 'qxc');
$stmt = $mydata1_db->prepare('SELECT `class3`, `odds` FROM `lottery_odds` WHERE `class1`=:class1');
$stmt->execute($params);
$odds = array();
while($rows = $stmt->fetch()){
    $odds[$rows['class3']] = $rows['odds'];
}
$bet_type = array(
    'dw1' => '一定位',
    'dw2' => '二定位',
    'dw3' => '三定位',
    'dw4' => '四定位',
    'zx2' => '二字现',
    'zx3' => '三字现',
);
if($uid){
    include_once '../../cache/group_' . @($_SESSION['gid']) . '.php';
    $cp_zd = @($pk_db['彩票最低']);
    $cp_zg = @($pk_db['彩票最高']);
    if (0 < $cp_zd){
        $cp_zd = $cp_zd;
    }else{
        $cp_zd = 10;
    }
    
    if (0 < $cp_zg){
        $cp_zg = $cp_zg;
    }else{
        $cp_zg = 1000000;
    }
}