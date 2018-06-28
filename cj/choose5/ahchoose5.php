<?php
header('Content-Type:text/html; charset=utf-8');
include_once("../include/function.php");

$url   = "爱博官网";
$title = "安徽11选5";
$jilu  = "";
$m     = 0;
$client = new rpcclient($cj_url);
$arr    = $client->ahchoose5(10, $site_id);
$arr    = a_decode64($arr);//解压
/* 两面长龙数据 开始 */
$lot_changlong = [
    '两面长龙'    => [],
    'date'    => 0,
    'lastest' => 0,
];
$lotteryName ='ahchoose5';
$cache_file    = '../../cache/lot_ahchoose5.php';
file_exists($cache_file) && $lot_changlong = include($cache_file);
/* 两面长龙数据 结束 */
if (is_array($arr) and $arr) {
    foreach (array_reverse($arr, true) as $key => $v) {
        $qishu    = $key;
        $qishunum = substr($qishu, -3);
        $num      = $v['number'];
        $datetime = $v['dateline'];
        $tempNum  = explode(",", $num);
        $num1     = (int)$tempNum[0];
        $num2     = (int)$tempNum[1];
        $num3     = (int)$tempNum[2];
        $num4     = (int)$tempNum[3];
        $num5     = (int)$tempNum[4];
        if (strlen($qishu) > 0 && is_numeric($num1) && is_numeric($num2) && is_numeric($num3) && is_numeric($num4) && is_numeric($num5)) {
            $params = [':qishu' => $qishu, ':datetime' => $datetime, ':ball_1' => $num1, ':ball_2' => $num2, ':ball_3' => $num3, ':ball_4' => $num4, ':ball_5' => $num5, ':ok' => 1, ':name' => $lotteryName];
            $sql    = 'insert into c_auto_choose5 (qishu,datetime,ball_1,ball_2,ball_3,ball_4,ball_5,ok,name) values (:qishu,:datetime,:ball_1,:ball_2,:ball_3,:ball_4,:ball_5,:ok,:name) ON DUPLICATE KEY UPDATE datetime=values(datetime),ok=values(ok)';
            $stmt   = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            $m = $m + 1;
            /* 两面长龙数据 开始 */
            if ($lot_changlong['lastest'] < $qishu || empty($lot_changlong)) {
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
                /* 1~5球 */
                $keys = ['第一球', '第二球', '第三球', '第四球', '第五球'];
                foreach ($tempNum as $k => $n) {
                    $lot_changlong['遗漏'][$n] = 0;
                    $lot_t['总和']             += $n;
                    $lot_t['大小']             = $n > 10 ? '大' : '小';
                    $lot_t['单双']             = fmod($n, 2) == 0 ? '双' : '单';

                    $k = $keys[$k];
                    foreach (['大' => '大小', '小' => '大小', '单' => '单双', '双' => '单双'] as $i => $j) {
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
                    foreach (['大小', '单双'] as $i) {
                        zoushi($k, $i, $lot_t[$i], $lot_t['line']);
                    }
                }
                /* 总和结果 */
                $lot_t['总和大小'] = $lot_t['总和'] == 84 ? '和' : ($lot_t['总和'] > 84 ? '大' : '小');
                $lot_t['总和单双'] = fmod($lot_t['总和'], 2) == 0 ? '双' : '单';

                foreach (['总和大小' => ['大', '小', '和'], '总和单双' => ['单', '双']] as $i => $j) {
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
                }

                foreach ($lot_changlong['两面长龙'] as $key => $val) {
                    $val > 1 && $lot_changlong['output']['ChangLong'][] = [$key, $val];
                }
                file_put_contents($cache_file, '<?php' . PHP_EOL . 'return unserialize(\'' . serialize($lot_changlong) . '\');');
            }
        }

        $jilu .= '第' . $qishu . '期：' . '开奖结果为' . $num . "<br>";
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
