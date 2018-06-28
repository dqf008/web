<?php
//Current_Kithe_Num
function checkSum(){
	global $Current_Kithe_Num,$mydata1_db,$mydata2_db;
    $kithe = $Current_Kithe_Num;
    $sql = 'select sum(sum_m) as sum from ka_tan where kithe=' . $kithe . ' limit 1';
    $res = $mydata2_db->query($sql)->fetch(PDO::FETCH_ASSOC);
    $sum = (int)$res['sum'];

    $sql = 'select content from webinfo where code="marksix-sum" limit 1';
    $res = $mydata1_db->query($sql)->fetch(PDO::FETCH_ASSOC);
    $max = (int)$res['content'];
    if($max>0 && $sum>$max){
        echo '<script type="text/javascript">alert("本期投注金额已达上限");window.location.href="/m/lotto/index.php";</script>';
        exit;
    }
}