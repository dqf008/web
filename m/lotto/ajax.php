<?php
include_once '../../include/config.php';
website_close();
website_deny();
include_once '../../database/mysql.config.php';
$Lastest_KitheTable = array(
    'nn' => '0000000',
    'na' => '--',
    'n1' => '--',
    'n2' => '--',
    'n3' => '--',
    'n4' => '--',
    'n5' => '--',
    'n6' => '--',
    'sx' => '--',
    'x1' => '--',
    'x2' => '--',
    'x3' => '--',
    'x4' => '--',
    'x5' => '--',
    'x6' => '--',
);
if(preg_match('/^[a-z0-9_]+$/i', $_GET['callback'])){
    $KitheTable = $mydata2_db->query('SELECT nn,nd,na,n1,n2,n3,n4,n5,n6,sx,x1,x2,x3,x4,x5,x6 FROM ka_kithe WHERE na>0 ORDER BY nn DESC LIMIT 1');
    if($KitheTable->rowCount()>0){
        $KitheTable = $KitheTable->fetch();
        foreach($KitheTable as $key=>$val){
            if(preg_match('/^n[a1-6]$/', $key)){
                $Lastest_KitheTable[$key] = substr('0'.$val, -2);
            }elseif(!is_numeric($key)&&isset($Lastest_KitheTable[$key])){
                $Lastest_KitheTable[$key] = $val;
            }
        }
    }
    echo $_GET['callback'];
    echo '('.json_encode($Lastest_KitheTable).')';
}else{
    echo 'Access Denied.';
}