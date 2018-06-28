<?php
header('Content-Type:text/html; charset=utf-8');
include_once ("../include/function.php");

$info = ['no' => [], 'ok' => [], 'bet_ok' => [], 'user' => []];
$now = time()+43200;

$params = array(':type' => 'FFK3');
$stmt = $mydata1_db->prepare('SELECT `id`, `uid`, `qishu`, `money`, `value` FROM `c_bet_data` WHERE `type`=:type AND `status`=0 ORDER BY `id` ASC');
$stmt->execute($params);

while ($rows = $stmt->fetch()) {
    if(!isset($info['ok'][$rows['qishu']])&&!in_array($rows['qishu'], $info['no'])){
        $stmt1 = $mydata1_db->prepare('SELECT `id`, `value` FROM `c_auto_data` WHERE `type`=:type AND `qishu`=:qishu AND `status` IN (0, 1, 3) AND `opentime`<=:time');
        $stmt1->execute([':qishu' => $rows['qishu'], ':type' => 'FFK3', ':time' => $now]);
        if($rows1 = $stmt1->fetch()){
            $info['ok'][$rows['qishu']] = unserialize($rows1['value']);
            $info['ok'][$rows['qishu']]['bet'] = [
                'money' => 0,
                'win' => 0,
                'user' => [],
                'rows' => 0,
                'ratio' => 0,
            ];
        }else{
            $info['no'][] = $rows['qishu'];
        }
    }
    if(!in_array($rows['qishu'], $info['no'])){
        $temp = $info['ok'][$rows['qishu']];
        $rows['value'] = unserialize($rows['value']);
        $rows['value']['result'] = implode(',', $temp['opencode']);
        $tempNum = $temp['opencode'];
        asort($tempNum);
        $info['bet_ok'][$rows['id']] = [
            'uid' => $rows['uid'],
            'money' => -1*$rows['money'],
            'value' => $rows['value'],
        ];
        switch ($rows['value']['class'][0]) {
            case '和值':
                $temp = array_sum($tempNum);
                break;
            case '三同号通选':
                if(isThreeSameBalls($tempNum) >0){
                    $info['bet_ok'][$rows['id']]['money'] += floor($rows['money']*$rows['value']['odds']);
                }
                break;
            case '三同号单选':
                $betBalls = $rows['value']['class'][1];
                if(isThreeSameBalls($tempNum)!=0 && isThreeSameBalls($tempNum)==isThreeSameBalls(array($betBalls[0],$betBalls[1],$betBalls[2]))){
                    $info['bet_ok'][$rows['id']]['money'] += floor($rows['money']*$rows['value']['odds']);
                }
                break;
            case '三不同号':
                if(isNoSameBalls($tempNum,$rows['value']['class'][1])){
                    $info['bet_ok'][$rows['id']]['money'] += floor($rows['money']*$rows['value']['odds']);
                }
                break;
            case '三连号单选':
                if(isThreeEvenNumber($tempNum,$rows['value']['class'][1])){
                    $info['bet_ok'][$rows['id']]['money'] += floor($rows['money']*$rows['value']['odds']);
                }
                break;
            case '三连号通选':
                if(isThreeEvenNumber($tempNum)){
                    $info['bet_ok'][$rows['id']]['money'] +=floor($rows['money']*$rows['value']['odds']);
                }
                break;
            case '二同号复选':
                if(twoDiff($tempNum,$rows['value']['class'][1])){
                    $info['bet_ok'][$rows['id']]['money'] += floor($rows['money']*$rows['value']['odds']);
                }
                break;
            case '二同号单选':
                if(twoSampleChoose($tempNum,$rows['value']['class'][1])){
                    $info['bet_ok'][$rows['id']]['money'] += floor($rows['money']*$rows['value']['odds']);
                }
                break;
            case '二不同号':
                if(twoDiff($tempNum,$rows['value']['class'][1])){
                    $info['bet_ok'][$rows['id']]['money'] += floor($rows['money']*$rows['value']['odds']);
                }
                break;
        }
        if(in_array($rows['value']['class'][1], ['大', '小'])){
            $temp = $temp>10?'大':'小';
        }
        if(in_array($rows['value']['class'][1], ['单', '双'])){
            $temp = fmod($temp, 2)==0?'双':'单';
        }
        if(in_array($rows['value']['class'][1],['大单', '大双','小单','小双'])){
            if($temp >10){
                $temp = fmod($temp, 2) == 0 ? '大双' : '大单';
            }else if($temp<=10){
                $temp = fmod($temp, 2) == 0 ? '小双' : '小单';
            }else{
                $temp ='';
            }
        }
        if($rows['value']['class'][1]==$temp){
            $info['bet_ok'][$rows['id']]['money'] = floor($rows['money']*$rows['value']['odds']);
        }
        $info['ok'][$rows['qishu']]['bet']['rows']++;
        $info['ok'][$rows['qishu']]['bet']['money']+= $rows['money'];
        $info['ok'][$rows['qishu']]['bet']['user'][$rows['uid']] = true;
        $info['ok'][$rows['qishu']]['bet']['win']-= $rows['money'];
        $info['bet_ok'][$rows['id']]['money']>0&&$info['ok'][$rows['qishu']]['bet']['win']+= $info['bet_ok'][$rows['id']]['money'];
    }
}

if(!empty($info['bet_ok'])){
    foreach($info['bet_ok'] as $id=>$val){
        if(!isset($info['user'][$val['uid']])){
            $stmt = $mydata1_db->prepare('SELECT `username`, `money` FROM `k_user` WHERE `uid`=:uid');
            $stmt->execute([':uid' => $val['uid']]);
            $info['user'][$val['uid']] = $stmt->fetch();
            $info['user'][$val['uid']]['win'] = 0;
        }
        $stmt = $mydata1_db->prepare('UPDATE `c_bet_data` SET `status`=1, `win`=:win, `value`=:value WHERE `id`=:id');
        $stmt->execute([
            ':id' => $id,
            ':win' => $val['money'],
            ':value' => serialize($val['value']),
        ]);
        if($val['money']<0){
            $val['money'] = 0;
        }else{
            $val['money']/= 100;
            $info['user'][$val['uid']]['money']+= $val['money'];
            $info['user'][$val['uid']]['win']+= $val['money'];
        }
        $stmt = $mydata1_db->prepare('INSERT INTO `k_money_log` (`uid`, `userName`, `gameType`, `transferType`, `transferOrder`, `transferAmount`, `previousAmount`, `currentAmount`, `creationTime`) VALUES (:uid, :userName, :gameType, :transferType, :transferOrder, :transferAmount, :previousAmount, :currentAmount, :creationTime)');
        $stmt->execute([
            ':uid' => $val['uid'],
            ':userName' => $info['user'][$val['uid']]['username'],
            ':gameType' => 'FFK3',
            ':transferType' => 'RECKON',
            ':transferOrder' => 'LOT_'.$id,
            ':transferAmount' => $val['money'],
            ':previousAmount' => $info['user'][$val['uid']]['money']-$val['money'],
            ':currentAmount' => $info['user'][$val['uid']]['money'],
            ':creationTime' => date('Y-m-d H:i:s'),
        ]);
    }
}
if(!empty($info['user'])){
    foreach($info['user'] as $uid=>$val){
        $stmt = $mydata1_db->prepare('UPDATE `k_user` SET `money`=`money`+:money WHERE `uid`=:uid');
        $stmt->execute([':money' => $val['win'], ':uid' => $uid]);
    }
}
$data = [0, 0, 0];
$data_file = '../../cache/ffk3.data.php';
file_exists($data_file)&&$data = include($data_file);
$stmt = $mydata1_db->prepare('SELECT `id`, `qishu`, `value`, `status` FROM `c_auto_data` WHERE `type`=:type AND `status` IN (0, 3) AND `opentime`<=:time ORDER BY `qishu` ASC');
$stmt->execute([':type' => 'FFK3', ':time' => $now]);
while ($rows = $stmt->fetch()) {
    if(isset($info['ok'][$rows['qishu']])){
        $info['ok'][$rows['qishu']]['bet']['user'] = count($info['ok'][$rows['qishu']]['bet']['user']);
        if($info['ok'][$rows['qishu']]['bet']['money']>0){
            $info['ok'][$rows['qishu']]['bet']['ratio'] = round($info['ok'][$rows['qishu']]['bet']['win']/$info['ok'][$rows['qishu']]['bet']['money']*10000);
            if ($rows['status'] != 3) {
                $data[0]+= $info['ok'][$rows['qishu']]['bet']['money']/100;
                $data[1]+= $info['ok'][$rows['qishu']]['bet']['win']/100;
                $data[2] = round($data[1]/$data[0]*10000);
                isset($data[3])||$data[3] = $info['ok'][$rows['qishu']]['qishu'];
                file_put_contents($data_file, '<?php'.PHP_EOL.'return unserialize(\''.serialize($data).'\');');
            }
        }
    }else{
        $info['ok'][$rows['qishu']] = unserialize($rows['value']);
        $info['ok'][$rows['qishu']]['bet'] = [
            'money' => 0,
            'win' => 0,
            'user' => 0,
            'rows' => 0,
            'ratio' => 0,
        ];
    }
    $stmt1 = $mydata1_db->prepare('UPDATE `c_auto_data` SET `status`=1, `value`=:value WHERE `id`=:id');
    $stmt1->execute([
        ':id' => $rows['id'],
        ':value' => serialize($info['ok'][$rows['qishu']]),
    ]);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>分分快3-结算</title>
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

    var limit="<?php echo rand(5, 10); ?>"
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

            <font color="#FF0000">分分快3共结算<?=count($info['bet_ok'])?>个注单</font></td>
    </tr>
</table>
</body>
</html>
