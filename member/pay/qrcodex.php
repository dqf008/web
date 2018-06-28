<?php
$_DIR = dirname(__FILE__);
$_DIR = str_replace('\\', '/', $_DIR);
substr($_DIR, -1)!='/'&&$_DIR = $_DIR.'/';
include($_DIR.'common/qrcode.class.php');
include($_DIR.'moneyfunc.php');
if(isset($_GET['s'])&&!empty($_GET['s'])){
    if($_GET['k']==1){//进行处理
	    $_GET['s'] = dz_authcode($_GET['s']);
	}
    if($_GET['k']==2){//进行
	    $_GET['s'] = base64_decode($_GET['s']);
	}
    if(!empty($_GET['s'])){
        header('Content-Type: image/png');
        QRcode::png($_GET['s'], false, 'L', 9, 2);
    }
}