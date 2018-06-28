<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
$C_Patch = $_SERVER['DOCUMENT_ROOT'];
include_once $C_Patch . '/cj/include/function.php';
include_once $C_Patch . '/cj/class/cj.php';
include_once $C_Patch . "/class/user.php";
$client = new rpcclient($cj_url);

function giro($uid, $typeLive, $typeGiro, $zz_money, $all = false)
{
    if(! check_game($typeLive)) return '维护中';
    if($typeGiro == 'IN' && $typeLive == 'OG'){
        return '为了您更好的体验，请到新OG东方厅进行游戏';
    }
	if($typeGiro == 'IN' && $typeLive == 'PT'){
        return '为了您更好的体验，请到新PT进行游戏';
    }
	if($typeLive == 'IPM'){
		return 'error';
	}
    $t = check($uid, $typeLive);
    if($t !== 0) return '操作过于频繁,请'.$t.'秒稍后再试';
    global $mydata1_db;
    global $site_id;
    global $cj_url;
    global $client;

    $userinfo = user::getinfo($uid);
    $str = typeName($typeLive);

    $typeName = $str['title'];//真人平台名称
    $istype = $str['istype'];//数据库字段名--是否注册
    $zzusername = $str['zzusername'];//数据库字段名--平台帐号
    $zzpassword = $str['zzpassword'];//数据库字段名--平台密码
    $zzmoney = $str['zzmoney'];
    $zztime = $str['zztime'];
    $giroName = '转入';
    $jiajian = '扣款';
    $transferAmount = -$zz_money;


    if ($userinfo[$istype] != 1) {//如果没有注册
        $arr = $client->livereg($site_id, $userinfo['username'], $typeLive);
        if (is_array($arr) and $arr) {
            if ($arr['info'] == 'ok') {
                $zzType = $arr['msg'][2];
                $zz_username = $arr['msg'][0];
                $zz_password = $arr['msg'][1];
                $par = zzType($zzType, $zz_username, $zz_password);
                $params = $par['params'];
                $params[':uid'] = $userinfo['uid'];
                $sql = 'update  mydata1_db.k_user set ' . $par['strsql'] . ' where ' . $par['where'] . ' and uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $userinfo = user::getinfo($uid);
            } else {
                $data['info'] = 'no';
                $data['msg'] = '注册' . $typeName . '失败!!<br><br>' . $arr['info'][0] . ' => ' . $arr['msg'][0];
                echo '(' . json_encode($data) . ')';
                exit;
            }
        } else {
            $data['info'] = 'no';
            $data['msg'] = '注册' . $typeName . '失败!!<br><br>请检查线路!!';
            echo '(' . json_encode($data) . ')';
            exit;
        }
    }

    //获取余额
    $arrUrl = $client->livebalance($site_id, $userinfo[$zzusername], $userinfo[$zzpassword], $typeLive);

    if (is_array($arrUrl) and $arrUrl) {
        $out_money = 0;
        if ($arrUrl['result'] == 'ok') {
            $out_money = $arrUrl['msg'];
            $zrmoney = $out_money;
        } else {
            return '获取' . $typeName . '余额失败!!';
        }

    } else {
        return '获取' . $typeName . '余额失败!!!';
    }

    if ($typeGiro == 'IN') {//转入真人
        if ($userinfo['money'] < $zz_money) {
            return '体育/彩票额度不足!!';
        }
        $giroName = '转入';
        $jiajian = '扣款';
        $transferAmount = -$zz_money;
    } else if ($typeGiro == 'OUT') {//转出真人
        if ($all) {
            $zz_money = (int)$out_money;
        } 
        if ($out_money < $zz_money || (int)$out_money == 0) {
            $stmt = $mydata1_db->prepare('update k_user set ' . $zzmoney . '=:zz_money,' . $zztime . '=now() where uid=:uid');
            $stmt->execute([':zz_money' => $out_money, ':uid' => $uid]);
            return $typeName . '额度不足!!';
        }
        $giroName = '转出';
        $jiajian = '加款';
        $transferAmount = $zz_money;
    } else {
        return '请选择转帐类型!!';
    }

    $billno = get_billno_live();
    //预备转帐
    $pre_json = $client->prelivegiro($site_id, $userinfo[$zzusername], $userinfo[$zzpassword], $typeLive, $billno, $typeGiro, sprintf("%.2f", $zz_money));

    if (is_array($pre_json) and $pre_json) {
        if ($pre_json['result'] == 'ok' and $billno == $pre_json['msg']) {//预备成功 且编号一致
            $billno = $pre_json['msg'];
            $userinfo = user::getinfo($uid);
            $moneyA = $userinfo['money'];
            if ($typeGiro == 'IN') {//预备转入提前扣款
                $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zz_money2' => $zz_money, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set money=money-:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid and money>=:zz_money2';

                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '预备扣款失败!!请联系客服人员！';
                }
            }
            //写入日志
            $userinfo = user::getinfo($uid);
            $moneyB = $userinfo['money'];
            $zz_time = date('Y-m-d H:i:s');
            $params = array(':live_type' => $typeLive, ':zz_type' => $typeGiro, ':uid' => $uid, ':username' => $userinfo['username'], ':zr_username' => $userinfo[$zzusername], ':zz_money' => $zz_money, ':zz_time' => $zz_time, ':billno' => $billno, ':moneyA' => $moneyA, ':moneyB' => $moneyB);

            $sql = 'insert into ag_zhenren_zz(live_type,zz_type,uid,username,zr_username,zz_money,ok,result,zz_num,zz_time,billno,moneyA,moneyB) values(:live_type,:zz_type,:uid,:username,:zr_username,:zz_money,0,"预备转账",0,:zz_time,:billno,:moneyA,:moneyB)';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            $zzid = $mydata1_db->lastInsertId();

            //正式转帐
            $userinfo = user::getinfo($uid);
            $money1 = $userinfo['money'];//转前余额
            $json = $client->livegiro($site_id, $userinfo[$zzusername], $userinfo[$zzpassword], $typeLive, $billno, $typeGiro, sprintf("%.2f", $zz_money));
            if (is_array($json) and $json) {
                if ($json['result'] == 'ok' and $billno == $json['msg']) {
                    $billno = $json['msg'];
                    $userinfo = user::getinfo($uid);
                    if ($typeGiro == 'IN') {
                        $zrmoney = $out_money + $zz_money;//计算真人余额
                        $params = array(':uid' => $uid, ':zrmoney' => $zrmoney);
                        $sql = 'update k_user set ' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                        $stmt = $mydata1_db->prepare($sql);
                        $stmt->execute($params);
                        $q1 = $stmt->rowCount();
                        if ($q1 <= 0) {
                            return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                        }
                    } else if ($typeGiro == 'OUT') {
                        $zrmoney = $out_money - $zz_money;//计算真人余额
                        $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
                        $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                        $stmt = $mydata1_db->prepare($sql);
                        $stmt->execute($params);
                        $q1 = $stmt->rowCount();
                        if ($q1 <= 0) {
                            return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                        }
                    }
                    $userinfo = user::getinfo($uid);
                    $moneyB = $userinfo['money'];
                    $zz_time = date('Y-m-d H:i:s');
                    //更新真人转账表
                    $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账成功" where  billno = \'' . $billno . '\'');
                    $params = array(':uid' => $uid, ':userName' => $userinfo['username'], ':transferType' => $typeGiro, ':transferOrder' => $billno, ':transferAmount' => $transferAmount, ':previousAmount' => $moneyA, ':currentAmount' => $moneyB, ':creationTime' => $zz_time);
                    $sql = 'INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) VALUE(:uid,:userName,\'' . $typeLive . 'LIVE\',:transferType,:transferOrder,:transferAmount,:previousAmount,:currentAmount,:creationTime)';
                    $stmt = $mydata1_db->prepare($sql);
                    $stmt->execute($params);
                    return 'ok';
                } else {
                    if ($typeGiro == 'IN') {
                        //退还扣除的款项
                        $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zz_money2' => $zz_money, ':zrmoney' => $zrmoney);
                        $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid and money>=:zz_money2';
                        $stmt = $mydata1_db->prepare($sql);
                        $stmt->execute($params);
                    }
                    //更新真人转账表
                    $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账失败" where  billno = \'' . $billno . '\'');
                    return '转帐失败!!原因：' . $json['msg'] . '!!';
                }
            } else {
                if ($typeGiro == 'IN') {
                    //退还扣除的款项
                    $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
                    $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                    $stmt = $mydata1_db->prepare($sql);
                    $stmt->execute($params);
                }
                //更新真人转账表
                $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账失败" where  billno = \'' . $billno . '\'');
                return '请检查网络线路!!';
            }
        } else {
            return '预备转账失败!!';
        }
    } else {
        return '请检查网络线路1!!';
    }
}

function giro_MAYA($uid, $typeLive, $typeGiro, $zz_money, $all = false)
{
    if(! check_game($typeLive)) return '维护中';
    $t = check($uid, 'MAYA');
    if($t !== 0) return '操作过于频繁,请'.$t.'秒稍后再试';
    global $mydata1_db;
    global $site_id;
    global $cj_url;
    global $client;

    $userinfo = user::getinfo($uid);
    $str = typeName($typeLive);

    $typeName = $str['title'];//真人平台名称
    $istype = $str['istype'];//数据库字段名--是否注册
    $zzusername = $str['zzusername'];//数据库字段名--平台帐号
    $GameMemberID = $str['zzpassword'];//数据库字段名--玛雅会员ID
    $zzmoney = $str['zzmoney'];
    $zztime = $str['zztime'];
    $giroName = '转入';
    $jiajian = '扣款';
    $transferAmount = -$zz_money;


    if ($userinfo[$istype] != 1) {//如果没有注册
        $arr = $client->liveloginmaya($site_id, $userinfo['username']);
        if (is_array($arr) and $arr) {
            if ($arr['info'] == 'ok') {
                $params = array(':username' => $userinfo['username'], ':mayaUserName' => $arr['username'], ':mayaGameMemberID' => $arr['GameMemberID'], ':mayaVenderMemberID' => $arr['VenderMemberID'], ':uid' => $uid);
                $sql = 'update  mydata1_db.k_user set mayaUserName=:mayaUserName,mayaGameMemberID=:mayaGameMemberID,mayaVenderMemberID=:mayaVenderMemberID,mayaAddtime=now(),ismaya=1 where ismaya=0 and username = :username and uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);

                $userinfo = user::getinfo($uid);
            } else {
                $data['info'] = 'no';
                $data['msg'] = '注册' . $typeName . '失败!!<br><br>' . $arr['ErrorCode'];

                echo '(' . json_encode($data) . ')';
                exit;
            }
        } else {
            $data['info'] = 'no';
            $data['msg'] = '注册' . $typeName . '失败!!<br><br>请检查线路!!';
            echo '(' . json_encode($data) . ')';
            exit;
        }
    }

    //获取余额
    $arrUrl = $client->livebalancemaya($site_id, $userinfo['mayaGameMemberID']);

    if (is_array($arrUrl) and $arrUrl) {
        $out_money = 0;
        if ($arrUrl['info'] == 'ok') {
            $out_money = $arrUrl['balance'];
        } else {
            return '获取' . $typeName . '余额失败!!' . $arrUrl['ErrorCode'];
        }

    } else {
        return '获取' . $typeName . '余额失败!!!';
    }

    if ($typeGiro == 'IN') {//转入真人
        if ($userinfo['money'] < $zz_money) {
            return '体育/彩票额度不足!!';
        }
        $giroName = '转入';
        $jiajian = '扣款';
        $transferAmount = -$zz_money;
    } else if ($typeGiro == 'OUT') {//转出真人
        if ($all) {
            $zz_money = (int)$out_money;
        }

        if ($out_money < $zz_money  || (int)$out_money == 0) {
        	$stmt = $mydata1_db->prepare('update k_user set ' . $zzmoney . '=:zz_money,' . $zztime . '=now() where uid=:uid');
            $stmt->execute([':zz_money' => $out_money, ':uid' => $uid]);
            return $typeName . '额度不足!!';
        }
        $giroName = '转出';
        $jiajian = '加款';
        $transferAmount = $zz_money;
    } else {
        return '请选择转帐类型!!';
    }

    $billno = get_billno_live();
    $json = $client->livegiromaya($site_id, $userinfo['mayaGameMemberID'], sprintf("%.2f", $zz_money), strtolower($typeGiro), $billno);

    if (is_array($json) and $json) {
        if ($json['info'] == 'ok') {
            $billno = $json['msg'];
            $userinfo = user::getinfo($uid);
            $moneyA = $userinfo['money'];
            if ($typeGiro == 'IN') {
                $zrmoney = $out_money + $zz_money;//计算真人余额
                $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zz_money2' => $zz_money, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set money=money-:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid and money>=:zz_money2';
            } else if ($typeGiro == 'OUT') {
                $zrmoney = $out_money - $zz_money;//计算真人余额
                $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
            }
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            $q1 = $stmt->rowCount();
            if ($q1 <= 0) {
                return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
            }


            $userinfo = user::getinfo($uid);
            $moneyB = $userinfo['money'];
            $zz_time = date('Y-m-d H:i:s');
            $params = array(':live_type' => $typeLive, ':zz_type' => $typeGiro, ':uid' => $uid, ':username' => $userinfo['username'], ':zr_username' => $userinfo['mayaUserName'], ':zz_money' => $zz_money, ':zz_time' => $zz_time, ':billno' => $billno, ':moneyA' => $moneyA, ':moneyB' => $moneyB);

            $sql = 'insert into ag_zhenren_zz(live_type,zz_type,uid,username,zr_username,zz_money,ok,result,zz_num,zz_time,billno,moneyA,moneyB) values(:live_type,:zz_type,:uid,:username,:zr_username,:zz_money,1,"转账成功",0,:zz_time,:billno,:moneyA,:moneyB)';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            $zzid = $mydata1_db->lastInsertId();

            $params = array(':uid' => $uid, ':userName' => $userinfo['username'], ':transferType' => $typeGiro, ':transferOrder' => $billno, ':transferAmount' => $transferAmount, ':previousAmount' => $moneyA, ':currentAmount' => $moneyB, ':creationTime' => $zz_time);
            $sql = 'INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) VALUE(:uid,:userName,\'' . $typeLive . 'LIVE\',:transferType,:transferOrder,:transferAmount,:previousAmount,:currentAmount,:creationTime)';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            return 'ok';
        } else {
            return '转帐失败!!原因：' . $json['ErrorCode'] . '!!';
        }
    } else {
        return '请检查网络线路!!';
    }

}

function giro_MW($uid, $typeLive, $typeGiro, $zz_money, $all = false)
{
    if(! check_game($typeLive)) return '维护中';
    $t = check($uid, 'MW');
    if($t !== 0) return '操作过于频繁,请'.$t.'秒稍后再试';
    global $mydata1_db;
    global $site_id;
    global $cj_url;
    global $client;

    $userinfo = user::getinfo($uid);
    $str = typeName($typeLive);

    $typeName = $str['title'];//真人平台名称
    $istype = $str['istype'];//数据库字段名--是否注册
    $zzusername = $str['zzusername'];//数据库字段名--平台帐号
    $zzpassword = $str['zzpassword'];//数据库字段名--平台密码
    $zzmoney = $str['zzmoney'];
    $zztime = $str['zztime'];
    $giroName = '转入';
    $jiajian = '扣款';
    $transferAmount = -$zz_money;


    if ($userinfo[$istype] != 1) {//如果没有注册
        $arr = $client->liveregmw($site_id, $userinfo['username']);
        if (is_array($arr) and $arr) {
            if ($arr['info'] == 'ok') {
                $params = array(':username' => $userinfo['username'], ':mwUserName' => $arr['username'], ':mwPassWord' => $arr['password'], ':uid' => $uid);
                $sql = 'update  mydata1_db.k_user set mwUserName=:mwUserName,mwAddtime=now(),ismw=1,mwPassWord=:mwPassWord where ismw=0 and username = :username and uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);

                $userinfo = user::getinfo($uid);
            } else {
                $data['info'] = 'no';
                $data['msg'] = '注册' . $typeName . '失败!!<br><br>' . $arr['msg'];
                echo '(' . json_encode($data) . ')';
                exit;
            }
        } else {
            $data['info'] = 'no';
            $data['msg'] = '注册' . $typeName . '失败!!<br><br>请检查线路!!';
            echo '(' . json_encode($data) . ')';
            exit;
        }
    }

    //获取余额
    $arrUrl = $client->livebalancemw($site_id, $userinfo['mwUserName'], $userinfo['mwPassWord']);

    if (is_array($arrUrl) and $arrUrl) {
        $out_money = 0;
        if ($arrUrl['info'] == 'ok') {
            $out_money = sprintf("%.2f", $arrUrl['money']);
            $zrmoney = $out_money;
        } else {
            return '获取' . $typeName . '余额失败!!' . $arrUrl['msg'];
        }

    } else {
        return '获取' . $typeName . '余额失败!!!';
    }

    if ($typeGiro == 'IN') {//转入真人
        if ($userinfo['money'] < $zz_money) {
            return '体育/彩票额度不足!!';
        }
        $giroName = '转入';
        $jiajian = '扣款';
        $transferAmount = -$zz_money;
        $transferType = 0;
    } else if ($typeGiro == 'OUT') {//转出真人
        if ($all) {
            $zz_money = (int)$out_money;
        }

        if ($out_money < $zz_money || (int)$out_money == 0) {
        	$stmt = $mydata1_db->prepare('update k_user set ' . $zzmoney . '=:zz_money,' . $zztime . '=now() where uid=:uid');
            $stmt->execute([':zz_money' => $out_money, ':uid' => $uid]);
            return $typeName . '额度不足!!';
        }
        $giroName = '转出';
        $jiajian = '加款';
        $transferType = 1;
        $transferAmount = $zz_money;
    } else {
        return '请选择转帐类型!!';
    }

    $billno = get_billno_live();
    //预备转帐
    $pre_json = $client->livegiropremw($site_id, $userinfo['mwUserName'], $userinfo['mwPassWord'], $billno, $zz_money, $transferType);
    if (is_array($pre_json) and $pre_json) {

        if ($pre_json['info'] == 'ok' and $billno == $pre_json['billno']) {//预备成功 且编号一致

            //MW转帐编号
            $asinTransferOrderNo = $pre_json['asinTransferOrderNo'];
            $asinTransferDate = $pre_json['asinTransferDate'];

            $billno = $pre_json['billno'];
            $userinfo = user::getinfo($uid);
            $moneyA = $userinfo['money'];
            if ($typeGiro == 'IN') {//预备转入提前扣款
                $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zz_money2' => $zz_money, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set money=money-:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid and money>=:zz_money2';  
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();  
                if ($q1 <= 0) {
                    return $typeName . '预备扣款失败!!请联系客服人员！';
                }            
            }
            if ($typeGiro == 'IN') {
                //写入日志
                $userinfo = user::getinfo($uid);
                $moneyB = $userinfo['money'];
                $zz_time = date('Y-m-d H:i:s');
                $params = array(':live_type' => $typeLive, ':zz_type' => $typeGiro, ':uid' => $uid, ':username' => $userinfo['username'], ':zr_username' => $userinfo['mwUserName'], ':zz_money' => $zz_money, ':zz_time' => $zz_time, ':billno' => $billno, ':moneyA' => $moneyA, ':moneyB' => $moneyB);

                $sql = 'insert into ag_zhenren_zz(live_type,zz_type,uid,username,zr_username,zz_money,ok,result,zz_num,zz_time,billno,moneyA,moneyB) values(:live_type,:zz_type,:uid,:username,:zr_username,:zz_money,0,"预备转账",0,:zz_time,:billno,:moneyA,:moneyB)';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $zzid = $mydata1_db->lastInsertId();
            }

            //正式转帐
            $userinfo = user::getinfo($uid);
            $money1 = $userinfo['money'];//转前余额
            $json = $client->livegiromw($site_id, $userinfo['mwUserName'], $userinfo['mwPassWord'], $billno, $zz_money, $asinTransferOrderNo, $asinTransferDate);
            if (is_array($json) and $json) {
                if ($json['info'] == 'ok' and $billno == $json['billno']) {
                    $billno = $json['billno'];
                    $userinfo = user::getinfo($uid);
                    if ($typeGiro == 'IN') {
                        $zrmoney = $out_money + $zz_money;//计算真人余额
                        $params = array(':uid' => $uid, ':zrmoney' => $zrmoney);
                        $sql = 'update k_user set ' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                        $stmt = $mydata1_db->prepare($sql);
                        $stmt->execute($params);
                        $q1 = $stmt->rowCount();
                        if ($q1 <= 0) {
                            return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                        }
                    } else if ($typeGiro == 'OUT') {                
                        $zrmoney = $out_money - $zz_money;//计算真人余额
                        $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
                        $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                        $stmt = $mydata1_db->prepare($sql);
                        $stmt->execute($params);
                        $q1 = $stmt->rowCount();
                        if ($q1 <= 0) {
                            return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                        }else{
                            //写入日志
                            $userinfo = user::getinfo($uid);
                            $moneyB = $userinfo['money'];
                            $zz_time = date('Y-m-d H:i:s');
                            $params = array(':live_type' => $typeLive, ':zz_type' => $typeGiro, ':uid' => $uid, ':username' => $userinfo['username'], ':zr_username' => $userinfo['mwUserName'], ':zz_money' => $zz_money, ':zz_time' => $zz_time, ':billno' => $billno, ':moneyA' => $moneyA, ':moneyB' => $moneyB);

                            $sql = 'insert into ag_zhenren_zz(live_type,zz_type,uid,username,zr_username,zz_money,ok,result,zz_num,zz_time,billno,moneyA,moneyB) values(:live_type,:zz_type,:uid,:username,:zr_username,:zz_money,0,"预备转账",0,:zz_time,:billno,:moneyA,:moneyB)';
                            $stmt = $mydata1_db->prepare($sql);
                            $stmt->execute($params);
                            $zzid = $mydata1_db->lastInsertId();
                        }
                    }


                    $userinfo = user::getinfo($uid);
                    $moneyB = $userinfo['money'];
                    $zz_time = date('Y-m-d H:i:s');

                    //更新真人转账表
                    $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账成功" where  billno = \'' . $billno . '\'');

                    $params = array(':uid' => $uid, ':userName' => $userinfo['username'], ':transferType' => $typeGiro, ':transferOrder' => $billno, ':transferAmount' => $transferAmount, ':previousAmount' => $moneyA, ':currentAmount' => $moneyB, ':creationTime' => $zz_time);
                    $sql = 'INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) VALUE(:uid,:userName,\'' . $typeLive . 'LIVE\',:transferType,:transferOrder,:transferAmount,:previousAmount,:currentAmount,:creationTime)';
                    $stmt = $mydata1_db->prepare($sql);
                    $stmt->execute($params);
                    return 'ok';
                } else {
                    if ($typeGiro == 'IN') {
                        //退还扣除的款项
                        $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
                        $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';

                        $stmt = $mydata1_db->prepare($sql);
                        $stmt->execute($params);
                    }
                    //更新真人转账表
                    $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账失败" where  billno = \'' . $billno . '\'');
                    return '转帐失败!!原因：' . $json['msg'] . '!!';
                }
            } else {
                if ($typeGiro == 'IN') {
                    //退还扣除的款项
                    $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
                    $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';

                    $stmt = $mydata1_db->prepare($sql);
                    $stmt->execute($params);
                }

                //更新真人转账表
                $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账失败" where  billno = \'' . $billno . '\'');

                return '请检查网络线路!!';
            }
        } else {
            return '2预备转账失败!!' . $pre_json['msg'];
        }


    } else {
        return '请检查网络线路1!!';
    }

}


function giro_KG($uid, $typeLive, $typeGiro, $zz_money, $all = false)
{   
    if(! check_game($typeLive)) return '维护中';
    $t = check($uid, 'KG');
    if($t !== 0) return '操作过于频繁,请'.$t.'秒稍后再试';
    global $mydata1_db;
    global $site_id;
    global $cj_url;
    global $client;

    $userinfo = user::getinfo($uid);
    $str = typeName($typeLive); 

    $typeName = $str['title'];//真人平台名称
    $istype = $str['istype'];//数据库字段名--是否注册
    $zzusername = $str['zzusername'];//数据库字段名--平台帐号
    $zzpassword = $str['zzpassword'];//数据库字段名--平台密码
    $zzmoney = $str['zzmoney'];
    $zztime = $str['zztime'];
    $giroName = '转入';
    $jiajian = '扣款';
    $transferAmount = -$zz_money;


    if ($userinfo['iskg'] != 1) {//如果没有注册
        $arr = $client->liveregkg($site_id, $userinfo['username']);
        if (is_array($arr) and $arr) {
            if ($arr['info'] == 'ok') {
                $params = array(':username' => $userinfo['username'], ':kgUserName' => $arr['username'], ':kgPassWord' => $arr['password'], ':uid' => $uid);
                $sql = 'update  mydata1_db.k_user set kgUserName=:kgUserName,kgAddtime=now(),iskg=1,kgPassWord=:kgPassWord where iskg=0 and username = :username and uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);

                $userinfo = user::getinfo($uid);
            } else {
                $data['info'] = 'no';
                $data['msg'] = '注册' . $typeName . '失败!!<br><br>' . $arr['msg'];
                echo '(' . json_encode($data) . ')';
                exit;
            }
        } else {
            $data['info'] = 'no';
            $data['msg'] = '注册' . $typeName . '失败!!<br><br>请检查线路!!';
            echo '(' . json_encode($data) . ')';
            exit;
        }
    }
    //获取余额
    $arrUrl = $client->livebalancekg($site_id, $userinfo['kgUserName']);
    if (is_array($arrUrl) and $arrUrl) {
        $out_money = 0;
        if ($arrUrl['info'] == 'ok') {
            $out_money = sprintf("%.2f", $arrUrl['money']);
            $zrmoney = $out_money;
        } else {
            return '获取' . $typeName . '余额失败!!' . $arrUrl['msg'];
        }

    } else {
        return '获取' . $typeName . '余额失败!!!';
    }

    if ($typeGiro == 'IN') {//转入真人
        if ($userinfo['money'] < $zz_money) {
            return '体育/彩票额度不足!!';
        }
        $giroName = '转入';
        $jiajian = '扣款';
        $transferAmount = -$zz_money;
        $transferType = 0;
    } else if ($typeGiro == 'OUT') {//转出真人
        if ($all) {
            $zz_money = (int)$out_money;
        }

        if ($out_money < $zz_money || (int)$out_money == 0) {
            $stmt = $mydata1_db->prepare('update k_user set ' . $zzmoney . '=:zz_money,' . $zztime . '=now() where uid=:uid');
            $stmt->execute([':zz_money' => $out_money, ':uid' => $uid]);
            return $typeName . '额度不足!!';
        }
        $giroName = '转出';
        $jiajian = '加款';
        $transferType = 1;
        $transferAmount = $zz_money;
    } else {
        return '请选择转帐类型!!';
    }

    $billno = get_billno_live();
    
    $userinfo = user::getinfo($uid);
    $moneyA = $userinfo['money'];

    if ($typeGiro == 'IN') {//预备转入提前扣款
        $q1 = pre_giro_in($uid, $zz_money, $zrmoney, $typeLive, $billno);
        if ($q1 <= 0) {
            return $typeName . '预备扣款失败!!请联系客服人员！';
        }
    }

    $json = $client->livegirokg($site_id, $userinfo['kgUserName'], $billno, $zz_money, $transferType);
    if (is_array($json) && $json['info'] == 'ok') {  
            $userinfo = user::getinfo($uid);
            if ($typeGiro == 'IN') {
                $zrmoney = $out_money + $zz_money;//计算真人余额
                $params = array(':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set ' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                }
            } else if ($typeGiro == 'OUT') {                
                $zrmoney = $out_money - $zz_money;//计算真人余额
                $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                }else{
                    //写入日志
                    $userinfo = user::getinfo($uid);
                    $moneyB = $userinfo['money'];
                    $zz_time = date('Y-m-d H:i:s');
                    $params = array(':live_type' => $typeLive, ':zz_type' => $typeGiro, ':uid' => $uid, ':username' => $userinfo['username'], ':zr_username' => $userinfo['kgUserName'], ':zz_money' => $zz_money, ':zz_time' => $zz_time, ':billno' => $billno, ':moneyA' => $moneyA, ':moneyB' => $moneyB);
                    $sql = 'insert into ag_zhenren_zz(live_type,zz_type,uid,username,zr_username,zz_money,ok,result,zz_num,zz_time,billno,moneyA,moneyB) values(:live_type,:zz_type,:uid,:username,:zr_username,:zz_money,0,"预备转账",0,:zz_time,:billno,:moneyA,:moneyB)';
                    $stmt = $mydata1_db->prepare($sql);
                    $stmt->execute($params);
                    $zzid = $mydata1_db->lastInsertId();
                }
            }
            $userinfo = user::getinfo($uid);
            $moneyB = $userinfo['money'];
            $zz_time = date('Y-m-d H:i:s');

            //更新真人转账表
            $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账成功" where  billno = \'' . $billno . '\'');

            $params = array(':uid' => $uid, ':userName' => $userinfo['username'], ':transferType' => $typeGiro, ':transferOrder' => $billno, ':transferAmount' => $transferAmount, ':previousAmount' => $moneyA, ':currentAmount' => $moneyB, ':creationTime' => $zz_time);
            $sql = 'INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) VALUE(:uid,:userName,\'' . $typeLive . 'LIVE\',:transferType,:transferOrder,:transferAmount,:previousAmount,:currentAmount,:creationTime)';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            return 'ok';
    } else {
        if ($typeGiro == 'IN') {
            //退还扣除的款项
            $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
            $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';

            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
        }

        //更新真人转账表
        $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账失败" where  billno = \'' . $billno . '\'');
        return '转帐失败!!';
    }
}


function giro_CQ9($uid, $typeLive, $typeGiro, $zz_money, $all = false)
{
    if(! check_game($typeLive)) return '维护中';
    $t = check($uid, 'CQ9');
    if($t !== 0) return '操作过于频繁,请'.$t.'秒稍后再试';
    global $mydata1_db;
    global $site_id;
    global $cj_url;
    global $client;

    $userinfo = user::getinfo($uid);
    $str = typeName($typeLive); 

    $typeName = $str['title'];//真人平台名称
    $istype = $str['istype'];//数据库字段名--是否注册
    $zzusername = $str['zzusername'];//数据库字段名--平台帐号
    $zzpassword = $str['zzpassword'];//数据库字段名--平台密码
    $zzmoney = $str['zzmoney'];
    $zztime = $str['zztime'];
    $giroName = '转入';
    $jiajian = '扣款';
    $transferAmount = -$zz_money;


    if ($userinfo[$istype] != 1) {//如果没有注册
        $arr = $client->liveregcq9($site_id, $userinfo['username']);
        if (is_array($arr) and $arr) {
            if ($arr['info'] == 'ok') {
                $params = array(':username' => $userinfo['username'], ':cq9UserName' => $arr['username'], ':cq9PassWord' => $arr['password'], ':uid' => $uid);
                $sql = 'update  mydata1_db.k_user set cq9UserName=:cq9UserName,cq9Addtime=now(),iscq9=1,cq9PassWord=:cq9PassWord where iscq9=0 and username = :username and uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);

                $userinfo = user::getinfo($uid);
            } else {
                $data['info'] = 'no';
                $data['msg'] = '注册' . $typeName . '失败!!<br><br>' . $arr['msg'];
                echo '(' . json_encode($data) . ')';
                exit;
            }
        } else {
            $data['info'] = 'no';
            $data['msg'] = '注册' . $typeName . '失败!!<br><br>请检查线路!!';
            echo '(' . json_encode($data) . ')';
            exit;
        }
    }

    //获取余额
    $arrUrl = $client->livebalancecq9($site_id, $userinfo['cq9UserName']);

    if (is_array($arrUrl) and $arrUrl) {
        $out_money = 0;
        if ($arrUrl['info'] == 'ok') {
            $out_money = sprintf("%.2f", $arrUrl['money']);
            $zrmoney = $out_money;
        } else {
            return '获取' . $typeName . '余额失败!!' . $arrUrl['msg'];
        }

    } else {
        return '获取' . $typeName . '余额失败!!!';
    }

    if ($typeGiro == 'IN') {//转入真人
        if ($userinfo['money'] < $zz_money) {
            return '体育/彩票额度不足!!';
        }
        $giroName = '转入';
        $jiajian = '扣款';
        $transferAmount = -$zz_money;
        $transferType = 0;
    } else if ($typeGiro == 'OUT') {//转出真人
        if ($all) {
            $zz_money = (int)$out_money;
        }

        if ($out_money < $zz_money || (int)$out_money == 0) {
        	$stmt = $mydata1_db->prepare('update k_user set ' . $zzmoney . '=:zz_money,' . $zztime . '=now() where uid=:uid');
            $stmt->execute([':zz_money' => $out_money, ':uid' => $uid]);
            return $typeName . '额度不足!!';
        }
        $giroName = '转出';
        $jiajian = '加款';
        $transferType = 1;
        $transferAmount = $zz_money;
    } else {
        return '请选择转帐类型!!';
    }

    $billno = get_billno_live();
    $userinfo = user::getinfo($uid);
    $moneyA = $userinfo['money'];

    if ($typeGiro == 'IN') {//预备转入提前扣款
        $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zz_money2' => $zz_money, ':zrmoney' => $zrmoney);
        $sql = 'update k_user set money=money-:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid and money>=:zz_money2';  
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        $q1 = $stmt->rowCount();  
        if ($q1 <= 0) {
            return $typeName . '预备扣款失败!!请联系客服人员！';
        }else{
            $userinfo = user::getinfo($uid);
            $moneyB = $userinfo['money'];
            $zz_time = date('Y-m-d H:i:s');
            $params = array(':live_type' => $typeLive, ':zz_type' => $typeGiro, ':uid' => $uid, ':username' => $userinfo['username'], ':zr_username' => $userinfo['cq9UserName'], ':zz_money' => $zz_money, ':zz_time' => $zz_time, ':billno' => $billno, ':moneyA' => $moneyA, ':moneyB' => $moneyB);
            $sql = 'insert into ag_zhenren_zz(live_type,zz_type,uid,username,zr_username,zz_money,ok,result,zz_num,zz_time,billno,moneyA,moneyB) values(:live_type,:zz_type,:uid,:username,:zr_username,:zz_money,0,"预备转账",0,:zz_time,:billno,:moneyA,:moneyB)';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            $zzid = $mydata1_db->lastInsertId();
        }
    }

    $json = $client->livegirocq9($site_id, $userinfo['cq9UserName'], $billno, $zz_money, $transferType);
    if (is_array($json) && $json['info'] == 'ok') {
            $userinfo = user::getinfo($uid);
            if ($typeGiro == 'IN') {
                $zrmoney = $out_money + $zz_money;//计算真人余额
                $params = array(':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set ' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                }
            } else if ($typeGiro == 'OUT') {                
                $zrmoney = $out_money - $zz_money;//计算真人余额
                $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                }else{
                    //写入日志
                    $userinfo = user::getinfo($uid);
                    $moneyB = $userinfo['money'];
                    $zz_time = date('Y-m-d H:i:s');
                    $params = array(':live_type' => $typeLive, ':zz_type' => $typeGiro, ':uid' => $uid, ':username' => $userinfo['username'], ':zr_username' => $userinfo['cq9UserName'], ':zz_money' => $zz_money, ':zz_time' => $zz_time, ':billno' => $billno, ':moneyA' => $moneyA, ':moneyB' => $moneyB);
                    $sql = 'insert into ag_zhenren_zz(live_type,zz_type,uid,username,zr_username,zz_money,ok,result,zz_num,zz_time,billno,moneyA,moneyB) values(:live_type,:zz_type,:uid,:username,:zr_username,:zz_money,0,"预备转账",0,:zz_time,:billno,:moneyA,:moneyB)';
                    $stmt = $mydata1_db->prepare($sql);
                    $stmt->execute($params);
                    $zzid = $mydata1_db->lastInsertId();
                }
            }
            $userinfo = user::getinfo($uid);
            $moneyB = $userinfo['money'];
            $zz_time = date('Y-m-d H:i:s');

            //更新真人转账表
            $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账成功" where  billno = \'' . $billno . '\'');

            $params = array(':uid' => $uid, ':userName' => $userinfo['username'], ':transferType' => $typeGiro, ':transferOrder' => $billno, ':transferAmount' => $transferAmount, ':previousAmount' => $moneyA, ':currentAmount' => $moneyB, ':creationTime' => $zz_time);
            $sql = 'INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) VALUE(:uid,:userName,\'' . $typeLive . 'LIVE\',:transferType,:transferOrder,:transferAmount,:previousAmount,:currentAmount,:creationTime)';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            return 'ok';
    } else {
        if ($typeGiro == 'IN') {
            //退还扣除的款项
            $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
            $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';

            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
        }

        //更新真人转账表
        $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账失败" where  billno = \'' . $billno . '\'');
        return '转帐失败!!';
    }
}

function giro_MG2($uid, $typeLive, $typeGiro, $zz_money, $all = false)
{
    if(! check_game($typeLive)) return '维护中';
    $t = check($uid, 'MG2');
    if($t !== 0) return '操作过于频繁,请'.$t.'秒稍后再试';
    global $mydata1_db;
    global $site_id;
    global $cj_url;
    global $client;

    $userinfo = user::getinfo($uid);
    $str = typeName($typeLive); 

    $typeName = $str['title'];//真人平台名称
    $istype = $str['istype'];//数据库字段名--是否注册
    $zzusername = $str['zzusername'];//数据库字段名--平台帐号
    $zzpassword = $str['zzpassword'];//数据库字段名--平台密码
    $zzmoney = $str['zzmoney'];
    $zztime = $str['zztime'];
    $giroName = '转入';
    $jiajian = '扣款';
    $transferAmount = -$zz_money;


    if ($userinfo[$istype] != 1) {//如果没有注册
        $arr = $client->liveregmg2($site_id, $userinfo['username']);
        if (is_array($arr) and $arr) {
            if ($arr['info'] == 'ok') {
                $params = array(':username' => $userinfo['username'], ':mg2UserName' => $arr['username'], ':mg2PassWord' => $arr['password'], ':uid' => $uid);
                $sql = 'update  mydata1_db.k_user set mg2UserName=:mg2UserName,mg2Addtime=now(),ismg2=1,mg2PassWord=:mg2PassWord where ismg2=0 and username = :username and uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);

                $userinfo = user::getinfo($uid);
            } else {
                $data['info'] = 'no';
                $data['msg'] = '注册' . $typeName . '失败!!<br><br>' . $arr['msg'];
                echo '(' . json_encode($data) . ')';
                exit;
            }
        } else {
            $data['info'] = 'no';
            $data['msg'] = '注册' . $typeName . '失败!!<br><br>请检查线路!!';
            echo '(' . json_encode($data) . ')';
            exit;
        }
    }

    //获取余额
    $arrUrl = $client->livebalancemg2($site_id, $userinfo['mg2UserName']);

    if (is_array($arrUrl) and $arrUrl) {
        $out_money = 0;
        if ($arrUrl['info'] == 'ok') {
            $out_money = sprintf("%.2f", $arrUrl['money']);
            $zrmoney = $out_money;
        } else {
            return '获取' . $typeName . '余额失败!!' . $arrUrl['msg'];
        }

    } else {
        return '获取' . $typeName . '余额失败!!!';
    }

    if ($typeGiro == 'IN') {//转入真人
        if ($userinfo['money'] < $zz_money) {
            return '体育/彩票额度不足!!';
        }
        $giroName = '转入';
        $jiajian = '扣款';
        $transferAmount = -$zz_money;
        $transferType = 0;
    } else if ($typeGiro == 'OUT') {//转出真人
        if ($all) {
            $zz_money = (int)$out_money;
        }

        if ($out_money < $zz_money || (int)$out_money == 0) {
        	$stmt = $mydata1_db->prepare('update k_user set ' . $zzmoney . '=:zz_money,' . $zztime . '=now() where uid=:uid');
            $stmt->execute([':zz_money' => $out_money, ':uid' => $uid]);
            return $typeName . '额度不足!!';
        }
        $giroName = '转出';
        $jiajian = '加款';
        $transferType = 1;
        $transferAmount = $zz_money;
    } else {
        return '请选择转帐类型!!';
    }

    $billno = get_billno_live();
    
    $userinfo = user::getinfo($uid);
    $moneyA = $userinfo['money'];

    if ($typeGiro == 'IN') {//预备转入提前扣款
        $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zz_money2' => $zz_money, ':zrmoney' => $zrmoney);
        $sql = 'update k_user set money=money-:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid and money>=:zz_money2';  
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        $q1 = $stmt->rowCount();  
        if ($q1 <= 0) {
            return $typeName . '预备扣款失败!!请联系客服人员！';
        }else{
            $userinfo = user::getinfo($uid);
            $moneyB = $userinfo['money'];
            $zz_time = date('Y-m-d H:i:s');
            $params = array(':live_type' => $typeLive, ':zz_type' => $typeGiro, ':uid' => $uid, ':username' => $userinfo['username'], ':zr_username' => $userinfo['mg2UserName'], ':zz_money' => $zz_money, ':zz_time' => $zz_time, ':billno' => $billno, ':moneyA' => $moneyA, ':moneyB' => $moneyB);
            $sql = 'insert into ag_zhenren_zz(live_type,zz_type,uid,username,zr_username,zz_money,ok,result,zz_num,zz_time,billno,moneyA,moneyB) values(:live_type,:zz_type,:uid,:username,:zr_username,:zz_money,0,"预备转账",0,:zz_time,:billno,:moneyA,:moneyB)';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            $zzid = $mydata1_db->lastInsertId();
        }
    }

    $json = $client->livegiromg2($site_id, $userinfo['mg2UserName'], $billno, $zz_money, $transferType);
    if (is_array($json) && $json['info'] == 'ok') {  
            $userinfo = user::getinfo($uid);
            if ($typeGiro == 'IN') {
                $zrmoney = $out_money + $zz_money;//计算真人余额
                $params = array(':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set ' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                }
            } else if ($typeGiro == 'OUT') {                
                $zrmoney = $out_money - $zz_money;//计算真人余额
                $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                }else{
                    //写入日志
                    $userinfo = user::getinfo($uid);
                    $moneyB = $userinfo['money'];
                    $zz_time = date('Y-m-d H:i:s');
                    $params = array(':live_type' => $typeLive, ':zz_type' => $typeGiro, ':uid' => $uid, ':username' => $userinfo['username'], ':zr_username' => $userinfo['mg2UserName'], ':zz_money' => $zz_money, ':zz_time' => $zz_time, ':billno' => $billno, ':moneyA' => $moneyA, ':moneyB' => $moneyB);
                    $sql = 'insert into ag_zhenren_zz(live_type,zz_type,uid,username,zr_username,zz_money,ok,result,zz_num,zz_time,billno,moneyA,moneyB) values(:live_type,:zz_type,:uid,:username,:zr_username,:zz_money,0,"预备转账",0,:zz_time,:billno,:moneyA,:moneyB)';
                    $stmt = $mydata1_db->prepare($sql);
                    $stmt->execute($params);
                    $zzid = $mydata1_db->lastInsertId();
                }
            }
            $userinfo = user::getinfo($uid);
            $moneyB = $userinfo['money'];
            $zz_time = date('Y-m-d H:i:s');

            //更新真人转账表
            $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账成功" where  billno = \'' . $billno . '\'');

            $params = array(':uid' => $uid, ':userName' => $userinfo['username'], ':transferType' => $typeGiro, ':transferOrder' => $billno, ':transferAmount' => $transferAmount, ':previousAmount' => $moneyA, ':currentAmount' => $moneyB, ':creationTime' => $zz_time);
            $sql = 'INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) VALUE(:uid,:userName,\'' . $typeLive . 'LIVE\',:transferType,:transferOrder,:transferAmount,:previousAmount,:currentAmount,:creationTime)';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            return 'ok';
    } else {
        if ($typeGiro == 'IN') {
            //退还扣除的款项
            $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
            $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';

            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
        }

        //更新真人转账表
        $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账失败" where  billno = \'' . $billno . '\'');
        return '转帐失败!!';
    }
}

function giro_VR($uid, $typeLive, $typeGiro, $zz_money, $all = false)
{
    if(! check_game($typeLive)) return '维护中';
    $t = check($uid, 'VR');
    if($t !== 0) return '操作过于频繁,请'.$t.'秒稍后再试';
    global $mydata1_db;
    global $site_id;
    global $cj_url;
    global $client;

    $userinfo = user::getinfo($uid);
    $str = typeName($typeLive); 

    $typeName = $str['title'];//真人平台名称
    $istype = $str['istype'];//数据库字段名--是否注册
    $zzusername = $str['zzusername'];//数据库字段名--平台帐号
    $zzpassword = $str['zzpassword'];//数据库字段名--平台密码
    $zzmoney = $str['zzmoney'];
    $zztime = $str['zztime'];
    $giroName = '转入';
    $jiajian = '扣款';
    $transferAmount = -$zz_money;


    if ($userinfo['isvr'] != 1) {//如果没有注册
        $arr = $client->liveregvr($site_id, $userinfo['username']);
        if (is_array($arr) and $arr) {
            if ($arr['info'] == 'ok') {
                $params = array(':username' => $userinfo['username'], ':vrUserName' => $arr['username'], ':vrPassWord' => $arr['password'], ':uid' => $uid);
                $sql = 'update  mydata1_db.k_user set vrUserName=:vrUserName,vrAddtime=now(),isvr=1,vrPassWord=:vrPassWord where isvr=0 and username = :username and uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);

                $userinfo = user::getinfo($uid);
            } else {
                $data['info'] = 'no';
                $data['msg'] = '注册' . $typeName . '失败!!<br><br>' . $arr['msg'];
                echo '(' . json_encode($data) . ')';
                exit;
            }
        } else {
            $data['info'] = 'no';
            $data['msg'] = '注册' . $typeName . '失败!!<br><br>请检查线路!!';
            echo '(' . json_encode($data) . ')';
            exit;
        }
    }

    //获取余额
    $arrUrl = $client->livebalancevr($site_id, $userinfo['vrUserName']);
    //var_dump($arrUrl);
    if (is_array($arrUrl) and $arrUrl) {
        $out_money = 0;
        if ($arrUrl['info'] == 'ok') {
            $out_money = sprintf("%.2f", $arrUrl['money']);
            $zrmoney = $out_money;
        } else {
            return '获取' . $typeName . '余额失败!!' . $arrUrl['msg'];
        }

    } else {
        return '获取' . $typeName . '余额失败!!!';
    }

    if ($typeGiro == 'IN') {//转入真人
        if ($userinfo['money'] < $zz_money) {
            return '体育/彩票额度不足!!';
        }
        $giroName = '转入';
        $jiajian = '扣款';
        $transferAmount = -$zz_money;
        $transferType = 0;
    } else if ($typeGiro == 'OUT') {//转出真人
        if ($all) {
            $zz_money = (int)$out_money;
        }

        if ($out_money < $zz_money || (int)$out_money == 0) {
        	$stmt = $mydata1_db->prepare('update k_user set ' . $zzmoney . '=:zz_money,' . $zztime . '=now() where uid=:uid');
            $stmt->execute([':zz_money' => $out_money, ':uid' => $uid]);
            return $typeName . '额度不足!!';
        }
        $giroName = '转出';
        $jiajian = '加款';
        $transferType = 1;
        $transferAmount = $zz_money;
    } else {
        return '请选择转帐类型!!';
    }

    $billno = get_billno_live();
    
    $userinfo = user::getinfo($uid);
    $moneyA = $userinfo['money'];

    if ($typeGiro == 'IN') {//预备转入提前扣款
        $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zz_money2' => $zz_money, ':zrmoney' => $zrmoney);
        $sql = 'update k_user set money=money-:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid and money>=:zz_money2';  
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        $q1 = $stmt->rowCount();  
        if ($q1 <= 0) {
            return $typeName . '预备扣款失败!!请联系客服人员！';
        }else{
            $userinfo = user::getinfo($uid);
            $moneyB = $userinfo['money'];
            $zz_time = date('Y-m-d H:i:s');
            $params = array(':live_type' => $typeLive, ':zz_type' => $typeGiro, ':uid' => $uid, ':username' => $userinfo['username'], ':zr_username' => $userinfo['vrUserName'], ':zz_money' => $zz_money, ':zz_time' => $zz_time, ':billno' => $billno, ':moneyA' => $moneyA, ':moneyB' => $moneyB);
            $sql = 'insert into ag_zhenren_zz(live_type,zz_type,uid,username,zr_username,zz_money,ok,result,zz_num,zz_time,billno,moneyA,moneyB) values(:live_type,:zz_type,:uid,:username,:zr_username,:zz_money,0,"预备转账",0,:zz_time,:billno,:moneyA,:moneyB)';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            $zzid = $mydata1_db->lastInsertId();
        }
    }

    $json = $client->livegirovr($site_id, $userinfo['vrUserName'], $billno, $zz_money, $transferType);
    if (is_array($json) && $json['info'] == 'ok') {  
            $userinfo = user::getinfo($uid);
            if ($typeGiro == 'IN') {
                $zrmoney = $out_money + $zz_money;//计算真人余额
                $params = array(':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set ' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                }
            } else if ($typeGiro == 'OUT') {                
                $zrmoney = $out_money - $zz_money;//计算真人余额
                $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                }else{
                    //写入日志
                    $userinfo = user::getinfo($uid);
                    $moneyB = $userinfo['money'];
                    $zz_time = date('Y-m-d H:i:s');
                    $params = array(':live_type' => $typeLive, ':zz_type' => $typeGiro, ':uid' => $uid, ':username' => $userinfo['username'], ':zr_username' => $userinfo['vrUserName'], ':zz_money' => $zz_money, ':zz_time' => $zz_time, ':billno' => $billno, ':moneyA' => $moneyA, ':moneyB' => $moneyB);
                    $sql = 'insert into ag_zhenren_zz(live_type,zz_type,uid,username,zr_username,zz_money,ok,result,zz_num,zz_time,billno,moneyA,moneyB) values(:live_type,:zz_type,:uid,:username,:zr_username,:zz_money,0,"预备转账",0,:zz_time,:billno,:moneyA,:moneyB)';
                    $stmt = $mydata1_db->prepare($sql);
                    $stmt->execute($params);
                    $zzid = $mydata1_db->lastInsertId();
                }
            }
            $userinfo = user::getinfo($uid);
            $moneyB = $userinfo['money'];
            $zz_time = date('Y-m-d H:i:s');

            //更新真人转账表
            $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账成功" where  billno = \'' . $billno . '\'');

            $params = array(':uid' => $uid, ':userName' => $userinfo['username'], ':transferType' => $typeGiro, ':transferOrder' => $billno, ':transferAmount' => $transferAmount, ':previousAmount' => $moneyA, ':currentAmount' => $moneyB, ':creationTime' => $zz_time);
            $sql = 'INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) VALUE(:uid,:userName,\'' . $typeLive . 'LIVE\',:transferType,:transferOrder,:transferAmount,:previousAmount,:currentAmount,:creationTime)';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            return 'ok';
    } else {
        if ($typeGiro == 'IN') {
            //退还扣除的款项
            $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
            $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';

            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
        }

        //更新真人转账表
        $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账失败" where  billno = \'' . $billno . '\'');
        return '转帐失败!!';
    }
}

function giro_BG($uid, $typeLive, $typeGiro, $zz_money, $all = false)
{
    if(! check_game($typeLive)) return '维护中';
    $t = check($uid, 'BGLIVE');
    if($t !== 0) return '操作过于频繁,请'.$t.'秒稍后再试';
    global $mydata1_db;
    global $site_id;
    global $cj_url;
    global $client;

    $userinfo = user::getinfo($uid);
    $str = typeName($typeLive); 

    $typeName = $str['title'];//真人平台名称
    $istype = $str['istype'];//数据库字段名--是否注册
    $zzusername = $str['zzusername'];//数据库字段名--平台帐号
    $zzpassword = $str['zzpassword'];//数据库字段名--平台密码
    $zzmoney = $str['zzmoney'];
    $zztime = $str['zztime'];
    $giroName = '转入';
    $jiajian = '扣款';
    $transferAmount = -$zz_money;


    if ($userinfo['isbg'] != 1) {//如果没有注册
        $arr = $client->liveregbg($site_id, $userinfo['username']);
        if (is_array($arr) and $arr) {
            if ($arr['info'] == 'ok') {
                $params = array(':username' => $userinfo['username'], ':bgUserName' => $arr['username'], ':bgPassWord' => $arr['password'], ':uid' => $uid);
                $sql = 'update  mydata1_db.k_user set bgUserName=:bgUserName,bgAddtime=now(),isbg=1,bgPassWord=:bgPassWord where isbg=0 and username = :username and uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);

                $userinfo = user::getinfo($uid);
            } else {
                $data['info'] = 'no';
                $data['msg'] = '注册' . $typeName . '失败!!<br><br>' . $arr['msg'];
                echo '(' . json_encode($data) . ')';
                exit;
            }
        } else {
            $data['info'] = 'no';
            $data['msg'] = '注册' . $typeName . '失败!!<br><br>请检查线路!!';
            echo '(' . json_encode($data) . ')';
            exit;
        }
    }
    //获取余额
    $arrUrl = $client->livebalancebg($site_id, $userinfo['bgUserName']);
    if (is_array($arrUrl) and $arrUrl) {
        $out_money = 0;
        if ($arrUrl['info'] == 'ok') {
            $out_money = sprintf("%.2f", $arrUrl['money']);
            $zrmoney = $out_money;
        } else {
            return '获取' . $typeName . '余额失败!!' . $arrUrl['msg'];
        }

    } else {
        return '获取' . $typeName . '余额失败!!!';
    }

    if ($typeGiro == 'IN') {//转入真人
        if ($userinfo['money'] < $zz_money) {
            return '体育/彩票额度不足!!';
        }
        $giroName = '转入';
        $jiajian = '扣款';
        $transferAmount = -$zz_money;
        $transferType = 0;
    } else if ($typeGiro == 'OUT') {//转出真人
        if ($all) {
            $zz_money = (int)$out_money;
        }

        if ($out_money < $zz_money || (int)$out_money == 0) {
        	$stmt = $mydata1_db->prepare('update k_user set ' . $zzmoney . '=:zz_money,' . $zztime . '=now() where uid=:uid');
            $stmt->execute([':zz_money' => $out_money, ':uid' => $uid]);
            return $typeName . '额度不足!!';
        }
        $giroName = '转出';
        $jiajian = '加款';
        $transferType = 1;
        $transferAmount = $zz_money;
    } else {
        return '请选择转帐类型!!';
    }

    $billno = get_billno_live();
    
    $userinfo = user::getinfo($uid);
    $moneyA = $userinfo['money'];

    if ($typeGiro == 'IN') {//预备转入提前扣款
        $q1 = pre_giro_in($uid, $zz_money, $zrmoney, $typeLive, $billno);
        if ($q1 <= 0) {
            return $typeName . '预备扣款失败!!请联系客服人员！';
        }
    }

    $json = $client->livegirobg($site_id, $userinfo['bgUserName'], $billno, $zz_money, $transferType);
    if (is_array($json) && $json['info'] == 'ok') {  
            $userinfo = user::getinfo($uid);
            if ($typeGiro == 'IN') {
                $zrmoney = $out_money + $zz_money;//计算真人余额
                $params = array(':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set ' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                }
            } else if ($typeGiro == 'OUT') {                
                $zrmoney = $out_money - $zz_money;//计算真人余额
                $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                }else{
                    //写入日志
                    $userinfo = user::getinfo($uid);
                    $moneyB = $userinfo['money'];
                    $zz_time = date('Y-m-d H:i:s');
                    $params = array(':live_type' => $typeLive, ':zz_type' => $typeGiro, ':uid' => $uid, ':username' => $userinfo['username'], ':zr_username' => $userinfo['bgUserName'], ':zz_money' => $zz_money, ':zz_time' => $zz_time, ':billno' => $billno, ':moneyA' => $moneyA, ':moneyB' => $moneyB);
                    $sql = 'insert into ag_zhenren_zz(live_type,zz_type,uid,username,zr_username,zz_money,ok,result,zz_num,zz_time,billno,moneyA,moneyB) values(:live_type,:zz_type,:uid,:username,:zr_username,:zz_money,0,"预备转账",0,:zz_time,:billno,:moneyA,:moneyB)';
                    $stmt = $mydata1_db->prepare($sql);
                    $stmt->execute($params);
                    $zzid = $mydata1_db->lastInsertId();
                }
            }
            $userinfo = user::getinfo($uid);
            $moneyB = $userinfo['money'];
            $zz_time = date('Y-m-d H:i:s');

            //更新真人转账表
            $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账成功" where  billno = \'' . $billno . '\'');

            $params = array(':uid' => $uid, ':userName' => $userinfo['username'], ':transferType' => $typeGiro, ':transferOrder' => $billno, ':transferAmount' => $transferAmount, ':previousAmount' => $moneyA, ':currentAmount' => $moneyB, ':creationTime' => $zz_time);
            $sql = 'INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) VALUE(:uid,:userName,\'' . $typeLive . '\',:transferType,:transferOrder,:transferAmount,:previousAmount,:currentAmount,:creationTime)';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            return 'ok';
    } else {
        if ($typeGiro == 'IN') {
            //退还扣除的款项
            $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
            $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';

            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
        }

        //更新真人转账表
        $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账失败" where  billno = \'' . $billno . '\'');
        return '转帐失败!!';
    }
}

function giro_SB($uid, $typeLive, $typeGiro, $zz_money, $all = false)
{
    if(! check_game($typeLive)) return '维护中';
    $t = check($uid, 'SB');
    if($t !== 0) return '操作过于频繁,请'.$t.'秒稍后再试';
    global $mydata1_db;
    global $site_id;
    global $cj_url;
    global $client;

    $userinfo = user::getinfo($uid);
    $str = typeName($typeLive); 

    $typeName = $str['title'];//真人平台名称
    $istype = $str['istype'];//数据库字段名--是否注册
    $zzusername = $str['zzusername'];//数据库字段名--平台帐号
    $zzpassword = $str['zzpassword'];//数据库字段名--平台密码
    $zzmoney = $str['zzmoney'];
    $zztime = $str['zztime'];
    $giroName = '转入';
    $jiajian = '扣款';
    $transferAmount = -$zz_money;


    if ($userinfo['issb'] != 1) {//如果没有注册
        $arr = $client->liveregsb($site_id, $userinfo['username']);
        if (is_array($arr) and $arr) {
            if ($arr['info'] == 'ok') {
                $params = array(':username' => $userinfo['username'], ':sbUserName' => $arr['username'], ':sbPassWord' => $arr['password'], ':uid' => $uid);
                $sql = 'update  mydata1_db.k_user set sbUserName=:sbUserName,sbAddtime=now(),issb=1,sbPassWord=:sbPassWord where issb=0 and username = :username and uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);

                $userinfo = user::getinfo($uid);
            } else {
                $data['info'] = 'no';
                $data['msg'] = '注册' . $typeName . '失败!!<br><br>' . $arr['msg'];
                echo '(' . json_encode($data) . ')';
                exit;
            }
        } else {
            $data['info'] = 'no';
            $data['msg'] = '注册' . $typeName . '失败!!<br><br>请检查线路!!';
            echo '(' . json_encode($data) . ')';
            exit;
        }
    }
    //获取余额
    $arrUrl = $client->livebalancesb($site_id, $userinfo['sbUserName']);
    if (is_array($arrUrl) and $arrUrl) {
        $out_money = 0;
        if ($arrUrl['info'] == 'ok') {
            $out_money = sprintf("%.2f", $arrUrl['money']);
            $zrmoney = $out_money;
        } else {
            return '获取' . $typeName . '余额失败!!' . $arrUrl['msg'];
        }

    } else {
        return '获取' . $typeName . '余额失败!!!';
    }

    if ($typeGiro == 'IN') {//转入真人
        if ($userinfo['money'] < $zz_money) {
            return '体育/彩票额度不足!!';
        }
        $giroName = '转入';
        $jiajian = '扣款';
        $transferAmount = -$zz_money;
        $transferType = 0;
    } else if ($typeGiro == 'OUT') {//转出真人
        if ($all) {
            $zz_money = (int)$out_money;
        }

        if ($out_money < $zz_money || (int)$out_money == 0) {
        	$stmt = $mydata1_db->prepare('update k_user set ' . $zzmoney . '=:zz_money,' . $zztime . '=now() where uid=:uid');
            $stmt->execute([':zz_money' => $out_money, ':uid' => $uid]);
            return $typeName . '额度不足!!';
        }
        $giroName = '转出';
        $jiajian = '加款';
        $transferType = 1;
        $transferAmount = $zz_money;
    } else {
        return '请选择转帐类型!!';
    }

    $billno = get_billno_live();
    
    $userinfo = user::getinfo($uid);
    $moneyA = $userinfo['money'];

    if ($typeGiro == 'IN') {//预备转入提前扣款
        $q1 = pre_giro_in($uid, $zz_money, $zrmoney, $typeLive, $billno);
        if ($q1 <= 0) {
            return $typeName . '预备扣款失败!!请联系客服人员！';
        }
    }

    $json = $client->livegirosb($site_id, $userinfo['sbUserName'], $billno, $zz_money, $transferType);
    if (is_array($json) && $json['info'] == 'ok') {  
            $userinfo = user::getinfo($uid);
            if ($typeGiro == 'IN') {
                $zrmoney = $out_money + $zz_money;//计算真人余额
                $params = array(':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set ' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                }
            } else if ($typeGiro == 'OUT') {                
                $zrmoney = $out_money - $zz_money;//计算真人余额
                $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                }else{
                    //写入日志
                    $userinfo = user::getinfo($uid);
                    $moneyB = $userinfo['money'];
                    $zz_time = date('Y-m-d H:i:s');
                    $params = array(':live_type' => $typeLive, ':zz_type' => $typeGiro, ':uid' => $uid, ':username' => $userinfo['username'], ':zr_username' => $userinfo['sbUserName'], ':zz_money' => $zz_money, ':zz_time' => $zz_time, ':billno' => $billno, ':moneyA' => $moneyA, ':moneyB' => $moneyB);
                    $sql = 'insert into ag_zhenren_zz(live_type,zz_type,uid,username,zr_username,zz_money,ok,result,zz_num,zz_time,billno,moneyA,moneyB) values(:live_type,:zz_type,:uid,:username,:zr_username,:zz_money,0,"预备转账",0,:zz_time,:billno,:moneyA,:moneyB)';
                    $stmt = $mydata1_db->prepare($sql);
                    $stmt->execute($params);
                    $zzid = $mydata1_db->lastInsertId();
                }
            }
            $userinfo = user::getinfo($uid);
            $moneyB = $userinfo['money'];
            $zz_time = date('Y-m-d H:i:s');

            //更新真人转账表
            $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账成功" where  billno = \'' . $billno . '\'');

            $params = array(':uid' => $uid, ':userName' => $userinfo['username'], ':transferType' => $typeGiro, ':transferOrder' => $billno, ':transferAmount' => $transferAmount, ':previousAmount' => $moneyA, ':currentAmount' => $moneyB, ':creationTime' => $zz_time);
            $sql = 'INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) VALUE(:uid,:userName,\'' . $typeLive . '\',:transferType,:transferOrder,:transferAmount,:previousAmount,:currentAmount,:creationTime)';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            return 'ok';
    } else {
        if ($typeGiro == 'IN') {
            //退还扣除的款项
            $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
            $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';

            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
        }

        //更新真人转账表
        $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账失败" where  billno = \'' . $billno . '\'');
        return '转帐失败!!';
    }
}

function giro_PT2($uid, $typeLive, $typeGiro, $zz_money, $all = false)
{
    if(! check_game($typeLive)) return '维护中';
    $t = check($uid, 'PT2');
    if($t !== 0) return '操作过于频繁,请'.$t.'秒稍后再试';
    global $mydata1_db;
    global $site_id;
    global $cj_url;
    global $client;

    $userinfo = user::getinfo($uid);
    $str = typeName($typeLive); 

    $typeName = $str['title'];//真人平台名称
    $istype = $str['istype'];//数据库字段名--是否注册
    $zzusername = $str['zzusername'];//数据库字段名--平台帐号
    $zzpassword = $str['zzpassword'];//数据库字段名--平台密码
    $zzmoney = $str['zzmoney'];
    $zztime = $str['zztime'];
    $giroName = '转入';
    $jiajian = '扣款';
    $transferAmount = -$zz_money;


    if ($userinfo['ispt2'] != 1) {//如果没有注册
        $arr = $client->liveregpt($site_id, $userinfo['username']);
        if (is_array($arr) and $arr) {
            if ($arr['info'] == 'ok') {
                $params = array(':username' => $userinfo['username'], ':pt2UserName' => $arr['username'], ':pt2PassWord' => $arr['password'], ':uid' => $uid);
                $sql = 'update  mydata1_db.k_user set pt2UserName=:pt2UserName,pt2Addtime=now(),ispt2=1,pt2PassWord=:pt2PassWord where ispt2=0 and username = :username and uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);

                $userinfo = user::getinfo($uid);
            } else {
                $data['info'] = 'no';
                $data['msg'] = '注册' . $typeName . '失败!!<br><br>' . $arr['msg'];
                echo '(' . json_encode($data) . ')';
                exit;
            }
        } else {
            $data['info'] = 'no';
            $data['msg'] = '注册' . $typeName . '失败!!<br><br>请检查线路!!';
            echo '(' . json_encode($data) . ')';
            exit;
        }
    }
    //获取余额
    $arrUrl = $client->livebalancept($site_id, $userinfo['pt2UserName']);
    if (is_array($arrUrl) and $arrUrl) {
        $out_money = 0;
        if ($arrUrl['info'] == 'ok') {
            $out_money = sprintf("%.2f", $arrUrl['money']);
            $zrmoney = $out_money;
        } else {
            return '获取' . $typeName . '余额失败!!' . $arrUrl['msg'];
        }

    } else {
        return '获取' . $typeName . '余额失败!!!';
    }

    if ($typeGiro == 'IN') {//转入真人
        if ($userinfo['money'] < $zz_money) {
            return '体育/彩票额度不足!!';
        }
        $giroName = '转入';
        $jiajian = '扣款';
        $transferAmount = -$zz_money;
        $transferType = 0;
    } else if ($typeGiro == 'OUT') {//转出真人
        if ($all) {
            $zz_money = (int)$out_money;
        }

        if ($out_money < $zz_money || (int)$out_money == 0) {
        	$stmt = $mydata1_db->prepare('update k_user set ' . $zzmoney . '=:zz_money,' . $zztime . '=now() where uid=:uid');
            $stmt->execute([':zz_money' => $out_money, ':uid' => $uid]);
            return $typeName . '额度不足!!';
        }
        $giroName = '转出';
        $jiajian = '加款';
        $transferType = 1;
        $transferAmount = $zz_money;
    } else {
        return '请选择转帐类型!!';
    }

    $billno = get_billno_live();
    
    $userinfo = user::getinfo($uid);
    $moneyA = $userinfo['money'];

    if ($typeGiro == 'IN') {//预备转入提前扣款
        $q1 = pre_giro_in($uid, $zz_money, $zrmoney, $typeLive, $billno);
        if ($q1 <= 0) {
            return $typeName . '预备扣款失败!!请联系客服人员！';
        }
    }

    $json = $client->livegiropt($site_id, $userinfo['pt2UserName'], $billno, $zz_money, $transferType);
    if (is_array($json) && $json['info'] == 'ok') {  
            $userinfo = user::getinfo($uid);
            if ($typeGiro == 'IN') {
                $zrmoney = $out_money + $zz_money;//计算真人余额
                $params = array(':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set ' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                }
            } else if ($typeGiro == 'OUT') {                
                $zrmoney = $out_money - $zz_money;//计算真人余额
                $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                }else{
                    //写入日志
                    $userinfo = user::getinfo($uid);
                    $moneyB = $userinfo['money'];
                    $zz_time = date('Y-m-d H:i:s');
                    $params = array(':live_type' => $typeLive, ':zz_type' => $typeGiro, ':uid' => $uid, ':username' => $userinfo['username'], ':zr_username' => $userinfo['pt2UserName'], ':zz_money' => $zz_money, ':zz_time' => $zz_time, ':billno' => $billno, ':moneyA' => $moneyA, ':moneyB' => $moneyB);
                    $sql = 'insert into ag_zhenren_zz(live_type,zz_type,uid,username,zr_username,zz_money,ok,result,zz_num,zz_time,billno,moneyA,moneyB) values(:live_type,:zz_type,:uid,:username,:zr_username,:zz_money,0,"预备转账",0,:zz_time,:billno,:moneyA,:moneyB)';
                    $stmt = $mydata1_db->prepare($sql);
                    $stmt->execute($params);
                    $zzid = $mydata1_db->lastInsertId();
                }
            }
            $userinfo = user::getinfo($uid);
            $moneyB = $userinfo['money'];
            $zz_time = date('Y-m-d H:i:s');

            //更新真人转账表
            $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账成功" where  billno = \'' . $billno . '\'');

            $params = array(':uid' => $uid, ':userName' => $userinfo['username'], ':transferType' => $typeGiro, ':transferOrder' => $billno, ':transferAmount' => $transferAmount, ':previousAmount' => $moneyA, ':currentAmount' => $moneyB, ':creationTime' => $zz_time);
            $sql = 'INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) VALUE(:uid,:userName,\'' . $typeLive . '\',:transferType,:transferOrder,:transferAmount,:previousAmount,:currentAmount,:creationTime)';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            return 'ok';
    } else {
        if ($typeGiro == 'IN') {
            //退还扣除的款项
            $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
            $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';

            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
        }

        //更新真人转账表
        $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账失败" where  billno = \'' . $billno . '\'');
        return '转帐失败!!';
    }
}

function giro_OG2($uid, $typeLive, $typeGiro, $zz_money, $all = false)
{
    if(! check_game($typeLive)) return '维护中';
    $t = check($uid, 'OG2');
    if($t !== 0) return '操作过于频繁,请'.$t.'秒稍后再试';
    global $mydata1_db;
    global $site_id;
    global $cj_url;
    global $client;

    $userinfo = user::getinfo($uid);
    $str = typeName($typeLive); 

    $typeName = $str['title'];//真人平台名称
    $istype = $str['istype'];//数据库字段名--是否注册
    $zzusername = $str['zzusername'];//数据库字段名--平台帐号
    $zzpassword = $str['zzpassword'];//数据库字段名--平台密码
    $zzmoney = $str['zzmoney'];
    $zztime = $str['zztime'];
    $giroName = '转入';
    $jiajian = '扣款';
    $transferAmount = -$zz_money;


    if ($userinfo['isog2'] != 1) {//如果没有注册
        $arr = $client->liveregog($site_id, $userinfo['username']);
        if (is_array($arr) and $arr) {
            if ($arr['info'] == 'ok') {
                $params = array(':username' => $userinfo['username'], ':og2UserName' => $arr['username'], ':og2PassWord' => $arr['password'], ':uid' => $uid);
                $sql = 'update  mydata1_db.k_user set og2UserName=:og2UserName,og2Addtime=now(),isog2=1,og2PassWord=:og2PassWord where isog2=0 and username = :username and uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);

                $userinfo = user::getinfo($uid);
            } else {
                $data['info'] = 'no';
                $data['msg'] = '注册' . $typeName . '失败!!<br><br>' . $arr['msg'];
                echo '(' . json_encode($data) . ')';
                exit;
            }
        } else {
            $data['info'] = 'no';
            $data['msg'] = '注册' . $typeName . '失败!!<br><br>请检查线路!!';
            echo '(' . json_encode($data) . ')';
            exit;
        }
    }
    //获取余额
    $arrUrl = $client->livebalanceog($site_id, $userinfo['og2UserName']);
    if (is_array($arrUrl) and $arrUrl) {
        $out_money = 0;
        if ($arrUrl['info'] == 'ok') {
            $out_money = sprintf("%.2f", $arrUrl['money']);
            $zrmoney = $out_money;
        } else {
            return '获取' . $typeName . '余额失败!!' . $arrUrl['msg'];
        }

    } else {
        return '获取' . $typeName . '余额失败!!!';
    }

    if ($typeGiro == 'IN') {//转入真人
        if ($userinfo['money'] < $zz_money) {
            return '体育/彩票额度不足!!';
        }
        $giroName = '转入';
        $jiajian = '扣款';
        $transferAmount = -$zz_money;
        $transferType = 0;
    } else if ($typeGiro == 'OUT') {//转出真人
        if ($all) {
            $zz_money = (int)$out_money;
        }

        if ($out_money < $zz_money || (int)$out_money == 0) {
        	$stmt = $mydata1_db->prepare('update k_user set ' . $zzmoney . '=:zz_money,' . $zztime . '=now() where uid=:uid');
            $stmt->execute([':zz_money' => $out_money, ':uid' => $uid]);
            return $typeName . '额度不足!!';
        }
        $giroName = '转出';
        $jiajian = '加款';
        $transferType = 1;
        $transferAmount = $zz_money;
    } else {
        return '请选择转帐类型!!';
    }

    $billno = get_billno_live();
    
    $userinfo = user::getinfo($uid);
    $moneyA = $userinfo['money'];

    if ($typeGiro == 'IN') {//预备转入提前扣款
        $q1 = pre_giro_in($uid, $zz_money, $zrmoney, $typeLive, $billno);
        if ($q1 <= 0) {
            return $typeName . '预备扣款失败!!请联系客服人员！';
        }
    }

    $json = $client->livegiroog($site_id, $userinfo['og2UserName'], $billno, $zz_money, $transferType);
    if (is_array($json) && $json['info'] == 'ok') {  
            $userinfo = user::getinfo($uid);
            if ($typeGiro == 'IN') {
                $zrmoney = $out_money + $zz_money;//计算真人余额
                $params = array(':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set ' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                }
            } else if ($typeGiro == 'OUT') {                
                $zrmoney = $out_money - $zz_money;//计算真人余额
                $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                }else{
                    //写入日志
                    $userinfo = user::getinfo($uid);
                    $moneyB = $userinfo['money'];
                    $zz_time = date('Y-m-d H:i:s');
                    $params = array(':live_type' => $typeLive, ':zz_type' => $typeGiro, ':uid' => $uid, ':username' => $userinfo['username'], ':zr_username' => $userinfo['og2UserName'], ':zz_money' => $zz_money, ':zz_time' => $zz_time, ':billno' => $billno, ':moneyA' => $moneyA, ':moneyB' => $moneyB);
                    $sql = 'insert into ag_zhenren_zz(live_type,zz_type,uid,username,zr_username,zz_money,ok,result,zz_num,zz_time,billno,moneyA,moneyB) values(:live_type,:zz_type,:uid,:username,:zr_username,:zz_money,0,"预备转账",0,:zz_time,:billno,:moneyA,:moneyB)';
                    $stmt = $mydata1_db->prepare($sql);
                    $stmt->execute($params);
                    $zzid = $mydata1_db->lastInsertId();
                }
            }
            $userinfo = user::getinfo($uid);
            $moneyB = $userinfo['money'];
            $zz_time = date('Y-m-d H:i:s');

            //更新真人转账表
            $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账成功" where  billno = \'' . $billno . '\'');

            $params = array(':uid' => $uid, ':userName' => $userinfo['username'], ':transferType' => $typeGiro, ':transferOrder' => $billno, ':transferAmount' => $transferAmount, ':previousAmount' => $moneyA, ':currentAmount' => $moneyB, ':creationTime' => $zz_time);
            $sql = 'INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) VALUE(:uid,:userName,\'' . $typeLive . '\',:transferType,:transferOrder,:transferAmount,:previousAmount,:currentAmount,:creationTime)';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            return 'ok';
    } else {
        if ($typeGiro == 'IN') {
            //退还扣除的款项
            $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
            $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';

            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
        }

        //更新真人转账表
        $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账失败" where  billno = \'' . $billno . '\'');
        return '转帐失败!!';
    }
}


function giro_DG($uid, $typeLive, $typeGiro, $zz_money, $all = false)
{
    if(! check_game($typeLive)) return '维护中';
    $t = check($uid, 'DG');
    if($t !== 0) return '操作过于频繁,请'.$t.'秒稍后再试';
    global $mydata1_db;
    global $site_id;
    global $cj_url;
    global $client;

    $userinfo = user::getinfo($uid);
    $str = typeName($typeLive); 

    $typeName = $str['title'];//真人平台名称
    $istype = $str['istype'];//数据库字段名--是否注册
    $zzusername = $str['zzusername'];//数据库字段名--平台帐号
    $zzpassword = $str['zzpassword'];//数据库字段名--平台密码
    $zzmoney = $str['zzmoney'];
    $zztime = $str['zztime'];
    $giroName = '转入';
    $jiajian = '扣款';
    $transferAmount = -$zz_money;


    if ($userinfo['isdg'] != 1) {//如果没有注册
        $arr = $client->liveregdg($site_id, $userinfo['username']);
        if (is_array($arr) and $arr) {
            if ($arr['info'] == 'ok') {
                $params = array(':username' => $userinfo['username'], ':dgUserName' => $arr['username'], ':dgPassWord' => $arr['password'], ':uid' => $uid);
                $sql = 'update  mydata1_db.k_user set dgUserName=:dgUserName,dgAddtime=now(),isdg=1,dgPassWord=:dgPassWord where isdg=0 and username = :username and uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);

                $userinfo = user::getinfo($uid);
            } else {
                $data['info'] = 'no';
                $data['msg'] = '注册' . $typeName . '失败!!<br><br>' . $arr['msg'];
                echo '(' . json_encode($data) . ')';
                exit;
            }
        } else {
            $data['info'] = 'no';
            $data['msg'] = '注册' . $typeName . '失败!!<br><br>请检查线路!!';
            echo '(' . json_encode($data) . ')';
            exit;
        }
    }
    //获取余额
    $arrUrl = $client->livebalancedg($site_id, $userinfo['dgUserName']);
    if (is_array($arrUrl) and $arrUrl) {
        $out_money = 0;
        if ($arrUrl['info'] == 'ok') {
            $out_money = sprintf("%.2f", $arrUrl['money']);
            $zrmoney = $out_money;
        } else {
            return '获取' . $typeName . '余额失败!!' . $arrUrl['msg'];
        }

    } else {
        return '获取' . $typeName . '余额失败!!!';
    }

    if ($typeGiro == 'IN') {//转入真人
        if ($userinfo['money'] < $zz_money) {
            return '体育/彩票额度不足!!';
        }
        $giroName = '转入';
        $jiajian = '扣款';
        $transferAmount = -$zz_money;
        $transferType = 0;
    } else if ($typeGiro == 'OUT') {//转出真人
        if ($all) {
            $zz_money = (int)$out_money;
        }

        if ($out_money < $zz_money || (int)$out_money == 0) {
            $stmt = $mydata1_db->prepare('update k_user set ' . $zzmoney . '=:zz_money,' . $zztime . '=now() where uid=:uid');
            $stmt->execute([':zz_money' => $out_money, ':uid' => $uid]);
            return $typeName . '额度不足!!';
        }
        $giroName = '转出';
        $jiajian = '加款';
        $transferType = 1;
        $transferAmount = $zz_money;
    } else {
        return '请选择转帐类型!!';
    }

    $billno = get_billno_live();
    
    $userinfo = user::getinfo($uid);
    $moneyA = $userinfo['money'];

    if ($typeGiro == 'IN') {//预备转入提前扣款
        $q1 = pre_giro_in($uid, $zz_money, $zrmoney, $typeLive, $billno);
        if ($q1 <= 0) {
            return $typeName . '预备扣款失败!!请联系客服人员！';
        }
    }

    $json = $client->livegirodg($site_id, $userinfo['dgUserName'], $billno, $zz_money, $transferType);
    if (is_array($json) && $json['info'] == 'ok') {  
            $userinfo = user::getinfo($uid);
            if ($typeGiro == 'IN') {
                $zrmoney = $out_money + $zz_money;//计算真人余额
                $params = array(':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set ' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                }
            } else if ($typeGiro == 'OUT') {                
                $zrmoney = $out_money - $zz_money;//计算真人余额
                $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                }else{
                    //写入日志
                    $userinfo = user::getinfo($uid);
                    $moneyB = $userinfo['money'];
                    $zz_time = date('Y-m-d H:i:s');
                    $params = array(':live_type' => $typeLive, ':zz_type' => $typeGiro, ':uid' => $uid, ':username' => $userinfo['username'], ':zr_username' => $userinfo['dgUserName'], ':zz_money' => $zz_money, ':zz_time' => $zz_time, ':billno' => $billno, ':moneyA' => $moneyA, ':moneyB' => $moneyB);
                    $sql = 'insert into ag_zhenren_zz(live_type,zz_type,uid,username,zr_username,zz_money,ok,result,zz_num,zz_time,billno,moneyA,moneyB) values(:live_type,:zz_type,:uid,:username,:zr_username,:zz_money,0,"预备转账",0,:zz_time,:billno,:moneyA,:moneyB)';
                    $stmt = $mydata1_db->prepare($sql);
                    $stmt->execute($params);
                    $zzid = $mydata1_db->lastInsertId();
                }
            }
            $userinfo = user::getinfo($uid);
            $moneyB = $userinfo['money'];
            $zz_time = date('Y-m-d H:i:s');

            //更新真人转账表
            $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账成功" where  billno = \'' . $billno . '\'');

            $params = array(':uid' => $uid, ':userName' => $userinfo['username'], ':transferType' => $typeGiro, ':transferOrder' => $billno, ':transferAmount' => $transferAmount, ':previousAmount' => $moneyA, ':currentAmount' => $moneyB, ':creationTime' => $zz_time);
            $sql = 'INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) VALUE(:uid,:userName,\'' . $typeLive . '\',:transferType,:transferOrder,:transferAmount,:previousAmount,:currentAmount,:creationTime)';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            return 'ok';
    } else {
        if ($typeGiro == 'IN') {
            //退还扣除的款项
            $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
            $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';

            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
        }

        //更新真人转账表
        $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账失败" where  billno = \'' . $billno . '\'');
        return '转帐失败!!';
    }
}


function giro_KY($uid, $typeLive, $typeGiro, $zz_money, $all = false)
{
    if(! check_game($typeLive)) return '维护中';
    $t = check($uid, 'KY');
    if($t !== 0) return '操作过于频繁,请'.$t.'秒稍后再试';
    global $mydata1_db;
    global $site_id;
    global $cj_url;
    global $client;

    $userinfo = user::getinfo($uid);
    $str = typeName($typeLive); 

    $typeName = $str['title'];//真人平台名称
    $istype = $str['istype'];//数据库字段名--是否注册
    $zzusername = $str['zzusername'];//数据库字段名--平台帐号
    $zzpassword = $str['zzpassword'];//数据库字段名--平台密码
    $zzmoney = $str['zzmoney'];
    $zztime = $str['zztime'];
    $giroName = '转入';
    $jiajian = '扣款';
    $transferAmount = -$zz_money;


    if ($userinfo['isky'] != 1) {//如果没有注册
        $arr = $client->liveregky($site_id, $userinfo['username']);
        if (is_array($arr) and $arr) {
            if ($arr['info'] == 'ok') {
                $params = array(':username' => $userinfo['username'], ':kyUserName' => $arr['username'], ':kyPassWord' => $arr['password'], ':uid' => $uid);
                $sql = 'update  mydata1_db.k_user set kyUserName=:kyUserName,kyAddtime=now(),isky=1,kyPassWord=:kyPassWord where isky=0 and username = :username and uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);

                $userinfo = user::getinfo($uid);
            } else {
                $data['info'] = 'no';
                $data['msg'] = '注册' . $typeName . '失败!!<br><br>' . $arr['msg'];
                echo '(' . json_encode($data) . ')';
                exit;
            }
        } else {
            $data['info'] = 'no';
            $data['msg'] = '注册' . $typeName . '失败!!<br><br>请检查线路!!';
            echo '(' . json_encode($data) . ')';
            exit;
        }
    }
    //获取余额
    $arrUrl = $client->livebalanceky($site_id, $userinfo['kyUserName']);
    if (is_array($arrUrl) and $arrUrl) {
        $out_money = 0;
        if ($arrUrl['info'] == 'ok') {
            $out_money = sprintf("%.2f", $arrUrl['money']);
            $zrmoney = $out_money;
        } else {
            return '获取' . $typeName . '余额失败!!' . $arrUrl['msg'];
        }

    } else {
        return '获取' . $typeName . '余额失败!!!';
    }

    if ($typeGiro == 'IN') {//转入真人
        if ($userinfo['money'] < $zz_money) {
            return '体育/彩票额度不足!!';
        }
        $giroName = '转入';
        $jiajian = '扣款';
        $transferAmount = -$zz_money;
        $transferType = 0;
    } else if ($typeGiro == 'OUT') {//转出真人
        if ($all) {
            $zz_money = (int)$out_money;
        }

        if ($out_money < $zz_money || (int)$out_money == 0) {
            $stmt = $mydata1_db->prepare('update k_user set ' . $zzmoney . '=:zz_money,' . $zztime . '=now() where uid=:uid');
            $stmt->execute([':zz_money' => $out_money, ':uid' => $uid]);
            return $typeName . '额度不足!!';
        }
        $giroName = '转出';
        $jiajian = '加款';
        $transferType = 1;
        $transferAmount = $zz_money;
    } else {
        return '请选择转帐类型!!';
    }

    $billno = get_billno_live();
    
    $userinfo = user::getinfo($uid);
    $moneyA = $userinfo['money'];

    if ($typeGiro == 'IN') {//预备转入提前扣款
        $q1 = pre_giro_in($uid, $zz_money, $zrmoney, $typeLive, $billno);
        if ($q1 <= 0) {
            return $typeName . '预备扣款失败!!请联系客服人员！';
        }
    }

    $json = $client->livegiroky($site_id, $userinfo['kyUserName'], $zz_money, $transferType);
    if (is_array($json) && $json['info'] == 'ok') {  
            $userinfo = user::getinfo($uid);
            if ($typeGiro == 'IN') {
                $zrmoney = $out_money + $zz_money;//计算真人余额
                $params = array(':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set ' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                }
            } else if ($typeGiro == 'OUT') {                
                $zrmoney = $out_money - $zz_money;//计算真人余额
                $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                }else{
                    //写入日志
                    $userinfo = user::getinfo($uid);
                    $moneyB = $userinfo['money'];
                    $zz_time = date('Y-m-d H:i:s');
                    $params = array(':live_type' => $typeLive, ':zz_type' => $typeGiro, ':uid' => $uid, ':username' => $userinfo['username'], ':zr_username' => $userinfo['kyUserName'], ':zz_money' => $zz_money, ':zz_time' => $zz_time, ':billno' => $billno, ':moneyA' => $moneyA, ':moneyB' => $moneyB);
                    $sql = 'insert into ag_zhenren_zz(live_type,zz_type,uid,username,zr_username,zz_money,ok,result,zz_num,zz_time,billno,moneyA,moneyB) values(:live_type,:zz_type,:uid,:username,:zr_username,:zz_money,0,"预备转账",0,:zz_time,:billno,:moneyA,:moneyB)';
                    $stmt = $mydata1_db->prepare($sql);
                    $stmt->execute($params);
                    $zzid = $mydata1_db->lastInsertId();
                }
            }
            $userinfo = user::getinfo($uid);
            $moneyB = $userinfo['money'];
            $zz_time = date('Y-m-d H:i:s');

            //更新真人转账表
            $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账成功" where  billno = \'' . $billno . '\'');

            $params = array(':uid' => $uid, ':userName' => $userinfo['username'], ':transferType' => $typeGiro, ':transferOrder' => $billno, ':transferAmount' => $transferAmount, ':previousAmount' => $moneyA, ':currentAmount' => $moneyB, ':creationTime' => $zz_time);
            $sql = 'INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) VALUE(:uid,:userName,\'' . $typeLive . '\',:transferType,:transferOrder,:transferAmount,:previousAmount,:currentAmount,:creationTime)';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            return 'ok';
    } else {
        if ($typeGiro == 'IN') {
            //退还扣除的款项
            $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
            $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';

            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
        }

        //更新真人转账表
        $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账失败" where  billno = \'' . $billno . '\'');
        return '转帐失败!!';
    }
}


function giro_BBIN2($uid, $typeLive, $typeGiro, $zz_money, $all = false)
{
    if(! check_game($typeLive)) return '维护中';
    $t = check($uid, 'BBIN2');
    if($t !== 0) return '操作过于频繁,请'.$t.'秒稍后再试';
    global $mydata1_db;
    global $site_id;
    global $cj_url;
    global $client;

    $userinfo = user::getinfo($uid);
    $str = typeName($typeLive); 

    $typeName = $str['title'];//真人平台名称
    $istype = $str['istype'];//数据库字段名--是否注册
    $zzusername = $str['zzusername'];//数据库字段名--平台帐号
    $zzpassword = $str['zzpassword'];//数据库字段名--平台密码
    $zzmoney = $str['zzmoney'];
    $zztime = $str['zztime'];
    $giroName = '转入';
    $jiajian = '扣款';
    $transferAmount = -$zz_money;


    if ($userinfo['isbbin2'] != 1) {//如果没有注册
        $arr = $client->liveregbbin($site_id, $userinfo['username']);
        if (is_array($arr) and $arr) {
            if ($arr['info'] == 'ok') {
                $params = array(':username' => $userinfo['username'], ':bbin2UserName' => $arr['username'], ':bbin2PassWord' => $arr['password'], ':uid' => $uid);
                $sql = 'update  mydata1_db.k_user set bbin2UserName=:bbin2UserName,bbin2Addtime=now(),isbbin2=1,bbin2PassWord=:bbin2PassWord where isbbin2=0 and username = :username and uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);

                $userinfo = user::getinfo($uid);
            } else {
                $data['info'] = 'no';
                $data['msg'] = '注册' . $typeName . '失败!!<br><br>' . $arr['msg'];
                echo '(' . json_encode($data) . ')';
                exit;
            }
        } else {
            $data['info'] = 'no';
            $data['msg'] = '注册' . $typeName . '失败!!<br><br>请检查线路!!';
            echo '(' . json_encode($data) . ')';
            exit;
        }
    }
    //获取余额
    $arrUrl = $client->livebalancebbin($site_id, $userinfo['bbin2UserName']);
    if (is_array($arrUrl) and $arrUrl) {
        $out_money = 0;
        if ($arrUrl['info'] == 'ok') {
            $out_money = sprintf("%.2f", $arrUrl['money']);
            $zrmoney = $out_money;
        } else {
            return '获取' . $typeName . '余额失败!!' . $arrUrl['msg'];
        }

    } else {
        return '获取' . $typeName . '余额失败!!!';
    }

    if ($typeGiro == 'IN') {//转入真人
        if ($userinfo['money'] < $zz_money) {
            return '体育/彩票额度不足!!';
        }
        $giroName = '转入';
        $jiajian = '扣款';
        $transferAmount = -$zz_money;
        $transferType = 0;
    } else if ($typeGiro == 'OUT') {//转出真人
        if ($all) {
            $zz_money = (int)$out_money;
        }

        if ($out_money < $zz_money || (int)$out_money == 0) {
            $stmt = $mydata1_db->prepare('update k_user set ' . $zzmoney . '=:zz_money,' . $zztime . '=now() where uid=:uid');
            $stmt->execute([':zz_money' => $out_money, ':uid' => $uid]);
            return $typeName . '额度不足!!';
        }
        $giroName = '转出';
        $jiajian = '加款';
        $transferType = 1;
        $transferAmount = $zz_money;
    } else {
        return '请选择转帐类型!!';
    }

    $billno = get_billno_live();
    
    $userinfo = user::getinfo($uid);
    $moneyA = $userinfo['money'];

    if ($typeGiro == 'IN') {//预备转入提前扣款
        $q1 = pre_giro_in($uid, $zz_money, $zrmoney, $typeLive, $billno);
        if ($q1 <= 0) {
            return $typeName . '预备扣款失败!!请联系客服人员！';
        }
    }

    $json = $client->livegirobbin($site_id, $userinfo['bbin2UserName'], $billno ,$zz_money, $transferType);
    //echo $userinfo['bbin2UserName'].''.$zz_money.
    //print_r($json);die();
    if (is_array($json) && $json['info'] == 'ok') {  
            $userinfo = user::getinfo($uid);
            if ($typeGiro == 'IN') {
                $zrmoney = $out_money + $zz_money;//计算真人余额
                $params = array(':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set ' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                }
            } else if ($typeGiro == 'OUT') {                
                $zrmoney = $out_money - $zz_money;//计算真人余额
                $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
                $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0) {
                    return $typeName . '扣款失败引起' . $giroName . '失败!!请联系客服人员！';
                }else{
                    //写入日志
                    $userinfo = user::getinfo($uid);
                    $moneyB = $userinfo['money'];
                    $zz_time = date('Y-m-d H:i:s');
                    $params = array(':live_type' => $typeLive, ':zz_type' => $typeGiro, ':uid' => $uid, ':username' => $userinfo['username'], ':zr_username' => $userinfo['bbin2UserName'], ':zz_money' => $zz_money, ':zz_time' => $zz_time, ':billno' => $billno, ':moneyA' => $moneyA, ':moneyB' => $moneyB);
                    $sql = 'insert into ag_zhenren_zz(live_type,zz_type,uid,username,zr_username,zz_money,ok,result,zz_num,zz_time,billno,moneyA,moneyB) values(:live_type,:zz_type,:uid,:username,:zr_username,:zz_money,0,"预备转账",0,:zz_time,:billno,:moneyA,:moneyB)';
                    $stmt = $mydata1_db->prepare($sql);
                    $stmt->execute($params);
                    $zzid = $mydata1_db->lastInsertId();
                }
            }
            $userinfo = user::getinfo($uid);
            $moneyB = $userinfo['money'];
            $zz_time = date('Y-m-d H:i:s');

            //更新真人转账表
            $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账成功" where  billno = \'' . $billno . '\'');

            $params = array(':uid' => $uid, ':userName' => $userinfo['username'], ':transferType' => $typeGiro, ':transferOrder' => $billno, ':transferAmount' => $transferAmount, ':previousAmount' => $moneyA, ':currentAmount' => $moneyB, ':creationTime' => $zz_time);
            $sql = 'INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) VALUE(:uid,:userName,\'' . $typeLive . '\',:transferType,:transferOrder,:transferAmount,:previousAmount,:currentAmount,:creationTime)';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            return 'ok';
    } else {
        if ($typeGiro == 'IN') {
            //退还扣除的款项
            $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zrmoney' => $zrmoney);
            $sql = 'update k_user set money=money+:zz_money,' . $zzmoney . '=:zrmoney,' . $zztime . '=now() where uid=:uid';

            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
        }

        //更新真人转账表
        $mydata1_db->query('update ag_zhenren_zz set ok=1,result="转账失败" where  billno = \'' . $billno . '\'');
        return '转帐失败!!';
    }
}

function get_billno_live()
{
    return date('ymdHis') . substr(microtime(), 2, 3) . rand(1, 9);
}

function zrmoneyName($type)
{

}

function getZrInfo($type){
    switch ($type) {
        case 'AGIN':
            return [
                'zrname' => 'agUserName',
                'zrmoney' => 'agmoney',
                'zrtime' => 'agAddtime'
                ];
        case 'AG':
            return [
                'zrname' => 'agqUserName',
                'zrmoney' => 'agqmoney',
                'zrtime' => 'agqAddtime'
                ];
        case 'BBIN':
            return [
                'zrname' => 'bbinUserName',
                'zrmoney' => 'bbmoney',
                'zrtime' => 'bbinAddtime'
                ];
        case 'OG':
            return [
                'zrname' => 'ogUserName',
                'zrmoney' => 'ogmoney',
                'zrtime' => 'ogAddtime'
                ];
        case 'MG':
            return [
                'zrname' => 'mgUserName',
                'zrmoney' => 'mgmoney',
                'zrtime' => 'mgAddtime'
                ];
        case 'SHABA':
            return [
                'zrname' => 'shabaUserName',
                'zrmoney' => 'shabamoney',
                'zrtime' => 'shabaAddtime'
                ];
        case 'PT':
            return [
                'zrname' => 'ptUserName',
                'zrmoney' => 'ptmoney',
                'zrtime' => 'ptAddtime'
                ];
        case 'MAYA':
            return [
                'zrname' => 'mayaUserName',
                'zrmoney' => 'mayamoney',
                'zrtime' => 'mayaAddtime'
                ];
        case 'MW':
            return [
                'zrname' => 'mwUserName',
                'zrmoney' => 'mwmoney',
                'zrtime' => 'mwAddtime'
                ];
        case 'KG':
            return [
                'zrname' => 'kgUserName',
                'zrmoney' => 'kgmoney',
                'zrtime' => 'kgAddtime'
                ];
        case 'IPM':
            return [
                'zrname' => 'ipmUserName',
                'zrmoney' => 'ipmmoney',
                'zrtime' => 'ipmAddtime'
                ];
        case 'CQ9':
            return [
                'zrname' => 'cq9UserName',
                'zrmoney' => 'cq9money',
                'zrtime' => 'cq9Addtime'
                ];
        case 'MG2':
            return [
                'zrname' => 'mg2UserName',
                'zrmoney' => 'mg2money',
                'zrtime' => 'mg2Addtime'
                ];
        case 'VR':
            return [
                'zrname' => 'vrUserName',
                'zrmoney' => 'vrmoney',
                'zrtime' => 'vrAddtime'
                ];
        case 'BGLIVE':
            return [
                'zrname' => 'bgUserName',
                'zrmoney' => 'bgmoney',
                'zrtime' => 'bgAddtime'
                ];
        case 'SB':
            return [
                'zrname' => 'sbUserName',
                'zrmoney' => 'sbmoney',
                'zrtime' => 'sbAddtime'
                ];
        case 'PT2':
            return [
                'zrname' => 'pt2UserName',
                'zrmoney' => 'pt2money',
                'zrtime' => 'pt2Addtime'
                ];
        case 'OG2':
            return [
                'zrname' => 'og2UserName',
                'zrmoney' => 'og2money',
                'zrtime' => 'og2Addtime'
                ];
        case 'DG':
            return [
                'zrname' => 'dgUserName',
                'zrmoney' => 'dgmoney',
                'zrtime' => 'dgAddtime'
                ];
        case 'KY':
            return [
                'zrname' => 'kyUserName',
                'zrmoney' => 'kymoney',
                'zrtime' => 'kyAddtime'
                ];
        case 'BBIN2':
            return [
                'zrname' => 'bbin2UserName',
                'zrmoney' => 'bbin2money',
                'zrtime' => 'bbin2Addtime'
                ];
        default:
            die('ERROR');
    }
}

/**
 * [pre_giro description]
 * @param  [type] $uid      [description]
 * @param  [type] $zz_money [description]
 * @param  [type] $zrmoney  [description]
 * @param  [type] $typeLive [description]
 * @param  [type] $billno   [description]
 * @return [int]           [description]
 */
function pre_giro_in($uid, $zz_money, $zrmoney, $typeLive, $billno){
    global $mydata1_db;
    $userinfo = user::getinfo($uid);
    $moneyA = $userinfo['money'];
    $zrinfo = getZrInfo($typeLive);
    $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zz_money2' => $zz_money, ':zrmoney' => $zrmoney);
    $sql = 'update k_user set money=money-:zz_money,' . $zrinfo['zrmoney'] . '=:zrmoney,' . $zrinfo['zrtime'] . '=now() where uid=:uid and money>=:zz_money2';  
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    $q1 = $stmt->rowCount();  
    if ($q1 <= 0) {
        return $q1;
    }else{
        $userinfo = user::getinfo($uid);
        $moneyB = $userinfo['money'];
        $zz_time = date('Y-m-d H:i:s');
        $params = array(':live_type' => $typeLive, ':uid' => $uid, ':username' => $userinfo['username'], ':zr_username' => $userinfo[$zrinfo['zrname']], ':zz_money' => $zz_money, ':zz_time' => $zz_time, ':billno' => $billno, ':moneyA' => $moneyA, ':moneyB' => $moneyB);
        $sql = 'insert into ag_zhenren_zz(live_type,zz_type,uid,username,zr_username,zz_money,ok,result,zz_num,zz_time,billno,moneyA,moneyB) values(:live_type,"IN",:uid,:username,:zr_username,:zz_money,0,"预备转账",0,:zz_time,:billno,:moneyA,:moneyB)';
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        return $mydata1_db->lastInsertId();
    }
}

function check($uid, $type){
    global $mydata1_db;
    $sql = 'select max(`zz_time`) from ag_zhenren_zz where uid=:uid and live_type=:type';
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute([':uid'=>$uid, ':type'=>$type]);
    $date = $stmt->fetch();
    $time = strtotime($date[0]);
    $sub = time() - $time;
    if($sub<60){
        return 60 - $sub;
    }else{
        return 0;
    }
}
