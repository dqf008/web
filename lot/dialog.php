<?php
include(dirname(__FILE__).'/include/common.php');
$LOT['i'] = isset($_GET['i'])?$_GET['i']:'default';
$LOT['action'] = array('history', 'rule', 'record');
$LOT['title'] = 'Layout';
if(in_array($LOT['i'], $LOT['action'])){
    include(IN_LOT.'include/template/dialog/head.php');
    include(IN_LOT.'include/template/dialog/'.$LOT['i'].'.php');
    include(IN_LOT.'include/template/dialog/footer.php');
}else{
    echo 'Access Denied';
}