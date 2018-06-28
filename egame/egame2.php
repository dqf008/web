<?php
session_start();
$_DIR = dirname(__FILE__).'/';
include($_DIR.'../include/config.php');
include($_DIR.'../database/mysql.config.php');
include($_DIR.'./config.php');
include($_DIR.'./include/functions.php');
include_once ("../include/function_close_game.php");
$type = $_GET['p'];
game_is_close($type);
$output = array(
    'toggle' => 'egame',
    'url' => $_egame['url'],
    'pid' => $_egame['pid'],
    'lang' => $_egame['lang'],
    'cur' => '',
    'user' => '',
    'key' => '',
    'token' => '',
    'custom' => '',
    'platform' => 'MG',
    'width' => '1250',
    'bgcolor' => isset($_GET['c'])&&preg_match('/^(#[a-z0-9]{3,6}|[a-z]+)$/i', $_GET['c'])?$_GET['c']:'',
);
if(isset($_SESSION['uid'])&&preg_match('/^[1-9]\d*$/', $_SESSION['uid'])){
    $query = $mydata1_db->query('SELECT `username`, `login_time` FROM `k_user` WHERE `uid`='.$_SESSION['uid']);
    if($query->rowCount()>0){
        $rows = $query->fetch();
        $output['cur'] = $_egame['cur'];
        $output['user'] = des_encode($rows['username'], $_egame['des']);
        $output['key'] = des_encode($_egame['md5'], $_egame['des']);
        $output['custom'] = array();
        $output['custom']['uid'] = $_SESSION['uid'];
        $output['custom']['domain'] = $_SERVER['HTTP_HOST'];
        $output['custom']['web_id'] = $_egame['web_id'];
        $output['custom'] = dz_authcode(serialize($output['custom']), 'ENCODE', $_egame['token']);
        $output['token'] = md5($_egame['token'].$rows['login_time'].$rows['username']);
    }
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html>
<head>
    <title>综合电子</title>
    <style>
        *{margin: 0;padding: 0}
        body{
            background:#212121;
        }
    </style>
</head>
<body style="">

    <div <?php foreach($output as $key=>$val) echo ' data-'.$key.'="'.$val.'"';?>></div>
    <!--script src="eGameFrame.js?v=1" type="text/javascript"></script-->
    <script src="frame.js?v=1" type="text/javascript"></script>
  </body>
</html>