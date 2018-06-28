<?php
session_start();
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';

$stmt = $mydata1_db->query('SELECT * FROM `packets_config` WHERE `uid`=0');
if($stmt->rowCount()>0){
    $rows = $stmt->fetch();
    !($packets = unserialize($rows['value']))&&$packets = array();
    $packets['count'] = $rows['count'];
    $packets['money'] = $rows['money'];
}else{
    $packets = array();
}
$packets['now'] = time();
!isset($_POST['action'])&&$_POST['action'] = 'default';
$output = array();
if(isset($packets['open'])&&$packets['open']==1&&in_array($_POST['action'], array('lastest', 'info', 'check', 'bonus', 'query'))){
    switch ($_POST['action']) {
        case 'lastest':
            $params = array();
            $sql = 'SELECT * FROM `packets_list` WHERE `money`>0 AND `addtime` BETWEEN :s_time AND :e_time AND `status` BETWEEN 0 AND 2 ORDER BY `';
            if(isset($packets['showtime'])&&$packets['showtime']==1){
                $params[':e_time'] = $packets['now'];
                $params[':s_time'] = $params[':e_time']-86400;
            }else{
                $params[':s_time'] = $packets['opentime'];
                $params[':e_time'] = $packets['closetime'];
            }
            $sql.= isset($packets['showorder'])&&$packets['showorder']==1?'money':'addtime';
            $stmt = $mydata1_db->prepare($sql.'` DESC LIMIT 48');
            $stmt->execute($params);
            while ($rows = $stmt->fetch()) {
                $output[] = array(
                    'id' => 'j'.$rows['id'],
                    'username' => cutName($rows['username']),
                    'money' => $rows['money']/100,
                    'time' => date('Y-m-d H:i:s', $rows['addtime']),
                );
            }
            // sort($output);
            break;
        case 'info':
            $output = getInfo();
            break;
        case 'check':
            $info = getInfo();
            $output = array('status' => -1);
            if($info['open']>0||$info['next']!=0||$info['close']==0||$info['end']==-1||!isset($packets['group'])||!isset($packets['group'][0])){
                $output = array('status' => 99);
            }else if(isset($_POST['username'])){
                $stmt = $mydata1_db->prepare('SELECT `uid`, `username`, `money`, `is_stop`, `gid`, `is_daili` FROM `k_user` WHERE `username`=:username AND `is_delete`=0 LIMIT 1');
                $stmt->execute(array(':username' => $_POST['username']));
                if($stmt->rowCount()>0){
                    $user = $stmt->fetch();
                    $query = $mydata1_db->query('SELECT * FROM `packets_config` WHERE `uid`='.$user['uid']);
                    if($query->rowCount()>0){
                        $rs = $query->fetch();
                        // $rs['value'] = unserialize($rs['value']);
                    }else{
                        $rs = array('stop' => 0, 'count' => 0, 'value' => array());
                        $mydata1_db->query('INSERT INTO `packets_config` (`uid`, `value`) VALUES ('.$user['uid'].', \'a:0:{}\')');
                    }
                    $config = $packets['group'][0];
                    $gid = $user['gid'];
                    isset($packets['group'][$gid])&&isset($packets['group'][$gid]['default'][0])&&$packets['group'][$gid]['default'][0]==1&&$config = $packets['group'][$gid];
                    switch (true) {
                        case $user['is_stop']==1:
                        case $user['money']<0:
                        case !(isset($packets['allow_daili'])&&$packets['allow_daili']==1)&&$user['is_daili']==1:
                        case $rs['stop']==1:
                        case isset($config['disable'])&&$config['disable']==1:
                            $output = array('status' => 97);
                            break;
                        case $rs['count']==0&&(isset($config['default'][0])&&$config['default'][0]==1)&&(!isset($config['data'])||empty($config['data'])):
                            $output = array('status' => 96);
                            break;
                        case !(isset($packets['allow_mobile'])&&$packets['allow_mobile']==1)&&(!isset($userinfo['mobile'])||empty($userinfo['mobile'])):
                            $output = array('status' => 95);
                            break;
                        case !(isset($packets['allow_bank'])&&$packets['allow_bank']==1)&&(!isset($userinfo['pay_card'])||empty($userinfo['pay_card'])||!isset($userinfo['pay_num'])||empty($userinfo['pay_num'])||!isset($userinfo['pay_address'])||empty($userinfo['pay_address'])||!isset($userinfo['pay_name'])||empty($userinfo['pay_name'])):
                            $output = array('status' => 94);
                            break;
                        default:
                            $valid = isset($packets['valid'])&&$packets['valid']==1;
                            $end = strtotime(date('Y-m-d 23:59:59', $packets['now']))-86400;
                            if($rs['last']>=$end){
                                $count = $rs['count'];
                            }else{
                                if($valid&&$rs['last']>=$packets['opentime']){
                                    $count = $rs['count'];
                                }else{
                                    $count = 0;
                                    addLogs($user['uid'], array(
                                        'type' => array('system'),
                                        'sum' => 0,
                                        'start' => $packets['now'],
                                        'end' => $packets['now'],
                                        'rule' => array(2, -1*$rs['count']),
                                        'count' => 0,
                                    ));
                                }
                                foreach($config['data'] as $key=>$val){
                                    if($end>$val['end']||!isset($val['type'])||empty($val['type'])||!isset($val['option'])||count($val['option'])<3){
                                        continue;
                                    }
                                    $sum = 0;
                                    if($valid){
                                        if($rs['last']<=$val['start']){
                                            $start = $val['start'];
                                        }else{
                                            $start = $rs['last']+1;
                                        }
                                    }else{
                                        $start = $end-86399;
                                    }
                                    foreach($val['type'] as $k){
                                        $params = array(
                                            ':uid' => $user['uid'],
                                            ':s_time' => date('Y-m-d H:i:s', $start),
                                            ':e_time' => date('Y-m-d H:i:s', $end),
                                        );
                                        switch (true) {
                                            case in_array($k, array('m_1', 'm_3')):
                                                $params[':type'] = substr($k, -1);
                                                $stmt = $mydata1_db->prepare('SELECT SUM(`m_value`) AS `sum` FROM `k_money` WHERE `type`=:type AND `status`=1 AND `uid`=:uid AND `m_make_time` BETWEEN :s_time AND :e_time');
                                                $stmt->execute($params);
                                                $rows = $stmt->fetch();
                                                $sum+= $rows['sum'];
                                                break;
                                            case $k=='h_0':
                                                $stmt = $mydata1_db->prepare('SELECT SUM(`money`) AS `sum` FROM `huikuan` WHERE `status`=1 AND `uid`=:uid AND `adddate` BETWEEN :s_time AND :e_time');
                                                $stmt->execute($params);
                                                $rows = $stmt->fetch();
                                                $sum+= $rows['sum'];
                                                break;
                                            case $k=='t_0':
                                                $stmt = $mydata1_db->prepare('SELECT SUM(`bet_money`) AS `sum` FROM `k_bet` WHERE `uid`=:uid AND `status` IN (1, 2, 4, 5) AND `bet_time` BETWEEN :s_time AND :e_time');
                                                $stmt->execute($params);
                                                $rows = $stmt->fetch();
                                                $sum+= $rows['sum'];
                                                break;
                                            case $k=='t_1':
                                                $stmt = $mydata1_db->prepare('SELECT SUM(`bet_money`) AS `sum` FROM `k_bet_cg_group` WHERE `uid`=:uid AND `status` IN (1, 3) AND `bet_time` BETWEEN :s_time AND :e_time');
                                                $stmt->execute($params);
                                                $rows = $stmt->fetch();
                                                $sum+= $rows['sum'];
                                                break;
                                            case $k=='c_0':
                                                $params[':type'] = '重庆时时彩';
                                                $stmt = $mydata1_db->prepare('SELECT SUM(`money`) AS `sum` FROM `c_bet` WHERE `uid`=:uid AND `type`=:type AND `js`=1 AND `money`<>`win` AND `addtime` BETWEEN :s_time AND :e_time');
                                                $stmt->execute($params);
                                                $rows = $stmt->fetch();
                                                $sum+= $rows['sum'];
                                                break;
                                            case in_array($k, array('c_1', 'c_2')):
                                                $params[':type'] = $k=='c_1'?'广东快乐10分':'北京赛车PK拾';
                                                $stmt = $mydata1_db->prepare('SELECT SUM(`money`) AS `sum` FROM `c_bet_3` WHERE `uid`=:uid AND `type`=:type AND `js`=1 AND `money`<>`win` AND `addtime` BETWEEN :s_time AND :e_time');
                                                $stmt->execute($params);
                                                $rows = $stmt->fetch();
                                                $sum+= $rows['sum'];
                                                break;
                                            case in_array($k, array('c_3', 'c_4', 'c_5', 'c_6', 'c_8')):
                                                $params[':type'] = str_replace(array('c_3', 'c_4', 'c_5', 'c_6', 'c_8'), array('kl8', 'ssl', '3d', 'pl3', 'qxc'), $k);
                                                $params[':username'] = $user['username'];
                                                unset($params[':uid']);
                                                $stmt = $mydata1_db->prepare('SELECT SUM(`money`) AS `sum` FROM `lottery_data` WHERE `username`=:username AND `atype`=:type AND `bet_ok`=1 AND `bet_time` BETWEEN :s_time AND :e_time');
                                                $stmt->execute($params);
                                                $rows = $stmt->fetch();
                                                $sum+= $rows['sum'];
                                                break;
                                            case $k=='c_7':
                                                $params[':username'] = $user['username'];
                                                $params[':s_time'] = date('Y-m-d H:i:s', $start+43200);
                                                $params[':e_time'] = date('Y-m-d H:i:s', $end+43200);
                                                unset($params[':uid']);
                                                $stmt = $mydata1_db->prepare('SELECT SUM(`sum_m`) AS `sum` FROM `mydata2_db`.`ka_tan` WHERE `username`=:username AND `bm`=1 AND `checked`=1 AND `adddate` BETWEEN :s_time AND :e_time');
                                                $stmt->execute($params);
                                                $rows = $stmt->fetch();
                                                $sum+= $rows['sum'];
                                                break;
                                            case substr($k, 0, 2)=='l_':
                                                $params[':pid'] = substr($k, 2);
                                                $params[':s_time'] = $start;
                                                $params[':e_time'] = $end;
                                                $stmt = $mydata1_db->prepare('SELECT SUM(`valid_amount`) AS `sum` FROM `daily_report` WHERE `uid`=:uid AND `platform_id`=:pid AND `report_date` BETWEEN :s_time AND :e_time');
                                                $stmt->execute($params);
                                                $rows = $stmt->fetch();
                                                $sum+= $rows['sum']/100;
                                                break;
                                        }
                                    }
                                    if(isset($val['option'][0])&&$val['option'][0]==1){
                                        $val['option'][1]>0&&$count+= floor($sum*100/$val['option'][1])*$val['option'][2];
                                        $rule = array(1, $val['option'][1], $val['option'][2]);
                                    }else{
                                        $count+= $sum>=$val['option'][1]/100?$val['option'][2]:0;
                                        $rule = array(0, $val['option'][1], $val['option'][2]);
                                    }
                                    addLogs($user['uid'], array(
                                        'type' => $val['type'],
                                        'sum' => $sum*100,
                                        'start' => $start,
                                        'end' => $end,
                                        'rule' => $rule,
                                        'count' => $count,
                                    ));
                                }
                            }
                            if($count>0){
                                $output = array('status' => 0, 'score' => $count);
                            }else{
                                $output = array('status' => 96);
                            }
                            $stmt = $mydata1_db->prepare('UPDATE `packets_config` SET `count`=:count, `last`=:last WHERE `uid`=:uid');
                            // krsort($rs['value']);
                            // $rs['value'] = array_slice($rs['value'], 0, 60);
                            $stmt->execute(array(
                                ':uid' => $user['uid'],
                                ':last' => $end,
                                ':count' => $count,
                            ));
                            break;
                    }
                }else{
                    $output = array('status' => 98);
                }
            }
            break;
        case 'bonus':
            $info = getInfo();
            $output = array('status' => -1);
            if($info['open']>0||$info['next']!=0||$info['close']==0||$info['end']==-1||!isset($packets['group'])||!isset($packets['group'][0])){
                $output = array('status' => 99);
            }else if(isset($_POST['username'])){
                $stmt = $mydata1_db->prepare('SELECT `uid`, `username`, `money`, `is_stop`, `gid`, `is_daili` FROM `k_user` WHERE `username`=:username AND `is_delete`=0 LIMIT 1');
                $stmt->execute(array(':username' => $_POST['username']));
                if($stmt->rowCount()>0){
                    $user = $stmt->fetch();
                    $query = $mydata1_db->query('SELECT * FROM `packets_config` WHERE `uid`='.$user['uid']);
                    if($query->rowCount()>0){
                        $rs = $query->fetch();
                        // $rs['value'] = unserialize($rs['value']);
                    }else{
                        $rs = array('stop' => 0, 'count' => 0, 'value' => array());
                        $mydata1_db->query('INSERT INTO `packets_config` (`uid`, `value`) VALUES ('.$user['uid'].', \'a:0:{}\')');
                    }
                    $config = $packets['group'][0];
                    $gid = $user['gid'];
                    isset($packets['group'][$gid])&&isset($packets['group'][$gid]['default'][1])&&$packets['group'][$gid]['default'][1]==1&&$config = $packets['group'][$gid];
                    switch (true) {
                        case $user['is_stop']==1:
                        case $user['money']<0:
                        case !(isset($packets['allow_daili'])&&$packets['allow_daili']==1)&&$user['is_daili']==1:
                        case $rs['stop']==1:
                        case isset($config['disable'])&&$config['disable']==1:
                            $output = array('status' => 97);
                            break;
                        case $rs['count']==0||$rs['last']+86400<strtotime(date('Y-m-d 23:59:59', $packets['now'])):
                            $output = array('status' => 96);
                            break;
                        case !(isset($packets['allow_mobile'])&&$packets['allow_mobile']==1)&&(!isset($userinfo['mobile'])||empty($userinfo['mobile'])):
                            $output = array('status' => 95);
                            break;
                        case !(isset($packets['allow_bank'])&&$packets['allow_bank']==1)&&(!isset($userinfo['pay_card'])||empty($userinfo['pay_card'])||!isset($userinfo['pay_num'])||empty($userinfo['pay_num'])||!isset($userinfo['pay_address'])||empty($userinfo['pay_address'])||!isset($userinfo['pay_name'])||empty($userinfo['pay_name'])):
                            $output = array('status' => 94);
                            break;
                        default:
                            if(isset($config['rule'])&&!empty($config['rule'])){
                                $temp1 = array();
                                $weight = 0;
                                foreach($config['rule'] as $key=>$val){
                                    for($i=0;$i<$val[2];$i++){
                                        $temp1[] = $key;
                                    }
                                    $weight+= $val[2];
                                }
                                $i = rand(0, $weight-1);
                                $i = $temp1[$i];
                                $temp1 = $config['rule'][$i];
                            }else{
                                $temp1 = array(0, 0);
                            }
                            $money = $temp1[0]>=$temp1[1]?$temp1[0]:rand($temp1[0], $temp1[1]);
                            if($info['count']||$info['money']){
                                $info['money']&&$money>$packets['money']&&$money = $packets['money'];
                                $params = array(':uid' => 0, ':money' => $money);
                                if($info['count']&&$info['money']){
                                    $sql = 'UPDATE `packets_config` SET `count`=`count`-1, `money`=`money`-:money WHERE `uid`=:uid';
                                }else if($info['money']){
                                    $sql = 'UPDATE `packets_config` SET `money`=`money`-:money WHERE `uid`=:uid';
                                }else{
                                    unset($params[':money']);
                                    $sql = 'UPDATE `packets_config` SET `count`=`count`-1 WHERE `uid`=:uid';
                                }
                                $stmt = $mydata1_db->prepare($sql);
                                $stmt->execute($params);
                            }
                            $status = !isset($packets['auto'])||$packets['auto']!=1;
                            addLogs($user['uid'], array(
                                'type' => array('system'),
                                'sum' => 0,
                                'start' => $packets['now'],
                                'end' => $packets['now'],
                                'rule' => array(3, $money),
                                'count' => $rs['count']-1,
                            ));
                            // krsort($rs['value']);
                            // $rs['value'] = array_slice($rs['value'], 0, 60);
                            $stmt = $mydata1_db->prepare('UPDATE `packets_config` SET `count`=`count`-1, `money`=`money`+:money WHERE `uid`=:uid');
                            $stmt->execute(array(
                                ':uid' => $user['uid'],
                                ':money' => $money,
                            ));
                            $stmt = $mydata1_db->prepare('INSERT INTO `packets_list` (`uid`, `username`, `money`, `addtime`, `status`) VALUES (:uid, :username, :money, :addtime, :status)');
                            $stmt->execute(array(
                                ':uid' => $user['uid'],
                                ':username' => $user['username'],
                                ':money' => $money,
                                ':addtime' => $packets['now'],
                                ':status' => $status||$money==0?1:0,
                            ));
                            if($money>0){
                                $status&&update_money($user['uid'], $money/100);
                                $output = array('status' => 1, 'msg' => '恭喜发财，大吉大利', 'money' => sprintf('%.2f', $money/100));
                            }else{
                                $output = array('status' => 0, 'msg' => '手气不佳，再接再厉');
                            }
                            isset($temp1[3])&&!empty($temp1[3])&&$output['msg'] = $temp1[3];
                            break;
                    }
                }else{
                    $output = array('status' => 98);
                }
            }
            break;
        case 'query':
            $output = array('count' => 0, 'list' => array());
            if(isset($_POST['username'])&&!empty($_POST['username'])){
                $params = array(
                    ':username' => $_POST['username'],
                    ':s_time' => $packets['opentime'],
                    ':e_time' => $packets['closetime'],
                );
                $stmt = $mydata1_db->prepare('SELECT COUNT(*) AS `count` FROM `packets_list` WHERE `username`=:username AND `status` BETWEEN 0 AND 1 AND `addtime` BETWEEN :s_time AND :e_time');
                $stmt->execute($params);
                $rows = $stmt->fetch();
                if($rows['count']>0){
                    $output['count'] = $rows['count'];
                    !(isset($_POST['page'])&&preg_match('/^[1-9]\d*$/', $_POST['page']))&&$_POST['page'] = 1;
                    $params[':index'] = ($_POST['page']-1)*5;
                    $stmt = $mydata1_db->prepare('SELECT * FROM `packets_list` WHERE `username`=:username AND `status` BETWEEN 0 AND 1 AND `addtime` BETWEEN :s_time AND :e_time ORDER BY `addtime` DESC LIMIT :index, 5');
                    $stmt->execute($params);
                    while ($rows = $stmt->fetch()) {
                        $output['list'][] = array(
                            'money' => sprintf('%.2f', $rows['money']/100),
                            'time' => date('Y年m月d日 H:i:s', $rows['addtime']),
                            'status' => $rows['status']==1?1:0,
                        );
                    }
                }
            }
            break;
    }
}

function cutName($val){
    $len = strlen($val)-4;
    if($len<=2){
        $val = substr($val, 0, $len).'****';
    }else{
        $val = substr($val, 0, ceil($len/2)).'****'.substr($val, -1*floor($len/2));
    }
    return $val;
}

function getInfo(){
    global $packets;
    $output = array();
    $output['open'] = $packets['opentime']-$packets['now'];
    $output['open']<0&&$output['open'] = 0;
    $output['close'] = $packets['closetime']-$packets['now'];
    $output['close']<0&&$output['close'] = 0;
    $output['count'] = false;
    $output['money'] = false;
    if($output['close']==0||empty($packets['limit'])){
        $output['next'] = -1;
        $output['end'] = -1;
    }else if($output['open']>0){
        $output['next'] = 0;
        $output['end'] = -1;
    }else{
        $output['end'] = 0;
        $time = strtotime(date('1970-01-01 H:i:s', $packets['now']))-14400;
        $temp1 = array();
        foreach($packets['limit'] as $val){
            if($val['start']<=$time&&$val['end']>=$time){
                if(
                    ($val['user']<=0&&$val['money']<=0)|| //不限制人数和红包彩池
                    ($val['user']<=0&&$val['money']>0&&$packets['money']>0)|| //不限制人数但是限制红包彩池
                    ($val['user']>0&&$val['money']<=0&&$packets['count']>0)|| //限制人数但是不限制红包彩池
                    ($packets['money']>0&&$packets['count']>0) //限制人数与红包彩池
                ){
                    $output['count'] = $val['user']>0?true:false;
                    $output['money'] = $val['money']>0?true:false;
                    $output['next'] = 0;
                    $output['end'] = $val['end']-$time;
                    break;
                }else{
                    $temp1[] = 86400+$val['start']-$time;
                }
            }else if($val['start']>$time){
                $temp1[] = $val['start']-$time;
            }else{
                $temp1[] = 86400+$val['start']-$time;
            }
        }
        !isset($output['next'])&&$output['next'] = min($temp1);
    }
    return $output;
}

function addLogs($uid, $value){
    global $mydata1_db, $packets;
    $stmt = $mydata1_db->prepare('INSERT INTO `packets_logs` (`uid`, `addtime`, `value`) VALUES (:uid, :addtime, :value)');
    return $stmt->execute(array(
        ':uid' => $uid,
        ':addtime' => $packets['now'],
        ':value' => serialize($value),
    ));
}

function update_money($uid, $money){
    global $mydata1_db, $packets;
    $return = -1;
    $params = array(':uid' => $uid);
    $sql = 'SELECT `uid`, `username`, `money` FROM `k_user` WHERE `uid`=:uid LIMIT 1';
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    if($stmt->rowCount()>0){
        $user = $stmt->fetch();
        $params[':money'] = $money;
        $sql = 'UPDATE `k_user` SET `money`=`money`+:money WHERE `uid`=:uid';
        $stmt = $mydata1_db->prepare($sql);
        if($stmt->execute($params)){
            $return = $user['money'];
            $packets_id = 'PACKETS_'.substr('0000000000'.$user['uid'], -10).date('YmdHis', $packets['now']);
            $stmt = $mydata1_db->prepare('INSERT INTO `k_money_log` (`uid`, `userName`, `gameType`, `transferType`, `transferOrder`, `transferAmount`, `previousAmount`, `currentAmount`, `creationTime`) VALUES (:uid, :userName, :gameType, :transferType, :transferOrder, :transferAmount, :previousAmount, :currentAmount, :creationTime)');
            $stmt->execute(array(
                ':uid' => $user['uid'],
                ':userName' => $user['username'],
                ':gameType' => 'ADMINACCOUNT',
                ':transferType' => 'IN',
                ':transferOrder' => $packets_id,
                ':transferAmount' => $money,
                ':previousAmount' => $user['money'],
                ':currentAmount' => $user['money']+$money,
                ':creationTime' => date('Y-m-d H:i:s', $packets['now']),
            ));
            $stmt = $mydata1_db->prepare('INSERT INTO `k_money` (`uid`, `m_value`, `m_order`, `status`, `m_make_time`, `about`, `type`, `assets`, `balance`) VALUES (:uid, :m_value, :m_order, 1, :m_make_time, :about, :type, :assets, :balance)');
            $stmt->execute(array(
                ':uid' => $user['uid'],
                ':m_value' => $money,
                ':m_order' => $packets_id,
                ':m_make_time' => date('Y-m-d H:i:s', $packets['now']),
                ':about' => '红包派送[系统结算]',
                ':type' => 4,
                ':assets' => $user['money'],
                ':balance' => $user['money']+$money,
            ));
        }
    }
    return $return;
}

echo json_encode($output);