<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include('../common/qrcode.class.php');
if(isset($_GET['s'])&&!empty($_GET['s'])){
    header('Content-Type: image/png');
    QRcode::png($_GET['s'], false, 'L', 9, 2);
}