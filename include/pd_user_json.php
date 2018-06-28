<?php 
session_start();
$json = array();
$callback = '';
$callback = @($_GET['callback']);
include_once __DIR__.'/../common/logintu.php';
$uid = intval($_SESSION['uid']);
sessionNum($uid, $_GET['callback']);