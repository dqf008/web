<?php
//@file_put_contents('data.txt', json_encode($_REQUEST));//$_REQUEST
$_DIR = dirname(__FILE__).'/';
include($_DIR.'../include/config.php');
include($_DIR.'../database/mysql.config.php');
include($_DIR.'../cj/include/config.php');
include($_DIR.'../cj/class/cj.php');
include($_DIR.'../class/user.php');
include($_DIR.'./config.php');
include($_DIR.'./include/functions.php');

$return = array();
$disabled = array();

if(isset($_SERVER['REQUEST_METHOD'])&&strtolower($_SERVER['REQUEST_METHOD'])=='post'){
    if(isset($_POST['custom'])&&!empty($_POST['custom'])&&isset($_POST['token'])&&!empty($_POST['token'])&&isset($_POST['cagent'])&&!empty($_POST['cagent'])){
        $gameType = explode('_', $_POST['cagent']);
        $gameType = count($gameType)>1?$gameType[1]:'';
        if(in_array($gameType, array('AGIN', 'NMGE', 'PT'))){
            file_exists($_DIR.'../cache/egame.php')&&$disabled = include($_DIR.'../cache/egame.php');
            $temp1 = array();
            foreach($disabled as $key=>$val){
                $temp1[] = strtolower($key);
            }
            if(in_array(strtolower($_POST['gametype']), $temp1)){
                $userinfo = array();
                $return['disabled'] = true;
            }else{
                $userinfo = unserialize(dz_authcode($_POST['custom'], 'DECODE', $_egame['token']));
            }
            if(is_array($userinfo)&&isset($userinfo['uid'])){
                $query = $mydata1_db->query('SELECT `login_time`, `uid`, `username`, `ispt`, `ptAddtime`, `ptUserName`, `ptPassWord`, `ismg`, `mgAddtime`, `mgUserName`, `mgPassWord`, `isag`, `agAddtime`, `agUserName`, `agPassWord` FROM `k_user` WHERE `uid`='.$userinfo['uid']);
                if($query->rowCount()>0){
                    $rows = $query->fetch();
                    $session_token = array(md5($_egame['token'].$rows['login_time'].$rows['username']));
                    if(is_array($session_token)&&isset($session_token[0])&&$session_token[0]==$_POST['token']){
                        $return['token'] = $session_token[0];
                        $return['username'] = $rows['username'];
                        $isreg = '';
                        $loginname = '';
                        $password = '';
                        $addtime = '';
                        $type = '';
                        switch($gameType){
                            case 'AGIN':
                                $isreg = 'isag';
                                $loginname = 'agUserName';
                                $password = 'agPassWord';
                                $addtime = 'agAddtime';
                                $type = 'AGIN';
                                break;
                            case 'NMGE':
                                $isreg = 'ismg';
                                $loginname = 'mgUserName';
                                $password = 'mgPassWord';
                                $addtime = 'mgAddtime';
                                $type = 'MG';
                                break;
                            case 'PT':
                                $isreg = 'ispt';
                                $loginname = 'ptUserName';
                                $password = 'ptPassWord';
                                $addtime = 'ptAddtime';
                                $type = 'PT';
                                break;
                        }
                        if($rows[$isreg]==1){
                            $return['loginname'] = $rows[$loginname];
                            $return['password'] = $rows[$password];
                        }else{
                            $client = new rpcclient($cj_url);
                            $arr = $client->livereg($site_id, $rows['username'], $type);
                            if(is_array($arr)&&!empty($arr)){
                                if($arr['info']=='ok'){
                                    $sql = 'UPDATE `mydata1_db`.`k_user` SET `'.$loginname.'`=:loginname, `'.$password.'`=:password, `'.$addtime.'`=now(), `'.$isreg.'`=1 WHERE `uid`=:uid';
                                    $mydata1_db->prepare($sql)->execute(array(
                                        ':loginname' => $arr['msg'][0],
                                        ':password' => $arr['msg'][1],
                                        ':uid' => $rows['uid'],
                                    ));
                                    $return['loginname'] = $arr['msg'][0];
                                    $return['password'] = $arr['msg'][1];
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

echo dz_authcode(serialize($return), 'ENCODE', $_egame['token']);