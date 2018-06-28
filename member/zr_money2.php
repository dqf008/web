<?php
session_start();
include_once '../include/config.php';
website_close();
include_once '../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../common/logintu.php';
include_once '../class/user.php';
include_once '../common/function.php';
include_once '../cj/live/live_giro.php';
include_once("../include/function_close_game.php");
$uid = $_SESSION['uid'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($uid);
if (!$userinfo) {
    message('用户不存在！');
    exit();
}
$username = $userinfo['username'];
$userinfo = user::getinfo($uid);
if ($_GET['save'] == 'ok') {
    if ($userinfo['iszhuan'] == 1) {
        $liveType = $_POST['liveType'];
        $liveMoney = $_POST['liveMoney'];
        $zz_money = abs(intval($_POST['zz_money']));
        $all = $_POST['all'] == 1 ? true : false;
        if ($all && $zz_money == 0) {
            $zz_money = abs($userinfo['money']);
        } elseif ($all && $zz_money != 0) {
            $all = false;
        }
        if ($liveMoney == "IN") {
            if ($zz_money < $web_site['zh_low']) {
                message('转账金额最低为：' . $web_site['zh_low'] . '元，请重新输入');
                exit();
            } else if ($web_site['zh_high'] < $zz_money) {
                message('转账金额最高为：' . $web_site['zh_high'] . '元，请重新输入');
                exit();
            }
        }
        if ($liveMoney == 'IN') {
            $flag = money_change_game_is_close($liveType);
            if (!$flag) {
                message("{$liveType}系统维护中,暂停下注!!");
                exit();
            }
        }
        //echo $liveType;exit;
        //转帐        
        if ($liveType == 'MAYA') {
            $json = giro_MAYA($uid, $liveType, $liveMoney, $zz_money, $all);
        } elseif ($liveType == 'MW') {
            $json = giro_MW($uid, $liveType, $liveMoney, $zz_money, $all);
        } elseif ($liveType == 'KG') {
            $json = giro_KG($uid, $liveType, $liveMoney, $zz_money, $all);            
        }elseif ($liveType == 'CQ9') {
            $json = giro_CQ9($uid, $liveType, $liveMoney, $zz_money, $all);            
        } elseif ($liveType == 'MG2') {
            $json = giro_MG2($uid, $liveType, $liveMoney, $zz_money, $all);            
        } elseif ($liveType == 'VR') {
            $json = giro_VR($uid, $liveType, $liveMoney, $zz_money, $all);            
        } elseif ($liveType == 'BGLIVE') {
            $json = giro_BG($uid, $liveType, $liveMoney, $zz_money, $all);            
        } elseif ($liveType == 'SB') {
            $json = giro_SB($uid, $liveType, $liveMoney, $zz_money, $all);            
        } else {
            $json = giro($uid, $liveType, $liveMoney, $zz_money, $all);
        }     
        
        if ($json == 'ok') {
            if (!empty($_POST['all'])) {
                echo json_encode(['code' => 200]);
            } else {
                message('转帐成功!!', 'zr_data_money.php');
            }
            exit();
        } else {
            message($json);
            exit();
        }
    } else {
        if (!empty($_POST['all'])) {
            echo json_encode(['code' => 201, 'msg' => '您已被禁止转帐!!请联系客服!!']);
            exit;
        } else {
            message('您已被禁止转帐!!请联系客服!!');
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>额度转换</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
    <link type="text/css" rel="stylesheet" href="images/member.css"/>
    <script type="text/javascript" src="images/member.js"></script>
    <!--[if IE 6]>
    <script type="text/javascript" src="images/DD_belatedPNG.js"></script><![endif]-->
    <script>
        var $my = function (id) {
            return document.getElementById(id);
        }

        //数字验证 过滤非法字符
        function clearNoNum(obj) {
            obj.value = obj.value.replace(/[^\d.]/g, "");//先把非数字的都替换掉，除了数字和.
            obj.value = obj.value.replace(/^\./g, "");//必须保证第一个为数字而不是.
            obj.value = obj.value.replace(/\.{2,}/g, ".");//保证只有出现一个.而没有多个.
            obj.value = obj.value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");//保证.只出现一次，而不能出现两次以上
            if (obj.value != '') {
                var re = /^\d+\.{0,1}\d{0,2}$/;
                if (!re.test(obj.value)) {
                    obj.value = obj.value.substring(0, obj.value.length - 1);
                    return false;
                }
            }
        }

        function SubInfo() {
            var hk = $my('zz_money').value;
            if (hk == '') {
                alert('请输入转账金额');
                $my('zz_money').focus();
                return false;
            } else {
                hk = hk * 1;
                if (hk <<?=$web_site['zh_low']?>) {
                    alert('转账金额最低为：<?=$web_site['zh_low']?>元');
                    $my('zz_money').select();
                    return false;
                } else if (hk ><?=$web_site['zh_high']?>) {
                    alert('转账金额最高为：<?=$web_site['zh_high']?>元');
                    $my('zz_money').select();
                    return false;
                }
            }

            $my('SubTran').value = "转账处理中";
            $my('SubTran').disabled = "disabled";
            $my('form1').submit();
        }
    </script>
    <script type="text/javascript" src="../skin/js/jquery-1.7.2.min.js"></script>
    <script src="/js/jquery.js"></script>
    <script language="javascript">
        function reflivemoney_one() {
            $("[code] span").html('<img src="../Box/skins/icons/loading.gif" />');
            $.getJSON("../cj/live/live_money_db.php?v=2&callback=?", function (data) {
                if (data.info == 'ok') {
                    $.each(data.data,function(index, value, array){
                        $('[code='+index+'] span:first').html(value);
                    });
                } else {
                    $("[code] span").html(data.msg);
                }

            });
        }
        

        $(function () {
            $('td[code] span').click(function(){
                $(this).html('<img src="../Box/skins/icons/loading.gif" />');
                var code = $(this).parent().attr('code');
                var url = "/cj/live/live_money.php?callback=?&type=" + code;
                var _self = this;
                if(code == 'MW'){
                    url = '/cj/live/live_money_MW.php?callback=?';
                }else if(code == 'MAYA'){
                    url = '/cj/live/live_money_MAYA.php?callback=?';
                }else if(code == 'KG'){
                    url = '/cj/live/live_money_KG.php?callback=?';
                }else if(code == 'CQ9'){
                    url = '/cj/live/live_money_CQ9.php?callback=?';
                }else if(code == 'MG2'){
                    url = '/cj/live/live_money_MG2.php?callback=?';
                }else if(code == 'VR'){
                    url = '/cj/live/live_money_VR.php?callback=?';
                }else if(code == 'BGLIVE'){
                    url = '/cj/live/live_money_BG.php?callback=?';
                }else if(code == 'SB'){
                    url = '/cj/live/live_money_SB.php?callback=?';
                }
                $.getJSON(url, function (data) {
                    $(_self).html(data.msg);
                });
            });

            $('td[code] a').click(function(){
                var type = $(this).parent().attr('code');
                //var _self = this;
                $.post("?save=ok", {"liveMoney": "IN", "zz_money": "", "liveType": type, "all": 1}, function (res) {
                    res = $.parseJSON(res);
                    if (res.code == 200) {
                        alert('转帐成功');
                        window.location.reload();
                    } else if (res.code == 201) {
                        alert(res.msg);
                    } else {
                        alert('转帐失败');
                    }
                });
            });
            $('#recovery').click(function () {
                var list = $('[code]');
                $.ajaxSetup({   
		            async : false  
		        }); 
                list.each(function (index) {
                    var str = $(list[index]).find('span').html();
                    if(/^\d+\.\d\d$/.test(str) && str!='0.00'){
                        var code = $(list[index]).attr('code');
                        $.post("?save=ok", {"liveMoney": "OUT", "zz_money": "", "liveType": code, "all": 1});
                    }
                })
                alert('完成');window.location.reload();
            });

            reflivemoney_one();
        })

    </script>

    <style>
        #form1 a {
            border: 1px solid #B22222;
            display: inline-block;
            text-decoration: none;
            color: #B22222;
            padding:0px 5px;
            letter-spacing: 1px;
            transition: all 0.2s ease;
            box-sizing: border-box;
            text-shadow: 0 1px 0 rgba(0,0,0,0.01);
            cursor:pointer;
            margin: 0 5px;
            border-radius: 3px;
            font-size: 12px;
        }
        #form1 a:hover{
            color: #fff;
            background-color: #B22222;
        }
        #form1 a{
            cursor:pointer
        }
        td[code] {
            padding-right: 20px;
        }
        td[code] > span{
            cursor:pointer
        }
        td[code] > a{
            /*float:right;*/
        }
    </style>
</head>
<body>
<table width="960" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #FFF solid;">
    <?php
    include_once("mainmenu.php");
    ?>
    <tr>
        <td colspan="2" align="center" valign="middle">
            <?php
            include_once("moneymenu.php");
            ?>
            <div class="content">
                <table width="98%" border="0" cellspacing="0" cellpadding="5">
                    <tr>
                        <td height="20" align="center" bgcolor="#FAFAFA" class="hong"><strong>账户内部额度转账</strong></td>
                    </tr>
                    <tr>
                        <td align="left" bgcolor="#FFFFFF" style="line-height:18px;">
                            <form id="form1" name="form1" action="?save=ok" method="post">
                                <table width="100%" border="0" cellspacing="0" cellpadding="4">
                                        <tr>
                                            <td width="13%" align="right" bgcolor="#FAFAFA">用户账号：</td>
                                            <td align="left" colspan="5"><?= $userinfo['username']; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="right" bgcolor="#FAFAFA">体育/彩票：</td>
                                            <td align="left" colspan="5"><?= sprintf("%.2f", $userinfo['money']); ?>RMB
                                                <a id="recovery">一键回收</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right" bgcolor="#FAFAFA" width="13%">AG国际厅：</td>
                                            <td align="left" width="20%" code="AGIN">
                                                <span>0.00</span> &nbsp;
                                                <a>一键转入</a>
                                                <?php echo display_html_weihu('AGIN'); ?>
                                            </td>
                                            <td align="right" bgcolor="#FAFAFA" width="13%">AG极速厅：</td>
                                            <td align="left" width="20%" code="AG">
                                                <span>0.00</span> &nbsp;
                                                <a>一键转入</a>
                                                <?php echo display_html_weihu('AG'); ?></td>
                                            <td align="right" bgcolor="#FAFAFA">BB波音厅：</td>
                                            <td align="left" code="BBIN">
                                                <span>0.00</span> &nbsp;
                                                <a>一键转入</a>
                                                <?php echo display_html_weihu('BBIN'); ?></td>
                                        </tr>
                                        <tr>
                                            <td align="right" bgcolor="#FAFAFA">玛雅娱乐厅：</td>
                                            <td align="left" code="MAYA">
                                                <span>0.00</span> &nbsp;
                                                <a>一键转入</a>
                                                <?php echo display_html_weihu('MAYA'); ?></td>
                                            <td align="right" bgcolor="#FAFAFA">OG东方厅：</td>
                                            <td align="left" code="OG">
                                                <span>0.00</span> &nbsp;
                                                <a>一键转入</a>
                                                <?php echo display_html_weihu('OG'); ?></td>
                                            <td align="right" bgcolor="#FAFAFA">BG视讯(捕鱼)：</td>
                                            <td align="left" code="BGLIVE">
                                                <span>0.00</span> &nbsp;
                                                <a>一键转入</a>
                                            </td>
                                        </tr>
                                        <tr>   
                                            <td align="right" bgcolor="#FAFAFA">申博视讯(RT,LAX)</td>
                                            <td align="left" code="SB">
                                                <span>0.00</span> &nbsp;
                                                <a>一键转入</a>
                                            </td> 
                                            <td align="right" bgcolor="#FAFAFA">新MG电子：</td>
                                            <td align="left" code="MG2">
                                                <span>0.00</span> &nbsp;
                                                <a>一键转入</a>
                                            </td>
                                            <td align="right" bgcolor="#FAFAFA">PT电子：</td>
                                            <td align="left" code="PT">
                                                <span>0.00</span> &nbsp;
                                                <a>一键转入</a>
                                                <?php echo display_html_weihu('PT'); ?>
                                            </td>    
                                        </tr>
                                        <tr>
                                            <td align="right" bgcolor="#FAFAFA">MW电子：</td>
                                            <td align="left" code="MW">
                                                <span>0.00</span> &nbsp;
                                                <a>一键转入</a>
                                            </td>
                                            <td align="right" bgcolor="#FAFAFA">AV女优：</td>
                                            <td align="left" code="KG">
                                                <span>0.00</span> &nbsp;
                                                <a>一键转入</a></td>
											<td align="right" bgcolor="#FAFAFA">CQ9电子：</td>
                                            <td align="left" code="CQ9">
                                                <span>0.00</span> &nbsp;
                                                <a>一键转入</a>
                                            </td>
                                        </tr>
                                        <tr>          
                                            <td align="right" bgcolor="#FAFAFA">IPM体育：</td>
                                            <td align="left" code="IPM">
                                                <span>0.00</span> &nbsp;
                                                <a>一键转入</a>
                                                <?php echo display_html_weihu('IPM'); ?>
                                            </td>
                                            <td align="right" bgcolor="#FAFAFA">沙巴体育：</td>
                                            <td align="left" code="SHABA">
                                                <span>0.00</span> &nbsp;
                                                <a>一键转入</a>
                                            </td>                                  
                                            <td align="right" bgcolor="#FAFAFA">VR彩票：</td>
                                            <td align="left" code="VR">
                                                <span>0.00</span> &nbsp;
                                                <a>一键转入</a>
                                            </td>
											
                                        </tr>
                                        <!--tr>                                            
                                            <td align="right" bgcolor="#FAFAFA"></td>
                                            <td align="left">
                                                &nbsp;
                                            </td>
                                        </tr-->    
                                        <tr>
                                            <td align="right" bgcolor="#FAFAFA">转帐真人选择：</td>
                                            <td align="left" colspan="5">
                                                <input type="radio" name="liveType" value="AGIN" checked="checked">AG国际厅（XIN电子,BG电子,AG街机）
                                                <input type="radio" name="liveType" value="AG">AG极速厅&nbsp;
                                                <input type="radio" name="liveType" value="BBIN">BB波音厅&nbsp;
                                                <input type="radio" name="liveType" value="MAYA">玛雅娱乐厅&nbsp;
                                                <input type="radio" name="liveType" value="OG">OG东方厅&nbsp;
                                                <input type="radio" name="liveType" value="BGLIVE">BG视讯(捕鱼)<br/>
                                                <input type="radio" name="liveType" value="SB">申博视讯(RT,LAX)&nbsp;
                                                <input type="radio" name="liveType" value="MG2">新MG电子&nbsp;
                                                <input type="radio" name="liveType" value="PT">PT电子&nbsp;
                                                <input type="radio" name="liveType" value="MW">MW电子&nbsp;
                                                <input type="radio" name="liveType" value="KG">AV女优&nbsp;
                                                <input type="radio" name="liveType" value="CQ9">CQ9电子&nbsp;
                                                <input type="radio" name="liveType" value="IPM">IPM体育&nbsp;
                                                <input type="radio" name="liveType" value="SHABA">沙巴体育&nbsp;
                                                <input type="radio" name="liveType" value="VR">VR彩票&nbsp;
                                            </td>
                                        </tr>

                                        <tr>
                                            <td align="right" bgcolor="#FAFAFA">转帐类型：</td>
                                            <td align="left" colspan="5">
                                                <input type="radio" name="liveMoney" value="IN" checked="checked">转入&nbsp;&nbsp;
                                                <input type="radio" name="liveMoney" value="OUT">转出
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right" bgcolor="#FAFAFA">转账金额：</td>
                                            <td align="left" colspan="5">
                                            <input name="zz_money" class="input_150" id="zz_money"
                                                                                onkeyup="clearNoNum(this);" maxlength="10" />&nbsp;&nbsp;
                                            <span style="color:#FF0000" id='txtmoney'>* 注意：最低转帐金额：<?= $web_site['zh_low'] ?> RMB；最高转帐金额：<?= $web_site['zh_high'] ?> RMB</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right" bgcolor="#FAFAFA">&nbsp;</td>
                                            <td align="left" colspan="5">
                                                <input name="SubTran" type="button" class="submit_108" id="SubTran"
                                                       onclick="SubInfo();" value="确认转账"/></td>
                                        </tr>
                                    
                                </table>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>
</body>
</html>