<?php
header('Content-Type:text/html; charset=utf-8');
include_once("../include/function.php");

$url = "爱博官网";
$title = "PC蛋蛋";
$jilu = "";
$m = 0;
$client = new rpcclient($cj_url);
$arr = $client->kl8(10, $site_id);
$arr = a_decode64($arr);//解压
/* 两面长龙数据 开始 */
$lot_changlong = array(
    '两面长龙' => array(),
    'time' => 0,
    'lastest' => 0,
);
$cache_file = '../../cache/lot_pcdd.php';
file_exists($cache_file) && $lot_changlong = include($cache_file);
/* 两面长龙数据 结束 */
if (is_array($arr) and $arr) {
    foreach (array_reverse($arr, true) as $key => $v) {
        $qihao = $key;
        $qihaonum = substr($qihao, -2);
        $num = $v['number'];
        $datetime = $v['dateline'];
        $tempNum = explode(",", $num);
        asort($tempNum);
        $num1 = (int)$tempNum[0];
        $num2 = (int)$tempNum[1];
        $num3 = (int)$tempNum[2];
        $num4 = (int)$tempNum[3];
        $num5 = (int)$tempNum[4];
        $num6 = (int)$tempNum[5];
        $num7 = (int)$tempNum[6];
        $num8 = (int)$tempNum[7];
        $num9 = (int)$tempNum[8];
        $num10 = (int)$tempNum[9];
        $num11 = (int)$tempNum[10];
        $num12 = (int)$tempNum[11];
        $num13 = (int)$tempNum[12];
        $num14 = (int)$tempNum[13];
        $num15 = (int)$tempNum[14];
        $num16 = (int)$tempNum[15];
        $num17 = (int)$tempNum[16];
        $num18 = (int)$tempNum[17];
        $num19 = (int)$tempNum[18];
        $num20 = (int)$tempNum[19];

        if (strlen($qihao) > 0 && is_numeric($num1) && is_numeric($num2) && is_numeric($num3) && is_numeric($num4) && is_numeric($num5) && is_numeric($num6) && is_numeric($num7) && is_numeric($num8) && is_numeric($num9) && is_numeric($num10) && is_numeric($num11) && is_numeric($num12) && is_numeric($num13) && is_numeric($num14) && is_numeric($num15) && is_numeric($num16) && is_numeric($num17) && is_numeric($num18) && is_numeric($num19) && is_numeric($num20)) {
            $params = array(':qihao' => $qihao);
            $sql = 'select count(*) from lottery_k_pcdd where qihao=:qihao order by id asc limit 0,1';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            $sum = $stmt->fetchColumn();
            if ($sum == 1) {
                $hm1 = ($num1 + $num2 + $num3 + $num4 + $num5 + $num6) % 10;
                $hm2 = ($num7 + $num8 + $num9 + $num10 + $num11 + $num12) % 10;
                $hm3 = ($num13 + $num14 + $num15 + $num16 + $num17 + $num18) % 10;
                $total = $hm1 + $hm2 + $hm3;
                $params = array(':hm1' => $hm1, ':hm2' => $hm2,'addtime'=>$datetime, ':hm3' => $hm3, ':total' => $total, ':qihao' => $qihao, ':ok' => 1);
                $sql = 'update  lottery_k_pcdd set addtime=:addtime, hm1=:hm1,hm2=:hm2,hm3=:hm3,total=:total,ok=:ok where qihao=:qihao';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $m++;
            }
            /* 两面长龙数据 开始 */
            if($lot_changlong['lastest']<$qihao){
                $lot_t = array('和值' => 0);
                $lot_t['line'] = $lot_changlong['time']+7200<time();
                $lot_t['和值']= $hm1+$hm2+$hm3;
                /* 和值 */
                $lot_t['和值大小'] = $lot_t['和值']>13?'大':'小';
                $lot_t['和值单双'] = fmod($lot_t['和值'], 2)==0?'双':'单';
                foreach(array('大' => '大小', '小' => '大小', '和' => '大小', '单' => '单双', '双' => '单双') as $i=>$j){
                    changlong('和值'.$j, $i, $lot_t['和值'.$j]);
                }
                foreach(array('大小', '单双') as $i){
                    zoushi('和值', $i, $lot_t['和值'.$i], $lot_t['line']);
                }
                arsort($lot_changlong['两面长龙']);
                $lot_changlong['time'] = time();
                $lot_changlong['lastest'] = $qihao;
                $lot_changlong['output'] = array();
                $lot_changlong['output']['ChangLong'] = array();
                $lot_changlong['output']['LuZhu'] = array();
                $lot_changlong['output']['ZongchuYilou'] = array();
                $lot_changlong['output']['ZongchuYilou']['miss'] = array();
                $lot_changlong['output']['ZongchuYilou']['hit'] = array();
                foreach(array('大小', '单双') as $val){
                    $lot_changlong['output']['LuZhu'][] = array(
                        'c' => implode(',', $lot_changlong['和值'][$val]),
                        'n' => '和值'.$val,
                        'p' => 0,
                    );
                }
                foreach($lot_changlong['两面长龙'] as $key=>$val){
                    $lot_changlong['output']['ChangLong'][] = array($key, $val);
                }
                file_put_contents($cache_file, '<?php'.PHP_EOL.'return unserialize(\''.serialize($lot_changlong).'\');');
            }
            /* 两面长龙数据 结束 */
            $jilu .= '第' . $qihao . '期：开奖号为' . $num1.','.$num2.','.$num3 .'开奖时间'.$fengpan. "<br>";
        }


    }
} else {
    print_r($arr);
}
function changlong($k, $i, $j)
{
    $lot_changlong =& $GLOBALS['lot_changlong']['两面长龙'];
    if ($i == $j) {
        if (isset($lot_changlong[$k . '-' . $i])) {
            $lot_changlong[$k . '-' . $i]++;
        } else {
            $lot_changlong[$k . '-' . $i] = 1;
        }
    } else {
        if (isset($lot_changlong[$k . '-' . $i])) {
            unset($lot_changlong[$k . '-' . $i]);
        }
    }
}

function zoushi($k, $i, $n, $line = false, $max = 30)
{
    $lot_changlong =& $GLOBALS['lot_changlong'];
    !isset($lot_changlong[$k]) && $lot_changlong[$k] = array();
    if (!isset($lot_changlong[$k][$i]) || empty($lot_changlong[$k][$i])) {
        $lot_changlong[$k][$i] = array($n . ':1');
    } else {
        $line && array_unshift($lot_changlong[$k][$i], '*:1');
        $lot_temp = explode(':', $lot_changlong[$k][$i][0]);
        if ($lot_temp[0] == $n) {
            $lot_temp[1]++;
            $lot_changlong[$k][$i][0] = $lot_temp[0] . ':' . $lot_temp[1];
        } else {
            array_unshift($lot_changlong[$k][$i], $n . ':1');
            count($lot_changlong[$k][$i]) > $max && array_splice($lot_changlong[$k][$i], $max);
        }
    }
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?= $title . ' ' . $url ?></title>
    <style type="text/css">
        <!--
        body, td, th {
            font-size: 12px;
        }

        body {
            margin-left: 0px;
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
        }

        -->
    </style>
</head>
<body>

<script>
    <!--

    <? $limit = rand(6, 15);?>
    var limit = "<?=$limit?>"
    if (document.images) {
        var parselimit = limit
    }

    function beginrefresh() {
        if (!document.images)
            return
        if (parselimit == 1)
            window.location.reload()
        else {
            parselimit -= 1
            curmin = Math.floor(parselimit)
            if (curmin != 0)
                curtime = curmin + "秒后自动获取!"
            else
                curtime = cursec + "秒后自动获取!"
            timeinfo.innerText = curtime
            setTimeout("beginrefresh()", 1000)
        }
    }

    window.onload = beginrefresh
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td align="left" style="padding-left:10px; padding-top:10px; line-height:22px;">
            <input type=button name=button value="刷新" onClick="window.location.reload()">
            <span id="timeinfo"></span><br/>
            采集网址：<?= $url ?><br/>
            <font color="#FF0000"><?= $title ?> 共采集到<?= $m ?>期</font>
            <?
            $xianshi = explode("<br>", $jilu);
            foreach (array_reverse($xianshi, true) as $v) {
                echo $v . "<br>";
            }

            ?>
        </td>
    </tr>
</table>
</body>
</html>
