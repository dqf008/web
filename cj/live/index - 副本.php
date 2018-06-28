<?php
  session_start();
  header('Content-Type:text/html; charset=utf-8');
  include __DIR__ . '/../../class/Db.class.php';//导入DB类
  include_once __DIR__ . "/../include/function.php";
  include_once __DIR__ . "/../../database/mysql.config.php";
  include_once __DIR__ . "/../../include/function_close_game.php";
  include_once __DIR__ . "/live_giro.php";
  $_REQUEST['type'] = strtoupper($_REQUEST['type']);
  if($_REQUEST['type'] == 'OG'){
    $_REQUEST['type'] = 'OG2';
  }
  if($_REQUEST['type'] == 'PT'){
    $_REQUEST['type'] = 'PT2';
  }
  if($_REQUEST['type'] == 'MG'){
    $_REQUEST['type'] = 'MG2';
  }
  if(!empty($_SESSION['uid'])){
    $str = typeName($_REQUEST['type']);
    $db = new DB();
    $userinfo = $db->row('select * from k_user where uid=:uid',['uid'=>$_SESSION['uid']]);
    $zr_money = $userinfo[$str['zzmoney']];
    $money = $userinfo['money'];
    $is_login = 1;
  }else{
    $is_login = 0;
  }

  if ($_POST['save'] == 'ok'){
    include_once '../../include/config.php';
    $data['status'] = '0';
    if(empty($_SESSION['uid'])){
      $data['err'] = '请先登录再操作！！';
      echo json_encode($data);
      exit;
    }
    if($userinfo['iszhuan']==1){
      $uid = $userinfo['uid'];
      $liveType = $_REQUEST['type'];
      $liveMoney = 'IN';
      $zz_money = abs(intval($_POST['zz_money']));
      if ($zz_money < $web_site['zh_low']){
        $data['err'] = '转账金额最低为：' . $web_site['zh_low'] . '元，请重新输入';
        echo json_encode($data);
        exit;
      }else if ($web_site['zh_high'] < $zz_money){
        $data['err'] = '转账金额最高为：' . $web_site['zh_high'] . '元，请重新输入';
        echo json_encode($data);
        exit;
      }

      //转帐
      if($liveType == 'MAYA'){
        $json = giro_MAYA($uid,$liveType,$liveMoney,$zz_money);
      }elseif($liveType == 'MW'){
        $json = giro_MW($uid,$liveType,$liveMoney,$zz_money);
      }elseif($liveType == 'KG'){
        $json = giro_KG($uid,$liveType,$liveMoney,$zz_money);
      }elseif($liveType == 'CQ9'){
        $json = giro_CQ9($uid,$liveType,$liveMoney,$zz_money);
      }elseif($liveType == 'MG2'){
        $json = giro_MG2($uid,$liveType,$liveMoney,$zz_money);
      }elseif($liveType == 'VR'){
        $json = giro_VR($uid,$liveType,$liveMoney,$zz_money);
      }elseif($liveType == 'BGLIVE'){
        $json = giro_BG($uid,$liveType,$liveMoney,$zz_money);
      }elseif(in_array($liveType, ['SB', 'RT', 'LAX'])){
        $json = giro_SB($uid,'SB',$liveMoney,$zz_money);
      }elseif($liveType == 'PT2'){
        $json = giro_PT2($uid,$liveType,$liveMoney,$zz_money);
      }elseif($liveType == 'OG2') {
        $json = giro_OG2($uid, $liveType, $liveMoney, $zz_money, $all);            
      }elseif($liveType == 'DG') {
        $json = giro_DG($uid, $liveType, $liveMoney, $zz_money, $all);            
      }elseif($liveType == 'KY') {
        $json = giro_KY($uid, $liveType, $liveMoney, $zz_money, $all);            
      }else{
        $json = giro($uid,$liveType,$liveMoney,$zz_money);
      }
      if($json == 'ok'){
        $data['status'] = '1';
        echo json_encode($data);
      }else{
        $data['err'] = $json;
        echo json_encode($data);
      }
    }else{
      $data['err'] = '您已被禁止转帐!!请联系客服!!';
      echo json_encode($data);
    }
    exit;
  }

  $type = strtoupper($_REQUEST['type']);
  $gameType = $_REQUEST['gameType'];
  game_is_close($type,$gameType);
  if($type=='MAYA'){
     $zzurl = "loginGameMAYA.php?callback=?";
     $gameName = '玛雅娱乐';
  }elseif($type=='MW'){
     $zzurl = "loginGameMW.php?callback=?&gameId=".$_REQUEST['id'];
     $gameName = 'MW电子';
  }elseif($type=='KG'){
     $zzurl = "loginGameKG.php?callback=?&gameId=".$_REQUEST['id'];
     $gameName = 'AV女优';
  }elseif($type=='CQ9'){
     $zzurl = "loginGameCQ9.php?callback=?&gameId=".$_REQUEST['id'];
     $gameName = 'CQ9电子';
  }elseif($type=='MG2'){
     $zzurl = "loginGameMG2.php?callback=?&gameId=".$_REQUEST['id'];
     $gameName = '新MG电子';
  }elseif($type=='VR'){
     $zzurl = "loginVR.php?callback=?&type=".$_REQUEST['id'];
     $gameName = 'VR彩票';
  }elseif($type=='BGLIVE'){
     $zzurl = "loginBG.php?callback=?&type=".$_REQUEST['id'];
     $gameName = 'BG视讯';
  }elseif($type=='SB'){
     $zzurl = "loginSB.php?callback=?&type=SB";
     $gameName = '申博视讯';
  }elseif($type=='RT'){
     $zzurl = "loginSB.php?callback=?&type=RT&gameId=".$_REQUEST['id'];
     $gameName = 'RT电子';
  }elseif($type=='LAX'){
     $zzurl = "loginSB.php?callback=?&type=LAX&gameId=".$_REQUEST['id'];
     $gameName = '勒思电子';
  }elseif($type=='PT2'){
     $zzurl = "loginPT.php?callback=?&gameId=".$_REQUEST['id'];
     $gameName = '新PT电子';
  }elseif($type=='OG2'){
     $zzurl = "loginOG.php?callback=?&gameId=".$_REQUEST['id'];
     $gameName = '新OG东方厅';
  }elseif($type=='DG'){
     $zzurl = "loginDG.php?callback=?";
     $gameName = 'DG视讯';
  }elseif($type=='KY'){
     $zzurl = "loginKY.php?callback=?&gameId=".$_REQUEST['id'];
     $gameName = '开元棋牌';
  }else{
    $str = typeName($type);
    $gameName = $str['title'];
    $zzurl = "loginGame.php?callback=?&type=$type&gameType=$gameType";
  }
  isset($_REQUEST['try'])&&$zzurl.= '&try=1';
  isset($_REQUEST['mobile'])&&$zzurl.= '&mobile=1';

?>
<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1"> 
  <meta charset="UTF-8">

  <title><?=$gameName?> 欢迎您的光临!!</title>
  <style>
html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed,
figure, figcaption, footer, header, hgroup,
menu, nav, output, ruby, section, summary,
time, mark, audio, video {
  margin: 0;
  padding: 0;
  border: 0;
  font-size: 100%;
  font: inherit;
  vertical-align: baseline;

}
/* HTML5 display-role reset for older browsers */
article, aside, details, figcaption, figure,
footer, header, hgroup, menu, nav, section {
  display: block;
}
body {
  line-height: 1;
  background: #111;
}
ol, ul {
  list-style: none;
}
blockquote, q {
  quotes: none;
}
blockquote:before, blockquote:after,
q:before, q:after {
  content: '';
  content: none;
}
table {
  border-collapse: collapse;
  border-spacing: 0;
}

canvas {
	background: #111;
	border: 1px solid #262522;
	display: block;
	/*left: 50%;
	margin: -51px 0 0 -201px;
	position: absolute;
	top: 50%;*/
  margin:0 auto;
}
#form {
  color:#FFF;
  width:410px;
  margin:0 auto;
  font-size:30px;
  display: none;
}
#form tr td {
  height:35px;
}
#form button {
  height:30px;
  font-size: 20px;
}
</style>
  <script src="js/prefixfree.min.js"></script>
  <script src="/js/jquery.js"></script>
  <script src="js/index.js?_=20171213"></script>
</head>
<body>
<form action="" id="game" method="post">
  <input type="hidden" name="VenderNo" id="no"/>
  <input type="hidden" name="DESDATA" id="des"/>
  <input type="hidden" name="EntryType" value="1" />
</form>
<div style="text-align:center;clear:both;color:#FFFFFF; margin-top:260px;font-size:25px;margin-bottom:20px" id="msg">
<h2>正在连接游戏服务器,请稍候...</h2></div>
<table id="form" >
  <tr>
    <td style="text-align:right;letter-spacing:5px;">主账户：</td><td><span id="money" style="color:yellow;font-size:30px;"></span></td>
  </tr>
  <tr>
    <td style="text-align:right;letter-spacing:5px;"><span id="name"></span>：</td><td><span id="zrmoney" style="color:yellow;font-size:30px;"></span></td>
  </tr>
  <tr>
    <td style="text-align:right;letter-spacing:5px;">转账额：</td><td><input id="zmoney" style="height:30px;font-size:25px;width:150px;font-weight: bold;" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,'');}).call(this)" onblur="this.v();"></td>
  </tr>
  <tr>
    <td colspan="2" style="text-align:center">
      <button onclick="transfer()">自动转账进入游戏</button>
      <button onclick="ignore()">忽略提示进入游戏</button>
    </td>
  </tr>
</table>
<script>
    var is_login = '<?=$is_login?>';
    var type = '<?=$type?>';
    var url = '<?=$zzurl?>';
    var zr_money = '<?=$zr_money?>';
    var money = '<?=$money?>';
    var game_name = '<?=$gameName?>';
    var is_try = '<?=isset($_REQUEST['try'])?"1":"0"?>';
    $(function(){
      if(is_try !='1' && is_login == 1 && zr_money < 10){
        $('#form').show();
        $("#msg h2").html('游戏账户余额不足');
        $('#money').html(money);
        $('#name').html(game_name);
        $('#zrmoney').html(zr_money);
        $('#zmoney').val(parseInt(money));
      }else{
        load();
        ToGame(url);
      }
    });
    function transfer(){
      var zmoney = $('#zmoney').val();
      $.post('/cj/live/index.php',{ 
          save: 'ok', 
          type: type,
          zz_money: zmoney
      }, 
      //回调函数
      function(res) 
      {
        if(res.status == 0){
          alert(res.err)
        }else{
          alert('转账成功');
           $('#form').hide();
          load();
          ToGame(url);
        }
      },
      "json"
      );
    }
    function ignore(){
        $('#form').hide();
        load();
        ToGame(url);
    }
    function ToGame(url){
      $.getJSON(url,function(json){
        if(json.info=="ok"){
            $("#msg h2").html('正在进入游戏...');
            if(type == 'MAYA'){
                $('#game').attr('action',json.url);
                $('#no').val(json.no);
                $('#des').val(json.des);
                $('#game').submit();
            }else{
              setTimeout(function(){
                location.href=json.msg;
              },3000);
            }
        }else{
          $("#msg h2").html(json.msg);
        }
      });
    }
</script>
</body>
</html>