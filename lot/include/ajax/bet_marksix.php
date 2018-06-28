<?php
!defined('IN_LOT')&&die('Access Denied');

switch(false){
    case $LOT['user']['login']:
        result('请先登录网站');
        break;

    case isset($LOT['input']['betParameters'])&&!empty($LOT['input']['betParameters']):
        result('请选择一个玩法');
        break;

    case check_order():
        break;

    default:
        $member = $mydata2_db->prepare('SELECT `id` FROM `ka_mem` WHERE `kauser`=:kauser LIMIT 1');
        $member->execute(array(':kauser' => $LOT['user']['username']));
        if($member->rowCount()<=0){
            result('投注失败，请联系在线客服。');
        }else if(!empty($LOT['marksix'])&&strtotime($LOT['marksix']['zfbdate'])>=$LOT['bjtime']&&intval($LOT['marksix']['zfb'])>0){

            $member = $member->fetch();
            $bet_class = array();
            $bet_money = 0;
            /* 整合下注类型 */
            foreach($LOT['input']['betParameters'] as $i=>$val){
                $key = substr('0000'.$val['Id'], -4);
                $id1 = intval(substr($key, 0, 2));
                $id2 = intval(substr($key, 2));
                $key1 = $LOT['odds'][$id1][0][0];
                if(check_odds($id1, $id2)&&isset($LOT['odds'][$id1][0])){
                    $bet_money+= abs($val['Money']);
                    if(isset($LOT['odds'][$id1][0][4])){
                        $key3 = $key2 = array();
                        $LOT['input']['betParameters'][$i]['class'] = $LOT['odds'][$id1][0][4];
                        $count = 0;
                        isset($val['BetContext'])&&is_array($val['BetContext'])&&$count = count($val['BetContext']);
                        !isset($LOT['odds'][$id1][0][6])&&$LOT['odds'][$id1][0][6] = $LOT['odds'][$id1][0][5];
                        if($count>=$LOT['odds'][$id1][0][5]&&$count<=$LOT['odds'][$id1][0][6]){
                            switch($LOT['odds'][$id1][0][4]){
                                case 'guoguan':
                                    $min = $LOT['odds'][$id1][0][2];
                                    $max = $LOT['odds'][$id1][0][3];
                                    $temp = array();
                                    foreach($val['BetContext'] as $bet){
                                        $key = substr('0000'.$bet['Id'], -4);
                                        $id1 = intval(substr($key, 0, 2));
                                        $id2 = intval(substr($key, 2));
                                        !isset($temp[$id1])&&$temp[$id1] = array();
                                        if(!in_array($id2, $temp[$id1])&&check_odds($id1, $id2, $min, $max)&&isset($LOT['odds'][$id1][0])){
                                            $temp[$id1][] = $id2;
                                            $key2[] = $id1;
                                            $key3[] = $id2;
                                            $k1 = $LOT['odds'][$id1][0][0];
                                            $k2 = $LOT['odds'][$id1][0][1];
                                            !isset($bet_class[$k1])&&$bet_class[$k1] = array();
                                            !in_array($k2, $bet_class[$k1])&&$bet_class[$k1][] = $k2;
                                        }else{
                                            $key2 = '';
                                            break;
                                        }
                                    }
                                    break;
                                case 'weilian':
                                    $key2 = $LOT['odds'][$id1][0][1];
                                    !isset($bet_class[$key1])&&$bet_class[$key1] = array();
                                    !in_array($key2, $bet_class[$key1])&&$bet_class[$key1][] = $key2;
                                    foreach($val['BetContext'] as $bet){
                                        $id2 = intval(substr('00'.$bet['Id'], -2));
                                        if(!in_array($id2, $key3)&&check_odds($id1, $id2)){
                                            $key3[] = $id2;
                                        }else{
                                            $key2 = '';
                                            break;
                                        }
                                    }
                                    break;
                            }
                        }else{
                            $bet_money = 0;
                            $limit = $LOT['odds'][$id1][0][5];
                            $LOT['odds'][$id1][0][5]<$LOT['odds'][$id1][0][6]&&$limit.= '-'.$LOT['odds'][$id1][0][6];
                            result('只能选择'.$limit.'个号码');
                            break 2;
                        }
                        if(empty($key2)||empty($key3)){
                            $bet_money = 0;
                            result('内容有误，请刷新页面重试');
                            break;
                        }
                    }else{
                        $key2 = $LOT['odds'][$id1][0][1];
                        $key3 = $LOT['odds'][$id1][1][$id2];
                        !isset($bet_class[$key1])&&$bet_class[$key1] = array();
                        !in_array($key2, $bet_class[$key1])&&$bet_class[$key1][] = $key2;
                    }
                    $LOT['input']['betParameters'][$i]['type'] = array($key1, $key2, $key3);
                }else{
                    $bet_money = 0;
                    result('内容有误，请刷新页面重试');
                    break;
                }
            }
            if($bet_money>0){
                /* 读取赔率 & ds 数据 */
                $odds = array();
                $userds = array();
                foreach($bet_class as $class1=>$val){
                    $userds[$class1] = $odds[$class1] = array();
                    foreach($val as $class2){
                        $sql = 'SELECT `class3`, `rate` FROM `ka_bl` WHERE `class1`=:class1 AND `class2`=:class2 ORDER BY `id` ASC';
                        $stmt = $mydata2_db->prepare($sql);
                        $stmt->execute(array(
                            ':class1' => $class1,
                            ':class2' => $class2,
                        ));
                        $userds[$class1][$class2] = $odds[$class1][$class2] = array();
                        while($rows = $stmt->fetch()){
                            $odds[$class1][$class2][$rows['class3']] = floatval($rows['rate']);
                        }
                        $dsclassArray = get_userds3($class1);
                        empty($dsclassArray)&&$dsclassArray = get_userds1($class2);
                        if(!empty($dsclassArray)){
                            $sql = 'SELECT `ds`, `yg` FROM `ka_quota` WHERE `username`=\'gd\' AND `id` IN ('.implode(', ', $dsclassArray).')';
                            $query = $mydata2_db->query($sql);
                            while($rows = $query->fetch()){
                                $key = trim($rows['ds']);
                                $userds[$class1][$class2][$key] = $rows['yg'];
                            }
                        }
                    }
                }
                if(!empty($odds)&&!empty($userds)){
                    /* 生成下注信息 */
                    $order = array();
                    foreach($LOT['input']['betParameters'] as $val){
                        $val['Money'] = abs($val['Money']);
                        $class1 = $val['type'][0];
                        if(isset($val['class'])){
                            switch($val['class']){
                                case 'guoguan':
                                    $class3 = $class2 = '';
                                    $class4 = array('lines' => -1, 'userds' => -1, 'ds_key' => -1);
                                    foreach($val['type'][1] as $i=>$key){
                                        $i = $val['type'][2][$i];
                                        $val['Id'] = strval(show_id($key, $i));
                                        $c2 = $LOT['odds'][$key][0][1];
                                        $c3 = $LOT['odds'][$key][1][$i];
                                        if(check_class($class1, $c2, $c3)){
                                            $class2.= $c2.',';
                                            $class3.= $c3.','.$odds[$class1][$c2][$c3].',';
                                            if($class4['lines']<0){
                                                $class4['lines'] = $odds[$class1][$c2][$c3];
                                            }else{
                                                $class4['lines']*= $odds[$class1][$c2][$c3];
                                            }
                                        }
                                        if($class4['userds']<0){
                                            $ds_key = get_userds2($class1, $c2, $c3);
                                            if(check_userds($class1, $c2, $ds_key)){
                                                $class4['userds'] = $userds[$class1][$c2][$ds_key];
                                                $class4['ds_key'] = $ds_key;
                                            }
                                        }
                                    }
                                    $odds[$class1][$class2] = $userds[$class1][$class2] = array();
                                    $odds[$class1][$class2][$class3] = round($class4['lines'], 2);
                                    $userds[$class1][$class2][$class4['ds_key']] = $class4['userds'];
                                    break;
                                case 'weilian':
                                    $class2 = $val['type'][1];
                                    $class3 = array();
                                    $class4 = array('lines' => -1, 'userds' => -1, 'ds_key' => -1);
                                    $key = intval(substr('0000'.$val['Id'], -4, 2));
                                    foreach($val['type'][2] as $i){
                                        $val['Id'] = strval(show_id($key, $i));
                                        $c3 = $LOT['odds'][$key][1][$i];
                                        if($LOT['odds'][$key][0][0]=='连码'){
                                            isset($odds[$class1])&&isset($odds[$class1][$class2])&&$class3[] = $c3;
                                        }elseif(check_class($class1, $class2, $c3)){
                                            $class3[] = $c3;
                                            $lines = $odds[$class1][$class2][$c3];
                                            ($class4['lines']<0||$class4['lines']>$lines)&&$class4['lines'] = $lines;
                                        }
                                        if($class4['userds']<0){
                                            $ds_key = get_userds2($class1, $class2, $c3);
                                            if(check_userds($class1, $class2, $ds_key)){
                                                $class4['userds'] = $userds[$class1][$class2][$ds_key];
                                                $class4['ds_key'] = $ds_key;
                                            }
                                        }
                                    }
                                    $class3 = implode(',', $class3);
                                    if($LOT['odds'][$key][0][0]=='连码'){
                                        $class4['lines'] = get_lianma($class1, $class2);
                                        $odds[$class1][$class2][$class3] = $class4['lines'][0];
                                        !isset($odds['rate'])&&$odds['rate'] = array();
                                        $odds['rate'][$class3] = $class4['lines'][1];
                                    }else{
                                        $odds[$class1][$class2][$class3] = $class4['lines'];
                                    }
                                    $userds[$class1][$class2][$class4['ds_key']] = $class4['userds'];
                                    break;
                                default:
                                    $order = array();
                                    break 2;
                            }
                        }else{
                            $class2 = $val['type'][1];
                            $class3 = $val['type'][2];
                        }
                        $ds_key = get_userds2($class1, $class2, $class3);
                        if(
                            check_class($class1, $class2, $class3)&&
                            check_userds($class1, $class2, $ds_key)&&
                            floatval($val['Lines'])==$odds[$class1][$class2][$class3]
                        ){
                            $order[] = array(
                                ':num' => substr(date('YmdHis', $LOT['bjtime']), -12),
                                ':username' => $LOT['user']['username'],
                                ':kithe' => $LOT['marksix']['nn'],
                                ':adddate' => date('Y-m-d H:i:s', $LOT['bjtime']),
                                ':class1' => $class1,
                                ':class2' => $class2,
                                ':class3' => $class3,
                                ':rate' => $odds[$class1][$class2][$class3],
                                ':rate2' => get_rate($class3),
                                ':sum_m' => $val['Money'],
                                ':user_ds' => $userds[$class1][$class2][$ds_key],
                                ':dai' => 'daili',
                                ':zong' => 'zong',
                                ':guan' => 'guan',
                                ':memid' => $member['id'],
                                ':abcd' => 'A',
                            );
                        }else{
                            $order = array();
                            result('<span style="color:red">{0}</span><br />请您重新确认投注', 9, $val['Id']);
                            break;
                        }
                    }
                    if(!empty($order)){
                        $last_money = update_money($LOT['user']['uid'], $bet_money);
                        if($last_money>0){
                            $sql = 'INSERT INTO `ka_tan` SET `num`=:num, `username`=:username, `kithe`=:kithe, `adddate`=:adddate, `class1`=:class1, `class2`=:class2, `class3`=:class3, `rate`=:rate, `sum_m`=:sum_m, `user_ds`=:user_ds, `dai_ds`=0, `zong_ds`=0, `guan_ds`=0, `dai_zc`=0, `zong_zc`=0, `guan_zc`=0, `dagu_zc`=0, `bm`=0, `dai`=:dai, `zong`=:zong, `guan`=:guan, `memid`=:memid, `danid`=3, `zongid`=2, `guanid`=1, `abcd`=:abcd, `lx`=0, `rate2`=:rate2';
                            foreach($order as $params){
                                $stmt = $mydata2_db->prepare($sql);
                                $stmt->execute($params);
                                $stmt = $mydata1_db->prepare('INSERT INTO `k_money_log` (`uid`, `userName`, `gameType`, `transferType`, `transferOrder`, `transferAmount`, `previousAmount`, `currentAmount`, `creationTime`) VALUES (:uid, :userName, :gameType, :transferType, :transferOrder, :transferAmount, :previousAmount, :currentAmount, :creationTime)');
                                $stmt->execute(array(
                                    ':uid' => $LOT['user']['uid'],
                                    ':userName' => $LOT['user']['username'],
                                    ':gameType' => 'SIX',
                                    ':transferType' => 'BET',
                                    ':transferOrder' => 'LOT_'.$params[':num'],
                                    ':transferAmount' => -1*$params[':sum_m'],
                                    ':previousAmount' => $last_money,
                                    ':currentAmount' => $last_money-$params[':sum_m'],
                                    ':creationTime' => date('Y-m-d H:i:s'),
                                ));
                                $last_money-= $params[':sum_m'];
                            }
                            result('投注成功', 1);
                        }else{
                            result('投注金额超过余额');
                        }
                    }
                }
            }
        }else{
            result('已经封盘，禁止下注');
        }
        break;
}
empty($LOT['output'])&&result('系统错误，请刷新页面重试');

function get_userds1($class2){
    $dsclassArray = array();
    switch($class2){
        case '特A':
            $dsclassArray = array(16630, 16632, 16633, 16634, 16640, 16654, 16663, 16664, 16665);
        break;
        case '特B':
            $dsclassArray = array(16631, 16632, 16633, 16634, 16640, 16654, 16663, 16664, 16665);
        break;
        case '正A':
            $dsclassArray = array(16636, 16638, 16639);
        break;
        case '正B':
            $dsclassArray = array(16637, 16638, 16639);
        break;
        case '正1特':
        case '正2特':
        case '正3特':
        case '正4特':
        case '正5特':
        case '正6特':
            $dsclassArray = array(16632, 16633, 16634, 16635, 16640);
        break;
        case '正码1':
        case '正码2':
        case '正码3':
        case '正码4':
        case '正码5':
        case '正码6':
            $dsclassArray[] = 16677;
        break;
        case '半波':
            $dsclassArray[] = 16641;
        break;
        case '正特尾数':
            $dsclassArray[] = 16660;
        break;
        case '一肖':
            $dsclassArray[] = 16652;
        break;
        case '二肖':
        case '三肖':
        case '四肖':
        case '五肖':
        case '六肖':
        case '七肖':
        case '八肖':
        case '九肖':
        case '十肖':
        case '十一肖':
            $dsclassArray[] = 16651;
        break;
        case '特肖':
            $dsclassArray[] = 16648;
        break;
        case '三全中':
            $dsclassArray[] = 16644;
        break;
        case '三中二':
            $dsclassArray[] = 16645;
        break;
        case '二全中':
            $dsclassArray[] = 16643;
        break;
        case '二中特':
            $dsclassArray[] = 16646;
        break;
        case '特串':
            $dsclassArray[] = 16647;
        break;
        case '四中一':
            $dsclassArray[] = 16675;
        break;
        default:
    }
    return $dsclassArray;
}
function get_userds2($class1, $class2, $class3){
    $user_class = '0';
    switch ($class1){
        case '特码':
            switch ($class3){
                case '单':
                case '双':
                    $user_class = '单双';
                break;
                case '大':
                case '小':
                    $user_class = '大小';
                break;
                case '合单':
                case '合双':
                    $user_class = '合数单双';
                break;
                case '红波':
                case '绿波':
                case '蓝波':
                    $user_class = '色波';
                break;
                case '家禽':
                case '野兽':
                    $user_class = '家禽野兽';
                break;
                case '尾大':
                case '尾小':
                    $user_class = '尾大尾小';
                break;
                case '大单':
                case '小单':
                    $user_class = '大单小单';
                break;
                case '大双':
                case '小双':
                    $user_class = '大双小双';
                break;
                default:
                    $user_class = $class2;
                break;
            }
        break;
        case '正码':
            switch ($class3){
                case '总单':
                case '总双':
                    $user_class = '总和单双';
                break;
                case '总大':
                case '总小':
                    $user_class = '总和大小';
                break;
                default:
                    $user_class = $class2;
                break;
            }
        break;
        case '正特':
            switch ($class3){
                case '单':
                case '双':
                    $user_class = '单双';
                break;
                case '大':
                case '小':
                    $user_class = '大小';
                break;
                case '合单':
                case '合双':
                    $user_class = '合数单双';
                break;
                case '红波':
                case '绿波':
                case '蓝波':
                    $user_class = '色波';
                break;
                default:
                    $user_class = '正特';
                break;
            }
        break;
        case '正1-6':
        case '半波':
        case '正特尾数':
            $user_class = $class1;
        break;
        case '生肖':
            switch ($class2){
                case '二肖':
                case '三肖':
                case '四肖':
                case '五肖':
                case '六肖':
                case '七肖':
                case '八肖':
                case '九肖':
                case '十肖':
                case '十一肖':
                    $user_class = '六肖';
                break;
                default:
                    $user_class = $class2;
                break;
            }
        break;
        case '过关':
            $user_class = '正码过关';
        break;
        case '生肖连':
        case '尾数连':
        case '全不中':
        case '连码':
            $user_class = $class2;
        break;
    }
    return $user_class;
}
function get_userds3($class1){
    $dsclassArray = array();
    switch($class1){
        case '过关':
            $dsclassArray[] = 16642;
        break;
        case '尾数连':
            $dsclassArray = array(16686, 16687, 16688, 16689, 16690, 16691);
        break;
        case '生肖连':
            $dsclassArray = array(16678, 16679, 16680, 16681, 16682, 16683, 16684, 16685);
        break;
        case '全不中':
            $dsclassArray = array(16667, 16668, 16669, 16670, 16671, 16672, 16673, 16674);
        break;
    }
    return $dsclassArray;
}
function check_class($class1, $class2, $class3){
    global $odds;
    return isset($odds[$class1])&&isset($odds[$class1][$class2])&&isset($odds[$class1][$class2][$class3]);
}
function check_userds($class1, $class2, $ds_key){
    global $userds;
    return isset($userds[$class1])&&isset($userds[$class1][$class2])&&isset($userds[$class1][$class2][$ds_key]);
}
function get_rate($class3){
    global $odds;
    return isset($odds['rate'])&&isset($odds['rate'][$class3])?$odds['rate'][$class3]:0;
}
function get_lianma($class1, $class2){
    global $odds;
    $return = array(0, 0);
    switch($class2){
        case '二全中':
            $return[0] = $odds[$class1][$class2]['二全中'];
        break;
        case '二中特':
            $return[0] = $odds[$class1][$class2]['中二'];
            $return[1] = $odds[$class1][$class2]['中特'];
        break;
        case '特串':
            $return[0] = $odds[$class1][$class2]['特串'];
        break;
        case '三全中':
            $return[0] = $odds[$class1][$class2]['三全中'];
        break;
        case '三中二':
            $return[0] = $odds[$class1][$class2]['中三'];
            $return[1] = $odds[$class1][$class2]['中二'];
        break;
        case '四中一':
            $return[0] = $odds[$class1][$class2]['四中一'];
        break;
    }
    return $return;
}