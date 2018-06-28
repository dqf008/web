<?php
session_start();
$_DIR = dirname(dirname(__FILE__));
$_DIR = str_replace('\\', '/', $_DIR);
substr($_DIR, -1) != '/' && $_DIR .= '/';
define('IN_LOT', $_DIR);
$LOT                  = [];
$LOT['game_category'] = [
    'pk10'    => '赛车',
    'cqssc'   => '时时彩',
    'k3'      => '全国快3',
    'pcdd'    => 'PC蛋蛋',
    'jslh'    => '六合彩',
    'xyft'    => '幸运飞艇',
    'gdkl10'  => '快乐10分',
    'choose5' => '11选5',
    'shssl'   => '其他',
];
$LOT['game']          = [
    'pk10'      => '北京赛车PK拾',
    'jssc'      => '极速赛车',
    'cqssc'     => '重庆时时彩',
    'tjssc'     => '天津时时彩',
    'xjssc'     => '新疆时时彩',
    'sfssc'     => '新疆时时彩',
    'jsssc'     => '极速时时彩',
    'xyft'      => '幸运飞艇',
    'jsft'      => '极速飞艇',
    'kl10'      => '快乐10分',
    'gdkl10'    => '广东快乐10分',
    'tjkl10'    => '天津快乐10分',
    'xjkl10'    => '新疆快乐10分',
    'sfkl10'    => '三分快乐10分',
    'ffkl10'    => '分分快乐10分',
    'hnkl10'    => '湖南快乐10分',
    'sxkl10'    => '山西快乐10分',
    'ynkl10'    => '云南快乐10分',
    'cqkl10'    => '重庆快乐10分',
    'shssl'     => '上海时时乐',
    'pl3'       => '排列三',
    '3d'        => '福彩3D',
    'kl8'       => '北京快乐8',
    'qxc'       => '七星彩',
    'wfqxc'     => '五分七星彩',
    'ffqxc'     => '分分七星彩',
    'jslh'      => '极速六合',
    'marksix'   => '六合彩',
    'k3'        => '快3',
    'jsk3'        => '江苏快3',
    'fjk3'        => '福建快3',
    'ahk3'        => '安徽快3',
    'bjk3'        => '北京快3',
    'jlk3'        => '吉林快3',
    'jxk3'        => '江西快3',
    'hbk3'        => '湖北快3',
    'hebk3'        => '河北快3',
    'hnk3'        => '河南快3',
    'gsk3'        => '甘肃快3',
    'gzk3'        => '贵州快3',
    'nmgk3'        => '内蒙古快3',
    'shk3'        => '上海快3',
    'gxk3'        => '广西快3',
    'ffk3'        => '分分快3',
    'sfk3'        => '超级快3',
    'wfk3'        => '好运快3',
    'pcdd'      => 'PC蛋蛋',
    'ffpcdd'    => '分分PC蛋蛋',
    'choose5'   => '11选5',
    'gdchoose5' => '广东11选5',
    'sdchoose5' => '山东11选5',
    'fjchoose5' => '福建11选5',
    'bjchoose5' => '北京11选5',
    'ahchoose5' => '安徽11选5',
    'sfchoose5' => '三分11选5',
    'yfchoose5' => '一分11选5',
];
$LOT['new']           = [];
$LOT['hot']           = []; //hot优先级比new高
$LOT['user']          = ['login' => false];
$LOT['skin']          = 'tan';
$LOT['mdtime']        = time();
$LOT['bjtime']        = $LOT['mdtime']+43200;

include(IN_LOT . '../include/config.php');
website_close();
website_deny();
include(IN_LOT . '../database/mysql.config.php');
$LOT['more'] = $web_site['lot_more'] !== 1;
/* 加载用户信息 */
if (isset($_SESSION['uid']) && isset($_SESSION['username']) && isset($_SESSION['password'])) {
    $params = [':uid' => $_SESSION['uid']];
    $stmt   = $mydata1_db->prepare('SELECT `username`, `password`, `money`, `uid`, `gid`, `agents` FROM `k_user` WHERE `uid`=:uid AND `is_stop`=0 AND `is_delete`=0 LIMIT 1');
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        $rows                    = $stmt->fetch(PDO::FETCH_ASSOC);
        $LOT['user']['login']    = true;
        $LOT['user']['uid']      = $rows['uid'];
        $LOT['user']['username'] = $rows['username'];
        $LOT['user']['agents']   = $rows['agents'];
        $LOT['user']['money']    = $rows['money'];
        $LOT['user']['gid']      = $rows['gid'];
    }
    if ($LOT['user']) {
        $res  = $mydata1_db->query('select * from k_user_login where is_login=0 and uid=' . $_SESSION['uid']);
        $data = $res->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            unset($_SESSION['uid']);
            unset($_SESSION['is_daili']);
            unset($_SESSION['gid']);
            unset($_SESSION['username']);
            unset($_SESSION['denlu']);
            unset($_SESSION['user_login_id']);
            unset($_SESSION['password']);
            session_destroy();
            $LOT['user'] = ['login' => false];
        }
    }
}

function show_id($id1 = 0, $id2 = 0)
{
    return $id1 . substr('00' . $id2, -2);
}

function result($msg, $code = 0, $errId = 0)
{
    $GLOBALS['LOT']                     = [];
    $GLOBALS['LOT']['output']['result'] = $code;
    $GLOBALS['LOT']['output']['msg']    = $msg;
    $GLOBALS['LOT']['output']['errId']  = $errId;
}

function check_order()
{
    global $LOT;
    if ($LOT['input']['lotteryId'] == 'marksix') {
        check_marksix();
    }
    $return = $LOT['user']['login'] && isset($LOT['input']['betParameters']) && !empty($LOT['input']['betParameters']);
    if ($return) {
        $return = is_array($LOT['input']['betParameters']);
        if ($return) {
            $group_file = IN_LOT . '../cache/group_' . $LOT['user']['gid'] . '.php';
            $bet_min    = 10;
            $bet_max    = 1000000;
            $bet_money  = 0;
            $pk_db      = [];
            file_exists($group_file) && include($group_file);
            if (isset($pk_db['彩票最低']) && $pk_db['彩票最高']) {
                $bet_min = $pk_db['彩票最低'];
                $bet_max = $pk_db['彩票最高'];
            }
            foreach ($LOT['input']['betParameters'] as $val) {
                $return = $return && is_array($val);
                if ($return) {
                    $return = isset($val['Id']) && preg_match('/^\d+$/', $val['Id']);
                    $return = $return && isset($val['BetContext']);
                    $return = $return && isset($val['Lines']) && !empty($val['Lines']);
                    if ($return && isset($val['Money']) && preg_match('/^[0-9\.]+$/', $val['Money'])) {
                        $val['Money'] = abs($val['Money']);
                        $bet_money    += $val['Money'];
                        $return       = $val['Money'] > 0;
                        $return       = $return && $val['Money'] >= $bet_min;
                        $return       = $return && $val['Money'] <= $bet_max;
                        !$return && result('允许投注范围：' . sprintf('%.2f', $bet_min) . ' ~ ' . sprintf('%.2f', $bet_max));
                    }
                } else {
                    empty($GLOBALS['LOT']['output']) && result('投注内容存在错误，请刷新页面重试');
                    break;
                }
            }
            if ($return && $bet_money <= 0 && $bet_money > $LOT['user']['money']) {
                $return = false;
                result('投注金额超过余额');
            }
        }
    }

    return $return;
}
function getK3BetQiHao()
{
    global $mydata1_db;
    global $LOT;
    $return = true;
    $lotteryType = $LOT['lottery_type'];
    $bjTime   = $LOT['bjtime'];
    $lotteryCount = ['jsk3' => 82, 'ahk3' => 80, 'fjk3' => 78, 'gxk3' => 78, 'shk3' => 80, 'hbk3' => 78, 'hebk3' => 81, 'nmgk3' => 73, 'bjk3' => 89, 'gsk3' => 72, 'gzk3' => 78, 'hnk3' => 84, 'jlk3' => 82, 'jxk3' => 84, 'qhk3' => 78];
    $sql          = "SELECT `qihao`, `kaipan`, `fengpan` FROM `lottery_k3` WHERE `name`='$lotteryType' ORDER BY `fengpan` DESC LIMIT 1";
    $stmt         = $mydata1_db->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $rows = $stmt->fetch();
        if ($lotteryType == 'bjk3') {
            $previousQihao = $rows['qihao'];
        } else {
            $previousQihao = substr($rows['qihao'], -2);
        }
        $fengpanDay = date('Y-m-d', strtotime($rows['fengpan']));
        $now        = date('Y-m-d', $bjTime);
        if ($lotteryType == 'bjk3') {
            $bjDay       = $fengpanDay . ' 00:00:00';
            $bjCondition = [':kaipan' => $bjDay];
            $bjfirstSql  = "SELECT `qihao` FROM `lottery_k3` where `name`='$lotteryType' AND kaipan >=:kaipan ORDER BY `qihao` ASC limit 1";
            $bjStmt      = $mydata1_db->prepare($bjfirstSql);
            $bjStmt->execute($bjCondition);
            if ($bjStmt->rowCount() > 0) {
                $bjfirstInfo = $bjStmt->fetch();
                if ($previousQihao - $bjfirstInfo['qihao'] < $lotteryCount[$lotteryType]) {
                    if ($bjTime < strtotime($rows['fengpan']) + 9 * 60) {
                        $betQihao = $previousQihao + 1;
                        $LOT['bet_qishu']=$betQihao;
                    } else {
                        $return = false;
                        result('已经封盘，禁止下注');
                    }
                } else {
                    $return = false;
                    result('已经封盘，禁止下注');
                }
            } else {
                $return = false;
                result('已经封盘，禁止下注');
            }
        } else {
            if ($previousQihao == $lotteryCount[$lotteryType]) {
                if ($now == $fengpanDay) {
                    $sql   = "SELECT `qihao` FROM `lottery_k3` where `name`='$lotteryType' ORDER BY `fengpan` DESC LIMIT 1";
                    $query = $mydata1_db->query($sql);
                    if ($query->rowCount() > 0) {
                        $rows                                  = $query->fetch();
                        $LOT['output']['Obj']['CurrentPeriod'] = $rows['qihao'];
                    } else {
                        result('已经封盘,禁止下注');
                    }
                } else {
                    $timePar  = [':qihao' => 1, ':name' => $lotteryType];
                    $timeSql  = 'select fengpan,kaipan from c_opentime_k3 where name=:name and qihao=:qihao limit 1';
                    $timeStmt = $mydata1_db->prepare($timeSql);
                    $timeStmt->execute($timePar);
                    if ($timeStmt->rowCount() > 0) {
                        $timeInfo                              = $timeStmt->fetch();
                        if($LOT['bjtime'] > strtotime($now.' '.$timeInfo['kaipan']) && ($LOT['bjtime'] < strtotime($now.' '.$timeInfo['fengpan']))){
                            $qihao                                 = getQiHao($lotteryType, 1, $LOT['bjtime']);
                            $LOT['bet_qishu']  = $qihao;
                        }else{
                          $return =false;
                            result('尚未开盘,禁止下注');
                        }
                    } else {
                        $return = false;
                        result('已经封盘，禁止下注');
                    }
                }
            } else {
                if ($bjTime < strtotime($rows['fengpan']) + 9 * 60) {
                    $betQihao = getQiHao($lotteryType, $previousQihao + 1, $bjTime);
                    $LOT['bet_qishu'] = $betQihao;
                } else {
                    $return = false;
                    result('已停止下注');
                }
            }
        }
    } else {
        $return = false;
        result('已经封盘，禁止下注');

    }
    return $return;
}
function check_odds($id1, $id2, $min = 0, $max = 0)
{
    global $LOT;
    $return = isset($LOT['odds'][$id1]) && isset($LOT['odds'][$id1][1][$id2]);
    $return && $min > 0 && $return = $id1 >= $min;
    $return && $max > 0 && $return = $id1 <= $max;

    return $return;
}

function getKjTime($kjinfo,$lotteryName,$total,$time,$firstOpenTime,$jgTime =600,$tqTime=60){
    if ($kjinfo['left_lime'] < 0 && $jgTime - abs($kjinfo['left_time']) < 0) {
        return false;
    }
    $count =1;
    if ($lotteryName=='ffk3' || $lotteryName == 'js1k3' || $lotteryName == 'f5k3') {
        $_d = substr($kjinfo['qihao'], 8, strlen($kjinfo['qihao']));
        $len = strlen(substr($kjinfo['qihao'], 8, strlen($kjinfo['qihao'])));
    } else {
        $len = 3;
    }
    if (intval($total) == intval(substr($kjinfo['qihao'], -$len))) {
        $day = substr($kjinfo['qihao'], 0, -$len);
        $nextdaydraw = strtotime($day . ' ' . $firstOpenTime) + 86400;
        $lefttime = strtotime($nextdaydraw)-$tqTime - $time;
        $str = 1;
        $qihao = date('Ymd', $nextdaydraw) . '' . str_pad($str, $len, "0", STR_PAD_LEFT) . '1';
    } else {
        if($lotteryName=='bjk3'){
            $qihao = $kjinfo['next_qihao']+$count;
        }else {
            $ext = substr($kjinfo['next_qihao'], -$len);

            if ($ext + 1 <= intval($total)) {
                $ext   = $ext + $count;
                $qihao = date('Ymd', $kjinfo['next_draw']) . '' . str_pad($ext, $len, "0", STR_PAD_LEFT);
            } else {
                $day         = substr($kjinfo['qihao'], 0, -$len);
                $nextdaydraw = strtotime($day . ' ' . $firstOpenTime) + $jgTime + 86400;
                $qihao       = date('Ymd', $nextdaydraw) . '' . str_pad('1', $len, "0", STR_PAD_LEFT);

            }
        }
        $kjjiange = $kjinfo['next_draw'] - $kjinfo['next_start_sale'];
        $lefttime = ($kjinfo['next_draw'] + $kjjiange)-$tqTime - $time;
        if ($lotteryName=='ffk3' || $lotteryName == 'js1k3' || $lotteryName == 'f5k3') {
            $qihao = $kjinfo['qihao'] + 2;
            $startsale = date('Y-m-d H:i:s', $kjinfo['next_start_sale']);
            $endsale = date('Y-m-d H:i:s', $kjinfo['nextendsale']);
            $t0 = strtotime($endsale);
            $d0 = strtotime(date('Y-m-d', strtotime($endsale)) . ' 23:52:00');
            $d1 = strtotime(date('Y-m-d', strtotime($endsale)) . ' 23:45:00');
            if (($t0 <= $d0 and $t0 > $d1) || substr($endsale, -8) == "23:50:00") {
                $nextendsale = date('Y-m-d 09:09:00', $kjinfo['start_sale'] + 86400);
                $lefttime = $nextendsale- $tqTime - $time;
            }
        }
    }
    $array = array('qihao' => $qihao, 'left_time' => $lefttime);
    return $array;
}
function update_money($uid, $money)
{
    global $mydata1_db;
    $return = -1;
    $params = [':uid' => $uid];
    $sql    = 'SELECT `money` FROM `k_user` WHERE `uid`=:uid LIMIT 1';
    $stmt   = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch();
        if ($user['money'] - $money >= 0) {
            $params[':money'] = $money;
            $sql              = 'UPDATE `k_user` SET `money`=`money`-:money WHERE `uid`=:uid';
            $stmt             = $mydata1_db->prepare($sql);
            $stmt->execute($params) && $return = $user['money'];
        }
    }

    return $return;
}

function check_marksix()
{
    global $LOT, $mydata1_db, $mydata2_db;
    $kithe = $LOT['marksix']['nn'];
    $sql   = 'select sum(sum_m) as sum from ka_tan where kithe=' . $kithe . ' limit 1';
    $res   = $mydata2_db->query($sql)->fetch(PDO::FETCH_ASSOC);
    $sum   = (int)$res['sum'];

    $sql = 'select content from webinfo where code="marksix-sum" limit 1';
    $res = $mydata1_db->query($sql)->fetch(PDO::FETCH_ASSOC);
    $max = (int)$res['content'];
    if ($max > 0 && $sum > $max) {
        result('本期投注金额已达上限');
    }

}

function isMobile(){
    if (isset($_SERVER['HTTP_X_WAP_PROFILE']))	{
        return true;
    }
    if (isset($_SERVER['HTTP_VIA']))
    {
        return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
    }
    if (isset($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile');
        if (preg_match('/(' . implode('|', $clientkeywords) . ')/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        }
    }
    if (isset($_SERVER['HTTP_ACCEPT']))
    {
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && ((strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false) || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        }
    }
    return false;
}