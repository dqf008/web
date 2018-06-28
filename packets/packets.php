<?php
!defined('IN_PACKETS')&&exit('Access Denied');
$stmt = $mydata1_db->query('SELECT * FROM `packets_config` WHERE `uid`=0');
if($stmt->rowCount()>0){
    $rows = $stmt->fetch();
    !($packets = unserialize($rows['value']))&&$packets = array();
}else{
    $packets = array();
}
if(!(isset($packets['open'])&&$packets['open']==1)){
    include(dirname(__FILE__).'/close.php');
    exit;
}
(!isset($packets['web_domain'])||empty($packets['web_domain']))&&$packets['web_domain'] = $_SERVER['HTTP_HOST'];
(!isset($packets['service_url'])||empty($packets['service_url']))&&$packets['service_url'] = 'javascript:alert(\'稍后提供\')';

$params = array(':code' => 'packets-content');
$stmt = $mydata1_db->prepare('SELECT * FROM `webinfo` WHERE `code`=:code');
$stmt->execute($params);
if($stmt->rowCount()>0){
    $rows = $stmt->fetch();
}else{
    $rows = array('content' => '');
    $params[':title'] = '红包活动详情';
    $params[':content'] = '';
    $stmt = $mydata1_db->prepare('INSERT INTO `webinfo` (`code`, `title`, `content`) VALUES (:code, :title, :content)');
    $stmt->execute($params);
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $web_site['web_title']; ?></title>
    <link href="<?php echo IN_PACKETS; ?>images/public.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">var PACKETS_URL = '<?php echo IN_PACKETS; ?>', IS_CLOSE = <?php echo $packets['closetime']>=time()?'false':'true'; ?>, TIME = new Date();</script>
    <script type="text/javascript" src="<?php echo IN_PACKETS; ?>javascript/jquery.js"></script>
    <script type="text/javascript" src="<?php echo IN_PACKETS; ?>javascript/snowfall.jquery.js"></script>
    <script type="text/javascript" src="<?php echo IN_PACKETS; ?>javascript/lottery.js"></script>
    <!-- <script type="text/javascript" src="<?php echo IN_PACKETS; ?>javascript/msclass.js"></script> -->
    <script type="text/javascript" src="<?php echo IN_PACKETS; ?>javascript/message.js"></script>
</head>
<body bgcolor="#C31F04">
    <div id="main">
        <div class="header_div">
            <div class="header_div_n">
                <div class="manu_div ml">
                    <a href="http://<?php echo $packets['web_domain']; ?>/" target="_blank">官网首页</a>
                    <a href="http://<?php echo $packets['web_domain']; ?>/?idx=70" target="_blank">会员注册</a>
                    <a href="javascript:;" onclick="$('#fade').show();$('#light').show().css('left',($(window).width()-589)/2);">红包查询</a>
                </div>
                <div class="manu_div mr">
                    <a href="http://<?php echo $packets['web_domain']; ?>/?idx=67" target="_blank">优惠活动</a>
                    <a href="http://<?php echo $packets['web_domain']; ?>/?idx=73" target="_blank">真人娱乐</a>
                    <a href="<?php echo $packets['service_url']; ?>" target="_blank">在线客服</a>
                </div>
            </div>
        </div>
        <div class="flash">
            <!-- 开始前 -->
            <div class="fond_div" id="hb_start" style="display:none;">
                <p class="tit">距离红包活动开始还有</p>
                <div class="time time2" id="luck_title">
                    <div>0</div>
                    <p>天</p>
                    <div>0</div>
                    <p>小时</p>
                    <div>0</div>
                    <p>分</p>
                    <div>0</div>
                    <p>秒</p>
                </div>
                <p class="tit" style="padding-top:20px"><?php echo $packets['web_domain']; ?></p>
            </div>
            <!-- 开始前 -->
            <!-- 等待中 -->
            <div class="fond_div" id="hb_wait" style="display:none;">
                <p class="tit">距离下轮开始还有</p>
                <div class="time" id="luck_title2" style="margin-top:20px">
                    <div>0</div>
                    <p>小时</p>
                    <div>0</div>
                    <p>分</p>
                    <div>0</div>
                    <p>秒</p>
                </div>
                <p class="tit" style="padding-top:20px">本轮已结束</p>
            </div>
            <!-- 等待中 -->
            <!-- 进行中 -->
            <div class="fond_div" id="hb_for" style="display:none;margin-top:475px">
                <p class="tit">距离本轮结束还有</p>
                <div class="time" id="luck_title3">
                    <div>0</div>
                    <p>小时</p>
                    <div>0</div>
                    <p>分</p>
                    <div>0</div>
                    <p>秒</p>
                </div>
                <input type="text" name="username" id="username" placeholder="请输入会员账号" />
                <a href="javascript:;" onclick="checkUser()" id="btnCheck"></a> 
            </div>
            <!-- 进行中 -->
            <!-- 结束后 -->
            <div class="fond_div" id="hb_end" style="display:none">
                <p class="tit" style="margin-top:25px">抢红包活动已结束</p>
                <p class="tit">感谢您的参与</p>
            </div>
            <!-- 结束后 -->
        </div>
        <div class="rbag" id="j-logn" style="display:none">
            <a href="javascript:;" class="close" data-key="lognClose"></a>
            <div class="cont">
                <p><input class="txt" type="text" name="username2" id="username2" placeholder="请输入会员账号" /></p>
                <button class="btn" type="button" onclick="$('#username').val($('#username2').val());$('#username2').val('');checkUser()" name="button2">立即领取</button>
            </div>
        </div>
        <div class="box0">
            <div id="marquee_rule" fixnum="2">
                <ul id="list_index"></ul>
            </div>
        </div>
        <div class="box1">
            <div class="wz" style="color:#fff"><?php echo stripcslashes($rows['content']); ?></div>    
        </div>
        <div class="foot">
            <p>选择<?php echo $web_site['web_name']; ?>，您将拥有可靠的资金保障和优质的服务<br />Copyright &copy; <?php echo date('Y').' '.$web_site['web_name']; ?> Reserved</p>      
        </div>
    </div>
    <!-- 浮动窗口 -->
    <div id="TplFloatPic_1" class="TplFloatSet" style="position:absolute;cursor:pointer;z-index:1000;top:150px;right:5px" picfloat="right">
        <a href="<?php echo $packets['service_url']; ?>" target="_blank" style="height:255px"><img src="<?php echo IN_PACKETS; ?>images/right_top.png" style="display:block"></a>
        <a href="javascript:;" onclick="FloatClose1(this)" style="height:24px"><img src="<?php echo IN_PACKETS; ?>images/right_bottom.png"></a>
    </div>
    <script type="text/javascript" src="<?php echo IN_PACKETS; ?>javascript/float.js"></script>
    <!-- 红包窗口 -->
    <div id="hongbao_back" class="hide" style="display:none;"></div>
    <div id="hongbao_open" class="popup flip" style="display:none;">
        <div class="popup-t">
            <a href="javascript:;" onclick="close_hongbao()" class="b1"><img src="<?php echo IN_PACKETS; ?>images/x.png"></a>
            <p class="b2"><img src="<?php echo IN_PACKETS; ?>../../static/images/packets_small.png"></p>
            <p class="b3"><?php echo $web_site['web_name']; ?></p>
            <p class="b4" style="display:none">&nbsp;&nbsp;</p>
            <p class="b5" id="b5">恭喜发财，大吉大利</p>
            <a href="javascript:;" onclick="startGame()" class="b6">拆红包</a>
        </div>
        <div class="popup-b"><?php echo $packets['web_domain']; ?></div>
    </div>
    <!-- 红包结果 -->
    <div id="hongbao_result" class="reward flip" style="display:none;background-color:#d20c06">
        <div class="reward-t">
            <a href="javascript:;" onclick="close_hongbao()" class="b1"><img src="<?php echo IN_PACKETS; ?>images/x.png"></a>
            <p class="b2"><img src="<?php echo IN_PACKETS; ?>../../static/images/packets_small.png"></p>
        </div>
        <div class="reward-b">
            <p class="w4"><?php echo $web_site['web_name']; ?></p>
            <p class="w3">0.00<em>元</em></p>
            <p class="w2">恭喜发财，大吉大利</p>
        </div>
    </div>
    <!-- 查询红包 -->
    <div id="light" class="white_content">
        <div class="cxbox">
            <div class="cxbox_bt">
                <p>输入会员账号查询</p>  
                <a href="javascript:;" style="color:#ffe681;text-decoration:none" onclick="$('#light').hide();$('#fade').hide()" class="gban">X</a>
            </div>
            <div class="cxbox_hy">
                <p>会员账号：</p>
                <input name="querycode" id="querycode" type="text" value="" placeholder="输入帐号">
                <a href="javascript:;" onclick="queryBtn()">查 询</a>
            </div>
            <div class="cxbox_bd" style="color:#ffe681;">
                <table width="480" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr class="ad">
                            <td>红包金额</td>
                            <td>领取时间</td>
                            <td>是否派彩</td>
                        </tr>
                    </tbody>
                    <tbody id="query_content"></tbody>
                </table>
                <div class="quotes" style="padding:10px 0px;"></div>
            </div>
        </div>
    </div>
    <div id="fade" class="black_overlay"></div>
    <!-- 活动公告 -->
    <div id="msg_win" style="display:none;top:503px;visibility:visible;opacity:1"> 
        <div class="icos">
            <a id="msg_min" title="最小化" href="javascript:;">_</a>
            <a id="msg_close" title="关闭" href="javascript:;">×</a>
        </div> 
        <div id="msg_title">活动公告：</div>
        <div id="msg_content"></div>
    </div>
</body>
</html>