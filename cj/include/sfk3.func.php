<?php
function getRanking()
{

    $return = [1 => []];
    for ($i = 1; $i <= 6; $i++) {
        $return[1][$i] = 1000;
    }
    for ($i = 2; $i <= 3; $i++) {
        $return[$i] = $return[1];
    }

    return $return;
}

function getNumber($tempNum, $check = false)
{
    $return = [];
    if ($check) {
        // 根据历史结果获取开奖号码
        foreach ($tempNum as $val) {
            $temp1 = $temp2 = $temp3 = $val;
            foreach ($temp1 as $k => $v) {
                if ($k < 10 && $v > rand(1000, 1005)) {
                    unset($temp1[$k]);
                }
            }
            $temp0 = array_intersect_key($temp1, $temp2, $temp3);
            if (count($temp0) >= 3) {
                $val = $temp0;
            } else {
                $temp0 = [
                    array_intersect_key($temp1, $temp2),
                    array_intersect_key($temp1, $temp3),
                    array_intersect_key($temp2, $temp3),
                ];
                $temp0 = $temp0[0] + $temp0[1] + $temp0[2];
                if (count($temp0) >= 3) {
                    $val = $temp0;
                } else {
                    // 2018-01-14: 部分情况下$temp1、$temp2、$temp3的合集不符合要求
                    $temp0 = $temp1 + $temp2 + $temp3;
                    count($temp0) >= 3 && $val = $temp0;
                }
            }
            $return[] = array_rand($val);
        }
    } else {
        foreach ($tempNum as $val) {
            $return[] = array_rand($val);
        }
    }

    return $return;
}

function checkBet($qishu, $tempArray)
{
    // 计算盈亏比例
    $stmt = $GLOBALS['mydata1_db']->prepare('SELECT `money`, `win`, `value` FROM `c_bet_data` WHERE `type`=:type AND `qishu`=:qishu AND `status`=0 ORDER BY `id` ASC');
    $stmt->execute([':type' => 'SFK3', ':qishu' => $qishu]);
    if ($stmt->rowCount() > 0) {
        $return = [];
        foreach ($tempArray as $key => $val) {
            $tempArray[$key]           = ['opencode' => $val, 'info' => []];
            $tempArray[$key]['info'][] = array_sum($val);
            $tempArray[$key]['info'][] = $tempArray[$key]['info'][0] > 10 ? '大' : '小';
            $return[$key] = [0, 0, 0];
        }
        $betArray = [];
        // 统计所有类型记录
        while ($rows = $stmt->fetch()) {
            $rows['value'] = unserialize($rows['value']);
            $rows          = array_merge($rows['value'], ['money' => $rows['money'] / 100, 'win' => $rows['win'] / 100]);
            $rows['key']   = $rows['class'][0] . '/' . $rows['class'][1];
            !isset($betArray[$rows['key']]) && $betArray[$rows['key']] = [
                'class' => $rows['class'],
                'odds'  => [],
            ];
            $rows['odds'] = 'j' . $rows['odds'];
            !isset($betArray[$rows['key']]['odds'][$rows['odds']]) && $betArray[$rows['key']]['odds'][$rows['odds']] = 0;
            $betArray[$rows['key']]['odds'][$rows['odds']] += $rows['money'];
        }
        // 计算各个结果的占比
        foreach ($betArray as $bet) {
            foreach ($bet['odds'] as $odds => $money) {
                $odds = substr($odds, 1);
                foreach ($tempArray as $key => $val) {
                    $tempNum         = $val['opencode'];
                    $tempInfo        = $val['info'];
                    $return[$key][0]+= $money;
                    $return[$key][1]-= $money;
                    $temp            = '';
                    switch ($bet['class'][0]) {
                        case '和值':
                            $temp = $tempInfo[0];
                            break;
                        case '三同号通选':
                            if(isThreeSameBalls($tempNum) >0){
                                $return[$key][1] += $money * $odds;
                            }
                            break;
                        case '三同号单选':
                            $betBalls = $bet['class'][1];
                            if(isThreeSameBalls($tempNum)!=0 && isThreeSameBalls($tempNum)==isThreeSameBalls(array($betBalls[0],$betBalls[1],$betBalls[2]))){
                                $return[$key][1] += $money * $odds;
                            }
                            break;
                        case '三不同号':
                            if(isNoSameBalls($tempNum,$bet['class'][1])){
                                $return[$key][1] += $money * $odds;
                            }
                            break;
                        case '三连号单选':
                            if(isThreeEvenNumber($tempNum,$bet['class'][1])){
                                $return[$key][1] += $money * $odds;
                            }
                            break;
                        case '三连号通选':
                            if(isThreeEvenNumber($tempNum)){
                                $return[$key][1] += $money * $odds;
                            }
                            break;
                        case '二同号复选':
                            if(twoDiff($tempNum,$bet['class'][1])){
                                $return[$key][1] += $money * $odds;
                            }
                            break;
                        case '二同号单选':
                            if(twoSampleChoose($tempNum,$bet['class'][1])){
                                $return[$key][1] += $money * $odds;
                            }
                            break;
                        case '二不同号':
                            if(twoDiff($tempNum,$bet['class'][1])){
                                $return[$key][1] += $money * $odds;
                            }
                            break;
                    }
                    if (in_array($bet['class'][1], ['大', '小'])) {
                        $temp = $temp > 10 ? '大' : '小';
                    }
                    if (in_array($bet['class'][1], ['单', '双'])) {
                        $temp = fmod($temp, 2) == 0 ? '双' : '单';
                    }
                    if(in_array($bet['class'][1],['大单', '大双','小单','小双'])){
                        if($temp >10){
                            $temp = fmod($temp, 2) == 0 ? '大双' : '大单';
                        }else if($temp<=10){
                            $temp = fmod($temp, 2) == 0 ? '小双' : '小单';
                        }else{
                            $temp ='';
                        }
                    }
                    if($bet['class'][1]==$temp){
                        $return[$key][1]+= $money*$odds;
                    }

                }
            }
        }
        foreach ($return as $key => $val) {
            $return[$key][2] = $val[0] > 0 ? -1 * round($val[1] / $val[0] * 10000) : 0;
        }
        return $return;
    } else {
        return [];
    }
}


