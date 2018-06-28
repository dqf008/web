<?php 
$_DIR = dirname(dirname(dirname(__FILE__)));
$_DIR = str_replace('\\', '/', $_DIR);
substr($_DIR, -1)!='/'&&$_DIR.='/';
session_start();
include_once $_DIR.'include/config.php';
include_once $_DIR.'database/mysql.config.php';
include_once $_DIR.'class/user.php';
include_once $_DIR.'class/money.php';

//public,private,protected,static

class sign{
    public $sign = array();

    public function __construct(){
        global $mydata1_db;
        /* 签到时间按照 美国东部时间 (UTC -04:00) 进行计算 */
        /* 请注意与客户端、服务器的时间差 */
        $this->sign['time'] = mktime(gmdate('H')-4, gmdate('i'), gmdate('s'), gmdate('m'), gmdate('d'), gmdate('Y'));
        $this->sign['date'] = strtotime(date('Y-m-d 00:00:00', $this->sign['time']));
        $this->sign['user'] = array();
        $this->sign['temp'] = array();
        $this->sign['config'] = array('open' => 0);
        $this->sign['next'] = array('money' => 0, 'day' => 0, 'time' => $this->sign['date']+86400);
        $this->sign['tempId'] = $this->sign['date'];
        $sql = 'SELECT * FROM `k_user_sign` WHERE `uid`=0';
        $query = $mydata1_db->query($sql);
        if($query->rowCount()>0){
            $rows = $query->fetch();
            $this->sign['config'] = unserialize($rows['sign']);
            if(isset($_SESSION['gid'])&&isset($this->sign['config']['groups'])){
                $_gconfig = $this->sign['config']['groups'];
                $_gid = $_SESSION['gid'];
                if(!empty($_gconfig)&&isset($_gconfig[$_gid])){
                    if(isset($_gconfig[$_gid]['default'])&&$_gconfig[$_gid]['default']==0){
                        isset($_gconfig[$_gid]['member'])&&!empty($_gconfig[$_gid]['member'])&&$this->sign['config']['member'] = $_gconfig[$_gid]['member'];
                        isset($_gconfig[$_gid]['type0'])&&!empty($_gconfig[$_gid]['type0'])&&$this->sign['config']['type0'] = $_gconfig[$_gid]['type0'];
                        isset($_gconfig[$_gid]['type1'])&&!empty($_gconfig[$_gid]['type1'])&&$this->sign['config']['type1'] = $_gconfig[$_gid]['type1'];
                    }
                }
            }
            $this->sign['temp'] = unserialize($rows['temp']);
        }
    }

    public function __destruct(){}

    public function userSign($uid, $money, $username, $regTime){
        $uid = intval($uid);
        $lastMoney = 0;
        $_return = array();
        if($this->checkSign($uid, $regTime)&&$this->sign['user']['access']){
            $this->sign['user']['day']+= 1;
            $_time = $this->sign['tempId'];
            $_message = '签到成功';
            if($this->sign['config']['type']!=1){
                $this->sign['user']['count'] = 0;
                $_return = $this->getRand($this->sign['config']['type0']);
                $lastMoney = $_return[0];
                !empty($_return[1])&&$_message = $_return[1];
                if($this->sign['config']['limit'][1]>0){
                    $lastMoney = $this->sign['temp'][$_time]['money']-$lastMoney>=0?$lastMoney:$this->sign['temp'][$_time]['money'];
                }
            }else{
                $this->sign['user']['count'] = ($this->sign['user']['time']+86400>=$this->sign['date']?$this->sign['user']['count']:0)+1;
                $_lastDay = 0;
                foreach($this->sign['config']['type1'] as $val){
                    if($val['day']<=$this->sign['user']['count']&&$_lastDay<=$val['day']){
                        $lastMoney = $val['money'];
                        $_lastDay = $val['day'];
                    }
                    if($val['day']<=$this->sign['user']['count']+1&&$this->sign['next']['day']<=$val['day']){
                        $this->sign['next']['money'] = $val['money'];
                        $this->sign['next']['day'] = $val['day'];
                    }
                }
            }
            $this->sign['user']['time'] = $this->sign['date'];
            $this->sign['user']['money']+= $lastMoney;
            $_money = floatval($money);
            $_order = 'SIGN'.substr('000000000'.$uid, -10).date('YmdHis', $this->sign['time']);
            $_amount = floatval($lastMoney/100);
            $_sign = false;
            $msg_info = $username.'，您好！<br />';
            $msg_info.= '您在 '.date('Y-m-d H:i:s', $this->sign['time']).'(美东时间) 成功签到，';
            if($lastMoney>0){
                if(money::chongzhi($uid, $_order, $_amount, $_money, 1, '签到赠送[系统结算]', '4')){
                    $msg_info.= '并获得 '.sprintf('%.2f', $_amount).' 彩金奖励！<br />';
                    $msg_info.= '您账户当前余额为 '.sprintf('%.2f', $_money+$_amount).'，';
                    $msg_info.= '您账户之前余额为 '.sprintf('%.2f', $_money).'。<br />';
                    $msg_info.= $this->sign['next']['money']>0?'您已签到 '.$this->sign['user']['count'].' 天，下次签到将获得 '.sprintf('%.2f', $this->sign['next']['money']/100).' 彩金奖励。<br />':'';
                    $msg_info.= '敬请留意您的账户余额，祝您游戏愉快！';
                    $_return['status'] = 'success';
                    $_sign = true;
                }else{
                    $_return['status'] = 'error';
                    $_return['message'] = '发生未知错误';
                }
            }else{
                $msg_info.= '但是没有获得彩金奖励！<br />';
                $msg_info.= '您账户当前余额为 '.sprintf('%.2f', $_money).'。<br />';
                $msg_info.= $this->sign['next']['money']>0?'您已签到 '.$this->sign['user']['count'].' 天，下次签到将获得 '.sprintf('%.2f', $this->sign['next']['money']/100).' 彩金奖励。<br />':'';
                $msg_info.= '祝您游戏愉快！';
                $_return['status'] = 'success';
                $_sign = true;
            }
            if($_sign){
                user::msg_add($uid, '[SYSTEM]签到', date('Y-m-d H:i:s', $this->sign['time']).'(美东时间) 签到成功！', $msg_info);
                if(isset($this->sign['temp'][$_time])){
                    $this->sign['config']['limit'][0]>0&&$this->sign['temp'][$_time]['count']-=1;
                    $this->sign['config']['limit'][1]>0&&$this->sign['temp'][$_time]['money']-=$lastMoney;
                }
                $this->updateSign($uid);
            }
        }else if($this->sign['config']['open']!=1){
            $_return['status'] = 'error';
            $_return['message'] = '未启用签到功能';
        }else if(!$this->sign['user']['access']){
            $_return['status'] = 'error';
            $limit = sprintf('%d', $this->sign['config']['member']['limit']/100);
            $_return['message'] = '您还未获得签到特权<br>当日充值'.$limit.'元（含）以上<br>即可获得签到特权哦^o^';
        }else if($this->sign['user']['time']>=$this->sign['date']){
            $_return['status'] = 'notice';
            $_return['message'] = '今天已经完成签到';
        }else{
            $_return['status'] = 'notice';
            $_return['message'] = '本次时段超过限制，请换个时间重试<br />'.date('Y-m-d H:i:s', $this->sign['next']['time']).'(美东时间)';
        }
        if($_return['status']=='success'){
            $_return['message'] = $_message;
            $_return['data'] = array(sprintf('%.2f', $lastMoney/100), $this->sign['user']['day'], sprintf('%.2f', $this->sign['user']['money']/100), $this->sign['user']['count'], sprintf('%.2f', $this->sign['next']['money']/100));
        }
        return $_return;
    }

    public function checkSign($uid, $regTime=0){
        global $mydata1_db;
        $uid = intval($uid);
        $_return = $this->sign['config']['open']==1;
        if($_return&&$uid>0){
            $sql = 'SELECT * FROM `k_user_sign` WHERE `uid`='.$uid;
            $query = $mydata1_db->query($sql);
            if($query->rowCount()>0){
                $rows = $query->fetch();
                $this->sign['user'] = unserialize($rows['sign']);
                $query->rowCount()>1&&$mydata1_db->query('DELETE FROM `k_user_sign` WHERE `uid`='.$rows['uid'].' AND `id`!='.$rows['id']);
            }
            if(empty($this->sign['user'])){
                $this->sign['user'] = array('time' => 0, 'money' => 0, 'count' => 0, 'day' => 0, 'access' => 0);
                $mydata1_db->query('INSERT INTO `k_user_sign` (`uid`, `sign`) VALUES ('.$uid.', \''.serialize($this->sign['user']).'\')');
            }
            $this->sign['user']['access'] = $this->getUserAccess($uid, $regTime)?1:0;
        }
        if($_return){
            //判断今日是否已签到
            $_return = $this->sign['user']['time']<$this->sign['date']?true:false;
            if($_return&&$this->sign['config']['type']!=1){
                $_time = $this->sign['tempId'];
                //判断时段
                if(!empty($this->sign['config']['limit'][2])){
                    $_return = false;
                    $_minTime = array(array(), array());
                    foreach($this->sign['config']['limit'][2] as $val){
                        $val = $this->getLimitTime($val);
                        if($this->sign['time']>=$val[0]&&$this->sign['time']<=$val[1]){
                            $_time = implode(', ', $val);
                            $this->sign['tempId'] = $_time;
                            $_return = true;
                            //break;
                        }
                        //获取最小开始时间
                        $_minTime[0][] = $val[0]+86400;
                        //返回下个时段
                        $this->sign['time']<$val[0]&&$_minTime[1][] = $val[0];
                    }
                    //当天时段结束则返回隔天第一个时段
                    $this->sign['next']['time'] = min(!empty($_minTime[1])?$_minTime[1]:(!empty($_minTime[0])?$_minTime[0]:array($this->sign['date']+86400)));
                }
                if($_return&&(!is_array($this->sign['temp'])||!isset($this->sign['temp'][$_time]))){
                    $this->sign['temp'] = array();
                    $this->sign['temp'][$_time] = array();
                    $this->sign['temp'][$_time]['count'] = $this->sign['config']['limit'][0];
                    $this->sign['temp'][$_time]['money'] = $this->sign['config']['limit'][1];
                    $mydata1_db->query('UPDATE `k_user_sign` SET `temp`=\''.serialize($this->sign['temp']).'\' WHERE `id`=1 AND `uid`=0');
                }else{
                    //判断名额
                    ($_return&&$this->sign['config']['limit'][0]>0)&&$_return = $this->sign['temp'][$_time]['count']>0;
                    //判断彩金
                    ($_return&&$this->sign['config']['limit'][1]>0)&&$_return = $this->sign['temp'][$_time]['money']>0;
                }
            }
        }
        return $_return;
    }

    private function updateSign($uid){
        global $mydata1_db;
        $mydata1_db->query('UPDATE `k_user_sign` SET `temp`=\''.serialize($this->sign['temp']).'\' WHERE `id`=1 AND `uid`=0');
        $mydata1_db->query('UPDATE `k_user_sign` SET `sign`=\''.serialize($this->sign['user']).'\' WHERE `uid`='.$uid);
    }

    private function getUserAccess($uid, $regTime=0){
        global $mydata1_db;
        $_return = true;
        if($this->sign['config']['member']['open']){
            $_return = $regTime>0&&$this->sign['config']['member']['reg']>0&&$this->sign['config']['member']['reg']>=ceil(($this->sign['time']-$regTime)/86400);
            if(!$_return){
                $sql = 'SELECT SUM(`money`) AS `money` FROM (';
                $sql.= '(SELECT SUM(`m_value`) AS `money` FROM `k_money` WHERE `uid`='.$uid.' AND `status`=1 AND `type` IN (1, 3) AND `m_make_time`>=\''.date('Y-m-d 00:00:00', $this->sign['date']).'\' AND `m_make_time`<=\''.date('Y-m-d 23:59:59', $this->sign['date']).'\') UNION ALL ';
                $sql.= '(SELECT SUM(`money`) AS `money` FROM `huikuan` WHERE `uid`='.$uid.' AND `status`=1 AND `adddate`>=\''.date('Y-m-d 00:00:00', $this->sign['date']).'\' AND `adddate`<=\''.date('Y-m-d 23:59:59', $this->sign['date']).'\')';
                $sql.= ') `m`';
                $query = $mydata1_db->query($sql);
                $rows = $query->fetch();
                if($this->sign['config']['member']['limit']<=$rows['money']*100){
                    $_return = true;
                }
            }
        }
        return $_return;
    }

    private function getLimitTime($_array){
        $_return = array(0, 0);
        if(is_array($_array)){
            if(isset($_array[1])){
                $_tmp1 = explode(':', $_array[0]);
                $_tmp2 = explode(':', $_array[1]);
                if(isset($_tmp1[1])&&isset($_tmp2[1])){
                    $_return[0] = mktime(intval($_tmp1[0]), intval($_tmp1[1]), 0, gmdate('m'), gmdate('d'), gmdate('Y'));
                    $_return[1] = mktime(intval($_tmp2[0]), intval($_tmp2[1]), 0, gmdate('m'), gmdate('d'), gmdate('Y'));
                }
            }
        }
        return $_return;
    }

    private function getRand($_array){
        $_rand = intval($_array['random']);
        $_rand = $_rand>0?mt_rand(1, $_rand):1;
        $_random = array('min'=>0, 'max'=>0, 'tips'=>'');
        //确定区间
        shuffle($_array); //随机排列区间
        foreach($_array as $key=>$val){
            if(is_array($val)){
                if($_rand<=$val['random']){
                    $_random = $val;
                    break;
                }
                $_rand-= $val['random'];
            }
        }
        (!isset($_random['tips'])||empty($_random['tips']))&&$_random['tips'] = '签到成功';
        if($_random['min']>=$_random['max']){
            return array($_random['min'], $_random['tips']);
        }else{
            return array(mt_rand($_random['min'], $_random['max']), $_random['tips']);
        }
    }
}


//var_dump(getConfig());exit;
//echo mktime(25, 62, 0);exit;

$signType = 'default';
$uid = isset($_SESSION['uid'])?intval($_SESSION['uid']):0;
if($uid>0){
    //验证是否登陆
    $sql = 'SELECT `uid`, `money`, `username`, `reg_date`, `mobile`, `pay_card`, `pay_num`, `pay_address`, `pay_name` FROM `k_user` WHERE `uid`='.$uid.' LIMIT 1';
    $query = $mydata1_db->query($sql);
    if($query->rowCount()>0){
        $userinfo = $query->fetch();
        $userinfo['reg_date'] = strtotime($userinfo['reg_date']);
        $userinfo['reg_date'] = date('Y-m-d', $userinfo['reg_date']);
        $userinfo['reg_date'] = strtotime($userinfo['reg_date']);
        $signType = isset($_GET['type'])?$_GET['type']:'default';
    }
}

$callback = isset($_GET['callback'])?$_GET['callback']:'callback';
$sign = new sign();
$_return = array(); //success

switch($signType){
    case 'check':
        $_return['status'] = 'error';
        if($sign->checkSign($uid, $userinfo['reg_date'])){
            $_return['status'] = 'success';
            $_return['message'] = 'SUCCESS';
        }else if($sign->sign['config']['open']!=1){
            $_return['message'] = 'SIGN_NOT_OPEN';
        }else if($sign->sign['user']['time']>=$sign->sign['date']){
            $_return['message'] = 'IS_SIGN_'.($sign->sign['next']['time']-$sign->sign['time']);
        }else{
            $_return['message'] = 'NEXT_TIME_'.($sign->sign['next']['time']-$sign->sign['time']);
        }
    break;
    case 'sign':
        if(
            $sign->sign['config']['allow']['mobile']!=1 && (
            !isset($userinfo['mobile']) || empty($userinfo['mobile'])
        )){
            $_return['status'] = 'error';
            $_return['message'] = '您还没有设置手机号码';
        }else if(
            $sign->sign['config']['allow']['bank']!=1 && (
            !isset($userinfo['pay_card']) || empty($userinfo['pay_card']) ||
            !isset($userinfo['pay_num']) || empty($userinfo['pay_num']) ||
            !isset($userinfo['pay_address']) || empty($userinfo['pay_address']) ||
            !isset($userinfo['pay_name']) || empty($userinfo['pay_name'])
        )){
            $_return['status'] = 'error';
            $_return['message'] = '您还没有设置银行资料';
        }else{
            $_return = $sign->userSign($uid, $userinfo['money'], $userinfo['username'], $userinfo['reg_date']);
        }
    break;
    default:
        $_return['status'] = 'error';
        $_return['message'] = '登录后即可使用签到功能';
    break;
}
if(!empty($_return)){
    echo $callback.'(';
    echo json_encode($_return);
    echo ');';
}
//echo '/*'.date('Y-m-d H:i:s', $sign->sign['time']).'*/';