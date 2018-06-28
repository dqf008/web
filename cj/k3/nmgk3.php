<?php
header('Content-Type:text/html; charset=utf-8');
include_once ("../include/function.php");

$url    = "爱博官网";
$title  = "内蒙古快3";
$jilu   = "";
$m      = 0;
$client = new rpcclient($cj_url);
$arr    = $client->nmgk3(10, $site_id);
$arr    = a_decode64($arr);//解压
$lotteryName ='nmgk3';
if (is_array($arr) and $arr) {
    foreach ($arr as $key => $v) {
        $qihao      = $key;
        $balls      = $v['number'];
        $fengpan    = $v['fengpan'];
        $kaipan     = $v['kaipan'];
        $addtime    = $v['dateline'];
        $startSale  = $v['start_sale'];
        $endSale    = $v['end_sale'];
        $draw       = $v['draw'];
        $nextStartSale = $v['next_start_sale'];
        $nextEndSale = $v['next_end_sale'];
        $nextQihao  = $v['next_qihao'];
        $nextDraw   = $v['next_draw'];
        $ok =0;
        if (strlen($qihao) > 0 && !empty($kaipan) && !empty($fengpan) && isExist($qihao,$lotteryName)) {
            $params = [':qihao' => $qihao,':start_sale'=>$startSale,':end_sale'=>$endSale,':draw'=>$draw,':next_start_sale'=>$nextStartSale,'next_end_sale'=>$nextEndSale,'next_draw'=>$nextDraw,':next_qihao'=>$nextQihao, ':kaipan' => $kaipan, ':fengpan' => $fengpan, ':balls' => $balls, ':ok' => $ok, ':addtime' => $addtime, ':lottery_name' => $lotteryName];
            $sql  = 'insert into lottery_k3 (qihao,kaipan,fengpan,start_sale,end_sale,draw,next_draw,next_start_sale,next_end_sale,next_qihao,balls,ok,addtime,name) values (:qihao,:kaipan,:fengpan,:start_sale,:end_sale,:draw,:next_draw,:next_start_sale,:next_end_sale,:next_qihao,:balls,:ok,:addtime,:lottery_name) ON DUPLICATE KEY UPDATE balls =values(balls),ok=values(ok)';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            $m = $m + 1;
        }
        $jilu .= '第' . $qihao . '期：' . $num .'开奖时间'.$fengpan. "<br>";
    }
} else{
    print_r($arr);
}
function isExist($qihao, $name)
{
    global $mydata1_db;
    $sql   = "select exists (select id from `lottery_k3` where `name`='$name' and `qihao`='$qihao') as `exists`";
    $st    = $mydata1_db->query($sql);
    if ($st->rowCount() > 0) {
        $isExist = $st->fetch();
        if($isExist['exists']==0){
            return true;
        }
        return false;
    }
    return false;
}

function zoushi($k, $i, $n, $line=false, $max=30){
    $lot_changlong =&$GLOBALS['lot_changlong'];
    !isset($lot_changlong[$k])&&$lot_changlong[$k] = array();
    if(!isset($lot_changlong[$k][$i])||empty($lot_changlong[$k][$i])){
        $lot_changlong[$k][$i] = array($n.':1');
    }else{
        $line&&array_unshift($lot_changlong[$k][$i], '*:1');
        $lot_temp = explode(':', $lot_changlong[$k][$i][0]);
        if($lot_temp[0]==$n){
            $lot_temp[1]++;
            $lot_changlong[$k][$i][0] = $lot_temp[0].':'.$lot_temp[1];
        }else{
            array_unshift($lot_changlong[$k][$i], $n.':1');
            count($lot_changlong[$k][$i])>$max&&array_splice($lot_changlong[$k][$i], $max);
        }
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=$title.' '.$url?></title>
    <style type="text/css">
        <!--
        body,td,th {
            font-size: 12px;
        }
        body {
            margin-left: 0px;
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
        }
        -->
    </style></head>
<body>

<script>
    <!--

    <? $limit= rand(6,15);?>
    var limit="<?=$limit?>"
    if (document.images){
        var parselimit=limit
    }
    function beginrefresh(){
        if (!document.images)
            return
        if (parselimit==1)
            window.location.reload()
        else{
            parselimit-=1
            curmin=Math.floor(parselimit)
            if (curmin!=0)
                curtime=curmin+"秒后自动获取!"
            else
                curtime=cursec+"秒后自动获取!"
            timeinfo.innerText=curtime
            setTimeout("beginrefresh()",1000)
        }
    }
    window.onload=beginrefresh
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td align="left" style="padding-left:10px; padding-top:10px; line-height:22px;">
            <input type=button name=button value="刷新" onClick="window.location.reload()">
            <span id="timeinfo"></span><br />
            采集网址：<?=$url?><br />
            <font color="#FF0000"><?=$title?> 共采集到<?=$m?>期</font>
            <?
            $xianshi = explode("<br>",$jilu);
            foreach(array_reverse($xianshi,true) as $v){
                echo $v."<br>";
            }

            ?>
        </td>
    </tr>
</table>
</body>
</html>
