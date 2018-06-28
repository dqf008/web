<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
$C_Patch = $_SERVER['DOCUMENT_ROOT'];
include_once $C_Patch.'/cj/include/function.php';
include_once $C_Patch.'/cj/class/cj.php';
include_once $C_Patch."/class/user.php";
include_once $C_Patch."/class/admin.php";

$callback = $_GET['callback'];
$uid = $_REQUEST['uid'];
$zrmoney = $_REQUEST['zrmoney'];
$moneyType = $_REQUEST['moneyType'];
$typeLive = $_REQUEST['zrtype'];
$typeGiro = $_REQUEST['typeGiro'];

if(isset($_SESSION['quanxian'])&&strpos($_SESSION['quanxian'], 'jkkk')){
  $client = new rpcclient($cj_url);
  if($typeLive=='MAYA'){
    $res = giro_MAYA($uid,$typeLive,$typeGiro,$zrmoney,$moneyType);
  }elseif($typeLive=='MW'){
    $res = giro_MW($uid,$typeLive,$typeGiro,$zrmoney,$moneyType);
  }elseif($typeLive=='KG'){
    $res = giro_KG($uid,$typeLive,$typeGiro,$zrmoney,$moneyType);
  }else{
    $res = giro($uid,$typeLive,$typeGiro,$zrmoney,$moneyType);
  }
}else{
  $res = '您没有权限操作该功能！';
}
$data['info']= $res;
echo $callback.'('.json_encode($data).')';
exit;

function giro($uid,$typeLive,$typeGiro,$zz_money,$moneyType=''){
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
  $zztime  = $str['zztime'];
  $giroName = '转入';
  $jiajian = '扣款';
  $transferAmount = -$zz_money;



  if($userinfo[$istype] != 1){//如果没有注册
    $arr = $client->livereg($site_id,$userinfo['username'],$typeLive);
    if(is_array($arr) and $arr){
      if($arr['info']=='ok'){
        $zzType = $arr['msg'][2];
        $zz_username = $arr['msg'][0];
        $zz_password = $arr['msg'][1];
        $par = zzType($zzType,$zz_username,$zz_password);
        $params = $par['params'];
        $params[':uid']=$userinfo['uid'];
        $sql = 'update  mydata1_db.k_user set '.$par['strsql'].' where '.$par['where'].' and uid=:uid';
        $stmt = $mydata1_db->prepare($sql);
        $stmt -> execute($params);
        $userinfo = user::getinfo($uid);
      }else{
        return '注册'.$typeName.'失败!!<br><br>'.$arr['info'][0].' => '.$arr['msg'][0];
      }
    }else{
      return '注册'.$typeName.'失败!!<br><br>请检查线路!!';
    }
  }

  //获取余额
  $arrUrl = $client->livebalance($site_id,$userinfo[$zzusername],$userinfo[$zzpassword],$typeLive);

  if(is_array($arrUrl) and $arrUrl){
    $out_money = 0;
    if($arrUrl['result'] == 'ok'){
      $out_money = $arrUrl['msg'];
      $zrmoney = $out_money;
    }else{
      return '获取'.$typeName.'余额失败!!';
    }

  }else{
    return '获取'.$typeName.'余额失败!!!';
  }

 if($typeGiro == 'IN'){//转入真人
    if($userinfo['money']<$zz_money and $moneyType != 'bd'){
      return '体育/彩票额度不足!!';
    }
    $giroName = '转入';
    $jiajian = '扣款';
    $transferAmount = -$zz_money;
  }else if($typeGiro == 'OUT'){//转出真人
    if($out_money < $zz_money){
      return $typeName.'额度不足!!';
    }
    $giroName = '转出';
    $jiajian = '加款';
    $transferAmount = $zz_money;
  }else{
    return '请选择转帐类型!!';
  }

  $billno = get_billno_live();
  //预备转帐
  $pre_json = $client -> prelivegiro($site_id,$userinfo[$zzusername],$userinfo[$zzpassword],$typeLive,$billno,$typeGiro,sprintf("%.2f",$zz_money));
  if(is_array($pre_json) and $pre_json){
      if($pre_json['result'] == 'ok' and $billno == $pre_json['msg']){//预备成功 且编号一致
        $billno = $pre_json['msg'];
        $userinfo = user::getinfo($uid);
        $moneyA = $userinfo['money'];
        if($typeGiro == 'IN' and $moneyType == 'ty'){//预备转入提前扣款 不是管理员补单 产生扣款
            $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zz_money2' => $zz_money,':zrmoney'=>$zrmoney);
            $sql = 'update k_user set money=money-:zz_money,'.$zzmoney.'=:zrmoney,'.$zztime.'=now() where uid=:uid and money>=:zz_money2';

            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            $q1 = $stmt->rowCount();
            if ($q1 <= 0){
                 return $typeName.'预备扣款失败!!请联系客服人员！';
            }
        }

        //写入日志
        if(($typeGiro == 'IN' and $moneyType == 'ty') or $typeGiro == 'OUT'){
          $userinfo = user::getinfo($uid);
          $moneyB = $userinfo['money'];
          $zz_time = date('Y-m-d H:i:s');
          $params = array(':live_type'=>$typeLive,':zz_type' => $typeGiro, ':uid' => $uid, ':username' => $userinfo['username'], ':zr_username' => $userinfo[$zzusername], ':zz_money' => $zz_money, ':zz_time' => $zz_time, ':billno' => $billno, ':moneyA' => $moneyA, ':moneyB' => $moneyB);
          
          $sql = 'insert into ag_zhenren_zz(live_type,zz_type,uid,username,zr_username,zz_money,ok,result,zz_num,zz_time,billno,moneyA,moneyB) values(:live_type,:zz_type,:uid,:username,:zr_username,:zz_money,0,\'[管理员]预备转账\',0,:zz_time,:billno,:moneyA,:moneyB)';
          $stmt = $mydata1_db->prepare($sql);
          $stmt->execute($params);
        }
          
        //正式转帐
        $userinfo = user::getinfo($uid);
        $money1 = $userinfo['money'];//转前余额
        $json = $client -> livegiro($site_id,$userinfo[$zzusername],$userinfo[$zzpassword],$typeLive,$billno,$typeGiro,sprintf("%.2f",$zz_money));
        if(is_array($json) and $json){
          if($json['result'] == 'ok' and $billno == $json['msg']){
            $billno = $json['msg'];
            $userinfo = user::getinfo($uid);
            
            if($typeGiro == 'IN' and $moneyType == 'ty'){//不是管理员补单 产生扣款
                $zrmoney = $out_money+$zz_money;//计算真人余额
                $params = array(':uid' => $uid,':zrmoney'=>$zrmoney);
                $sql = 'update k_user set '.$zzmoney.'=:zrmoney,'.$zztime.'=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0){
                  return $typeName.'扣款失败引起'.$giroName.'失败!!请联系客服人员！';
                }
            }else if($typeGiro == 'OUT'){
              $zrmoney = $out_money-$zz_money;//计算真人余额
              $params = array(':zz_money' => $zz_money, ':uid' => $uid,':zrmoney'=>$zrmoney);
              $sql = 'update k_user set money=money+:zz_money,'.$zzmoney.'=:zrmoney,'.$zztime.'=now() where uid=:uid';
              $stmt = $mydata1_db->prepare($sql);
              $stmt->execute($params);
              $q1 = $stmt->rowCount();
              if ($q1 <= 0){
                return $typeName.'扣款失败引起'.$giroName.'失败!!请联系客服人员！';
              }
            }

            if(($typeGiro == 'IN' and $moneyType == 'ty') or $typeGiro == 'OUT'){
              $userinfo = user::getinfo($uid);
              $moneyB = $userinfo['money'];
              $zz_time = date('Y-m-d H:i:s');
              
              //更新真人转账表 
              $mydata1_db->query($sql = 'update ag_zhenren_zz set ok=1,result=\'[管理员]转账成功\' where  billno = \''.$billno.'\'');
              
              $params = array(':uid' => $uid, ':userName' => $userinfo['username'], ':transferType' => $typeGiro, ':transferOrder' => $billno, ':transferAmount' => $transferAmount, ':previousAmount' => $moneyA, ':currentAmount' => $moneyB, ':creationTime' => $zz_time);
              $sql = 'INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) VALUE(:uid,:userName,\''.$typeLive.'LIVE\',:transferType,:transferOrder,:transferAmount,:previousAmount,:currentAmount,:creationTime)';
              $stmt = $mydata1_db->prepare($sql);
              $stmt->execute($params);
            }

            $about = '平台'.$giroName;
            if($moneyType=='bd'){
              $about = '平台补单';
            }
            admin::insert_log($_SESSION['adminid'], '对用户ID' . $uid . '的'.$typeLive.'平台'. $giroName. $zz_money . ',理由:' . $about);
            return 'ok';
          }else{
            if($typeGiro == 'IN' and $moneyType == 'ty'){
                //退还扣除的款项
                $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zz_money2' => $zz_money,':zrmoney'=>$zrmoney);
                $sql = 'update k_user set money=money+:zz_money,'.$zzmoney.'=:zrmoney,'.$zztime.'=now() where uid=:uid and money>=:zz_money2';

                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);          
            }

            //更新真人转账表 
            $mydata1_db->query($sql = 'update ag_zhenren_zz set ok=1,result=\'[管理员]转账失败\' where  billno = \''.$billno.'\'');
            return '转帐失败!!原因：'.$json['msg'].'!!';
          }
        }else{
          if($typeGiro == 'IN' and $moneyType == 'ty'){
              //退还扣除的款项
              $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zz_money2' => $zz_money,':zrmoney'=>$zrmoney);
              $sql = 'update k_user set money=money+:zz_money,'.$zzmoney.'=:zrmoney,'.$zztime.'=now() where uid=:uid and money>=:zz_money2';

              $stmt = $mydata1_db->prepare($sql);
              $stmt->execute($params);          
          }

          //更新真人转账表 
          $mydata1_db->query($sql = 'update ag_zhenren_zz set ok=1,result=\'[管理员]转账失败\' where  billno = \''.$billno.'\'');
        }

      }else{
        return '预备转账失败!!';
      }
  }else{
    return '请检查网络线路1!!';
  }
  

}

function giro_MW($uid,$typeLive,$typeGiro,$zz_money,$moneyType=''){
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
  $zztime  = $str['zztime'];
  $giroName = '转入';
  $jiajian = '扣款';
  $transferAmount = -$zz_money;



  if($userinfo[$istype] != 1){//如果没有注册
    $arr = $client->liveregmw($site_id,$userinfo['username']);
    if(is_array($arr) and $arr){
      if($arr['info']=='ok'){
        $params = array(':username'=>$userinfo['username'],':mwUserName'=>$arr['username'],':mwPassWord'=>$arr['password'],':uid'=>$uid);
        $sql = 'update  mydata1_db.k_user set mwUserName=:mwUserName,mwAddtime=now(),ismw=1,mwPassWord=:mwPassWord where ismw=0 and username = :username and uid=:uid';
        $stmt = $mydata1_db->prepare($sql);
        $stmt -> execute($params);

        $userinfo = user::getinfo($uid);
      }else{
        return '注册'.$typeName.'失败!!<br><br>'.$arr['msg'];
      }
    }else{
      return '注册'.$typeName.'失败!!<br><br>请检查线路!!';
    }
  }

  //获取余额
  $arrUrl = $client->livebalancemw($site_id,$userinfo['mwUserName'],$userinfo['mwPassWord']);

  if(is_array($arrUrl) and $arrUrl){
    $out_money = 0;
    if($arrUrl['info'] == 'ok'){
      $out_money = sprintf("%.2f",$arrUrl['money']);
      $zrmoney = $out_money;
    }else{
      return '获取'.$typeName.'余额失败!!'.$arrUrl['msg'];
    }

  }else{
    return '获取'.$typeName.'余额失败!!!';
  }

 if($typeGiro == 'IN'){//转入真人
    if($userinfo['money']<$zz_money and $moneyType != 'bd'){
      return '体育/彩票额度不足!!';
    }
    $giroName = '转入';
    $jiajian = '扣款';
    $transferAmount = -$zz_money;
    $transferType = 0;
  }else if($typeGiro == 'OUT'){//转出真人
    if($out_money < $zz_money){
      return $typeName.'额度不足!!';
    }
    $giroName = '转出';
    $jiajian = '加款';
    $transferAmount = $zz_money;
    $transferType = 1;
  }else{
    return '请选择转帐类型!!';
  }

  $billno = get_billno_live();
  //预备转帐
  $pre_json = $client -> livegiropremw($site_id,$userinfo['mwUserName'],$userinfo['mwPassWord'],$billno,$zz_money,$transferType);
  if(is_array($pre_json) and $pre_json){
      if($pre_json['info'] == 'ok' and $billno == $pre_json['billno']){//预备成功 且编号一致

        //MW转帐编号
        $asinTransferOrderNo = $pre_json['asinTransferOrderNo'];
        $asinTransferDate = $pre_json['asinTransferDate'];

        $billno = $pre_json['billno'];
        $userinfo = user::getinfo($uid);
        $moneyA = $userinfo['money'];
        if($typeGiro == 'IN' and $moneyType == 'ty'){//预备转入提前扣款
            $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zz_money2' => $zz_money,':zrmoney'=>$zrmoney);
            $sql = 'update k_user set money=money-:zz_money,'.$zzmoney.'=:zrmoney,'.$zztime.'=now() where uid=:uid and money>=:zz_money2';

            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            $q1 = $stmt->rowCount();
            if ($q1 <= 0){
                 return $typeName.'预备扣款失败!!请联系客服人员！';
            }
        }

        //写入日志
        if(($typeGiro == 'IN' and $moneyType == 'ty') or $typeGiro == 'OUT'){
          $userinfo = user::getinfo($uid);
          $moneyB = $userinfo['money'];
          $zz_time = date('Y-m-d H:i:s');
          $params = array(':live_type'=>$typeLive,':zz_type' => $typeGiro, ':uid' => $uid, ':username' => $userinfo['username'], ':zr_username' => $userinfo['mwUserName'], ':zz_money' => $zz_money, ':zz_time' => $zz_time, ':billno' => $billno, ':moneyA' => $moneyA, ':moneyB' => $moneyB);
          
          $sql = 'insert into ag_zhenren_zz(live_type,zz_type,uid,username,zr_username,zz_money,ok,result,zz_num,zz_time,billno,moneyA,moneyB) values(:live_type,:zz_type,:uid,:username,:zr_username,:zz_money,0,\'[管理员]预备转账\',0,:zz_time,:billno,:moneyA,:moneyB)';
          $stmt = $mydata1_db->prepare($sql);
          $stmt->execute($params);
        }
          
        //正式转帐
        $userinfo = user::getinfo($uid);
        $money1 = $userinfo['money'];//转前余额
        $json = $client -> livegiromw($site_id,$userinfo['mwUserName'],$userinfo['mwPassWord'],$billno,$zz_money,$asinTransferOrderNo,$asinTransferDate);
        if(is_array($json) and $json){
          if($json['info'] == 'ok' and $billno == $json['billno']){
            $billno = $json['billno'];
            $userinfo = user::getinfo($uid);
            
            if($typeGiro == 'IN' and $moneyType == 'ty'){//不是管理员补单 产生扣款
                $zrmoney = $out_money+$zz_money;//计算真人余额
                $params = array(':uid' => $uid,':zrmoney'=>$zrmoney);
                $sql = 'update k_user set '.$zzmoney.'=:zrmoney,'.$zztime.'=now() where uid=:uid';
                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);
                $q1 = $stmt->rowCount();
                if ($q1 <= 0){
                  return $typeName.'扣款失败引起'.$giroName.'失败!!请联系客服人员！';
                }
            }else if($typeGiro == 'OUT'){
              $zrmoney = $out_money-$zz_money;//计算真人余额
              $params = array(':zz_money' => $zz_money, ':uid' => $uid,':zrmoney'=>$zrmoney);
              $sql = 'update k_user set money=money+:zz_money,'.$zzmoney.'=:zrmoney,'.$zztime.'=now() where uid=:uid';
              $stmt = $mydata1_db->prepare($sql);
              $stmt->execute($params);
              $q1 = $stmt->rowCount();
              if ($q1 <= 0){
                return $typeName.'扣款失败引起'.$giroName.'失败!!请联系客服人员！';
              }
            }

            if(($typeGiro == 'IN' and $moneyType == 'ty') or $typeGiro == 'OUT'){
              $userinfo = user::getinfo($uid);
              $moneyB = $userinfo['money'];
              $zz_time = date('Y-m-d H:i:s');
              
              //更新真人转账表 
              $mydata1_db->query($sql = 'update ag_zhenren_zz set ok=1,result=\'[管理员]转账成功\' where  billno = \''.$billno.'\'');
              
              $params = array(':uid' => $uid, ':userName' => $userinfo['username'], ':transferType' => $typeGiro, ':transferOrder' => $billno, ':transferAmount' => $transferAmount, ':previousAmount' => $moneyA, ':currentAmount' => $moneyB, ':creationTime' => $zz_time);
              $sql = 'INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) VALUE(:uid,:userName,\''.$typeLive.'LIVE\',:transferType,:transferOrder,:transferAmount,:previousAmount,:currentAmount,:creationTime)';
              $stmt = $mydata1_db->prepare($sql);
              $stmt->execute($params);
            }

            $about = '平台'.$giroName;
            if($moneyType=='bd'){
              $about = '平台补单';
            }
            admin::insert_log($_SESSION['adminid'], '对用户ID' . $uid . '的'.$typeLive.'平台'. $giroName. $zz_money . ',理由:' . $about);
            return 'ok';
          }else{
            if($typeGiro == 'IN' and $moneyType == 'ty'){
                //退还扣除的款项
                $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zz_money2' => $zz_money,':zrmoney'=>$zrmoney);
                $sql = 'update k_user set money=money+:zz_money,'.$zzmoney.'=:zrmoney,'.$zztime.'=now() where uid=:uid and money>=:zz_money2';

                $stmt = $mydata1_db->prepare($sql);
                $stmt->execute($params);          
            }

            //更新真人转账表 
            $mydata1_db->query($sql = 'update ag_zhenren_zz set ok=1,result=\'[管理员]转账失败\' where  billno = \''.$billno.'\'');
            return '转帐失败!!原因：'.$json['msg'].'!!';
          }
        }else{
          if($typeGiro == 'IN' and $moneyType == 'ty'){
              //退还扣除的款项
              $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zz_money2' => $zz_money,':zrmoney'=>$zrmoney);
              $sql = 'update k_user set money=money+:zz_money,'.$zzmoney.'=:zrmoney,'.$zztime.'=now() where uid=:uid and money>=:zz_money2';

              $stmt = $mydata1_db->prepare($sql);
              $stmt->execute($params);          
          }

          //更新真人转账表 
          $mydata1_db->query($sql = 'update ag_zhenren_zz set ok=1,result=\'[管理员]转账失败\' where  billno = \''.$billno.'\'');
        }

      }else{
        return '预备转账失败!!'.$pre_json['msg'];
      }
  }else{
    return '请检查网络线路1!!';
  }


}

function giro_MAYA($uid,$typeLive,$typeGiro,$zz_money,$moneyType=''){
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
  $zztime  = $str['zztime'];
  $giroName = '转入';
  $jiajian = '扣款';
  $transferAmount = -$zz_money;


  if($userinfo[$istype] != 1){//如果没有注册
    $arr = $client->liveloginmaya($site_id,$userinfo['username']);
    if(is_array($arr) and $arr){
      if($arr['info']=='ok'){
        $params = array(':username'=>$userinfo['username'],':mayaUserName'=>$arr['username'],':mayaGameMemberID'=>$arr['GameMemberID'],':mayaVenderMemberID'=>$arr['VenderMemberID'],':uid'=>$uid);
        $sql = 'update  mydata1_db.k_user set mayaUserName=:mayaUserName,mayaGameMemberID=:mayaGameMemberID,mayaVenderMemberID=:mayaVenderMemberID,mayaAddtime=now(),ismaya=1 where ismaya=0 and username = :username and uid=:uid';
        $stmt = $mydata1_db->prepare($sql);
        $stmt -> execute($params);

        $userinfo = user::getinfo($uid);
      }else{
        $data['info'] = 'no';
        $data['msg']  = '注册'.$typeName.'失败!!<br><br>'.$arr['ErrorCode'];

        echo $callback.'('.json_encode($data).')';
        exit;
      }
    }else{
      $data['info'] = 'no';
      $data['msg']  = '注册'.$typeName.'失败!!<br><br>请检查线路!!';
      echo $callback.'('.json_encode($data).')';
      exit;
    } 
  }

  //获取余额
  $arrUrl = $client->livebalancemaya($site_id,$userinfo['mayaGameMemberID']);

  if(is_array($arrUrl) and $arrUrl){
    $out_money = 0;
    if($arrUrl['info'] == 'ok'){
      $out_money = $arrUrl['balance'];
    }else{
      return '获取'.$typeName.'余额失败!!'.$arrUrl['ErrorCode'];
    }

  }else{
    return '获取'.$typeName.'余额失败!!!';
  }

 if($typeGiro == 'IN'){//转入真人
    if($userinfo['money']<$zz_money  and $moneyType != 'bd'){
      return '体育/彩票额度不足!!';
    }
    $giroName = '转入';
    $jiajian = '扣款';
    $transferAmount = -$zz_money;
  }else if($typeGiro == 'OUT'){//转出真人
    

    if($out_money < $zz_money){
      return $typeName.'额度不足!!';
    }
    $giroName = '转出';
    $jiajian = '加款';
    $transferAmount = $zz_money;
  }else{
    return '请选择转帐类型!!';
  }

  $billno = get_billno_live();
  $json = $client -> livegiromaya($site_id,$userinfo['mayaGameMemberID'],sprintf("%.2f",$zz_money),strtolower($typeGiro),$billno);
  if(is_array($json) and $json){
    if($json['info'] == 'ok'){
      $billno = $json['msg'];
      $userinfo = user::getinfo($uid);
      $moneyA = $userinfo['money'];
      if($typeGiro == 'IN'){
        if($moneyType == 'ty'){//不是管理员补单 产生扣款
          $zrmoney = $out_money+$zz_money;//计算真人余额
          $params = array(':zz_money' => $zz_money, ':uid' => $uid, ':zz_money2' => $zz_money,':zrmoney'=>$zrmoney);
          $sql = 'update k_user set money=money-:zz_money,'.$zzmoney.'=:zrmoney,'.$zztime.'=now() where uid=:uid and money>=:zz_money2';
          $stmt = $mydata1_db->prepare($sql);
          $stmt->execute($params);
          $q1 = $stmt->rowCount();
          if ($q1 <= 0){
            return $typeName.'扣款失败引起'.$giroName.'失败!!请联系客服人员！';
          }
        }
        
      }else if($typeGiro == 'OUT'){
        $zrmoney = $out_money-$zz_money;//计算真人余额
        $params = array(':zz_money' => $zz_money, ':uid' => $uid,':zrmoney'=>$zrmoney);
        $sql = 'update k_user set money=money+:zz_money,'.$zzmoney.'=:zrmoney,'.$zztime.'=now() where uid=:uid';
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        $q1 = $stmt->rowCount();
        if ($q1 <= 0){
          return $typeName.'扣款失败引起'.$giroName.'失败!!请联系客服人员！';
        }
      }
     
      if(($typeGiro == 'IN' and $moneyType == 'ty') or $typeGiro == 'OUT'){
        $userinfo = user::getinfo($uid);
        $moneyB = $userinfo['money'];
        $zz_time = date('Y-m-d H:i:s');
        $params = array(':live_type'=>$typeLive,':zz_type' => $typeGiro, ':uid' => $uid, ':username' => $userinfo['username'], ':zr_username' => $userinfo[$zzusername], ':zz_money' => $zz_money, ':zz_time' => $zz_time, ':billno' => $billno, ':moneyA' => $moneyA, ':moneyB' => $moneyB);
        
        $sql = 'insert into ag_zhenren_zz(live_type,zz_type,uid,username,zr_username,zz_money,ok,result,zz_num,zz_time,billno,moneyA,moneyB) values(:live_type,:zz_type,:uid,:username,:zr_username,:zz_money,1,\'[管理员]转账成功\',0,:zz_time,:billno,:moneyA,:moneyB)';
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        $zzid = $mydata1_db->lastInsertId();
        
        $params = array(':uid' => $uid, ':userName' => $userinfo['username'], ':transferType' => $typeGiro, ':transferOrder' => $billno, ':transferAmount' => $transferAmount, ':previousAmount' => $moneyA, ':currentAmount' => $moneyB, ':creationTime' => $zz_time);
        $sql = 'INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) VALUE(:uid,:userName,\'AGLIVE\',:transferType,:transferOrder,:transferAmount,:previousAmount,:currentAmount,:creationTime)';
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
      }

      $about = '平台'.$giroName;
      if($moneyType=='bd'){
        $about = '平台补单';
      }
      admin::insert_log($_SESSION['adminid'], '对用户ID' . $uid . '的'.$typeLive.'平台'. $giroName. $zz_money . ',理由:' . $about);
      return 'ok';
    }else{
      return '转帐失败!!原因：'.$json['ErrorCode'].'!!';
    }
  }else{
    return '请检查网络线路!!';
  }

}

function get_billno_live(){
  return date('ymdHis') . substr(microtime(), 2, 3) . rand(1, 9);
}

function zrmoneyName($type){

}

?>