<?php
    session_start();
    header('Content-Type:text/html; charset=utf-8');
    include __DIR__ . '/../../class/Db.class.php';//导入DB类
    include_once __DIR__ . "/../include/function.php";
    include_once __DIR__ . "/../../database/mysql.config.php";
    include_once __DIR__ . "/../../include/function_close_game.php";
    include_once __DIR__ . "/live_giro.php";
    $_REQUEST['type'] = strtoupper($_REQUEST['type']);
    if($_REQUEST['type'] == 'OG') $_REQUEST['type'] = 'OG2';
    if($_REQUEST['type'] == 'PT') $_REQUEST['type'] = 'PT2';
    if($_REQUEST['type'] == 'MG') $_REQUEST['type'] = 'MG2';
    $is_login = 0;
    
    if(!empty($_SESSION['uid'])){
        $str = typeName($_REQUEST['type']);
        $db = new DB();
        $userinfo = $db->row('select * from k_user where uid=:uid',['uid'=>$_SESSION['uid']]);
        $zr_money = $userinfo[$str['zzmoney']];
        $money = $userinfo['money'];
        $is_login = 1;
    }

    if($_GET['act'] == 'check'){
        $closeList = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/cache/game.close'), true);
        $game = trim($_GET['game']);
        if(is_array($closeList) && in_array($game,$closeList)){
            die('0');
        }
        die('1');
    }
    if ($_POST['save'] == 'ok'){
        include_once '../../include/config.php';
        $data['status'] = '0';
        if(empty($_SESSION['uid'])) die(json_encode(['err'=>'请先登录再操作！！']));
        if($userinfo['iszhuan'] !='1') die(json_encode(['err'=>'您已被禁止转帐!!请联系客服!!']));

        $uid = $userinfo['uid'];
        $liveType = $_REQUEST['type'];
        $liveMoney = 'IN';
        $zz_money = abs(intval($_POST['zz_money']));
        if ($zz_money < $web_site['zh_low']){
            die(json_encode(['err'=>'转账金额最低为：' . $web_site['zh_low'] . '元，请重新输入']));
        }else if ($web_site['zh_high'] < $zz_money){
            die(json_encode(['err'=>'转账金额最高为：' . $web_site['zh_high'] . '元，请重新输入']));
        }

        $act = 'giro';
        if(in_array($liveType,['MAYA','MW','KG','CQ9','MG2','VR','PT2','OG2','BBIN2','DG','KY','SB'])){
            $act = 'giro_'.$liveType;
        }else if($liveType == 'BGLIVE'){
            $act = 'giro_BG';
        }
        $json = $act($uid,$liveType,$liveMoney,$zz_money);

        if($json == 'ok'){
            $data['status'] = '1';
        }else{
            $data['err'] = $json;
        }
        die(json_encode($data));
    }

    $type = strtoupper($_REQUEST['type']);
    $gameType = $_REQUEST['gameType'];
    if($type=='MAYA'){
        $zzurl = "loginGameMAYA.php?callback=?";
        $gameName = '玛雅娱乐';
    }elseif($type=='OG2'){
        $zzurl = "loginOG.php?callback=?";
        $gameName = '新OG东方厅';
    }elseif($type=='DG'){
        $zzurl = "loginDG.php?callback=?";
        $gameName = 'DG视讯';
    }elseif($type=='VR'){
        $zzurl = "loginVR.php?callback=?";
        $gameName = 'VR彩票';
    }elseif($type=='BGLIVE'){
        $zzurl = "loginBG.php?callback=?";
        $gameName = 'BG视讯';
        if(!empty($_REQUEST['id']) && $_REQUEST['id'] == 'fish'){
            $zzurl .= '&type=fish';
            $gameName = 'BG捕鱼大师';
        }
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
    }elseif($type=='SB'){
        $zzurl = "loginSB.php?callback=?&type=SB";
        $gameName = '申博视讯';
    }elseif($type=='PT2'){
        $zzurl = "loginPT.php?callback=?&gameId=".$_REQUEST['id'];
        $gameName = '新PT电子';
    }elseif($type=='KY'){
        $zzurl = "loginKY.php?callback=?&gameId=".$_REQUEST['id'];
        $gameName = '开元棋牌';
    }elseif($type=='BBIN2'){
        $gameType || $gameType = 'game';
        $zzurl = 'loginBBIN.php?callback=?&type='.$gameType;
        if($gameType == 'game') $zzurl .= '&gameId='.$_REQUEST['id'];
        $gameName = '新BB波音厅';
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
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
    <meta charset="UTF-8">
    <title><?=$gameName?> 欢迎您的光临!!</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flat-ui/2.3.0/css/vendor/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flat-ui/2.3.0/css/flat-ui.min.css" />
    <style>
html,body {
  background-color: rgba(0, 0, 0, .7);
  height: 100%;
}
.form-control[readonly]{color:#34495e !important;}
#app {
    /*position: fixed;
    top: 0;
    left: 0;*/
    width: 100%;
    height: 100%;
}
#loader {
    display: block;
    position: relative;
    left: 50%;
    top: 50%;
    width: 150px;
    height: 150px;
    margin: -75px 0 0 -75px;
    border-radius: 50%;
    border: 3px solid transparent;
    border-top-color: #9370DB;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
}
#loader:before {
    content: "";
    position: absolute;
    top: 5px;
    left: 5px;
    right: 5px;
    bottom: 5px;
    border-radius: 50%;
    border: 3px solid transparent;
    border-top-color: #BA55D3;
    -webkit-animation: spin 3s linear infinite;
    animation: spin 3s linear infinite;
}
#loader:after {
    content: "";
    position: absolute;
    top: 15px;
    left: 15px;
    right: 15px;
    bottom: 15px;
    border-radius: 50%;
    border: 3px solid transparent;
    border-top-color: #FF00FF;
    -webkit-animation: spin 1.5s linear infinite;
    animation: spin 1.5s linear infinite;
}
@-webkit-keyframes spin {
    0%   {
        -webkit-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}
@keyframes spin {
    0%   {
        -webkit-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}
.transfer{
  color:#34495e;
  margin: 0 auto;
  max-width: 500px;
  margin-top:<?=empty($_REQUEST['mobile'])?'200px':'50px'?>;
  border:0;
  padding: 50px 40px;
  background-color: #FFF;
  /*box-shadow: 0 0 20px #fff;*/
  border-radius: 12px;
}
label{font-size: 16px;}
[v-cloak] {
        display: none !important
    }
  .col-sm-9,.col-sm-3{
    padding-left: 5px;
    padding-right: 5px;
  }


.alert {
    padding: 8px 35px 8px 14px;
    margin-bottom: 20px;
    text-shadow: 0 1px 0 rgba(255,255,255,0.5);
    background-color: #fcf8e3;
    border: 1px solid #fbeed5;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    width: 80%;
    margin: 50px auto;
} 
.alert, .alert h4 {
    color: #c09853;
} 
.alert-danger, .alert-error {
    color: #b94a48;
    background-color: #f2dede;
    border-color: #eed3d7;
}

.close {
    float: right;
    font-size: 20px;
    font-weight: bold;
    line-height: 20px;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    opacity: .2;
    filter: alpha(opacity=20);
}
button.close {
    padding: 0;
    cursor: pointer;
    background: transparent;
    border: 0;
    -webkit-appearance: none;
}

.alert .close {
    position: relative;
    top: -2px;
    right: -21px;
    line-height: 20px;
}
</style>

</head>
<body>
<div id="app" class="container">
  <div v-show="loding" id="loader"></div>
  <div v-cloak class="alert alert-error" v-show="err_msg != ''">
  <button type="button" class="close" data-dismiss="alert" onclick="window.close()">&times;</button>
    <strong>进入游戏失败：</strong><div v-html="err_msg"></div>
  </div>
  <form v-cloak class="transfer form-horizontal" v-show="! loding && err_msg == ''">
  <!--h1 class="text-center">{{ game_name }} 欢迎您的光临!!</h1-->
  <div class="form-group">
    <label class="col-sm-3 control-label">主账户:</label>
    <div class="col-sm-9">
      <input class="form-control" type="text" :value="money" readonly>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label" v-text="game_name+':'"></label>
    <div class="col-sm-9">
      <input class="form-control" type="text" :value="zr_money" readonly>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label">转账额:</label>
    <div class="col-sm-9">
      <input class="form-control" id="money" v-model="zmoney"  onkeyup="this.value=this.value.replace(/\D/g,'')" onblur="this.value=this.value.replace(/\D/g,'')" placeholder="转账额">
    </div>
  </div>
  <div class="form-group">
    <div class="/*col-sm-offset-3*/ col-sm-12 text-center">
        <button type="button" @click="transfer()" class="btn btn-primary <?=empty($_REQUEST['mobile'])?'':'btn-block'?>">自动转账进入游戏</button>&nbsp;&nbsp;
        <button type="button" @click="jump()" class="btn btn-default <?=empty($_REQUEST['mobile'])?'':'btn-block'?>">忽略提示进入游戏</button>
    </div>
  </div>
</form>
</div>
<form action="" id="game" method="post"></form>
<!--script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.16/vue.min.js"></script-->
<!--script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.js"></script-->
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js"></script>
<script>
    var mv = new Vue({
      el: '#app',
      data: {
        loding: true,
        is_login: '<?=$is_login?>',
        type: '<?=$type?>',
        game_url: '<?=$zzurl?>',
        zr_money: 0,
        money: '<?=$money?>',
        game_name: '<?=$gameName?>',
        game_type: '<?=$gameType?>',
        is_try: '<?=isset($_REQUEST['try'])?"1":"0"?>',
        zmoney: 0,
        err_msg: ''
      },
      methods: {
        init: function(){
          if(this.is_login == '1'){
            this.refresh_money();
          }else{
            if(this.is_try == '1'){
              this.jump();
            }else{
              alert('请先登录')
              window.close()
            }
          }
        },
        check_game: function(){
            var _self = this;
            $.get('?act=check&game='+this.type,function(res){
                console.log(res);
                if(res == '1'){
                    _self.init();
                }else{
                    alert(_self.game_name+'维护中')
                    window.close()
                }
            });
        },
        check_money: function(){
            if(this.zr_money < 10){
              this.loding = false;
              this.zmoney = Math.floor(this.money);
            }else{
              this.jump();
            }
        },
        refresh_money: function(){
          var _self = this;
          var type = this.type;
          var url = "/cj/live/live_money.php?callback=?&type=" + type;
          var list = ['MW','MAYA','KG','CQ9','MG2','VR','DG','KY','BGLIVE','PT2','OG2','SB','BBIN2'];
          if($.inArray(type,list) >= 0){
              switch(type){
                  case 'BGLIVE': type = 'BG';break;
                  case 'PT2': type = 'PT';break;
                  case 'OG2': type = 'OG';break;
                  case 'BBIN2': type = 'BBIN';break;
              }
              url = '/cj/live/live_money_'+type+'.php?callback=?';
          } 
          $.getJSON(url, function (data) {
            _self.zr_money = data.msg;
            _self.check_money();
          });
        },
        transfer: function(){
          this.loding = true;
          var _self = this;
          $.post('/cj/live/index.php',{save: 'ok',type: this.type,zz_money: this.zmoney}, function(res) {
            if(res.status == 0){
              alert(res.err)
            }else{
              _self.jump();
            }
          }, "json");
        },
        jump: function(){
            this.loding = true;
            var _self = this;
            $.getJSON(this.game_url, function(json){
            if(json.info=="ok"){
              if(_self.type == 'MAYA' || (_self.type == 'BBIN2' && _self.game_type != 'game')){
                  $('#game').attr('action',json.url);
                  $('#game').html(json.form);
                  $('#game').submit();
              }else{
                setTimeout(function(){
                  location.href=json.msg;
                },3000);
              }
            }else{
              _self.err_msg = json.msg
              _self.loding = false;
            }
          });
        }
      },
      created: function(){
        _self = this;
        setTimeout(function(){_self.check_game()},300);
      }
    });
</script>
</body>
</html>