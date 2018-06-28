<?php
include_once './_qxc.php';
if($trow&&$trow['fengpan']>=$l_time){
    $allmoney = 0;
    $count = 0;
    if(!$uid||!isset($_POST['type'])||!in_array($_POST['type'], array_keys($bet_type))){
        echo '<script type="text/javascript">alert("本页面禁止刷新！");window.history.back()</script>';
        exit;
    }
    if(!isset($_POST['money'])||empty($_POST['money'])||!preg_match('/^\d+$/', $_POST['money'])){
        echo '<script type="text/javascript">alert("请输入金额！");window.history.back()</script>';
        exit;
    }
    if(!isset($_POST['value'])||empty($_POST['value'])){
        echo '<script type="text/javascript">alert("请选择一个玩法！");window.history.back()</script>';
        exit;
    }
    $_POST['money'] = abs($_POST['money']);
    $userinfo = user::getinfo($uid);
    $order = array();
    foreach($_POST['value'] as $val){
        if($bet_num = checkBet($val, $bet_type[$_POST['type']])){
            $money = $_POST['money']*$bet_num;
            $allmoney+= $money;
            $count+= $bet_num;
            $order[] = array(
                ':mid' => $trow['qishu'],
                ':uid' => date('YmdHis').rand(1000, 9999),
                ':atype' => 'qxc',
                ':btype' => str_replace(array('一', '二', '三', '四'), '', $bet_type[$_POST['type']]),
                ':ctype' => $bet_num.'/'.$_POST['money'],
                ':dtype' => $bet_type[$_POST['type']],
                ':content' => $val,
                ':money' => $money,
                ':odds' => $odds[$bet_type[$_POST['type']]],
                ':win' => ($money*$odds[$bet_type[$_POST['type']]])-$money,
                ':username' => $userinfo['username'],
                ':agent' => $userinfo['agents'],
                ':bet_date' => date('Y-m-d'),
                ':bet_time' => date('Y-m-d H:i:s')
            );
        }else{
            echo '<script type="text/javascript">alert("非法投注！");window.history.back()</script>';
            exit;
        }
    }
    if($allmoney>0){
        $last_money = update_money($uid, $allmoney);
        if($last_money>0){
            foreach($order as $params){
                $stmt = $mydata1_db->prepare('INSERT INTO `lottery_data` (`mid`, `uid`, `atype`, `btype`, `ctype`, `dtype`, `content`, `money`, `odds`, `win`, `username`, `agent`, `bet_date`, `bet_time`) VALUES (:mid, :uid, :atype, :btype, :ctype, :dtype, :content, :money, :odds, :win, :username, :agent, :bet_date, :bet_time)');
                $stmt->execute($params);
                $last_id = $mydata1_db->lastInsertId();
                $stmt = $mydata1_db->prepare('INSERT INTO `k_money_log` (`uid`, `userName`, `gameType`, `transferType`, `transferOrder`, `transferAmount`, `previousAmount`, `currentAmount`, `creationTime`) VALUES (:uid, :userName, :gameType, :transferType, :transferOrder, :transferAmount, :previousAmount, :currentAmount, :creationTime)');
                $stmt->execute(array(
                    ':uid' => $uid,
                    ':userName' => $username,
                    ':gameType' => 'QXC',
                    ':transferType' => 'BET',
                    ':transferOrder' => 'm_'.$last_id,
                    ':transferAmount' => -1*$params[':money'],
                    ':previousAmount' => $last_money,
                    ':currentAmount' => $last_money-$params[':money'],
                    ':creationTime' => date('Y-m-d H:i:s'),
                ));
                $last_money-= $params[':money'];
            }
        }else{
            echo '<script type="text/javascript">alert("您的账户额度不足进行本次投注，请充值后在进行投注！");window.history.back()</script>';
            exit;
        }
    }
?>
<!DOCTYPE html> 
<html class="ui-mobile ui-mobile-viewport ui-overlay-a"> 
<head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
  <title><?=$web_site['web_title'];?></title> 
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"> 
  <meta content="yes" name="apple-mobile-web-app-capable"> 
  <meta content="black" name="apple-mobile-web-app-status-bar-style"> 
  <meta content="telephone=no" name="format-detection"> 
  <meta name="viewport" content="width=device-width"> 
  <link rel="shortcut icon" href="../images/favicon.ico"> 
  <link rel="stylesheet" href="../css/style.css"> 
  <link rel="stylesheet" href="../js/jquery.mobile-1.4.5.min.css"> 
  <script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script> 
  <script type="text/javascript" src="../js/jquery.mobile-1.4.5.min.js"></script> 
  <!--js判断横屏竖屏自动刷新--> 
  <script type="text/javascript" src="../js/top.js"></script> 
  <style type="text/css"> 
      ul, ol, li{  
          list-style-type:none;
      }  
      .xiazhu ul { 
          padding-top: 5px;
      }  
      .xiazhu     .biaodan li{  
          width: 20%;
          height: 28px;
          border-bottom:1px solid #DDD;
          text-align:     center;
          float:left;
      } 
      .xiazhu .biaodan1 li{ 
          width: 25%;
          height: 28px;
          border-bottom:1px solid #DDD;
          text-align: center;
          float:left;
      } 
  </style> 
</head> 
<body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" tabindex="0" style="min-height: 659px;"> 
  <input id="uid" name="uid" value="<?=$uid;?>" type="hidden"/> 
  <!--头部开始--> 
  <header id="header"> 
      <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" 
      aria-owns="popupPanel" aria-expanded="false"> 
      </a> 
      <span> 
          彩票游戏 
      </span> 
      <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"> 
      </a> 
  </header> 
  <div class="mrg_header"></div> 
  <!--头部结束--> 

  <!--功能列表--> 
  <section class="sliderWrap clearfix"> 
      <div data-role="header" style="overflow:hidden;" role="banner" class="ui-header ui-bar-inherit"> 
          <h1 class="ui-title" role="heading" aria-level="1"> 
              七星彩 
          </h1> 
      </div> 
  </section> 
  <section class="mContent" style="padding-left:0px;padding-right:0px;padding-top:5px;"> 
      <div data-role="tabs" id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all"> 
          <div id="three" class="ui-body-d ui-content" style="padding:0px;"> 
              <div style="clear:both;padding-bottom:5px;text-align:center;"> 
                    <p><b>下注成功！</b></p> 
              </div> 
              <div style="clear:both;padding-bottom:5px;text-align:center;"> 
                  <p> 
                      期号: 
                      <font color="#FF0000"><?=$trow['qishu'];?></font> 
                      &nbsp;&nbsp;总金额: 
                      <font color="#FF0000"><?=$allmoney;?></font> 
                      &nbsp;&nbsp;总单量: 
                      <font color="#FF0000"> 
                          <span id="zdnum"><?=$count;?></span> 
                      </font> 
                  </p> 
              </div> 
          <div style="clear:both;padding-top:10px;padding-left:10px;"> 
              <div style="clear:both;text-align:center;"> 
                  <a href="javascript:window.history.back();" class="ui-btn ui-btn-inline">继续下注</a> 
                  <a href="javascript:window.location.href='../index.php';" class="ui-btn ui-btn-inline">返回首页</a> 
              </div> 
          </div> 
      </div> 
  </section> 
  <!--底部开始--><?php include_once '../bottom.php';?>    <!--底部结束--> 
  <!--我的资料--><?php include_once '../member/myinfo.php';?>     
</body> 
</html>
<?php
}else{
    echo '<script type="text/javascript">alert("已经封盘，禁止下注！");window.history.back()</script>';
}
function checkBet($content, $type){
    $return = 0;
    switch($type){
        case '一定位':
        case '二定位':
        case '三定位':
        case '四定位':
            if(preg_match('/^(\d+|\*)\,(\d+|\*)\,(\d+|\*)\,(\d+|\*)$/', $content, $matches)){
                /* 判断是否存在重复数字 */
                foreach($matches as $key=>$val){
                    if($key==0||$val=='*'){
                        unset($matches[$key]);
                        continue;
                    }else{
                        $t = array_count_values(str_split($val));
                        if(max($t)>1){
                            $return = 0;
                            break 2;
                        }else{
                            $matches[$key] = strlen($val);
                        }
                    }
                }
                if($type=='一定位'){
                    $return = array_sum($matches);
                }else{
                    if(count($matches)==str_replace(array('二定位', '三定位', '四定位'), array(2, 3, 4), $type)){
                        $return = 1;
                        foreach($matches as $val){
                            $return*= $val;
                        }
                    }
                }
            }
        break;
        case '二字现':
        case '三字现':
            if(preg_match('/^\d+$/', $content)&&strlen($content)==str_replace(array('二字现', '三字现'), array(2, 3), $type)){
                $t = array_count_values(str_split($content));
                max($t)==1&&$return = 1;
            }
        break;
    }
    return $return;
}
function update_money($uid, $money){
    global $mydata1_db;
    $return = -1;
    $params = array(':uid' => $uid);
    $sql = 'SELECT `money` FROM `k_user` WHERE `uid`=:uid LIMIT 1';
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    if($stmt->rowCount()>0){
        $user = $stmt->fetch();
        if($user['money']-$money>=0){
            $params[':money'] = $money;
            $sql = 'UPDATE `k_user` SET `money`=`money`-:money WHERE `uid`=:uid';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params)&&$return = $user['money'];
        }
    }
    return $return;
}