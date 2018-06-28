<?php
header('Content-Type:text/html; charset=utf-8');
include_once("../include/function.php");

$url                = "爱博官网";
$title              = "三分快乐10";
$jilu               = "";
$m                  = 0;
$date               = date("H:i:s");
$dateTime           = date('Y-m-d', time());
$lotteryName        = 'sfkl10';
$params[':fengpan'] = $date;
$params[':name']    = $lotteryName;
$sql                = "SELECT `qishu`, `kaipan`, `fengpan` FROM `c_opentime_3` WHERE  `fengpan`<=:fengpan and `name`=:name AND `ok`=0 ORDER BY `fengpan` DESC LIMIT 5";
$stmt               = $mydata1_db->prepare($sql);
$stmt->execute($params);
$ballsNumber = '1|2|3|4|5|6|7|8|9|A|B|C|D|E|F|G|H|I|J|K';
$ballMaps    = ['A' => 10, 'B' => 11, 'C' => 12, 'D' => 13, 'E' => 14, 'F' => 15, 'G' => 16, 'H' => 17, 'I' => 18, 'J' => 19, 'K' => 20];
/* 两面长龙数据 开始 */
$lot_changlong = [
    '两面长龙'    => [],
    'time'    => 0,
    'lastest' => 0,
];
$cache_file    = '../../cache/lot_sf10f.php';
file_exists($cache_file) && $lot_changlong = include($cache_file);

if ($stmt->rowCount() > 0) {
    $rows = $stmt->fetchAll();
    foreach ($rows as $key => $v) {
        $datetime = $dateTime . ' ' . $v['fengpan'];
        $qishu   = getQiHao($lotteryName, $v['qishu']);
        $ok      = 1;
        $balls   = getBalls(8, 1, $ballsNumber);
        $tempNum = explode(",", $balls);
        foreach ($tempNum as &$value) {
            if(isset($ballMaps[$value])){
                $value = $ballMaps[$value];
            }
        }
        $num1    = $tempNum[0];
        $num2    = $tempNum[1];
        $num3    = $tempNum[2];
        $num4    = $tempNum[3];
        $num5    = $tempNum[4];
        $num6    = $tempNum[5];
        $num7    = $tempNum[6];
        $num8    = $tempNum[7];
        if (strlen($qishu) > 0 && is_numeric($num1) && is_numeric($num2) && is_numeric($num3) && is_numeric($num4) && is_numeric($num5) && is_numeric($num6) && is_numeric($num7) && is_numeric($num8)) {
            $params = [':qishu' => $qishu,':name'=>$lotteryName, ':datetime' => $datetime, ':ball_1' => $num1, ':ball_2' => $num2, ':ball_3' => $num3, ':ball_4' => $num4, ':ball_5' => $num5, ':ball_6' => $num6, ':ball_7' => $num7, ':ball_8' => $num8, ':ok' => 1];

            $sql = 'insert into c_auto_3(qishu,name,datetime,ball_1,ball_2,ball_3,ball_4,ball_5,ball_6,ball_7,ball_8,ok) values (:qishu,:name,:datetime,:ball_1,:ball_2,:ball_3,:ball_4,:ball_5,:ball_6,:ball_7,:ball_8,:ok) ON DUPLICATE KEY UPDATE datetime=values(datetime),ok=values(ok)';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);

            $m += 1;
            /* 两面长龙数据 开始 */
            if ($lot_changlong['lastest'] < $qishu) {
                $lot_t         = ['总和' => 0];
                $lot_t['line'] = $lot_changlong['date'] != substr($qishu, 0, 8);
                /* 遗漏数据 */
                (!isset($lot_changlong['遗漏']) || $lot_t['line']) && $lot_changlong['遗漏'] = [];
                for ($i = 1; $i <= 20; $i++) {
                    if (isset($lot_changlong['遗漏'][$i])) {
                        $lot_changlong['遗漏'][$i]++;
                    } else {
                        $lot_changlong['遗漏'][$i] = 1;
                    }
                }
                /* 1~8球 */
                $keys    = ['第一球', '第二球', '第三球', '第四球', '第五球', '第六球', '第七球', '第八球'];
                $fangwei = ['东', '南', '西', '北'];
                foreach ($tempNum as $k => $n) {
                    $lot_changlong['遗漏'][$n] = 0;
                    $lot_t['总和']             += $n;
                    $lot_t['大小']             = $n > 10 ? '大' : '小';
                    $lot_t['单双']             = fmod($n, 2) == 0 ? '双' : '单';
                    $lot_t['尾数']             = substr($n, -1) >= 5 ? '尾大' : '尾小';
                    $lot_t['合数']             = fmod(substr('00' . $n, -2, 1) + substr($n, -1), 2) == 0 ? '合双' : '合单';
                    $k                       = $keys[$k];
                    foreach (['尾大' => '尾数', '尾小' => '尾数', '大' => '大小', '小' => '大小', '单' => '单双', '双' => '单双', '合双' => '合数', '合单' => '合数'] as $i => $j) {
                        changlong($k, $i, $lot_t[$j]);
                    }
                    !isset($lot_changlong[$k]) && $lot_changlong[$k] = [];
                    (!isset($lot_changlong[$k]['号码']) || $lot_t['line']) && $lot_changlong[$k]['号码'] = [];
                    if (!isset($lot_changlong[$k]['号码'])) {
                        $lot_changlong[$k]['号码'][$n] = 1;
                    } else {
                        $lot_changlong[$k]['号码'][$n]++;
                    }
                    zoushi($k, '和', $n, $lot_t['line']);
                    $lot_t['方位']  = $fangwei[fmod($n - 1, 4)];
                    $lot_t['中发白'] = $n < 8 ? '中' : ($n < 15 ? '发' : '白');
                    foreach (['大小', '单双', '合数', '尾数', '方位', '中发白'] as $i) {
                        zoushi($k, $i, $lot_t[$i], $lot_t['line']);
                    }
                }
                /* 总和结果 */
                $lot_t['总和大小'] = $lot_t['总和'] == 84 ? '和' : ($lot_t['总和'] > 84 ? '大' : '小');
                $lot_t['总和单双'] = fmod($lot_t['总和'], 2) == 0 ? '双' : '单';
                $lot_t['总和尾数'] = substr($lot_t['总和'], -1) >= 5 ? '大' : '小';
                foreach (['总和大小' => ['大', '小', '和'], '总和单双' => ['单', '双'], '总和尾数' => ['大', '小']] as $i => $j) {
                    changlong($i, $j[0], $lot_t[$i]);
                    changlong($i, $j[1], $lot_t[$i]);
                    isset($j[2]) && changlong($i, $j[2], $lot_t[$i]);
                    zoushi('总和', $i, $lot_t[$i], $lot_t['line']);
                }
                arsort($lot_changlong['两面长龙']);
                $lot_changlong['date']    = substr($qishu, 0, 8);
                $lot_changlong['lastest'] = $qishu;
                $lot_changlong['output']  = [];
                /* 缓存输出结果 */
                $lot_changlong['output']['ChangLong']            = [];
                $lot_changlong['output']['LuZhu']                = [];
                $lot_changlong['output']['ZongchuYilou']         = [];
                $lot_changlong['output']['ZongchuYilou']['miss'] = array_values($lot_changlong['遗漏']);
                $lot_changlong['output']['ZongchuYilou']['hit']  = [];
                foreach ($keys as $j => $key) {
                    $k                                                  = 'n' . ($j + 1);
                    $lot_changlong['output']['ZongchuYilou']['hit'][$k] = [];
                    for ($i = 1; $i <= 20; $i++) {
                        !isset($lot_changlong[$key]['号码'][$i]) && $lot_changlong[$key]['号码'][$i] = 0;
                        $lot_changlong['output']['ZongchuYilou']['hit'][$k][] = $lot_changlong[$key]['号码'][$i];
                    }
                    $lot_changlong['output']['LuZhu'][] = [
                        'c' => implode(',', $lot_changlong[$key]['和']),
                        'n' => $key,
                        'p' => $j + 1,
                    ];
                }
                foreach ($keys as $j => $key) {
                    foreach (['大小', '单双', '合数', '尾数', '方位', '中发白'] as $i) {
                        $lot_changlong['output']['LuZhu'][] = [
                            'c' => str_replace(['合', '尾'], ['', ''], implode(',', $lot_changlong[$key][$i])),
                            'n' => str_replace(['合数', '尾数'], ['合数单双', '尾数大小'], $i),
                            'p' => $j + 1,
                        ];
                    }
                }
                foreach (['总和大小', '总和单双', '总和尾数'] as $key) {
                    $lot_changlong['output']['LuZhu'][] = [
                        'c' => implode(',', $lot_changlong['总和'][$key]),
                        'n' => $key,
                        'p' => 0,
                    ];
                }
                foreach ($lot_changlong['两面长龙'] as $key => $val) {
                    $val > 1 && $lot_changlong['output']['ChangLong'][] = [$key, $val];
                }
                file_put_contents($cache_file, '<?php' . PHP_EOL . 'return unserialize(\'' . serialize($lot_changlong) . '\');');
            }
            /* 两面长龙数据 结束 */
        }


        $jilu .= '第' . $qishu . '期：' . $fengpan . '开奖结果为' . implode(',',$tempNum) . "<br>";
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
    !isset($lot_changlong[$k]) && $lot_changlong[$k] = [];
    if (!isset($lot_changlong[$k][$i]) || empty($lot_changlong[$k][$i])) {
        $lot_changlong[$k][$i] = [$n . ':1'];
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
