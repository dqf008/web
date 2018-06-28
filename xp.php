<?php 
$_DIR = dirname(__FILE__);
$_DIR = str_replace('\\', '/', $_DIR);
substr($_DIR, -1)!='/'&&$_DIR.='/';
session_start();
include_once $_DIR.'include/config.php';
website_close();
website_deny();
include_once $_DIR.'database/mysql.config.php';
include_once $_DIR.'common/logintu.php';
include_once $_DIR.'common/function.php';
include_once $_DIR.'myfunction.php';
$uid = $_SESSION['uid'];
$loginid = $_SESSION['user_login_id'];
(!isset($include_file)||empty($include_file))&&$include_file = isset($_GET['i'])?$_GET['i']:'';
$include_file = preg_replace('/[\\\\\/\.]/', '', $include_file); //过滤跨目录符号
if(!empty($include_file)&&is_file($_DIR.'static/templates/'.$include_file.'.php')){
    include($_DIR.'static/templates/myhead.php');
    include($_DIR.'static/templates/'.$include_file.'.php');
    include($_DIR.'static/templates/mybottom.php');
}else{
    echo 'Access Denied';
}